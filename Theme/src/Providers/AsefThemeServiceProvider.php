<?php

namespace AsefSondaj\Theme\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * AsefThemeServiceProvider
 *
 * Registers the Asef Sondaj web theme:
 *   - Loads config asef-theme.php
 *   - Loads own view namespace "asef-theme"
 *   - Prepends shop:: overrides (highest priority — beats Webkul\Shop)
 *   - Loads asef routes (/teklif, /iletisim, /katalog)
 *   - Shares brand + nav config with all views
 *
 * Does NOT touch packages/Webkul/*.
 */
class AsefThemeServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom($this->getPath('Config/asef-theme.php'), 'asef-theme');
    }

    public function boot(): void
    {
        // 1) View namespaces
        $this->loadViewsFrom($this->getPath('Resources/views'), 'asef-theme');

        // 2) Prepend shop overrides so our storefront views win.
        $shopOverrides = $this->getPath('Resources/views/shop');
        if (is_dir($shopOverrides)) {
            View::prependNamespace('shop', $shopOverrides);
        }

        // 3) Routes (asef-themed pages: /teklif, /iletisim, /katalog fallback)
        $routesFile = $this->getPath('Routes/web.php');
        if (is_file($routesFile)) {
            Route::middleware('web')->group($routesFile);
        }

        // 4) Share brand + nav globally with all views (so Blade partials can render header/nav)
        View::composer('*', function ($view) {
            $view->with('asefBrand',   config('asef-theme.brand'));
            $view->with('asefContact', config('asef-theme.contact'));
            $view->with('asefNav',     config('asef-theme.nav'));
        });

        // 5) Publish assets to public/asef-theme/ for install.sh
        $this->publishes([
            $this->getPath('Resources/assets') => public_path('asef-theme'),
        ], 'asef-theme-assets');

        // 6) Register the seeder autoload
        if ($this->app->runningInConsole()) {
            // seeders are picked up via composer autoload (PSR-4)
        }
    }

    protected function getPath(string $path): string
    {
        return dirname(__DIR__).'/'.ltrim($path, '/');
    }
}
