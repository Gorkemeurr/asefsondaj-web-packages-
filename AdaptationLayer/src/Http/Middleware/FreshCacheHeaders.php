<?php

namespace AsefSondaj\AdaptationLayer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Force fresh HTML on every request (no browser caching).
 *
 * Bagisto/Laravel default Cache-Control is 'no-cache, private' — browser
 * revalidates but may serve stale HTML during deploys when the origin
 * still returns 304. We force 'no-store' so the browser NEVER stores
 * HTML — always fetches fresh from origin.
 *
 * Static assets (favicon, images) bypass this.
 */
class FreshCacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only touch HTML/text responses — not images, css, js, etc.
        $ct = $response->headers->get('Content-Type', '');
        if (! str_starts_with($ct, 'text/html')) {
            return $response;
        }

        // Skip admin and API — they may have their own cache logic.
        $path = $request->path();
        if (str_starts_with($path, 'admin') || str_starts_with($path, 'api/')) {
            return $response;
        }

        $response->headers->set('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
