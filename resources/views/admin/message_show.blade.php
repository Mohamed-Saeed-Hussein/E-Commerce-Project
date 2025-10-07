@extends('layouts.admin')

@section('title', 'Message Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ url('/admin/messages') }}" class="text-primary-600 hover:text-primary-700">&larr; Back to Messages</a>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $message->subject ?: 'No subject' }}</h1>
                <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                    <span><strong>From:</strong> {{ $message->name }}</span>
                    <span><strong>Email:</strong> {{ $message->email }}</span>
                    <span><strong>Date:</strong> {{ $message->created_at->format('M d, Y \a\t H:i') }}</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Message Content</h2>
                <div class="prose dark:prose-invert max-w-none whitespace-pre-wrap text-gray-800 dark:text-white bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    {{ $message->content }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


