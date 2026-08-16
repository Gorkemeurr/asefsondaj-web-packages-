<?php

namespace AsefSondaj\AdaptationLayer\Http\Middleware;

use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;
use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use Closure;
use Illuminate\Http\Request;

/**
 * Legacy /search?ana=X&alt=Y URL'lerini yeni SEO-friendly
 * /urunler/{ana-slug}/{alt-slug} URL'lerine 301 redirect eder.
 *
 * Google migration best practice: sadece 301 (noindex + 301 kombinasyonu YANLIŞ —
 * Google 301 sonrası eski sayfayı render etmez, meta robots görülmez).
 * 301 kalıcı redirect canonical sinyali olarak yeter.
 *
 * Gerçek /search?query=... arama sorguları redirect edilmez (arama fonksiyonu çalışsın).
 */
class LegacySearchRedirect
{
    public function handle(Request $request, Closure $next)
    {
        // Sadece /search yolu için
        if ($request->path() !== 'search') {
            return $next($request);
        }

        $anaCode = trim((string) $request->query('ana', ''));
        $altCode = trim((string) $request->query('alt', ''));

        // Kategori filtresi yoksa (sadece arama sorgusu vs.) devam
        if (! $anaCode && ! $altCode) {
            return $next($request);
        }

        try {
            $newUrl = null;

            if ($altCode) {
                $alt = AsefAltKategori::where('code', $altCode)->first();
                if ($alt && $alt->slug) {
                    // Alt kategori için parent ana'yı da bul
                    $ana = AsefAnaKategori::where('code', $alt->parent_code)->first();
                    if ($ana && $ana->slug) {
                        $newUrl = url('urunler/' . $ana->slug . '/' . $alt->slug);
                    }
                }
            } elseif ($anaCode) {
                $ana = AsefAnaKategori::where('code', $anaCode)->first();
                if ($ana && $ana->slug) {
                    $newUrl = url('urunler/' . $ana->slug);
                }
            }

            if ($newUrl) {
                return redirect()->to($newUrl, 301);
            }
        } catch (\Throwable $e) {
            // DB henüz hazır değilse veya slug yoksa — sessizce fallback + normal render
        }

        return $next($request);
    }
}
