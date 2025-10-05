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
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        Product::create($request->only([
            'name',
            'price',
            'description',
            'quantity',
            'is_available',
            'image',
            'category_id',
        ]));
        
        return redirect('/admin/products')->with('status', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', ['product' => $product]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'image' => 'nullable|url',
            'category_id' => 'nullable|exists:categories,id',
        ]);
        
        $product = Product::findOrFail($id);
        $product->update($request->only([
            'name',
            'price',
            'description',
            'quantity',
            'is_available',
            'image',
            'category_id',
        ]));
        
        return redirect('/admin/products')->with('status', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect('/admin/products')->with('status', 'Product deleted successfully!');
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
