<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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

    public function checkout(Request $request)
    {
        if (!session('auth.user_id')) {
            return redirect('/login');
        }

        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'billing_address' => 'required|string|max:255'
        ]);

        $userId = session('auth.user_id');
        $shippingAddress = $request->input('shipping_address');
        $billingAddress = $request->input('billing_address');

        $order = Order::createFromCart($userId, $shippingAddress, $billingAddress);

        if ($order) {
            return redirect('/orders')->with('success', 'Order placed successfully!');
        } else {
            return redirect('/cart')->with('error', 'Your cart is empty');
        }
    }
}
