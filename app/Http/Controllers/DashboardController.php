<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\TrainingData;
use App\Models\ClassificationLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_produk' => Product::count(),
            'total_kategori' => Category::count(),
            'total_training_data' => TrainingData::count(),
            'akurasi_model' => $this->getModelAccuracy()
        ];

        $recentProducts = Product::with('category')
            ->latest()
            ->limit(5)
            ->get();

        $categoryDistribution = Category::withCount('products')->get();

        $recentClassifications = ClassificationLog::with(['product', 'predictedCategory'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentProducts', 'categoryDistribution', 'recentClassifications'));
    }

    private function getModelAccuracy()
    {
        $totalLogs = ClassificationLog::whereNotNull('is_correct')->count();

        if ($totalLogs == 0) {
            return 0;
        }

        $correctLogs = ClassificationLog::where('is_correct', true)->count();
        return round(($correctLogs / $totalLogs) * 100, 2);
    }
}
