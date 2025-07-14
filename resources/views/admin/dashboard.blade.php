@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-description', 'Overview sistem klasifikasi parfum Philocalist')

@section('content')
    <div class="space-y-6">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Produk -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-pink-100">
                        <i class="fas fa-spray-can text-pink-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_produk'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Kategori -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-tags text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Kategori</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_kategori'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Data Training -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-database text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Data Training</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_training_data'] }}</p>
                    </div>
                </div>
            </div>

            <!-- Akurasi Model -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <i class="fas fa-chart-line text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Akurasi Model</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['akurasi_model'] }}%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Chart Distribusi Kategori
        const categoryData = @json($categoryDistribution);
        const ctx = document.getElementById('categoryChart').getContext('2d');

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: categoryData.map(item => item.nama),
                datasets: [{
                    data: categoryData.map(item => item.products_count),
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
                            usePointStyle: true
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
                button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Melatih Model...';
                button.disabled = true;

                fetch('{{ route('admin.training-data.train-model') }}', {
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
    </script>
@endpush
