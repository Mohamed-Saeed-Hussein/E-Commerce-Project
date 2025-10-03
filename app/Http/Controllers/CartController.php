<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }

        $userId = session('auth.user_id');
        $cartItems = Cart::getCartItems($userId);

        return view('cart', ['cartItems' => $cartItems]);
    }

    public function add(Request $request)
    {
        if (!session('auth.user_id')) {
            return response()->json(['success' => false, 'message' => 'Please log in to add items to cart']);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = session('auth.user_id');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Get product details
        $product = Product::find($productId);
        if (!$product || !$product->is_available) {
            return response()->json(['success' => false, 'message' => 'Product not available']);
        }

        // Check if quantity is available
        if ($quantity > $product->quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available']);
        }

        // Add to cart
        Cart::addToCart($userId, $productId, $quantity, $product->price);

        // Get updated cart count
        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }

    public function count()
    {
        if (!session('auth.user_id')) {
            return response()->json(['success' => false, 'count' => 0]);
        }

        $userId = session('auth.user_id');
        $count = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json(['success' => true, 'count' => $count]);
    }

    public function remove(Request $request)
    {
        if (!session('auth.user_id')) {
            return response()->json(['success' => false, 'message' => 'Please log in']);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = session('auth.user_id');
        $productId = $request->input('product_id');

        Cart::where('user_id', $userId)
           ->where('product_id', $productId)
           ->delete();

        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }

    public function update(Request $request)
    {
        if (!session('auth.user_id')) {
            return response()->json(['success' => false, 'message' => 'Please log in']);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $userId = session('auth.user_id');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cartItem = Cart::where('user_id', $userId)
                       ->where('product_id', $productId)
                       ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        $cartCount = Cart::where('user_id', $userId)->sum('quantity');

        return response()->json(['success' => true, 'cart_count' => $cartCount]);
    }
}
