@extends('layouts.admin')

@section('title', 'Tambah Data Training')
@section('page-title', 'Tambah Data Training AI')
@section('page-description', 'Tambah data training untuk meningkatkan akurasi model Naive Bayes')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.training-data.store') }}">
                @csrf

                <div class="space-y-6">
                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori Aroma *
                        </label>
                        <select id="category_id" name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('category_id') ? 'border-red-300' : '' }}">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Aroma *
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('deskripsi') ? 'border-red-300' : '' }}"
                            placeholder="Deskripsi karakteristik aroma untuk training AI">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Semakin detail deskripsi, semakin baik akurasi AI</p>
                    </div>

                    <!-- Fragrance Notes -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Fragrance Notes</h3>

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
                            <input type="text" id="middle_notes" name="middle_notes" value="{{ old('middle_notes') }}"
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

                    <!-- Info Box -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-blue-900 mb-2">
                            <i class="fas fa-info-circle mr-2"></i>Tips Data Training
                        </h4>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Gunakan deskripsi yang spesifik dan detail</li>
                            <li>• Pastikan kategori yang dipilih sudah tepat</li>
                            <li>• Data akan divalidasi sebelum digunakan untuk training</li>
                            <li>• Semakin banyak data berkualitas, semakin akurat AI</li>
                        </ul>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.training-data.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        <i class="fas fa-save mr-2"></i>Simpan Data Training
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
