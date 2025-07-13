@extends('layouts.app')

@section('title', 'News - Veloxis Legends')

@section('content')
<div class="max-w-7xl mx-auto py-8">
    <h2 class="text-3xl font-bold mb-2 text-center">Latest News</h2>
    <p class="text-center text-gray-500 mb-8">Stay updated with the latest from Veloxis Legends</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($news as $item)
        <div class="bg-white rounded-lg shadow p-5 flex flex-col">
            <img 
                src="{{ $item->image ? asset('storage/news/' . $item->image) : asset('images/news-default.jpg') }}" 
                alt="{{ $item->title }}" 
                class="w-full h-40 object-cover rounded-t mb-4"
                onerror="this.onerror=null;this.src='{{ asset('images/news-default.jpg') }}';"
            >
            <div class="flex-1 flex flex-col">
                <div class="flex items-center justify-between text-xs text-gray-500 mb-2">
                    <span>Veloxis Team</span>
                    <span>{{ $item->created_at->format('M d, Y') }}</span>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $item->title }}</h3>
                <p class="text-gray-700 text-sm mb-3 line-clamp-3">{{ $item->excerpt ?? Str::limit($item->content, 100) }}</p>
                <a href="{{ route('news.show', $item) }}" class="mt-auto text-red-500 hover:text-red-700 font-semibold text-sm flex items-center gap-1">
                    Read More <span class="ml-1">&rarr;</span>
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @if($news->hasPages())
    <div class="mt-8">
        {{ $news->links() }}
    </div>
    @endif
</div>
@endsection 