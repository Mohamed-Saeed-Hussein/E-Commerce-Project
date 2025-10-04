@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12 scroll-animate">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 animate-fade-in-up">Contact Us</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 animate-fade-in-up" style="animation-delay: 0.2s;">We're here to help! Get in touch with our team</p>
        </div>

        <!-- Contact Form (Simplified) -->
        <section class="bg-gray-50 dark:bg-gray-900 mb-16">
            <div class="flex flex-col items-center justify-center px-4 py-8 mx-auto md:py-12">
                <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700 scroll-animate">
                    <div class="p-6 space-y-6 sm:p-8">
                        <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">Send us a Message</h2>
                        <form action="{{ url('/contact') }}" method="POST" class="space-y-4 md:space-y-6" autocomplete="off">
                            @csrf
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Name <span class="text-xs text-gray-500 dark:text-gray-400">(from your account)</span>
                                </label>
                                <input type="text" id="name" name="name" value="{{ session('auth.name', '') }}" class="bg-gray-100 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed" placeholder="Your name" readonly />
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Email <span class="text-xs text-gray-500 dark:text-gray-400">(from your account)</span>
                                </label>
                                <input type="email" id="email" name="email" value="{{ session('auth.email', '') }}" class="bg-gray-100 border border-gray-300 text-gray-900 rounded-lg block w-full p-2.5 dark:bg-gray-600 dark:border-gray-600 dark:text-gray-300 cursor-not-allowed" placeholder="your@email.com" readonly />
                            </div>
                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subject</label>
                                <input type="text" id="subject" name="subject" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="How can we help?" required />
                            </div>
                            <div>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
                                <textarea id="message" name="message" rows="6" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Describe your request..." required></textarea>
                            </div>
                            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-all duration-200 hover:scale-105">Send message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Information Card (Centered with Animation) -->
        <div class="max-w-2xl mx-auto mb-16 scroll-animate">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 hover:scale-105">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">Get in Touch</h2>
                
                <div class="space-y-6">
                    <!-- Address -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-200 group-hover:scale-110">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200">Address</h3>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-200">Gamaet Al Dowal Al Arabia St., Mohandessin, Giza, Egypt</p>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-200 group-hover:scale-110">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200">Phone</h3>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-200">+20 123 456 7890</p>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-200 group-hover:scale-110">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200">Email</h3>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-200">info@stylehaven.com</p>
                        </div>
                    </div>

                    <!-- Working Hours -->
                    <div class="flex items-start space-x-4 p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105 group">
                        <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-200 group-hover:scale-110">
                            <svg class="w-6 h-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-200">Working Hours</h3>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-200">Saturday - Thursday: 9 AM - 10 PM</p>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-200">Friday: 2 PM - 10 PM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 scroll-animate">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 text-center">Our Location</h2>
            <div class="rounded-lg overflow-hidden">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3453.130982388144!2d31.20575371511558!3d30.05610758187605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458411b3eacdf0b%3A0xd58a7b6b4d1b445f!2sGamaet%20Al%20Dowal%20Al%20Arabia%2C%20Al%20Mohandessin%2C%20Giza%20Governorate!5e0!3m2!1sen!2seg!4v1695907220000!5m2!1sen!2seg"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>

<style>
/* Enhanced scroll animations */
.scroll-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-animate.animate {
    opacity: 1;
    transform: translateY(0);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(30px);
    }
    50% {
        opacity: 0.7;
        transform: translateY(15px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Enhanced hover effects */
.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 300ms;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced scroll-triggered animations with intersection observer
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    // Observe all scroll-animate elements
    document.querySelectorAll('.scroll-animate').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endsection
