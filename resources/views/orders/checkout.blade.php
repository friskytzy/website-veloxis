@extends('layouts.app')

@section('title', 'Checkout - Veloxis Legends')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Checkout</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-medium mb-4">Ringkasan Pesanan</h3>
            @foreach($cartItems as $item)
                <div class="flex justify-between items-center py-2 border-b">
                    <div>
                        <div class="font-medium">{{ $item->product->name }}</div>
                        <div class="text-sm text-gray-500">Qty: {{ $item->quantity }}</div>
                        @if($item->quantity > $item->product->stock)
                            <div class="text-red-500 text-xs">Stok tidak mencukupi (Tersedia: {{ $item->product->stock }})</div>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="font-medium">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-500">@ Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                    </div>
                </div>
            @endforeach
            <div class="flex justify-between items-center py-4 font-bold text-lg">
                <span>Total:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
        
        <!-- Checkout Form -->
        <div class="bg-white rounded shadow p-6">
            <h3 class="text-lg font-medium mb-4">Informasi Pengiriman</h3>
            <form method="POST" action="{{ route('orders.store') }}" class="space-y-4">
                @csrf
                
                <!-- Hidden fields for cart items -->
                @foreach($cartItems as $item)
                    <input type="hidden" name="items[{{ $loop->index }}][product_id]" value="{{ $item->product_id }}">
                    <input type="hidden" name="items[{{ $loop->index }}][product_type]" value="{{ $item->product_type }}">
                    <input type="hidden" name="items[{{ $loop->index }}][quantity]" value="{{ $item->quantity }}">
                @endforeach
                
                <div>
                    <label class="block mb-1 font-medium">Nama Penerima</label>
                    <input type="text" name="shipping_name" value="{{ old('shipping_name') }}" class="w-full border rounded px-3 py-2 @error('shipping_name') border-red-500 @enderror" required>
                    @error('shipping_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-1 font-medium">Alamat Pengiriman</label>
                    <textarea name="shipping_address" rows="3" class="w-full border rounded px-3 py-2 @error('shipping_address') border-red-500 @enderror" required>{{ old('shipping_address') }}</textarea>
                    @error('shipping_address')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-1 font-medium">Nomor Telepon</label>
                    <input type="tel" name="shipping_phone" value="{{ old('shipping_phone') }}" class="w-full border rounded px-3 py-2 @error('shipping_phone') border-red-500 @enderror" required>
                    @error('shipping_phone')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-1 font-medium">Metode Pembayaran</label>
                    <select name="payment_method" class="w-full border rounded px-3 py-2 @error('payment_method') border-red-500 @enderror" required>
                        <option value="">Pilih metode pembayaran</option>
                        <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                        <option value="cod" {{ old('payment_method') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                    </select>
                    @error('payment_method')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <div>
                    <label class="block mb-1 font-medium">Catatan (Opsional)</label>
                    <textarea name="notes" rows="3" class="w-full border rounded px-3 py-2 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Buat Pesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection 