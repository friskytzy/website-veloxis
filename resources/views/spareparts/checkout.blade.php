@extends('layouts.app')

@section('title', 'Checkout - VELOXIS')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="mb-8">
        <p class="font-bold uppercase tracking-[0.25em] text-veloxis-red">Step 2-3 dari 3</p>
        <h1 class="mt-2 text-4xl font-black text-veloxis-navy">Checkout Minimalis</h1>
        <p class="mt-3 text-slate-600">Guest checkout aktif. Tidak wajib registrasi untuk mengurangi friction pembelian.</p>
    </div>

    <div class="mb-8 grid gap-3 sm:grid-cols-3">
        <a href="{{ route('veloxis.cart') }}" class="rounded-2xl bg-white px-5 py-4 font-black text-slate-500">1. Cart</a>
        <div class="rounded-2xl bg-veloxis-red px-5 py-4 font-black text-white">2. Shipping</div>
        <div class="rounded-2xl bg-veloxis-navy px-5 py-4 font-black text-white">3. Payment</div>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid gap-8 lg:grid-cols-[1fr_380px]">
        <form action="{{ route('veloxis.order.place') }}" method="POST" class="rounded-3xl bg-white p-6 shadow-sm">
            @csrf
            @if(count($items) === 0)
                <div class="mb-5 rounded-2xl bg-veloxis-cream p-4 font-semibold text-slate-600">Keranjang kosong. Tambahkan produk sebelum membuat order.</div>
            @endif
            <h2 class="mb-5 text-2xl font-black text-veloxis-navy">Informasi Pengiriman</h2>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="name" class="mb-2 block font-bold text-slate-700">Nama penerima</label>
                    <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                </div>
                <div>
                    <label for="email" class="mb-2 block font-bold text-slate-700">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                </div>
                <div>
                    <label for="phone" class="mb-2 block font-bold text-slate-700">Telepon</label>
                    <input id="phone" name="phone" value="{{ old('phone') }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                </div>
                <div>
                    <label for="city" class="mb-2 block font-bold text-slate-700">Kota</label>
                    <input id="city" name="city" value="{{ old('city') }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                </div>
                <div>
                    <label for="postal_code" class="mb-2 block font-bold text-slate-700">Kode pos</label>
                    <input id="postal_code" name="postal_code" value="{{ old('postal_code') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                </div>
            </div>
            <div class="mt-4">
                <label for="address" class="mb-2 block font-bold text-slate-700">Alamat lengkap</label>
                <textarea id="address" name="address" rows="4" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">{{ old('address') }}</textarea>
            </div>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="courier" class="mb-2 block font-bold text-slate-700">Kurir</label>
                    <select id="courier" name="courier" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                        <option value="">Pilih kurir</option>
                        @foreach($couriers as $courier => $config)
                            <option value="{{ $courier }}" @selected(old('courier') === $courier)>{{ $courier }}{{ $config['provider'] !== 'manual' ? ' · ' . strtoupper($config['provider']) : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="payment_method" class="mb-2 block font-bold text-slate-700">Metode Pembayaran</label>
                    <select id="payment_method" name="payment_method" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                        <option value="">Pilih pembayaran</option>
                        @foreach($paymentMethods as $method => $config)
                            <option value="{{ $method }}" @selected(old('payment_method') === $method)>{{ $method }}{{ $config['provider'] !== 'manual' ? ' · ' . strtoupper($config['provider']) : '' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4">
                <label for="notes" class="mb-2 block font-bold text-slate-700">Catatan order</label>
                <textarea id="notes" name="notes" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">{{ old('notes') }}</textarea>
            </div>
            <button @disabled(count($items) === 0) class="mt-6 w-full rounded-2xl bg-veloxis-red px-6 py-4 font-black text-white hover:bg-red-700 disabled:cursor-not-allowed disabled:bg-slate-300">Buat Order</button>
            <p class="mt-4 text-center text-sm font-semibold text-slate-500"><i class="fas fa-lock mr-2 text-veloxis-red"></i>Order tersimpan ke database. Payment/kurir siap disambungkan ke provider terkonfigurasi.</p>
        </form>

        <aside class="h-fit rounded-3xl bg-white p-6 shadow-sm">
            <h2 class="mb-5 text-2xl font-black text-veloxis-navy">Ringkasan Order</h2>
            @forelse($items as $item)
                <div class="flex gap-3 border-b border-slate-100 py-3">
                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-16 w-16 rounded-xl object-cover">
                    <div class="flex-1">
                        <p class="font-bold text-veloxis-navy">{{ $item['name'] }}</p>
                        <p class="text-sm text-slate-500">Qty {{ $item['quantity'] }}</p>
                    </div>
                    <p class="font-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="rounded-2xl bg-veloxis-cream p-4 text-sm font-semibold text-slate-600">Keranjang kosong. Checkout tetap ditampilkan sebagai demo MVP.</p>
            @endforelse
            <div class="mt-4 space-y-3 text-slate-600">
                <div class="flex justify-between"><span>Total produk</span><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></div>
                <div class="flex justify-between"><span>Ongkir</span><strong>{{ $shipping === 0 ? 'Gratis' : 'Rp ' . number_format($shipping, 0, ',', '.') }}</strong></div>
                <div class="flex justify-between"><span>Diskon</span><strong>- Rp {{ number_format($discount, 0, ',', '.') }}</strong></div>
                <div class="border-t border-slate-200 pt-4 text-xl font-black text-veloxis-navy flex justify-between"><span>Total bayar</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
            </div>
        </aside>
    </div>
</section>
@endsection
