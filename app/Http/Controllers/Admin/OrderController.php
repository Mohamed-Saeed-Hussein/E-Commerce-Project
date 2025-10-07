<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        // Admin middleware will be applied via routes
    }

    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at','desc')->get();
        return view('admin.orders', ['orders' => $orders]);
    }

    public function create()
    {
        $users = \App\Models\User::orderBy('name')->get();
        return view('admin.orders.create', ['users' => $users]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);

        $order = Order::create([
            'user_id' => $request->user_id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
        ]);

        return redirect('/admin/orders')->with('status', 'Order created successfully!');
    }

    public function edit($id)
    {
        $order = Order::with('user')->findOrFail($id);
        $users = \App\Models\User::orderBy('name')->get();
        return view('admin.orders.edit', ['order' => $order, 'users' => $users]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
        ]);

        $order = Order::findOrFail($id);
        $order->update([
            'user_id' => $request->user_id,
            'total_amount' => $request->total_amount,
            'status' => $request->status,
            'shipping_address' => $request->shipping_address,
            'billing_address' => $request->billing_address,
        ]);

        return redirect('/admin/orders')->with('status', 'Order updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect('/admin/orders')->with('status', 'Order deleted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order = Order::findOrFail($id);
        $order->updateStatus($request->input('status'));
        return back()->with('status', 'Order status updated');
    }
}
