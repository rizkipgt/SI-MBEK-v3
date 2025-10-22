<?php

namespace App\Providers;

use App\Models\SiteSetting; // Tambahkan ini
use Illuminate\Support\Facades\View; // Tambahkan ini
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
         // Tambahkan ini untuk share settings ke header
        View::composer('components.navbar-v2', function ($view) {
            $view->with('settings', SiteSetting::first());
        });
        
    }
}
