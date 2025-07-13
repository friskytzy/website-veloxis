<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Bike;
use App\Observers\BikeObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the BikeObserver
        Bike::observe(BikeObserver::class);
    }
}
