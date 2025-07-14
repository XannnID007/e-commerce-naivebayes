@extends('layouts.admin')

@section('title', 'Daftar Produk')
@section('page-title', 'Manajemen Produk')
@section('page-description', 'Kelola produk parfum dan klasifikasi otomatis')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex-1">
                <!-- Search & Filter -->
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>

                    <div>
                        <select name="category"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>

                        <a href="{{ route('admin.products.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-4 sm:mt-0 sm:ml-4">
                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg hover:bg-pink-700">
                    <i class="fas fa-plus mr-2"></i>Tambah Produk
                </a>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori & Klasifikasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga & Stok
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-12 w-12">
                                            <img class="h-12 w-12 rounded object-cover" src="{{ $product->gambar_url }}"
                                                alt="{{ $product->nama }}"
                                                onerror="this.src='{{ asset('images/default-perfume.jpg') }}'">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $product->nama }}</div>
                                            <div class="text-sm text-gray-500">{{ $product->konsentrasi_label }}</div>
                                            <div class="text-xs text-gray-400">{{ Str::limit($product->deskripsi, 50) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="space-y-1">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                            {{ $product->category->nama }}
                                        </span>

                                        @if ($product->confidence_score)
                                            <div class="flex items-center space-x-2">
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                                {{ $product->confidence_score >= 80
                                                    ? 'bg-green-100 text-green-800'
                                                    : ($product->confidence_score >= 60
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : 'bg-red-100 text-red-800') }}">
                                                    {{ $product->confidence_score }}%
                                                </span>
                                                <button onclick="reclassify({{ $product->id }})"
                                                    class="text-xs text-pink-600 hover:text-pink-800">
                                                    <i class="fas fa-redo"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-xs text-gray-500">Manual</span>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $product->formatted_harga }}</div>
                                    <div class="text-sm text-gray-500">Stok: {{ $product->stok }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $product->aktif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->aktif ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.products.show', $product) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.products.edit', $product) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button onclick="deleteProduct({{ $product->id }})"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-spray-can text-4xl mb-4"></i>
                                        <p>Belum ada produk</p>
                                        <a href="{{ route('admin.products.create') }}"
                                            class="mt-2 inline-flex items-center text-pink-600 hover:text-pink-800">
                                            <i class="fas fa-plus mr-1"></i>Tambah produk pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function reclassify(productId) {
            if (confirm('Klasifikasi ulang produk ini?')) {
                fetch(`/admin/products/${productId}/reclassify`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan: ' + error.message);
                    });
            }
        }

        function deleteProduct(productId) {
            if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${productId}`;
                form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endpush
