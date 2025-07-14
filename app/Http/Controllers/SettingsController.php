<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => config('app.name'),
            'naive_bayes_min_accuracy' => env('NAIVE_BAYES_MIN_ACCURACY', 80),
            'naive_bayes_auto_retrain' => env('NAIVE_BAYES_AUTO_RETRAIN', true),
            'default_products_per_page' => env('DEFAULT_PRODUCTS_PER_PAGE', 12),
            'max_upload_size' => env('MAX_UPLOAD_SIZE', 2048),
            'supported_image_formats' => env('SUPPORTED_IMAGE_FORMATS', 'jpeg,png,jpg,gif')
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'naive_bayes_min_accuracy' => 'required|numeric|min:0|max:100',
            'default_products_per_page' => 'required|integer|min:1|max:100',
            'max_upload_size' => 'required|integer|min:1|max:10240'
        ]);

        // Dalam implementasi nyata, ini akan update file .env
        // Untuk demo, kita simpan di cache
        Cache::put('app_settings', $request->all(), 3600);

        return redirect()->back()
            ->with('success', 'Pengaturan berhasil disimpan!');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');

        return redirect()->back()
            ->with('success', 'Cache berhasil dibersihkan!');
    }

    public function optimizeApp()
    {
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:cache');

        return redirect()->back()
            ->with('success', 'Aplikasi berhasil dioptimasi!');
    }
}
