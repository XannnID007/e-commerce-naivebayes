@extends('layouts.app')

@section('title', 'Tentang Kami - Philocalist')
@section('description', 'Pelajari lebih lanjut tentang Philocalist dan teknologi AI yang kami gunakan untuk
    mengklasifikasikan parfum')

@section('content')
    <div class="bg-white">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-pink-50 to-white py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Tentang Philocalist</h1>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        Menggabungkan seni parfum tradisional dengan teknologi AI untuk menciptakan pengalaman berbelanja
                        parfum yang revolusioner
                    </p>
                </div>
            </div>
        </div>

        <!-- Story Section -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Cerita Kami</h2>
                        <div class="space-y-4 text-gray-700">
                            <p>
                                Philocalist didirikan pada tahun 2024 dengan visi menciptakan produk parfum berkualitas
                                tinggi yang dapat bersaing dengan brand internasional. Nama "Philocalist" berasal dari
                                bahasa Yunani yang berarti "orang yang mencintai keindahan", mencerminkan dedikasi kami
                                dalam menciptakan produk yang tidak hanya harum tetapi juga merepresentasikan nilai
                                estetika.
                            </p>
                            <p>
                                Kami memulai perjalanan dengan sistem pre-order dan penjualan langsung melalui media sosial.
                                Namun, seiring dengan perkembangan teknologi dan bertambahnya varian produk, kami menyadari
                                perlunya sistem yang lebih canggih untuk membantu pelanggan menemukan parfum yang sesuai
                                dengan preferensi mereka.
                            </p>
                            <p>
                                Kini, Philocalist telah memiliki lebih dari 50 varian produk dengan berbagai konsentrasi
                                mulai dari Eau de Cologne (EDC), Eau de Toilette (EDT), hingga Eau de Parfum (EDP), yang
                                telah mendapat pengakuan dari komunitas parfum lokal.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 lg:mt-0">
                        <div class="bg-gradient-to-r from-pink-400 to-pink-600 rounded-lg p-8 text-white">
                            <h3 class="text-2xl font-bold mb-4">Visi Kami</h3>
                            <p class="mb-6">
                                Menjadi industri parfum yang berkelanjutan dan inovatif, dengan menghadirkan aroma yang
                                memikat dan berkualitas yang menginspirasi kepercayaan diri dan kebahagiaan bagi setiap
                                individu.
                            </p>

                            <h3 class="text-2xl font-bold mb-4">Misi Kami</h3>
                            <ul class="space-y-2">
                                <li class="flex items-start">
                                    <i class="fas fa-check mr-3 mt-1"></i>
                                    <span>Terus berinovasi dalam menciptakan produk parfum yang ramah lingkungan dan
                                        berkelanjutan</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check mr-3 mt-1"></i>
                                    <span>Memberikan pengalaman pelanggan yang luar biasa melalui layanan yang responsif dan
                                        profesional</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-check mr-3 mt-1"></i>
                                    <span>Mendukung ekonomi lokal melalui kerjasama dengan komunitas</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Technology Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Teknologi AI Kami</h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Kami menggunakan algoritma Naive Bayes untuk mengklasifikasikan parfum ke dalam berbagai kategori
                        aroma secara otomatis
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-brain text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Algoritma Naive Bayes</h3>
                        <p class="text-gray-600">
                            Menggunakan machine learning untuk menganalisis deskripsi dan karakteristik parfum, kemudian
                            mengklasifikasikan ke dalam 8 kategori aroma utama.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-chart-line text-green-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Akurasi Tinggi</h3>
                        <p class="text-gray-600">
                            Sistem kami mencapai tingkat akurasi klasifikasi di atas 85%, memastikan pengelompokan parfum
                            yang tepat berdasarkan karakteristik aromanya.
                        </p>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                            <i class="fas fa-sync-alt text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Pembelajaran Berkelanjutan</h3>
                        <p class="text-gray-600">
                            Model AI kami terus belajar dari data baru untuk meningkatkan akurasi klasifikasi dan memberikan
                            rekomendasi yang lebih baik.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Fragrance Categories -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Aroma</h2>
                    <p class="text-lg text-gray-600">
                        Sistem AI kami mengklasifikasikan parfum ke dalam 8 kategori aroma utama berdasarkan Michael
                        Edwards' Fragrance Wheel
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $fragranceCategories = [
                            [
                                'name' => 'Floral',
                                'icon' => 'fas fa-flower',
                                'color' => 'pink',
                                'desc' => 'Aroma bunga yang lembut dan feminin',
                            ],
                            [
                                'name' => 'Woody',
                                'icon' => 'fas fa-tree',
                                'color' => 'green',
                                'desc' => 'Aroma kayu yang hangat dan maskulin',
                            ],
                            [
                                'name' => 'Oriental',
                                'icon' => 'fas fa-star',
                                'color' => 'yellow',
                                'desc' => 'Aroma eksotis dengan rempah-rempah',
                            ],
                            [
                                'name' => 'Fresh',
                                'icon' => 'fas fa-leaf',
                                'color' => 'blue',
                                'desc' => 'Aroma segar dan bersih',
                            ],
                            [
                                'name' => 'Citrus',
                                'icon' => 'fas fa-lemon',
                                'color' => 'orange',
                                'desc' => 'Aroma jeruk yang menyegarkan',
                            ],
                            [
                                'name' => 'Fougère',
                                'icon' => 'fas fa-seedling',
                                'color' => 'green',
                                'desc' => 'Aroma herbal dengan lavender',
                            ],
                            [
                                'name' => 'Chypre',
                                'icon' => 'fas fa-mountain',
                                'color' => 'gray',
                                'desc' => 'Aroma kompleks dengan oakmoss',
                            ],
                            [
                                'name' => 'Gourmand',
                                'icon' => 'fas fa-cookie',
                                'color' => 'red',
                                'desc' => 'Aroma manis seperti makanan',
                            ],
                        ];
                    @endphp

                    @foreach ($fragranceCategories as $category)
                        <div class="text-center p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div
                                class="w-16 h-16 bg-{{ $category['color'] }}-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="{{ $category['icon'] }} text-{{ $category['color'] }}-600 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $category['name'] }}</h3>
                            <p class="text-sm text-gray-600">{{ $category['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="py-16 bg-pink-600">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-bold text-white mb-4">
                    Siap Merasakan Pengalaman Berbelanja Parfum dengan AI?
                </h2>
                <p class="text-xl text-pink-100 mb-8">
                    Jelajahi koleksi kami dan biarkan teknologi AI membantu Anda menemukan parfum yang sempurna
                </p>
                <a href="{{ route('products.index') }}"
                    class="inline-flex items-center px-8 py-3 bg-white text-pink-600 font-medium rounded-lg hover:bg-gray-100 transition-colors">
                    <i class="fas fa-search mr-2"></i>Mulai Jelajahi Produk
                </a>
            </div>
        </div>
    </div>
@endsection
