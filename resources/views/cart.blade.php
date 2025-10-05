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
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:shadow-md transition-shadow duration-200" data-product-id="{{ $item->product_id }}">
                            <div class="flex-shrink-0">
                                @if($item->product->image)
                                <img src="{{ url($item->product->image) }}" alt="{{ $item->product->name }}" class="h-20 w-20 object-cover rounded-md">
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
                                <p class="text-lg font-semibold text-primary-600 dark:text-primary-400 item-price">${{ number_format($item->price, 2) }}</p>
                            </div>
                            
                            <div class="flex items-center space-x-2">
                                <div class="quantity-selector flex items-center border border-gray-300 dark:border-gray-600 rounded-md group-hover:border-primary-300 dark:group-hover:border-primary-600 transition-colors duration-300">
                                    <button class="qty-btn minus px-3 py-1 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200" type="button" onclick="decreaseQuantity({{ $item->product_id }})">-</button>
                                    <input type="number" id="quantity_{{ $item->product_id }}" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" class="qty-input w-16 text-center border-0 bg-transparent text-gray-900 dark:text-white" onchange="updateQuantityFromInput({{ $item->product_id }})" data-previous-value="{{ $item->quantity }}">
                                    <button class="qty-btn plus px-3 py-1 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200" type="button" onclick="increaseQuantity({{ $item->product_id }})">+</button>
                                </div>
                            </div>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $item->product->quantity }} in stock</p>
                            
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900 dark:text-white item-total">${{ number_format($item->price * $item->quantity, 2) }}</p>
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
                            <span class="text-gray-900 dark:text-white subtotal-amount">${{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
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
                                <span class="text-lg font-semibold text-primary-600 dark:text-primary-400 total-amount">${{ number_format($cartItems->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <div class="mt-6">
                        <a href="{{ url('/checkout') }}" class="w-full bg-primary-600 text-white py-3 px-4 rounded-md font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                            Proceed to Checkout
                        </a>
                    </div>

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
function decreaseQuantity(productId) {
    const quantityInput = document.getElementById('quantity_' + productId);
    const currentValue = parseInt(quantityInput.value);
    if (currentValue > 1) {
        quantityInput.value = currentValue - 1;
        updateQuantityFromInput(productId);
    }
}

function increaseQuantity(productId) {
    const quantityInput = document.getElementById('quantity_' + productId);
    const currentValue = parseInt(quantityInput.value);
    const maxValue = parseInt(quantityInput.max);
    if (currentValue < maxValue) {
        quantityInput.value = currentValue + 1;
        updateQuantityFromInput(productId);
    }
}

function updateQuantityFromInput(productId) {
    const quantityInput = document.getElementById('quantity_' + productId);
    const newQuantity = parseInt(quantityInput.value);
    
    // Store previous value for error handling
    quantityInput.setAttribute('data-previous-value', quantityInput.value);
    
    // Ensure quantity is within bounds
    if (newQuantity < 1) {
        quantityInput.value = 1;
        return;
    }
    if (newQuantity > parseInt(quantityInput.max)) {
        quantityInput.value = quantityInput.max;
        return;
    }
    
    updateQuantity(productId, newQuantity);
}

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
            // Update the total price for this item
            updateItemTotal(productId, newQuantity);
            // Update cart count in navbar if it exists
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
        } else {
            PopupMessage.error(data.message || 'Error updating quantity');
            // Revert the input value on error
            const quantityInput = document.getElementById('quantity_' + productId);
            quantityInput.value = quantityInput.getAttribute('data-previous-value') || 1;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        PopupMessage.error('Error updating quantity');
        // Revert the input value on error
        const quantityInput = document.getElementById('quantity_' + productId);
        quantityInput.value = quantityInput.getAttribute('data-previous-value') || 1;
    });
}

function updateItemTotal(productId, quantity) {
    // Find the cart item row and update the total price
    const itemRow = document.querySelector(`[data-product-id="${productId}"]`);
    if (itemRow) {
        const priceElement = itemRow.querySelector('.item-price');
        const totalElement = itemRow.querySelector('.item-total');
        if (priceElement && totalElement) {
            const price = parseFloat(priceElement.textContent.replace('$', ''));
            const total = price * quantity;
            totalElement.textContent = '$' + total.toFixed(2);
        }
    }
    
    // Update the order summary
    updateOrderSummary();
}

function updateOrderSummary() {
    // Calculate new subtotal
    let subtotal = 0;
    document.querySelectorAll('.item-total').forEach(totalElement => {
        const total = parseFloat(totalElement.textContent.replace('$', ''));
        subtotal += total;
    });
    
    // Update subtotal and total in order summary
    const subtotalElement = document.querySelector('.subtotal-amount');
    const totalElement = document.querySelector('.total-amount');
    
    if (subtotalElement) {
        subtotalElement.textContent = '$' + subtotal.toFixed(2);
    }
    if (totalElement) {
        totalElement.textContent = '$' + subtotal.toFixed(2);
    }
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
                // Remove the item from the DOM
                const itemRow = document.querySelector(`[data-product-id="${productId}"]`);
                if (itemRow) {
                    itemRow.remove();
                }
                
                // Update order summary
                updateOrderSummary();
                
                // Update cart count in navbar if it exists
                const cartCount = document.getElementById('cartCount');
                if (cartCount) {
                    cartCount.textContent = data.cart_count;
                }
                
                // Check if cart is empty and reload if needed
                const remainingItems = document.querySelectorAll('[data-product-id]');
                if (remainingItems.length === 0) {
                    location.reload();
                }
            } else {
                PopupMessage.error(data.message || 'Error removing item');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            PopupMessage.error('Error removing item');
        });
    }
}
</script>
@endsection
