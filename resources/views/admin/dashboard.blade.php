@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview sistem klasifikasi parfum Philocalist')

@section('content')
    <div class="space-y-8">
        <!-- Welcome Card -->
        <div class="bg-gradient-to-r from-pink-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h1>
                    <p class="text-pink-100">Kelola sistem klasifikasi parfum AI dengan mudah</p>
                </div>
                <div class="hidden md:block">
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-spray-can text-4xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Produk -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-pink-500 to-pink-600">
                        <i class="fas fa-spray-can text-white text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Produk</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_produk'] }}</p>
                            <span class="ml-2 text-sm font-medium text-green-600">+12%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Kategori -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-blue-500 to-blue-600">
                        <i class="fas fa-tags text-white text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Kategori</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_kategori'] }}</p>
                            <span class="ml-2 text-sm font-medium text-gray-500">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Training -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-green-500 to-green-600">
                        <i class="fas fa-database text-white text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Data Training</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_training_data'] }}</p>
                            <span class="ml-2 text-sm font-medium text-blue-600">Tervalidasi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Akurasi Model -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-gradient-to-r from-purple-500 to-purple-600">
                        <i class="fas fa-brain text-white text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Akurasi Model</p>
                        <div class="flex items-baseline">
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['akurasi_model'] }}%</p>
                            <span class="ml-2 text-sm font-medium text-green-600">Excellent</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Category Distribution Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Distribusi Kategori</h3>
                    <div class="flex space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-refresh text-sm"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-download text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="relative h-64">
                    <canvas id="categoryChart"></canvas>
                </div>
            </div>

            <!-- AI Performance Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Performa AI (7 Hari)</h3>
                    <div class="flex space-x-2">
                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-refresh text-sm"></i>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                            <i class="fas fa-download text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="relative h-64">
                    <canvas id="performanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Activity & Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Products -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-900">Produk Terbaru</h3>
                    <a href="{{ route('admin.products.index') }}"
                        class="text-pink-600 hover:text-pink-700 text-sm font-medium">
                        Lihat Semua
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($recentProducts ?? [] as $product)
                        <div class="flex items-center space-x-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-spray-can text-pink-600"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ $product->nama }}</p>
                                <div class="flex items-center space-x-2 mt-1">
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-pink-100 text-pink-800">
                                        {{ $product->category->nama }}
                                    </span>
                                    @if ($product->confidence_score)
                                        <span class="text-xs text-gray-500">AI: {{ $product->confidence_score }}%</span>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ $product->formatted_harga }}</p>
                                <p class="text-xs text-gray-500">{{ $product->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-box-open text-3xl mb-2"></i>
                            <p>Belum ada produk terbaru</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Classifications -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Klasifikasi AI Terbaru</h3>
                <a href="{{ route('admin.model-evaluation.index') }}"
                    class="text-pink-600 hover:text-pink-700 text-sm font-medium">
                    Lihat Detail
                    <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3">Produk
                            </th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3">Prediksi
                                AI</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3">
                                Confidence</th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3">Status
                            </th>
                            <th class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider py-3">Waktu
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentClassifications ?? [] as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->product->nama ?? 'N/A' }}
                                    </div>
                                    <div class="text-sm text-gray-500">{{ $log->product->konsentrasi ?? 'N/A' }}</div>
                                </td>
                                <td class="py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                        {{ $log->predictedCategory->nama ?? 'N/A' }}
                                    </span>
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            @php
                                                $confidence = $log->confidence_score ?? 0;
                                                $color =
                                                    $confidence >= 80
                                                        ? 'bg-green-500'
                                                        : ($confidence >= 60
                                                            ? 'bg-yellow-500'
                                                            : 'bg-red-500');
                                            @endphp
                                            <div class="{{ $color }} h-2 rounded-full"
                                                style="width: {{ $confidence }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $confidence }}%</span>
                                    </div>
                                </td>
                                <td class="py-4">
                                    @if (isset($log->is_correct))
                                        @if ($log->is_correct)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check mr-1"></i>Benar
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times mr-1"></i>Salah
                                            </span>
                                        @endif
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-clock mr-1"></i>Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 text-sm text-gray-500">
                                    {{ $log->created_at->diffForHumans() ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    <i class="fas fa-robot text-3xl mb-2"></i>
                                    <p>Belum ada klasifikasi AI terbaru</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Sample data for charts (replace with real data from controller)
        const categoryData = @json($categoryDistribution ?? []);

        // Category Distribution Chart
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.nama || 'Unknown'),
                datasets: [{
                    data: categoryData.map(item => item.products_count || 0),
                    backgroundColor: [
                        '#ec4899', '#f472b6', '#f9a8d4', '#fbcfe8',
                        '#3b82f6', '#60a5fa', '#93c5fd', '#dbeafe'
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });

        // AI Performance Chart
        const ctxPerformance = document.getElementById('performanceChart').getContext('2d');
        new Chart(ctxPerformance, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Akurasi (%)',
                    data: [85, 87, 89, 86, 91, 93, 95],
                    borderColor: '#ec4899',
                    backgroundColor: 'rgba(236, 72, 153, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // Function untuk training model
        function trainModel() {
            if (confirm('Apakah Anda yakin ingin melatih ulang model? Proses ini mungkin memakan waktu beberapa menit.')) {
                // Show loading
                const button = event.target.closest('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Melatih Model...';
                button.disabled = true;

                fetch('/admin/training-data/train-model', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Model berhasil dilatih!');
                            location.reload();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        alert('Terjadi kesalahan: ' + error.message);
                    })
                    .finally(() => {
                        button.innerHTML = originalText;
                        button.disabled = false;
                    });
            }
        }

        // Auto refresh data setiap 30 detik
        setInterval(function() {
            // Update real-time data jika diperlukan
            console.log('Auto refresh data...');
        }, 30000);
    </script>
@endpush
