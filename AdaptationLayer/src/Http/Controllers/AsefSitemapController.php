<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers;

use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;
use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use AsefSondaj\AdaptationLayer\Models\AsefProduct;
use Illuminate\Http\Response;
use Webkul\Shop\Http\Controllers\SitemapController as BagistoSitemapController;

/**
 * Bagisto SitemapController override.
 *
 * Container binding: AdaptationServiceProvider::register() içinde bu sınıf
 * BagistoSitemapController yerine bind edilir. Bagisto'nun kendi rotası
 * (/sitemap.xml, /robots.txt) böylece bizim override'ımızı çağırır.
 *
 * Parent sınıftan miras alarak sadece index() ve robots() metodlarını
 * override ederiz — constructor + diğer methodlar Bagisto'nun kendi
 * repository injection'ıyla çalışır.
 */
class AsefSitemapController extends BagistoSitemapController
{
    /**
     * /sitemap.xml — 813 ürün + 15 ana + 63 alt kategori + statik sayfalar.
     */
    public function index(): Response
    {
        $now = date('Y-m-d');
        $base = url('');
        $urls = [];

        $add = function (string $loc, ?string $lastmod = null, string $changefreq = 'weekly', string $priority = '0.5') use (&$urls, $now) {
            $urls[] = compact('loc') + [
                'lastmod'    => $lastmod ?: $now,
                'changefreq' => $changefreq,
                'priority'   => $priority,
            ];
        };

        // Ana sayfa
        $add($base . '/', $now, 'daily', '1.0');

        // Kurumsal + statik + sözlük
        foreach (['hakkimizda','kurumsal','sondaj-makinalarimiz','hizmetlerimiz','referanslar','sss','iletisim','destek','sondaj-sozlugu'] as $s) {
            $add($base . '/' . $s, $now, 'monthly', '0.7');
        }

        // Blog + galeri + kategori landing
        foreach ([
            'blog','tum-bloglar','blog/fotograf','blog/video',
            'blog/saha-fotograflari','blog/ekipman-fotograflari','blog/proje-fotograflari',
            'blog/urun-tanitim-videolari','blog/saha-uygulamalari','blog/teknik-anlatimlar',
            'blog/kategori/ekipman-rehberi','blog/kategori/vaka-calismalari',
            'blog/kategori/sektor-trendleri','blog/kategori/teknik-ipuclari',
        ] as $s) {
            $add($base . '/' . $s, $now, 'weekly', '0.6');
        }

        // Blog yazıları
        foreach ([
            'ekipman-secim-rehberi','dth-cekic-bakim','sondaj-tiji-baglanti','camur-pompa-verim',
            'karot-hatalari','su-sondaji-mevzuat','yerustu-yeralti','karotier-ipuclari','yedek-parca-stok',
        ] as $s) {
            $add($base . '/blog/' . $s, $now, 'monthly', '0.6');
        }

        // Legal
        foreach (['kvkk','gizlilik-politikasi','cerez-politikasi','kullanim-sartlari'] as $s) {
            $add($base . '/' . $s, $now, 'yearly', '0.3');
        }

        // Katalog kök
        $add($base . '/search', $now, 'daily', '0.9');

        // Ana kategoriler + alt
        foreach (AsefAnaKategori::orderBy('sort')->get() as $ana) {
            $add($base . '/search?ana=' . $ana->code, $now, 'weekly', '0.8');
        }
        foreach (AsefAltKategori::orderBy('sort')->get() as $alt) {
            $add($base . '/search?ana=' . $alt->parent_code . '&alt=' . $alt->code, $now, 'weekly', '0.7');
        }

        // Ürünler
        foreach (AsefProduct::where('is_active', true)->get(['sku','updated_at']) as $p) {
            $add(
                $base . '/urun/' . $p->sku,
                optional($p->updated_at)->format('Y-m-d') ?: $now,
                'weekly',
                '0.7'
            );
        }

        $xml  = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
        $xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        foreach ($urls as $u) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>" . htmlspecialchars($u['loc']) . "</loc>\n";
            $xml .= "    <lastmod>{$u['lastmod']}</lastmod>\n";
            $xml .= "    <changefreq>{$u['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$u['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }
        $xml .= "</urlset>\n";

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=utf-8']);
    }

    /**
     * /robots.txt — sitemap referansı ile.
     */
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin/',
            'Disallow: /sepet',
            'Disallow: /checkout',
            'Disallow: /customer/',
            '',
            'Sitemap: ' . url('sitemap.xml'),
            '',
        ];
        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=utf-8']);
    }
}
