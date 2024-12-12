<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\AdminLteServiceProvider;
use Illuminate\Support\Facades\View;
use App\AdminLte;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(AdminLteServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('adminlte', $this->app->make(AdminLte::class));
    }
}
