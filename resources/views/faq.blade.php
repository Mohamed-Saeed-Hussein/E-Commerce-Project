@extends('layouts.app')

@section('title', 'Frequently Asked Questions')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400">Find answers to common questions about Style Haven</p>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-8">
            <!-- FAQ Item 1 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">What is Style Haven?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Style Haven is your premier destination for trendy fashion and high-quality clothing. We offer a wide range of stylish apparel and accessories for every occasion, from casual everyday wear to special events.
                </p>
            </div>

            <!-- FAQ Item 2 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">How do I place an order?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Placing an order is simple! Browse our catalog, select your desired items, add them to your cart, and proceed to checkout. You'll need to create an account or sign in to complete your purchase.
                </p>
            </div>

            <!-- FAQ Item 3 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">What payment methods do you accept?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and other secure payment methods. All transactions are encrypted and secure.
                </p>
            </div>

            <!-- FAQ Item 4 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">How long does shipping take?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Standard shipping typically takes 3-5 business days. Express shipping options are available for faster delivery. You'll receive a tracking number once your order ships.
                </p>
            </div>

            <!-- FAQ Item 5 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">What is your return policy?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    We offer a 30-day return policy for unworn items with original tags. Returns are free and easy - just contact our customer service team to initiate a return.
                </p>
            </div>

            <!-- FAQ Item 6 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">How do I track my order?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Once your order ships, you'll receive an email with a tracking number. You can also track your order by logging into your account and viewing your order history.
                </p>
            </div>

            <!-- FAQ Item 7 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Do you offer international shipping?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Currently, we ship within the United States and select international destinations. Please contact us for specific shipping information to your country.
                </p>
            </div>

            <!-- FAQ Item 8 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">How do I contact customer service?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    You can reach our customer service team through our <a href="{{ url('/contact') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300 transition-colors duration-200">contact page</a>, email, or phone. We're here to help Monday through Friday, 9 AM to 6 PM.
                </p>
            </div>

            <!-- FAQ Item 9 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Are your products authentic?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Yes, all our products are 100% authentic. We work directly with trusted suppliers and brands to ensure the highest quality and authenticity of every item we sell.
                </p>
            </div>

            <!-- FAQ Item 10 -->
            <div class="faq-item bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 opacity-0 transform translate-y-8 transition-all duration-700">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">Do you have a size guide?</h3>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                    Yes! Each product page includes detailed size charts and measurements. We recommend checking the size guide before making a purchase to ensure the perfect fit.
                </p>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="text-center mt-16">
            <div class="bg-primary-50 dark:bg-primary-900/20 rounded-lg p-8">
                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4">Still have questions?</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Can't find what you're looking for? Our customer service team is here to help!</p>
                <a href="{{ url('/contact') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-medium rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    Contact Us
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const faqItems = document.querySelectorAll('.faq-item');

        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        faqItems.forEach(item => {
            observer.observe(item);
        });
    });
</script>
@endsection