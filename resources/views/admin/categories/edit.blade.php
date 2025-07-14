@extends('layouts.admin')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori Aroma')
@section('page-description', 'Edit kategori aroma ' . $category->nama)

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('admin.categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Nama Kategori -->
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Kategori *
                        </label>
                        <input type="text" id="nama" name="nama" required value="{{ old('nama', $category->nama) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('nama') ? 'border-red-300' : '' }}"
                            placeholder="Masukkan nama kategori">
                        @error('nama')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi -->
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('deskripsi') ? 'border-red-300' : '' }}"
                            placeholder="Deskripsi karakteristik aroma kategori ini">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                            Icon (Font Awesome Class)
                        </label>
                        <input type="text" id="icon" name="icon" value="{{ old('icon', $category->icon) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent {{ $errors->has('icon') ? 'border-red-300' : '' }}"
                            placeholder="fas fa-flower">
                        @error('icon')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Preview Icon -->
                    <div id="iconPreview" class="{{ $category->icon ? '' : 'hidden' }}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Preview Icon</label>
                        <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center">
                            <i id="previewIcon" class="{{ $category->icon }} text-pink-600 text-xl"></i>
                        </div>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="aktif" value="1"
                                {{ old('aktif', $category->aktif) ? 'checked' : '' }}
                                class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Kategori aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-8">
                    <a href="{{ route('admin.categories.index') }}"
                        class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        <i class="fas fa-save mr-2"></i>Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('icon').addEventListener('input', function() {
            const iconClass = this.value;
            const preview = document.getElementById('iconPreview');
            const previewIcon = document.getElementById('previewIcon');

            if (iconClass) {
                previewIcon.className = iconClass + ' text-pink-600 text-xl';
                preview.classList.remove('hidden');
            } else {
                preview.classList.add('hidden');
            }
        });
    </script>
@endpush
