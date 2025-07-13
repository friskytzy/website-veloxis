<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <title>@yield('title', 'Veloxis Legends - Ride the Freedom')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet"/>
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Oswald', sans-serif;
        }
        .font-oswald {
            font-family: 'Oswald', sans-serif;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-900 text-gray-100">
    <!-- Navbar -->
    <nav class="bg-gray-800 fixed w-full z-30 top-0 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a class="flex items-center space-x-2" href="{{ route('home') }}">
                        <img alt="Veloxis Legends logo, stylized red TL letters on black background" class="h-10 w-10 rounded-full" height="40" src="https://storage.googleapis.com/a1aa/image/e82c0885-0c51-4458-0e08-0c56d261d2bb.jpg" width="40"/>
                        <span class="text-2xl font-bold tracking-wide">Veloxis Legends</span>
                    </a>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a class="hover:text-red-500 transition duration-300 font-semibold" href="{{ url('/products/bikes') }}">Bikes</a>
                    <a class="hover:text-red-500 transition duration-300 font-semibold" href="{{ url('/products/gear') }}">Gear</a>
                    <a class="hover:text-red-500 transition duration-300 font-semibold" href="{{ route('events.index') }}">Community</a>
                    <a class="hover:text-red-500 transition duration-300 font-semibold" href="{{ route('news.index') }}">News</a>
                    <a class="hover:text-red-500 transition duration-300 font-semibold" href="{{ route('contact.index') }}">Contact</a>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('cart.index') }}" class="relative hover:text-red-500 transition duration-300">
                            <i class="fas fa-shopping-cart text-xl"></i>
                            @if(session('cart_count', 0) > 0)
                                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ session('cart_count', 0) }}</span>
                            @endif
                        </a>
                        <div class="relative">
                            <button class="hover:text-red-500 transition duration-300" id="user-menu-btn">
                                <i class="fas fa-user text-xl"></i>
                            </button>
                            <div class="hidden absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50" id="user-menu">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-gray-700">Profile</a>
                                <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-sm hover:bg-gray-700">Order History</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-700">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hover:text-red-500 transition duration-300">Login</a>
                        <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-300">Register</a>
                    @endauth
                </div>
                <div class="md:hidden">
                    <button class="focus:outline-none" id="menu-btn">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="hidden md:hidden bg-gray-800 px-4 pt-2 pb-4 space-y-1" id="mobile-menu">
            <a class="block px-3 py-2 rounded-md text-base font-semibold hover:text-red-500" href="{{ url('/products/bikes') }}">Bikes</a>
            <a class="block px-3 py-2 rounded-md text-base font-semibold hover:text-red-500" href="{{ url('/products/gear') }}">Gear</a>
            <a class="block px-3 py-2 rounded-md text-base font-semibold hover:text-red-500" href="{{ route('events.index') }}">Community</a>
            <a class="block px-3 py-2 rounded-md text-base font-semibold hover:text-red-500" href="{{ route('news.index') }}">News</a>
            <a class="block px-3 py-2 rounded-md text-base font-semibold hover:text-red-500" href="{{ route('contact.index') }}">Contact</a>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-16">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-gray-400 text-sm">
            <p>© 2024 Veloxis Legends. All rights reserved.</p>
            <div class="flex space-x-6 mt-4 md:mt-0">
                <a aria-label="Facebook" class="hover:text-red-600 transition duration-300" href="#">
                    <i class="fab fa-facebook-f fa-lg"></i>
                </a>
                <a aria-label="Twitter" class="hover:text-red-600 transition duration-300" href="#">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>
                <a aria-label="Instagram" class="hover:text-red-600 transition duration-300" href="#">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
                <a aria-label="YouTube" class="hover:text-red-600 transition duration-300" href="#">
                    <i class="fab fa-youtube fa-lg"></i>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // User menu toggle
        const userMenuBtn = document.getElementById('user-menu-btn');
        const userMenu = document.getElementById('user-menu');

        if (userMenuBtn && userMenu) {
            userMenuBtn.addEventListener('click', () => {
                userMenu.classList.toggle('hidden');
            });
        }
    </script>

    @stack('scripts')
</body>
</html> 