@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">About Style Haven</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">Discover our story, mission, and the passionate team behind your favorite fashion destination</p>
        </div>

        <!-- Our Story Section -->
        <div class="mb-16">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-200">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-6">Our Story</h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                    Style Haven was born from a simple yet powerful vision: to make high-quality, trendy fashion accessible to everyone. 
                    Founded in 2019, we started as a small online boutique with a curated selection of carefully chosen pieces. 
                    Today, we've grown into a comprehensive fashion platform that serves thousands of customers worldwide.
                </p>
                <p class="text-lg text-gray-600 dark:text-gray-400 leading-relaxed">
                    Our journey began when our founders noticed a gap in the market for affordable, stylish clothing that doesn't compromise on quality. 
                    We set out to bridge that gap, creating a shopping experience that combines the latest trends with exceptional value and outstanding customer service.
                </p>
            </div>
        </div>

        <!-- Mission & Values -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-200">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Our Mission</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                    To empower individuals to express their unique style through high-quality, affordable fashion that makes them look and feel confident.
                </p>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    We believe that great style shouldn't come with a hefty price tag, and everyone deserves access to clothing that reflects their personality and lifestyle.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-200">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-6">Our Values</h2>
                <ul class="space-y-3 text-gray-600 dark:text-gray-400">
                    <li class="flex items-start">
                        <span class="text-primary-600 dark:text-primary-400 mr-3">•</span>
                        <span><strong>Quality First:</strong> Every piece is carefully selected for durability and style</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary-600 dark:text-primary-400 mr-3">•</span>
                        <span><strong>Customer-Centric:</strong> Your satisfaction is our top priority</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary-600 dark:text-primary-400 mr-3">•</span>
                        <span><strong>Sustainability:</strong> Committed to responsible fashion practices</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-primary-600 dark:text-primary-400 mr-3">•</span>
                        <span><strong>Innovation:</strong> Constantly evolving to meet your needs</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Services Section -->
        <div class="mb-16">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 hover:shadow-xl transition-shadow duration-200">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-8 text-center">What We Offer</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Curated Collections</h3>
                        <p class="text-gray-600 dark:text-gray-400">Handpicked pieces that represent the latest trends and timeless classics</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Affordable Prices</h3>
                        <p class="text-gray-600 dark:text-gray-400">Quality fashion at prices that won't break the bank</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Fast Shipping</h3>
                        <p class="text-gray-600 dark:text-gray-400">Quick and reliable delivery to your doorstep</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Section -->
        <div class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-semibold text-gray-900 dark:text-white mb-4">Meet Our Team</h2>
                <p class="text-xl text-gray-600 dark:text-gray-400">The passionate individuals behind Style Haven</p>
            </div>

            <!-- Team Leader -->
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8 text-center">Leadership</h3>
                <div class="flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-md w-full hover:shadow-xl transition-shadow duration-200">
                        <div class="text-center">
                            <div class="w-32 h-32 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="text-4xl font-bold text-primary-600 dark:text-primary-400">MSH</span>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Mohamed Saeed Hussein</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-4">Team Leader & Back-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400">Leading our technical vision and ensuring robust backend infrastructure for seamless user experiences.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Front-End Team -->
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8 text-center">Front-End Development</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-200">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">MSA</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Mohamed Saeed Abdelmawjoud</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-3">Front-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Creating beautiful and responsive user interfaces that bring our designs to life.</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-200">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">RSE</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Rahma Saeed Eldaly</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-3">Front-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Focusing on user experience and creating intuitive interfaces that customers love.</p>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow duration-200">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">AMA</span>
                            </div>
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Ahmed Magdy Abdelmoneim</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-3">Front-End Developer</p>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">Implementing modern web technologies to deliver fast and engaging user experiences.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testing Team -->
            <div class="mb-12">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-8 text-center">Quality Assurance</h3>
                <div class="flex justify-center">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8 max-w-md w-full hover:shadow-xl transition-shadow duration-200">
                        <div class="text-center">
                            <div class="w-32 h-32 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                                <span class="text-4xl font-bold text-primary-600 dark:text-primary-400">IAI</span>
                            </div>
                            <h4 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Ibrahim Ashraf Ibrahim</h4>
                            <p class="text-primary-600 dark:text-primary-400 font-medium mb-4">Quality Assurance Tester</p>
                            <p class="text-gray-600 dark:text-gray-400">Ensuring every feature works perfectly and maintaining the highest quality standards across our platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center">
            <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Ready to Start Shopping?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Explore our curated collection and find your perfect style today!</p>
                <a href="{{ url('/catalog') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    Browse Products
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection


