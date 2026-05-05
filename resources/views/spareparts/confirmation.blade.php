@extends('layouts.app')

@section('title', 'Order Confirmation - VELOXIS')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6 lg:px-8">
    <div class="rounded-[2rem] bg-white p-10 shadow-sm">
        <div class="mx-auto mb-6 grid h-20 w-20 place-items-center rounded-full bg-green-100 text-3xl text-green-700"><i class="fas fa-check"></i></div>
        <h1 class="text-4xl font-black text-veloxis-navy">Order diterima</h1>
        <p class="mt-4 text-lg leading-8 text-slate-600">Terima kasih. Ini adalah confirmation page MVP; order demo berhasil dan tim VELOXIS akan menghubungi Anda untuk pembayaran serta pengiriman.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('veloxis.spareparts') }}" class="rounded-2xl bg-veloxis-red px-6 py-4 font-black text-white hover:bg-red-700">Belanja Lagi</a>
            <a href="{{ route('home') }}" class="rounded-2xl border border-slate-200 px-6 py-4 font-black text-veloxis-navy hover:border-veloxis-red hover:text-veloxis-red">Kembali Home</a>
        </div>
    </div>
</section>
@endsection
