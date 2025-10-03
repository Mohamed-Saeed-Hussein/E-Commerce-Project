<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Message;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        // Admin middleware will be applied via routes
    }

    public function dashboard()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $revenue = Order::whereIn('status', ['processing','shipped','delivered'])->sum('total_amount');
        $messageCount = Message::count();
        
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'productCount' => $productCount,
            'orderCount' => $orderCount,
            'revenue' => $revenue,
            'messageCount' => $messageCount,
        ]);
    }
}
