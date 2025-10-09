<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Mail\OrderConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index()
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }
        
        $userId = session('auth.user_id');
        $orders = Order::with('items.product')
                      ->where('user_id', $userId)
                      ->orderBy('created_at', 'desc')
                      ->get();
        
        return view('orders', ['orders' => $orders]);
    }

    public function showCheckout()
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }

        $userId = session('auth.user_id');
        $cartItems = Cart::getCartItems($userId);

        return view('checkout', ['cartItems' => $cartItems]);
    }

    public function checkout(Request $request)
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }

        $request->validate([
            'fullName' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'postal_code' => 'required|string|max:20|regex:/^[a-zA-Z0-9\s-]+$/',
            'country' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'phone' => 'required|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'billingName' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'billingEmail' => 'nullable|email|max:255',
            'billingAddress' => 'nullable|string|max:500',
            'billingCity' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'billingPostalCode' => 'nullable|string|max:20|regex:/^[a-zA-Z0-9\s-]+$/',
            'billingCountry' => 'nullable|string|max:255|regex:/^[a-zA-Z\s]+$/',
            'billingPhone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
        ], [
            'fullName.required' => 'Full name is required',
            'fullName.regex' => 'Full name must contain only letters and spaces',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'address.required' => 'Address is required',
            'city.required' => 'City is required',
            'city.regex' => 'City must contain only letters and spaces',
            'postal_code.required' => 'Postal code is required',
            'postal_code.regex' => 'Invalid postal code format',
            'country.required' => 'Country is required',
            'country.regex' => 'Country must contain only letters and spaces',
            'phone.required' => 'Phone number is required',
            'phone.regex' => 'Invalid phone number format',
        ]);

        $userId = session('auth.user_id');
        
        // Verify cart has items
        $cartItems = Cart::getCartItems($userId);
        if ($cartItems->isEmpty()) {
            return redirect('/cart')->with('error', 'Your cart is empty');
        }

        // Double-check stock availability before processing order
        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if (!$product || !$product->is_available || $cartItem->quantity > $product->quantity) {
                return redirect('/cart')->with('error', 'Some items in your cart are no longer available. Please review your cart.');
            }
        }
        
        // Prepare shipping address
        $shippingAddress = $request->input('address');
        $shippingDetails = [
            'name' => $request->input('fullName'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'country' => $request->input('country'),
            'phone' => $request->input('phone'),
        ];

        // Prepare billing address
        $billingAddress = $request->input('billingAddress', $request->input('address'));
        $billingDetails = [
            'name' => $request->input('billingName', $request->input('fullName')),
            'email' => $request->input('billingEmail', $request->input('email')),
            'address' => $request->input('billingAddress', $request->input('address')),
            'city' => $request->input('billingCity', $request->input('city')),
            'postal_code' => $request->input('billingPostalCode', $request->input('postal_code')),
            'country' => $request->input('billingCountry', $request->input('country')),
            'phone' => $request->input('billingPhone', $request->input('phone')),
        ];

        try {
            $order = Order::createFromCart($userId, $shippingAddress, $billingAddress, $shippingDetails, $billingDetails);

            if ($order) {
                // Get the user details for email
                $user = User::find($userId);
                
                if ($user) {
                    // Load the order with items and products for email
                    $order->load('items.product');
                    
                    // Send order confirmation email
                    try {
                        Mail::to($user->email)->send(new OrderConfirmationMail($order, $user, $shippingDetails));
                    } catch (\Exception $e) {
                        // Log the error but don't fail the order
                        \Log::error('Failed to send order confirmation email', [
                            'order_id' => $order->id,
                            'user_id' => $userId,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
                
                // Log successful order
                \Log::info('Order created successfully', [
                    'order_id' => $order->id,
                    'user_id' => $userId,
                    'total_amount' => $order->total_amount,
                    'items_count' => $order->items->count()
                ]);
                
                return redirect('/orders')->with('success', 'Order placed successfully! You will receive a confirmation email shortly.');
            } else {
                return redirect('/cart')->with('error', 'Failed to process your order. Please try again.');
            }
        } catch (\Exception $e) {
            \Log::error('Order processing failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect('/cart')->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }
}
