@extends('layouts.admin')

@section('title', 'Detail Produk - ' . $product->nama)
@section('page-title', 'Detail Produk')
@section('page-description', 'Informasi lengkap produk ' . $product->nama)

@section('content')
    <div class="space-y-6">
        <!-- Breadcrumb & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <nav class="text-sm breadcrumbs">
                <ol class="list-none p-0 inline-flex">
                    <li class="flex items-center">
                        <a href="{{ route('admin.products.index') }}" class="text-pink-600 hover:text-pink-800">
                            <i class="fas fa-spray-can mr-1"></i>Daftar Produk
                        </a>
                    </li>
                    <li class="mx-2 text-gray-500">/</li>
                    <li class="text-gray-700 font-medium">{{ $product->nama }}</li>
                </ol>
            </nav>

            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('admin.products.edit', $product) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700">
                    <i class="fas fa-edit mr-2"></i>Edit Produk
                </a>
                
                @if($product->confidence_score)
                    <button onclick="reclassifyProduct()"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                        <i class="fas fa-brain mr-2"></i>Klasifikasi Ulang
                    </button>
                @endif

                <button onclick="deleteProduct()"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700">
                    <i class="fas fa-trash mr-2"></i>Hapus
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Product Image -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                    <!-- Product Image -->
                    <div class="aspect-square bg-gray-100">
                        <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}" 
                             class="w-full h-full object-cover"
                             onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">
                    </div>

                    <!-- Image Info -->
                    <div class="p-4 border-t">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Informasi Gambar</h4>
                        @if($product->gambar)
                            <div class="text-sm text-gray-600 space-y-1">
                                <p><strong>File:</strong> {{ basename($product->gambar) }}</p>
                                <p><strong>Path:</strong> {{ $product->gambar }}</p>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">Belum ada gambar yang diupload</p>
                        @endif
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mt-6 bg-white rounded-lg shadow-sm p-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Statistik Cepat</h4>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $product->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $product->aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Stok:</span>
                            <span class="font-medium {{ $product->stok > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $product->stok }} unit
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dibuat:</span>
                            <span class="text-gray-900">{{ $product->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diupdate:</span>
                            <span class="text-gray-900">{{ $product->updated_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Product Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $product->nama }}</h2>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-pink-600">{{ $product->formatted_harga }}</div>
                            <div class="text-sm text-gray-500">{{ $product->konsentrasi_label }}</div>
                        </div>
                    </div>

                    <!-- Category & AI Classification -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-pink-100 text-pink-800">
                            <i class="{{ $product->category->icon ?? 'fas fa-spray-can' }} mr-2"></i>
                            {{ $product->category->nama }}
                        </span>

                        @if($product->confidence_score)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $product->confidence_score >= 80 ? 'bg-green-100 text-green-800' : 
                                   ($product->confidence_score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <i class="fas fa-brain mr-2"></i>
                                AI Confidence: {{ $product->confidence_score }}%
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <i class="fas fa-user mr-2"></i>
                                Manual Classification
                            </span>
                        @endif

                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $product->konsentrasi }}
                        </span>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Deskripsi Produk</h4>
                        <p class="text-gray-700 leading-relaxed">{{ $product->deskripsi }}</p>
                    </div>

                    <!-- Product Details Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Informasi Produk</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between py-1">
                                    <dt class="text-sm text-gray-600">ID Produk:</dt>
                                    <dd class="text-sm font-medium text-gray-900">#{{ $product->id }}</dd>
                                </div>
                                <div class="flex justify-between py-1">
                                    <dt class="text-sm text-gray-600">Konsentrasi:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $product->konsentrasi_label }}</dd>
                                </div>
                                <div class="flex justify-between py-1">
                                    <dt class="text-sm text-gray-600">Harga:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $product->formatted_harga }}</dd>
                                </div>
                                <div class="flex justify-between py-1">
                                    <dt class="text-sm text-gray-600">Stok:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $product->stok }} unit</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-900 mb-3">Klasifikasi</h4>
                            <dl class="space-y-2">
                                <div class="flex justify-between py-1">
                                    <dt class="text-sm text-gray-600">Kategori:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $product->category->nama }}</dd>
                                </div>
                                @if($product->confidence_score)
                                    <div class="flex justify-between py-1">
                                        <dt class="text-sm text-gray-600">AI Confidence:</dt>
                                        <dd class="text-sm font-medium text-gray-900">{{ $product->confidence_score }}%</dd>
                                    </div>
                                    <div class="flex justify-between py-1">
                                        <dt class="text-sm text-gray-600">Metode:</dt>
                                        <dd class="text-sm font-medium text-blue-600">Naive Bayes AI</dd>
                                    </div>
                                @else
                                    <div class="flex justify-between py-1">
                                        <dt class="text-sm text-gray-600">Metode:</dt>
                                        <dd class="text-sm font-medium text-gray-600">Manual</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Fragrance Notes -->
                @if($product->top_notes || $product->middle_notes || $product->base_notes)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Notes Aroma</h3>
                        
                        <div class="space-y-4">
                            @if($product->top_notes)
                                <div class="border-l-4 border-pink-400 pl-4">
                                    <h4 class="font-medium text-gray-900 mb-1">Top Notes</h4>
                                    <p class="text-gray-700">{{ $product->top_notes }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Aroma yang pertama tercium (5-15 menit)</p>
                                </div>
                            @endif

                            @if($product->middle_notes)
                                <div class="border-l-4 border-pink-500 pl-4">
                                    <h4 class="font-medium text-gray-900 mb-1">Middle Notes (Heart Notes)</h4>
                                    <p class="text-gray-700">{{ $product->middle_notes }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Aroma inti parfum (30 menit - 2 jam)</p>
                                </div>
                            @endif

                            @if($product->base_notes)
                                <div class="border-l-4 border-pink-600 pl-4">
                                    <h4 class="font-medium text-gray-900 mb-1">Base Notes</h4>
                                    <p class="text-gray-700">{{ $product->base_notes }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Aroma yang bertahan paling lama (2-8 jam)</p>
                                </div>
                            @endif
                        </div>

                        <!-- Combined Notes -->
                        @if($product->all_notes)
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                                <h5 class="text-sm font-medium text-gray-900 mb-2">Semua Notes</h5>
                                <p class="text-sm text-gray-700">{{ $product->all_notes }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- AI Classification Details -->
                @if($product->confidence_score)
                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 border border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-brain text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Analisis AI</h3>
                                <p class="text-sm text-gray-600">Hasil klasifikasi menggunakan algoritma Naive Bayes</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-4 text-center">
                                <div class="text-2xl font-bold text-blue-600">{{ $product->confidence_score }}%</div>
                                <div class="text-sm text-gray-600">Confidence Score</div>
                            </div>
                            <div class="bg-white rounded-lg p-4 text-center">
                                <div class="text-lg font-semibold text-purple-600">{{ $product->category->nama }}</div>
                                <div class="text-sm text-gray-600">Kategori Terprediksi</div>
                            </div>
                            <div class="bg-white rounded-lg p-4 text-center">
                                <div class="text-lg font-semibold text-green-600">
                                    @if($product->confidence_score >= 80)
                                        Sangat Yakin
                                    @elseif($product->confidence_score >= 60)
                                        Cukup Yakin
                                    @else
                                        Kurang Yakin
                                    @endif
                                </div>
                                <div class="text-sm text-gray-600">Level Kepercayaan</div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button onclick="reclassifyProduct()"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-medium rounded-lg hover:from-blue-700 hover:to-purple-700">
                                <i class="fas fa-redo mr-2"></i>Klasifikasi Ulang dengan AI
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Related Products -->
                @if($product->category->products->count() > 1)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Serupa</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($product->category->products->where('id', '!=', $product->id)->take(3) as $relatedProduct)
                                <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                    <div class="aspect-square bg-gray-100 rounded-lg mb-3 overflow-hidden">
                                        <img src="{{ $relatedProduct->gambar_url }}" alt="{{ $relatedProduct->nama }}"
                                             class="w-full h-full object-cover"
                                             onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">
                                    </div>
                                    <h4 class="font-medium text-gray-900 text-sm mb-1">{{ $relatedProduct->nama }}</h4>
                                    <p class="text-sm text-gray-600 mb-2">{{ $relatedProduct->formatted_harga }}</p>
                                    <a href="{{ route('admin.products.show', $relatedProduct) }}"
                                       class="text-xs text-pink-600 hover:text-pink-800">
                                        Lihat Detail →
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeDeleteModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Konfirmasi Hapus</h3>
                </div>
                
                <p class="text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus produk <strong>"{{ $product->nama }}"</strong>? 
                    Tindakan ini tidak dapat dibatalkan.
                </p>
                
                <div class="flex justify-end space-x-4">
                    <button onclick="closeDeleteModal()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </button>
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Ya, Hapus Produk
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function reclassifyProduct() {
            if (confirm('Klasifikasi ulang produk ini dengan AI? Hasil klasifikasi sebelumnya akan diganti.')) {
                // Show loading
                const button = event.target;
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengklasifikasi...';
                button.disabled = true;

                fetch(`{{ route('admin.products.reclassify', $product) }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Terjadi kesalahan'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengklasifikasi produk');
                })
                .finally(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
            }
        }

        function deleteProduct() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
        
        .transition-shadow {
            transition: box-shadow 0.15s ease-in-out;
        }
    </style>
@endpush