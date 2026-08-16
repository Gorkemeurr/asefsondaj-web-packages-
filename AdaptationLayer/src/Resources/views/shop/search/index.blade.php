{{-- ============================================================
     Asef Sondaj — Ürünler / Katalog (DB backed, 813 ürün)
     Faz 2B: statik 8 ürün kaldırıldı, AsefProduct'tan okur.
     ============================================================ --}}
@php
    use AsefSondaj\AdaptationLayer\Models\AsefProduct;
    use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
    use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;

    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');

    // === FILTER PARAMS ===
    $anaCode   = trim((string) request()->query('ana', ''));
    $altCode   = trim((string) request()->query('alt', ''));
    $queryText = trim((string) request()->query('query', ''));

    // Turkish fold: ç→c, ş→s, ı→i, ğ→g, ö→o, ü→u for case-insensitive matching
    $tr_fold = static function (string $s): string {
        $s = mb_strtolower($s, 'UTF-8');
        return strtr($s, ['ç'=>'c','ş'=>'s','ı'=>'i','ğ'=>'g','ö'=>'o','ü'=>'u','â'=>'a','î'=>'i','û'=>'u']);
    };

    // === CATEGORIES ===
    $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();
    $altKategoriler = $anaCode
        ? AsefAltKategori::where('parent_code', $anaCode)->orderBy('sort')->get()
        : collect();

    // === PRODUCT QUERY ===
    $q = AsefProduct::query()->where('is_active', true);

    if ($anaCode) $q->where('ana_code', $anaCode);
    if ($altCode) $q->where('alt_code', $altCode);

    if ($queryText) {
        $needle = $tr_fold($queryText);
        // Prefix match on SKU (uppercase) — AS-EMB → all EMB products
        $skuUpper = strtoupper(str_replace(' ', '', $queryText));
        $q->where(function ($sub) use ($needle, $skuUpper) {
            $sub->where('sku', 'like', $skuUpper . '%')       // "AS-EMB" → AS-EMB-001..080
                ->orWhere('sku', 'like', '%' . $skuUpper . '%');
            // Turkish-folded name search — MySQL utf8mb4 handles ç/c differ, so we
            // build our own via LOWER + REPLACE. But simple LIKE %needle% first pass:
            $sub->orWhereRaw(
                "REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(LOWER(name), 'ç','c'),'ş','s'),'ı','i'),'ğ','g'),'ö','o'),'ü','u') LIKE ?",
                ['%' . $needle . '%']
            );
        });
    }

    $totalCount = (clone $q)->count();
    // Sort: exact SKU match first, then by sort
    if ($queryText) {
        $skuUpper = strtoupper(str_replace(' ', '', $queryText));
        $q->orderByRaw("CASE WHEN sku = ? THEN 0 WHEN sku LIKE ? THEN 1 ELSE 2 END", [$skuUpper, $skuUpper . '%']);
    }
    $q->orderBy('sort')->orderBy('sku');

    $perPage = 24;
    $products = $q->paginate($perPage)->appends(request()->query());

    // Görsel resolve (image kolonu boşsa alt kategoriden düş)
    $imgUrl = static function (AsefProduct $p): string {
        $file = $p->image ?: 'asef-hero-equipment.jpg';
        return url('asef/' . $file);
    };

    $activeAnaName = null;
    if ($anaCode) {
        $tmp = $anaKategoriler->firstWhere('code', $anaCode);
        $activeAnaName = $tmp ? $tmp->name : null;
    }
    $activeAltName = null;
    if ($altCode) {
        $tmp = AsefAltKategori::where('code', $altCode)->first();
        $activeAltName = $tmp ? $tmp->name : null;
    }
@endphp

