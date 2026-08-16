<?php

namespace AsefSondaj\AdaptationLayer\Providers;

use AsefSondaj\AdaptationLayer\Http\Middleware\BlockDisabledRoutes;
use AsefSondaj\AdaptationLayer\Http\Middleware\FreshCacheHeaders;
use AsefSondaj\AdaptationLayer\Http\Middleware\LegacySearchRedirect;
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

        // Bagisto admin menu genişlet — Asef Sondaj grubu + alt öğeler
        // menu.admin config'ine merge et (Bagisto AdminServiceProvider
        // dosyayı 'menu.admin' key altında yükler)
        $this->mergeConfigFrom($this->getPath('Config/admin-menu.php'), 'menu.admin');

        // Override Bagisto's SitemapController with our AsefSitemapController.
        // Bagisto's route ('sitemap.xml', 'robots.txt') resolves the controller
        // through the container; binding a subclass makes Bagisto call OUR
        // index()/robots() methods and returns our full sitemap.
        $this->app->bind(
            \Webkul\Shop\Http\Controllers\SitemapController::class,
            \AsefSondaj\AdaptationLayer\Http\Controllers\AsefSitemapController::class
        );

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
            $kernel->pushMiddleware(FreshCacheHeaders::class);
            $kernel->pushMiddleware(LegacySearchRedirect::class);
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
            // SEO-friendly katalog URL yapısı — /urunler/{ana-slug}/{alt-slug}
            Route::get('/urunler', function () {
                // /urunler → ana katalog (search view, filtresiz)
                return view('asef-adaptation::shop.search.index');
            })->name('shop.asef.catalog');

            Route::get('/urunler/{ana_slug}', function (string $anaSlug) {
                $ana = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::where('slug', $anaSlug)->first();
                if (! $ana) abort(404);
                return view('asef-adaptation::shop.search.index', [
                    'seoAnaCode' => $ana->code,
                ]);
            })->name('shop.asef.category-ana')->where('ana_slug', '[a-z0-9\-]+');

            Route::get('/urunler/{ana_slug}/{alt_slug}', function (string $anaSlug, string $altSlug) {
                $ana = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::where('slug', $anaSlug)->first();
                if (! $ana) abort(404);
                $alt = \AsefSondaj\AdaptationLayer\Models\AsefAltKategori::where('slug', $altSlug)
                    ->where('parent_code', $ana->code)
                    ->first();
                if (! $alt) abort(404);
                return view('asef-adaptation::shop.search.index', [
                    'seoAnaCode' => $ana->code,
                    'seoAltCode' => $alt->code,
                ]);
            })->name('shop.asef.category-alt')->where(['ana_slug' => '[a-z0-9\-]+', 'alt_slug' => '[a-z0-9\-]+']);

            // Ürün detay — slug (yeni SEO URL) veya SKU (backward compat).
            // Parameter adı 'sku' KALIR — mevcut route('shop.asef.product', ['sku' => ...]) çağrılarını kırmayalım.
            Route::get('/urun/{sku}', function (string $sku) {
                // Önce slug ile ara (yeni SEO URL: /urun/bwl-karotiyer-15-m)
                $product = \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('slug', $sku)->first();

                if (! $product) {
                    // Fallback: SKU (uppercase) ile ara — eski /urun/AS-KRT-001 URL'leri
                    $product = \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('sku', strtoupper($sku))->first();

                    // Eğer SKU eşleşti VE ürünün slug'ı varsa → 301 redirect yeni slug URL'ine
                    if ($product && $product->slug && $product->slug !== $sku) {
                        return redirect(url('urun/' . $product->slug), 301);
                    }
                }

                if (! $product) {
                    abort(404);
                }

                return view('asef-adaptation::product-detail', [
                    'sku' => $product->sku,
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

            // (Dev-only) Debug URL — Bagisto /sitemap.xml override edilemezse yedek.
            Route::get('/asef-sitemap.xml', function () {
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
                foreach (['hakkimizda','kurumsal','sondaj-makinalarimiz','hizmetlerimiz','referanslar','sss','iletisim','destek','sondaj-sozlugu'] as $slug) {
                    $push(url($slug), $now, 'monthly', '0.7');
                }
                // Blog kategori landing (4 kategori)
                foreach (['ekipman-rehberi','vaka-calismalari','sektor-trendleri','teknik-ipuclari'] as $cat) {
                    $push(url('blog/kategori/' . $cat), $now, 'weekly', '0.7');
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

            // robots.txt Bagisto route + AsefSitemapController override üzerinden çalışır.

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

            // Blog kategori landing (BEFORE /blog/{slug} — 2 segment wins)
            Route::get('/blog/kategori/{cat}', function (string $cat) {
                return view('asef-adaptation::blog-kategori', ['cat' => $cat]);
            })->name('shop.asef.blog-category')->where('cat', '[a-z0-9\-]+');

            Route::get('/blog/{slug}', function (string $slug) {
                return view('asef-adaptation::blog-detay', ['slug' => $slug]);
            })->name('shop.asef.blog-post')->where('slug', '[a-z0-9\-]+');

            // llms.txt — AI arama motorlarına (ChatGPT, Perplexity, Claude) site kılavuzu
            Route::get('/llms.txt', function () {
                return response(view('asef-adaptation::llms-txt')->render(), 200, [
                    'Content-Type' => 'text/plain; charset=utf-8',
                    'Cache-Control' => 'public, max-age=3600',
                ]);
            })->name('shop.asef.llms-txt');

            // Sondaj sözlüğü — 60+ sektör terimi
            Route::get('/sondaj-sozlugu', function () {
                return view('asef-adaptation::sondaj-sozlugu');
            })->name('shop.asef.glossary');

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

        // ============================================================
        //  ADMIN ROUTES — Bagisto admin panel altında Asef Sondaj CRUD
        // ============================================================
        $adminPrefix = config('app.admin_url') . '/asef';

        Route::prefix($adminPrefix)
            ->middleware(['web', 'admin'])
            ->name('admin.asef.')
            ->group(function () {
                // Ana Kategoriler
                Route::get('/kategoriler/ana', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AnaKategoriController::class, 'index'])->name('categories.ana.index');
                Route::get('/kategoriler/ana/create', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AnaKategoriController::class, 'create'])->name('categories.ana.create');
                Route::post('/kategoriler/ana', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AnaKategoriController::class, 'store'])->name('categories.ana.store');
                Route::get('/kategoriler/ana/{code}/edit', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AnaKategoriController::class, 'edit'])->name('categories.ana.edit');
                Route::put('/kategoriler/ana/{code}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AnaKategoriController::class, 'update'])->name('categories.ana.update');
                Route::delete('/kategoriler/ana/{code}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AnaKategoriController::class, 'destroy'])->name('categories.ana.destroy');

                // Alt Kategoriler
                Route::get('/kategoriler/alt', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AltKategoriController::class, 'index'])->name('categories.alt.index');
                Route::get('/kategoriler/alt/create', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AltKategoriController::class, 'create'])->name('categories.alt.create');
                Route::post('/kategoriler/alt', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AltKategoriController::class, 'store'])->name('categories.alt.store');
                Route::get('/kategoriler/alt/{code}/edit', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AltKategoriController::class, 'edit'])->name('categories.alt.edit');
                Route::put('/kategoriler/alt/{code}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AltKategoriController::class, 'update'])->name('categories.alt.update');
                Route::delete('/kategoriler/alt/{code}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\AltKategoriController::class, 'destroy'])->name('categories.alt.destroy');

                // Ürünler
                Route::get('/urunler', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\UrunController::class, 'index'])->name('products.index');
                Route::get('/urunler/create', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\UrunController::class, 'create'])->name('products.create');
                Route::post('/urunler', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\UrunController::class, 'store'])->name('products.store');
                Route::get('/urunler/{sku}/edit', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\UrunController::class, 'edit'])->name('products.edit');
                Route::put('/urunler/{sku}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\UrunController::class, 'update'])->name('products.update');
                Route::delete('/urunler/{sku}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\UrunController::class, 'destroy'])->name('products.destroy');

                // Blog Yazıları — Faz 2'de DB'ye taşınacak, şu an placeholder
                Route::get('/bloglar', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\BlogController::class, 'index'])->name('blog.index');

                // SSS full CRUD
                Route::get('/faqs', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\FaqController::class, 'index'])->name('faqs.index');
                Route::get('/faqs/create', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\FaqController::class, 'create'])->name('faqs.create');
                Route::post('/faqs', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\FaqController::class, 'store'])->name('faqs.store');
                Route::get('/faqs/{id}/edit', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\FaqController::class, 'edit'])->name('faqs.edit');
                Route::put('/faqs/{id}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\FaqController::class, 'update'])->name('faqs.update');
                Route::delete('/faqs/{id}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\FaqController::class, 'destroy'])->name('faqs.destroy');

                // Genel Ayarlar (hero, footer, iletişim, WhatsApp)
                Route::get('/ayarlar', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\SettingsController::class, 'index'])->name('settings.index');
                Route::put('/ayarlar', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\SettingsController::class, 'update'])->name('settings.update');

                // Sözlük full CRUD
                Route::get('/sozluk', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\GlossaryController::class, 'index'])->name('glossary.index');
                Route::get('/sozluk/create', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\GlossaryController::class, 'create'])->name('glossary.create');
                Route::post('/sozluk', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\GlossaryController::class, 'store'])->name('glossary.store');
                Route::get('/sozluk/{id}/edit', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\GlossaryController::class, 'edit'])->name('glossary.edit');
                Route::put('/sozluk/{id}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\GlossaryController::class, 'update'])->name('glossary.update');
                Route::delete('/sozluk/{id}', [\AsefSondaj\AdaptationLayer\Http\Controllers\Admin\GlossaryController::class, 'destroy'])->name('glossary.destroy');
            });
    }

    protected function getPath(string $path): string
    {
        return dirname(__DIR__).'/'.ltrim($path, '/');
    }
}
