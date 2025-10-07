@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Product</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Update product information</p>
        </div>

        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-800 font-medium">There was a problem</p>
                    <ul class="text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ url('/admin/products/' . $product->id) }}" class="max-w-2xl mx-auto space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Category Selection -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Select category --</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter product name" required>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0.00" required>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter product description" required>{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Quantity and Availability -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                        <input type="number" name="quantity" id="quantity" min="0" value="{{ old('quantity', $product->quantity) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0" required>
                    </div>

                    <div>
                        <label for="is_available" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Availability</label>
                        <select name="is_available" id="is_available" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="1" {{ old('is_available', $product->is_available) == '1' ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('is_available', $product->is_available) == '0' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </div>

                <!-- Image URL -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image URL (Optional)</label>
                    <input type="url" name="image" id="image" value="{{ old('image', $product->image) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="https://example.com/image.jpg">
                    
                    <!-- Image Preview -->
                    <div id="image-preview-container" class="mt-4" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image Preview</label>
                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                            <img id="image-preview" src="" alt="Product preview" class="max-w-full h-64 object-contain mx-auto rounded-lg shadow-sm" style="display: none;">
                            <div id="image-error" class="text-center text-red-600 dark:text-red-400 py-8" style="display: none;">
                                <svg class="mx-auto h-12 w-12 text-red-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 19.5c-.77.833.192 2.5 1.732 2.5z" />
                                </svg>
                                <p>Failed to load image. Please check the URL.</p>
                            </div>
                            <div id="image-loading" class="text-center text-gray-500 dark:text-gray-400 py-8" style="display: none;">
                                <svg class="animate-spin mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <p>Loading image...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4 pt-4">
                    <a href="{{ url('/admin/products') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
                        Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const previewContainer = document.getElementById('image-preview-container');
    const imagePreview = document.getElementById('image-preview');
    const imageError = document.getElementById('image-error');
    const imageLoading = document.getElementById('image-loading');
    
    let debounceTimer;
    
    // Function to validate URL
    function isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }
    
    // Function to check if URL is an image
    function isImageUrl(url) {
        const imageExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg', '.bmp'];
        const lowerUrl = url.toLowerCase();
        return imageExtensions.some(ext => lowerUrl.includes(ext)) || 
               lowerUrl.includes('image') || 
               lowerUrl.includes('photo') ||
               lowerUrl.includes('img');
    }
    
    // Function to load and preview image
    function loadImagePreview(url) {
        if (!url || !isValidUrl(url)) {
            hidePreview();
            return;
        }
        
        // Show loading state
        showLoading();
        
        // Create new image object to test loading
        const testImage = new Image();
        
        testImage.onload = function() {
            // Image loaded successfully
            imagePreview.src = url;
            imagePreview.style.display = 'block';
            imageError.style.display = 'none';
            imageLoading.style.display = 'none';
            previewContainer.style.display = 'block';
        };
        
        testImage.onerror = function() {
            // Image failed to load
            imagePreview.style.display = 'none';
            imageError.style.display = 'block';
            imageLoading.style.display = 'none';
            previewContainer.style.display = 'block';
        };
        
        // Set timeout for loading
        setTimeout(() => {
            if (imageLoading.style.display !== 'none') {
                testImage.onerror();
            }
        }, 10000); // 10 second timeout
        
        // Start loading the image
        testImage.src = url;
    }
    
    // Function to show loading state
    function showLoading() {
        imagePreview.style.display = 'none';
        imageError.style.display = 'none';
        imageLoading.style.display = 'block';
        previewContainer.style.display = 'block';
    }
    
    // Function to hide preview
    function hidePreview() {
        previewContainer.style.display = 'none';
        imagePreview.style.display = 'none';
        imageError.style.display = 'none';
        imageLoading.style.display = 'none';
    }
    
    // Event listener for image input
    imageInput.addEventListener('input', function() {
        const url = this.value.trim();
        
        // Clear previous timer
        clearTimeout(debounceTimer);
        
        // Hide preview immediately if empty
        if (!url) {
            hidePreview();
            return;
        }
        
        // Debounce the image loading to avoid too many requests
        debounceTimer = setTimeout(() => {
            loadImagePreview(url);
        }, 500); // 500ms delay
    });
    
    // Load preview if there's already a value (for existing products or form validation errors)
    if (imageInput.value.trim()) {
        loadImagePreview(imageInput.value.trim());
    }
});
</script>
@endsection
