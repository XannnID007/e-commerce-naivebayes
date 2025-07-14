<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ClassificationLog;
use App\Models\TrainingData;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function products()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('aktif', true)->count();
        $lowStockProducts = Product::where('stok', '<=', 5)->count();

        $productsByCategory = Category::withCount('products')->get();

        $recentProducts = Product::with('category')
            ->latest()
            ->limit(10)
            ->get();

        $productsByMonth = Product::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month', 'year')
            ->orderBy('month')
            ->get();

        return view('admin.reports.products', compact(
            'totalProducts',
            'activeProducts',
            'lowStockProducts',
            'productsByCategory',
            'recentProducts',
            'productsByMonth'
        ));
    }

    public function classifications()
    {
        $totalClassifications = ClassificationLog::count();
        $accurateClassifications = ClassificationLog::where('is_correct', true)->count();
        $accuracy = $totalClassifications > 0 ? ($accurateClassifications / $totalClassifications) * 100 : 0;

        $classificationsByCategory = Category::withCount([
            'classificationLogs as total_predicted',
            'classificationLogs as correct_predicted' => function ($query) {
                $query->where('is_correct', true);
            }
        ])->get();

        $confidenceDistribution = [
            'high' => ClassificationLog::where('confidence_score', '>=', 80)->count(),
            'medium' => ClassificationLog::whereBetween('confidence_score', [60, 79])->count(),
            'low' => ClassificationLog::where('confidence_score', '<', 60)->count()
        ];

        $classificationTrend = ClassificationLog::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN is_correct = 1 THEN 1 ELSE 0 END) as correct')
        )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.reports.classifications', compact(
            'totalClassifications',
            'accuracy',
            'classificationsByCategory',
            'confidenceDistribution',
            'classificationTrend'
        ));
    }

    public function export($type)
    {
        switch ($type) {
            case 'products':
                return $this->exportProducts();
            case 'classifications':
                return $this->exportClassifications();
            case 'categories':
                return $this->exportCategories();
            default:
                return redirect()->back()->with('error', 'Tipe export tidak valid');
        }
    }

    private function exportProducts()
    {
        $products = Product::with('category')->get();

        $csv = "Laporan Produk Philocalist\n";
        $csv .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $csv .= "ID,Nama,Kategori,Harga,Konsentrasi,Stok,Status,Confidence Score,Created At\n";

        foreach ($products as $product) {
            $csv .= "{$product->id},";
            $csv .= "\"{$product->nama}\",";
            $csv .= "\"{$product->category->nama}\",";
            $csv .= "{$product->harga},";
            $csv .= "{$product->konsentrasi},";
            $csv .= "{$product->stok},";
            $csv .= ($product->aktif ? 'Aktif' : 'Nonaktif') . ",";
            $csv .= ($product->confidence_score ?? 'Manual') . ",";
            $csv .= "{$product->created_at}\n";
        }

        $filename = 'products_report_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function exportClassifications()
    {
        $logs = ClassificationLog::with(['product', 'predictedCategory', 'actualCategory'])->get();

        $csv = "Laporan Klasifikasi AI Philocalist\n";
        $csv .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $csv .= "ID,Produk,Kategori Prediksi,Kategori Aktual,Confidence Score,Akurat,Tanggal\n";

        foreach ($logs as $log) {
            $csv .= "{$log->id},";
            $csv .= "\"{$log->product->nama}\",";
            $csv .= "\"{$log->predictedCategory->nama}\",";
            $csv .= "\"" . ($log->actualCategory ? $log->actualCategory->nama : 'N/A') . "\",";
            $csv .= "{$log->confidence_score},";
            $csv .= ($log->is_correct === null ? 'N/A' : ($log->is_correct ? 'Ya' : 'Tidak')) . ",";
            $csv .= "{$log->created_at}\n";
        }

        $filename = 'classifications_report_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function exportCategories()
    {
        $categories = Category::withCount(['products', 'trainingData'])->get();

        $csv = "Laporan Kategori Aroma Philocalist\n";
        $csv .= "Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $csv .= "ID,Nama,Deskripsi,Total Produk,Total Training Data,Status\n";

        foreach ($categories as $category) {
            $csv .= "{$category->id},";
            $csv .= "\"{$category->nama}\",";
            $csv .= "\"{$category->deskripsi}\",";
            $csv .= "{$category->products_count},";
            $csv .= "{$category->training_data_count},";
            $csv .= ($category->aktif ? 'Aktif' : 'Nonaktif') . "\n";
        }

        $filename = 'categories_report_' . date('Y-m-d_H-i-s') . '.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}
