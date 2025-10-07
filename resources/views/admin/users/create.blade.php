@extends('layouts.admin')

@section('title', 'Create User')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ url('/admin/users') }}" class="text-primary-600 hover:text-primary-700">&larr; Back to Users</a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mt-4">Create User</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Add a new user account</p>
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
            <form method="POST" action="{{ url('/admin/users') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                    
                    <!-- Password Requirements -->
                    <div id="password-feedback" class="mt-2 space-y-1" style="display: none;">
                        <div class="flex items-center space-x-2">
                            <span id="length-icon" class="w-4 h-4"></span>
                            <span id="length-text" class="text-sm"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span id="letter-icon" class="w-4 h-4"></span>
                            <span id="letter-text" class="text-sm"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span id="number-icon" class="w-4 h-4"></span>
                            <span id="number-text" class="text-sm"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span id="special-icon" class="w-4 h-4"></span>
                            <span id="special-text" class="text-sm"></span>
                        </div>
                    </div>
                </div>
                <div class="mt-6">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                </div>
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ url('/admin/users') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                        Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordFeedback = document.getElementById('password-feedback');
    
    const successIcon = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>';
    const errorIcon = '<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>';
    
    passwordInput.addEventListener('input', validatePassword);
    passwordInput.addEventListener('focus', function() {
        if (passwordInput.value.length > 0) {
            passwordFeedback.style.display = 'block';
        }
    });
    
    function validatePassword() {
        const password = passwordInput.value;
        
        // Length requirement (8+ characters)
        const lengthValid = password.length >= 8;
        updateRequirement('length', lengthValid, 'At least 8 characters');
        
        // Letter requirement
        const letterValid = /[a-zA-Z]/.test(password);
        updateRequirement('letter', letterValid, 'Contains letters');
        
        // Number requirement
        const numberValid = /\d/.test(password);
        updateRequirement('number', numberValid, 'Contains numbers');
        
        // Special character requirement
        const specialValid = /[@$!%*?&]/.test(password);
        updateRequirement('special', specialValid, 'Contains special characters (@$!%*?&)');
        
        // Show/hide feedback based on input focus and content
        if (password.length > 0) {
            passwordFeedback.style.display = 'block';
        } else {
            passwordFeedback.style.display = 'none';
        }
    }
    
    function updateRequirement(type, isValid, text) {
        const icon = document.getElementById(type + '-icon');
        const textElement = document.getElementById(type + '-text');
        
        if (isValid) {
            icon.innerHTML = successIcon;
            icon.className = 'w-4 h-4 text-green-500';
            textElement.className = 'text-sm text-green-600';
            textElement.textContent = text;
        } else {
            icon.innerHTML = errorIcon;
            icon.className = 'w-4 h-4 text-red-500';
            textElement.className = 'text-sm text-red-600';
            textElement.textContent = text;
        }
    }
});
</script>
@endsection
