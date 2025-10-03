@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Orders</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">View and manage customer orders</p>
        </div>

        <!-- Orders Table -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            @if($orders->count() > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($orders as $order)
                <li class="px-4 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-medium text-gray-900 dark:text-white">Order #{{ $order->order_number }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $order->user?->name }} • ${{ number_format($order->total_amount,2) }} • {{ $order->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                        <form method="POST" action="{{ url('/admin/orders/' . $order->id . '/status') }}" class="flex items-center space-x-2">
                            @csrf
                            <select name="status" class="border-gray-300 rounded-md dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                @foreach(['pending','processing','shipped','delivered','cancelled'] as $status)
                                    <option value="{{ $status }}" {{ $order->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-3 py-1 bg-primary-600 text-white rounded-md">Update</button>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No orders yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Orders will appear here when customers make purchases.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection