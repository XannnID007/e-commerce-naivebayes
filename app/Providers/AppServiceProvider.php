<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Services\NaiveBayesService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind NaiveBayesService sebagai singleton
        $this->app->singleton(NaiveBayesService::class, function ($app) {
            return new NaiveBayesService();
        });
    }

    public function boot()
    {
        // Gunakan custom pagination view
        Paginator::defaultView('custom.pagination');
        Paginator::defaultSimpleView('custom.simple-pagination');

        // Set default timezone
        date_default_timezone_set('Asia/Jakarta');
    }
}
