@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16 scroll-animate">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 animate-fade-in-up">About Style Haven</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 animate-fade-in-up" style="animation-delay: 0.2s;">Discover our story, mission, and the passionate team behind your trusted fashion destination</p>
        </div>

        <!-- Our Story Section -->
        <div class="mb-16 scroll-animate">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-300 group">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Our Story</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-6 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                    Style Haven was born from a simple yet powerful vision: to make high-quality, trendy fashion accessible to everyone.
                    Founded in 2019, we started as a small online boutique with a curated selection of carefully chosen pieces.
                    Today, we've grown into a comprehensive fashion platform that serves thousands of customers worldwide.
                </p>
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                    Our journey began when our founders noticed a gap in the market for affordable, stylish clothing that doesn't compromise on quality.
                    We set out to bridge that gap, creating a shopping experience that combines the latest trends with exceptional value and outstanding customer service.
                </p>
            </div>
        </div>

        <!-- Mission & Values -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <div class="scroll-animate">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-300 group h-full flex flex-col">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Our Mission</h2>
                    <div class="flex-1 flex flex-col justify-center">
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                            To empower individuals to express their unique style through high-quality, affordable fashion that makes them look and feel confident.
                        </p>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                            We believe that great style shouldn't come with a hefty price tag, and everyone deserves access to clothing that reflects their personality and lifestyle.
                        </p>
                    </div>
                </div>
            </div>

            <div class="scroll-animate">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-300 group h-full flex flex-col">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Our Values</h2>
                    <div class="flex-1 flex flex-col justify-center">
                        <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                                <span class="text-primary-600 dark:text-primary-400 mr-3 group-hover:scale-110 transition-transform duration-300">•</span>
                                <span><strong>Quality First:</strong> Every piece is carefully selected for durability and style</span>
                            </li>
                            <li class="flex items-start group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                                <span class="text-primary-600 dark:text-primary-400 mr-3 group-hover:scale-110 transition-transform duration-300">•</span>
                                <span><strong>Customer-Centric:</strong> Your satisfaction is our top priority</span>
                            </li>
                            <li class="flex items-start group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                                <span class="text-primary-600 dark:text-primary-400 mr-3 group-hover:scale-110 transition-transform duration-300">•</span>
                                <span><strong>Sustainability:</strong> Committed to responsible fashion practices</span>
                            </li>
                            <li class="flex items-start group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">
                                <span class="text-primary-600 dark:text-primary-400 mr-3 group-hover:scale-110 transition-transform duration-300">•</span>
                                <span><strong>Innovation:</strong> Constantly evolving to meet your needs</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mb-16 scroll-animate">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8 text-center animate-fade-in-up">What We Offer</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-300 group scroll-animate">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Curated Collections</h3>
                        <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Handpicked pieces that represent the latest trends and timeless classics</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-300 group scroll-animate">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Affordable Prices</h3>
                        <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Quality fashion at prices that won't break the bank</p>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl hover:scale-105 transition-all duration-300 group scroll-animate">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Fast Shipping</h3>
                        <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Quick and reliable delivery to your doorstep</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16 scroll-animate">
            <div class="text-center mb-12 scroll-animate">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4 animate-fade-in-up">Meet Our Team</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400 animate-fade-in-up" style="animation-delay: 0.2s;">The passionate individuals behind Style Haven</p>
            </div>

            <!-- Team Leader -->
            <div class="mb-12 scroll-animate">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8 text-center animate-fade-in-up">Leadership</h3>
                <div class="flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-md w-full hover:shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="text-center">
                            <div class="w-32 h-32 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-4xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">MSH</span>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Mohamed Saeed Hussein</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-4 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">Team Leader & Back-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Leading our technical vision and ensuring robust backend infrastructure for seamless user experiences.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Front-End Team -->
            <div class="mb-12 scroll-animate">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8 text-center animate-fade-in-up">Front-End Development</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 group scroll-animate">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">MSA</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Mohamed Saeed Abdelmawjoud</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-3 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">Front-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Creating beautiful and responsive user interfaces that bring our designs to life.</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 group scroll-animate">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">RSE</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Rahma Saeed Eldaly</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-3 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">Front-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Focusing on user experience and creating intuitive interfaces that customers love.</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl hover:scale-105 transition-all duration-300 group scroll-animate">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">AMA</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Ahmed Magdy Abdelmoneim</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-3 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">Front-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Implementing modern web technologies to deliver fast and engaging user experiences.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testing Team -->
            <div class="mb-12 scroll-animate">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8 text-center animate-fade-in-up">Quality Assurance</h3>
                <div class="flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-md w-full hover:shadow-xl hover:scale-105 transition-all duration-300 group">
                        <div class="text-center">
                            <div class="w-32 h-32 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:bg-primary-200 dark:group-hover:bg-primary-800/50 transition-colors duration-300 group-hover:scale-110 transition-transform duration-300">
                                <span class="text-4xl font-bold text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">IAI</span>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Ibrahim Ashraf Ibrahim</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-4 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300">Quality Assurance Tester</p>
                            <p class="text-gray-600 dark:text-gray-400 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Ensuring every feature works perfectly and maintaining the highest quality standards across our platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center scroll-animate">
            <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-8 hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors duration-300 group">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Ready to Start Shopping?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 group-hover:text-gray-700 dark:group-hover:text-gray-300 transition-colors duration-300">Explore our curated collection and find your perfect style today!</p>
                <a href="{{ url('/catalog') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 hover:scale-105 transition-all duration-300 group">
                    Browse Products
                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

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
                    // Add staggered animation for child elements
                    const children = entry.target.querySelectorAll('.scroll-animate');
                    children.forEach((child, index) => {
                        setTimeout(() => {
                            child.classList.add('animate');
                        }, index * 150);
                    });
                } else {
                    // Keep animations running - don't remove animate class
                    // This ensures animations persist while on the page
                }
            });
        }, observerOptions);

        // Observe all scroll-animate elements
        document.querySelectorAll('.scroll-animate').forEach(el => {
            observer.observe(el);
        });

        // Add smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';

        // Continuous animation loop for persistent effects
        function continuousAnimations() {
            document.querySelectorAll('.scroll-animate').forEach((el, index) => {
                // Add subtle continuous animation
                setTimeout(() => {
                    if (el.classList.contains('animate')) {
                        el.style.animation = `fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards`;
                    }
                }, index * 200);
            });
        }

        // Run continuous animations every 3 seconds
        setInterval(continuousAnimations, 3000);

        // Position-based scroll animations
        let ticking = false;

        function updateScrollPosition() {
            document.querySelectorAll('.scroll-animate').forEach((el, index) => {
                const rect = el.getBoundingClientRect();
                const windowHeight = window.innerHeight;

                // Calculate visibility percentage based on scroll position
                const elementTop = rect.top;
                const elementHeight = rect.height;
                const elementCenter = elementTop + (elementHeight / 2);
                const windowCenter = windowHeight / 2;

                // Calculate distance from center of viewport
                const distanceFromCenter = Math.abs(elementCenter - windowCenter);
                const maxDistance = windowHeight / 2 + elementHeight / 2;

                // Calculate opacity and transform based on position
                const visibilityRatio = Math.max(0, 1 - (distanceFromCenter / maxDistance));
                const opacity = Math.max(0.1, visibilityRatio);
                const translateY = (1 - visibilityRatio) * 50;
                const scale = 0.8 + (visibilityRatio * 0.2);

                // Apply position-based styles
                el.style.opacity = opacity;
                el.style.transform = `translateY(${translateY}px) scale(${scale})`;

                // Add animate class when element is in view
                if (rect.top < windowHeight && rect.bottom > 0) {
                    el.classList.add('animate');
                } else {
                    el.classList.remove('animate');
                }
            });

            ticking = false;
        }

        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateScrollPosition);
                ticking = true;
            }
        }

        window.addEventListener('scroll', requestTick);
    });
