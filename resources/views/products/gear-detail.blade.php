@extends('layouts.app')

@section('title', $gear->name . ' - Veloxis Legends')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-300">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="{{ url('/products/gear') }}" class="text-gray-400 hover:text-gray-300 ml-1 md:ml-2 text-sm font-medium">Gear</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-gray-400 ml-1 md:ml-2 text-sm font-medium">{{ $gear->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div class="p-6">
                <div class="rounded-xl overflow-hidden mb-4" style="height: 400px;">
                    <img src="{{ asset('storage/' . $gear->image) }}" alt="{{ $gear->name }}" 
                        class="w-full h-full object-cover">
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="p-6">
                <h1 class="text-3xl font-oswald font-bold mb-2 text-white">{{ $gear->name }}</h1>
                
                <div class="flex items-center mb-4">
                    <span class="px-2 py-1 bg-gray-700 text-sm font-medium rounded-full text-gray-300">{{ $gear->category }}</span>
                    <span class="mx-2 text-gray-500">•</span>
                    <span class="{{ $gear->stock > 0 ? 'text-green-500' : 'text-red-500' }} text-sm font-medium">
                        {{ $gear->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                
                <div class="text-3xl font-bold text-red-600 mb-4">
                    Rp {{ number_format($gear->price, 0, ',', '.') }}
                </div>
                
                <div class="text-gray-300 mb-6">
                    <p>{{ $gear->description }}</p>
                </div>
                
                <div class="space-y-4 mb-6">
                    <div class="flex items-center justify-between py-3 border-t border-b border-gray-700">
                        <span class="font-medium text-gray-200">Category</span>
                        <span class="text-gray-300">{{ $gear->category }}</span>
                    </div>
                    
                    @if($gear->size)
                    <div class="flex items-center justify-between py-3 border-b border-gray-700">
                        <span class="font-medium text-gray-200">Size</span>
                        <span class="text-gray-300">{{ $gear->size }}</span>
                    </div>
                    @endif
                    
                    @if($gear->color)
                    <div class="flex items-center justify-between py-3 border-b border-gray-700">
                        <span class="font-medium text-gray-200">Color</span>
                        <div class="flex items-center">
                            <span class="inline-block h-6 w-6 rounded-full border" 
                                  style="background-color: {{ strtolower($gear->color) }}"></span>
                            <span class="ml-2 text-gray-300">{{ $gear->color }}</span>
                        </div>
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between py-3 border-b border-gray-700">
                        <span class="font-medium text-gray-200">Availability</span>
                        <span class="{{ $gear->stock > 0 ? 'text-green-500' : 'text-red-500' }}">
                            {{ $gear->stock > 0 ? $gear->stock . ' items available' : 'Out of stock' }}
                        </span>
                    </div>
                </div>
                
                @if($gear->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $gear->id }}">
                    <input type="hidden" name="product_type" value="gear">
                    
                    <div class="flex items-center mb-4">
                        <label for="quantity" class="mr-4 font-medium text-gray-200">Quantity:</label>
                        <div class="custom-number-input h-10 w-32">
                            <div class="flex flex-row h-10 w-full rounded-lg relative bg-transparent">
                                <button type="button" data-action="decrement" class="bg-gray-700 text-gray-300 hover:text-white h-full w-10 rounded-l-lg cursor-pointer outline-none">
                                    <span class="m-auto text-xl font-medium">−</span>
                                </button>
                                <input type="number" class="focus:outline-none text-center w-full bg-gray-700 font-semibold text-md md:text-base cursor-default flex items-center text-gray-200 outline-none" name="quantity" value="1" min="1" max="{{ $gear->stock }}">
                                <button type="button" data-action="increment" class="bg-gray-700 text-gray-300 hover:text-white h-full w-10 rounded-r-lg cursor-pointer">
                                    <span class="m-auto text-xl font-medium">+</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                        Add to Cart
                    </button>
                </form>
                @endif
                
                <div class="flex justify-center space-x-4 border-t border-gray-700 pt-6">
                    <button class="flex items-center text-gray-400 hover:text-red-500 transition duration-300">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Add to Wishlist
                    </button>
                    <button class="flex items-center text-gray-400 hover:text-red-500 transition duration-300">
                        <svg class="w-5 h-5 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z"></path>
                        </svg>
                        Share
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    <div class="mt-16">
        <h2 class="text-2xl font-oswald font-bold mb-6 text-white">You May Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedGear as $related)
            <div class="bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-red-600 transition-shadow duration-300">
                <div class="relative overflow-hidden" style="height: 200px;">
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" 
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                </div>
                <div class="p-4">
                    <h3 class="font-oswald font-semibold text-lg mb-2 text-white">{{ $related->name }}</h3>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-lg font-bold text-red-600">Rp {{ number_format($related->price, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-400">{{ $related->category }}</span>
                    </div>
                    <a href="{{ url('/products/gear/' . $related->id) }}" class="block text-center bg-gray-700 hover:bg-gray-600 text-gray-200 font-medium py-2 px-4 rounded-lg transition-colors duration-300">
                        View Details
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Quantity increment/decrement
        function decrement(e) {
            const btn = e.target.parentNode.parentElement.querySelector('[data-action="decrement"]');
            const target = btn.nextElementSibling;
            let value = Number(target.value);
            if(value > 1) {
                value--;
                target.value = value;
            }
        }
        
        function increment(e) {
            const btn = e.target.parentNode.parentElement.querySelector('[data-action="increment"]');
            const target = btn.previousElementSibling;
            let value = Number(target.value);
            let max = Number(target.getAttribute('max'));
            if(value < max) {
                value++;
                target.value = value;
            }
        }
        
        const decrementButtons = document.querySelectorAll(`[data-action="decrement"]`);
        const incrementButtons = document.querySelectorAll(`[data-action="increment"]`);
        
        decrementButtons.forEach(btn => {
            btn.addEventListener("click", decrement);
        });
        
        incrementButtons.forEach(btn => {
            btn.addEventListener("click", increment);
        });
    });
</script>
@endpush

@endsection 