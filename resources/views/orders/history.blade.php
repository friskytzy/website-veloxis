@extends('layouts.app')

@section('title', 'Riwayat Order - VELOXIS')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black text-veloxis-navy">Riwayat Order</h1>
    <p class="mt-3 text-slate-600">Pantau pesanan akun Anda, termasuk status pembayaran dan pengiriman.</p>

    <div class="mt-8 space-y-4">
        @forelse($orders as $order)
            <article class="rounded-3xl bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-black text-veloxis-navy">{{ $order->order_number ?? '#'.$order->id }}</h2>
                        <p class="mt-1 text-sm text-slate-500">{{ $order->created_at->format('d M Y H:i') }} · {{ ucfirst($order->status) }}</p>
                    </div>
                    <div class="text-left sm:text-right">
                        <p class="text-2xl font-black text-veloxis-red">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <a href="{{ route('orders.show', $order) }}" class="mt-2 inline-block rounded-xl border border-slate-200 px-4 py-2 text-sm font-black text-veloxis-navy hover:border-veloxis-red hover:text-veloxis-red">Detail</a>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-slate-300 bg-white p-10 text-center">
                <h2 class="text-2xl font-black text-veloxis-navy">Belum ada order</h2>
                <a href="{{ route('veloxis.spareparts') }}" class="mt-5 inline-block rounded-2xl bg-veloxis-red px-6 py-3 font-black text-white">Belanja Sparepart</a>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $orders->links() }}
    </div>
</section>
@endsection
