<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingData;
use App\Models\Category;
use App\Services\NaiveBayesService;

class TrainingDataController extends Controller
{
    protected $naiveBayesService;

    public function __construct(NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        $trainingData = TrainingData::with('category')
            ->when(request('category'), function ($query) {
                $query->where('category_id', request('category'));
            })
            ->when(request('validated'), function ($query) {
                $query->where('is_validated', request('validated') === '1');
            })
            ->paginate(15);

        $categories = Category::all();

        return view('admin.training-data.index', compact('trainingData', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('aktif', true)->get();
        return view('admin.training-data.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'top_notes' => 'nullable|string',
            'middle_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        TrainingData::create($request->all());

        return redirect()->route('admin.training-data.index')
            ->with('success', 'Data training berhasil ditambahkan!');
    }

    public function edit(TrainingData $trainingData)
    {
        $categories = Category::where('aktif', true)->get();
        return view('admin.training-data.edit', compact('trainingData', 'categories'));
    }

    public function update(Request $request, TrainingData $trainingData)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'top_notes' => 'nullable|string',
            'middle_notes' => 'nullable|string',
            'base_notes' => 'nullable|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $trainingData->update($request->all());

        return redirect()->route('admin.training-data.index')
            ->with('success', 'Data training berhasil diperbarui!');
    }

    public function destroy(TrainingData $trainingData)
    {
        $trainingData->delete();

        return redirect()->route('admin.training-data.index')
            ->with('success', 'Data training berhasil dihapus!');
    }

    /**
     * Validasi data training
     * Method ini diperbaiki untuk menghindari konflik dengan Laravel's validate() method
     */
    public function validateTrainingData(TrainingData $trainingData)
    {
        try {
            // Update status validasi
            $trainingData->update(['is_validated' => true]);

            return redirect()->back()
                ->with('success', 'Data training berhasil divalidasi!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memvalidasi data training: ' . $e->getMessage());
        }
    }

    /**
     * Training model Naive Bayes
     */
    public function trainModel()
    {
        try {
            // Cek apakah ada data training yang tervalidasi
            $validatedDataCount = TrainingData::where('is_validated', true)->count();

            if ($validatedDataCount < 5) {
                return redirect()->back()
                    ->with('error', 'Minimal 5 data training tervalidasi diperlukan untuk melatih model!');
            }

            // Latih model
            $this->naiveBayesService->trainModel();

            return redirect()->back()
                ->with('success', 'Model Naive Bayes berhasil dilatih ulang! Data tervalidasi: ' . $validatedDataCount);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal melatih model: ' . $e->getMessage());
        }
    }

    /**
     * Import data training dari CSV
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data);

            $imported = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                if (count($row) >= 5) {
                    try {
                        // Validasi category_id
                        $categoryId = (int) $row[4];
                        if (!Category::find($categoryId)) {
                            $errors[] = "Baris " . ($index + 2) . ": Kategori ID {$categoryId} tidak ditemukan";
                            continue;
                        }

                        TrainingData::create([
                            'deskripsi' => trim($row[0]),
                            'top_notes' => !empty($row[1]) ? trim($row[1]) : null,
                            'middle_notes' => !empty($row[2]) ? trim($row[2]) : null,
                            'base_notes' => !empty($row[3]) ? trim($row[3]) : null,
                            'category_id' => $categoryId,
                            'is_validated' => false // Default belum tervalidasi
                        ]);
                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Baris " . ($index + 2) . ": " . $e->getMessage();
                    }
                } else {
                    $errors[] = "Baris " . ($index + 2) . ": Data tidak lengkap (minimal 5 kolom)";
                }
            }

            $message = "Berhasil mengimpor {$imported} data training!";
            if (!empty($errors)) {
                $message .= " Dengan " . count($errors) . " error.";
                session()->flash('import_errors', $errors);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    /**
     * Export data training ke CSV
     */
    public function export()
    {
        try {
            $trainingData = TrainingData::with('category')->get();

            $csv = "ID,Deskripsi,Top Notes,Middle Notes,Base Notes,Kategori,Category ID,Tervalidasi,Tanggal Dibuat\n";

            foreach ($trainingData as $data) {
                $csv .= '"' . $data->id . '",';
                $csv .= '"' . str_replace('"', '""', $data->deskripsi) . '",';
                $csv .= '"' . str_replace('"', '""', $data->top_notes ?? '') . '",';
                $csv .= '"' . str_replace('"', '""', $data->middle_notes ?? '') . '",';
                $csv .= '"' . str_replace('"', '""', $data->base_notes ?? '') . '",';
                $csv .= '"' . str_replace('"', '""', $data->category->nama) . '",';
                $csv .= $data->category_id . ',';
                $csv .= ($data->is_validated ? 'Ya' : 'Tidak') . ',';
                $csv .= $data->created_at->format('Y-m-d H:i:s') . "\n";
            }

            $filename = 'training_data_export_' . date('Y-m-d_H-i-s') . '.csv';

            return response($csv)
                ->header('Content-Type', 'text/csv; charset=UTF-8')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Transfer-Encoding', 'binary');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    /**
     * Batch validasi multiple data training
     */
    public function batchValidate(Request $request)
    {
        $request->validate([
            'training_data_ids' => 'required|array',
            'training_data_ids.*' => 'exists:training_data,id'
        ]);

        try {
            $count = TrainingData::whereIn('id', $request->training_data_ids)
                ->update(['is_validated' => true]);

            return redirect()->back()
                ->with('success', "Berhasil memvalidasi {$count} data training!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memvalidasi data: ' . $e->getMessage());
        }
    }

    /**
     * Reset validasi data training
     */
    public function resetValidation(TrainingData $trainingData)
    {
        try {
            $trainingData->update(['is_validated' => false]);

            return redirect()->back()
                ->with('success', 'Status validasi berhasil direset!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mereset validasi: ' . $e->getMessage());
        }
    }

    /**
     * Preview data sebelum import
     */
    public function previewImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data);

            $preview = [];
            $errors = [];

            // Ambil 10 baris pertama untuk preview
            $previewData = array_slice($data, 0, 10);

            foreach ($previewData as $index => $row) {
                $rowData = [
                    'row_number' => $index + 2,
                    'deskripsi' => $row[0] ?? '',
                    'top_notes' => $row[1] ?? '',
                    'middle_notes' => $row[2] ?? '',
                    'base_notes' => $row[3] ?? '',
                    'category_id' => $row[4] ?? '',
                    'valid' => true,
                    'errors' => []
                ];

                // Validasi data
                if (empty($row[0])) {
                    $rowData['valid'] = false;
                    $rowData['errors'][] = 'Deskripsi tidak boleh kosong';
                }

                if (empty($row[4]) || !is_numeric($row[4])) {
                    $rowData['valid'] = false;
                    $rowData['errors'][] = 'Category ID harus berupa angka';
                } else {
                    $category = Category::find((int) $row[4]);
                    if (!$category) {
                        $rowData['valid'] = false;
                        $rowData['errors'][] = 'Kategori tidak ditemukan';
                    } else {
                        $rowData['category_name'] = $category->nama;
                    }
                }

                $preview[] = $rowData;
            }

            return response()->json([
                'success' => true,
                'preview' => $preview,
                'total_rows' => count($data),
                'header' => $header
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membaca file: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get statistics untuk dashboard
     */
    public function getStatistics()
    {
        try {
            $stats = [
                'total' => TrainingData::count(),
                'validated' => TrainingData::where('is_validated', true)->count(),
                'unvalidated' => TrainingData::where('is_validated', false)->count(),
                'by_category' => Category::withCount([
                    'trainingData',
                    'trainingData as validated_count' => function ($query) {
                        $query->where('is_validated', true);
                    }
                ])->get(),
                'recent_additions' => TrainingData::with('category')
                    ->latest()
                    ->limit(5)
                    ->get()
            ];

            return response()->json([
                'success' => true,
                'data' => $stats
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
