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
    /* Chip rows — flex layout: [◀] [scroll] [▶] */
    .asef-chips-scroll-wrap {
        max-width: 1024px; margin: 0 auto 12px; padding: 0 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .asef-chips-scroll, .asef-chips-alt {
        flex: 1; min-width: 0;
        padding: 4px 4px;
        display: flex; gap: 10px; overflow-x: auto; scroll-snap-type: x proximity;
        -webkit-overflow-scrolling: touch;
        scroll-behavior: smooth;
    }
    .asef-chips-scroll::-webkit-scrollbar, .asef-chips-alt::-webkit-scrollbar { height: 0; }
    .asef-chips-scroll, .asef-chips-alt { scrollbar-width: none; }
    .asef-chips-scroll .asef-chip, .asef-chips-alt .asef-chip { scroll-snap-align: start; flex-shrink: 0; }

    /* Arrow buttons — chip'lerin YANINDA, üstüne binmez */
    .asef-scroll-arrow {
        flex-shrink: 0;
        width: 36px; height: 36px; border-radius: 50%;
        background: #FFFFFF; border: 1.5px solid var(--primary);
        color: var(--primary); cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: background .15s, color .15s, transform .15s, opacity .2s;
    }
    .asef-scroll-arrow:hover:not(:disabled) { background: var(--primary); color: #FFFFFF; transform: scale(1.08); }
    .asef-scroll-arrow:disabled { opacity: 0.3; cursor: not-allowed; }
    .asef-scroll-arrow svg { width: 16px; height: 16px; }
    .asef-chips-alt {
        max-width: 1024px; margin: 0 auto 24px; padding: 0 20px;
        display: flex; gap: 8px; overflow-x: auto; flex-wrap: nowrap;
        -webkit-overflow-scrolling: touch;
    }
    .asef-chips-alt::-webkit-scrollbar { height: 0; }
    /* Alt kategori chip'i ana ile aynı yükseklik (hizalama tutarlı) */
    .asef-chips-alt .asef-chip {
        scroll-snap-align: start; flex-shrink: 0;
    }
    .asef-chips-alt .asef-chip:hover:not(.active) {
        background: #F5F5F7;
        border-color: var(--primary);
        color: var(--primary);
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

    /* "Tüm Kategoriler" chip'i özel — CTA vurgu */
    .asef-chip-panel {
        display: inline-flex; align-items: center; gap: 6px;
        border: 1.5px solid var(--primary) !important;
        background: white !important;
        color: var(--primary) !important;
        font-weight: 600 !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08), 0 1px 0 rgba(255,255,255,0.9) inset !important;
        cursor: pointer;
        transition: transform .2s, box-shadow .2s, background .2s !important;
    }
    .asef-chip-panel:hover {
        transform: translateY(-1px);
        background: var(--primary) !important;
        color: white !important;
        box-shadow: 0 8px 20px rgba(0,0,0,0.16) !important;
    }
    .asef-chip-panel svg { flex-shrink: 0; }

    /* === TÜM KATEGORİLER PANEL === */
    .asef-cat-panel {
        position: fixed; inset: 0; z-index: 10000;
        background: rgba(15,17,20,0.5); backdrop-filter: blur(8px);
        display: none; align-items: flex-end; justify-content: center;
    }
    @media (min-width: 768px) {
        .asef-cat-panel { align-items: center; }
    }
    .asef-cat-panel.on { display: flex; animation: catFade .2s ease-out; }
    @keyframes catFade { from { opacity: 0; } to { opacity: 1; } }
    .asef-cat-panel-inner {
        background: white; width: 100%; max-width: 900px; max-height: 88vh;
        border-radius: 24px 24px 0 0;
        display: flex; flex-direction: column;
        animation: catSlide .3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 -20px 60px rgba(0,0,0,0.3);
    }
    @media (min-width: 768px) {
        .asef-cat-panel-inner { border-radius: 24px; max-height: 82vh; }
    }
    @keyframes catSlide { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    .asef-cat-panel-head {
        display: flex; justify-content: space-between; align-items: center;
        padding: 22px 28px; border-bottom: 1px solid var(--outline); flex-shrink: 0;
    }
    .asef-cat-panel-head h3 { font-size: 20px; font-weight: 600; color: var(--primary); }
    .asef-cat-panel-close {
        width: 36px; height: 36px; border-radius: 50%;
        background: var(--surface-alt); border: 0;
        display: inline-flex; align-items: center; justify-content: center;
        color: var(--on-surface); cursor: pointer; transition: background .15s;
    }
    .asef-cat-panel-close:hover { background: #EEEEF0; }
    .asef-cat-panel-close svg { width: 18px; height: 18px; }
    .asef-cat-panel-body {
        padding: 20px 28px 32px; overflow-y: auto;
        display: flex; flex-direction: column; gap: 18px;
    }
    .asef-cat-panel-all {
        display: flex; align-items: center; gap: 14px;
        padding: 18px 20px; border-radius: 16px;
        background: var(--primary); color: #ffffff !important;
        transition: transform .2s, box-shadow .2s;
        text-decoration: none;
        box-shadow: 0 8px 24px rgba(0,0,0,0.14);
    }
    .asef-cat-panel-all:hover { transform: translateY(-2px); box-shadow: 0 14px 30px rgba(0,0,0,0.24); }
    .asef-cat-panel-all-icon {
        width: 42px; height: 42px; border-radius: 12px;
        background: rgba(255,255,255,0.12); backdrop-filter: blur(6px);
        display: inline-flex; align-items: center; justify-content: center;
        color: #ffffff; flex-shrink: 0;
    }
    .asef-cat-panel-all-icon svg { width: 20px; height: 20px; }
    .asef-cat-panel-all-title { font-size: 16px; font-weight: 600; color: #ffffff; letter-spacing: -0.01em; }
    .asef-cat-panel-all-sub   { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 2px; }
    .asef-cat-panel-group { border-top: 1px solid var(--outline); padding-top: 16px; }
    .asef-cat-panel-group:first-of-type { border-top: 0; padding-top: 0; }
    .asef-cat-panel-ana {
        display: flex; justify-content: space-between; align-items: center;
        font-size: 15px; font-weight: 600; color: var(--primary);
        padding: 8px 4px; margin-bottom: 8px;
        border-radius: 8px; transition: background .15s;
    }
    .asef-cat-panel-ana:hover { background: var(--surface-alt); }
    .asef-cat-panel-alts {
        display: grid; grid-template-columns: 1fr; gap: 4px;
        padding-left: 12px;
    }
    @media (min-width: 640px) { .asef-cat-panel-alts { grid-template-columns: 1fr 1fr; } }
    @media (min-width: 900px) { .asef-cat-panel-alts { grid-template-columns: 1fr 1fr 1fr; } }
    .asef-cat-panel-alt {
        display: flex; justify-content: space-between; align-items: center;
        padding: 8px 12px; font-size: 13px; color: var(--secondary);
        border-radius: 6px; transition: background .15s, color .15s;
    }
    .asef-cat-panel-alt:hover { background: var(--surface-alt); color: var(--primary); }
    .asef-cat-panel-count {
        font-size: 11px; color: var(--gray-secondary);
        background: var(--surface-alt); padding: 2px 8px; border-radius: 999px;
        font-family: "SF Mono", ui-monospace, Menlo, monospace;
    }
    .asef-cat-panel-ana .asef-cat-panel-count { background: white; border: 1px solid var(--outline); }
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
                <form action="{{ route('shop.search.index') }}" class="asef-search-form" method="get" role="search" onsubmit="return asefSearchSubmit(this);">
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
                <script>
                    // Bagisto native search controller boş query varsa ana sayfaya yönlendiriyor.
                    // Boş query submit'te query alanını URL'den çıkararak sadece diğer filtre'leri gönderiyoruz.
                    function asefSearchSubmit(form) {
                        var q = form.querySelector('input[name="query"]');
                        if (q && q.value.trim() === '') {
                            q.disabled = true;  // form submit'te name gitmez
                            setTimeout(function () { q.disabled = false; }, 300);
                        }
                        return true;
                    }
                </script>
            </section>

            {{-- MAIN CATEGORY CHIPS (15 ana + Tümü) --}}
            <div class="asef-chips-scroll-wrap">
            <button type="button" class="asef-scroll-arrow left" data-scroll-arrow="left" aria-label="Sola kaydır">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="asef-chips-scroll" data-asef-scroll>
                {{-- "Tümü" temizler HER şeyi (query + ana + alt) — direct /search --}}
                <button type="button" class="asef-chip asef-chip-panel" data-open-cat-panel aria-label="Tüm kategoriler paneli">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    Tüm Kategoriler
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" style="opacity: .7;"><polyline points="6 9 12 15 18 9"/></svg>
                </button>
                <a href="{{ route('shop.search.index') }}" class="asef-chip {{ ! $anaCode && ! $queryText ? 'active' : '' }}">Tümü</a>
                @foreach ($anaKategoriler as $ana)
                    @php
                        // Ana chip tıklaması: query'yi KORU (arama içi kategori refine)
                        $qs = ['ana' => $ana->code];
                        if ($queryText) $qs['query'] = $queryText;
                        $chipUrl = route('shop.search.index') . '?' . http_build_query($qs);
                        $isActive = $anaCode === $ana->code;
                    @endphp
                    <a href="{{ $chipUrl }}" class="asef-chip {{ $isActive ? 'active' : '' }}">{{ $ana->name }}</a>
                @endforeach
            </div>
            <button type="button" class="asef-scroll-arrow right" data-scroll-arrow="right" aria-label="Sağa kaydır">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>
            </button>
            </div>{{-- /asef-chips-scroll-wrap --}}

            {{-- SUB CATEGORY CHIPS (aktif ana için alt kategoriler) --}}
            @if ($altKategoriler->count() > 0)
                <div class="asef-chips-scroll-wrap">
                <button type="button" class="asef-scroll-arrow left" data-scroll-arrow="left" aria-label="Sola kaydır">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="asef-chips-alt" data-asef-scroll>
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
                <button type="button" class="asef-scroll-arrow right" data-scroll-arrow="right" aria-label="Sağa kaydır">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>
                </button>
                </div>{{-- /wrap --}}
            @endif
            <script>
            (function () {
                function bindScrollControls() {
                    document.querySelectorAll('.asef-chips-scroll-wrap').forEach(function (wrap) {
                        var scroller = wrap.querySelector('[data-asef-scroll]');
                        if (!scroller || scroller._asefBound) return;
                        scroller._asefBound = true;
                        var leftBtn  = wrap.querySelector('.asef-scroll-arrow.left');
                        var rightBtn = wrap.querySelector('.asef-scroll-arrow.right');

                        function updateArrows() {
                            var canScroll = scroller.scrollWidth > scroller.clientWidth + 4;
                            var atStart   = scroller.scrollLeft <= 2;
                            var atEnd     = scroller.scrollLeft + scroller.clientWidth >= scroller.scrollWidth - 2;
                            if (leftBtn)  leftBtn.disabled  = !canScroll || atStart;
                            if (rightBtn) rightBtn.disabled = !canScroll || atEnd;
                        }
                        // Wheel: dikey → yatay
                        scroller.addEventListener('wheel', function (e) {
                            if (e.deltaY === 0) return;
                            if (scroller.scrollWidth <= scroller.clientWidth) return;
                            e.preventDefault();
                            scroller.scrollLeft += e.deltaY;
                        }, { passive: false });
                        // Arrow buttons
                        if (leftBtn)  leftBtn.addEventListener('click',  function () { scroller.scrollBy({ left: -260, behavior: 'smooth' }); });
                        if (rightBtn) rightBtn.addEventListener('click', function () { scroller.scrollBy({ left:  260, behavior: 'smooth' }); });
                        // Update arrows on scroll + resize
                        scroller.addEventListener('scroll', updateArrows, { passive: true });
                        window.addEventListener('resize', updateArrows);
                        setTimeout(updateArrows, 100);
                        setTimeout(updateArrows, 600);
                    });
                }
                if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', bindScrollControls); }
                else { bindScrollControls(); }
                setTimeout(bindScrollControls, 500);
            })();
            </script>

            {{-- === TÜM KATEGORİLER PANEL (modal / bottom-sheet) === --}}
            <div class="asef-cat-panel" id="asefCatPanel" role="dialog" aria-modal="true" aria-label="Tüm kategoriler">
                <div class="asef-cat-panel-inner">
                    <div class="asef-cat-panel-head">
                        <h3>Tüm Kategoriler</h3>
                        <button type="button" class="asef-cat-panel-close" data-close-cat-panel aria-label="Kapat">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
                        </button>
                    </div>
                    <div class="asef-cat-panel-body">
                        <a href="{{ route('shop.search.index') }}" class="asef-cat-panel-all">
                            <span class="asef-cat-panel-all-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                            </span>
                            <div style="flex: 1;">
                                <div class="asef-cat-panel-all-title">Tüm Ürünler</div>
                                <div class="asef-cat-panel-all-sub">{{ \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('is_active',true)->count() }} ürün · tümünü göz at</div>
                            </div>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="opacity: 0.9;"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        @php
                            $panelAna = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::with(['altKategoriler' => function ($q) {
                                $q->orderBy('sort');
                            }])->orderBy('sort')->get();
                        @endphp
                        @foreach ($panelAna as $pa)
                            <div class="asef-cat-panel-group">
                                <a href="{{ route('shop.search.index') . '?ana=' . $pa->code }}" class="asef-cat-panel-ana">
                                    {{ $pa->name }}
                                    <span class="asef-cat-panel-count">{{ $pa->products()->where('is_active',true)->count() }}</span>
                                </a>
                                @if ($pa->altKategoriler->count() > 0)
                                    <div class="asef-cat-panel-alts">
                                        @foreach ($pa->altKategoriler as $pal)
                                            <a href="{{ route('shop.search.index') . '?ana=' . $pa->code . '&alt=' . $pal->code }}" class="asef-cat-panel-alt">
                                                {{ $pal->name }}
                                                <span class="asef-cat-panel-count">{{ $pal->products()->where('is_active',true)->count() }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <script>
            (function () {
                function bind() {
                    var panel = document.getElementById('asefCatPanel');
                    if (!panel) { console.warn('[asef] cat-panel not found'); return; }
                    function open()  { panel.classList.add('on');    document.documentElement.style.overflow = 'hidden'; document.body.style.overflow = 'hidden'; }
                    function close() { panel.classList.remove('on'); document.documentElement.style.overflow = '';       document.body.style.overflow = ''; }

                    // Direct binding to the open button — no delegation surprises with Vue
                    document.querySelectorAll('[data-open-cat-panel]').forEach(function (btn) {
                        btn.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); open(); });
                    });
                    // Close via X button, backdrop click, and ESC
                    var closeBtn = panel.querySelector('[data-close-cat-panel]');
                    if (closeBtn) closeBtn.addEventListener('click', function (e) { e.preventDefault(); close(); });
                    panel.addEventListener('click', function (e) { if (e.target === panel) close(); });
                    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && panel.classList.contains('on')) close(); });
                }
                if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', bind); }
                else { bind(); }
                // Belt & braces: rebind after 500ms in case Vue re-renders
                setTimeout(bind, 500);
            })();
            </script>

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
