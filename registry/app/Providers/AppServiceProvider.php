<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //debugger

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facades\Debugbar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Dashboard routes (protected)
        Route::middleware(['web', 'auth'])
            ->prefix('admin') // optional: gives you URLs like /admin/dashboard
            ->group(base_path('routes/dashboard.php'));
    }
}
