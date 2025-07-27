@extends('layouts.admin')

@section('title', 'Edit Data Training')
@section('page-title', 'Edit Data Training AI')
@section('page-description', 'Edit data training untuk meningkatkan akurasi model Naive Bayes')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.training-data.update', $trainingData) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Kategori -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori Aroma *
                        </label>
                        <select id="category_id" name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('category_id') ? 'border-red-300' : '' }}">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $trainingData->category_id) == $category->id ? 'selected' : '' }}>
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
                            placeholder="Deskripsi karakteristik aroma untuk training AI">{{ old('deskripsi', $trainingData->deskripsi) }}</textarea>
                        @error('deskripsi')
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
                                value="{{ old('top_notes', $trainingData->top_notes) }}"
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
                                value="{{ old('middle_notes', $trainingData->middle_notes) }}"
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
                            <input type="text" id="base_notes" name="base_notes"
                                value="{{ old('base_notes', $trainingData->base_notes) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('base_notes') ? 'border-red-300' : '' }}"
                                placeholder="Musk, Vanilla, Sandalwood">
                            @error('base_notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Status Validasi -->
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Status Validasi</h4>
                        <div class="flex items-center">
                            @if ($trainingData->is_validated)
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-2"></i>Sudah Tervalidasi
                                </span>
                            @else
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <i class="fas fa-clock mr-2"></i>Belum Tervalidasi
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.training-data.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        <i class="fas fa-save mr-2"></i>Update Data Training
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
