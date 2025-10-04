<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cart;
use App\Models\User;
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
            'fullName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'billingName' => 'nullable|string|max:255',
            'billingEmail' => 'nullable|email|max:255',
            'billingAddress' => 'nullable|string|max:255',
            'billingCity' => 'nullable|string|max:255',
            'billingPostalCode' => 'nullable|string|max:20',
            'billingCountry' => 'nullable|string|max:255',
            'billingPhone' => 'nullable|string|max:20',
        ]);

        $userId = session('auth.user_id');
        
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
                    \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
                }
            }
            
            return redirect('/orders')->with('success', 'Order placed successfully!');
        } else {
            return redirect('/cart')->with('error', 'Your cart is empty');
        }
    }
}
