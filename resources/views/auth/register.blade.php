@extends('layouts.app')

@section('title', 'Register - Veloxis Legends')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md p-8 space-y-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700">
        <div class="text-center">
            <h2 class="text-3xl font-oswald font-bold text-white">Join Veloxis Legends</h2>
            <p class="mt-2 text-sm text-gray-400">Create your account and start your journey</p>
        </div>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                @error('name')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                <input id="password" type="password" name="password" required 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
            </div>
            
            <button type="submit" class="w-full py-3 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                Register
            </button>
        </form>
        
        <div class="text-center text-sm text-gray-400">
            Already have an account? 
            <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 font-semibold transition duration-300">
                Sign in
            </a>
        </div>
    </div>
</div>
@endsection 