@extends('layouts.admin')

@section('title', 'Kategori Aroma')
@section('page-title', 'Manajemen Kategori')
@section('page-description', 'Kelola kategori aroma parfum untuk klasifikasi AI')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex-1">
                <form method="GET" class="flex gap-4">
                    <div class="flex-1">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kategori..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                        <a href="{{ route('admin.categories.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-4 sm:mt-0 sm:ml-4">
                <a href="{{ route('admin.categories.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg hover:bg-pink-700">
                    <i class="fas fa-plus mr-2"></i>Tambah Kategori
                </a>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah Produk
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
                        @forelse($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 bg-pink-100 rounded-lg flex items-center justify-center">
                                                <i class="{{ $category->icon ?? 'fas fa-spray-can' }} text-pink-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $category->nama }}</div>
                                            <div class="text-sm text-gray-500">ID: {{ $category->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($category->deskripsi, 100) }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $category->products_count }} produk</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="{{ route('admin.categories.toggle-status', $category) }}"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->aktif ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                            {{ $category->aktif ? 'Aktif' : 'Nonaktif' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.categories.edit', $category) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    @if ($category->products_count == 0)
                                        <button onclick="deleteCategory({{ $category->id }})"
                                            class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @else
                                        <span class="text-gray-400" title="Tidak dapat dihapus karena memiliki produk">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-tags text-4xl mb-4"></i>
                                        <p>Belum ada kategori</p>
                                        <a href="{{ route('admin.categories.create') }}"
                                            class="mt-2 inline-flex items-center text-pink-600 hover:text-pink-800">
                                            <i class="fas fa-plus mr-1"></i>Tambah kategori pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($categories->hasPages())
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $categories->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteCategory(categoryId) {
            if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/categories/${categoryId}`;
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
