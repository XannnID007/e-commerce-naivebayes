<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Philocalist - Parfum Berkualitas')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Philocalist - Koleksi parfum berkualitas dengan sistem klasifikasi aroma menggunakan teknologi AI')">
    <meta name="keywords" content="parfum, fragrance, philocalist, aroma, scent, perfume">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'pink': {
                            50: '#fdf2f8',
                            100: '#fce7f3',
                            200: '#fbcfe8',
                            300: '#f9a8d4',
                            400: '#f472b6',
                            500: '#ec4899',
                            600: '#db2777',
                            700: '#be185d',
                            800: '#9d174d',
                            900: '#831843'
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="h-full bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center">
                        <div class="text-2xl font-bold text-pink-600">Philocalist</div>
                    </a>
                </div>

                <!-- Navigation Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-pink-600 border-b-2 border-pink-600' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('products.index') }}"
                        class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('products.*') ? 'text-pink-600 border-b-2 border-pink-600' : '' }}">
                        Produk
                    </a>
                    <a href="{{ route('about') }}"
                        class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('about') ? 'text-pink-600 border-b-2 border-pink-600' : '' }}">
                        Tentang
                    </a>
                    <a href="{{ route('contact') }}"
                        class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium {{ request()->routeIs('contact') ? 'text-pink-600 border-b-2 border-pink-600' : '' }}">
                        Kontak
                    </a>
                </div>

                <!-- Right Menu -->
                <div class="flex items-center space-x-4">
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="text-gray-700 hover:text-pink-600 px-3 py-2 text-sm font-medium">
                                <i class="fas fa-tachometer-alt mr-1"></i>Dashboard
                            </a>
                        @endif

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-2 text-gray-700 hover:text-pink-600">
                                <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center">
                                    <span
                                        class="text-white text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200">
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Login hanya untuk admin -->
                        <a href="{{ route('login') }}"
                            class="text-pink-600 hover:text-pink-800 px-3 py-2 text-sm font-medium">
                            Login
                        </a>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button class="md:hidden p-2 text-gray-700 hover:text-pink-600" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden border-t border-gray-200 py-4">
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:text-pink-600">Beranda</a>
                    <a href="{{ route('products.index') }}"
                        class="block px-3 py-2 text-gray-700 hover:text-pink-600">Produk</a>
                    <a href="{{ route('about') }}"
                        class="block px-3 py-2 text-gray-700 hover:text-pink-600">Tentang</a>
                    <a href="{{ route('contact') }}"
                        class="block px-3 py-2 text-gray-700 hover:text-pink-600">Kontak</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Brand -->
                <div class="col-span-1 md:col-span-2">
                    <h3 class="text-2xl font-bold text-pink-400 mb-4">Philocalist</h3>
                    <p class="text-gray-300 mb-4">
                        Koleksi parfum berkualitas dengan teknologi klasifikasi aroma menggunakan algoritma Naive Bayes.
                        Temukan parfum yang sesuai dengan preferensi Anda.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-pink-400">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-pink-400">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-pink-400">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-pink-400">
                            <i class="fab fa-youtube text-lg"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Tautan Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-pink-400">Beranda</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-gray-300 hover:text-pink-400">Semua
                                Produk</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-pink-400">Tentang Kami</a>
                        </li>
                        <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-pink-400">Hubungi Kami</a>
                        </li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Kategori Aroma</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('products.index', ['category' => 1]) }}"
                                class="text-gray-300 hover:text-pink-400">Floral</a></li>
                        <li><a href="{{ route('products.index', ['category' => 2]) }}"
                                class="text-gray-300 hover:text-pink-400">Woody</a></li>
                        <li><a href="{{ route('products.index', ['category' => 3]) }}"
                                class="text-gray-300 hover:text-pink-400">Oriental</a></li>
                        <li><a href="{{ route('products.index', ['category' => 4]) }}"
                                class="text-gray-300 hover:text-pink-400">Fresh</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Philocalist. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
