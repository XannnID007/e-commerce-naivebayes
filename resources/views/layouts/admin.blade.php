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
<body class="h-full">
    <div class="min-h-full">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg z-50" id="sidebar">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-pink-600">
                <h1 class="text-white text-xl font-bold">Philocalist Admin</h1>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-8">
                <div class="px-4 space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas fa-tachometer-alt mr-3 text-pink-500"></i>
                        Dashboard
                    </a>
                    
                    <!-- Manajemen Produk -->
                    <div class="space-y-1">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 py-1">
                            Manajemen Produk
                        </div>
                        
                        <a href="{{ route('admin.products.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.products.*') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-spray-can mr-3 text-pink-500"></i>
                            Daftar Produk
                        </a>
                        
                        <a href="{{ route('admin.categories.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.categories.*') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-tags mr-3 text-pink-500"></i>
                            Kategori Aroma
                        </a>
                    </div>
                    
                    <!-- Machine Learning -->
                    <div class="space-y-1 mt-6">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 py-1">
                            Machine Learning
                        </div>
                        
                        <a href="{{ route('admin.training-data.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.training-data.*') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-database mr-3 text-pink-500"></i>
                            Data Training
                        </a>
                        
                        <a href="{{ route('admin.model-evaluation.index') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.model-evaluation.*') ? 'bg-pink-100 text-pink-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            <i class="fas fa-chart-line mr-3 text-pink-500"></i>
                            Evaluasi Model
                        </a>
                    </div>
                    
                    <!-- Laporan -->
                    <div class="space-y-1 mt-6">
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-2 py-1">
                            Laporan
                        </div>
                        
                        <a href="{{ route('admin.reports.products') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-file-alt mr-3 text-pink-500"></i>
                            Laporan Produk
                        </a>
                        
                        <a href="{{ route('admin.reports.classifications') }}" 
                           class="group flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-chart-bar mr-3 text-pink-500"></i>
                            Laporan Klasifikasi
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="ml-64 flex flex-col min-h-screen">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm border-b border-gray-200 fixed top-0 right-0 left-64 z-40">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                            <p class="text-sm text-gray-600">@yield('page-description', 'Selamat datang di admin dashboard')</p>
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Notifications -->
                            <button class="p-2 text-gray-400 hover:text-gray-600">
                                <i class="fas fa-bell text-lg"></i>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center space-x-2 text-sm text-gray-700 hover:text-gray-900">
                                    <div class="w-8 h-8 bg-pink-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span>{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" 
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg border border-gray-200">
                                    <div class="py-1">
                                        <a href="{{ route('home') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-home mr-2"></i>Lihat Website
                                        </a>
                                        <div class="border-t border-gray-100"></div>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 pt-20 p-6">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" id="success-alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert('success-alert')">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" id="error-alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="closeAlert('error-alert')">
                            <i class="fas fa-times"></i>
                        </span>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <script>
        function closeAlert(id) {
            document.getElementById(id).style.display = 'none';
        }
        
        // Auto close alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('[id$="-alert"]');
            alerts.forEach(alert => {
                if (alert) alert.style.display = 'none';
            });
        }, 5000);
    </script>
    
    @stack('scripts')
</body>
</html>