@extends('layouts.app')

@section('title', 'Contact Us - Veloxis Legends')

@section('content')
<div class="max-w-2xl mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Hubungi Kami</h2>
    
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('contact.store') }}" class="space-y-4 bg-white p-6 rounded shadow">
        @csrf
        
        <!-- Honeypot field for spam protection -->
        <div class="hidden">
            <input type="text" name="honeypot" tabindex="-1" autocomplete="off">
        </div>
        
        <div>
            <label class="block mb-1 font-medium">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 @error('name') border-red-500 @enderror" required>
            @error('name')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror" required>
            @error('email')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label class="block mb-1 font-medium">Nomor Telepon (Opsional)</label>
            <input type="tel" name="phone" value="{{ old('phone') }}" class="w-full border rounded px-3 py-2 @error('phone') border-red-500 @enderror">
            @error('phone')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label class="block mb-1 font-medium">Subjek</label>
            <input type="text" name="subject" value="{{ old('subject') }}" class="w-full border rounded px-3 py-2 @error('subject') border-red-500 @enderror" required>
            @error('subject')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <label class="block mb-1 font-medium">Pesan</label>
            <textarea name="message" rows="5" class="w-full border rounded px-3 py-2 @error('message') border-red-500 @enderror" required>{{ old('message') }}</textarea>
            @error('message')
                <span class="text-red-500 text-sm">{{ $message }}</span>
            @enderror
        </div>
        
        <div>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Kirim Pesan</button>
        </div>
    </form>
</div>
@endsection 