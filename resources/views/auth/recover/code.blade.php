@extends('layouts.auth')

@section('title', 'Enter Verification Code')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="{{ url('/home') }}" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
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
              Enter Verification Code
          </h2>
          <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">We've sent a 6-digit verification code to <strong>{{ $email }}</strong></p>
          
          @if(config('app.debug'))
          <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-400 rounded">
              <div class="flex">
                  <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                      </svg>
                  </div>
                  <div class="ml-3">
                      <p class="text-sm text-blue-800 font-medium">Debug Mode</p>
                      <p class="text-sm text-blue-700">Check the log file at <code>storage/logs/laravel.log</code> for the verification code, or visit: <a href="{{ url('/debug/verification-code/' . $email) }}" target="_blank" class="text-blue-600 hover:underline">{{ url('/debug/verification-code/' . $email) }}</a></p>
                  </div>
              </div>
          </div>
          @endif
          
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
                      <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                  </div>
              </div>
          </div>
          @endif

          @if (session('status'))
          <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-400 rounded">
              <div class="flex">
                  <div class="flex-shrink-0">
                      <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                  </div>
                  <div class="ml-3">
                      <p class="text-sm text-green-800 font-medium">Success!</p>
                      <p class="text-sm text-green-700">{{ session('status') }}</p>
                  </div>
              </div>
          </div>
          @endif

          <form class="mt-4 space-y-4 lg:mt-5 md:space-y-5" method="POST" action="{{ url('/recover/code') }}" id="verify-form">
              @csrf
              <input type="hidden" name="email" value="{{ $email }}">
              <div>
                  <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Verification Code</label>
                  <input type="text" name="code" id="code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-center text-2xl tracking-widest" placeholder="000000" maxlength="6" pattern="[0-9]{6}" required autocomplete="one-time-code" value="">
                  <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Enter the 6-digit code sent to your email</p>
              </div>
              <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" id="verify-button">
                  Verify Code
              </button>
          </form>
          
          <div class="mt-4 text-center">
              <p class="text-sm text-gray-600 dark:text-gray-400">Didn't receive the code?</p>
              <form method="POST" action="{{ url('/recover/resend') }}" class="inline" id="resend-form">
                  @csrf
                  <input type="hidden" name="email" value="{{ $email }}">
                  <button type="submit" id="resend-button" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500 disabled:text-gray-400 disabled:cursor-not-allowed">
                      <span id="resend-text">Resend Code</span>
                      <span id="resend-timer" class="hidden">Resend in <span id="countdown">60</span>s</span>
                  </button>
              </form>
          </div>
          
          <p class="text-sm font-light text-gray-500 dark:text-gray-400 mt-4">
              Remember your password? <a href="{{ url('/login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign in</a>
          </p>
      </div>
  </div>
</section>

<script>
document.getElementById('code').addEventListener('input', function(e) {
    // Only allow numbers
    e.target.value = e.target.value.replace(/[^0-9]/g, '');
});

// Clear code input on page load to ensure it's always empty
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('code').value = '';
    document.getElementById('code').focus();
});

// Resend timer functionality
let resendTimer = null;
let timeLeft = 60;

function startResendTimer() {
    const resendButton = document.getElementById('resend-button');
    const resendText = document.getElementById('resend-text');
    const resendTimer = document.getElementById('resend-timer');
    const countdown = document.getElementById('countdown');
    
    resendButton.disabled = true;
    resendText.classList.add('hidden');
    resendTimer.classList.remove('hidden');
    
    const timer = setInterval(() => {
        timeLeft--;
        countdown.textContent = timeLeft;
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            resendButton.disabled = false;
            resendText.classList.remove('hidden');
            resendTimer.classList.add('hidden');
            timeLeft = 60;
        }
    }, 1000);
}

// Start timer when page loads
startResendTimer();

// Handle resend form submission
document.getElementById('resend-form').addEventListener('submit', function() {
    startResendTimer();
});

// Handle paste events for OTP codes
document.getElementById('code').addEventListener('paste', function(e) {
    e.preventDefault();
    const pastedData = e.clipboardData.getData('text');
    const numbersOnly = pastedData.replace(/[^0-9]/g, '');
    if (numbersOnly.length <= 6) {
        e.target.value = numbersOnly;
    }
});
</script>
@endsection
