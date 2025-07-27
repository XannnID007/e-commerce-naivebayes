@extends('layouts.admin')

@section('title', 'Evaluasi Model AI')
@section('page-title', 'Evaluasi Model')
@section('page-description', 'Analisis performa model Naive Bayes untuk klasifikasi parfum')

@section('content')
    <div class="space-y-6">
        @if (isset($needsClassificationLogs) && $needsClassificationLogs)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Belum Ada Data Evaluasi</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>Sistem belum memiliki classification logs untuk dievaluasi. Silakan generate classification
                                logs terlebih dahulu.</p>
                        </div>
                        <div class="mt-4">
                            <div class="flex space-x-2">
                                <form method="POST" action="{{ route('admin.model-evaluation.generate-logs') }}"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-yellow-700">
                                        <i class="fas fa-cogs mr-1"></i>Generate Classification Logs
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Klasifikasi -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100">
                        <i class="fas fa-brain text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Klasifikasi</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $overallStats['total_classifications'] ?? 0 }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Akurasi Model -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100">
                        <i class="fas fa-target text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Akurasi Model</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $overallStats['accuracy'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>

            <!-- Rata-rata Confidence -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100">
                        <i class="fas fa-percentage text-purple-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Avg Confidence</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $overallStats['avg_confidence'] ?? 0 }}%</p>
                    </div>
                </div>
            </div>

            <!-- Distribusi High Confidence -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-pink-100">
                        <i class="fas fa-thumbs-up text-pink-600 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">High Confidence</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ $overallStats['confidence_distribution']['high'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluasi per Kategori -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900">Evaluasi per Kategori</h3>
                <a href="{{ route('admin.model-evaluation.export') }}"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    <i class="fas fa-download mr-2"></i>Export CSV
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Precision
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Recall
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                F1-Score
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Prediksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($categoryStats ?? [] as $stat)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-pink-100 rounded-lg flex items-center justify-center mr-3">
                                            <i
                                                class="{{ $stat['category']->icon ?? 'fas fa-spray-can' }} text-pink-600"></i>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">{{ $stat['category']->nama }}</div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $stat['precision'] }}%</span>
                                        <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-500 h-2 rounded-full"
                                                style="width: {{ $stat['precision'] }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $stat['recall'] }}%</span>
                                        <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full"
                                                style="width: {{ $stat['recall'] }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">{{ $stat['f1_score'] }}%</span>
                                        <div class="ml-2 w-16 bg-gray-200 rounded-full h-2">
                                            <div class="bg-purple-500 h-2 rounded-full"
                                                style="width: {{ $stat['f1_score'] }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $stat['total_predicted'] }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-chart-line text-4xl mb-4"></i>
                                        <p>Belum ada data evaluasi</p>
                                        <p class="text-sm">Tambah produk baru untuk melihat klasifikasi AI</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Log Klasifikasi Terbaru -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Klasifikasi Terbaru</h3>
                <p class="text-sm text-gray-600 mt-1">Log klasifikasi AI terbaru</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prediksi AI
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Confidence
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentClassifications ?? [] as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $log->product->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $log->product->konsentrasi }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                        {{ $log->predictedCategory->nama }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ $log->confidence_score }}%</span>
                                        <div class="ml-2 w-12 bg-gray-200 rounded-full h-1.5">
                                            @php
                                                $color =
                                                    $log->confidence_score >= 80
                                                        ? 'green'
                                                        : ($log->confidence_score >= 60
                                                            ? 'yellow'
                                                            : 'red');
                                            @endphp
                                            <div class="bg-{{ $color }}-500 h-1.5 rounded-full"
                                                style="width: {{ $log->confidence_score }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($log->is_correct === null)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class="fas fa-question mr-1"></i>Pending
                                        </span>
                                    @elseif($log->is_correct)
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
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $log->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-history text-4xl mb-4"></i>
                                        <p>Belum ada log klasifikasi</p>
                                        <p class="text-sm">Tambah produk baru untuk melihat klasifikasi AI</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
