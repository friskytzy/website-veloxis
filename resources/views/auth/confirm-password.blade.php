@extends('layouts.app')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-center">Confirm Password</h2>
        <p class="text-center text-sm">This is a secure area of the application. Please confirm your password before continuing.</p>
        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium">Password</label>
                <input id="password" type="password" name="password" required autofocus class="mt-1 w-full border-gray-300 rounded shadow-sm focus:ring focus:ring-indigo-200">
                @error('password')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
            </div>
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700">Confirm</button>
        </form>
        <form method="POST" action="{{ route('logout') }}" class="mt-2 text-center">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:underline">Logout</button>
        </form>
    </div>
</div>
@endsection 