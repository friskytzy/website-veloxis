@extends('layouts.app')

@section('title', 'Cari Sparepart Motor - VELOXIS')

@section('content')
<section class="bg-veloxis-navy py-12 text-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <nav class="mb-4 text-sm text-slate-300" aria-label="Breadcrumb"><a href="{{ route('home') }}" class="hover:text-white">Home</a> <span class="mx-2">/</span> Sparepart</nav>
        <h1 class="text-4xl font-black sm:text-5xl">Cari Sparepart Motor</h1>
        <p class="mt-4 max-w-2xl text-slate-200">Filter berdasarkan merek motor, model, tahun, kategori, harga, dan brand part. Semua produk memiliki stok dan badge keaslian.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <form method="GET" action="{{ route('veloxis.spareparts') }}" class="mb-8 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="grid gap-4 lg:grid-cols-[1.3fr_repeat(5,1fr)]">
            <div>
                <label for="search" class="mb-2 block text-sm font-bold text-slate-700">Search</label>
                <input id="search" name="search" value="{{ request('search') }}" list="search-suggestions" placeholder="Contoh: oli Honda Beat" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                <datalist id="search-suggestions">
                    @foreach($searchSuggestions as $suggestion)
                        <option value="{{ $suggestion }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div>
                <label for="motor_brand" class="mb-2 block text-sm font-bold text-slate-700">Merek Motor</label>
                <select id="motor_brand" name="motor_brand" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                    <option value="">Semua</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand['name'] }}" @selected(request('motor_brand') === $brand['name'])>{{ $brand['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="model" class="mb-2 block text-sm font-bold text-slate-700">Model</label>
                <select id="model" name="model" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                    <option value="">Semua</option>
                    @foreach($brands as $brand)
                        <optgroup label="{{ $brand['name'] }}">
                            @foreach($brand['models'] as $model)
                                <option value="{{ $model }}" @selected(request('model') === $model)>{{ $model }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="category" class="mb-2 block text-sm font-bold text-slate-700">Kategori</label>
                <select id="category" name="category" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                    <option value="">Semua</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" @selected(request('category') === $category)>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="part_brand" class="mb-2 block text-sm font-bold text-slate-700">Brand Part</label>
                <select id="part_brand" name="part_brand" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                    <option value="">Semua</option>
                    @foreach($partBrands as $partBrand)
                        <option value="{{ $partBrand }}" @selected(request('part_brand') === $partBrand)>{{ $partBrand }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="sort" class="mb-2 block text-sm font-bold text-slate-700">Sort</label>
                <select id="sort" name="sort" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                    <option value="popular" @selected(request('sort') === 'popular')>Popularitas</option>
                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Harga rendah</option>
                    <option value="rating" @selected(request('sort') === 'rating')>Rating</option>
                    <option value="newest" @selected(request('sort') === 'newest')>Terbaru</option>
                </select>
            </div>
        </div>
        <div class="mt-4 grid gap-4 sm:grid-cols-[1fr_1fr_auto]">
            <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Harga minimum" class="rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
            <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Harga maksimum" class="rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
            <button class="rounded-2xl bg-veloxis-red px-8 py-3 font-black text-white hover:bg-red-700">Terapkan Filter</button>
        </div>
    </form>

    <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <p class="font-bold text-slate-600">{{ count($products) }} produk ditemukan</p>
        <p class="text-sm text-slate-500">Breadcrumb maksimal 3 klik: Home → Sparepart → Produk</p>
    </div>

    @if(count($products) > 0)
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($products as $product)
                <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <a href="{{ route('veloxis.spareparts.show', $product['slug']) }}" class="block">
                        <div class="relative h-52 overflow-hidden bg-slate-100">
                            <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-full w-full object-cover transition duration-500 hover:scale-110" loading="lazy">
                            <span class="absolute left-4 top-4 rounded-full bg-veloxis-red px-3 py-1 text-xs font-black text-white">{{ $product['badge'] }}</span>
                            <span class="absolute bottom-4 right-4 rounded-full bg-white px-3 py-1 text-xs font-black text-green-700">Stok {{ $product['stock'] }}</span>
                        </div>
                    </a>
                    <div class="p-5">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ $product['category'] }} · {{ $product['part_brand'] }}</p>
                        <h2 class="mt-2 min-h-[3.5rem] text-lg font-black text-veloxis-navy"><a href="{{ route('veloxis.spareparts.show', $product['slug']) }}" class="hover:text-veloxis-red">{{ $product['name'] }}</a></h2>
                        <p class="mt-2 text-sm text-slate-500">Cocok: {{ $product['motor_brand'] }} {{ implode(', ', array_slice($product['models'], 0, 2)) }} · {{ $product['years'] }}</p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="text-xl font-black text-veloxis-red">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                            <span class="text-sm font-bold text-amber-500"><i class="fas fa-star"></i> {{ $product['rating'] }} ({{ $product['review_count'] }})</span>
                        </div>
                        <div class="mt-5 flex gap-2">
                            <form action="{{ route('veloxis.cart.add', $product['slug']) }}" method="POST" class="flex-1">
                                @csrf
                                <button class="w-full rounded-2xl bg-veloxis-red px-4 py-3 text-sm font-black text-white hover:bg-red-700">Add to cart</button>
                            </form>
                            <a href="{{ route('veloxis.spareparts.show', $product['slug']) }}" class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-black text-veloxis-navy hover:border-veloxis-red hover:text-veloxis-red">Detail</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @else
        <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center">
            <h2 class="text-2xl font-black text-veloxis-navy">Produk tidak ditemukan</h2>
            <p class="mt-2 text-slate-500">Coba hapus filter atau gunakan kata kunci lain.</p>
            <a href="{{ route('veloxis.spareparts') }}" class="mt-5 inline-block rounded-2xl bg-veloxis-red px-6 py-3 font-black text-white">Reset filter</a>
        </div>
    @endif
</section>
@endsection
