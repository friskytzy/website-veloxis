@extends('layouts.app')

@section('title', 'Reset Password - Veloxis Legends')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md p-8 space-y-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700">
        <div class="text-center">
            <h2 class="text-3xl font-oswald font-bold text-white">Reset Password</h2>
            <p class="mt-2 text-sm text-gray-400">Create a new password for your account</p>
        </div>
        
        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ request('token') }}">
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', request('email')) }}" required autofocus 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-300">New Password</label>
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
                Reset Password
            </button>
        </form>
        
        <div class="text-center text-sm text-gray-400">
            <a href="{{ route('login') }}" class="text-red-500 hover:text-red-400 font-semibold transition duration-300">
                Back to login
            </a>
        </div>
    </div>
</div>
@endsection 