<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainingData;
use App\Models\Category;
use App\Services\NaiveBayesService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            ->when(request('validated') !== null, function ($query) {
                $query->where('is_validated', request('validated') === '1');
            })
            ->when(request('search'), function ($query) {
                $query->where('deskripsi', 'like', '%' . request('search') . '%')
                    ->orWhere('top_notes', 'like', '%' . request('search') . '%')
                    ->orWhere('middle_notes', 'like', '%' . request('search') . '%')
                    ->orWhere('base_notes', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->paginate(15);

        $categories = Category::all();

        // Stats untuk summary
        $stats = [
            'total' => TrainingData::count(),
            'validated' => TrainingData::where('is_validated', true)->count(),
            'pending' => TrainingData::where('is_validated', false)->count(),
        ];

        return view('admin.training-data.index', compact('trainingData', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::where('aktif', true)->get();
        return view('admin.training-data.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|string|min:10',
            'top_notes' => 'nullable|string|max:500',
            'middle_notes' => 'nullable|string|max:500',
            'base_notes' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id'
        ], [
            'deskripsi.min' => 'Deskripsi minimal 10 karakter untuk training yang efektif',
            'category_id.required' => 'Kategori wajib dipilih',
            'category_id.exists' => 'Kategori tidak valid'
        ]);

        try {
            TrainingData::create($request->all());

            return redirect()->route('admin.training-data.index')
                ->with('success', 'Data training berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error creating training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menambahkan data training: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(TrainingData $trainingData)
    {
        $trainingData->load('category');
        return view('admin.training-data.show', compact('trainingData'));
    }

    public function edit(TrainingData $trainingData)
    {
        $categories = Category::where('aktif', true)->get();
        return view('admin.training-data.edit', compact('trainingData', 'categories'));
    }

    public function update(Request $request, TrainingData $trainingData)
    {
        $request->validate([
            'deskripsi' => 'required|string|min:10',
            'top_notes' => 'nullable|string|max:500',
            'middle_notes' => 'nullable|string|max:500',
            'base_notes' => 'nullable|string|max:500',
            'category_id' => 'required|exists:categories,id'
        ]);

        try {
            $trainingData->update($request->all());

            return redirect()->route('admin.training-data.index')
                ->with('success', 'Data training berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memperbarui data training: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(TrainingData $trainingData)
    {
        try {
            $trainingData->delete();

            return redirect()->route('admin.training-data.index')
                ->with('success', 'Data training berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus data training: ' . $e->getMessage());
        }
    }

    public function validateTrainingData(TrainingData $trainingData)
    {
        try {
            $trainingData->update([
                'is_validated' => true,
                'validated_at' => now()
            ]);

            return redirect()->back()
                ->with('success', 'Data training berhasil divalidasi!');
        } catch (\Exception $e) {
            Log::error('Error validating training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memvalidasi data training: ' . $e->getMessage());
        }
    }

    public function trainModel()
    {
        try {
            $validatedCount = TrainingData::where('is_validated', true)->count();
            $categoriesWithData = TrainingData::where('is_validated', true)
                ->distinct('category_id')
                ->count('category_id');

            $totalCategories = Category::count();

            // Validasi minimal data
            if ($validatedCount < 10) {
                return redirect()->back()
                    ->with('error', 'Minimal 10 data training tervalidasi diperlukan untuk melatih model! (Saat ini: ' . $validatedCount . ')');
            }

            if ($categoriesWithData < 2) {
                return redirect()->back()
                    ->with('error', 'Minimal 2 kategori harus memiliki data training tervalidasi!');
            }

            // Cek distribusi data per kategori
            $categoryDistribution = TrainingData::where('is_validated', true)
                ->select('category_id')
                ->selectRaw('count(*) as count')
                ->groupBy('category_id')
                ->with('category:id,nama')
                ->get();

            $minDataPerCategory = $categoryDistribution->min('count');
            if ($minDataPerCategory < 2) {
                $problematicCategories = $categoryDistribution
                    ->where('count', '<', 2)
                    ->pluck('category.nama')
                    ->join(', ');

                return redirect()->back()
                    ->with('error', 'Setiap kategori harus memiliki minimal 2 data training. Kategori dengan data kurang: ' . $problematicCategories);
            }

            // Training model
            $result = $this->naiveBayesService->trainModel();

            return redirect()->back()->with(
                'success',
                "Model Naive Bayes berhasil dilatih! Data tervalidasi: {$validatedCount}, Kategori: {$categoriesWithData}/{$totalCategories}"
            );
        } catch (\Exception $e) {
            Log::error('Error training model: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Gagal melatih model: ' . $e->getMessage());
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt|max:2048'
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();

            // Read CSV with proper encoding handling
            $handle = fopen($path, 'r');
            if (!$handle) {
                throw new \Exception('Tidak dapat membuka file CSV');
            }

            $header = fgetcsv($handle, 1000, ',');
            if (!$header || count($header) < 5) {
                fclose($handle);
                throw new \Exception('Format CSV tidak valid. Header harus: deskripsi,top_notes,middle_notes,base_notes,category_id');
            }

            $imported = 0;
            $errors = [];
            $rowNumber = 2; // Start from row 2 (after header)

            DB::beginTransaction();

            while (($row = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (count($row) >= 5 && !empty(trim($row[0]))) {
                    try {
                        $categoryId = (int) trim($row[4]);

                        // Validate category exists
                        if (!Category::find($categoryId)) {
                            $errors[] = "Baris {$rowNumber}: Kategori ID {$categoryId} tidak ditemukan";
                            $rowNumber++;
                            continue;
                        }

                        // Validate description length
                        $description = trim($row[0]);
                        if (strlen($description) < 10) {
                            $errors[] = "Baris {$rowNumber}: Deskripsi terlalu pendek (minimal 10 karakter)";
                            $rowNumber++;
                            continue;
                        }

                        TrainingData::create([
                            'deskripsi' => $description,
                            'top_notes' => !empty(trim($row[1])) ? trim($row[1]) : null,
                            'middle_notes' => !empty(trim($row[2])) ? trim($row[2]) : null,
                            'base_notes' => !empty(trim($row[3])) ? trim($row[3]) : null,
                            'category_id' => $categoryId,
                            'is_validated' => false
                        ]);

                        $imported++;
                    } catch (\Exception $e) {
                        $errors[] = "Baris {$rowNumber}: " . $e->getMessage();
                    }
                } else {
                    if (!empty(array_filter($row))) { // Skip empty rows
                        $errors[] = "Baris {$rowNumber}: Data tidak lengkap atau deskripsi kosong";
                    }
                }
                $rowNumber++;
            }

            fclose($handle);
            DB::commit();

            $message = "Berhasil mengimpor {$imported} data training!";
            if (!empty($errors)) {
                $message .= " Dengan " . count($errors) . " error.";
                session()->flash('import_errors', array_slice($errors, 0, 10)); // Limit errors shown
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            if (isset($handle)) fclose($handle);
            DB::rollback();

            Log::error('Error importing training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function export()
    {
        try {
            $trainingData = TrainingData::with('category')->get();

            $csv = "deskripsi,top_notes,middle_notes,base_notes,category_id,category_name,is_validated,created_at\n";

            foreach ($trainingData as $data) {
                $csv .= '"' . str_replace('"', '""', $data->deskripsi) . '",';
                $csv .= '"' . str_replace('"', '""', $data->top_notes ?? '') . '",';
                $csv .= '"' . str_replace('"', '""', $data->middle_notes ?? '') . '",';
                $csv .= '"' . str_replace('"', '""', $data->base_notes ?? '') . '",';
                $csv .= $data->category_id . ',';
                $csv .= '"' . str_replace('"', '""', $data->category->nama) . '",';
                $csv .= ($data->is_validated ? '1' : '0') . ',';
                $csv .= $data->created_at->format('Y-m-d H:i:s') . "\n";
            }

            $filename = 'training_data_export_' . date('Y-m-d_H-i-s') . '.csv';

            return response($csv, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            Log::error('Error exporting training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }

    public function batchValidate(Request $request)
    {
        $request->validate([
            'training_data_ids' => 'required|array|min:1',
            'training_data_ids.*' => 'exists:training_data,id'
        ]);

        try {
            $count = TrainingData::whereIn('id', $request->training_data_ids)
                ->update([
                    'is_validated' => true,
                    'validated_at' => now()
                ]);

            return redirect()->back()
                ->with('success', "Berhasil memvalidasi {$count} data training!");
        } catch (\Exception $e) {
            Log::error('Error batch validating training data: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memvalidasi data: ' . $e->getMessage());
        }
    }

    public function resetValidation(TrainingData $trainingData)
    {
        try {
            $trainingData->update([
                'is_validated' => false,
                'validated_at' => null
            ]);

            return redirect()->back()
                ->with('success', 'Status validasi berhasil direset!');
        } catch (\Exception $e) {
            Log::error('Error resetting training data validation: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mereset validasi: ' . $e->getMessage());
        }
    }
}
