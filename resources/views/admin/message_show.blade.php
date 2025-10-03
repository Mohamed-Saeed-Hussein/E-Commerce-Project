@extends('layouts.admin')

@section('title', 'Message Details')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ url('/admin/messages') }}" class="text-primary-600 hover:text-primary-700">&larr; Back to Messages</a>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $message->subject ?: 'No subject' }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">From {{ $message->name }} &lt;{{ $message->email }}&gt; • {{ $message->created_at->format('Y-m-d H:i') }}</p>
            </div>
            <div class="prose dark:prose-invert max-w-none whitespace-pre-wrap text-gray-800 dark:text-gray-100">
                {{ $message->content }}
            </div>
        </div>
    </div>
</div>
@endsection


