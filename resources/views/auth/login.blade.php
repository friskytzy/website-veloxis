@extends('layouts.app')

@section('title', 'Login - Veloxis Legends')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-900 py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md p-8 space-y-6 bg-gray-800 rounded-xl shadow-lg border border-gray-700">
        <div class="text-center">
            <h2 class="text-3xl font-oswald font-bold text-white">Welcome Back</h2>
            <p class="mt-2 text-sm text-gray-400">Sign in to access your Veloxis account</p>
        </div>
        
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div>
                <div class="flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <a href="{{ route('password.request') }}" class="text-sm text-red-500 hover:text-red-400 transition duration-300">
                        Forgot password?
                    </a>
                </div>
                <input id="password" type="password" name="password" required 
                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                @error('password')
                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded bg-gray-700 border-gray-600 text-red-600 focus:ring-red-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-300">Remember me</label>
            </div>
            
            <button type="submit" class="w-full py-3 px-4 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                Sign in
            </button>
        </form>
        
        <div class="text-center text-sm text-gray-400">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-red-500 hover:text-red-400 font-semibold transition duration-300">
                Register now
            </a>
        </div>
    </div>
</div>
@endsection 