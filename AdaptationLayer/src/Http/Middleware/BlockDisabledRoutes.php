<?php

namespace AsefSondaj\AdaptationLayer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * BlockDisabledRoutes
 *
 * Redirects (or 404s) storefront requests that hit checkout / cart /
 * customer / order / wishlist paths. Admin panel is never affected.
 *
 * Configured via config('asef.blocked_prefixes') and config('asef.blocked_action').
 */
class BlockDisabledRoutes
{
    public function handle(Request $request, Closure $next): Response
    {
        $path = ltrim($request->path(), '/');

        // Never touch admin routes.
        if ($path === 'admin' || str_starts_with($path, 'admin/')) {
            return $next($request);
        }

        // Never touch API routes.
        if (str_starts_with($path, 'api/') || str_starts_with($path, 'graphql')) {
            return $next($request);
        }

        $prefixes = config('asef.blocked_prefixes', []);

        foreach ($prefixes as $prefix) {
            $prefix = ltrim($prefix, '/');

            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return $this->blockedResponse($request);
            }
        }

        return $next($request);
    }

    protected function blockedResponse(Request $request): Response
    {
        $action = config('asef.blocked_action', 'home');

        if ($action === 'abort') {
            abort(404);
        }

        // Default: redirect to storefront home
        return redirect(url('/'));
    }
}
