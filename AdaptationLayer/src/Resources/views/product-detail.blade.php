{{-- ============================================================
     Asef Sondaj — Ürün Detay Sayfası (v5)
     Route: /urun/{sku}
     Hardcoded catalog until Bagisto backend wired (Faz 2).
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Master catalog — kaynak: mobile app + ana sayfa.
    $catalog = [
        'AS-DTH-040' => [
            'sku' => 'AS-DTH-040',
            'name' => 'DTH Çekiç 4 İnç',
            'cat' => 'delici', 'catLabel' => 'Delici Ekipmanlar',
            'desc' => 'Yüksek darbe enerjili profesyonel kuyu delme çekici. Sert formasyonlarda yüksek verimlilik ve uzun ömür sağlar.',
            'img'  => 'dth-hammer.jpg',
            'usecases' => ['Kuyu delme', 'Su sondajı', 'Maden sondajı'],
            'specs' => [
                ['label' => 'Delme çapı',    'value' => '105 – 130 mm'],
                ['label' => 'Bağlantı',      'value' => 'DTH-4 standart'],
                ['label' => 'Ağırlık',       'value' => '38 kg'],
                ['label' => 'Çalışma basıncı','value' => '10 – 25 bar'],
            ],
        ],
        'AS-BIT-152' => [
            'sku' => 'AS-BIT-152',
            'name' => 'DTH Button Bit 6 İnç',
            'cat' => 'delici', 'catLabel' => 'Delici Ekipmanlar',
            'desc' => 'Sert formasyonlar için karbür butonlu delici matkap. Aşırı aşındırıcı zeminlerde bile kesme performansı korur.',
            'img'  => 'asef-diamond-bit.jpg',
            'usecases' => ['Sert formasyon', 'Kuyu delme', 'Yeraltı su sondajı'],
            'specs' => [
                ['label' => 'Çap',            'value' => '152 mm (6 inç)'],
                ['label' => 'Buton sayısı',   'value' => '12 karbür'],
                ['label' => 'Bağlantı',       'value' => 'DHD-360 standart'],
                ['label' => 'Malzeme',        'value' => 'Tungsten karbür'],
            ],
        ],
        'AS-TRI-215' => [
            'sku' => 'AS-TRI-215',
            'name' => 'Tricone Matkap 8 1/2 İnç',
            'cat' => 'delici', 'catLabel' => 'Delici Ekipmanlar',
            'desc' => 'Rulmanlı üç konili döner matkap; büyük çaplı delme operasyonlarında yüksek dönüş verimi sunar.',
            'img'  => 'asef-macro-diamond.jpg',
            'usecases' => ['Rotary sondaj', 'Büyük çaplı delme'],
            'specs' => [
                ['label' => 'Çap',           'value' => '215 mm (8 1/2 inç)'],
                ['label' => 'Konfigürasyon', 'value' => 'IADC 517'],
                ['label' => 'Bağlantı',      'value' => 'API 6 5/8 REG'],
                ['label' => 'Malzeme',       'value' => 'Karbür + rulmanlı'],
            ],
        ],
        'AS-ROD-300' => [
            'sku' => 'AS-ROD-300',
            'name' => 'Sondaj Tiji 3 Metre',
            'cat' => 'tij', 'catLabel' => 'Tij ve Borular',
            'desc' => 'Yüksek tork aktarımı için hassas dişli sondaj tiji. Ekleme sistemi ile uzun kuyu operasyonlarında güvenle kullanılır.',
            'img'  => 'drill-rods.jpg',
            'usecases' => ['Kuyu delme', 'Zemin sondajı', 'Su sondajı'],
            'specs' => [
                ['label' => 'Boy',      'value' => '3.000 mm'],
                ['label' => 'Çap',      'value' => '76 mm'],
                ['label' => 'Bağlantı', 'value' => 'API IF standart'],
                ['label' => 'Malzeme',  'value' => 'AISI 4145H'],
            ],
        ],
        'AS-CAS-168' => [
            'sku' => 'AS-CAS-168',
            'name' => 'Muhafaza Borusu 6 5/8 İnç',
            'cat' => 'tij', 'catLabel' => 'Tij ve Borular',
            'desc' => 'Kuyu duvarını sabitleyen dayanıklı çelik muhafaza borusu. Deformasyona karşı yüksek dirençlidir.',
            'img'  => 'asef-macro-thread.jpg',
            'usecases' => ['Kuyu koruma', 'Su sondajı'],
            'specs' => [
                ['label' => 'Çap',       'value' => '168 mm (6 5/8 inç)'],
                ['label' => 'Cidar',     'value' => '7.32 mm'],
                ['label' => 'Boy',       'value' => '6.000 mm'],
                ['label' => 'Malzeme',   'value' => 'API 5CT J55'],
            ],
        ],
        'AS-PMP-600' => [
            'sku' => 'AS-PMP-600',
            'name' => 'Triplex Çamur Pompası',
            'cat' => 'pompa', 'catLabel' => 'Pompa Sistemleri',
            'desc' => 'Sondaj devri için yüksek basınçlı üç pistonlu çamur pompası. Sürekli çalışmada kararlı basınç sağlar.',
            'img'  => 'mud-pump.jpg',
            'usecases' => ['Rotary sondaj', 'Çamur devri', 'Kuyu temizliği'],
            'specs' => [
                ['label' => 'Debi',           'value' => '600 L/dk'],
                ['label' => 'Basınç',         'value' => '50 bar max'],
                ['label' => 'Piston sayısı',  'value' => '3 (Triplex)'],
                ['label' => 'Motor',          'value' => 'Elektrik / Dizel'],
            ],
        ],
        'AS-SWI-250' => [
            'sku' => 'AS-SWI-250',
            'name' => 'Yüksek Basınçlı Döner Başlık',
            'cat' => 'pompa', 'catLabel' => 'Pompa Sistemleri',
            'desc' => 'Sondaj dizisi dönerken akışkan aktarımını kesintisiz sürdüren, değiştirilebilir conta grubuna sahip ağır hizmet döner başlık.',
            'img'  => 'asef-macro-valve.jpg',
            'usecases' => ['Rotary sondaj', 'Su enjeksiyonu', 'Hava aktarımı'],
            'specs' => [
                ['label' => 'Çalışma basıncı', 'value' => '250 bar'],
                ['label' => 'Bağlantı',        'value' => 'API seçenekli'],
                ['label' => 'Gövde',           'value' => 'Çelik'],
                ['label' => 'Conta',           'value' => 'Değiştirilebilir kartuş'],
            ],
        ],
        'AS-SRV-001' => [
            'sku' => 'AS-SRV-001',
            'name' => 'DTH Bakım ve Sızdırmazlık Seti',
            'cat' => 'yedek-parca', 'catLabel' => 'Yedek Parça',
            'desc' => 'DTH çekiç bakımı için tam sızdırmazlık ve conta seti. Uzun servis ömrü için tavsiye edilen orijinal parça seti.',
            'img'  => 'asef-spare-parts.jpg',
            'usecases' => ['Periyodik bakım', 'DTH servis'],
            'specs' => [
                ['label' => 'Uyumluluk',   'value' => 'AS-DTH-040'],
                ['label' => 'İçerik',      'value' => 'O-ring · Piston contaları · Yağ keçesi'],
                ['label' => 'Adet',        'value' => '1 komple set'],
                ['label' => 'Menşei',      'value' => 'Orijinal'],
            ],
        ],
    ];

    $sku = strtoupper($sku ?? '');
    $product = $catalog[$sku] ?? null;

    if (! $product) {
        abort(404);
    }

    // Related — same category, excluding self, max 3
    $related = collect($catalog)
        ->filter(fn ($p) => $p['cat'] === $product['cat'] && $p['sku'] !== $product['sku'])
        ->take(3)
        ->values();

    // If less than 3 related, top up from other categories
    if ($related->count() < 3) {
        $extra = collect($catalog)
            ->filter(fn ($p) => $p['cat'] !== $product['cat'] && $p['sku'] !== $product['sku'])
            ->take(3 - $related->count())
            ->values();
        $related = $related->concat($extra);
    }
@endphp

@push('meta')
    <meta name="title" content="{{ $product['name'] }} — Asef Sondaj" />
    <meta name="description" content="{{ $product['desc'] }}" />
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
        {{ $product['name'] }} — Asef Sondaj
    </x-slot>

    <div class="asef-root">

        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- BREADCRUMB --}}
            <div class="asef-pd-wrap" style="padding-bottom: 0;">
                <nav class="asef-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ url('/') }}">Ana Sayfa</a>
                    <span class="sep">/</span>
                    <a href="{{ route('shop.search.index', ['cat' => $product['cat']]) }}">{{ $product['catLabel'] }}</a>
                    <span class="sep">/</span>
                    <span class="current">{{ $product['name'] }}</span>
                </nav>
            </div>

            {{-- PRODUCT MAIN --}}
            <section class="asef-pd-wrap" style="padding-top: 0;">
                <div class="asef-pd-grid">
                    {{-- GALLERY (single image for now — Bagisto backend will multi later) --}}
                    <div>
                        <div class="asef-pd-gallery">
                            <img src="{{ $asefUrl($product['img']) }}" alt="{{ $product['name'] }}" />
                        </div>
                    </div>

                    {{-- INFO + CTA --}}
                    <div class="asef-pd-info">
                        <div class="asef-pd-cat">{{ mb_strtoupper($product['catLabel'], 'UTF-8') }}</div>
                        <h1 class="asef-pd-title">{{ $product['name'] }}</h1>
                        <div class="asef-pd-sku-line">{{ $product['sku'] }}</div>
                        <p class="asef-pd-desc">{{ $product['desc'] }}</p>

                        @if (! empty($product['usecases']))
                            <div class="asef-pd-usecases-title">Kullanım alanları</div>
                            <div class="asef-pd-usecases">
                                @foreach ($product['usecases'] as $uc)
                                    <span class="asef-pd-usecase">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        {{ $uc }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="asef-pd-spec-title">Teknik özellikler</div>
                        <ul class="asef-pd-spec-list">
                            @foreach ($product['specs'] as $spec)
                                <li>
                                    <span class="asef-pd-spec-label">{{ $spec['label'] }}</span>
                                    <span class="asef-pd-spec-value">{{ $spec['value'] }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- ADD TO CART CARD --}}
                        <div class="asef-pd-card">
                            <div class="asef-pd-card-head">
                                <div class="asef-pd-card-title">Teklif İste</div>
                                <span class="asef-pd-stock">Stokta / Kısa sürede tedarik</span>
                            </div>
                            <div class="asef-pd-qty-row">
                                <span class="asef-pd-qty-label">Adet</span>
                                <div class="asef-qty-picker" data-asef-qty-picker>
                                    <button type="button" class="asef-qty-btn" data-asef-qty-dec aria-label="Azalt">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14"/></svg>
                                    </button>
                                    <span class="asef-qty-value" data-asef-qty-value>1</span>
                                    <button type="button" class="asef-qty-btn" data-asef-qty-inc aria-label="Arttır">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                                    </button>
                                </div>
                            </div>
                            <div class="asef-pd-cta-row">
                                <button type="button"
                                        class="asef-cta-pill black"
                                        data-asef-pd-add
                                        data-sku="{{ $product['sku'] }}"
                                        data-name="{{ $product['name'] }}"
                                        data-img="{{ $asefUrl($product['img']) }}"
                                        data-cat="{{ $product['catLabel'] }}">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    Sepete Ekle
                                </button>
                                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill outline">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M17.6 6.32A7.85 7.85 0 0 0 12.05 4a7.94 7.94 0 0 0-6.88 11.9L4 20l4.2-1.1a7.94 7.94 0 0 0 3.85.98A7.94 7.94 0 0 0 17.6 6.32Z"/></svg>
                                    WhatsApp'tan Yaz
                                </a>
                            </div>
                            <div class="asef-pd-note">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                                <span>Doğru ölçü ve bağlantı seçimi için teknik ekibimiz operasyon bilgilerinizi birlikte değerlendirir.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- RELATED PRODUCTS --}}
            @if ($related->count() > 0)
                <section class="asef-related-wrap">
                    <div class="asef-related-head">
                        <h2>Birlikte iyi gider.</h2>
                    </div>
                    <div class="asef-related-grid">
                        @foreach ($related as $r)
                            <a href="{{ route('shop.asef.product', ['sku' => $r['sku']]) }}" class="asef-related-card">
                                <div class="asef-related-media">
                                    <img src="{{ $asefUrl($r['img']) }}" alt="{{ $r['name'] }}" loading="lazy" />
                                </div>
                                <div class="asef-related-name">{{ $r['name'] }}</div>
                                <div class="asef-related-desc">{{ \Illuminate\Support\Str::limit($r['desc'], 70) }}</div>
                                <span class="asef-related-link">İncele ›</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>

    {{-- Product detail JS: adet picker + sepete ekle --}}
    @push('scripts')
    <script>
    (function () {
        var qtyPicker = document.querySelector('[data-asef-qty-picker]');
        if (!qtyPicker) return;
        var valEl = qtyPicker.querySelector('[data-asef-qty-value]');
        var incBtn = qtyPicker.querySelector('[data-asef-qty-inc]');
        var decBtn = qtyPicker.querySelector('[data-asef-qty-dec]');
        var addBtn = document.querySelector('[data-asef-pd-add]');

        function getQty() { return Math.max(1, parseInt(valEl.textContent, 10) || 1); }
        function setQty(q) { valEl.textContent = String(Math.max(1, q)); decBtn.disabled = getQty() <= 1; }

        incBtn.addEventListener('click', function () { setQty(getQty() + 1); });
        decBtn.addEventListener('click', function () { setQty(getQty() - 1); });
        setQty(1);

        addBtn.addEventListener('click', function () {
            var sku = addBtn.dataset.sku;
            var name = addBtn.dataset.name;
            var meta = { img: addBtn.dataset.img, cat: addBtn.dataset.cat };
            window.AsefCart.add(sku, name, getQty(), meta);
        });
    })();
    </script>
    @endpush
</x-shop::layouts>
