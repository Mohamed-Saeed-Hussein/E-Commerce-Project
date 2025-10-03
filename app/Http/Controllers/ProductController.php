<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function catalog()
    {
        $products = Product::where('is_available', true)->get();
        $categories = Category::orderBy('name')->get();
        return view('catalog', ['products' => $products, 'categories' => $categories]);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $similarProducts = Product::where('id', '!=', $id)
            ->where('is_available', true)
            ->take(4)
            ->get();
        return view('product', ['product' => $product, 'similarProducts' => $similarProducts]);
    }
}
