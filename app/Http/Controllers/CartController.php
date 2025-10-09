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

        // For authenticated users: check their cart; for guests: check session cart
        $currentCartQuantity = 0;
        if ($userId) {
            $currentCartQuantity = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->sum('quantity');
        } else {
            $guestCart = session('guest_cart', []);
            foreach ($guestCart as $item) {
                if ((int)($item['product_id'] ?? 0) === $productId) {
                    $currentCartQuantity += (int)($item['quantity'] ?? 0);
                }
            }
        }

        if (($currentCartQuantity + $quantity) > $product->quantity) {
            return response()->json(['success' => false, 'message' => 'Adding this quantity would exceed available stock.']);
        }

        try {
            \DB::transaction(function () use ($userId, $product, $productId, $quantity) {
                // Decrease stock immediately
                $affected = Product::where('id', $productId)
                    ->where('quantity', '>=', $quantity)
                    ->decrement('quantity', $quantity);

                if ($affected === 0) {
                    throw new \RuntimeException('Insufficient stock');
                }

                // If stock hits zero, mark unavailable
                $fresh = Product::find($productId);
                if ($fresh && $fresh->quantity <= 0 && $fresh->is_available) {
                    $fresh->is_available = 0;
                    $fresh->save();
                }

                if ($userId) {
                    Cart::addToCart($userId, $productId, $quantity, $product->price);
                } else {
                    // Guest cart in session
                    $guestCart = session('guest_cart', []);
                    $found = false;
                    foreach ($guestCart as &$item) {
                        if ((int)$item['product_id'] === $productId) {
                            $item['quantity'] += $quantity;
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        $guestCart[] = [
                            'product_id' => $productId,
                            'quantity' => $quantity,
                            'price' => $product->price,
                        ];
                    }
                    session(['guest_cart' => $guestCart]);
                }
            });

            // Get updated cart count and remaining stock
            if ($userId) {
                $cartCount = Cart::where('user_id', $userId)->sum('quantity');
            } else {
                $cartCount = array_reduce(session('guest_cart', []), function ($sum, $it) { return $sum + (int)($it['quantity'] ?? 0); }, 0);
            }
            $remaining = Product::find($productId)?->quantity ?? 0;

            \Log::info('Item added to cart', [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price
            ]);

            return response()->json(['success' => true, 'cart_count' => $cartCount, 'remaining_stock' => $remaining]);
        } catch (\Throwable $e) {
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
        $userId = session('auth.user_id');
        if ($userId) {
            $count = Cart::where('user_id', $userId)->sum('quantity');
            return response()->json(['success' => true, 'count' => $count]);
        }
        $count = array_reduce(session('guest_cart', []), function ($sum, $it) { return $sum + (int)($it['quantity'] ?? 0); }, 0);
        return response()->json(['success' => true, 'count' => $count]);
    }

    public function remove(Request $request)
    {
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
            \DB::transaction(function () use ($userId, $productId) {
                $qty = 0;
                if ($userId) {
                    $cartItem = Cart::where('user_id', $userId)->where('product_id', $productId)->first();
                    if ($cartItem) {
                        $qty = (int)$cartItem->quantity;
                        $cartItem->delete();
                    }
                } else {
                    $guestCart = session('guest_cart', []);
                    foreach ($guestCart as $idx => $item) {
                        if ((int)$item['product_id'] === $productId) {
                            $qty = (int)($item['quantity'] ?? 0);
                            unset($guestCart[$idx]);
                            break;
                        }
                    }
                    session(['guest_cart' => array_values($guestCart)]);
                }

                if ($qty > 0) {
                    Product::where('id', $productId)->increment('quantity', $qty);
                    $fresh = Product::find($productId);
                    if ($fresh && $fresh->quantity > 0 && !$fresh->is_available) {
                        $fresh->is_available = 1;
                        $fresh->save();
                    }
                }
            });

            $cartCount = $userId
                ? Cart::where('user_id', $userId)->sum('quantity')
                : array_reduce(session('guest_cart', []), function ($sum, $it) { return $sum + (int)($it['quantity'] ?? 0); }, 0);

            \Log::info('Item removed from cart', [
                'user_id' => $userId,
                'product_id' => $productId
            ]);

            return response()->json(['success' => true, 'cart_count' => $cartCount]);
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

        try {
            \DB::transaction(function () use ($userId, $productId, $quantity) {
                if ($userId) {
                    $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->first();
                    if (!$cartItem) {
                        throw new \RuntimeException('Item not found in cart');
                    }
                    $delta = $quantity - (int)$cartItem->quantity;
                    if ($delta > 0) {
                        // Increase requested: ensure stock then decrement
                        $affected = Product::where('id', $productId)->where('quantity', '>=', $delta)->decrement('quantity', $delta);
                        if ($affected === 0) {
                            throw new \RuntimeException('Not enough stock available');
                        }
                    } elseif ($delta < 0) {
                        // Decrease requested: return stock
                        Product::where('id', $productId)->increment('quantity', abs($delta));
                    }
                    $cartItem->quantity = $quantity;
                    $cartItem->save();
                } else {
                    $guestCart = session('guest_cart', []);
                    $found = false;
                    foreach ($guestCart as &$item) {
                        if ((int)$item['product_id'] === $productId) {
                            $delta = $quantity - (int)$item['quantity'];
                            if ($delta > 0) {
                                $affected = Product::where('id', $productId)->where('quantity', '>=', $delta)->decrement('quantity', $delta);
                                if ($affected === 0) {
                                    throw new \RuntimeException('Not enough stock available');
                                }
                            } elseif ($delta < 0) {
                                Product::where('id', $productId)->increment('quantity', abs($delta));
                            }
                            $item['quantity'] = $quantity;
                            $found = true;
                            break;
                        }
                    }
                    if (!$found) {
                        throw new \RuntimeException('Item not found in cart');
                    }
                    session(['guest_cart' => $guestCart]);
                }

                $fresh = Product::find($productId);
                if ($fresh) {
                    if ($fresh->quantity <= 0 && $fresh->is_available) { $fresh->is_available = 0; $fresh->save(); }
                    if ($fresh->quantity > 0 && !$fresh->is_available) { $fresh->is_available = 1; $fresh->save(); }
                }
            });

            $cartCount = $userId
                ? Cart::where('user_id', $userId)->sum('quantity')
                : array_reduce(session('guest_cart', []), function ($sum, $it) { return $sum + (int)($it['quantity'] ?? 0); }, 0);

            \Log::info('Cart item updated', [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);

            return response()->json(['success' => true, 'cart_count' => $cartCount]);
        } catch (\Throwable $e) {
            \Log::error('Failed to update cart item', [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'error' => $e->getMessage()
            ]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
