<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TrainingDataController;
use App\Http\Controllers\ModelEvaluationController;

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

// Contact form submission
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

    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

        // CRUD Produk
        Route::resource('products', ProductController::class);

        // Klasifikasi ulang produk
        Route::post('products/{product}/reclassify', [ProductController::class, 'reclassify'])
            ->name('products.reclassify');

        // Batch klasifikasi
        Route::post('products/batch-classify', [ProductController::class, 'batchClassify'])
            ->name('products.batch-classify');


        // CRUD Kategori
        Route::resource('categories', CategoryController::class);

        // Toggle status kategori
        Route::post('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');


        // CRUD Training Data
        Route::resource('training-data', TrainingDataController::class);

        // Validasi data training
        Route::post('training-data/{trainingData}/validate', [TrainingDataController::class, 'validateTrainingData'])
            ->name('training-data.validate');

        // Batch validasi data training
        Route::post('training-data/batch-validate', [TrainingDataController::class, 'batchValidate'])
            ->name('training-data.batch-validate');

        // Reset validasi data training
        Route::post('training-data/{trainingData}/reset-validation', [TrainingDataController::class, 'resetValidation'])
            ->name('training-data.reset-validation');

        // Training model Naive Bayes
        Route::post('training-data/train-model', [TrainingDataController::class, 'trainModel'])
            ->name('training-data.train-model');

        // Import data training dari CSV
        Route::post('training-data/import', [TrainingDataController::class, 'import'])
            ->name('training-data.import');

        // Preview import data
        Route::post('training-data/preview-import', [TrainingDataController::class, 'previewImport'])
            ->name('training-data.preview-import');

        // Export data training
        Route::get('training-data/export', [TrainingDataController::class, 'export'])
            ->name('training-data.export');

        // Get statistics untuk dashboard
        Route::get('training-data/statistics', [TrainingDataController::class, 'getStatistics'])
            ->name('training-data.statistics');


        // Halaman evaluasi model
        Route::get('model-evaluation', [ModelEvaluationController::class, 'index'])
            ->name('model-evaluation.index');

        // Generate classification logs
        Route::post('model-evaluation/generate-logs', [ModelEvaluationController::class, 'generateClassificationLogs'])
            ->name('model-evaluation.generate-logs');

        // Re-evaluate classification logs
        Route::post('model-evaluation/reevaluate', [ModelEvaluationController::class, 'reevaluateAll'])
            ->name('model-evaluation.reevaluate');

        // Export laporan evaluasi
        Route::get('model-evaluation/export', [ModelEvaluationController::class, 'exportReport'])
            ->name('model-evaluation.export');


        Route::resource('users', UserController::class);

        // Toggle status user
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('users.toggle-status');


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


        // Backup management
        Route::get('backup', [BackupController::class, 'index'])
            ->name('backup.index');

        Route::post('backup/create', [BackupController::class, 'create'])
            ->name('backup.create');

        Route::get('backup/download/{file}', [BackupController::class, 'download'])
            ->name('backup.download');

        Route::post('backup/restore', [BackupController::class, 'restore'])
            ->name('backup.restore');
    });
});
