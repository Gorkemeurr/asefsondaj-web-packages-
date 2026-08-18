<?php

namespace AsefSondaj\AdaptationLayer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ForceWwwHost
 *
 * SEO: Ana domain'i tek bir host'a kilitler (www.asefsondaj.com).
 * asefsondaj.com (www'siz) -> 301 https://www.asefsondaj.com/...
 *
 * Neden: Google SEO otorite sinyalleri (backlink, sosyal paylasim, AI atif)
 * iki farkli host arasinda bolunmemesi icin tek canonical host gerekli.
 *
 * Cloudflare + Bagisto arkasinda calisir; Host header'i degistirmez, sadece
 * 301 dondurur. Sonsuz loop koruma: sadece scheme=https + host non-www ise redirect.
 */
class ForceWwwHost
{
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // asefsondaj.com (www'siz) ise -> www.asefsondaj.com'a 301
        if ($host === 'asefsondaj.com') {
            $url = 'https://www.asefsondaj.com' . $request->getRequestUri();
            return redirect($url, 301);
        }

        return $next($request);
    }
}
