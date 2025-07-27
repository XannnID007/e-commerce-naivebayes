<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassificationLog;
use App\Models\Category;
use App\Models\Product;
use App\Services\NaiveBayesService;

class ModelEvaluationController extends Controller
{
    protected $naiveBayesService;

    public function __construct(NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        // Statistik keseluruhan
        $overallStats = $this->getOverallStats();

        // Evaluasi per kategori
        $categoryStats = $this->getCategoryStats();

        // Log klasifikasi terbaru
        $recentLogs = ClassificationLog::with(['product', 'predictedCategory', 'actualCategory'])
            ->latest()
            ->limit(20)
            ->get();

        // Cek apakah perlu generate classification logs
        $needsClassificationLogs = ClassificationLog::count() == 0 && Product::count() > 0;

        return view('admin.model-evaluation.index', compact(
            'overallStats',
            'categoryStats',
            'recentLogs',
            'needsClassificationLogs'
        ));
    }

    private function getOverallStats()
    {
        $totalClassifications = ClassificationLog::count();

        if ($totalClassifications == 0) {
            return [
                'total_classifications' => 0,
                'accuracy' => 0,
                'avg_confidence' => 0,
                'confidence_distribution' => [
                    'high' => 0,
                    'medium' => 0,
                    'low' => 0
                ]
            ];
        }

        $correctClassifications = ClassificationLog::where('is_correct', true)->count();
        $accuracy = ($correctClassifications / $totalClassifications) * 100;
        $avgConfidence = ClassificationLog::avg('confidence_score') ?? 0;

        $highConfidence = ClassificationLog::where('confidence_score', '>=', 80)->count();
        $mediumConfidence = ClassificationLog::whereBetween('confidence_score', [60, 79])->count();
        $lowConfidence = ClassificationLog::where('confidence_score', '<', 60)->count();

        return [
            'total_classifications' => $totalClassifications,
            'accuracy' => round($accuracy, 2),
            'avg_confidence' => round($avgConfidence, 2),
            'confidence_distribution' => [
                'high' => $highConfidence,
                'medium' => $mediumConfidence,
                'low' => $lowConfidence
            ]
        ];
    }

    private function getCategoryStats()
    {
        $categories = Category::all();
        $stats = [];

        foreach ($categories as $category) {
            $totalPredicted = ClassificationLog::where('predicted_category_id', $category->id)->count();
            $correctPredicted = ClassificationLog::where('predicted_category_id', $category->id)
                ->where('is_correct', true)->count();

            $precision = $totalPredicted > 0 ? ($correctPredicted / $totalPredicted) * 100 : 0;

            $totalActual = ClassificationLog::where('actual_category_id', $category->id)->count();
            $recall = $totalActual > 0 ? ($correctPredicted / $totalActual) * 100 : 0;

            $f1Score = ($precision + $recall) > 0 ? (2 * $precision * $recall) / ($precision + $recall) : 0;

            $stats[] = [
                'category' => $category,
                'precision' => round($precision, 2),
                'recall' => round($recall, 2),
                'f1_score' => round($f1Score, 2),
                'total_predicted' => $totalPredicted,
                'correct_predicted' => $correctPredicted
            ];
        }

        return $stats;
    }

    /**
     * Generate classification logs untuk produk yang sudah ada
     */
    public function generateClassificationLogs()
    {
        try {
            $products = Product::whereNull('confidence_score')->get();
            $generated = 0;

            foreach ($products as $product) {
                $productData = [
                    'deskripsi' => $product->deskripsi,
                    'top_notes' => $product->top_notes,
                    'middle_notes' => $product->middle_notes,
                    'base_notes' => $product->base_notes
                ];

                $classification = $this->naiveBayesService->classify($productData);

                // Update produk dengan hasil klasifikasi
                $product->update([
                    'confidence_score' => $classification['confidence_score']
                ]);

                // Buat classification log
                ClassificationLog::create([
                    'product_id' => $product->id,
                    'predicted_category_id' => $classification['category_id'],
                    'actual_category_id' => $product->category_id, // kategori asli produk
                    'confidence_score' => $classification['confidence_score'],
                    'probabilities' => $classification['probabilities'],
                    'is_correct' => $classification['category_id'] == $product->category_id
                ]);

                $generated++;
            }

            return redirect()->back()
                ->with('success', "Berhasil generate {$generated} classification logs!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal generate classification logs: ' . $e->getMessage());
        }
    }

    /**
     * Re-evaluate semua classification logs
     */
    public function reevaluateAll()
    {
        try {
            $logs = ClassificationLog::with('product')->get();
            $updated = 0;

            foreach ($logs as $log) {
                if ($log->product) {
                    // Re-classify produk
                    $productData = [
                        'deskripsi' => $log->product->deskripsi,
                        'top_notes' => $log->product->top_notes,
                        'middle_notes' => $log->product->middle_notes,
                        'base_notes' => $log->product->base_notes
                    ];

                    $classification = $this->naiveBayesService->classify($productData);

                    // Update log
                    $log->update([
                        'predicted_category_id' => $classification['category_id'],
                        'confidence_score' => $classification['confidence_score'],
                        'probabilities' => $classification['probabilities'],
                        'is_correct' => $classification['category_id'] == $log->product->category_id
                    ]);

                    $updated++;
                }
            }

            return redirect()->back()
                ->with('success', "Berhasil re-evaluate {$updated} classification logs!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal re-evaluate: ' . $e->getMessage());
        }
    }

    public function exportReport()
    {
        $stats = $this->getOverallStats();
        $categoryStats = $this->getCategoryStats();

        $csv = "Laporan Evaluasi Model Naive Bayes\n\n";
        $csv .= "Statistik Keseluruhan:\n";
        $csv .= "Total Klasifikasi," . $stats['total_classifications'] . "\n";
        $csv .= "Akurasi," . $stats['accuracy'] . "%\n";
        $csv .= "Rata-rata Confidence," . $stats['avg_confidence'] . "%\n\n";

        $csv .= "Evaluasi Per Kategori:\n";
        $csv .= "Kategori,Precision,Recall,F1-Score\n";

        foreach ($categoryStats as $stat) {
            $csv .= $stat['category']->nama . "," .
                $stat['precision'] . "," .
                $stat['recall'] . "," .
                $stat['f1_score'] . "\n";
        }

        $filename = 'laporan_evaluasi_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
