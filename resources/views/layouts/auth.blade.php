<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Style Haven') - {{ config('app.name', 'Style Haven') }}</title>

    <!-- Fonts removed to comply with CSP (use system fonts defined in CSS) -->

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
        <main class="w-full">
            @yield('content')
        </main>
    </div>

    <!-- Flowbite JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    
    <script>
        // Auth pages: toggle password visibility
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

        // Clear forms when navigating back to the page
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                document.querySelectorAll('form').forEach(function(form) { form.reset(); });
            }
        });

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
    </script>
</body>

</html>