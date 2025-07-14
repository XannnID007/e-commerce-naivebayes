<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassificationLog;
use App\Models\Category;
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

        // Confusion Matrix
        $confusionMatrix = $this->getConfusionMatrix();

        // Log klasifikasi terbaru
        $recentLogs = ClassificationLog::with(['product', 'predictedCategory', 'actualCategory'])
            ->latest()
            ->limit(20)
            ->get();

        return view('admin.model-evaluation.index', compact(
            'overallStats',
            'categoryStats',
            'confusionMatrix',
            'recentLogs'
        ));
    }

    private function getOverallStats()
    {
        $totalClassifications = ClassificationLog::count();
        $correctClassifications = ClassificationLog::where('is_correct', true)->count();
        $accuracy = $totalClassifications > 0 ? ($correctClassifications / $totalClassifications) * 100 : 0;

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

    private function getConfusionMatrix()
    {
        $categories = Category::all();
        $matrix = [];

        foreach ($categories as $actual) {
            $row = ['category' => $actual->nama];
            foreach ($categories as $predicted) {
                $count = ClassificationLog::where('actual_category_id', $actual->id)
                    ->where('predicted_category_id', $predicted->id)
                    ->count();
                $row[$predicted->nama] = $count;
            }
            $matrix[] = $row;
        }

        return $matrix;
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
