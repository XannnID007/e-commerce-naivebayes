@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')
@section('page-description', 'Tambah produk parfum dengan klasifikasi otomatis AI')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Nama Produk -->
                        <div>
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Produk *
                            </label>
                            <input type="text" id="nama" name="nama" required value="{{ old('nama') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('nama') ? 'border-red-300' : '' }}"
                                placeholder="Masukkan nama produk">
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
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('deskripsi') ? 'border-red-300' : '' }}"
                                placeholder="Deskripsi lengkap produk untuk klasifikasi AI">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Deskripsi akan digunakan oleh AI untuk klasifikasi
                                otomatis</p>
                        </div>

                        <!-- Harga dan Konsentrasi -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                    Harga (Rp) *
                                </label>
                                <input type="number" id="harga" name="harga" required value="{{ old('harga') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('harga') ? 'border-red-300' : '' }}"
                                    placeholder="0">
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
                                    <option value="">Pilih Konsentrasi</option>
                                    <option value="EDC" {{ old('konsentrasi') == 'EDC' ? 'selected' : '' }}>EDC (Eau de
                                        Cologne)</option>
                                    <option value="EDT" {{ old('konsentrasi') == 'EDT' ? 'selected' : '' }}>EDT (Eau de
                                        Toilette)</option>
                                    <option value="EDP" {{ old('konsentrasi') == 'EDP' ? 'selected' : '' }}>EDP (Eau de
                                        Parfum)</option>
                                </select>
                                @error('konsentrasi')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Stok -->
                        <div>
                            <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                Stok *
                            </label>
                            <input type="number" id="stok" name="stok" required value="{{ old('stok') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('stok') ? 'border-red-300' : '' }}"
                                placeholder="0">
                            @error('stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Gambar Produk -->
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Produk
                            </label>
                            <input type="file" id="gambar" name="gambar" accept="image/*"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('gambar') ? 'border-red-300' : '' }}">
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB</p>
                        </div>

                        <!-- Fragrance Notes -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium text-gray-900">Fragrance Notes</h3>
                            <p class="text-sm text-gray-600">Notes akan digunakan oleh AI untuk klasifikasi yang lebih
                                akurat</p>

                            <div>
                                <label for="top_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Top Notes
                                </label>
                                <input type="text" id="top_notes" name="top_notes" value="{{ old('top_notes') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('top_notes') ? 'border-red-300' : '' }}"
                                    placeholder="Bergamot, Lemon, Orange">
                                @error('top_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="middle_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Middle Notes
                                </label>
                                <input type="text" id="middle_notes" name="middle_notes"
                                    value="{{ old('middle_notes') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('middle_notes') ? 'border-red-300' : '' }}"
                                    placeholder="Rose, Jasmine, Lavender">
                                @error('middle_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="base_notes" class="block text-sm font-medium text-gray-700 mb-2">
                                    Base Notes
                                </label>
                                <input type="text" id="base_notes" name="base_notes" value="{{ old('base_notes') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('base_notes') ? 'border-red-300' : '' }}"
                                    placeholder="Musk, Vanilla, Sandalwood">
                                @error('base_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- AI Classification Preview -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-blue-900 mb-2">
                                <i class="fas fa-brain mr-2"></i>Klasifikasi AI
                            </h4>
                            <p class="text-sm text-blue-700">
                                Setelah produk disimpan, sistem AI akan secara otomatis mengklasifikasikan produk ini ke
                                dalam kategori aroma yang sesuai berdasarkan deskripsi dan fragrance notes.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.products.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        <i class="fas fa-save mr-2"></i>Simpan & Klasifikasi AI
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
