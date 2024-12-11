<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\paginator;
use App\Auth\CustomEloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        paginator::useBootstrap();

        // Custom Eloquent Provider
        Auth::provider('custom-eloquent', function ($app, array $config) {
            return new CustomEloquentUserProvider($app['hash'], $config['model']);
        });
    }
}
