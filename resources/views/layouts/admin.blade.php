<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') - {{ config('app.name', 'Style Haven') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind is compiled via Vite (resources/css/app.css) -->
</head>
<body class="font-sans antialiased dark:bg-gray-900">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Navigation (match user header styles, admin links) -->
        <nav class="bg-white dark:bg-gray-800 antialiased">
            <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/admin') }}" class="flex items-center">
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
                                <span class="text-xl font-bold text-gray-900 dark:text-white">Style Haven Admin</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <ul class="hidden lg:flex items-center justify-start gap-6 md:gap-8 py-3 sm:justify-center">
                            <li><a href="{{ url('/admin') }}" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Dashboard</a></li>
                            <li class="shrink-0"><a href="{{ url('/admin/products') }}" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Products</a></li>
                            <li class="shrink-0"><a href="{{ url('/admin/categories') }}" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Categories</a></li>
                            <li class="shrink-0"><a href="{{ url('/admin/orders') }}" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Orders</a></li>
                            <li class="shrink-0"><a href="{{ url('/admin/users') }}" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Users</a></li>
                            <li class="shrink-0"><a href="{{ url('/admin/messages') }}" class="flex text-sm font-medium text-gray-900 hover:text-primary-700 dark:text-white dark:hover:text-primary-500 transition-all duration-200 hover:scale-105 hover:underline">Messages</a></li>
                        </ul>
                    </div>

                    <!-- Right side -->
                    <div class="hidden sm:ml-6 sm:flex sm:items-center">
                        <!-- Profile dropdown -->
                        <div class="ml-3 relative">
                            <div>
                                <button type="button" class="bg-white dark:bg-gray-800 rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span class="sr-only">Open user menu</span>
                                    <div class="h-8 w-8 rounded-full bg-primary-600 flex items-center justify-center">
                                        <span class="text-sm font-medium text-white">{{ substr(session('auth.name', 'A'), 0, 1) }}</span>
                                    </div>
                                </button>
                            </div>

                            <!-- Dropdown menu -->
                            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none hidden" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">My Profile</a>
                                <a href="{{ url('/logout') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Logout</a>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button type="button" class="bg-white dark:bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500" aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="sm:hidden" id="mobile-menu">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ url('/admin') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Dashboard</a>
                    <a href="{{ url('/admin/products') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Products</a>
                    <a href="{{ url('/admin/categories') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Categories</a>
                    <a href="{{ url('/admin/orders') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Orders</a>
                    <a href="{{ url('/admin/users') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Users</a>
                    <a href="{{ url('/admin/messages') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Messages</a>
                </div>
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-primary-600 flex items-center justify-center">
                                <span class="text-sm font-medium text-white">{{ substr(session('auth.name', 'A'), 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800 dark:text-white">{{ session('auth.name', 'Admin') }}</div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ session('auth.email', 'admin@example.com') }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ url('/profile') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700">My Profile</a>
                        <a href="{{ url('/logout') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-300 dark:hover:bg-gray-700">Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer (reuse user footer style with admin links) -->
        <footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
            <div class="mx-auto max-w-screen-xl text-center">
                <a href="{{ url('/admin') }}" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                    <svg class="mr-2 h-8" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false">
                        <defs>
                            <linearGradient id="bagSplitFooterAdmin" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="50%" stop-color="#F7632E"/>
                                <stop offset="50%" stop-color="#FF1F49"/>
                            </linearGradient>
                        </defs>
                        <path d="M96 144h320c10.7 0 19.7 7.8 21.1 18.4l40 312C478.8 486 462.9 504 442.9 504H69.1c-20 0-35.9-18-34.2-29.6l40-312C76.3 151.8 85.3 144 96 144z" fill="url(#bagSplitFooterAdmin)"/>
                        <path d="M176 208a16 16 0 0 1-16-16v-64c0-58.5 47.5-106 106-106s106 47.5 106 106v64a16 16 0 1 1-32 0v-64c0-40.9-33.1-74-74-74s-74 33.1-74 74v64a16 16 0 0 1-16 16z" fill="#0B2C33"/>
                    </svg>
                    Admin Panel
                </a>
                <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white mt-4">
                    <li><a href="{{ url('/admin') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Dashboard</a></li>
                    <li><a href="{{ url('/admin/products') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Products</a></li>
                    <li><a href="{{ url('/admin/categories') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Categories</a></li>
                    <li><a href="{{ url('/admin/orders') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Orders</a></li>
                    <li><a href="{{ url('/admin/users') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Users</a></li>
                    <li><a href="{{ url('/admin/messages') }}" class="mr-4 hover:underline md:mr-6 transition-all duration-200 hover:text-primary-600 dark:hover:text-primary-400 hover:scale-105">Messages</a></li>
                </ul>
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© {{ date('Y') }} Style Haven Admin. All Rights Reserved.</span>
            </div>
        </footer>
    </div>

    <script>
        // Profile dropdown toggle
        document.getElementById('user-menu-button').addEventListener('click', function() {
            const dropdown = document.querySelector('[role="menu"]');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('[role="menu"]');
            const button = document.getElementById('user-menu-button');
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Mobile menu toggle
        document.querySelector('[aria-controls="mobile-menu"]').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
