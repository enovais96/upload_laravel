<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\CsvServiceInterface;
use App\Services\Interfaces\CsvProcessorServiceInterface;
use App\Services\Implementation\CsvService;
use App\Services\Implementation\CsvProcessorService;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(CsvServiceInterface::class, CsvService::class);
        $this->app->bind(CsvProcessorServiceInterface::class, CsvProcessorService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
