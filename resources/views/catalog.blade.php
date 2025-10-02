@extends('layouts.app')

@section('title', 'Products - Style Haven')

@section('content')
<!-- Page Header -->
<section class="bg-gray-50 dark:bg-gray-800 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 scroll-animate">Our Products</h1>
        <p class="text-xl text-gray-600 dark:text-gray-300 scroll-animate">Discover our exclusive fashion collection</p>
    </div>
</section>

<!-- Category Filter -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="text-center mb-8 scroll-animate">
        <div class="inline-flex rounded-lg border border-gray-200 dark:border-gray-700 p-1 hover:shadow-lg transition-shadow duration-300">
            <button class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-primary-600 text-white hover:bg-primary-700 transform hover:scale-105" data-category="all">All</button>
            <button class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:scale-105" data-category="shirts">Shirts</button>
            <button class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:scale-105" data-category="pants">Pants</button>
            <button class="filter-btn px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 text-gray-600 hover:text-primary-600 dark:text-gray-300 dark:hover:text-primary-400 hover:bg-gray-100 dark:hover:bg-gray-700 transform hover:scale-105" data-category="shoes">Shoes</button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($products as $product)
        <div class="product-card bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden scroll-animate group cursor-pointer transform hover:scale-105" data-category="{{ strtolower(explode(' ', $product->name)[0]) }}" onclick="window.location.href='{{ url('/product/' . $product->id) }}'">
            <div class="aspect-w-1 aspect-h-1 bg-gray-200 dark:bg-gray-700 relative overflow-hidden">
                <img src="{{ $product->image ?: 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500' }}" 
                     alt="{{ $product->name }}" 
                     class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                <!-- Overlay on hover -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                    <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="p-4 group-hover:bg-gray-50 dark:group-hover:bg-gray-700 transition-colors duration-300">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">{{ $product->name }}</h3>
                <p class="text-gray-600 dark:text-gray-300 text-sm mb-3 line-clamp-2 group-hover:text-gray-700 dark:group-hover:text-gray-200 transition-colors duration-300">{{ $product->description }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-2xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">${{ number_format($product->price, 2) }}</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">{{ $product->quantity }} in stock</span>
                </div>
                <div class="mt-4 flex items-center space-x-2">
                    <div class="quantity-selector flex items-center border border-gray-300 dark:border-gray-600 rounded-md group-hover:border-primary-300 dark:group-hover:border-primary-600 transition-colors duration-300">
                        <button class="qty-btn minus px-3 py-1 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200" type="button" onclick="event.stopPropagation(); decreaseQuantity(this)">-</button>
                        <input type="number" value="1" min="1" max="{{ $product->quantity }}" class="qty-input w-16 text-center border-0 bg-transparent text-gray-900 dark:text-white" readonly>
                        <button class="qty-btn plus px-3 py-1 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-primary-600 dark:hover:text-primary-400 transition-colors duration-200" type="button" onclick="event.stopPropagation(); increaseQuantity(this)">+</button>
                    </div>
                    <button class="btn-cart flex-1 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-all duration-200 transform hover:scale-105" 
                            onclick="event.stopPropagation(); addToCart({{ $product->id }}, '{{ $product->name }}', {{ $product->price }}, this)">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <div class="text-gray-400 dark:text-gray-500 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No products available</h3>
            <p class="text-gray-600 dark:text-gray-300">Check back later for new arrivals!</p>
        </div>
        @endforelse
    </div>
</div>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productCards = document.querySelectorAll('.product-card');
    
    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update button states
            filterButtons.forEach(b => {
                b.classList.remove('bg-primary-600', 'text-white');
                b.classList.add('text-gray-600', 'hover:text-primary-600', 'dark:text-gray-300', 'dark:hover:text-primary-400');
            });
            btn.classList.add('bg-primary-600', 'text-white');
            btn.classList.remove('text-gray-600', 'hover:text-primary-600', 'dark:text-gray-300', 'dark:hover:text-primary-400');
            
            // Filter products
            const category = btn.getAttribute('data-category');
            productCards.forEach(card => {
                if (category === 'all' || card.getAttribute('data-category') === category) {
                    card.style.display = 'block';
                    card.classList.add('animate-fade-in-up');
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
    
    // Quantity selector functionality
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.qty-input');
            const currentValue = parseInt(input.value);
            const maxValue = parseInt(input.getAttribute('max'));
            
            if (this.classList.contains('plus') && currentValue < maxValue) {
                input.value = currentValue + 1;
            } else if (this.classList.contains('minus') && currentValue > 1) {
                input.value = currentValue - 1;
            }
        });
    });
});

// Add to cart functionality
function addToCart(productId, productName, price, button) {
    const quantityInput = button.parentElement.querySelector('.qty-input');
    const quantity = parseInt(quantityInput.value);
    
    // Check if user is logged in
    @if(!session('auth.user_id'))
        alert('Please log in to add items to cart');
        return;
    @endif
    
    // Add to cart via AJAX
    fetch('{{ url("/cart/add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            button.textContent = 'Added!';
            button.classList.add('bg-green-600', 'hover:bg-green-700');
            button.classList.remove('bg-primary-600', 'hover:bg-primary-700');
            
            setTimeout(() => {
                button.textContent = 'Add to Cart';
                button.classList.remove('bg-green-600', 'hover:bg-green-700');
                button.classList.add('bg-primary-600', 'hover:bg-primary-700');
            }, 2000);
            
            // Update cart count if element exists
            const cartCount = document.getElementById('cartCount');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to cart');
    });
}

// Update cart count
function updateCartCount() {
    const cart = JSON.parse(localStorage.getItem('cart') || '[]');
    const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
    
    // Update cart count in navbar if it exists
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}

// Initialize cart count on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
});
</script>
@endsection