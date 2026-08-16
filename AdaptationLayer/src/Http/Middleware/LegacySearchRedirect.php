<?php

namespace AsefSondaj\AdaptationLayer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Legacy /search?ana=X&alt=Y URL'lerini yeni SEO-friendly
 * /urunler/{ana-slug}/{alt-slug} URL'lerine 301 redirect eder.
 *
 * SEO best practice: sadece 301. Noindex + 301 kombinasyonu YANLIŞ —
 * Google 301 sonrası eski sayfayı render etmez, meta robots görülmez.
 *
 * Gerçek /search?query=... arama sorguları redirect edilmez.
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
                $alt = \AsefSondaj\AdaptationLayer\Models\AsefAltKategori::where('code', $altCode)->first();
                if ($alt && $alt->slug) {
                    $ana = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::where('code', $alt->parent_code)->first();
                    if ($ana && $ana->slug) {
                        $newUrl = url('urunler/' . $ana->slug . '/' . $alt->slug);
                    }
                }
            } elseif ($anaCode) {
                $ana = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::where('code', $anaCode)->first();
                if ($ana && $ana->slug) {
                    $newUrl = url('urunler/' . $ana->slug);
                }
            }

            if ($newUrl) {
                return redirect($newUrl, 301);
            }
        } catch (\Throwable $e) {
            // DB henüz hazır değilse veya slug yoksa — sessizce fallback
        }

        return $next($request);
    }
}
