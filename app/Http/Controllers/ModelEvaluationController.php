<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassificationLog;
use App\Models\Category;
use App\Models\Product;
use App\Services\NaiveBayesService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModelEvaluationController extends Controller
{
    protected $naiveBayesService;

    public function __construct(NaiveBayesService $naiveBayesService)
    {
        $this->naiveBayesService = $naiveBayesService;
    }

    public function index()
    {
        try {
            // Statistik keseluruhan dengan error handling
            $overallStats = $this->getOverallStats();

            // Evaluasi per kategori dengan validasi
            $categoryStats = $this->getCategoryStats();

            // Log klasifikasi terbaru dengan limit dan eager loading
            $recentClassifications = ClassificationLog::with(['product', 'predictedCategory', 'actualCategory'])
                ->latest()
                ->limit(20)
                ->get();

            // Cek apakah perlu generate classification logs
            $needsClassificationLogs = ClassificationLog::count() == 0 && Product::count() > 0;

            // Additional insights
            $insights = $this->getModelInsights();

            return view('admin.model-evaluation.index', compact(
                'overallStats',
                'categoryStats',
                'recentClassifications',
                'needsClassificationLogs',
                'insights'
            ));
        } catch (\Exception $e) {
            Log::error('Error in model evaluation index: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')
                ->with('error', 'Gagal memuat halaman evaluasi model: ' . $e->getMessage());
        }
    }

    private function getOverallStats()
    {
        try {
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
                    ],
                    'correct_predictions' => 0,
                    'error_rate' => 0
                ];
            }

            // PERBAIKAN: Query yang lebih akurat
            $stats = ClassificationLog::selectRaw('
                COUNT(*) as total,
                AVG(CAST(confidence_score AS DECIMAL(5,2))) as avg_confidence,
                SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct_count,
                SUM(CASE WHEN CAST(confidence_score AS DECIMAL(5,2)) >= 80 THEN 1 ELSE 0 END) as high_confidence,
                SUM(CASE WHEN CAST(confidence_score AS DECIMAL(5,2)) >= 60 AND CAST(confidence_score AS DECIMAL(5,2)) < 80 THEN 1 ELSE 0 END) as medium_confidence,
                SUM(CASE WHEN CAST(confidence_score AS DECIMAL(5,2)) < 60 THEN 1 ELSE 0 END) as low_confidence
            ')->first();

            $accuracy = $stats->total > 0 ? ($stats->correct_count / $stats->total) * 100 : 0;
            $errorRate = 100 - $accuracy;

            return [
                'total_classifications' => $stats->total,
                'accuracy' => round($accuracy, 2),
                'avg_confidence' => round($stats->avg_confidence ?? 0, 2),
                'confidence_distribution' => [
                    'high' => $stats->high_confidence ?? 0,
                    'medium' => $stats->medium_confidence ?? 0,
                    'low' => $stats->low_confidence ?? 0
                ],
                'correct_predictions' => $stats->correct_count ?? 0,
                'error_rate' => round($errorRate, 2)
            ];
        } catch (\Exception $e) {
            Log::error('Error calculating overall stats: ' . $e->getMessage());
            return [
                'total_classifications' => 0,
                'accuracy' => 0,
                'avg_confidence' => 0,
                'confidence_distribution' => ['high' => 0, 'medium' => 0, 'low' => 0],
                'correct_predictions' => 0,
                'error_rate' => 0
            ];
        }
    }

    private function getCategoryStats()
    {
        try {
            $categories = Category::all();
            $stats = [];

            foreach ($categories as $category) {
                // PERBAIKAN: Perhitungan precision dan recall yang lebih akurat

                // Precision: dari semua prediksi untuk kategori ini, berapa yang benar
                $totalPredicted = ClassificationLog::where('predicted_category_id', $category->id)->count();
                $correctPredicted = ClassificationLog::where('predicted_category_id', $category->id)
                    ->where('is_correct', true)->count();

                // Recall: dari semua data aktual kategori ini, berapa yang berhasil diprediksi benar
                $totalActual = ClassificationLog::where('actual_category_id', $category->id)->count();
                $correctRecalled = ClassificationLog::where('actual_category_id', $category->id)
                    ->where('is_correct', true)->count();

                $precision = $totalPredicted > 0 ? ($correctPredicted / $totalPredicted) * 100 : 0;
                $recall = $totalActual > 0 ? ($correctRecalled / $totalActual) * 100 : 0;

                // F1 Score dengan handling untuk division by zero
                $f1Score = ($precision + $recall) > 0 ? (2 * $precision * $recall) / ($precision + $recall) : 0;

                // Support - jumlah sampel aktual untuk kategori ini
                $support = $totalActual;

                // Average confidence untuk prediksi kategori ini
                $avgConfidenceQuery = ClassificationLog::where('predicted_category_id', $category->id);
                $avgConfidence = $avgConfidenceQuery->count() > 0 ?
                    $avgConfidenceQuery->avg(DB::raw('CAST(confidence_score AS DECIMAL(5,2))')) : 0;

                $stats[] = [
                    'category' => $category,
                    'precision' => round($precision, 2),
                    'recall' => round($recall, 2),
                    'f1_score' => round($f1Score, 2),
                    'support' => $support,
                    'total_predicted' => $totalPredicted,
                    'correct_predicted' => $correctPredicted,
                    'avg_confidence' => round($avgConfidence ?? 0, 2)
                ];
            }

            // Sort by F1 score descending
            usort($stats, function ($a, $b) {
                return $b['f1_score'] <=> $a['f1_score'];
            });

            return $stats;
        } catch (\Exception $e) {
            Log::error('Error calculating category stats: ' . $e->getMessage());
            return [];
        }
    }

    private function getModelInsights()
    {
        try {
            // Best performing categories
            $categoryStats = $this->getCategoryStats();
            $bestCategories = array_slice($categoryStats, 0, 3);
            $worstCategories = array_slice(array_reverse($categoryStats), 0, 3);

            // Confidence trends (last 30 days)
            $confidenceTrends = ClassificationLog::selectRaw('
                DATE(created_at) as date,
                AVG(CAST(confidence_score AS DECIMAL(5,2))) as avg_confidence,
                COUNT(*) as total_predictions
            ')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            // Most confused categories (highest error rate)
            $confusionMatrix = ClassificationLog::select('predicted_category_id', 'actual_category_id')
                ->selectRaw('COUNT(*) as count')
                ->where('is_correct', false)
                ->groupBy('predicted_category_id', 'actual_category_id')
                ->with(['predictedCategory:id,nama', 'actualCategory:id,nama'])
                ->orderByDesc('count')
                ->limit(10)
                ->get();

            return [
                'best_categories' => $bestCategories,
                'worst_categories' => $worstCategories,
                'confidence_trends' => $confidenceTrends,
                'confusion_matrix' => $confusionMatrix
            ];
        } catch (\Exception $e) {
            Log::error('Error getting model insights: ' . $e->getMessage());
            return [
                'best_categories' => [],
                'worst_categories' => [],
                'confidence_trends' => [],
                'confusion_matrix' => []
            ];
        }
    }

    public function generateClassificationLogs()
    {
        try {
            // Validasi awal tanpa transaction
            $products = Product::with('category')->get();

            if ($products->isEmpty()) {
                return redirect()->back()
                    ->with('info', 'Tidak ada produk yang ditemukan untuk diklasifikasi.');
            }

            Log::info('Starting classification logs generation for ' . $products->count() . ' products');

            $generated = 0;
            $errors = [];

            // Start transaction setelah validasi
            DB::beginTransaction();

            // Hapus classification logs yang ada untuk fresh start
            ClassificationLog::query()->delete();
            Log::info('Cleared existing classification logs');

            foreach ($products as $product) {
                try {
                    // Pastikan produk punya deskripsi minimal
                    if (empty($product->deskripsi)) {
                        $errors[] = "Produk ID {$product->id} ({$product->nama}): Tidak ada deskripsi";
                        continue;
                    }

                    $productData = [
                        'deskripsi' => (string) ($product->deskripsi ?? ''),
                        'top_notes' => (string) ($product->top_notes ?? ''),
                        'middle_notes' => (string) ($product->middle_notes ?? ''),
                        'base_notes' => (string) ($product->base_notes ?? '')
                    ];

                    // Klasifikasi dengan AI
                    $classification = $this->naiveBayesService->classify($productData);

                    if (!$classification || !isset($classification['category_id'])) {
                        $errors[] = "Produk ID {$product->id}: Gagal klasifikasi AI";
                        continue;
                    }

                    // Update produk dengan hasil klasifikasi (tanpa transaction)
                    Product::where('id', $product->id)->update([
                        'confidence_score' => $classification['confidence_score']
                    ]);

                    // Buat classification log
                    ClassificationLog::create([
                        'product_id' => $product->id,
                        'predicted_category_id' => $classification['category_id'],
                        'actual_category_id' => $product->category_id,
                        'confidence_score' => $classification['confidence_score'],
                        'probabilities' => is_array($classification['probabilities']) ?
                            json_encode($classification['probabilities']) : ($classification['probabilities'] ?? '{}'),
                        'is_correct' => $classification['category_id'] == $product->category_id
                    ]);

                    $generated++;

                    Log::info("Generated classification log for product {$product->id}: " .
                        "Predicted={$classification['category_id']}, " .
                        "Actual={$product->category_id}, " .
                        "Confidence={$classification['confidence_score']}%, " .
                        "Correct=" . ($classification['category_id'] == $product->category_id ? 'Yes' : 'No'));
                } catch (\Exception $e) {
                    $errors[] = "Produk ID {$product->id} ({$product->nama}): " . $e->getMessage();
                    Log::error("Error classifying product {$product->id}: " . $e->getMessage());
                    continue; // Continue dengan produk lain
                }
            }

            if ($generated == 0) {
                DB::rollback();
                return redirect()->back()
                    ->with('error', 'Tidak ada classification logs yang berhasil di-generate. Pastikan model sudah dilatih dan produk memiliki deskripsi.');
            }

            DB::commit();

            $message = "Berhasil generate {$generated} classification logs dari {$products->count()} produk!";
            if (!empty($errors)) {
                $message .= " Dengan " . count($errors) . " error.";
                session()->flash('generation_errors', array_slice($errors, 0, 10));
            }

            Log::info("Successfully generated {$generated} classification logs");

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            // Rollback hanya jika transaction masih aktif
            if (DB::transactionLevel() > 0) {
                DB::rollback();
            }

            Log::error('Error generating classification logs: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()->back()
                ->with('error', 'Gagal generate classification logs: ' . $e->getMessage());
        }
    }

    public function reevaluateAll()
    {
        try {
            DB::beginTransaction();

            $logs = ClassificationLog::with('product')->get();
            $updated = 0;
            $errors = [];

            foreach ($logs as $log) {
                if ($log->product) {
                    try {
                        // Re-classify produk
                        $productData = [
                            'deskripsi' => $log->product->deskripsi ?? '',
                            'top_notes' => $log->product->top_notes ?? '',
                            'middle_notes' => $log->product->middle_notes ?? '',
                            'base_notes' => $log->product->base_notes ?? ''
                        ];

                        $classification = $this->naiveBayesService->classify($productData);

                        // Update log
                        $log->update([
                            'predicted_category_id' => $classification['category_id'],
                            'confidence_score' => $classification['confidence_score'],
                            'probabilities' => json_encode($classification['probabilities']),
                            'is_correct' => $classification['category_id'] == $log->product->category_id
                        ]);

                        // Update product confidence score
                        $log->product->update([
                            'confidence_score' => $classification['confidence_score']
                        ]);

                        $updated++;
                    } catch (\Exception $e) {
                        $errors[] = "Log ID {$log->id}: " . $e->getMessage();
                        Log::error("Error re-evaluating log {$log->id}: " . $e->getMessage());
                    }
                }
            }

            DB::commit();

            $message = "Berhasil re-evaluate {$updated} classification logs!";
            if (!empty($errors)) {
                $message .= " Dengan " . count($errors) . " error.";
                session()->flash('reevaluation_errors', array_slice($errors, 0, 5));
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error re-evaluating classification logs: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal re-evaluate: ' . $e->getMessage());
        }
    }

    public function exportReport()
    {
        try {
            $stats = $this->getOverallStats();
            $categoryStats = $this->getCategoryStats();
            $insights = $this->getModelInsights();

            $csv = "Laporan Evaluasi Model Naive Bayes - " . date('Y-m-d H:i:s') . "\n\n";

            // Overall Statistics
            $csv .= "STATISTIK KESELURUHAN:\n";
            $csv .= "Total Klasifikasi," . $stats['total_classifications'] . "\n";
            $csv .= "Akurasi," . $stats['accuracy'] . "%\n";
            $csv .= "Error Rate," . $stats['error_rate'] . "%\n";
            $csv .= "Rata-rata Confidence," . $stats['avg_confidence'] . "%\n";
            $csv .= "High Confidence (>=80%)," . $stats['confidence_distribution']['high'] . "\n";
            $csv .= "Medium Confidence (60-79%)," . $stats['confidence_distribution']['medium'] . "\n";
            $csv .= "Low Confidence (<60%)," . $stats['confidence_distribution']['low'] . "\n\n";

            // Category Performance
            $csv .= "PERFORMA PER KATEGORI:\n";
            $csv .= "Kategori,Precision,Recall,F1-Score,Support,Avg Confidence\n";

            foreach ($categoryStats as $stat) {
                $csv .= $stat['category']->nama . "," .
                    $stat['precision'] . "," .
                    $stat['recall'] . "," .
                    $stat['f1_score'] . "," .
                    $stat['support'] . "," .
                    $stat['avg_confidence'] . "\n";
            }

            $csv .= "\nKETERANGAN:\n";
            $csv .= "Precision: Dari semua prediksi untuk kategori ini, berapa persen yang benar\n";
            $csv .= "Recall: Dari semua data aktual kategori ini, berapa persen yang berhasil diprediksi\n";
            $csv .= "F1-Score: Harmonic mean dari precision dan recall\n";
            $csv .= "Support: Jumlah sampel aktual untuk kategori ini\n";

            $filename = 'laporan_evaluasi_model_' . date('Y-m-d_H-i-s') . '.csv';

            return response($csv, 200, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        } catch (\Exception $e) {
            Log::error('Error exporting evaluation report: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal mengexport laporan: ' . $e->getMessage());
        }
    }

    public function getAccuracyTrend()
    {
        try {
            $trends = ClassificationLog::selectRaw('
                DATE(created_at) as date,
                AVG(CASE WHEN is_correct = 1 THEN 100 ELSE 0 END) as accuracy,
                AVG(CAST(confidence_score AS DECIMAL(5,2))) as avg_confidence,
                COUNT(*) as total_predictions
            ')
                ->where('created_at', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $trends
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting accuracy trend: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get detailed confusion matrix for specific category
     */
    public function getCategoryConfusionMatrix($categoryId)
    {
        try {
            $category = Category::findOrFail($categoryId);

            // Get all predictions for this actual category
            $confusionData = ClassificationLog::where('actual_category_id', $categoryId)
                ->select('predicted_category_id')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('predicted_category_id')
                ->with('predictedCategory:id,nama')
                ->get();

            return response()->json([
                'success' => true,
                'category' => $category->nama,
                'confusion_data' => $confusionData
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting category confusion matrix: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clean up old classification logs (older than 3 months)
     */
    public function cleanupOldLogs()
    {
        try {
            $cutoffDate = now()->subMonths(3);
            $deletedCount = ClassificationLog::where('created_at', '<', $cutoffDate)->delete();

            return redirect()->back()
                ->with('success', "Berhasil menghapus {$deletedCount} log klasifikasi lama (>3 bulan)");
        } catch (\Exception $e) {
            Log::error('Error cleaning up old logs: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal menghapus log lama: ' . $e->getMessage());
        }
    }
}
