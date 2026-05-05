@extends('layouts.app')

@section('title', $product['name'] . ' - VELOXIS')

@section('content')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org/',
    '@type' => 'Product',
    'name' => $product['name'],
    'sku' => $product['sku'],
    'image' => [$product['image']],
    'description' => $product['description'],
    'brand' => ['@type' => 'Brand', 'name' => $product['part_brand']],
    'aggregateRating' => ['@type' => 'AggregateRating', 'ratingValue' => $product['rating'], 'reviewCount' => $product['review_count']],
    'offers' => ['@type' => 'Offer', 'priceCurrency' => 'IDR', 'price' => $product['price'], 'availability' => 'https://schema.org/InStock'],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <nav class="mb-6 text-sm text-slate-500" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-veloxis-red">Home</a>
        <span class="mx-2">/</span>
        <a href="{{ route('veloxis.spareparts', ['category' => $product['category']]) }}" class="hover:text-veloxis-red">{{ $product['category'] }}</a>
        <span class="mx-2">/</span>
        <span class="text-slate-700">{{ $product['name'] }}</span>
    </nav>

    <div class="grid gap-10 lg:grid-cols-2">
        <div>
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white p-3 shadow-sm">
                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="h-[460px] w-full rounded-[1.5rem] object-cover">
            </div>
            <div class="mt-4 grid grid-cols-4 gap-3">
                @foreach([1,2,3,4] as $index)
                    <button class="overflow-hidden rounded-2xl border border-slate-200 bg-white p-1 focus:outline-none focus:ring-4 focus:ring-red-100" aria-label="Foto produk {{ $index }}">
                        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }} angle {{ $index }}" class="h-24 w-full rounded-xl object-cover">
                    </button>
                @endforeach
            </div>
        </div>

        <div>
            <div class="mb-4 flex flex-wrap gap-2">
                <span class="rounded-full bg-veloxis-red px-3 py-1 text-xs font-black text-white">{{ $product['badge'] }}</span>
                <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-black text-green-700">Stok {{ $product['stock'] }}</span>
                <span class="rounded-full bg-veloxis-cream px-3 py-1 text-xs font-black text-veloxis-navy">SKU {{ $product['sku'] }}</span>
            </div>
            <h1 class="text-4xl font-black leading-tight text-veloxis-navy sm:text-5xl">{{ $product['name'] }}</h1>
            <div class="mt-4 flex flex-wrap items-center gap-4">
                <span class="text-3xl font-black text-veloxis-red">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                <span class="font-bold text-amber-500"><i class="fas fa-star"></i> {{ $product['rating'] }} dari {{ $product['review_count'] }} review</span>
            </div>
            <p class="mt-5 text-lg leading-8 text-slate-600">{{ $product['description'] }}</p>

            <div class="mt-6 rounded-3xl border border-slate-200 bg-white p-5">
                <h2 class="mb-3 font-black text-veloxis-navy">Fitment info</h2>
                <p class="text-slate-600">Cocok untuk: <strong>{{ $product['motor_brand'] }} {{ implode(', ', $product['models']) }} {{ $product['years'] }}</strong></p>
            </div>

            <div class="mt-6 grid gap-3 sm:grid-cols-3">
                <div class="rounded-2xl bg-white p-4 text-sm font-bold shadow-sm"><i class="fas fa-certificate mr-2 text-veloxis-red"></i>Genuine guarantee</div>
                <div class="rounded-2xl bg-white p-4 text-sm font-bold shadow-sm"><i class="fas fa-undo mr-2 text-veloxis-red"></i>30-day return</div>
                <div class="rounded-2xl bg-white p-4 text-sm font-bold shadow-sm"><i class="fas fa-truck mr-2 text-veloxis-red"></i>Free shipping*</div>
            </div>

            <form id="purchase-form" action="{{ route('veloxis.cart.add', $product['slug']) }}" method="POST" class="mt-7 rounded-3xl bg-white p-5 shadow-sm">
                @csrf
                <label for="quantity" class="mb-2 block font-bold text-slate-700">Quantity</label>
                <div class="grid gap-3 sm:grid-cols-[112px_1fr_1fr]">
                    <input id="quantity" name="quantity" type="number" min="1" max="10" value="1" class="w-full rounded-2xl border border-slate-200 px-4 py-3 outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
                    <button class="rounded-2xl bg-veloxis-red px-6 py-4 font-black text-white hover:bg-red-700">Add to Cart</button>
                    <button formaction="{{ route('veloxis.buy-now', $product['slug']) }}" class="rounded-2xl bg-veloxis-navy px-6 py-4 font-black text-white hover:bg-veloxis-dark">Buy Now</button>
                </div>
            </form>

            <div class="mt-7 rounded-3xl bg-white p-5 shadow-sm">
                <h2 class="mb-3 font-black text-veloxis-navy">Spesifikasi</h2>
                <div class="grid gap-2 sm:grid-cols-2">
                    @foreach($product['specifications'] as $spec)
                        <div class="rounded-2xl bg-veloxis-cream px-4 py-3 font-semibold text-slate-700">{{ $spec }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <section class="mt-16">
        <h2 class="mb-6 text-3xl font-black text-veloxis-navy">Sering dibeli bersama</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($relatedProducts as $related)
                <a href="{{ route('veloxis.spareparts.show', $related['slug']) }}" class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <img src="{{ $related['image'] }}" alt="{{ $related['name'] }}" class="h-40 w-full object-cover" loading="lazy">
                    <div class="p-4">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ $related['category'] }}</p>
                        <h3 class="mt-2 font-black text-veloxis-navy">{{ $related['name'] }}</h3>
                        <p class="mt-2 font-black text-veloxis-red">Rp {{ number_format($related['price'], 0, ',', '.') }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
</section>
@endsection
