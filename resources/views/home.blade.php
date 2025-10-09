@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="py-16 bg-white dark:bg-gray-800">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-primary-600 to-primary-800 overflow-hidden">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-primary-600 to-primary-800 mix-blend-multiply"></div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <div class="animate-fade-in-up">
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Elevate Your Everyday Style
                </h1>
                <p class="mt-6 max-w-3xl text-xl text-primary-100">
                    Style Haven is a thoughtfully curated destination for modern fashion and lifestyle essentials.
                    We champion timeless design, responsible sourcing, and a seamless customer experience—so you can shop
                    with confidence and wear with pride.
                </p>
                <div class="mt-10">
                    <a href="{{ url('/catalog') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary-700 bg-white hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                        Shop Now
                        <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center scroll-animate">
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl">
                    What Sets Style Haven Apart
                </h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 dark:text-gray-400 mx-auto">
                    We combine elevated design with dependable service and transparent values.
                </p>
            </div>

            <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center scroll-animate group cursor-pointer hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-100 dark:bg-primary-900 mx-auto group-hover:bg-primary-200 dark:group-hover:bg-primary-800 transition-all duration-300 transform group-hover:scale-110">
                        <svg class="h-6 w-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Fast, Reliable Shipping</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Trackable delivery partners and well‑packaged orders, dispatched quickly.</p>
                </div>

                <div class="text-center scroll-animate group cursor-pointer hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-100 dark:bg-primary-900 mx-auto group-hover:bg-primary-200 dark:group-hover:bg-primary-800 transition-all duration-300 transform group-hover:scale-110">
                        <svg class="h-6 w-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Considered Quality</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Materials and craftsmanship selected for comfort, durability, and fit.</p>
                </div>

                <div class="text-center scroll-animate group cursor-pointer hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-100 dark:bg-primary-900 mx-auto group-hover:bg-primary-200 dark:group-hover:bg-primary-800 transition-all duration-300 transform group-hover:scale-110">
                        <svg class="h-6 w-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Hassle‑Free Returns</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Simple returns window with responsive support—no run‑around.</p>
                </div>

                <div class="text-center scroll-animate group cursor-pointer hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center justify-center h-12 w-12 rounded-md bg-primary-100 dark:bg-primary-900 mx-auto group-hover:bg-primary-200 dark:group-hover:bg-primary-800 transition-all duration-300 transform group-hover:scale-110">
                        <svg class="h-6 w-6 text-primary-600 dark:text-primary-400 group-hover:text-primary-700 dark:group-hover:text-primary-300 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z" />
                        </svg>
                    </div>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-300">Human Support</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-300">Real people, real help—before and after you order.</p>
                </div>
            </div>
        </div>
    </div>


	<!-- Value Pillars -->
	<div class="py-16 bg-white dark:bg-gray-800">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white text-center scroll-animate">The Style Haven Standard</h2>
			<p class="mt-3 max-w-3xl mx-auto text-center text-gray-600 dark:text-gray-300">Six principles guide everything we make, source, and ship.</p>
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-900 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Design Without Noise</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Timeless silhouettes and considered details—built to outlast trends.</p>
				</div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-900 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Responsibly Sourced</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Vendor partners audited for quality, labor practices, and material traceability.</p>
				</div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-900 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Made To Wear</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Comfortable fits, durable stitching, and fabric hand‑feel that earns repeat wear.</p>
				</div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-900 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Clear Pricing</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">No artificial markups or flash‑sale gimmicks—just fair value year‑round.</p>
				</div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-900 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Fast Fulfillment</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Most orders leave our warehouse within 48 hours with end‑to‑end tracking.</p>
				</div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6 bg-white dark:bg-gray-900 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<h3 class="text-lg font-semibold text-gray-900 dark:text-white">Human Support</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Care from real people who can actually solve problems—quickly.</p>
				</div>
			</div>
		</div>
	</div>

    <!-- How We Work -->
    <div class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                <div class="lg:col-span-12 text-center scroll-animate">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white">How We Work</h2>
                    <p class="mt-4 text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">From selection to post‑purchase, our process is designed to remove friction and add value.</p>
                </div>
                <div class="lg:col-span-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
						<div class="text-primary-600 dark:text-primary-400 text-sm font-semibold">01 • Curate</div>
						<p class="mt-2 text-gray-700 dark:text-gray-300">We review every item for construction, materials, and fit before it hits the catalog.</p>
					</div>
                    <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
						<div class="text-primary-600 dark:text-primary-400 text-sm font-semibold">02 • Validate</div>
						<p class="mt-2 text-gray-700 dark:text-gray-300">Early customer testing and feedback loops ensure the pieces perform in real life.</p>
					</div>
                    <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
						<div class="text-primary-600 dark:text-primary-400 text-sm font-semibold">03 • Fulfill</div>
						<p class="mt-2 text-gray-700 dark:text-gray-300">Orders are packed with care and shipped quickly, with proactive notifications.</p>
					</div>
                    <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
						<div class="text-primary-600 dark:text-primary-400 text-sm font-semibold">04 • Support</div>
						<p class="mt-2 text-gray-700 dark:text-gray-300">Our team resolves issues fast and uses insights to improve future drops.</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Assortment Snapshot -->
	<div class="py-16 bg-white dark:bg-gray-800">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white text-center">What You’ll Find</h2>
			<p class="mt-3 max-w-3xl mx-auto text-center text-gray-600 dark:text-gray-300">A versatile assortment for workdays, weekends, and everything between.</p>
			<div class="mt-8 flex flex-wrap gap-3 justify-center">
				<span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">Everyday Basics</span>
				<span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">Elevated Essentials</span>
				<span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">Seasonal Layers</span>
				<span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">Occasionwear</span>
				<span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">Accessories</span>
				<span class="px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm">Limited Drops</span>
			</div>
		</div>
	</div>

	<!-- Testimonials -->
	<div class="py-16 bg-gray-50 dark:bg-gray-900">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white text-center">What Customers Say</h2>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<p class="text-gray-700 dark:text-gray-300">“Quality is unreal for the price. Shipping updates were spot‑on and the fit guide was accurate.”</p>
					<p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Samir • Repeat customer</p>
				</div>
                <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<p class="text-gray-700 dark:text-gray-300">“Clean designs that actually last. Their support solved a sizing swap in minutes.”</p>
					<p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Elena • First‑time buyer</p>
				</div>
                <div class="rounded-lg bg-white dark:bg-gray-800 shadow p-6 scroll-animate hover:shadow-lg transition-transform duration-300 transform hover:-translate-y-1">
					<p class="text-gray-700 dark:text-gray-300">“My third order—consistent experience every time. Big fan of the returns process.”</p>
					<p class="mt-3 text-sm text-gray-500 dark:text-gray-400">Marcus • Member</p>
				</div>
			</div>
		</div>
	</div>

	<!-- FAQ Preview -->
	<div class="py-16 bg-white dark:bg-gray-800">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white text-center">FAQs</h2>
			<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
				<div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6">
					<h3 class="font-semibold text-gray-900 dark:text-white">How fast is shipping?</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Most orders dispatch within 48 hours and arrive in 2–6 business days depending on destination.</p>
				</div>
				<div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6">
					<h3 class="font-semibold text-gray-900 dark:text-white">What’s your return policy?</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">We offer a 15‑day window for returns in original condition. Start a return from your account.</p>
				</div>
				<div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6">
					<h3 class="font-semibold text-gray-900 dark:text-white">How do you size your garments?</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Size charts on each product page include precise measurements and guidance by fit.</p>
				</div>
				<div class="rounded-lg border border-gray-200 dark:border-gray-700 p-6">
					<h3 class="font-semibold text-gray-900 dark:text-white">Do you restock popular items?</h3>
					<p class="mt-2 text-gray-600 dark:text-gray-300">Yes—sign up for restock alerts on the product page to be notified first.</p>
				</div>
			</div>
			<div class="mt-8 text-center">
				<a href="{{ url('/faq') }}" class="inline-flex items-center px-6 py-3 rounded-md bg-primary-600 hover:bg-primary-700 text-white font-medium transition-colors">View all FAQs</a>
			</div>
		</div>
            </div>

	<!-- Final CTA -->
	<div class="py-16 bg-gray-50 dark:bg-gray-900">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="rounded-2xl bg-gradient-to-r from-primary-600 to-primary-700 p-8 sm:p-12 text-center">
				<h2 class="text-3xl font-extrabold text-white">Discover pieces you’ll keep reaching for</h2>
				<p class="mt-3 text-primary-100 max-w-2xl mx-auto">Explore our latest arrivals and build a wardrobe that works every day.</p>
				<div class="mt-8">
					<a href="{{ url('/catalog') }}" class="inline-flex items-center px-6 py-3 bg-white text-primary-700 rounded-md font-medium hover:bg-gray-50 transition">
						Shop the Collection
                    <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
			</div>
        </div>
    </div>
</div>
@endsection
