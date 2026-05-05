@extends('layouts.app')

@section('title', 'VELOXIS - Suku Cadang Motor, Asli & Terpercaya')

@section('content')
@php
    $brands = \App\Support\VeloxisCatalog::motorBrands();
    $categories = \App\Support\VeloxisCatalog::categories();
    $products = \App\Support\VeloxisCatalog::products();
    $flashProducts = array_slice($products, 0, 4);
@endphp

<section class="relative overflow-hidden bg-gradient-to-br from-veloxis-navy via-[#24476f] to-veloxis-dark text-white">
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(circle at 20% 20%, #F4A261 0, transparent 28%), radial-gradient(circle at 80% 10%, #E63946 0, transparent 26%);"></div>
    <div class="relative mx-auto grid max-w-7xl gap-12 px-4 py-20 sm:px-6 lg:grid-cols-[1.05fr_0.95fr] lg:px-8 lg:py-28">
        <div>
            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm font-bold text-veloxis-cream backdrop-blur">
                <i class="fas fa-bolt text-veloxis-orange"></i> Search → Find → Buy dalam 3 klik
            </div>
            <h1 class="max-w-3xl text-5xl font-black leading-tight tracking-tight sm:text-6xl lg:text-7xl">Suku Cadang Motor, <span class="text-veloxis-orange">Asli</span> & Terpercaya</h1>
            <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-200">Cari sparepart berdasarkan merek dan model motor. VELOXIS membantu mekanik dan pemilik motor menemukan oli, ban, rem, rantai, aki, dan busi yang kompatibel.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('veloxis.spareparts') }}" class="rounded-2xl bg-veloxis-red px-7 py-4 text-center font-black text-white shadow-xl shadow-red-950/30 transition hover:bg-red-700">Cari Sparepart Motor Anda</a>
                <a href="#brand-selector" class="rounded-2xl border border-white/25 px-7 py-4 text-center font-black text-white transition hover:bg-white/10">Pilih Merek Motor</a>
            </div>
            <div class="mt-10 grid grid-cols-3 gap-4 max-w-xl">
                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur"><p class="text-3xl font-black">20+</p><p class="text-sm text-slate-300">Seed produk MVP</p></div>
                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur"><p class="text-3xl font-black">4.5</p><p class="text-sm text-slate-300">Rating optimal</p></div>
                <div class="rounded-2xl bg-white/10 p-4 backdrop-blur"><p class="text-3xl font-black">30</p><p class="text-sm text-slate-300">Hari retur</p></div>
            </div>
        </div>
        <div class="relative">
            <div class="rounded-[2.5rem] border border-white/15 bg-white/10 p-4 shadow-2xl backdrop-blur">
                <img src="https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=1200&q=85" alt="Motor Indonesia dengan sparepart premium" class="h-[460px] w-full rounded-[2rem] object-cover">
            </div>
            <div class="absolute -bottom-7 left-6 right-6 rounded-3xl bg-white p-5 text-veloxis-dark shadow-2xl">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-veloxis-red">Fitment-first search</p>
                <div class="mt-3 flex flex-wrap gap-2 text-sm font-bold">
                    <span class="rounded-full bg-veloxis-cream px-3 py-2">Honda Beat 2018-2023</span>
                    <span class="rounded-full bg-veloxis-cream px-3 py-2">Yamaha NMax 2020+</span>
                    <span class="rounded-full bg-veloxis-cream px-3 py-2">Kawasaki Ninja 250</span>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="brand-selector" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="font-bold uppercase tracking-[0.25em] text-veloxis-red">Pilih motor Anda</p>
            <h2 class="mt-2 text-3xl font-black text-veloxis-navy sm:text-4xl">Temukan part yang cocok</h2>
        </div>
        <a href="{{ route('veloxis.spareparts') }}" class="font-bold text-veloxis-red hover:text-red-700">Lihat semua sparepart →</a>
    </div>
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($brands as $brand)
            <a href="{{ route('veloxis.spareparts', ['motor_brand' => $brand['name']]) }}" class="group rounded-3xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-veloxis-red hover:shadow-xl">
                <div class="mb-5 grid h-14 w-14 place-items-center rounded-2xl bg-veloxis-navy text-xl font-black text-white group-hover:bg-veloxis-red">{{ substr($brand['name'], 0, 1) }}</div>
                <h3 class="text-2xl font-black text-veloxis-navy">{{ $brand['name'] }}</h3>
                <p class="mt-2 text-sm text-slate-500">{{ implode(', ', $brand['models']) }}</p>
            </a>
        @endforeach
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 text-center">
            <p class="font-bold uppercase tracking-[0.25em] text-veloxis-red">Kategori populer</p>
            <h2 class="mt-2 text-3xl font-black text-veloxis-navy sm:text-4xl">Belanja kebutuhan servis rutin</h2>
        </div>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3 lg:grid-cols-6">
            @foreach($categories as $category)
                <a href="{{ route('veloxis.spareparts', ['category' => $category]) }}" class="rounded-3xl bg-veloxis-cream p-5 text-center font-black text-veloxis-navy transition hover:bg-veloxis-red hover:text-white">
                    <i class="fas fa-{{ ['Oli' => 'oil-can', 'Ban' => 'circle-notch', 'Kampas Rem' => 'stop-circle', 'Rantai & Gear' => 'cogs', 'Aki' => 'car-battery', 'Busi' => 'bolt'][$category] }} mb-3 block text-3xl"></i>
                    {{ $category }}
                </a>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="mb-8 flex items-end justify-between gap-4">
        <div>
            <p class="font-bold uppercase tracking-[0.25em] text-veloxis-red">Flash sale</p>
            <h2 class="mt-2 text-3xl font-black text-veloxis-navy sm:text-4xl">Promo cepat untuk part favorit</h2>
        </div>
        <div class="hidden rounded-2xl bg-veloxis-orange px-5 py-3 font-black text-veloxis-dark sm:block">Hemat sampai Rp50.000</div>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($flashProducts as $product)
            <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover transition duration-500 hover:scale-110">
                    <span class="absolute left-4 top-4 rounded-full bg-veloxis-red px-3 py-1 text-xs font-black text-white">{{ $product['badge'] }}</span>
                </div>
                <div class="p-5">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ $product['category'] }} · {{ $product['motor_brand'] }}</p>
                    <h3 class="mt-2 min-h-[3.5rem] text-lg font-black text-veloxis-navy">{{ $product['name'] }}</h3>
                    <div class="mt-3 flex items-center justify-between">
                        <span class="text-xl font-black text-veloxis-red">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        <span class="text-sm font-bold text-amber-500"><i class="fas fa-star"></i> {{ $product['rating'] }}</span>
                    </div>
                    <a href="{{ route('veloxis.spareparts.show', $product['slug']) }}" class="mt-5 block rounded-2xl bg-veloxis-navy px-4 py-3 text-center font-black text-white hover:bg-veloxis-red">Lihat Detail</a>
                </div>
            </article>
        @endforeach
    </div>
</section>

<section class="bg-veloxis-navy py-16 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-6 lg:grid-cols-3">
            @foreach([
                ['Budi Mekanik', 'Part cepat sampai, harga transparan, dan cocok untuk order bengkel. Filter model motornya bikin kerja lebih cepat.'],
                ['Diana Pemilik Motor', 'Saya tidak takut salah beli karena ada info cocok untuk Beat dan badge genuine. Checkout-nya juga simpel.'],
                ['Raka Parts Specialist', 'VELOXIS siap jadi fondasi marketplace sparepart lokal dengan review mekanik dan fitment checker.'],
            ] as $review)
                <figure class="rounded-3xl border border-white/10 bg-white/10 p-6 backdrop-blur">
                    <div class="mb-4 text-veloxis-orange"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></div>
                    <blockquote class="leading-7 text-slate-100">“{{ $review[1] }}”</blockquote>
                    <figcaption class="mt-5 font-black">{{ $review[0] }}</figcaption>
                </figure>
            @endforeach
        </div>
    </div>
</section>
@endsection
