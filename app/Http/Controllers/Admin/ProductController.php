<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        // Admin middleware will be applied via routes
    }

    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->get();
        return view('admin.products', ['products' => $products]);
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate(Product::validationRules(), [
            'name.required' => 'Product name is required',
            'name.min' => 'Product name must be at least 2 characters',
            'name.max' => 'Product name is too long',
            'price.required' => 'Price is required',
            'price.min' => 'Price must be at least 0',
            'price.max' => 'Price is too high',
            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 10 characters',
            'description.max' => 'Description is too long',
            'quantity.required' => 'Quantity is required',
            'quantity.min' => 'Quantity must be at least 0',
            'quantity.max' => 'Quantity is too high',
            'image.url' => 'Image must be a valid URL',
            'image.max' => 'Image URL is too long',
            'category_id.exists' => 'Selected category does not exist',
        ]);
        
        try {
            Product::create($request->only([
                'name',
                'price',
                'description',
                'quantity',
                'is_available',
                'image',
                'category_id',
            ]));
            
            \Log::info('Product created', [
                'admin_user_id' => session('auth.user_id'),
                'product_name' => $request->input('name'),
                'price' => $request->input('price')
            ]);
            
            return redirect('/admin/products')->with('status', 'Product created successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to create product', [
                'admin_user_id' => session('auth.user_id'),
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Failed to create product. Please try again.'])->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(Product::validationRules(), [
            'name.required' => 'Product name is required',
            'name.min' => 'Product name must be at least 2 characters',
            'name.max' => 'Product name is too long',
            'price.required' => 'Price is required',
            'price.min' => 'Price must be at least 0',
            'price.max' => 'Price is too high',
            'description.required' => 'Description is required',
            'description.min' => 'Description must be at least 10 characters',
            'description.max' => 'Description is too long',
            'quantity.required' => 'Quantity is required',
            'quantity.min' => 'Quantity must be at least 0',
            'quantity.max' => 'Quantity is too high',
            'image.url' => 'Image must be a valid URL',
            'image.max' => 'Image URL is too long',
            'category_id.exists' => 'Selected category does not exist',
        ]);
        
        try {
            $product = Product::findOrFail($id);
            $oldData = $product->toArray();
            
            $product->update($request->only([
                'name',
                'price',
                'description',
                'quantity',
                'is_available',
                'image',
                'category_id',
            ]));
            
            \Log::info('Product updated', [
                'admin_user_id' => session('auth.user_id'),
                'product_id' => $id,
                'old_data' => $oldData,
                'new_data' => $product->toArray()
            ]);
            
            return redirect('/admin/products')->with('status', 'Product updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to update product', [
                'admin_user_id' => session('auth.user_id'),
                'product_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Failed to update product. Please try again.'])->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            $productData = $product->toArray();
            
            // Check if product has orders
            $hasOrders = $product->orderItems()->exists();
            if ($hasOrders) {
                return redirect('/admin/products')->with('error', 'Cannot delete product that has been ordered. Consider marking it as unavailable instead.');
            }
            
            $product->delete();
            
            \Log::info('Product deleted', [
                'admin_user_id' => session('auth.user_id'),
                'product_id' => $id,
                'product_data' => $productData
            ]);
            
            return redirect('/admin/products')->with('status', 'Product deleted successfully!');
        } catch (\Exception $e) {
            \Log::error('Failed to delete product', [
                'admin_user_id' => session('auth.user_id'),
                'product_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return redirect('/admin/products')->with('error', 'Failed to delete product. Please try again.');
        }
    }

    public function importProducts()
    {
        $basePath = public_path('images/products');
        if (!File::exists($basePath)) {
            return back()->with('status', 'No products directory found at /public/images/products');
        }

        $imported = 0;
        $updated = 0;

        $imageExtensions = ['jpg','jpeg','png','gif','webp'];

        // Helper to process a single image file
        $processImage = function ($relativeDir, $filename) use (&$imported, &$updated, $imageExtensions) {
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($ext, $imageExtensions)) return;

            $categoryName = trim($relativeDir, DIRECTORY_SEPARATOR);
            $categoryName = $categoryName === '' ? null : str_replace(['-', '_'], ' ', $categoryName);

            $categoryId = null;
            if ($categoryName) {
                $category = Category::firstOrCreate(
                    ['name' => $categoryName],
                    ['slug' => Str::slug($categoryName)]
                );
                $categoryId = $category->id;
            }

            $basename = pathinfo($filename, PATHINFO_FILENAME);
            $productName = ucwords(str_replace(['-', '_'], ' ', $basename));
            $imageUrl = '/images/products' . ($relativeDir ? '/' . trim(str_replace('\\', '/', $relativeDir), '/') : '') . '/' . $filename;

            $existing = Product::where('image', $imageUrl)->first();

            if ($existing) {
                $existing->update([
                    'name' => $existing->name ?: $productName,
                    'category_id' => $categoryId,
                ]);
                $updated++;
            } else {
                Product::create([
                    'name' => $productName,
                    'price' => 0,
                    'description' => 'Imported product',
                    'quantity' => 0,
                    'is_available' => true,
                    'image' => $imageUrl,
                    'category_id' => $categoryId,
                ]);
                $imported++;
            }
        };

        // Walk through subdirectories
        $dirs = File::directories($basePath);
        // Also include base directory as a category-less import
        $dirs = array_merge([$basePath], $dirs);

        foreach ($dirs as $dir) {
            $relativeDir = trim(str_replace($basePath, '', $dir), DIRECTORY_SEPARATOR);
            foreach (File::files($dir) as $file) {
                $processImage($relativeDir, $file->getFilename());
            }
        }

        return back()->with('status', "Imported: {$imported}, Updated: {$updated}");
    }
}
