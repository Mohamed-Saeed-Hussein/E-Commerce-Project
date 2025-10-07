@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Orders</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">View and manage customer orders</p>
            </div>
            <a href="{{ url('/admin/orders/create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                Add Order
            </a>
        </div>

        <!-- Orders Table -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            @if($orders->count() > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($orders as $order)
                <li class="px-4 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Order #{{ $order->order_number }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $order->user ? $order->user->name : 'Deleted User' }} • 
                                ${{ number_format($order->total_amount,2) }} • 
                                {{ $order->created_at->format('Y-m-d H:i') }}
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <form method="POST" action="{{ url('/admin/orders/' . $order->id . '/status') }}" class="flex items-center space-x-2">
                                @csrf
                                <select name="status" class="border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                        <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="px-3 py-1 bg-primary-600 text-white rounded-md">Update</button>
                            </form>
                            <div class="flex items-center space-x-2">
                                <a href="{{ url('/admin/orders/' . $order->id . '/edit') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    Edit
                                </a>
                                <form method="POST" action="{{ url('/admin/orders/' . $order->id) }}" onsubmit="return confirm('Delete this order?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No orders yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Orders will appear here when customers make purchases.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection