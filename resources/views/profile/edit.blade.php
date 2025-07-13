@extends('layouts.app')

@section('title', 'Edit Profile - Veloxis Legends')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-oswald font-bold text-white mb-8">Profile Settings</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-1">
            <div class="bg-gray-800 p-6 rounded-xl shadow-md border border-gray-700">
                <h3 class="font-oswald text-xl font-bold mb-4 text-white">Navigation</h3>
                <nav class="flex flex-col space-y-2">
                    <a href="#profile-info" class="text-gray-300 hover:text-red-500 transition">Profile Information</a>
                    <a href="#update-password" class="text-gray-300 hover:text-red-500 transition">Update Password</a>
                    <a href="#delete-account" class="text-gray-300 hover:text-red-500 transition">Delete Account</a>
                </nav>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">
            <!-- Profile Information -->
            <div id="profile-info" class="bg-gray-800 p-6 rounded-xl shadow-md border border-gray-700">
                <h3 class="font-oswald text-xl font-bold mb-4 text-white">Profile Information</h3>
                <p class="text-gray-400 mb-4">Update your account's profile information and email address.</p>

                @if (session('status') === 'profile-updated')
                    <div class="bg-gray-700 border-l-4 border-green-500 text-green-400 p-4 rounded-lg mb-4">
                        Profile updated successfully.
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus 
                            class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('name')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                            class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('email')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 focus:outline-none">
                            Save
                        </button>
                    </div>
                </form>
            </div>

            <!-- Update Password -->
            <div id="update-password" class="bg-gray-800 p-6 rounded-xl shadow-md border border-gray-700">
                <h3 class="font-oswald text-xl font-bold mb-4 text-white">Update Password</h3>
                <p class="text-gray-400 mb-4">Ensure your account is using a secure password.</p>

                @if (session('status') === 'password-updated')
                    <div class="bg-gray-700 border-l-4 border-green-500 text-green-400 p-4 rounded-lg mb-4">
                        Password updated successfully.
                    </div>
                @endif

                <form method="post" action="{{ route('profile.password.update') }}" class="space-y-4">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-300">Current Password</label>
                        <input id="current_password" name="current_password" type="password" required
                            class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('current_password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">New Password</label>
                        <input id="password" name="password" type="password" required
                            class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('password')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-300">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('password_confirmation')
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 focus:outline-none">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Delete Account -->
            <div id="delete-account" class="bg-gray-800 p-6 rounded-xl shadow-md border border-gray-700">
                <h3 class="font-oswald text-xl font-bold mb-4 text-white">Delete Account</h3>
                <p class="text-gray-400 mb-4">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Before
                    deleting your account, please download any data or information that you wish to retain.
                </p>

                <button type="button" onclick="document.getElementById('confirm-delete-modal').classList.remove('hidden')" 
                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 focus:outline-none">
                    Delete Account
                </button>

                <!-- Delete Account Confirmation Modal -->
                <div id="confirm-delete-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                    <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 border border-gray-700">
                        <h4 class="font-oswald text-xl font-bold mb-4 text-white">Are you sure you want to delete your account?</h4>
                        <p class="text-gray-400 mb-6">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Please
                            enter your password to confirm you would like to permanently delete your account.
                        </p>

                        <form method="post" action="{{ route('profile.destroy') }}" class="space-y-4">
                            @csrf
                            @method('delete')

                            <div>
                                <label for="delete-password" class="block text-sm font-medium text-gray-300">Password</label>
                                <input id="delete-password" name="password" type="password" required
                                    class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                @error('password')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="document.getElementById('confirm-delete-modal').classList.add('hidden')"
                                    class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 focus:outline-none">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-300 focus:outline-none">
                                    Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 