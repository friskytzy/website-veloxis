@extends('layouts.app')

@section('title', 'Veloxis Legends - Ride the Freedom')

@section('content')
<!-- Hero Section -->
<header class="relative bg-gray-900 pt-24 pb-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center md:items-start">
        <div class="md:w-1/2 text-center md:text-left">
            <h1 class="text-5xl md:text-6xl font-oswald font-bold leading-tight mb-6 tracking-wide">
                Ride the Freedom
                <br/>
                <span class="text-red-600">Veloxis Legends</span>
            </h1>
            <p class="text-gray-300 text-lg md:text-xl mb-8 max-w-lg">
                Discover the ultimate motorcycle experience. From classic cruisers to modern beasts, gear up and join the community of riders who live for the open road.
            </p>
            <a class="inline-block bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg transition duration-300" href="{{ route('products.bikes') }}">
                Explore Bikes
            </a>
        </div>
        <div class="md:w-1/2 mt-12 md:mt-0 flex justify-center">
            <img alt="Motorcycle rider cruising on an open road at sunset with mountains in the background, warm orange and purple sky" class="rounded-xl shadow-2xl max-w-full h-auto" height="400" src="https://storage.googleapis.com/a1aa/image/8874ec7d-472e-49a5-a768-2169479ef098.jpg" width="600"/>
        </div>
    </div>
    <svg class="absolute bottom-0 left-0 w-full" fill="none" viewbox="0 0 1440 320" xmlns="http://www.w3.org/2000/svg">
        <path d="M0,224L48,197.3C96,171,192,117,288,117.3C384,117,480,171,576,197.3C672,224,768,224,864,197.3C960,171,1056,117,1152,117.3C1248,117,1344,171,1392,197.3L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z" fill="#111827" fill-opacity="1"></path>
    </svg>
</header>

<!-- Bikes Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20" id="bikes">
    <h2 class="text-4xl font-oswald font-bold text-center mb-12 tracking-wide">Our Bikes</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach($featuredBikes as $bike)
        <article class="bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-red-600 transition-shadow duration-300">
            <img alt="{{ $bike->name }}" class="w-full h-48 object-cover" src="{{ asset('storage/' . $bike->image) }}"/>
            <div class="p-6">
                <h3 class="text-2xl font-oswald font-semibold mb-2">{{ $bike->name }}</h3>
                <p class="text-gray-300 mb-4">{{ $bike->description }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-red-600 font-bold text-xl">${{ number_format($bike->price, 2) }}</span>
                    <a class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center" href="{{ url('/products/bikes/' . $bike->id) }}">
                        Learn More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </article>
        @endforeach
    </div>
</section>

<!-- Gear Section -->
<section class="bg-gray-800 py-20" id="gear">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-oswald font-bold text-center mb-12 tracking-wide text-white">Gear Up</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
            @foreach($featuredGear as $gear)
            <div class="bg-gray-900 rounded-xl shadow-lg overflow-hidden hover:shadow-red-600 transition-shadow duration-300 flex flex-col items-center p-6">
                <img alt="{{ $gear->name }}" class="w-40 h-40 object-cover rounded-lg mb-4" src="{{ asset('storage/' . $gear->image) }}"/>
                <h3 class="text-xl font-oswald font-semibold mb-2 text-center">{{ $gear->name }}</h3>
                <p class="text-gray-400 text-center mb-4">{{ $gear->description }}</p>
                <div class="flex justify-between items-center w-full">
                    <span class="text-red-600 font-bold">${{ number_format($gear->price, 2) }}</span>
                    <a class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center" href="{{ url('/products/gear/' . $gear->id) }}">
                        Shop Now
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Community Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20" id="community">
    <h2 class="text-4xl font-oswald font-bold text-center mb-12 tracking-wide">Join the Community</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
        <div class="bg-gray-800 rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-red-600 transition-shadow duration-300">
            <img alt="Group of motorcyclists riding together on a scenic highway with mountains and blue sky" class="rounded-full mb-6 w-36 h-36 object-cover" src="https://storage.googleapis.com/a1aa/image/d12cb247-0d44-45e2-2619-aa1c3c00f5fe.jpg"/>
            <h3 class="text-2xl font-oswald font-semibold mb-3">Rides & Events</h3>
            <p class="text-gray-300 mb-4">Join our monthly rides and meet fellow riders who share your passion.</p>
            <a class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center" href="{{ route('events.index') }}">
                See Upcoming Events
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="bg-gray-800 rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-red-600 transition-shadow duration-300">
            <img alt="Motorcycle mechanic working on a bike in a well-equipped garage with tools and parts" class="rounded-full mb-6 w-36 h-36 object-cover" src="https://storage.googleapis.com/a1aa/image/98ce8684-c85b-4fd0-2b56-b01af7483b56.jpg"/>
            <h3 class="text-2xl font-oswald font-semibold mb-3">Workshops</h3>
            <p class="text-gray-300 mb-4">Learn maintenance, customization, and repair skills from the pros.</p>
            <a class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center" href="{{ route('events.index') }}">
                Join a Workshop
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="bg-gray-800 rounded-xl shadow-lg p-8 flex flex-col items-center text-center hover:shadow-red-600 transition-shadow duration-300">
            <img alt="Close-up of hands typing on laptop keyboard with motorcycle forum website on screen" class="rounded-full mb-6 w-36 h-36 object-cover" src="https://storage.googleapis.com/a1aa/image/d453342e-efab-46db-3a98-ae9702955dbd.jpg"/>
            <h3 class="text-2xl font-oswald font-semibold mb-3">Online Forum</h3>
            <p class="text-gray-300 mb-4">Connect, share stories, and get advice from riders worldwide.</p>
            <a class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center" href="#">
                Visit the Forum
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="bg-gray-800 py-20" id="news">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-oswald font-bold text-center mb-12 tracking-wide text-white">Latest News</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            @foreach($latestNews as $news)
            <article class="bg-gray-900 rounded-xl shadow-lg overflow-hidden hover:shadow-red-600 transition-shadow duration-300">
                <img alt="{{ $news->title }}" class="w-full h-48 object-cover" src="{{ asset('storage/' . $news->image) }}"/>
                <div class="p-6">
                    <h3 class="text-2xl font-oswald font-semibold mb-2">{{ $news->title }}</h3>
                    <p class="text-gray-400 mb-4">{{ Str::limit($news->content, 100) }}</p>
                    <a class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center" href="{{ route('news.show', $news->id) }}">
                        Read More
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20" id="contact">
    <h2 class="text-4xl font-oswald font-bold text-center mb-12 tracking-wide">Get in Touch</h2>
    <div class="max-w-3xl mx-auto bg-gray-800 rounded-xl shadow-lg p-10">
        <form action="{{ route('contact.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label class="block text-gray-300 font-semibold mb-2" for="name">Name</label>
                <input class="w-full rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-600" id="name" name="name" placeholder="Your full name" required type="text"/>
            </div>
            <div>
                <label class="block text-gray-300 font-semibold mb-2" for="email">Email</label>
                <input class="w-full rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-600" id="email" name="email" placeholder="you@example.com" required type="email"/>
            </div>
            <div>
                <label class="block text-gray-300 font-semibold mb-2" for="message">Message</label>
                <textarea class="w-full rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-600" id="message" name="message" placeholder="Write your message here..." required rows="5"></textarea>
            </div>
            <button class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-4 rounded-lg shadow-lg transition duration-300" type="submit">
                Send Message
            </button>
        </form>
    </div>
</section>
@endsection 