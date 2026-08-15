<?php

namespace AsefSondaj\AdaptationLayer\Providers;

use AsefSondaj\AdaptationLayer\Http\Middleware\BlockDisabledRoutes;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * AdaptationServiceProvider
 *
 * Boots the Asef Sondaj adaptation:
 *   - registers config asef.php
 *   - registers view namespace "asef-adaptation" + high-priority shop overrides
 *   - pushes BlockDisabledRoutes middleware into the "web" group
 *
 * Does NOT touch any Webkul/* package.
 */
class AdaptationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom($this->getPath('Config/asef.php'), 'asef');
    }

    public function boot(): void
    {
        // 1) Load our own view namespace (for future custom pages / partials).
        $this->loadViewsFrom($this->getPath('Resources/views'), 'asef-adaptation');

        // 2) Register shop view overrides at a HIGHER priority than the
        //    Bagisto Shop package. Laravel picks the first-registered
        //    view path that contains a match, so prepend ours.
        $shopOverrides = $this->getPath('Resources/views/shop');

        if (is_dir($shopOverrides)) {
            // Bagisto uses Webkul\Theme\ThemeViewFinder which lacks setHints/getHints.
            // Use Laravel's View facade prependNamespace() which is finder-agnostic.
            $this->app['view']->prependNamespace('shop', $shopOverrides);
        }

        // 3) Register the middleware GLOBALLY via HTTP Kernel so every
        //    request runs it (Bagisto shop routes don't consistently use
        //    the 'web' group, so pushMiddlewareToGroup misses them).
        //    Admin/API paths are skipped inside the middleware itself.
        try {
            $kernel = $this->app->make(Kernel::class);
            $kernel->pushMiddleware(BlockDisabledRoutes::class);
        } catch (\Throwable $e) {
            // kernel not accessible in this context (rare) — fall back to group registration below
        }

        // 3b) Also push to the router's web + shop groups as a belt-and-braces
        //     — some setups use these groups for storefront routes.
        /** @var Router $router */
        $router = $this->app->make(Router::class);
        foreach (['web', 'shop'] as $group) {
            try {
                $router->pushMiddlewareToGroup($group, BlockDisabledRoutes::class);
            } catch (\Throwable $e) {
                // group may not exist — safe to ignore
            }
        }

        // 4) Publishable config (optional — lets ops override values).
        $this->publishes([
            $this->getPath('Config/asef.php') => config_path('asef.php'),
        ], 'asef-config');

        // 5) Asef-specific storefront routes (product detail + sepet).
        //    Uses "web" middleware so it participates in Bagisto session/CSRF.
        Route::middleware('web')->group(function () {
            Route::get('/urun/{sku}', function (string $sku) {
                return view('asef-adaptation::product-detail', [
                    'sku' => strtoupper($sku),
                ]);
            })->name('shop.asef.product')->where('sku', '[A-Za-z0-9\-]+');

            Route::get('/sepet', function () {
                return view('asef-adaptation::sepet');
            })->name('shop.asef.cart');

            Route::get('/hakkimizda', function () {
                return view('asef-adaptation::hakkimizda');
            })->name('shop.asef.about');
        });
    }

    protected function getPath(string $path): string
    {
        return dirname(__DIR__).'/'.ltrim($path, '/');
    }
}
