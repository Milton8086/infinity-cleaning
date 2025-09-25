<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register bindings or services here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Code to run on every request, e.g., view composers
    }
}

