<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrainingDataController;
use App\Http\Controllers\ModelEvaluationController;

/*
|--------------------------------------------------------------------------
| Public Routes (Tidak perlu login)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Public Routes (User dapat akses tanpa login)
|--------------------------------------------------------------------------
*/

// Halaman Utama User
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [HomeController::class, 'about'])->name('about');
Route::get('/kontak', [HomeController::class, 'contact'])->name('contact');

// Produk untuk User (tanpa login)
Route::get('/produk', [ProductController::class, 'userIndex'])->name('products.index');
Route::get('/produk/{product}', [ProductController::class, 'userShow'])->name('products.show');

// Contact form submission (jika diperlukan)
Route::post('/kontak', [HomeController::class, 'submitContact'])->name('contact.submit');

// Halaman kategori untuk user
Route::get('/kategori/{category}', function ($category) {
    return redirect()->route('products.index', ['category' => $category]);
})->name('categories.show');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (Perlu login sebagai admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard')
        ->middleware('admin');

    /*
    |--------------------------------------------------------------------------
    | Manajemen Produk
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        // CRUD Produk
        Route::resource('products', ProductController::class);

        // Klasifikasi ulang produk
        Route::post('products/{product}/reclassify', [ProductController::class, 'reclassify'])
            ->name('products.reclassify');

        // Batch klasifikasi
        Route::post('products/batch-classify', [ProductController::class, 'batchClassify'])
            ->name('products.batch-classify');

        /*
        |--------------------------------------------------------------------------
        | Manajemen Kategori
        |--------------------------------------------------------------------------
        */

        // CRUD Kategori
        Route::resource('categories', CategoryController::class);

        // Toggle status kategori
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');

        /*
        |--------------------------------------------------------------------------
        | Manajemen Data Training
        |--------------------------------------------------------------------------
        */

        // CRUD Training Data
        Route::resource('training-data', TrainingDataController::class);

        // Validasi data training
        Route::post('training-data/{trainingData}/validate', [TrainingDataController::class, 'validate'])
            ->name('training-data.validate');

        // Training model Naive Bayes
        Route::post('training-data/train-model', [TrainingDataController::class, 'trainModel'])
            ->name('training-data.train-model');

        // Import data training dari CSV
        Route::post('training-data/import', [TrainingDataController::class, 'import'])
            ->name('training-data.import');

        // Export data training
        Route::get('training-data/export', [TrainingDataController::class, 'export'])
            ->name('training-data.export');

        /*
        |--------------------------------------------------------------------------
        | Evaluasi Model
        |--------------------------------------------------------------------------
        */

        // Halaman evaluasi model
        Route::get('model-evaluation', [ModelEvaluationController::class, 'index'])
            ->name('model-evaluation.index');

        // Export laporan evaluasi
        Route::get('model-evaluation/export', [ModelEvaluationController::class, 'exportReport'])
            ->name('model-evaluation.export');

        // Test model dengan data testing
        Route::post('model-evaluation/test', [ModelEvaluationController::class, 'testModel'])
            ->name('model-evaluation.test');

        // Reset evaluasi
        Route::post('model-evaluation/reset', [ModelEvaluationController::class, 'resetEvaluation'])
            ->name('model-evaluation.reset');

        /*
        |--------------------------------------------------------------------------
        | Manajemen User (jika diperlukan)
        |--------------------------------------------------------------------------
        */

        Route::resource('users', UserController::class);

        /*
        |--------------------------------------------------------------------------
        | API untuk Chart dan Ajax
        |--------------------------------------------------------------------------
        */

        // Data untuk chart dashboard
        Route::get('api/dashboard-stats', [DashboardController::class, 'getStats'])
            ->name('api.dashboard-stats');

        // Data distribusi kategori
        Route::get('api/category-distribution', [DashboardController::class, 'getCategoryDistribution'])
            ->name('api.category-distribution');

        // Data akurasi model per bulan
        Route::get('api/accuracy-trend', [ModelEvaluationController::class, 'getAccuracyTrend'])
            ->name('api.accuracy-trend');

        // Klasifikasi produk secara real-time
        Route::post('api/classify-product', [ProductController::class, 'classifyAjax'])
            ->name('api.classify-product');

        // Preview klasifikasi sebelum menyimpan
        Route::post('api/preview-classification', [ProductController::class, 'previewClassification'])
            ->name('api.preview-classification');

        /*
        |--------------------------------------------------------------------------
        | Settings & Configuration
        |--------------------------------------------------------------------------
        */

        // Pengaturan sistem
        Route::get('settings', [SettingsController::class, 'index'])
            ->name('settings.index');

        Route::post('settings', [SettingsController::class, 'update'])
            ->name('settings.update');

        // Backup & Restore
        Route::post('backup/create', [BackupController::class, 'create'])
            ->name('backup.create');

        Route::get('backup/download/{file}', [BackupController::class, 'download'])
            ->name('backup.download');

        Route::post('backup/restore', [BackupController::class, 'restore'])
            ->name('backup.restore');

        /*
        |--------------------------------------------------------------------------
        | Laporan & Export
        |--------------------------------------------------------------------------
        */

        // Laporan produk
        Route::get('reports/products', [ReportController::class, 'products'])
            ->name('reports.products');

        // Laporan klasifikasi
        Route::get('reports/classifications', [ReportController::class, 'classifications'])
            ->name('reports.classifications');

        // Export laporan ke PDF/Excel
        Route::get('reports/export/{type}', [ReportController::class, 'export'])
            ->name('reports.export');
    });
});
