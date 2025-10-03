@extends('layouts.admin')

@section('title', 'Manage Categories')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Categories</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Manage product categories</p>
            </div>
        </div>

        @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 rounded">
            <p class="text-sm text-green-800">{{ session('status') }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-400 rounded">
            <ul class="text-sm text-red-700 list-disc list-inside">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-8">
            <form method="POST" action="{{ url('/admin/categories') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @csrf
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="e.g. Accessories" required>
                </div>
                <div>
                    <button type="submit" class="w-full bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">Add Category</button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse(\App\Models\Category::orderBy('name')->get() as $category)
                <li class="px-4 py-3 flex items-center justify-between">
                    <div class="text-gray-900 dark:text-white">{{ $category->name }}</div>
                    <form method="POST" action="{{ url('/admin/categories/' . $category->id) }}" onsubmit="return confirm('Delete this category?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                    </form>
                </li>
                @empty
                <li class="px-4 py-6 text-center text-gray-500 dark:text-gray-400">No categories available</li>
                @endforelse
            </ul>
        </div>
    </div>
    </div>
@endsection


