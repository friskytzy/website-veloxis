@extends('layouts.app')

@section('title', 'Events - Veloxis Legends')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-oswald font-bold mb-4">Community Events</h1>
        <p class="text-gray-300 text-lg">Join our community and participate in exciting events</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
        <article class="bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-red-600 transition-shadow duration-300">
            <img alt="{{ $event->title }}" class="w-full h-48 object-cover" src="{{ $event->image }}"/>
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-red-600 font-semibold">{{ $event->start_date->format('M d, Y') }}</span>
                    @if($event->max_participants)
                        <span class="text-gray-400 text-sm">{{ $event->max_participants }} participants max</span>
                    @endif
                </div>
                <h3 class="text-xl font-oswald font-semibold mb-3">{{ $event->title }}</h3>
                <p class="text-gray-300 mb-2">{{ Str::limit($event->description, 100) }}</p>
                <p class="text-gray-400 text-sm mb-4">{{ $event->location }}</p>
                <a href="{{ route('events.show', $event->id) }}" 
                   class="text-red-600 hover:text-red-700 font-semibold inline-flex items-center">
                    Learn More
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($events->hasPages())
    <div class="mt-8">
        {{ $events->links() }}
    </div>
    @endif
</div>
@endsection 