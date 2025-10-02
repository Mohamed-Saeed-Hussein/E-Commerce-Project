@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 scroll-animate">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">My Orders</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Track and manage your order history</p>
        </div>

        <!-- Orders List -->
        <div class="space-y-6">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 scroll-animate hover:shadow-lg transition-shadow duration-300">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Order #{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($order->status === 'shipped') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                            @elseif($order->status === 'delivered') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Amount</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Items</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->items->count() }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Order Date</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Items:</h4>
                        <div class="space-y-1">
                            @foreach($order->items as $item)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-600 dark:text-gray-400">{{ $item->product_name }} x{{ $item->quantity }}</span>
                                <span class="text-gray-900 dark:text-white">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-sm">
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Shipping Address</h5>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->shipping_address }}</p>
                        </div>
                        <div>
                            <h5 class="font-medium text-gray-900 dark:text-white">Billing Address</h5>
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->billing_address }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex space-x-4">
                            <button class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium transition-colors duration-200">
                                View Details
                            </button>
                            @if($order->status === 'pending')
                            <button class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 font-medium transition-colors duration-200">
                                Cancel Order
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- Empty State (when no orders) -->
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center scroll-animate">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No orders yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Get started by making your first purchase.</p>
                    <a href="{{ url('/catalog') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>

        <!-- Order Status Legend -->
        <div class="mt-8 bg-white dark:bg-gray-800 shadow rounded-lg p-6 scroll-animate">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Order Status Guide</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                        Processing
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Order is being prepared</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                        Shipped
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Order is on its way</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                        Delivered
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Order has been delivered</span>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                        Cancelled
                    </span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Order was cancelled</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