@push('meta')
    <meta name="title" content="Ürünler — Asef Sondaj" />
    <meta name="description" content="{{ $totalCount }}+ sondaj ekipmanı — karotier, matkap, tij, pompa. Teklif için WhatsApp'tan yazın." />
    <meta name="theme-color" content="#ffffff" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    /* Chip rows — 15 ana kategori yatay scroll snap */
    .asef-chips-scroll {
        max-width: 1024px; margin: 0 auto 12px; padding: 0 20px;
        display: flex; gap: 10px; overflow-x: auto; scroll-snap-type: x mandatory;
        -webkit-overflow-scrolling: touch;
    }
    .asef-chips-scroll::-webkit-scrollbar { height: 0; }
    .asef-chips-scroll { scrollbar-width: none; }
    .asef-chips-scroll .asef-chip { scroll-snap-align: start; flex-shrink: 0; }
    .asef-chips-alt {
        max-width: 1024px; margin: 0 auto 24px; padding: 0 20px;
        display: flex; gap: 8px; overflow-x: auto; flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .asef-chips-alt::-webkit-scrollbar { height: 0; }
    .asef-chips-alt .asef-chip {
        scroll-snap-align: start; flex-shrink: 0;
        font-size: 12px; padding: 7px 14px;
        background: transparent; border-color: var(--outline);
    }
    .asef-chips-alt .asef-chip.active {
        background: white; color: var(--primary); border-color: var(--primary);
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    /* Pagination */
    .asef-pager { max-width: 1024px; margin: 40px auto 100px; padding: 0 20px; display: flex; justify-content: center; align-items: center; gap: 8px; flex-wrap: wrap; }
    .asef-pager a, .asef-pager span {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 40px; height: 40px; padding: 0 12px; border-radius: 10px;
        font-size: 14px; font-weight: 500; text-decoration: none;
        border: 1px solid var(--outline); background: white; color: var(--on-surface);
        transition: background .15s, border-color .15s;
    }
    .asef-pager a:hover { border-color: var(--primary); }
    .asef-pager .active, .asef-pager span[aria-current] {
        background: var(--primary); color: white; border-color: var(--primary);
    }
    .asef-pager .disabled { opacity: .4; pointer-events: none; }

    /* Chip mobile safe */
    @media (max-width: 640px) {
        .asef-chips-scroll { padding: 0 16px; }
    }
</style>
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        {{ $queryText ? '"' . e($queryText) . '" için sonuçlar' : ($activeAltName ?: $activeAnaName ?: 'Ürünler') }} — Asef Sondaj
    </x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO / SEARCH --}}
            <section class="asef-search-hero">
                <div class="asef-label-caps">KATALOG · {{ AsefProduct::where('is_active', true)->count() }} EKİPMAN</div>
                <h1>{{ $queryText ? '"' . e($queryText) . '" için sonuçlar' : ($activeAltName ?: $activeAnaName ?: 'Ürünleri keşfet.') }}</h1>
                <p>Sondaj sahasına hazır ekipmanları filtreleyerek gezinin. Teklif için WhatsApp'tan yazın.</p>
                <form action="{{ route('shop.search.index') }}" class="asef-search-form" method="get" role="search">
                    @if ($anaCode)<input type="hidden" name="ana" value="{{ e($anaCode) }}" />@endif
                    @if ($altCode)<input type="hidden" name="alt" value="{{ e($altCode) }}" />@endif
                    <input
                        type="text"
                        name="query"
                        class="asef-search-input"
                        placeholder="Ürün adı veya stok kodu ara (örn: AS-EMB, portkron, DTH)"
                        value="{{ e($queryText) }}"
                        autocomplete="off"
                    />
                    <button type="submit" class="asef-search-btn" aria-label="Ara">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    </button>
                </form>
            </section>

            {{-- MAIN CATEGORY CHIPS (15 ana + Tümü) --}}
            <div class="asef-chips-scroll">
                @php
                    $tumUrl = $queryText ? route('shop.search.index') . '?' . http_build_query(['query' => $queryText]) : route('shop.search.index');
                @endphp
                <a href="{{ $tumUrl }}" class="asef-chip {{ ! $anaCode ? 'active' : '' }}">Tümü</a>
                @foreach ($anaKategoriler as $ana)
                    @php
                        $qs = ['ana' => $ana->code];
                        if ($queryText) $qs['query'] = $queryText;
                        $chipUrl = route('shop.search.index') . '?' . http_build_query($qs);
                        $isActive = $anaCode === $ana->code;
                    @endphp
                    <a href="{{ $chipUrl }}" class="asef-chip {{ $isActive ? 'active' : '' }}">{{ $ana->name }}</a>
                @endforeach
            </div>

            {{-- SUB CATEGORY CHIPS (aktif ana için alt kategoriler) --}}
            @if ($altKategoriler->count() > 0)
                <div class="asef-chips-alt">
                    @php
                        $allAltUrl = route('shop.search.index') . '?' . http_build_query(array_filter([
                            'ana' => $anaCode, 'query' => $queryText,
                        ]));
                    @endphp
                    <a href="{{ $allAltUrl }}" class="asef-chip {{ ! $altCode ? 'active' : '' }}">Tümü</a>
                    @foreach ($altKategoriler as $alt)
                        @php
                            $qs = ['ana' => $anaCode, 'alt' => $alt->code];
                            if ($queryText) $qs['query'] = $queryText;
                            $chipUrl = route('shop.search.index') . '?' . http_build_query($qs);
                            $isActive = $altCode === $alt->code;
                        @endphp
                        <a href="{{ $chipUrl }}" class="asef-chip {{ $isActive ? 'active' : '' }}">{{ $alt->name }}</a>
                    @endforeach
                </div>
            @endif

            {{-- RESULT COUNT --}}
            <div class="asef-search-count">
                <div>{{ $totalCount }} ürün</div>
                @if ($anaCode || $altCode || $queryText)
                    <a href="{{ route('shop.search.index') }}" class="asef-section-link" style="display: inline-flex;">Filtreleri temizle</a>
                @endif
            </div>

            {{-- GRID --}}
            @if ($products->count() > 0)
                <div class="asef-search-grid">
                    @foreach ($products as $product)
                        @php
                            $catLabel = optional($product->altKategori)->name ?: optional($product->anaKategori)->name ?: '';
                            $imgSrc   = $imgUrl($product);
                            $shortDesc = $product->description
                                ?: (($product->attrs['ebat_sistem'] ?? '') . ($product->attrs['boy_uzunluk'] ? ' · ' . $product->attrs['boy_uzunluk'] : ''));
                            $detailUrl = route('shop.asef.product', ['sku' => $product->sku]);
                        @endphp
                        <div class="asef-search-card">
                            <a href="{{ $detailUrl }}" class="asef-search-media" aria-label="{{ $product->name }} detay" style="display:block;">
                                <img src="{{ $imgSrc }}" alt="{{ $product->name }}" loading="lazy" />
                                <span class="asef-search-sku">{{ $product->sku }}</span>
                            </a>
                            <a href="{{ $detailUrl }}" class="asef-search-body" style="color:inherit;">
                                <div class="asef-search-cat">{{ $catLabel }}</div>
                                <div class="asef-search-name">{{ $product->name }}</div>
                                <div class="asef-search-desc">{{ $shortDesc ?: 'Sondaj ekipmanı — teknik detay için tıkla.' }}</div>
                            </a>
                            <div class="asef-search-foot">
                                <button type="button"
                                        class="asef-search-add"
                                        data-asef-add-to-cart
                                        data-sku="{{ $product->sku }}"
                                        data-name="{{ $product->name }}"
                                        data-img="{{ $imgSrc }}"
                                        data-cat="{{ $catLabel }}"
                                        aria-label="{{ $product->name }} sepete ekle">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    Sepete Ekle
                                </button>
                                <a href="{{ $detailUrl }}" class="asef-search-detail" aria-label="{{ $product->name }} detay">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                @if ($products->hasPages())
                    <div class="asef-pager">
                        @if ($products->onFirstPage())
                            <span class="disabled">‹</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" rel="prev">‹</a>
                        @endif

                        @php
                            $current = $products->currentPage(); $last = $products->lastPage();
                            $window = 2;
                            $pages = collect(range(max(1, $current - $window), min($last, $current + $window)));
                            if ($pages->first() > 1) { $pages->prepend(1); if ($pages[1] > 2) $pages->splice(1, 0, '…'); }
                            if ($pages->last() < $last) { if ($pages->last() < $last - 1) $pages->push('…'); $pages->push($last); }
                        @endphp
                        @foreach ($pages as $p)
                            @if ($p === '…')
                                <span class="disabled">…</span>
                            @elseif ($p == $current)
                                <span class="active" aria-current="page">{{ $p }}</span>
                            @else
                                <a href="{{ $products->url($p) }}">{{ $p }}</a>
                            @endif
                        @endforeach

                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" rel="next">›</a>
                        @else
                            <span class="disabled">›</span>
                        @endif
                    </div>
                @endif
            @else
                <div class="asef-search-empty">
                    <h3>Sonuç bulunamadı.</h3>
                    <p>Farklı bir arama veya kategori seçin, ya da WhatsApp'tan bize ulaşın.</p>
                    <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('shop.search.index') }}" class="asef-cta-pill primary">Tüm ürünlere dön</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">WhatsApp'tan yaz <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            @endif

            {{-- CTA BAND --}}
            <section class="asef-section" style="margin-top: 80px;">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">TEKNİK DESTEK</div>
                    <h2>Doğru ekipmanı birlikte seçelim.</h2>
                    <p>Delik çapı, formasyon ve basınç bilgilerinizi paylaşın; teknik ekibimiz size en uygun çözümü önerir.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>

        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
