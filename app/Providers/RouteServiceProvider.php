<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // API routes
            Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

            // Rider routes
            Route::middleware('api')->prefix('api')->group(base_path('routes/rider.php'));

            // Rider routes
            Route::middleware('api')->prefix('api')->group(base_path('routes/seller.php'));

            // Shop routes
            Route::middleware('web')->prefix('shop')->group(base_path('routes/shop.php'));

            // Admin routes
            Route::middleware('web')->prefix('admin')->group(base_path('routes/admin.php'));

            // Web routes
            Route::middleware('web')->group(base_path('routes/web.php'));
        });
    }
}
