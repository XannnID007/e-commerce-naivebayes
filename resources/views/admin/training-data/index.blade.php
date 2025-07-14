@extends('layouts.admin')

@section('title', 'Data Training AI')
@section('page-title', 'Manajemen Data Training')
@section('page-description', 'Kelola data training untuk meningkatkan akurasi AI Naive Bayes')

@section('content')
    <div class="space-y-6">
        <!-- Header Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">


                    <div>
                        <select name="category"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="validated"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('validated') === '1' ? 'selected' : '' }}>Tervalidasi</option>
                            <option value="0" {{ request('validated') === '0' ? 'selected' : '' }}>Belum Validasi
                            </option>
                        </select>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                        <a href="{{ route('admin.training-data.index') }}"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="flex gap-2">
                <button onclick="openImportModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i class="fas fa-upload mr-2"></i>Import CSV
                </button>
                <a href="{{ route('admin.training-data.create') }}"
                    class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
                    <i class="fas fa-plus mr-2"></i>Tambah Data
                </a>
                <form method="POST" action="{{ route('admin.training-data.train-model') }}" class="inline">
                    @csrf
                    <button type="submit"
                        onclick="return confirm('Latih ulang model AI? Proses ini mungkin memakan waktu beberapa menit.')"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        <i class="fas fa-cog mr-2"></i>Latih Model
                    </button>
                </form>
            </div>
        </div>

        <!-- Training Data Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Notes
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
                        @forelse($trainingData as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($data->deskripsi, 100) }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                        {{ $data->category->nama }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-xs text-gray-600 space-y-1">
                                        @if ($data->top_notes)
                                            <div><strong>Top:</strong> {{ Str::limit($data->top_notes, 30) }}</div>
                                        @endif
                                        @if ($data->middle_notes)
                                            <div><strong>Middle:</strong> {{ Str::limit($data->middle_notes, 30) }}</div>
                                        @endif
                                        @if ($data->base_notes)
                                            <div><strong>Base:</strong> {{ Str::limit($data->base_notes, 30) }}</div>
                                        @endif
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($data->is_validated)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Tervalidasi
                                        </span>
                                    @else
                                        <form method="POST" action="{{ route('admin.training-data.validate', $data) }}"
                                            class="inline">
                                            @csrf
                                            <button type="submit"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 hover:bg-yellow-200">
                                                <i class="fas fa-clock mr-1"></i>Validasi
                                            </button>
                                        </form>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.training-data.edit', $data) }}"
                                        class="text-indigo-600 hover:text-indigo-900">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <button onclick="deleteTrainingData({{ $data->id }})"
                                        class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center">
                                    <div class="text-gray-500">
                                        <i class="fas fa-database text-4xl mb-4"></i>
                                        <p>Belum ada data training</p>
                                        <a href="{{ route('admin.training-data.create') }}"
                                            class="mt-2 inline-flex items-center text-pink-600 hover:text-pink-800">
                                            <i class="fas fa-plus mr-1"></i>Tambah data training pertama
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($trainingData->hasPages())
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
                    {{ $trainingData->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 z-50 hidden">
        <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeImportModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg p-6 w-full max-w-md">
                <h3 class="text-lg font-semibold mb-4">Import Data Training</h3>

                <form method="POST" action="{{ route('admin.training-data.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                File CSV *
                            </label>
                            <input type="file" id="file" name="file" accept=".csv,.txt" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500">
                            <p class="mt-1 text-sm text-gray-500">
                                Format: deskripsi, top_notes, middle_notes, base_notes, category_id
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" onclick="closeImportModal()"
                            class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <i class="fas fa-upload mr-2"></i>Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteTrainingData(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data training ini?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/training-data/${id}`;
                form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        function openImportModal() {
            document.getElementById('importModal').classList.remove('hidden');
        }

        function closeImportModal() {
            document.getElementById('importModal').classList.add('hidden');
        }
    </script>
@endpush
