@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Add Product</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Create a new product for your store</p>
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
            <form method="POST" action="{{ url('/admin/products') }}" enctype="multipart/form-data" class="max-w-2xl mx-auto space-y-6">
                @csrf
                
                <!-- Category Selection -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                    <select name="category_id" id="category_id" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        <option value="">-- Select category --</option>
                        @foreach(\App\Models\Category::orderBy('name')->get() as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Product Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter product name" required>
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">$</span>
                        </div>
                        <input type="number" name="price" id="price" step="0.01" min="0" value="{{ old('price') }}" class="w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0.00" required>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Enter product description" required>{{ old('description') }}</textarea>
                </div>

                <!-- Quantity and Availability -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Quantity</label>
                        <input type="number" name="quantity" id="quantity" min="0" value="{{ old('quantity', 0) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="0" required>
                    </div>

                    <div>
                        <label for="is_available" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Availability</label>
                        <select name="is_available" id="is_available" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                            <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>Available</option>
                            <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Out of Stock</option>
                        </select>
                    </div>
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Product Image</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Upload a JPEG, PNG, JPG, GIF, or WebP image (max 2MB)</p>
                    
                    <!-- Image Preview -->
                    <div id="image-preview-container" class="mt-4" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image Preview</label>
                        <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                            <img id="image-preview" src="" alt="Product preview" class="max-w-full h-64 object-contain mx-auto rounded-lg shadow-sm" style="display: none;">
                        </div>
                    </div>
                </div>

                <!-- Image Alt Text -->
                <div>
                    <label for="image_alt" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image Alt Text (Optional)</label>
                    <input type="text" name="image_alt" id="image_alt" value="{{ old('image_alt') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Describe the image for accessibility">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Alternative text for screen readers</p>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-center space-x-4 pt-4">
                    <a href="{{ url('/admin/products') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors duration-200">
                        Cancel
                    </a>
                    <button type="submit" class="bg-primary-600 text-white px-6 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 transition-colors duration-200">
                        Create Product
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
    
    // Function to preview uploaded image
    function previewImage(file) {
        if (!file) {
            hidePreview();
            return;
        }
        
        // Check file type
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            return;
        }
        
        // Check file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image file size must not exceed 2MB.');
            return;
        }
        
        // Create FileReader to preview image
        const reader = new FileReader();
        
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
            imagePreview.style.display = 'block';
            previewContainer.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    }
    
    // Function to hide preview
    function hidePreview() {
        previewContainer.style.display = 'none';
        imagePreview.style.display = 'none';
    }
    
    // Event listener for file input
    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        previewImage(file);
    });
});
</script>
@endsection