</script>

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

    /* Position-based scroll animations */
    .scroll-animate {
        opacity: 0.1;
        transform: translateY(50px) scale(0.8);
        transition: opacity 0.3s ease-out, transform 0.3s ease-out;
    }

    .scroll-animate.animate {
        /* Animation properties are now controlled by JavaScript based on scroll position */
    }

    /* Enhanced hover effects */
    .group:hover .group-hover\:scale-110 {
        transform: scale(1.1);
    }

    .group:hover .group-hover\:translate-x-1 {
        transform: translateX(0.25rem);
    }

    /* Individual card animations for "What We Offer" */
    .scroll-animate:nth-child(1) {
        animation-delay: 0.1s;
    }

    .scroll-animate:nth-child(2) {
        animation-delay: 0.3s;
    }

    .scroll-animate:nth-child(3) {
        animation-delay: 0.5s;
    }

    .scroll-animate:nth-child(4) {
        animation-delay: 0.7s;
    }

    .scroll-animate:nth-child(5) {
        animation-delay: 0.9s;
    }

    .scroll-animate:nth-child(6) {
        animation-delay: 1.1s;
    }

    /* Consistent card sizing for comfortable visual appearance */
    .grid .scroll-animate {
        min-height: 300px;
        display: flex;
        flex-direction: column;
    }

    .grid .scroll-animate .text-center {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 1.5rem;
    }

    .grid .scroll-animate h3 {
        min-height: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .grid .scroll-animate p {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        line-height: 1.6;
        font-size: 0.95rem;
    }

    /* Ensure equal height for all cards in grid */
    .grid {
        align-items: stretch;
    }

    .grid>* {
        height: 100%;
    }

    /* Icon container sizing */
    .grid .scroll-animate .w-16 {
        width: 4rem;
        height: 4rem;
        margin-bottom: 1.5rem;
    }

    /* Smooth transitions for all interactive elements */
    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 300ms;
    }

    /* Enhanced card hover effects */
    .group:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .dark .group:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection