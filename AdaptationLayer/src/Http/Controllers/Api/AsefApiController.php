<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Api;

use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;
use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use AsefSondaj\AdaptationLayer\Models\AsefBlog;
use AsefSondaj\AdaptationLayer\Models\AsefFaq;
use AsefSondaj\AdaptationLayer\Models\AsefGlossaryTerm;
use AsefSondaj\AdaptationLayer\Models\AsefProduct;
use AsefSondaj\AdaptationLayer\Models\AsefSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

/**
 * Public read-only JSON API for the Asef Sondaj Flutter mobile app.
 *
 * Endpoints:
 *   GET /api/asef/health              — versioning + health check
 *   GET /api/asef/settings            — public settings (contact, hero, footer)
 *   GET /api/asef/categories          — 15 ana + 63 alt kategori
 *   GET /api/asef/products            — 813 ürün (pagination + filter)
 *   GET /api/asef/products/{sku}      — tek ürün detay
 *   GET /api/asef/blogs               — 9+ blog liste
 *   GET /api/asef/blogs/{slug}        — tek blog detay
 *   GET /api/asef/faqs                — 20+ SSS
 *   GET /api/asef/glossary            — 50+ sözlük terimi
 *
 * Format: JSON. Auth: none (public read-only).
 * CORS: * (mobile app cross-origin).
 */
class AsefApiController extends Controller
{
    public function health(): JsonResponse
    {
        return $this->json([
            'ok'         => true,
            'service'    => 'Asef Sondaj API',
            'version'    => '1.0.0',
            'timestamp'  => now()->toIso8601String(),
            'endpoints'  => [
                'settings', 'categories', 'products', 'products/{sku}',
                'blogs', 'blogs/{slug}', 'faqs', 'glossary',
            ],
        ]);
    }

    public function settings(): JsonResponse
    {
        try {
            $rows = AsefSetting::orderBy('sort')->get(['key', 'group', 'label', 'value', 'type']);
            return $this->json(['data' => $rows]);
        } catch (\Throwable $e) {
            return $this->json(['data' => [], 'error' => 'db_unavailable']);
        }
    }

    public function categories(): JsonResponse
    {
        $ana = AsefAnaKategori::orderBy('sort')->get(['code', 'slug', 'name', 'description', 'image', 'sort']);
        $alt = AsefAltKategori::orderBy('sort')->get(['code', 'slug', 'name', 'parent_code', 'image', 'sort']);

        // Nested structure for mobile
        $altGrouped = $alt->groupBy('parent_code');
        $tree = $ana->map(function ($a) use ($altGrouped) {
            $a->alt_kategoriler = $altGrouped->get($a->code, collect())->values();
            return $a;
        });

        return $this->json([
            'ana' => $ana,
            'alt' => $alt,
            'tree' => $tree,
            'meta' => ['total_ana' => $ana->count(), 'total_alt' => $alt->count()],
        ]);
    }

    public function products(Request $req): JsonResponse
    {
        $q = AsefProduct::query()->where('is_active', true);

        if ($ana = trim((string) $req->query('ana', ''))) {
            $q->where('ana_code', $ana);
        }
        if ($alt = trim((string) $req->query('alt', ''))) {
            $q->where('alt_code', $alt);
        }
        if ($search = trim((string) $req->query('q', ''))) {
            $skuUpper = strtoupper(str_replace(' ', '', $search));
            $q->where(function ($sub) use ($search, $skuUpper) {
                $sub->where('sku', 'like', $skuUpper . '%')
                    ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        $perPage = min(100, max(10, (int) $req->query('per_page', 30)));
        $items = $q->orderBy('sort')->orderBy('sku')
            ->paginate($perPage, ['sku', 'slug', 'name', 'ana_code', 'alt_code', 'description', 'image', 'attrs', 'sort']);

        return $this->json([
            'data' => $items->items(),
            'meta' => [
                'total'        => $items->total(),
                'per_page'     => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page'    => $items->lastPage(),
            ],
        ]);
    }

    public function product(string $sku): JsonResponse
    {
        // Slug öncelik, SKU fallback
        $product = AsefProduct::where('slug', $sku)->first();
        if (! $product) {
            $product = AsefProduct::where('sku', strtoupper($sku))->first();
        }
        if (! $product) {
            return $this->json(['error' => 'not_found'], 404);
        }

        // İlgili ürünler (aynı alt kategori)
        $related = AsefProduct::where('is_active', true)
            ->where('alt_code', $product->alt_code)
            ->where('sku', '!=', $product->sku)
            ->orderBy('sort')->limit(4)
            ->get(['sku', 'slug', 'name', 'image', 'attrs']);

        return $this->json([
            'data'    => $product,
            'related' => $related,
        ]);
    }

    public function blogs(): JsonResponse
    {
        try {
            $items = AsefBlog::where('is_active', true)
                ->orderByDesc('published_at')->orderBy('sort')
                ->get(['slug', 'title', 'cat', 'lede', 'image', 'author', 'read_time', 'published_at']);
            return $this->json(['data' => $items]);
        } catch (\Throwable $e) {
            return $this->json(['data' => []]);
        }
    }

    public function blog(string $slug): JsonResponse
    {
        try {
            $item = AsefBlog::where('slug', $slug)->where('is_active', true)->first();
            if (! $item) return $this->json(['error' => 'not_found'], 404);
            return $this->json(['data' => $item]);
        } catch (\Throwable $e) {
            return $this->json(['error' => 'db_unavailable'], 500);
        }
    }

    public function faqs(): JsonResponse
    {
        try {
            $items = AsefFaq::where('is_active', true)
                ->orderBy('sort')->orderBy('id')
                ->get(['q', 'a', 'sort']);
            return $this->json(['data' => $items]);
        } catch (\Throwable $e) {
            return $this->json(['data' => []]);
        }
    }

    public function glossary(): JsonResponse
    {
        try {
            $items = AsefGlossaryTerm::where('is_active', true)
                ->orderBy('term')
                ->get(['term', 'definition']);
            return $this->json(['data' => $items]);
        } catch (\Throwable $e) {
            return $this->json(['data' => []]);
        }
    }

    /**
     * Standart JSON response — CORS + cache header.
     */
    protected function json(array $payload, int $status = 200): JsonResponse
    {
        return response()->json($payload, $status, [
            'Access-Control-Allow-Origin'  => '*',
            'Access-Control-Allow-Methods' => 'GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, Accept',
            'Cache-Control'                => 'public, max-age=300',  // 5 dk cache
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
