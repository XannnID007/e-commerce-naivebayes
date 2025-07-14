@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')
@section('page-title', 'Pengaturan Sistem')
@section('page-description', 'Konfigurasi sistem dan parameter AI')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- General Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Pengaturan Umum</h3>

            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="app_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Aplikasi
                        </label>
                        <input type="text" id="app_name" name="app_name" value="{{ $settings['app_name'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="default_products_per_page" class="block text-sm font-medium text-gray-700 mb-2">
                            Produk per Halaman
                        </label>
                        <input type="number" id="default_products_per_page" name="default_products_per_page"
                            value="{{ $settings['default_products_per_page'] }}" min="1" max="100"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="max_upload_size" class="block text-sm font-medium text-gray-700 mb-2">
                            Maksimal Upload (KB)
                        </label>
                        <input type="number" id="max_upload_size" name="max_upload_size"
                            value="{{ $settings['max_upload_size'] }}" min="1" max="10240"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="supported_image_formats" class="block text-sm font-medium text-gray-700 mb-2">
                            Format Gambar
                        </label>
                        <input type="text" id="supported_image_formats" name="supported_image_formats"
                            value="{{ $settings['supported_image_formats'] }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent"
                            placeholder="jpeg,png,jpg,gif">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                        <i class="fas fa-save mr-2"></i>Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>

        <!-- AI Settings -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Pengaturan AI & Machine Learning</h3>

            <form method="POST" action="{{ route('admin.settings.update') }}">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="naive_bayes_min_accuracy" class="block text-sm font-medium text-gray-700 mb-2">
                            Minimal Akurasi Model (%)
                        </label>
                        <input type="number" id="naive_bayes_min_accuracy" name="naive_bayes_min_accuracy"
                            value="{{ $settings['naive_bayes_min_accuracy'] }}" min="0" max="100" step="0.1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Model akan dilatih ulang jika akurasi di bawah nilai ini</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="naive_bayes_auto_retrain" value="1"
                                {{ $settings['naive_bayes_auto_retrain'] ? 'checked' : '' }}
                                class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm text-gray-700">Auto Retrain Model</span>
                        </label>
                        <p class="mt-1 text-sm text-gray-500">Sistem akan otomatis melatih ulang model setiap hari</p>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-brain mr-2"></i>Update Pengaturan AI
                    </button>
                </div>
            </form>
        </div>

        <!-- System Actions -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Aksi Sistem</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <form method="POST" action="{{ route('admin.settings.clear-cache') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-trash-alt mr-2"></i>
                        <div class="text-left">
                            <div class="font-medium">Bersihkan Cache</div>
                            <div class="text-sm text-gray-500">Hapus semua cache sistem</div>
                        </div>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.settings.optimize-app') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-rocket mr-2"></i>
                        <div class="text-left">
                            <div class="font-medium">Optimasi Aplikasi</div>
                            <div class="text-sm text-gray-500">Cache config, routes, views</div>
                        </div>
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.training-data.train-model') }}">
                    @csrf
                    <button type="submit" onclick="return confirm('Latih ulang model AI?')"
                        class="w-full flex items-center justify-center px-4 py-3 border border-green-300 rounded-lg text-green-700 hover:bg-green-50">
                        <i class="fas fa-brain mr-2"></i>
                        <div class="text-left">
                            <div class="font-medium">Latih Model AI</div>
                            <div class="text-sm text-gray-500">Train ulang Naive Bayes</div>
                        </div>
                    </button>
                </form>

                <a href="{{ route('admin.backup.create') }}"
                    class="w-full flex items-center justify-center px-4 py-3 border border-blue-300 rounded-lg text-blue-700 hover:bg-blue-50">
                    <i class="fas fa-download mr-2"></i>
                    <div class="text-left">
                        <div class="font-medium">Backup Sistem</div>
                        <div class="text-sm text-gray-500">Download backup lengkap</div>
                    </div>
                </a>
            </div>
        </div>

        <!-- System Information -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-6">Informasi Sistem</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Environment</h4>
                    <p class="text-sm text-gray-600">{{ app()->environment() }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Laravel Version</h4>
                    <p class="text-sm text-gray-600">{{ app()->version() }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">PHP Version</h4>
                    <p class="text-sm text-gray-600">{{ PHP_VERSION }}</p>
                </div>

                <div>
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Database</h4>
                    <p class="text-sm text-gray-600">{{ config('database.default') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
