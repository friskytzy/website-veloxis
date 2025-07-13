@extends('layouts.app')

@section('title', 'Bikes - Veloxis Legends')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-oswald font-bold mb-4">Our Bikes</h1>
        <p class="text-gray-300 text-lg">Discover the perfect ride for your journey</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-gray-800 rounded-xl p-6 mb-8">
        <form method="GET" action="{{ route('products.bikes') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-gray-300 font-semibold mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                       placeholder="Search bikes...">
            </div>
            <div>
                <label class="block text-gray-300 font-semibold mb-2">Category</label>
                <select name="category" class="w-full rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-gray-300 font-semibold mb-2">Price Range</label>
                <div class="flex space-x-2">
                    <input type="number" name="min_price" value="{{ request('min_price') }}" 
                           class="w-1/2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                           placeholder="Min">
                    <input type="number" name="max_price" value="{{ request('max_price') }}" 
                           class="w-1/2 rounded-md bg-gray-700 border border-gray-600 text-gray-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-600"
                           placeholder="Max">
                </div>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @foreach($bikes as $bike)
        <article class="bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-red-600 transition-shadow duration-300">
            <img alt="{{ $bike->name }}" class="w-full h-48 object-cover" src="{{ $bike->image_url }}"/>
            <div class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="text-xl font-oswald font-semibold">{{ $bike->name }}</h3>
                    @if($bike->is_featured)
                        <span class="bg-red-600 text-white text-xs px-2 py-1 rounded">Featured</span>
                    @endif
                </div>
                <p class="text-gray-300 mb-4 text-sm">{{ Str::limit($bike->description, 100) }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-red-600 font-bold text-xl">Rp {{ number_format($bike->price, 0, ',', '.') }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ url('/products/bikes/' . $bike->id) }}" 
                           class="text-red-600 hover:text-red-700 font-semibold text-sm">
                            Details
                        </a>
                        @auth
                        <form method="POST" action="{{ route('cart.add') }}" class="inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $bike->id }}">
                            <input type="hidden" name="product_type" value="bike">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="text-red-600 hover:text-red-700 font-semibold text-sm">
                                Add to Cart
                            </button>
                        </form>
                        @endauth
                    </div>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($bikes->hasPages())
    <div class="mt-8">
        {{ $bikes->links() }}
    </div>
    @endif
</div>
@endsection 