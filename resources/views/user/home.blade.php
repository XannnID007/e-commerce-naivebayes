@extends('layouts.app')

@section('title', 'Philocalist - Parfum Berkualitas dengan AI')
@section('description',
    'Temukan parfum berkualitas dengan sistem klasifikasi aroma terdepan menggunakan teknologi AI.
    Koleksi lengkap parfum dari berbagai kategori aroma.')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-pink-50 to-white overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Temukan Parfum
                        <span class="text-pink-600">Sempurna</span>
                        untuk Anda
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Koleksi parfum berkualitas dengan sistem klasifikasi aroma menggunakan teknologi AI.
                        Temukan parfum yang sesuai dengan kepribadian dan preferensi Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index') }}"
                            class="inline-flex items-center justify-center px-8 py-3 bg-pink-600 text-white font-medium rounded-lg hover:bg-pink-700 transition-colors">
                            <i class="fas fa-search mr-2"></i>Jelajahi Produk
                        </a>
                        <a href="{{ route('about') }}"
                            class="inline-flex items-center justify-center px-8 py-3 border border-pink-600 text-pink-600 font-medium rounded-lg hover:bg-pink-50 transition-colors">
                            <i class="fas fa-info-circle mr-2"></i>Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                <div class="relative">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div
                                class="bg-white rounded-lg shadow-lg p-6 transform rotate-3 hover:rotate-0 transition-transform">
                                <i class="fas fa-spa text-pink-500 text-2xl mb-2"></i>
                                <h3 class="font-semibold text-gray-900">Floral</h3>
                                <p class="text-sm text-gray-600">Aroma bunga yang lembut</p>
                            </div>
                            <div
                                class="bg-white rounded-lg shadow-lg p-6 transform -rotate-2 hover:rotate-0 transition-transform">
                                <i class="fas fa-tree text-green-500 text-2xl mb-2"></i>
                                <h3 class="font-semibold text-gray-900">Woody</h3>
                                <p class="text-sm text-gray-600">Aroma kayu yang hangat</p>
                            </div>
                        </div>
                        <div class="space-y-4 mt-8">
                            <div
                                class="bg-white rounded-lg shadow-lg p-6 transform -rotate-3 hover:rotate-0 transition-transform">
                                <i class="fas fa-star text-yellow-500 text-2xl mb-2"></i>
                                <h3 class="font-semibold text-gray-900">Oriental</h3>
                                <p class="text-sm text-gray-600">Aroma eksotis & misterius</p>
                            </div>
                            <div
                                class="bg-white rounded-lg shadow-lg p-6 transform rotate-2 hover:rotate-0 transition-transform">
                                <i class="fas fa-leaf text-blue-500 text-2xl mb-2"></i>
                                <h3 class="font-semibold text-gray-900">Fresh</h3>
                                <p class="text-sm text-gray-600">Aroma segar & bersih</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Aroma</h2>
                <p class="text-lg text-gray-600">Jelajahi berbagai kategori aroma yang telah diklasifikasi dengan AI</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($categories as $category)
                    <a href="{{ route('products.index', ['category' => $category->id]) }}"
                        class="group bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 p-6 text-center">
                        <div
                            class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-pink-200 transition-colors">
                            <i class="{{ $category->icon ?? 'fas fa-spray-can' }} text-pink-600 text-xl"></i>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-2">{{ $category->nama }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ $category->deskripsi }}</p>
                        <div class="text-xs text-pink-600 font-medium">
                            {{ $category->products_count }} Produk
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    @if ($popularProducts->count() > 0)
        <section class="py-16 bg-pink-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Produk Populer</h2>
                    <p class="text-lg text-gray-600">Parfum favorit pilihan pelanggan</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($popularProducts as $product)
                        <div
                            class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                            <a href="{{ route('products.show', $product) }}">
                                <div class="relative overflow-hidden">
                                    <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}"
                                        class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                        onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">

                                    <!-- Popular Badge -->
                                    <div class="absolute top-2 left-2">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-star mr-1"></i>Populer
                                        </span>
                                    </div>
                                </div>

                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ $product->nama }}</h3>
                                    <p class="text-sm text-pink-600 mb-2">{{ $product->category->nama }}</p>
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="text-lg font-bold text-gray-900">{{ $product->formatted_harga }}</span>
                                        <div class="flex items-center text-yellow-500">
                                            <i class="fas fa-star text-sm"></i>
                                            <i class="fas fa-star text-sm"></i>
                                            <i class="fas fa-star text-sm"></i>
                                            <i class="fas fa-star text-sm"></i>
                                            <i class="fas fa-star text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('styles')
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endpush
