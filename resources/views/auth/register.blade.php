@extends('layouts.auth')

@section('title', 'Register')

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
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Create an account
              </h1>
              
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

              <form class="space-y-4 md:space-y-6" method="POST" action="{{ url('/register') }}">
                  @csrf
                  <div>
                      <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                      <input type="text" name="name" id="name" value="{{ old('name') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your Name" required>
                  </div>
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                      <input type="email" name="email" id="email" value="{{ old('email') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required>
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                      
                      <!-- Password Requirements Feedback -->
                      <div id="password-feedback" class="mt-2 space-y-2">
                          <div class="flex items-center space-x-2" id="length-requirement">
                              <svg class="w-4 h-4 text-red-500" id="length-icon" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                              </svg>
                              <span class="text-sm text-red-600" id="length-text">At least 8 characters</span>
                          </div>
                          <div class="flex items-center space-x-2" id="letter-requirement">
                              <svg class="w-4 h-4 text-red-500" id="letter-icon" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                              </svg>
                              <span class="text-sm text-red-600" id="letter-text">Contains letters</span>
                          </div>
                          <div class="flex items-center space-x-2" id="number-requirement">
                              <svg class="w-4 h-4 text-red-500" id="number-icon" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                              </svg>
                              <span class="text-sm text-red-600" id="number-text">Contains numbers</span>
                          </div>
                          <div class="flex items-center space-x-2" id="special-requirement">
                              <svg class="w-4 h-4 text-red-500" id="special-icon" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                              </svg>
                              <span class="text-sm text-red-600" id="special-text">Contains special characters (@$!%*?&)</span>
                          </div>
                      </div>
                  </div>
                  <div>
                      <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                      
                      <!-- Password Confirmation Feedback -->
                      <div id="password-confirmation-feedback" class="mt-2 space-y-2">
                          <div class="flex items-center space-x-2" id="match-requirement">
                              <svg class="w-4 h-4 text-red-500" id="match-icon" fill="currentColor" viewBox="0 0 20 20">
                                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                              </svg>
                              <span class="text-sm text-red-600" id="match-text">Passwords must match</span>
                          </div>
                      </div>
                  </div>
                  <div class="flex items-start">
                      <div class="flex items-center h-5">
                        <input id="terms" aria-describedby="terms" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                      </div>
                      <div class="ml-4 text-sm">
                        <label for="terms" class="text-gray-500 dark:text-gray-300">I accept the <a class="font-medium text-primary-600 hover:underline dark:text-primary-500" href="#">Terms and Conditions</a></label>
                      </div>
                  </div>
                  <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create an account</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Already have an account? <a href="{{ url('/login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Login here</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordFeedback = document.getElementById('password-feedback');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const passwordConfirmationFeedback = document.getElementById('password-confirmation-feedback');
    
    // Icons for success (checkmark) and error (X)
    const successIcon = '<svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>';
    const errorIcon = '<svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>';
    
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
    
    function validatePasswordConfirmation() {
        const password = passwordInput.value;
        const confirmPassword = passwordConfirmationInput.value;
        
        // Check if passwords match
        const passwordsMatch = password === confirmPassword && confirmPassword.length > 0;
        updateConfirmationRequirement('match', passwordsMatch, 'Passwords must match');
        
        // Show/hide feedback based on input focus and content
        if (confirmPassword.length > 0) {
            passwordConfirmationFeedback.style.display = 'block';
        } else {
            passwordConfirmationFeedback.style.display = 'none';
        }
    }
    
    function updateConfirmationRequirement(type, isValid, text) {
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
    
    // Hide feedback initially
    passwordFeedback.style.display = 'none';
    passwordConfirmationFeedback.style.display = 'none';
    
    // Add event listeners for password field
    passwordInput.addEventListener('input', function() {
        validatePassword();
        validatePasswordConfirmation(); // Also validate confirmation when main password changes
    });
    passwordInput.addEventListener('focus', function() {
        if (passwordInput.value.length > 0) {
            passwordFeedback.style.display = 'block';
        }
    });
    passwordInput.addEventListener('blur', function() {
        // Keep feedback visible if password is not empty
        if (passwordInput.value.length === 0) {
            passwordFeedback.style.display = 'none';
        }
    });
    
    // Add event listeners for password confirmation field
    passwordConfirmationInput.addEventListener('input', validatePasswordConfirmation);
    passwordConfirmationInput.addEventListener('focus', function() {
        if (passwordConfirmationInput.value.length > 0) {
            passwordConfirmationFeedback.style.display = 'block';
        }
    });
    passwordConfirmationInput.addEventListener('blur', function() {
        // Keep feedback visible if confirmation password is not empty
        if (passwordConfirmationInput.value.length === 0) {
            passwordConfirmationFeedback.style.display = 'none';
        }
    });
});
</script>
@endsection