@extends('layouts.app')

@section('title', 'Tentang Kami - Philocalist')
@section('description', 'Pelajari lebih lanjut tentang Philocalist dan teknologi AI yang kami gunakan untuk mengklasifikasikan parfum')

@section('content')
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-pink-50 via-white to-purple-50 py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                    <i class="fas fa-spray-can text-white text-2xl"></i>
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">Tentang Philocalist</h1>
                <p class="text-xl text-gray-600 leading-relaxed max-w-3xl mx-auto">
                    Menggabungkan seni parfum tradisional dengan teknologi AI untuk menciptakan pengalaman berbelanja parfum yang revolusioner
                </p>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Story Section -->
            <div class="prose prose-lg max-w-none">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-8">Cerita Kami</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                        <div class="text-left space-y-6">
                            <p class="text-gray-700 leading-relaxed">
                                Philocalist didirikan pada tahun 2024 dengan visi menciptakan produk parfum berkualitas tinggi yang dapat bersaing dengan brand internasional. Nama "Philocalist" berasal dari bahasa Yunani yang berarti <em>"orang yang mencintai keindahan"</em>.
                            </p>
                            
                            <p class="text-gray-700 leading-relaxed">
                                Kami memulai perjalanan dengan sistem pre-order dan penjualan langsung melalui media sosial. Kini, Philocalist telah memiliki lebih dari 50 varian produk dengan berbagai konsentrasi yang telah mendapat pengakuan dari komunitas parfum lokal.
                            </p>
                        </div>

                        <div class="relative">
                            <div class="bg-gradient-to-br from-pink-100 to-purple-100 rounded-2xl p-8 text-center">
                                <div class="grid grid-cols-2 gap-6">
                                    <div>
                                        <div class="text-3xl font-bold text-pink-600">50+</div>
                                        <div class="text-sm text-gray-600">Varian Produk</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-purple-600">95%</div>
                                        <div class="text-sm text-gray-600">Akurasi AI</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-blue-600">8</div>
                                        <div class="text-sm text-gray-600">Kategori Aroma</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-green-600">2024</div>
                                        <div class="text-sm text-gray-600">Tahun Berdiri</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fragrance Categories -->
    <section class="py-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kategori Aroma</h2>
                <p class="text-lg text-gray-600">
                    Sistem AI mengklasifikasikan parfum ke dalam 8 kategori aroma utama
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Floral -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-pink-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-spa text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Floral</h3>
                    <p class="text-sm text-gray-600">Aroma bunga yang lembut</p>
                </div>

                <!-- Woody -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-tree text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Woody</h3>
                    <p class="text-sm text-gray-600">Aroma kayu yang hangat</p>
                </div>

                <!-- Oriental -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Oriental</h3>
                    <p class="text-sm text-gray-600">Aroma eksotis</p>
                </div>

                <!-- Fresh -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Fresh</h3>
                    <p class="text-sm text-gray-600">Aroma segar</p>
                </div>

                <!-- Citrus -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lemon text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Citrus</h3>
                    <p class="text-sm text-gray-600">Aroma jeruk</p>
                </div>

                <!-- Fougère -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-seedling text-emerald-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Fougère</h3>
                    <p class="text-sm text-gray-600">Aroma herbal</p>
                </div>

                <!-- Chypre -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-mountain text-gray-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Chypre</h3>
                    <p class="text-sm text-gray-600">Aroma kompleks</p>
                </div>

                <!-- Gourmand -->
                <div class="text-center p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-cookie-bite text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Gourmand</h3>
                    <p class="text-sm text-gray-600">Aroma manis</p>
                </div>
            </div>
        </div>
    </section>
@endsection