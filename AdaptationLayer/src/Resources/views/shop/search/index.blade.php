{{-- ============================================================
     Asef Sondaj — Ürünler / Arama Sayfası (Adaptation Layer)
     Design v5 uses shared partials for styles/nav/footer.
     Products hardcoded (mobile app catalog) until Bagisto backend
     is wired up (Faz 2).
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Hardcoded catalog — mirrors eticaretapp/lib/features/asef/data/asef_catalog.dart
    $products = [
        ['sku' => 'AS-DTH-040', 'name' => 'DTH Çekiç 4 İnç',              'cat' => 'delici',       'catLabel' => 'Delici Ekipmanlar', 'desc' => 'Yüksek darbe enerjili profesyonel kuyu delme çekici.', 'img' => 'dth-hammer.jpg'],
        ['sku' => 'AS-BIT-152', 'name' => 'DTH Button Bit 6 İnç',          'cat' => 'delici',       'catLabel' => 'Delici Ekipmanlar', 'desc' => 'Sert formasyonlar için karbür butonlu delici matkap.',   'img' => 'asef-diamond-bit.jpg'],
        ['sku' => 'AS-TRI-215', 'name' => 'Tricone Matkap 8 1/2 İnç',      'cat' => 'delici',       'catLabel' => 'Delici Ekipmanlar', 'desc' => 'Rulmanlı üç konili döner matkap; büyük çaplı deliler için.', 'img' => 'asef-macro-diamond.jpg'],
        ['sku' => 'AS-ROD-300', 'name' => 'Sondaj Tiji 3 Metre',           'cat' => 'tij',          'catLabel' => 'Tij ve Borular',    'desc' => 'Yüksek tork aktarımı için hassas dişli sondaj tiji.',     'img' => 'drill-rods.jpg'],
        ['sku' => 'AS-CAS-168', 'name' => 'Muhafaza Borusu 6 5/8 İnç',     'cat' => 'tij',          'catLabel' => 'Tij ve Borular',    'desc' => 'Kuyu duvarını sabitleyen dayanıklı çelik muhafaza borusu.', 'img' => 'asef-macro-thread.jpg'],
        ['sku' => 'AS-PMP-600', 'name' => 'Triplex Çamur Pompası',         'cat' => 'pompa',        'catLabel' => 'Pompa Sistemleri',  'desc' => 'Sondaj devri için yüksek basınçlı çamur pompası.',        'img' => 'mud-pump.jpg'],
        ['sku' => 'AS-SWI-250', 'name' => 'Yüksek Basınçlı Döner Başlık',  'cat' => 'pompa',        'catLabel' => 'Pompa Sistemleri',  'desc' => 'Kesintisiz akışkan aktarımı sağlayan ağır hizmet döner başlık.', 'img' => 'asef-macro-valve.jpg'],
        ['sku' => 'AS-SRV-001', 'name' => 'DTH Bakım ve Sızdırmazlık Seti', 'cat' => 'yedek-parca', 'catLabel' => 'Yedek Parça',       'desc' => 'DTH çekiç bakımı için tam sızdırmazlık ve conta seti.',    'img' => 'asef-spare-parts.jpg'],
    ];

    $categories = [
        ['slug' => null,           'label' => 'Tümü'],
        ['slug' => 'delici',       'label' => 'Delici Ekipmanlar'],
        ['slug' => 'tij',          'label' => 'Tij ve Borular'],
        ['slug' => 'pompa',        'label' => 'Pompa Sistemleri'],
        ['slug' => 'karot',        'label' => 'Karot Ürünleri'],
        ['slug' => 'yedek-parca',  'label' => 'Yedek Parça'],
    ];

    $activeCat   = request()->query('cat');
    $queryText   = trim((string) request()->query('query', ''));

    $filtered = collect($products)
        ->when($activeCat, fn ($c) => $c->where('cat', $activeCat))
        ->when($queryText, function ($c) use ($queryText) {
            $needle = mb_strtolower($queryText);
            return $c->filter(fn ($p) =>
                str_contains(mb_strtolower($p['name']), $needle) ||
                str_contains(mb_strtolower($p['sku']), $needle) ||
                str_contains(mb_strtolower($p['desc']), $needle)
            );
        })
        ->values();
@endphp

@push('meta')
    <meta name="title" content="Ürünler — Asef Sondaj" />
    <meta name="description" content="Sondaj ekipmanları katalogumuzda delici, tij, pompa ve karot ürünlerini keşfedin. Teklif için WhatsApp'tan yazın." />
    <meta name="theme-color" content="#ffffff" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        {{ $queryText ? '"' . e($queryText) . '" için sonuçlar' : 'Ürünler' }} — Asef Sondaj
    </x-slot>

    <div class="asef-root">

        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO / SEARCH --}}
            <section class="asef-search-hero">
                <div class="asef-label-caps">KATALOG · {{ count($products) }} EKİPMAN</div>
                <h1>{{ $queryText ? '"' . e($queryText) . '" için sonuçlar' : 'Ürünleri keşfet.' }}</h1>
                <p>Sondaj sahasına hazır ekipmanları filtreleyerek gezinin. Fiyat bilgisi için teklif oluşturun.</p>
                <form action="{{ route('shop.search.index') }}" class="asef-search-form" method="get" role="search">
                    @if ($activeCat)
                        <input type="hidden" name="cat" value="{{ e($activeCat) }}" />
                    @endif
                    <input
                        type="text"
                        name="query"
                        class="asef-search-input"
                        placeholder="Ürün adı veya stok kodu ara"
                        value="{{ e($queryText) }}"
                        autocomplete="off"
                    />
                    <button type="submit" class="asef-search-btn" aria-label="Ara">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    </button>
                </form>
            </section>

            {{-- CATEGORY CHIPS --}}
            <div class="asef-chips-row">
                @foreach ($categories as $cat)
                    @php
                        $isActive = ($activeCat === $cat['slug']) || (empty($activeCat) && $cat['slug'] === null);
                        $chipQs = [];
                        if ($cat['slug']) { $chipQs['cat'] = $cat['slug']; }
                        if ($queryText) { $chipQs['query'] = $queryText; }
                        $chipUrl = $chipQs ? route('shop.search.index') . '?' . http_build_query($chipQs) : route('shop.search.index');
                    @endphp
                    <a href="{{ $chipUrl }}" class="asef-chip {{ $isActive ? 'active' : '' }}">
                        {{ $cat['label'] }}
                    </a>
                @endforeach
            </div>

            {{-- RESULT COUNT --}}
            <div class="asef-search-count">
                <div>{{ $filtered->count() }} ürün gösteriliyor</div>
                @if ($activeCat || $queryText)
                    <a href="{{ route('shop.search.index') }}" class="asef-section-link" style="display: inline-flex;">Filtreleri temizle</a>
                @endif
            </div>

            {{-- GRID --}}
            @if ($filtered->count() > 0)
                <div class="asef-search-grid">
                    @foreach ($filtered as $product)
                        <div class="asef-search-card">
                            <a href="{{ route('shop.asef.product', ['sku' => $product['sku']]) }}" class="asef-search-media" aria-label="{{ $product['name'] }} detay" style="display:block;">
                                <img
                                    src="{{ $asefUrl($product['img']) }}"
                                    alt="{{ $product['name'] }}"
                                    loading="lazy"
                                />
                                <span class="asef-search-sku">{{ $product['sku'] }}</span>
                            </a>
                            <a href="{{ route('shop.asef.product', ['sku' => $product['sku']]) }}" class="asef-search-body" style="color:inherit;">
                                <div class="asef-search-cat">{{ $product['catLabel'] }}</div>
                                <div class="asef-search-name">{{ $product['name'] }}</div>
                                <div class="asef-search-desc">{{ $product['desc'] }}</div>
                            </a>
                            <div class="asef-search-foot">
                                <button type="button"
                                        class="asef-search-add"
                                        data-asef-add-to-cart
                                        data-sku="{{ $product['sku'] }}"
                                        data-name="{{ $product['name'] }}"
                                        data-img="{{ $asefUrl($product['img']) }}"
                                        data-cat="{{ $product['catLabel'] }}"
                                        aria-label="{{ $product['name'] }} sepete ekle">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    Sepete Ekle
                                </button>
                                <a href="{{ route('shop.asef.product', ['sku' => $product['sku']]) }}" class="asef-search-detail" aria-label="{{ $product['name'] }} detay">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
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
