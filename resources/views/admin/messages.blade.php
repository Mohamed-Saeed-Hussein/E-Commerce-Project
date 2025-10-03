@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Messages</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Messages sent via Contact Us</p>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            @if($messages->count() > 0)
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($messages as $msg)
                <li>
                    <a href="{{ url('/admin/messages/' . $msg->id) }}" class="block px-4 py-4 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $msg->subject ?: 'No subject' }}</p>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">From: {{ $msg->name }} &lt;{{ $msg->email }}&gt;</p>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $msg->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
            @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8m-18 8h18a2 2 0 002-2V8a2 2 0 00-2-2H3a2 2 0 00-2 2v6a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No messages</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Messages will show up here when users contact you.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


