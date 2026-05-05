@extends('layouts.app')

@section('title', 'Keranjang Belanja - VELOXIS')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-8">
        <p class="font-bold uppercase tracking-[0.25em] text-veloxis-red">Step 1 dari 3</p>
        <h1 class="mt-2 text-4xl font-black text-veloxis-navy">Keranjang Belanja</h1>
    </div>

    <div class="mb-8 grid gap-3 sm:grid-cols-3">
        <div class="rounded-2xl bg-veloxis-red px-5 py-4 font-black text-white">1. Cart</div>
        <div class="rounded-2xl bg-white px-5 py-4 font-black text-slate-500">2. Shipping</div>
        <div class="rounded-2xl bg-white px-5 py-4 font-black text-slate-500">3. Payment</div>
    </div>

    @if(count($items) > 0)
        <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
            <div class="space-y-4">
                @foreach($items as $item)
                    <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="grid gap-5 sm:grid-cols-[120px_1fr_auto] sm:items-center">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-28 w-full rounded-2xl object-cover sm:w-28">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ $item['category'] }} · {{ $item['sku'] }}</p>
                                <h2 class="mt-1 text-xl font-black text-veloxis-navy">{{ $item['name'] }}</h2>
                                <p class="mt-1 text-sm text-slate-500">{{ $item['motor_brand'] }} {{ implode(', ', array_slice($item['models'], 0, 2)) }}</p>
                                <p class="mt-2 font-black text-veloxis-red">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="sm:text-right">
                                <form action="{{ route('veloxis.cart.update', $item['slug']) }}" method="POST" class="flex items-center gap-2 sm:justify-end">
                                    @csrf
                                    @method('PUT')
                                    <input name="quantity" type="number" min="0" max="10" value="{{ $item['quantity'] }}" class="w-20 rounded-xl border border-slate-200 px-3 py-2 text-center font-bold">
                                    <button class="rounded-xl bg-veloxis-navy px-3 py-2 text-sm font-bold text-white">Update</button>
                                </form>
                                <p class="mt-3 font-black text-veloxis-navy">Subtotal Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <aside class="h-fit rounded-3xl bg-white p-6 shadow-sm">
                <h2 class="mb-5 text-2xl font-black text-veloxis-navy">Order Summary</h2>
                <div class="space-y-3 text-slate-600">
                    <div class="flex justify-between"><span>Total produk</span><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></div>
                    <div class="flex justify-between"><span>Ongkir</span><strong>{{ $shipping === 0 ? 'Gratis' : 'Rp ' . number_format($shipping, 0, ',', '.') }}</strong></div>
                    <div class="flex justify-between"><span>Diskon</span><strong>- Rp {{ number_format($discount, 0, ',', '.') }}</strong></div>
                </div>
                <div class="mt-5 border-t border-slate-200 pt-5">
                    <div class="flex items-center justify-between text-xl font-black text-veloxis-navy"><span>Total bayar</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                </div>
                <a href="{{ route('veloxis.checkout') }}" class="mt-6 block rounded-2xl bg-veloxis-red px-6 py-4 text-center font-black text-white hover:bg-red-700">Lanjut Checkout</a>
                <div class="mt-5 rounded-2xl bg-veloxis-cream p-4 text-sm font-semibold text-slate-600">
                    <i class="fas fa-lock mr-2 text-veloxis-red"></i>Secure checkout, return policy, dan CS WhatsApp aktif.
                </div>
            </aside>
        </div>
    @else
        <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center">
            <h2 class="text-2xl font-black text-veloxis-navy">Keranjang masih kosong</h2>
            <p class="mt-2 text-slate-500">Mulai dari pilih merek motor, lalu masukkan sparepart yang cocok ke keranjang.</p>
            <a href="{{ route('veloxis.spareparts') }}" class="mt-5 inline-block rounded-2xl bg-veloxis-red px-6 py-3 font-black text-white">Cari Sparepart</a>
        </div>
    @endif
</section>
@endsection
