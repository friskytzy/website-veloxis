@extends('layouts.app')

@section('title', 'Detail Order - VELOXIS')

@section('content')
<section class="mx-auto max-w-5xl px-4 py-10 sm:px-6 lg:px-8">
    <a href="{{ route('orders.history') }}" class="font-bold text-veloxis-red">&larr; Riwayat Order</a>

    <div class="mt-6 rounded-3xl bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 border-b border-slate-100 pb-6 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-4xl font-black text-veloxis-navy">{{ $order->order_number ?? '#'.$order->id }}</h1>
                <p class="mt-2 text-slate-500">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="rounded-2xl bg-veloxis-cream px-5 py-3 font-black text-veloxis-navy">{{ ucfirst($order->status) }}</div>
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[1fr_320px]">
            <div>
                <h2 class="text-2xl font-black text-veloxis-navy">Item Order</h2>
                <div class="mt-4 space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between rounded-2xl border border-slate-100 p-4">
                            <div>
                                <p class="font-black text-veloxis-navy">{{ $item->product_name ?? 'Product #'.$item->product_id }}</p>
                                <p class="text-sm text-slate-500">Qty {{ $item->quantity }} × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-black text-veloxis-red">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <aside class="rounded-3xl bg-veloxis-cream p-6">
                <h2 class="text-2xl font-black text-veloxis-navy">Ringkasan</h2>
                <div class="mt-4 space-y-3 text-slate-700">
                    <div class="flex justify-between"><span>Subtotal</span><strong>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></div>
                    <div class="flex justify-between"><span>Ongkir</span><strong>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></div>
                    <div class="flex justify-between"><span>Diskon</span><strong>- Rp {{ number_format($order->discount, 0, ',', '.') }}</strong></div>
                    <div class="border-t border-slate-300 pt-4 text-xl font-black text-veloxis-navy flex justify-between"><span>Total</span><span>Rp {{ number_format($order->total, 0, ',', '.') }}</span></div>
                </div>
                <div class="mt-6 space-y-3 text-sm text-slate-600">
                    <p><strong>Pembayaran:</strong> {{ $order->payment_method }} · {{ strtoupper($order->payment_provider ?? 'manual') }}</p>
                    <p><strong>Status bayar:</strong> {{ $order->payment_status }}</p>
                    <p><strong>Kurir:</strong> {{ $order->courier }} · Resi {{ $order->tracking_number ?? 'belum ada' }}</p>
                    <p><strong>Alamat:</strong> {{ $order->address }}, {{ $order->city }} {{ $order->postal_code }}</p>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
