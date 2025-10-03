@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 scroll-animate">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Shopping Cart</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Review your items and proceed to checkout</p>
        </div>

        @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 scroll-animate">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Cart Items</h2>
                    
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow duration-200">
                            <div class="flex-shrink-0">
                                @if($item->product->image)
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="h-20 w-20 object-cover rounded-md">
                                @else
                                <div class="h-20 w-20 bg-gray-200 dark:bg-gray-600 rounded-md flex items-center justify-center">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($item->product->description, 100) }}</p>
                                <p class="text-lg font-semibold text-primary-600 dark:text-primary-400">${{ number_format($item->price, 2) }}</p>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <button onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity - 1 }})" class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                    </svg>
                                </button>
                                <span class="w-12 text-center text-gray-900 dark:text-white">{{ $item->quantity }}</span>
                                <button onclick="updateQuantity({{ $item->product_id }}, {{ $item->quantity + 1 }})" class="p-1 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                    <svg class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                <button onclick="removeFromCart({{ $item->product_id }})" class="text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium transition-colors duration-200">
                                    Remove
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 scroll-animate">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Order Summary</h2>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                            <span class="text-gray-900 dark:text-white">${{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                            <span class="text-gray-900 dark:text-white">Free</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600 dark:text-gray-400">Tax</span>
                            <span class="text-gray-900 dark:text-white">$0.00</span>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Total</span>
                                <span class="text-lg font-semibold text-primary-600 dark:text-primary-400">${{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <form action="{{ url('/checkout') }}" method="POST" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="shipping_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Shipping Address</label>
                            <textarea id="shipping_address" name="shipping_address" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Enter your shipping address" required></textarea>
                        </div>
                        
                        <div>
                            <label for="billing_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Billing Address</label>
                            <textarea id="billing_address" name="billing_address" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white" placeholder="Enter your billing address" required></textarea>
                        </div>

                        <button type="submit" class="w-full bg-primary-600 text-white py-3 px-4 rounded-md font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200">
                            Proceed to Checkout
                        </button>
                    </form>

                    <div class="mt-6">
                        <a href="{{ url('/catalog') }}" class="block text-center text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 font-medium transition-colors duration-200">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-12 text-center scroll-animate">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Your cart is empty</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Add some items to get started.</p>
            <a href="{{ url('/catalog') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                Start Shopping
            </a>
        </div>
        @endif
    </div>
</div>

<script>
function updateQuantity(productId, newQuantity) {
    if (newQuantity < 1) {
        removeFromCart(productId);
        return;
    }

    fetch('{{ url("/cart/update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating quantity');
    });
}

function removeFromCart(productId) {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        fetch('{{ url("/cart/remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing item');
        });
    }
}
</script>
@endsection
