@extends('layouts.admin')

@section('title', 'View Users')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Users</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">View user accounts and information</p>
            </div>
            <a href="{{ url('/admin/users/create') }}" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                Add User
            </a>
        </div>

        @if (session('status'))
        <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Admins List -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md mb-8">
            <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Admins</h2>
            </div>
            @php
                $admins = $users->where('role','admin');
                $regularUsers = $users->where('role','user');
            @endphp
            @if($admins->count() > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($admins as $user)
                <li class="{{ $user->id == session('auth.user_id') ? 'opacity-75' : '' }}">
                    <div class="px-4 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $user->name }}
                                    @if($user->id == session('auth.user_id'))
                                        <span class="text-xs text-gray-500 dark:text-gray-400">(You)</span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">
                                        Admin
                                    </span>
                                    • Joined {{ $user->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            @if($user->id == session('auth.user_id'))
                                <span class="text-sm text-gray-500 dark:text-gray-400">Current User</span>
                            @else
                                <div class="flex items-center space-x-2">
                                    <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ url('/admin/users/' . $user->id) }}" onsubmit="return confirm('Delete this user?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-10a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No admins</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No admins found.</p>
            </div>
            @endif
        </div>

        <!-- Users List -->
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Users</h2>
            </div>
            @if($regularUsers->count() > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($regularUsers as $user)
                <li>
                    <div class="px-4 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10">
                                <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                                    <span class="text-sm font-medium text-white">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">User</span>
                                    • Joined {{ $user->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                    Edit
                                </a>
                                <form method="POST" action="{{ url('/admin/users/' . $user->id) }}" onsubmit="return confirm('Delete this user?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-10a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No users</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No users have registered yet.</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection