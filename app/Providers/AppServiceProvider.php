<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Pagination\paginator;
use App\Auth\CustomEloquentUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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


        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . '|' . $request->ip());
        });
    }
}
