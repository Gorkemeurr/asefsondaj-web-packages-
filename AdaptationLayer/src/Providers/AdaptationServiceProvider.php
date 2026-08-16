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

        // Bagisto's FPC (Spatie Response Cache) hasher strips all query
        // parameters except "query" from the /search cache key, so
        // /search?cat=delici and /search?cat=tij collide onto the same
        // cached HTML. Our filter and product-detail flows are dynamic
        // (query params, per-visitor cart state) — full-page cache does
        // more harm than good for a low-traffic B2B storefront. Force it
        // off here so we never re-introduce this class of bug.
        config(['responsecache.enabled' => false]);
    }

    public function boot(): void
    {
        // 0) Migrations (asef_products, asef_ana_kategoriler, asef_alt_kategoriler, asef_ebat_ref).
        $this->loadMigrationsFrom($this->getPath('Database/Migrations'));

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
        //    /sepet must NEVER response-cache (localStorage-driven content
        //    depends on the visiting user); /urun/{sku} may be cached (URL
        //    identifies the unique variant).
        $noCache = \Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class;

        Route::middleware('web')->group(function () use ($noCache) {
            Route::get('/urun/{sku}', function (string $sku) {
                return view('asef-adaptation::product-detail', [
                    'sku' => strtoupper($sku),
                ]);
            })->name('shop.asef.product')->where('sku', '[A-Za-z0-9\-]+');

            Route::get('/sepet', function () {
                return view('asef-adaptation::sepet');
            })->name('shop.asef.cart')->middleware($noCache);

            Route::get('/hakkimizda', function () {
                return view('asef-adaptation::hakkimizda');
            })->name('shop.asef.about');

            Route::get('/kurumsal', function () {
                return view('asef-adaptation::kurumsal');
            })->name('shop.asef.corporate');

            Route::get('/tum-bloglar', function () {
                return view('asef-adaptation::tum-bloglar');
            })->name('shop.asef.all-blogs');

            Route::get('/sondaj-makinalarimiz', function () {
                return view('asef-adaptation::sondaj-makinalari');
            })->name('shop.asef.machines');

            Route::get('/hizmetlerimiz', function () {
                return view('asef-adaptation::hizmetlerimiz');
            })->name('shop.asef.services');

            Route::get('/referanslar', function () {
                return view('asef-adaptation::referanslar');
            })->name('shop.asef.references');

            Route::get('/sss', function () {
                return view('asef-adaptation::sss');
            })->name('shop.asef.faq');

            Route::get('/blog', function () {
                return view('asef-adaptation::blog');
            })->name('shop.asef.blog');

            // Dinamik XML sitemap — 813 ürün + 15+63 kategori + tüm statik sayfalar
            Route::get('/sitemap.xml', function () {
                $now = date('Y-m-d');
                $urls = [];
                $push = function (string $loc, string $lastmod = null, string $changefreq = 'weekly', string $priority = '0.5') use (&$urls, $now) {
                    $urls[] = [
                        'loc' => $loc,
                        'lastmod' => $lastmod ?: $now,
                        'changefreq' => $changefreq,
                        'priority' => $priority,
                    ];
                };
                // Ana sayfa
                $push(url('/'), $now, 'daily', '1.0');
                // Statik kurumsal
                foreach (['hakkimizda','kurumsal','sondaj-makinalarimiz','hizmetlerimiz','referanslar','sss','iletisim','destek'] as $slug) {
                    $push(url($slug), $now, 'monthly', '0.7');
                }
                // Blog + galeri
                foreach (['blog','tum-bloglar','blog/fotograf','blog/video',
                          'blog/saha-fotograflari','blog/ekipman-fotograflari','blog/proje-fotograflari',
                          'blog/urun-tanitim-videolari','blog/saha-uygulamalari','blog/teknik-anlatimlar'] as $slug) {
                    $push(url($slug), $now, 'weekly', '0.6');
                }
                // Blog yazıları (blog-detay içinde tanımlı 9 slug)
                foreach (['ekipman-secim-rehberi','dth-cekic-bakim','sondaj-tiji-baglanti','camur-pompa-verim',
                          'karot-hatalari','su-sondaji-mevzuat','yerustu-yeralti','karotier-ipuclari','yedek-parca-stok'] as $slug) {
                    $push(url('blog/' . $slug), $now, 'monthly', '0.6');
                }
                // Legal
                foreach (['kvkk','gizlilik-politikasi','cerez-politikasi','kullanim-sartlari'] as $slug) {
                    $push(url($slug), $now, 'yearly', '0.3');
                }
                // Katalog kök
                $push(url('search'), $now, 'daily', '0.9');
                // Kategori sayfaları — ana + alt
                $anas = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::orderBy('sort')->get();
                foreach ($anas as $ana) {
                    $push(url('search') . '?ana=' . $ana->code, $now, 'weekly', '0.8');
                }
                $alts = \AsefSondaj\AdaptationLayer\Models\AsefAltKategori::orderBy('sort')->get();
                foreach ($alts as $alt) {
                    $push(url('search') . '?ana=' . $alt->parent_code . '&alt=' . $alt->code, $now, 'weekly', '0.7');
                }
                // Ürünler
                $products = \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('is_active', true)->get(['sku','updated_at']);
                foreach ($products as $p) {
                    $push(url('urun/' . $p->sku), optional($p->updated_at)->format('Y-m-d') ?: $now, 'weekly', '0.7');
                }

                $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
                $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
                foreach ($urls as $u) {
                    $xml .= '  <url>' . "\n";
                    $xml .= '    <loc>' . htmlspecialchars($u['loc']) . '</loc>' . "\n";
                    $xml .= '    <lastmod>' . $u['lastmod'] . '</lastmod>' . "\n";
                    $xml .= '    <changefreq>' . $u['changefreq'] . '</changefreq>' . "\n";
                    $xml .= '    <priority>' . $u['priority'] . '</priority>' . "\n";
                    $xml .= '  </url>' . "\n";
                }
                $xml .= '</urlset>' . "\n";
                return response($xml, 200)
                    ->header('Content-Type', 'application/xml; charset=utf-8');
            })->name('shop.asef.sitemap');

            // robots.txt — sitemap'i işaretle
            Route::get('/robots.txt', function () {
                $txt = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /sepet\nDisallow: /checkout\n\nSitemap: " . url('sitemap.xml') . "\n";
                return response($txt, 200)->header('Content-Type', 'text/plain; charset=utf-8');
            })->name('shop.asef.robots');

            // Photo gallery hub + sub-galleries (registered BEFORE /blog/{slug}).
            Route::get('/blog/fotograf', function () {
                return view('asef-adaptation::galeri-fotograf-hub');
            })->name('shop.asef.gallery.photo-hub');

            Route::get('/blog/video', function () {
                return view('asef-adaptation::galeri-video-hub');
            })->name('shop.asef.gallery.video-hub');

            Route::get('/blog/saha-fotograflari', function () {
                return view('asef-adaptation::galeri-fotograf', ['slug' => 'saha-fotograflari']);
            })->name('shop.asef.gallery.saha');

            Route::get('/blog/ekipman-fotograflari', function () {
                return view('asef-adaptation::galeri-fotograf', ['slug' => 'ekipman-fotograflari']);
            })->name('shop.asef.gallery.ekipman');

            Route::get('/blog/proje-fotograflari', function () {
                return view('asef-adaptation::galeri-fotograf', ['slug' => 'proje-fotograflari']);
            })->name('shop.asef.gallery.proje');

            Route::get('/blog/urun-tanitim-videolari', function () {
                return view('asef-adaptation::galeri-video', ['slug' => 'urun-tanitim-videolari']);
            })->name('shop.asef.gallery.urun-video');

            Route::get('/blog/saha-uygulamalari', function () {
                return view('asef-adaptation::galeri-video', ['slug' => 'saha-uygulamalari']);
            })->name('shop.asef.gallery.saha-video');

            Route::get('/blog/teknik-anlatimlar', function () {
                return view('asef-adaptation::galeri-video', ['slug' => 'teknik-anlatimlar']);
            })->name('shop.asef.gallery.teknik-video');

            Route::get('/blog/{slug}', function (string $slug) {
                return view('asef-adaptation::blog-detay', ['slug' => $slug]);
            })->name('shop.asef.blog-post')->where('slug', '[a-z0-9\-]+');

            Route::get('/iletisim', function () {
                return view('asef-adaptation::iletisim');
            })->name('shop.asef.contact');

            Route::get('/destek', function () {
                return view('asef-adaptation::destek');
            })->name('shop.asef.support');

            Route::get('/kvkk', function () {
                return view('asef-adaptation::legal.kvkk');
            })->name('shop.asef.kvkk');

            Route::get('/gizlilik-politikasi', function () {
                return view('asef-adaptation::legal.gizlilik');
            })->name('shop.asef.privacy');

            Route::get('/cerez-politikasi', function () {
                return view('asef-adaptation::legal.cerez');
            })->name('shop.asef.cookies');

            Route::get('/kullanim-sartlari', function () {
                return view('asef-adaptation::legal.kullanim-sartlari');
            })->name('shop.asef.terms');
        });
    }

    protected function getPath(string $path): string
    {
        return dirname(__DIR__).'/'.ltrim($path, '/');
    }
}
