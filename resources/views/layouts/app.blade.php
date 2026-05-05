<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="description" content="VELOXIS adalah e-commerce sparepart motor asli dan terpercaya untuk Honda, Yamaha, Suzuki, Kawasaki, dan motor harian Indonesia.">
    <title>@yield('title', 'VELOXIS - Suku Cadang Motor, Asli & Terpercaya')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        veloxis: {
                            red: '#E63946',
                            navy: '#1D3557',
                            orange: '#F4A261',
                            cream: '#F1FAEE',
                            dark: '#2B2D42'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'Roboto', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    @stack('styles')
</head>
<body class="bg-veloxis-cream text-veloxis-dark antialiased">
    <div class="bg-veloxis-navy text-white text-xs sm:text-sm">
        <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-2 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <p><i class="fas fa-shield-alt mr-2 text-veloxis-orange"></i>Genuine guarantee, retur 30 hari, dan checkout tanpa registrasi.</p>
            <p><i class="fas fa-phone-alt mr-2 text-veloxis-orange"></i>WhatsApp CS: +62 812-VELOXIS</p>
        </div>
    </div>

    <nav class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 shadow-sm backdrop-blur">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-20 items-center justify-between gap-4">
                <a class="flex items-center gap-3" href="{{ route('home') }}" aria-label="VELOXIS homepage">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-veloxis-red text-xl font-black text-white shadow-lg shadow-red-200">VX</span>
                    <span>
                        <span class="block text-2xl font-black tracking-tight text-veloxis-navy">VELOXIS</span>
                        <span class="hidden text-xs font-semibold uppercase tracking-[0.24em] text-slate-500 sm:block">Sparepart Motor</span>
                    </span>
                </a>

                <form action="{{ route('veloxis.spareparts') }}" method="GET" class="hidden flex-1 lg:block">
                    <label for="top-search" class="sr-only">Cari sparepart</label>
                    <div class="relative mx-auto max-w-xl">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input id="top-search" name="search" value="{{ request('search') }}" list="top-search-suggestions" placeholder="Cari oli, kampas rem, ban NMax..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm outline-none transition focus:border-veloxis-red focus:bg-white focus:ring-4 focus:ring-red-100">
                        <datalist id="top-search-suggestions">
                            <option value="Oli Honda Beat"></option>
                            <option value="Ban Yamaha NMax"></option>
                            <option value="Kampas rem genuine"></option>
                            <option value="Aki Yuasa"></option>
                        </datalist>
                    </div>
                </form>

                <div class="hidden items-center gap-6 font-semibold text-slate-700 md:flex">
                    <a class="hover:text-veloxis-red" href="{{ route('veloxis.spareparts') }}">Sparepart</a>
                    <a class="hover:text-veloxis-red" href="{{ route('veloxis.spareparts', ['category' => 'Oli']) }}">Oli</a>
                    <a class="hover:text-veloxis-red" href="{{ route('veloxis.spareparts', ['category' => 'Ban']) }}">Ban</a>
                    <a class="hover:text-veloxis-red" href="{{ route('contact.index') }}">Kontak</a>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('veloxis.cart') }}" class="relative rounded-2xl border border-slate-200 px-4 py-3 text-veloxis-navy hover:border-veloxis-red hover:text-veloxis-red" aria-label="Keranjang belanja">
                        <i class="fas fa-shopping-cart"></i>
                        @php($cartCount = array_sum(session('veloxis_cart', [])))
                        @if($cartCount > 0)
                            <span class="absolute -right-2 -top-2 grid h-5 w-5 place-items-center rounded-full bg-veloxis-red text-xs font-bold text-white">{{ $cartCount }}</span>
                        @endif
                    </a>
                    @auth
                        <a href="{{ route('orders.history') }}" class="hidden rounded-2xl bg-veloxis-navy px-4 py-3 text-sm font-bold text-white hover:bg-veloxis-dark sm:inline-flex">Akun</a>
                    @else
                        <a href="{{ route('login') }}" class="hidden rounded-2xl bg-veloxis-navy px-4 py-3 text-sm font-bold text-white hover:bg-veloxis-dark sm:inline-flex">Login</a>
                    @endauth
                    <button class="rounded-xl p-2 text-2xl text-veloxis-navy md:hidden" id="menu-btn" aria-label="Buka menu"><i class="fas fa-bars"></i></button>
                </div>
            </div>

            <form action="{{ route('veloxis.spareparts') }}" method="GET" class="pb-4 lg:hidden">
                <label for="mobile-search" class="sr-only">Cari sparepart</label>
                <input id="mobile-search" name="search" placeholder="Cari sparepart motor..." class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-veloxis-red focus:ring-4 focus:ring-red-100">
            </form>
        </div>
        <div class="hidden border-t border-slate-100 bg-white px-4 py-3 md:hidden" id="mobile-menu">
            <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-50" href="{{ route('veloxis.spareparts') }}">Sparepart</a>
            <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-50" href="{{ route('veloxis.spareparts', ['motor_brand' => 'Honda']) }}">Honda</a>
            <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-50" href="{{ route('veloxis.spareparts', ['motor_brand' => 'Yamaha']) }}">Yamaha</a>
            <a class="block rounded-xl px-3 py-2 font-semibold hover:bg-slate-50" href="{{ route('contact.index') }}">Kontak</a>
        </div>
    </nav>

    <main>
        @if (session('success'))
            <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 font-semibold text-green-800">{{ session('success') }}</div>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-veloxis-navy text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-4 lg:px-8">
            <div class="md:col-span-2">
                <div class="mb-4 flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-veloxis-red text-xl font-black">VX</span>
                    <div>
                        <p class="text-2xl font-black">VELOXIS</p>
                        <p class="text-sm text-slate-300">Suku Cadang Motor, Asli & Terpercaya</p>
                    </div>
                </div>
                <p class="max-w-md text-sm leading-6 text-slate-300">Platform e-commerce sparepart motor Indonesia dengan pencarian berbasis merek, stok real-time, dan jaminan genuine untuk mekanik maupun pemilik motor harian.</p>
            </div>
            <div>
                <h3 class="mb-4 font-bold">Bantuan</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li><a href="{{ route('contact.index') }}" class="hover:text-white">Kontak CS</a></li>
                    <li><a href="{{ route('veloxis.checkout') }}" class="hover:text-white">Cara Order</a></li>
                    <li><a href="#" class="hover:text-white">Retur & Garansi</a></li>
                    <li><a href="#" class="hover:text-white">Kebijakan Privasi</a></li>
                </ul>
            </div>
            <div>
                <h3 class="mb-4 font-bold">Keamanan</h3>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li><i class="fas fa-lock mr-2 text-veloxis-orange"></i>SSL checkout</li>
                    <li><i class="fas fa-undo mr-2 text-veloxis-orange"></i>Retur 30 hari</li>
                    <li><i class="fas fa-certificate mr-2 text-veloxis-orange"></i>Genuine guarantee</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-sm text-slate-300">© 2026 VELOXIS. All rights reserved.</div>
    </footer>

    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => mobileMenu.classList.toggle('hidden'));
        }
    </script>
    @stack('scripts')
</body>
</html>
