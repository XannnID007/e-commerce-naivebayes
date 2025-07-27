<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Philocalist</title>

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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @stack('styles')
</head>

<body class="h-full bg-gray-50">
    <div class="min-h-full">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50" id="sidebar">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gradient-to-r from-pink-600 to-pink-700 shadow-sm">
                <h1 class="text-white text-xl font-bold tracking-wide">Philocalist Admin</h1>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-3">
                <div class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                        class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-pink-100 text-pink-700 border-r-2 border-pink-600' : 'text-gray-700 hover:bg-gray-100 hover:text-pink-600' }}">
                        <i
                            class="fas fa-tachometer-alt mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                        Dashboard
                    </a>

                    <!-- Manajemen Produk -->
                    <div class="mt-6">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2">
                            Manajemen Produk
                        </div>

                        <a href="{{ route('admin.products.index') }}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.products.*') ? 'bg-pink-100 text-pink-700 border-r-2 border-pink-600' : 'text-gray-700 hover:bg-gray-100 hover:text-pink-600' }}">
                            <i
                                class="fas fa-spray-can mr-3 {{ request()->routeIs('admin.products.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            Daftar Produk
                        </a>

                        <a href="{{ route('admin.categories.index') }}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.categories.*') ? 'bg-pink-100 text-pink-700 border-r-2 border-pink-600' : 'text-gray-700 hover:bg-gray-100 hover:text-pink-600' }}">
                            <i
                                class="fas fa-tags mr-3 {{ request()->routeIs('admin.categories.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            Kategori Aroma
                        </a>
                    </div>

                    <!-- Machine Learning -->
                    <div class="mt-6">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 py-2">
                            Machine Learning
                        </div>

                        <a href="{{ route('admin.training-data.index') }}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.training-data.*') ? 'bg-pink-100 text-pink-700 border-r-2 border-pink-600' : 'text-gray-700 hover:bg-gray-100 hover:text-pink-600' }}">
                            <i
                                class="fas fa-database mr-3 {{ request()->routeIs('admin.training-data.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            Data Training
                        </a>

                        <a href="{{ route('admin.model-evaluation.index') }}"
                            class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->routeIs('admin.model-evaluation.*') ? 'bg-pink-100 text-pink-700 border-r-2 border-pink-600' : 'text-gray-700 hover:bg-gray-100 hover:text-pink-600' }}">
                            <i
                                class="fas fa-chart-line mr-3 {{ request()->routeIs('admin.model-evaluation.*') ? 'text-pink-600' : 'text-gray-400 group-hover:text-pink-500' }}"></i>
                            Evaluasi Model
                        </a>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="ml-64 flex flex-col min-h-screen bg-gray-50">
            <!-- Top Navigation Bar - Fixed dengan z-index tinggi -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 right-0 left-64 z-40 h-16">
                <div class="px-6 h-full flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-4">
                            <!-- Page Title & Description -->
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                                <p class="text-sm text-gray-600 hidden sm:block">@yield('page-description', 'Selamat datang di admin dashboard')</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side Navigation -->
                    <div class="flex items-center space-x-4">

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center space-x-3 text-sm focus:outline-none">
                                <div
                                    class="w-8 h-8 bg-gradient-to-br from-pink-500 to-pink-600 rounded-full flex items-center justify-center shadow-sm">
                                    <span
                                        class="text-white font-medium text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <div class="hidden lg:block text-left">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">Administrator</p>
                                </div>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>

                                <a href="{{ route('home') }}"
                                    class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-home mr-3 text-gray-400"></i>Lihat Website
                                </a>

                                <div class="border-t border-gray-100 mt-1"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content dengan padding top yang cukup -->
            <main class="flex-1 pt-20 pb-8">
                <!-- Container dengan padding yang generous -->
                <div class="px-6 lg:px-8">
                    <!-- Alert Messages dengan margin yang baik -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg relative shadow-sm"
                            id="success-alert">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-3 text-green-500"></i>
                                <span class="block sm:inline">{{ session('success') }}</span>
                                <button
                                    class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer hover:text-green-900"
                                    onclick="closeAlert('success-alert')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm"
                            id="error-alert">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                                <span class="block sm:inline">{{ session('error') }}</span>
                                <button
                                    class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer hover:text-red-900"
                                    onclick="closeAlert('error-alert')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative shadow-sm"
                            id="validation-alert">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle mr-3 text-red-500 mt-0.5"></i>
                                <div class="flex-1">
                                    <h4 class="font-medium mb-2">Terdapat kesalahan pada form:</h4>
                                    <ul class="list-disc list-inside space-y-1 text-sm">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button class="ml-4 cursor-pointer hover:text-red-900"
                                    onclick="closeAlert('validation-alert')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Main Content Area -->
                    <div class="space-y-6">
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 lg:px-8 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="text-sm text-gray-500">
                        © {{ date('Y') }} Philocalist Admin. Semua hak cipta dilindungi.
                    </div>
                    <div class="mt-2 sm:mt-0 flex items-center space-x-4 text-sm text-gray-500">
                        <span>Laravel {{ app()->version() }}</span>
                        <span>•</span>
                        <span>PHP {{ PHP_VERSION }}</span>
                        <span>•</span>
                        <span>AI Powered</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        function closeAlert(id) {
            const alert = document.getElementById(id);
            if (alert) {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-10px)';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 300);
            }
        }

        // Auto close alerts after 8 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[id$="-alert"]');
            alerts.forEach(alert => {
                if (alert && alert.style.display !== 'none') {
                    closeAlert(alert.id);
                }
            });
        }, 8000);

        // Smooth scroll behavior
        document.documentElement.style.scrollBehavior = 'smooth';
    </script>

    @stack('scripts')
</body>

</html>
