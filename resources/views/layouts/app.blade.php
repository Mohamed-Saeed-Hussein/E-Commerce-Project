<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Style Haven') - {{ config('app.name', 'Style Haven') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    
    
    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slide-in-left {
            animation: slideInLeft 0.6s ease-out;
        }
        
        .animate-slide-in-right {
            animation: slideInRight 0.6s ease-out;
        }
        
        /* Scroll-triggered animations */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }
        
        .scroll-animate.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>
<body class="font-sans antialiased dark:bg-gray-900">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 antialiased">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
                <div class="flex items-center justify-between">

                    <div class="flex items-center space-x-8">
                        <div class="shrink-0">
                            <a href="{{ url('/home') }}" title="" class="flex items-center space-x-2">
                                <svg class="block w-auto h-8 dark:hidden" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <defs>
                                        <linearGradient id="bagSplit" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="50%" stop-color="#F7632E"/>
                                            <stop offset="50%" stop-color="#FF1F49"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M96 144h320c10.7 0 19.7 7.8 21.1 18.4l40 312C478.8 486 462.9 504 442.9 504H69.1c-20 0-35.9-18-34.2-29.6l40-312C76.3 151.8 85.3 144 96 144z" fill="url(#bagSplit)"/>
                                    <path d="M176 208a16 16 0 0 1-16-16v-64c0-58.5 47.5-106 106-106s106 47.5 106 106v64a16 16 0 1 1-32 0v-64c0-40.9-33.1-74-74-74s-74 33.1-74 74v64a16 16 0 0 1-16 16z" fill="#0B2C33"/>
                                </svg>
                                <svg class="hidden w-auto h-8 dark:block" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                                    <defs>
                                        <linearGradient id="bagSplitDark" x1="0%" y1="0%" x2="100%" y2="0%">
                                            <stop offset="50%" stop-color="#F7632E"/>
                                            <stop offset="50%" stop-color="#FF1F49"/>
                                        </linearGradient>
                                    </defs>
                                    <path d="M96 144h320c10.7 0 19.7 7.8 21.1 18.4l40 312C478.8 486 462.9 504 442.9 504H69.1c-20 0-35.9-18-34.2-29.6l40-312C76.3 151.8 85.3 144 96 144z" fill="url(#bagSplitDark)"/>
                                    <path d="M176 208a16 16 0 0 1-16-16v-64c0-58.5 47.5-106 106-106s106 47.5 106 106v64a16 16 0 1 1-32 0v-64c0-40.9-33.1-74-74-74s-74 33.1-74 74v64a16 16 0 0 1-16 16z" fill="#ffffff"/>
                                </svg>
                                <span class="text-xl font-bold text-gray-900 dark:text-white">Style Haven</span>
                            </a>
                        </div>

                        <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
                            <li>
                                <a href="{{ url('/home') }}" title="" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">
                                    Home
                                </a>
                            </li>
                            <li class="shrink-0">
                                <a href="{{ url('/catalog') }}" title="" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">
                                    Products
                                </a>
                            </li>
                            <li class="shrink-0">
                                <a href="{{ url('/about') }}" title="" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">
                                    About
                                </a>
                            </li>
                            <li class="shrink-0">
                                <a href="{{ url('/contact') }}" title="" class="text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">
                                    Contact
                                </a>
                            </li>
                            <li class="shrink-0">
                                <a href="{{ url('/faq') }}" title="" class="text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">
                                    FAQ
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="flex items-center lg:space-x-2">

                        <a href="{{ url('/cart') }}" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <span class="sr-only">
                                Cart
                            </span>
                            <svg class="w-5 h-5 lg:me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"/>
                            </svg> 
                            <span class="hidden sm:flex">My Cart</span>
                            <span id="cartCount" class="ml-1 bg-primary-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>


                        @if(session('auth.user_id'))
                        <div class="relative">
                        <button id="userDropdownButton1" data-dropdown-toggle="userDropdown1" type="button" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-10a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/>
                            </svg>              
                            Account
                            <svg class="w-4 h-4 text-gray-900 dark:text-white ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"/>
                            </svg> 
                        </button>

                        <div id="userDropdown1" class="hidden z-10 w-56 divide-y divide-gray-100 overflow-hidden overflow-y-auto rounded-lg bg-white antialiased shadow dark:divide-gray-600 dark:bg-gray-700">
                            <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                                <div class="font-medium truncate">{{ session('auth.name', 'User') }}</div>
                                <div class="font-medium truncate">{{ session('auth.email', 'user@example.com') }}</div>
                            </div>
                            <ul class="p-2 text-start text-sm font-medium text-gray-900 dark:text-white">
                                <li><a href="{{ url('/profile') }}" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200"> My Account </a></li>
                                <li><a href="{{ url('/orders') }}" title="" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200"> My Orders </a></li>
                            </ul>
                            <div class="p-2 text-sm font-medium text-gray-900 dark:text-white">
                                <form method="POST" action="{{ url('/logout') }}">
                                    @csrf
                                    <button type="submit" class="inline-flex w-full items-center gap-2 rounded-md px-3 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-600"> Sign Out </button>
                                </form>
                            </div>
                        </div>
                        </div>
                        @else
                        <a href="{{ url('/login') }}" class="inline-flex items-center rounded-lg justify-center p-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-sm font-medium leading-none text-gray-900 dark:text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <svg class="w-5 h-5 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="2" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m8-10a4 4 0 1 1 0-8 4 4 0 0 1 0 8Z"/>
                            </svg>              
                            Sign In
                        </a>
                        @endif

                        <button type="button" data-collapse-toggle="ecommerce-navbar-menu-1" aria-controls="ecommerce-navbar-menu-1" aria-expanded="false" class="inline-flex lg:hidden items-center justify-center hover:bg-gray-100 rounded-md dark:hover:bg-gray-700 p-2 text-gray-900 dark:text-white transition-all duration-200 hover:scale-105 hover:shadow-md">
                            <span class="sr-only">
                                Open Menu
                            </span>
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14"/>
                            </svg>                
                        </button>
                    </div>
                </div>

                <div id="ecommerce-navbar-menu-1" class="bg-gray-50 dark:bg-gray-700 dark:border-gray-600 border border-gray-200 rounded-lg py-3 hidden px-4 mt-4">
                    <ul class="text-gray-900 dark:text-white text-sm font-medium dark:text-white space-y-3">
                        <li>
                            <a href="{{ url('/home') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Home</a>
                        </li>
                        <li>
                            <a href="{{ url('/catalog') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Products</a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">About</a>
                        </li>
                        <li>
                            <a href="{{ url('/contact') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Contact</a>
                        </li>
                        <li>
                            <a href="{{ url('/faq') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">FAQ</a>
                        </li>
                        @if(!session('auth.user_id'))
                        <li>
                            <a href="{{ url('/login') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Sign In</a>
                        </li>
                        <li>
                            <a href="{{ url('/register') }}" class="hover:text-primary-700 dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Sign Up</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="flex-1">
        @yield('content')
    </main>

    <!-- Popup Message System -->
    @include('partials.popup-message')

        <!-- Footer -->
        <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
            <div class="mx-auto max-w-screen-xl text-center">
                <a href="{{ url('/home') }}" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                    <svg class="mr-2 h-8" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <defs>
                            <linearGradient id="bagSplitFooter" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="50%" stop-color="#F7632E"/>
                                <stop offset="50%" stop-color="#FF1F49"/>
                            </linearGradient>
                        </defs>
                        <path d="M96 144h320c10.7 0 19.7 7.8 21.1 18.4l40 312C478.8 486 462.9 504 442.9 504H69.1c-20 0-35.9-18-34.2-29.6l40-312C76.3 151.8 85.3 144 96 144z" fill="url(#bagSplitFooter)"/>
                        <path d="M176 208a16 16 0 0 1-16-16v-64c0-58.5 47.5-106 106-106s106 47.5 106 106v64a16 16 0 1 1-32 0v-64c0-40.9-33.1-74-74-74s-74 33.1-74 74v64a16 16 0 0 1-16 16z" fill="#0B2C33"/>
                    </svg>
                    Style Haven    
                </a>
                <p class="my-6 text-gray-500 dark:text-gray-400">Your favorite store for trendy fashion. We offer high-quality clothing and accessories for every style and occasion.</p>
                <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
                    <li>
                        <a href="{{ url('/home') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Home</a>
                    </li>
                    <li>
                        <a href="{{ url('/catalog') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Products</a>
                    </li>
                    <li>
                        <a href="{{ url('/about') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">About</a>
                    </li>
                    <li>
                        <a href="{{ url('/contact') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Contact</a>
                    </li>
                    <li>
                        <a href="{{ url('/faq') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">FAQ</a>
                    </li>
                </ul>
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} <a href="{{ url('/home') }}" class="hover:underline">Style Haven™</a>. All Rights Reserved.</span>
            </div>
        </footer>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <style>
        /* Fix dropdown positioning and disable animations */
        #userDropdown1 {
            position: absolute !important;
            top: 100% !important;
            right: 0 !important;
            left: auto !important;
            transform: none !important;
            transition: none !important;
            animation: none !important;
            margin-top: 0.5rem !important;
        }
        #userDropdown1.hidden {
            display: none !important;
        }
        #userDropdown1:not(.hidden) {
            display: block !important;
        }
        /* Ensure the button container has relative positioning */
        #userDropdownButton1 {
            position: relative !important;
        }
    </style>
    
    <script>
        // Global: toggle password visibility buttons
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('[data-toggle-password]');
            if (!btn) return;
            const sel = btn.getAttribute('data-toggle-password');
            const input = document.querySelector(sel);
            if (!input) return;
            
            const eyeOpen = btn.querySelector('.eye-open');
            const eyeClosed = btn.querySelector('.eye-closed');
            
            if (input.getAttribute('type') === 'password') {
                // Password is currently hidden, show it (open eye)
                input.setAttribute('type', 'text');
                eyeOpen.classList.remove('hidden'); // Show open eye
                eyeClosed.classList.add('hidden');   // Hide closed eye
            } else {
                // Password is currently visible, hide it (closed eye)
                input.setAttribute('type', 'password');
                eyeOpen.classList.add('hidden');     // Hide open eye
                eyeClosed.classList.remove('hidden'); // Show closed eye
            }
        });

        // Global: clear all forms on page show (when navigating back/forward)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                document.querySelectorAll('form').forEach(function(form) { form.reset(); });
            }
        });

        // Mobile menu toggle
        const mobileMenuButton = document.querySelector('[data-collapse-toggle="ecommerce-navbar-menu-1"]');
        const mobileMenu = document.getElementById('ecommerce-navbar-menu-1');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
                mobileMenuButton.setAttribute('aria-expanded', !isExpanded);
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Scroll-triggered animations
        function handleScrollAnimations() {
            const elements = document.querySelectorAll('.scroll-animate');
            elements.forEach(element => {
                const elementTop = element.getBoundingClientRect().top;
                const elementVisible = 150;
                
                if (elementTop < window.innerHeight - elementVisible) {
                    element.classList.add('animate');
                }
            });
        }

            // Run on scroll and on load
            window.addEventListener('scroll', handleScrollAnimations);
            window.addEventListener('load', handleScrollAnimations);

            // Load cart count on page load
            @if(session('auth.user_id'))
            fetch('{{ url("/cart/count") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const cartCount = document.getElementById('cartCount');
                    if (cartCount) {
                        cartCount.textContent = data.count;
                    }
                }
            })
            .catch(error => {
                console.error('Error loading cart count:', error);
            });
            @endif

    </script>
</body>
</html>