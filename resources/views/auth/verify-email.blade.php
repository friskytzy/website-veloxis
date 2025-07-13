@extends('layouts.app')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-8 space-y-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-center">Verify Your Email</h2>
        <p class="text-center text-sm">Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn't receive the email, we will gladly send you another.</p>
        @if (session('status') == 'verification-link-sent')
            <div class="text-green-600 text-center text-sm">A new verification link has been sent to your email address.</div>
        @endif
        <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
            @csrf
            <button type="submit" class="w-full py-2 px-4 bg-indigo-600 text-white rounded hover:bg-indigo-700">Resend Verification Email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}" class="mt-2 text-center">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:underline">Logout</button>
        </form>
    </div>
</div>
@endsection 