@extends('layouts.app')

@section('title', $product->nama . ' - Philocalist')
@section('description', 'Detail produk ' . $product->nama . ' - ' . Str::limit($product->deskripsi, 150))

@section('content')
    <div class="bg-white">
        <!-- Breadcrumb -->
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <ol class="flex items-center space-x-2 text-sm text-gray-500">
                <li><a href="{{ route('home') }}" class="hover:text-pink-600">Beranda</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('products.index') }}" class="hover:text-pink-600">Produk</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li><a href="{{ route('products.index', ['category' => $product->category_id]) }}"
                        class="hover:text-pink-600">{{ $product->category->nama }}</a></li>
                <li><i class="fas fa-chevron-right text-xs"></i></li>
                <li class="text-gray-900 font-medium">{{ $product->nama }}</li>
            </ol>
        </nav>

        <!-- Product Detail -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-12">
                <!-- Product Image -->
                <div class="mb-8 lg:mb-0">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}" class="w-full h-full object-cover"
                            onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">
                    </div>

                    <!-- Additional Images (placeholder for future enhancement) -->
                    <div class="mt-4 grid grid-cols-4 gap-2">
                        @for ($i = 1; $i <= 4; $i++)
                            <div
                                class="aspect-square bg-gray-100 rounded border-2 border-transparent hover:border-pink-300 cursor-pointer">
                                <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}"
                                    class="w-full h-full object-cover rounded"
                                    onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Product Info -->
                <div>
                    <!-- Category & AI Badge -->
                    <div class="flex items-center gap-2 mb-4">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                            <i class="{{ $product->category->icon ?? 'fas fa-spray-can' }} mr-2"></i>
                            {{ $product->category->nama }}
                        </span>

                        @if ($product->confidence_score)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $product->confidence_score >= 80
                                ? 'bg-green-100 text-green-800'
                                : ($product->confidence_score >= 60
                                    ? 'bg-yellow-100 text-yellow-800'
                                    : 'bg-red-100 text-red-800') }}">
                                <i class="fas fa-brain mr-2"></i>
                                AI Confidence: {{ $product->confidence_score }}%
                            </span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->nama }}</h1>

                    <!-- Concentration -->
                    <p class="text-lg text-gray-600 mb-4">{{ $product->konsentrasi_label }}</p>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-3xl font-bold text-pink-600">{{ $product->formatted_harga }}</span>
                        <span class="text-sm text-gray-500 ml-2">Per botol</span>
                    </div>

                    <!-- Stock Status -->
                    <div class="mb-6">
                        @if ($product->stok > 0)
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-2"></i>
                                Stok tersedia ({{ $product->stok }} unit)
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-2"></i>
                                Stok habis
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $product->deskripsi }}</p>
                    </div>

                    <!-- Fragrance Notes -->
                    @if ($product->top_notes || $product->middle_notes || $product->base_notes)
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Notes Aroma</h3>
                            <div class="space-y-4">
                                @if ($product->top_notes)
                                    <div class="border-l-4 border-pink-400 pl-4">
                                        <h4 class="font-medium text-gray-900">Top Notes</h4>
                                        <p class="text-gray-600">{{ $product->top_notes }}</p>
                                    </div>
                                @endif

                                @if ($product->middle_notes)
                                    <div class="border-l-4 border-pink-500 pl-4">
                                        <h4 class="font-medium text-gray-900">Middle Notes</h4>
                                        <p class="text-gray-600">{{ $product->middle_notes }}</p>
                                    </div>
                                @endif

                                @if ($product->base_notes)
                                    <div class="border-l-4 border-pink-600 pl-4">
                                        <h4 class="font-medium text-gray-900">Base Notes</h4>
                                        <p class="text-gray-600">{{ $product->base_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ $product->shopee_link ?? '#' }}" target="_blank" rel="noopener noreferrer"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 transition-colors duration-300 ease-in-out shadow-lg transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                            <i class="fab fa-shopify mr-3"></i> {{-- Menggunakan ikon generik toko --}}
                            Beli di Shopee
                        </a>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="space-y-4 mt-8">
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Halo, saya tertarik dengan produk: ' . $product->nama) }}"
                                target="_blank" rel="noopener noreferrer"
                                class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-500 hover:bg-green-600 transition-colors duration-300 ease-in-out shadow-lg transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <i class="fab fa-whatsapp mr-3"></i>
                                Hubungi via WA
                            </a>
                            <button onclick="shareProduct()"
                                class="px-6 py-3 border border-pink-600 text-pink-600 rounded-lg font-medium hover:bg-pink-50 transition-colors">
                                <i class="fas fa-share mr-2"></i>Bagikan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- AI Classification Info -->
            @if ($product->confidence_score)
                <div class="mt-12 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-brain text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Klasifikasi AI</h3>
                        <p class="text-gray-600 mb-4">
                            Produk ini telah diklasifikasikan menggunakan algoritma Naive Bayes dengan tingkat kepercayaan
                            <strong>{{ $product->confidence_score }}%</strong> ke dalam kategori
                            <strong>{{ $product->category->nama }}</strong>.
                        </p>
                        <div class="flex justify-center">
                            <div class="bg-white rounded-lg px-6 py-3 shadow-sm">
                                <div class="flex items-center space-x-4">
                                    <div class="text-center">
                                        <div class="text-2xl font-bold text-blue-600">{{ $product->confidence_score }}%
                                        </div>
                                        <div class="text-xs text-gray-500">Akurasi AI</div>
                                    </div>
                                    <div class="text-center">
                                        <div class="text-lg font-semibold text-purple-600">{{ $product->category->nama }}
                                        </div>
                                        <div class="text-xs text-gray-500">Kategori Terprediksi</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Produk Serupa</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div
                                class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                                <a href="{{ route('products.show', $relatedProduct) }}">
                                    <div class="relative">
                                        <img src="{{ $relatedProduct->gambar_url }}" alt="{{ $relatedProduct->nama }}"
                                            class="w-full h-48 object-cover"
                                            onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">

                                        @if ($relatedProduct->confidence_score)
                                            <div class="absolute top-2 right-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white text-gray-800">
                                                    AI: {{ $relatedProduct->confidence_score }}%
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-4">
                                        <h3 class="font-semibold text-gray-900 mb-1 line-clamp-1">
                                            {{ $relatedProduct->nama }}</h3>
                                        <p class="text-sm text-gray-600 mb-2">{{ $relatedProduct->konsentrasi_label }}</p>
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-lg font-bold text-pink-600">{{ $relatedProduct->formatted_harga }}</span>
                                            <span class="text-xs text-gray-500">{{ $relatedProduct->stok }} stok</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function shareProduct() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $product->nama }} - Philocalist',
                    text: '{{ Str::limit($product->deskripsi, 100) }}',
                    url: window.location.href
                });
            } else {
                // Fallback - copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Link produk telah disalin ke clipboard!');
                });
            }
        }
    </script>
@endpush

@push('styles')
    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .aspect-square {
            aspect-ratio: 1 / 1;
        }
    </style>
@endpush
