@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Checkout</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Complete your order with shipping and billing information</p>
        </div>

        @if(!session('auth.user_id'))
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
        </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Please sign in to checkout</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Create an account or sign in to proceed to payment.</p>
            <div class="flex justify-center gap-4">
                <a href="{{ url('/login') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-900 font-medium py-2 px-4 rounded-lg transition-colors duration-200">Sign In</a>
                <a href="{{ url('/register') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">Create Account</a>
      </div>
    </div>
        @elseif($cartItems->count() == 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center">
            <div class="mb-4">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
            </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Your cart is empty</h2>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Add items to your cart before checking out.</p>
            <a href="{{ url('/catalog') }}" class="bg-primary-600 hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">Start Shopping</a>
        </div>
        @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Shipping Information</h3>
                    <form id="checkoutForm" class="space-y-4" method="POST" action="{{ url('/checkout') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fullName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                <input type="text" id="fullName" name="fullName" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                <input type="email" id="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
          </div>
        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                            <input type="text" id="address" name="address" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                                <input type="text" id="city" name="city" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
      </div>
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                                <input type="text" id="country" name="country" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
      </div>
    </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </form>
                </div>

                <!-- Billing Information -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Billing Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" id="sameAsShipping" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                            <label for="sameAsShipping" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">Same as shipping address</label>
                        </div>
                        
                        <div id="billingFields" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="billingName" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                                    <input type="text" id="billingName" name="billingName" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="billingEmail" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                                    <input type="email" id="billingEmail" name="billingEmail" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                            </div>
                            
                            <div>
                                <label for="billingAddress" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Address</label>
                                <input type="text" id="billingAddress" name="billingAddress" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="billingCity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">City</label>
                                    <input type="text" id="billingCity" name="billingCity" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="billingPostalCode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Postal Code</label>
                                    <input type="text" id="billingPostalCode" name="billingPostalCode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                </div>
                                <div>
                                    <label for="billingCountry" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Country</label>
                                    <input type="text" id="billingCountry" name="billingCountry" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  </div>
                  </div>
                            
                            <div>
                                <label for="billingPhone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Phone Number</label>
                                <input type="tel" id="billingPhone" name="billingPhone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                  </div>
                  </div>
                  </div>
                </div>

            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 sticky top-8">
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

                    <!-- Place Order Button -->
                    <div class="mt-6">
                        <button type="submit" form="checkoutForm" class="w-full bg-primary-600 text-white py-3 px-4 rounded-md font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition-colors duration-200 inline-flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312" />
                            </svg>
                            Place Order - Cash on Delivery
                        </button>
                    </div>
                </div>
            </div>
          </div>
        @endif
    </div>
</div>

<script src="{{ url('/script.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle same as shipping checkbox
    const sameAsShipping = document.getElementById('sameAsShipping');
    const billingFields = document.getElementById('billingFields');
    
    if (sameAsShipping && billingFields) {
        sameAsShipping.addEventListener('change', function() {
            if (this.checked) {
                billingFields.style.display = 'none';
                // Copy shipping data to billing
                document.getElementById('billingName').value = document.getElementById('fullName').value;
                document.getElementById('billingEmail').value = document.getElementById('email').value;
                document.getElementById('billingAddress').value = document.getElementById('address').value;
                document.getElementById('billingCity').value = document.getElementById('city').value;
                document.getElementById('billingPostalCode').value = document.getElementById('postal_code').value;
                document.getElementById('billingCountry').value = document.getElementById('country').value;
                document.getElementById('billingPhone').value = document.getElementById('phone').value;
            } else {
                billingFields.style.display = 'block';
            }
        });
    }

    // Form submission
        const form = document.getElementById('checkoutForm');
    if (form) {
        form.addEventListener('submit', function(ev) {
          ev.preventDefault();
            
          const fullName = document.getElementById('fullName').value.trim();
          const email = document.getElementById('email').value.trim();
          const address = document.getElementById('address').value.trim();
          const city = document.getElementById('city').value.trim();
            const postalCode = document.getElementById('postal_code').value.trim();
            const country = document.getElementById('country').value.trim();
            const phone = document.getElementById('phone').value.trim();
            
            const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            if (!fullName || !emailOk || !address || !city || !postalCode || !country || !phone) {
                showError('Please fill out all fields correctly.');
                return;
            }

            // Prepare form data
            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('fullName', fullName);
            formData.append('email', email);
            formData.append('address', address);
            formData.append('city', city);
            formData.append('postal_code', postalCode);
            formData.append('country', country);
            formData.append('phone', phone);
            
            // Add billing information
            const sameAsShippingChecked = document.getElementById('sameAsShipping').checked;
            if (sameAsShippingChecked) {
                formData.append('billingName', fullName);
                formData.append('billingEmail', email);
                formData.append('billingAddress', address);
                formData.append('billingCity', city);
                formData.append('billingPostalCode', postalCode);
                formData.append('billingCountry', country);
                formData.append('billingPhone', phone);
            } else {
                formData.append('billingName', document.getElementById('billingName').value.trim());
                formData.append('billingEmail', document.getElementById('billingEmail').value.trim());
                formData.append('billingAddress', document.getElementById('billingAddress').value.trim());
                formData.append('billingCity', document.getElementById('billingCity').value.trim());
                formData.append('billingPostalCode', document.getElementById('billingPostalCode').value.trim());
                formData.append('billingCountry', document.getElementById('billingCountry').value.trim());
                formData.append('billingPhone', document.getElementById('billingPhone').value.trim());
            }

            // Submit the form
            fetch('{{ url("/checkout") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok');
            })
            .then(data => {
                // Redirect to orders page
                window.location.href = '{{ url("/orders") }}';
            })
            .catch(error => {
                console.error('Error:', error);
                showError('There was an error processing your order. Please try again.');
            });
        });
    }
});
  </script>
@endsection


