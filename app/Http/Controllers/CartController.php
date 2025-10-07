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
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100'
        ], [
            'product_id.required' => 'Product ID is required',
            'product_id.integer' => 'Invalid product ID',
            'product_id.exists' => 'Product not found',
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be a number',
            'quantity.min' => 'Quantity must be at least 1',
            'quantity.max' => 'Quantity cannot exceed 100'
        ]);

        $userId = session('auth.user_id');
        $productId = (int) $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        // Get product details with proper error handling
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        if (!$product->is_available) {
            return response()->json(['success' => false, 'message' => 'Product is currently unavailable']);
        }

        // Check if quantity is available
        if ($quantity > $product->quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available. Only ' . $product->quantity . ' items in stock.']);
        }

        // Check current cart quantity to prevent exceeding stock
        $currentCartQuantity = Cart::where('user_id', $userId)
                                 ->where('product_id', $productId)
                                 ->sum('quantity');
        
        if (($currentCartQuantity + $quantity) > $product->quantity) {
            return response()->json(['success' => false, 'message' => 'Adding this quantity would exceed available stock.']);
        }

        try {
            // Add to cart
            Cart::addToCart($userId, $productId, $quantity, $product->price);

            // Get updated cart count
            $cartCount = Cart::where('user_id', $userId)->sum('quantity');

            // Log cart addition for analytics
            \Log::info('Item added to cart', [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);

            return response()->json(['success' => true, 'cart_count' => $cartCount]);
        } catch (\Exception $e) {
            \Log::error('Failed to add item to cart', [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['success' => false, 'message' => 'Failed to add item to cart. Please try again.']);
        }
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
            'product_id' => 'required|integer|exists:products,id'
        ], [
            'product_id.required' => 'Product ID is required',
            'product_id.integer' => 'Invalid product ID',
            'product_id.exists' => 'Product not found'
        ]);

        $userId = session('auth.user_id');
        $productId = (int) $request->input('product_id');

        try {
            $deleted = Cart::where('user_id', $userId)
                          ->where('product_id', $productId)
                          ->delete();

            if ($deleted) {
                $cartCount = Cart::where('user_id', $userId)->sum('quantity');
                
                // Log cart removal
                \Log::info('Item removed from cart', [
                    'user_id' => $userId,
                    'product_id' => $productId
                ]);
                
                return response()->json(['success' => true, 'cart_count' => $cartCount]);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found in cart']);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to remove item from cart', [
                'user_id' => $userId,
                'product_id' => $productId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['success' => false, 'message' => 'Failed to remove item from cart. Please try again.']);
        }
    }

    public function update(Request $request)
    {
        if (!session('auth.user_id')) {
            return response()->json(['success' => false, 'message' => 'Please log in']);
        }

        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1|max:100'
        ], [
            'product_id.required' => 'Product ID is required',
            'product_id.integer' => 'Invalid product ID',
            'product_id.exists' => 'Product not found',
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be a number',
            'quantity.min' => 'Quantity must be at least 1',
            'quantity.max' => 'Quantity cannot exceed 100'
        ]);

        $userId = session('auth.user_id');
        $productId = (int) $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        // Get product details to check stock
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }

        if (!$product->is_available) {
            return response()->json(['success' => false, 'message' => 'Product is currently unavailable']);
        }

        // Check if quantity exceeds available stock
        if ($quantity > $product->quantity) {
            return response()->json(['success' => false, 'message' => 'Not enough stock available. Only ' . $product->quantity . ' items in stock.']);
        }

        try {
            $cartItem = Cart::where('user_id', $userId)
                           ->where('product_id', $productId)
                           ->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
                
                $cartCount = Cart::where('user_id', $userId)->sum('quantity');
                
                // Log cart update
                \Log::info('Cart item updated', [
                    'user_id' => $userId,
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);

                return response()->json(['success' => true, 'cart_count' => $cartCount]);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found in cart']);
            }
        } catch (\Exception $e) {
            \Log::error('Failed to update cart item', [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'error' => $e->getMessage()
            ]);
            
            return response()->json(['success' => false, 'message' => 'Failed to update cart item. Please try again.']);
        }
    }
}
