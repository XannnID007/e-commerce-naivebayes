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

    public function validate(TrainingData $trainingData)
    {
        $trainingData->update(['is_validated' => true]);

        return redirect()->back()
            ->with('success', 'Data training berhasil divalidasi!');
    }

    public function trainModel()
    {
        try {
            $this->naiveBayesService->trainModel();

            return redirect()->back()
                ->with('success', 'Model Naive Bayes berhasil dilatih ulang!');
        } catch (\Exception $e) {
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
            $data = array_map('str_getcsv', file($file->getRealPath()));
            $header = array_shift($data);

            $imported = 0;
            foreach ($data as $row) {
                if (count($row) >= 5) {
                    TrainingData::create([
                        'deskripsi' => $row[0],
                        'top_notes' => $row[1],
                        'middle_notes' => $row[2],
                        'base_notes' => $row[3],
                        'category_id' => $row[4]
                    ]);
                    $imported++;
                }
            }

            return redirect()->back()
                ->with('success', "Berhasil mengimpor {$imported} data training!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }
}
