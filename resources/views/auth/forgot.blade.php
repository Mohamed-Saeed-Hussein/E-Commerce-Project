@extends('layouts.auth')

@section('title', 'Change Password')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
  <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
          <svg class="w-8 h-8 mr-2" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
              <defs>
                  <linearGradient id="bagSplit" x1="0%" y1="0%" x2="100%" y2="0%">
                      <stop offset="50%" stop-color="#F7632E"/>
                      <stop offset="50%" stop-color="#FF1F49"/>
                  </linearGradient>
              </defs>
              <path d="M96 144h320c10.7 0 19.7 7.8 21.1 18.4l40 312C478.8 486 462.9 504 442.9 504H69.1c-20 0-35.9-18-34.2-29.6l40-312C76.3 151.8 85.3 144 96 144z" fill="url(#bagSplit)"/>
              <path d="M176 208a16 16 0 0 1-16-16v-64c0-58.5 47.5-106 106-106s106 47.5 106 106v64a16 16 0 1 1-32 0v-64c0-40.9-33.1-74-74-74s-74 33.1-74 74v64a16 16 0 0 1-16 16z" fill="#0B2C33"/>
          </svg>
          Style Haven
      </a>
      <div class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8">
          <h2 class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
              Change Password
          </h2>
          @if ($errors->any())
          <div class="text-sm text-red-600 dark:text-red-400">{{ $errors->first() }}</div>
          @endif
          @if (session('status'))
          <div class="text-sm text-green-600 dark:text-green-400">{{ session('status') }}</div>
          @endif
          <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ url('/password/forgot') }}">
              @csrf
              <div>
                  <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                  <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required>
              </div>
              <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Send reset link</button>
          </form>
      </div>
  </div>
</section>
@endsection