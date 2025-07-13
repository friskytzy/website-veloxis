@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6">
    <nav class="mb-6">
        <ol class="list-none p-0 inline-flex text-sm text-gray-600">
            <li class="flex items-center">
                <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                <svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li class="flex items-center">
                <a href="{{ route('products.bikes') }}" class="hover:text-indigo-600">Bikes</a>
                <svg class="w-3 h-3 mx-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </li>
            <li>
                <span class="text-gray-800 font-medium">{{ $bike->name }}</span>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-0 lg:gap-8">
            <!-- Product Image with Gallery Effect -->
            <div class="p-4 sm:p-6">
                <div class="relative">
                    <img id="product-image" src="{{ $bike->image_url }}" alt="{{ $bike->name }}" class="w-full h-80 sm:h-96 object-cover rounded-lg shadow hover:opacity-95 transition-opacity cursor-pointer">
                    
                    <!-- Zoom icon -->
                    <div class="absolute bottom-4 right-4 bg-white p-2 rounded-full shadow-md cursor-pointer" onclick="openImageModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Product Info with Better Organization -->
            <div class="p-4 sm:p-6 lg:pt-8">
                <span class="inline-block px-3 py-1 bg-indigo-100 text-indigo-800 text-xs font-medium rounded-full mb-3">
                    {{ $bike->category }}
                </span>
                
                <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $bike->name }}</h1>
                
                <div class="mb-6">
                    <span class="text-3xl font-bold text-indigo-600">Rp {{ number_format($bike->price, 0, ',', '.') }}</span>
                </div>
                
                <div class="prose prose-sm text-gray-600 mb-6">
                    <p>{{ $bike->description }}</p>
                </div>
                
                <!-- Availability Card -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-3 h-3 rounded-full {{ $bike->stock > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                        <span class="font-semibold {{ $bike->stock > 0 ? 'text-green-700' : 'text-red-700' }}">
                            {{ $bike->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                        </span>
                    </div>
                    
                    @if($bike->stock > 0)
                    <p class="text-sm text-gray-600">{{ $bike->stock }} units available for immediate shipping</p>
                    @else
                    <p class="text-sm text-gray-600">Currently unavailable. Please check back later.</p>
                    @endif
                </div>
                
                @if($bike->stock > 0)
                <form method="POST" action="{{ route('cart.add') }}" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $bike->id }}">
                    <input type="hidden" name="product_type" value="bike">
                    <div class="flex flex-wrap items-end gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <div class="flex border rounded overflow-hidden w-32">
                                <button type="button" onclick="decrementQuantity()" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                    -
                                </button>
                                <input type="number" id="quantity" name="quantity" value="1" min="1" max="{{ $bike->stock }}" class="w-full text-center border-none focus:ring-0">
                                <button type="button" onclick="incrementQuantity({{ $bike->stock }})" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600">
                                    +
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="flex-grow sm:flex-grow-0 bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 flex items-center justify-center gap-2 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Add to Cart
                        </button>
                    </div>
                </form>
                @else
                <div class="mb-6">
                    <button disabled class="w-full sm:w-auto bg-gray-400 text-white px-8 py-3 rounded-lg cursor-not-allowed">
                        Out of Stock
                    </button>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Specifications -->
        @if($bike->specifications)
        <div class="border-t p-4 sm:p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Specifications</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-6">
                    @foreach($bike->specifications as $key => $value)
                    <div class="flex justify-between border-b border-gray-200 pb-2">
                        <span class="font-medium capitalize text-gray-700">{{ str_replace('_', ' ', $key) }}</span>
                        <span class="text-gray-900">{{ $value }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
    
    <!-- Related Products -->
    @if(count($relatedBikes) > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6">Related Bikes</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedBikes as $related)
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                <a href="{{ url('/products/bikes/' . $related->id) }}" class="block relative">
                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                    @if($related->stock <= 0)
                    <span class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded">Out of Stock</span>
                    @endif
                </a>
                <div class="p-4">
                    <h3 class="font-semibold mb-2">
                        <a href="{{ url('/products/bikes/' . $related->id) }}" class="text-gray-900 hover:text-indigo-600">
                            {{ $related->name }}
                        </a>
                    </h3>
                    <p class="text-lg font-bold text-indigo-600 mb-3">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                    <a href="{{ url('/products/bikes/' . $related->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 text-sm">
                        View Details
                        <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-80 flex items-center justify-center p-4">
    <div class="relative max-w-4xl w-full">
        <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="modal-image" src="" alt="Product Image" class="max-w-full max-h-[80vh] mx-auto object-contain">
    </div>
</div>

@push('scripts')
<script>
    // Quantity controls
    function incrementQuantity(maxStock) {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue < maxStock) {
            quantityInput.value = currentValue + 1;
        }
    }
    
    function decrementQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }

    // Image modal functionality
    function openImageModal() {
        const productImage = document.getElementById('product-image');
        const modalImage = document.getElementById('modal-image');
        const modal = document.getElementById('imageModal');
        
        modalImage.src = productImage.src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent scrolling when modal is open
    }
    
    function closeImageModal() {
        const modal = document.getElementById('imageModal');
        modal.classList.add('hidden');
        document.body.style.overflow = ''; // Re-enable scrolling
    }
    
    // Also open modal when clicking directly on the product image
    document.getElementById('product-image').addEventListener('click', openImageModal);
    
    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeImageModal();
        }
    });
    
    // Close modal with escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection 