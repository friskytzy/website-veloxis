@extends('layouts.app')

@section('title', 'Gear Collection - Veloxis Legends')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8">
        <h2 class="text-3xl font-oswald font-bold text-white">Gear Collection</h2>
        <div class="mt-4 md:mt-0">
            <form method="GET" action="{{ route('products.gear') }}">
                <div class="flex">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search gear..." 
                        class="border border-gray-600 bg-gray-700 text-white rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-r hover:bg-red-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Filters Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-gray-800 p-6 rounded-xl shadow-md">
                <h3 class="font-oswald font-bold text-lg mb-4 text-white">Filters</h3>
                <form method="GET" action="{{ route('products.gear') }}" id="filter-form">
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                        <select name="category" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" onchange="document.getElementById('filter-form').submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}" {{ request('category') == $category->name ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Price Range</label>
                        <select name="price_range" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" onchange="document.getElementById('filter-form').submit()">
                            <option value="">Any Price</option>
                            <option value="0-100000" {{ request('price_range') == '0-100000' ? 'selected' : '' }}>Under Rp 100.000</option>
                            <option value="100000-500000" {{ request('price_range') == '100000-500000' ? 'selected' : '' }}>Rp 100.000 - Rp 500.000</option>
                            <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                            <option value="1000000-5000000" {{ request('price_range') == '1000000-5000000' ? 'selected' : '' }}>Rp 1.000.000 - Rp 5.000.000</option>
                            <option value="5000000+" {{ request('price_range') == '5000000+' ? 'selected' : '' }}>Above Rp 5.000.000</option>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Size</label>
                        <select name="size" class="w-full bg-gray-700 border border-gray-600 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" onchange="document.getElementById('filter-form').submit()">
                            <option value="">Any Size</option>
                            <option value="S" {{ request('size') == 'S' ? 'selected' : '' }}>S</option>
                            <option value="M" {{ request('size') == 'M' ? 'selected' : '' }}>M</option>
                            <option value="L" {{ request('size') == 'L' ? 'selected' : '' }}>L</option>
                            <option value="XL" {{ request('size') == 'XL' ? 'selected' : '' }}>XL</option>
                            <option value="XXL" {{ request('size') == 'XXL' ? 'selected' : '' }}>XXL</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="lg:col-span-3">
            @if($gear->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($gear as $item)
                    <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-red-600 transition-shadow duration-300">
                        <div class="relative overflow-hidden" style="height: 200px;">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" 
                                class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                            @if($item->stock <= 0)
                                <span class="absolute top-0 right-0 bg-red-600 text-white px-3 py-1 text-sm font-semibold">
                                    Out of Stock
                                </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-oswald font-semibold text-lg mb-2 text-white">{{ $item->name }}</h3>
                            <p class="text-gray-400 text-sm mb-3 line-clamp-2">{{ $item->description }}</p>
                            
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-lg font-bold text-red-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-400 px-2 py-1 bg-gray-700 rounded-full">{{ $item->category }}</span>
                            </div>
                            
                            <div class="flex items-center justify-between text-sm text-gray-400 mb-4">
                                @if($item->size)
                                    <span>Size: {{ $item->size }}</span>
                                @endif
                                @if($item->color)
                                    <span>Color: {{ $item->color }}</span>
                                @endif
                            </div>
                            
                            <div class="flex items-center justify-between">
                                @if($item->stock > 0)
                                    <form action="{{ route('cart.add') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <input type="hidden" name="product_type" value="gear">
                                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 text-sm transition duration-300">
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="bg-gray-700 text-gray-400 px-4 py-2 rounded-lg text-sm cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                                <a href="{{ url('/products/gear/' . $item->id) }}" class="text-red-600 hover:text-red-400 text-sm font-medium">
                                    View Details →
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $gear->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-gray-800 rounded-xl p-8 text-center">
                    <p class="text-lg text-gray-300">No gear items found matching your criteria.</p>
                    <a href="{{ route('products.gear') }}" class="inline-block mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                        Clear Filters
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 