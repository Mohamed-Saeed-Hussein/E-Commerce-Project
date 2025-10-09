@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-primary-600 dark:text-gray-400 dark:hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ url('/catalog') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-400 dark:hover:text-white">Products</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="space-y-4">
            <div class="bg-white dark:bg-white rounded-lg overflow-hidden flex items-center justify-center p-4 min-h-96">
            @if($product->image)
                    <img src="{{ $product->image_url }}" alt="{{ $product->image_alt_text }}" class="max-w-full max-h-full object-contain">
                    @else
                    <div class="w-full h-96 flex items-center justify-center">
                        <svg class="h-24 w-24 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="space-y-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $product->name }}</h1>
                    <div class="mt-4 flex items-center space-x-4">
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">${{ number_format($product->price, 2) }}</p>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $product->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                            {{ $product->is_available ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Description</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $product->description }}</p>
                </div>

                @if($product->is_available)
                <div class="space-y-4">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                        <div class="mt-1">
                            <div class="quantity-selector flex items-center border border-gray-300 dark:border-gray-600 rounded-md group-hover:border-primary-300 dark:group-hover:border-primary-600 transition-colors duration-300">
                                <button class="qty-btn minus px-3 py-1 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200" type="button">-</button>
                                <input type="number" id="quantity" value="{{ $product->quantity > 0 ? 1 : 0 }}" min="{{ $product->quantity > 0 ? 1 : 0 }}" max="{{ $product->quantity }}" class="qty-input w-16 text-center border-0 bg-transparent text-gray-900 dark:text-white">
                                <button class="qty-btn plus px-3 py-1 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200" type="button">+</button>
                            </div>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $product->quantity }} available</p>
                        </div>
                    </div>

                    <button id="addToCartBtn" onclick="addToCart()" class="w-full bg-primary-600 text-white px-6 py-3 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 font-medium" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                        Add to Cart
                    </button>
                </div>
                @else
                <div class="bg-gray-100 dark:bg-gray-700 rounded-md p-4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">This product is currently out of stock.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Similar Products -->
        <div class="mt-16 scroll-animate">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8">Similar Products</h2>
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                @forelse($similarProducts as $similarProduct)
                <div class="group relative bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105 scroll-animate cursor-pointer" onclick="window.location.href='{{ url('/product/' . $similarProduct->id) }}'">
                <div class="w-full h-64 bg-white dark:bg-white relative overflow-hidden">
                @if($similarProduct->image)
                        <img src="{{ $similarProduct->image_url }}" alt="{{ $similarProduct->image_alt_text }}" class="max-w-full max-h-full object-contain group-hover:scale-110 transition-transform duration-500">
                        @else
                        <div class="w-full h-64 flex items-center justify-center group-hover:bg-gray-100 dark:group-hover:bg-gray-500 transition-colors duration-300">
                            <svg class="h-12 w-12 text-gray-400 group-hover:text-gray-500 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        @endif
                        <!-- Overlay on hover -->
                        <div class="absolute inset-0 bg-gray-900 bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-4 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 transition-colors duration-300">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">
                            {{ $similarProduct->name }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">{{ Str::limit($similarProduct->description, 80) }}</p>
                        <div class="mt-4 flex items-center justify-between">
                            <p class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">${{ number_format($similarProduct->price, 2) }}</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $similarProduct->is_available ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 group-hover:bg-green-200 dark:group-hover:bg-green-800' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 group-hover:bg-red-200 dark:group-hover:bg-red-800' }} transition-colors duration-300">
                                {{ $similarProduct->is_available ? 'In Stock' : 'Out of Stock' }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">No similar products found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
    // Unified qty control
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.qty-btn');
        if (!btn) return;
        const input = document.getElementById('quantity');
        const min = parseInt(input.min);
        const max = parseInt(input.max);
        let value = parseInt(input.value) || min;
        if (btn.classList.contains('plus')) {
            value = Math.min(max, value + 1);
        } else if (btn.classList.contains('minus')) {
            value = Math.max(min, value - 1);
        }
        input.value = isNaN(value) ? min : value;
    });

    function addToCart() {
        const quantity = document.getElementById('quantity').value;
        const productId = {{ $product->id }};
        const button = document.getElementById('addToCartBtn');

        // Disable button and show loading state
        button.disabled = true;
        button.textContent = 'Adding...';
        button.classList.add('opacity-75', 'cursor-not-allowed');

        // Add to cart via AJAX
        fetch('{{ url("/cart/add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    // Update button state with animations
                    button.textContent = 'Added!';
                    button.classList.add('bg-green-600', 'hover:bg-green-700');
                    button.classList.remove('bg-primary-600', 'hover:bg-primary-700', 'opacity-75', 'cursor-not-allowed');
                    button.classList.add('transform', 'scale-105');

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        button.textContent = 'Add to Cart';
                        button.classList.remove('bg-green-600', 'hover:bg-green-700', 'transform', 'scale-105');
                        button.classList.add('bg-primary-600', 'hover:bg-primary-700');
                        button.disabled = false;
                    }, 2000);

                    // Update cart count if element exists
                    const cartCount = document.getElementById('cartCount');
                    if (cartCount && typeof data.cart_count !== 'undefined') {
                        cartCount.textContent = data.cart_count;
                    }

                    // Immediately update remaining stock UI
                    if (typeof data.remaining_stock !== 'undefined') {
                        const stockText = document.querySelector('p.mt-1.text-sm');
                        if (stockText) {
                            stockText.textContent = `${data.remaining_stock} available`;
                        }
                        const qtyInput = document.getElementById('quantity');
                        if (qtyInput) {
                            qtyInput.max = data.remaining_stock;
                            const min = parseInt(qtyInput.min);
                            if (parseInt(qtyInput.value) > data.remaining_stock) {
                                qtyInput.value = Math.max(min, data.remaining_stock);
                            }
                            if (data.remaining_stock <= 0) {
                                document.getElementById('addToCartBtn').setAttribute('disabled', 'disabled');
                                qtyInput.value = 0;
                                qtyInput.min = 0;
                            }
                        }
                    }
                } else {
                    // Reset button on error
                    button.textContent = 'Add to Cart';
                    button.classList.remove('opacity-75', 'cursor-not-allowed');
                    button.disabled = false;
                    alert(data.message || 'Error adding product to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Reset button on error
                button.textContent = 'Add to Cart';
                button.classList.remove('opacity-75', 'cursor-not-allowed');
                button.disabled = false;
                alert('Error adding product to cart');
            });
    }
</script>
@endsection