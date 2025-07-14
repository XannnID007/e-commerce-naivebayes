@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-description', 'Edit produk ' . $product->nama)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Nama Produk -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk *
                            </label>
                            <input type="text" id="nama" name="nama" required
                                value="{{ old('nama', $product->nama) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('nama') ? 'border-red-300' : '' }}">
                            @error('nama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi *
                            </label>
                            <textarea id="deskripsi" name="deskripsi" rows="4" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('deskripsi') ? 'border-red-300' : '' }}">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Harga dan Konsentrasi -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga (Rp) *
                                </label>
                                <input type="number" id="harga" name="harga" required
                                    value="{{ old('harga', $product->harga) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('harga') ? 'border-red-300' : '' }}">
                                @error('harga')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="konsentrasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konsentrasi *
                                </label>
                                <select id="konsentrasi" name="konsentrasi" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('konsentrasi') ? 'border-red-300' : '' }}">
                                    <option value="EDC"
                                        {{ old('konsentrasi', $product->konsentrasi) == 'EDC' ? 'selected' : '' }}>EDC
                                    </option>
                                    <option value="EDT"
                                        {{ old('konsentrasi', $product->konsentrasi) == 'EDT' ? 'selected' : '' }}>EDT
                                    </option>
                                    <option value="EDP"
                                        {{ old('konsentrasi', $product->konsentrasi) == 'EDP' ? 'selected' : '' }}>EDP
                                    </option>
                                </select>
                                @error('konsentrasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Stok dan Kategori -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                    Stok *
                                </label>
                                <input type="number" id="stok" name="stok" required
                                    value="{{ old('stok', $product->stok) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('stok') ? 'border-red-300' : '' }}">
                                @error('stok')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kategori *
                                </label>
                                <select id="category_id" name="category_id" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('category_id') ? 'border-red-300' : '' }}">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="aktif" value="1"
                                    {{ old('aktif', $product->aktif) ? 'checked' : '' }}
                                    class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                                <span class="ml-2 text-sm text-gray-700">Produk aktif</span>
                            </label>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Current Image -->
                        @if ($product->gambar)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                                <img src="{{ $product->gambar_url }}" alt="{{ $product->nama }}"
                                    class="w-32 h-32 object-cover rounded-lg border border-gray-300">
                            </div>
                        @endif

                        <!-- New Image Upload -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $product->gambar ? 'Ganti Gambar' : 'Upload Gambar' }}
                            </label>
                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('gambar') ? 'border-red-300' : '' }}">
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fragrance Notes -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Fragrance Notes</h3>

                            <div>
                                <label for="top_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Top Notes
                                </label>
                                <input type="text" id="top_notes" name="top_notes"
                                    value="{{ old('top_notes', $product->top_notes) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('top_notes') ? 'border-red-300' : '' }}">
                                @error('top_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="middle_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Middle Notes
                                </label>
                                <input type="text" id="middle_notes" name="middle_notes"
                                    value="{{ old('middle_notes', $product->middle_notes) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('middle_notes') ? 'border-red-300' : '' }}">
                                @error('middle_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="base_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Base Notes
                                </label>
                                <input type="text" id="base_notes" name="base_notes"
                                    value="{{ old('base_notes', $product->base_notes) }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('base_notes') ? 'border-red-300' : '' }}">
                                @error('base_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Current Classification -->
                        @if ($product->confidence_score)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-blue-900 mb-2">
                                    <i class="fas fa-brain mr-2"></i>Klasifikasi AI Saat Ini
                                </h4>
                                <div class="text-sm text-blue-700">
                                    <p><strong>Kategori:</strong> {{ $product->category->nama }}</p>
                                    <p><strong>Confidence:</strong> {{ $product->confidence_score }}%</p>
                                </div>
                                <button type="button" onclick="reclassifyProduct()"
                                    class="mt-2 text-sm text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-redo mr-1"></i>Klasifikasi Ulang
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        <i class="fas fa-save mr-2"></i>Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function reclassifyProduct() {
            if (confirm('Klasifikasi ulang produk dengan AI?')) {
                fetch(`/admin/products/{{ $product->id }}/reclassify`, {
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
    </script>
@endpush
