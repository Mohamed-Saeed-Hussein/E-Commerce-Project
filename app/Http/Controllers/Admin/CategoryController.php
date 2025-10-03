<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Admin middleware will be applied via routes
    }

    public function index()
    {
        return view('admin.categories');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);
        
        Category::create([
            'name' => $request->input('name'),
            'slug' => strtolower(str_replace(' ', '-', $request->input('name'))),
        ]);
        
        return back()->with('status', 'Category added successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        
        return back()->with('status', 'Category deleted successfully!');
    }

    public function importCategoryImages()
    {
        $basePath = public_path('images/products');
        if (!File::exists($basePath)) {
            return back()->with('status', 'No products directory found at /public/images/products');
        }

        $imageExtensions = ['jpg','jpeg','png','gif','webp'];
        $updated = 0;

        foreach (File::directories($basePath) as $dir) {
            $relative = trim(str_replace($basePath, '', $dir), DIRECTORY_SEPARATOR);
            if ($relative === '') continue;
            $categoryName = str_replace(['-', '_'], ' ', $relative);
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            $files = collect(File::files($dir))
                ->filter(fn($f) => in_array(strtolower($f->getExtension()), $imageExtensions))
                ->values();

            if ($files->count() > 0) {
                $file = $files->first();
                $imageUrl = '/images/products/' . $relative . '/' . $file->getFilename();
                if ($category->image !== $imageUrl) {
                    $category->image = $imageUrl;
                    $category->save();
                    $updated++;
                }
            }
        }

        return back()->with('status', "Category images updated: {$updated}");
    }
}
