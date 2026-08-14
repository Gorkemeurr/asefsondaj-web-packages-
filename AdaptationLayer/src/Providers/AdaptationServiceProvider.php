<?php

namespace AsefSondaj\AdaptationLayer\Providers;

use AsefSondaj\AdaptationLayer\Http\Middleware\BlockDisabledRoutes;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Routing\Router;
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

        // 3) Push our middleware into the "web" group so all storefront
        //    requests pass through it. Admin/API paths are skipped inside
        //    the middleware itself.
        /** @var Router $router */
        $router = $this->app->make(Router::class);
        $router->pushMiddlewareToGroup('web', BlockDisabledRoutes::class);

        // 4) Publishable config (optional — lets ops override values).
        $this->publishes([
            $this->getPath('Config/asef.php') => config_path('asef.php'),
        ], 'asef-config');
    }

    protected function getPath(string $path): string
    {
        return dirname(__DIR__).'/'.ltrim($path, '/');
    }
}
