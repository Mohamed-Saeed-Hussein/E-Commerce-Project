<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function catalog(Request $request)
    {
        $query = Product::where('is_available', true)->with('category');
        
        // Filter by category if specified
        if ($request->has('category') && $request->category !== 'all') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        } else {
            // When "All" is selected, randomize the order
            $query->inRandomOrder();
        }
        
        $products = $query->get();
        $categories = Category::orderBy('name')->get();
        
        return view('catalog', [
            'products' => $products, 
            'categories' => $categories,
            'selectedCategory' => $request->get('category', 'all')
        ]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        
        // Get similar products from the same category
        $similarProducts = Product::where('id', '!=', $id)
            ->where('is_available', true)
            ->where('category_id', $product->category_id)
            ->take(4)
            ->get();
            
        // If not enough products in the same category, fill with random products
        if ($similarProducts->count() < 4) {
            $additionalProducts = Product::where('id', '!=', $id)
                ->where('is_available', true)
                ->whereNotIn('id', $similarProducts->pluck('id'))
                ->take(4 - $similarProducts->count())
                ->get();
            $similarProducts = $similarProducts->merge($additionalProducts);
        }
        
        return view('product', ['product' => $product, 'similarProducts' => $similarProducts]);
    }
}
