@extends('layouts.app')

@section('title', 'Order Confirmation - VELOXIS')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6 lg:px-8">
    <div class="rounded-[2rem] bg-white p-10 shadow-sm">
        <div class="mx-auto mb-6 grid h-20 w-20 place-items-center rounded-full bg-green-100 text-3xl text-green-700"><i class="fas fa-check"></i></div>
        <h1 class="text-4xl font-black text-veloxis-navy">Order diterima</h1>
        <p class="mt-4 text-lg leading-8 text-slate-600">Terima kasih. Order Anda sudah tersimpan dan tim VELOXIS akan menghubungi Anda untuk pembayaran serta pengiriman.</p>
        @if($order)
            <div class="mt-8 rounded-3xl bg-veloxis-cream p-6 text-left">
                <dl class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Nomor Order</dt>
                        <dd class="mt-1 text-xl font-black text-veloxis-navy">{{ $order->order_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Total</dt>
                        <dd class="mt-1 text-xl font-black text-veloxis-red">Rp {{ number_format($order->total, 0, ',', '.') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Pembayaran</dt>
                        <dd class="mt-1 font-black text-veloxis-navy">{{ $order->payment_method }} · {{ strtoupper($order->payment_provider) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-bold uppercase tracking-[0.2em] text-slate-500">Kurir</dt>
                        <dd class="mt-1 font-black text-veloxis-navy">{{ $order->courier }}</dd>
                    </div>
                </dl>
            </div>
        @endif
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('veloxis.spareparts') }}" class="rounded-2xl bg-veloxis-red px-6 py-4 font-black text-white hover:bg-red-700">Belanja Lagi</a>
            <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200 px-6 py-4 font-black text-veloxis-navy hover:border-veloxis-red hover:text-veloxis-red">Kembali Home</a>
        </div>
    </div>
</section>
@endsection
