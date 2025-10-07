@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ url('/admin/categories') }}" class="text-primary-600 hover:text-primary-700">&larr; Back to Categories</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">Create Category</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Add a new product category</p>
        </div>

        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded">
            <ul class="text-sm text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <form method="POST" action="{{ url('/admin/categories') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g. Accessories" required>
                </div>
                <div class="flex justify-end space-x-4">
                    <a href="{{ url('/admin/categories') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Create Category
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
