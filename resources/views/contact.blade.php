@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
 

        <!-- Contact Form (Auth-like styling, centered) -->
        <section class="bg-gray-50 dark:bg-gray-900">
            <div class="flex flex-col items-center justify-center px-4 py-8 mx-auto md:py-12">
                <div class="w-full bg-white rounded-lg shadow dark:border sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-6 sm:p-8">
                        <h2 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">Contact Us</h2>
                        <p class="text-sm text-gray-600 dark:text-gray-400 text-center">>We're here to help! Get in touch with our team</p>
                        <form action="{{ url('/contact') }}" method="POST" class="space-y-4 md:space-y-6" autocomplete="off">
                            @csrf
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
                                <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="John Doe" required>
                            </div>
                            <div>
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
                                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="name@company.com" required>
                            </div>
                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subject</label>
                                <input type="text" id="subject" name="subject" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="How can we help?" />
                            </div>
                            <div>
                                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
                                <textarea id="message" name="message" rows="6" class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" placeholder="Describe your request..." required></textarea>
                            </div>
                            <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Send message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Information (rows) -->
        <div class="mt-16 max-w-3xl mx-auto space-y-4">
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md flex items-start space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Address</h3>
                    <p class="text-gray-600 dark:text-gray-400">Gamaet Al Dowal Al Arabia St., Mohandessin, Giza, Egypt</p>
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md flex items-start space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Phone</h3>
                    <p class="text-gray-600 dark:text-gray-400">+20 123 456 7890</p>
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md flex items-start space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Email</h3>
                    <p class="text-gray-600 dark:text-gray-400">info@stylehaven.com</p>
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-md flex items-start space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Working Hours</h3>
                    <p class="text-gray-600 dark:text-gray-400">Saturday - Thursday: 9 AM - 10 PM</p>
                    <p class="text-gray-600 dark:text-gray-400">Friday: 2 PM - 10 PM</p>
                </div>
            </div>
        </div>

        <!-- Map Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
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
@endsection
