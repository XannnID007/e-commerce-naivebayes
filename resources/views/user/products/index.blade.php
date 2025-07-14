@extends('layouts.app')

@section('title', 'Daftar Produk - Philocalist')
@section('description', 'Jelajahi koleksi lengkap parfum Philocalist dengan berbagai kategori aroma yang telah
    diklasifikasi menggunakan AI')

@section('content')
    <div class="bg-white">
        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-50 to-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Koleksi Parfum</h1>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Temukan parfum berkualitas dengan sistem klasifikasi aroma menggunakan teknologi AI
                    </p>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Sidebar Filter -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8 lg:mb-0">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Produk</h3>

                        <!-- Search -->
                        <form method="GET" class="space-y-6">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                                    Cari Produk
                                </label>
                                <input type="text" id="search" name="search" value="{{ request('search') }}"
                                    placeholder="Nama produk, aroma..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                            </div>

                            <!-- Category Filter -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori Aroma
                                </label>
                                <select id="category" name="category"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                                    <option value="">Semua Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }} ({{ $category->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sort -->
                            <div>
                                <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">
                                    Urutkan
                                </label>
                                <select id="sort" name="sort"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                                    <option value="">Terbaru</option>
                                    <option value="nama" {{ request('sort') == 'nama' ? 'selected' : '' }}>Nama A-Z
                                    </option>
                                    <option value="harga_asc" {{ request('sort') == 'harga_asc' ? 'selected' : '' }}>Harga
                                        Terendah</option>
                                    <option value="harga_desc" {{ request('sort') == 'harga_desc' ? 'selected' : '' }}>Harga
                                        Tertinggi</option>
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit"
                                    class="flex-1 bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition-colors">
                                    <i class="fas fa-search mr-1"></i>Filter
                                </button>
                                <a href="{{ route('products.index') }}"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                                    Reset
                                </a>
                            </div>
                        </form>

                        <!-- Categories Quick Filter -->
                        <div class="mt-8">
                            <h4 class="text-sm font-medium text-gray-700 mb-4">Kategori Populer</h4>
                            <div class="space-y-2">
                                @foreach ($categories->take(6) as $category)
                                    <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                        class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 {{ request('category') == $category->id ? 'bg-pink-50 text-pink-700' : 'text-gray-600' }}">
                                        <span class="text-sm">{{ $category->nama }}</span>
                                        <span class="text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded-full">
                                            {{ $category->products_count }}
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="lg:col-span-3">
                    <!-- Results Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <p class="text-gray-600">
                                Menampilkan {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}
                                dari {{ $products->total() }} produk
                                @if (request('search'))
                                    untuk "<strong>{{ request('search') }}</strong>"
                                @endif
                            </p>
                        </div>

                        <!-- Mobile Filter Toggle -->
                        <button onclick="toggleMobileFilter()"
                            class="sm:hidden mt-4 px-4 py-2 bg-pink-600 text-white rounded-lg">
                            <i class="fas fa-filter mr-2"></i>Filter
                        </button>
                    </div>

                    <!-- Products Grid -->
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            @foreach ($products as $product)
                                <div
                                    class="bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden group">
                                    <a href="{{ route('products.show', $product) }}">
                                        <div class="relative overflow-hidden">
                                            <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}"
                                                class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                                onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">

                                            <!-- Category Badge -->
                                            <div class="absolute top-2 left-2">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                                    {{ $product->category->nama }}
                                                </span>
                                            </div>

                                            <!-- AI Confidence -->
                                            @if ($product->confidence_score)
                                                <div class="absolute top-2 right-2">
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white text-gray-800">
                                                        AI: {{ $product->confidence_score }}%
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-4">
                                            <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1">{{ $product->nama }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-2">{{ $product->konsentrasi_label }}</p>
                                            <p class="text-xs text-gray-500 mb-3 line-clamp-2">
                                                {{ Str::limit($product->deskripsi, 80) }}</p>

                                            <!-- Notes Preview -->
                                            @if ($product->top_notes || $product->middle_notes || $product->base_notes)
                                                <div class="mb-3">
                                                    <p class="text-xs text-gray-400 font-medium mb-1">Notes:</p>
                                                    <p class="text-xs text-gray-600 line-clamp-1">{{ $product->all_notes }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="flex items-center justify-between">
                                                <span
                                                    class="text-lg font-bold text-pink-600">{{ $product->formatted_harga }}</span>
                                                <span class="text-xs text-gray-500">Stok: {{ $product->stok }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $products->appends(request()->query())->links() }}
                        </div>
                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-search text-6xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Produk tidak ditemukan</h3>
                            <p class="text-gray-600 mb-6">
                                @if (request('search'))
                                    Tidak ada produk yang sesuai dengan pencarian "{{ request('search') }}"
                                @else
                                    Belum ada produk di kategori ini
                                @endif
                            </p>
                            <a href="{{ route('products.index') }}"
                                class="inline-flex items-center px-6 py-3 bg-pink-600 text-white font-medium rounded-lg hover:bg-pink-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i>Lihat Semua Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Filter Modal -->
    <div id="mobileFilterModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="toggleMobileFilter()"></div>
        <div class="fixed inset-y-0 left-0 w-80 bg-white shadow-xl p-6 overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold">Filter Produk</h3>
                <button onclick="toggleMobileFilter()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Mobile filter content akan sama dengan sidebar filter -->
            <div class="space-y-6">
                <!-- Content akan di-copy dari sidebar filter -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleMobileFilter() {
            const modal = document.getElementById('mobileFilterModal');
            modal.classList.toggle('hidden');
        }
    </script>
@endpush
