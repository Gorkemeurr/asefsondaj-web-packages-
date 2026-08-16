{{-- ============================================================
     Asef Sondaj — Ürün Detay (v5, DB backed)
     Route: /urun/{sku}
     Faz 2B: AsefProduct'tan okur, statik catalog kaldırıldı.
     ============================================================ --}}
@php
    use AsefSondaj\AdaptationLayer\Models\AsefProduct;

    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');

    $sku = strtoupper(trim($sku ?? ''));
    $product = AsefProduct::where('sku', $sku)->where('is_active', true)->first();

    if (! $product) {
        abort(404);
    }

    $altKat = $product->altKategori;
    $anaKat = $product->anaKategori;
    $catLabel = $altKat ? $altKat->name : ($anaKat ? $anaKat->name : '');

    $imgFile = $product->image ?: 'asef-hero-equipment.jpg';
    $imgSrc  = url('asef/' . $imgFile);

    $filledAttrs = $product->filledAttrs();

    // Related — same alt category, 3 items
    $related = AsefProduct::where('is_active', true)
        ->where('alt_code', $product->alt_code)
        ->where('sku', '!=', $product->sku)
        ->orderBy('sort')
        ->limit(3)
        ->get();
    if ($related->count() < 3) {
        $extra = AsefProduct::where('is_active', true)
            ->where('ana_code', $product->ana_code)
            ->whereNotIn('sku', $related->pluck('sku')->push($product->sku))
            ->orderBy('sort')
            ->limit(3 - $related->count())
            ->get();
        $related = $related->concat($extra);
    }

    $altName = $product->altKategori->name ?? '';
    $anaName = $product->anaKategori->name ?? '';
    $ebatSistem = $product->attrs['ebat_sistem'] ?? '';

    // Description'da HTML olabilir (generator/admin panel) — meta için strip_tags + kısalt
    $descRaw = $product->description
        ?: trim(($ebatSistem ? $ebatSistem . ' — ' : '') . $product->name . '. '
            . ($altName ? $altName . ' kategorisinde ' : '')
            . 'sondaj ekipmanı. SKU: ' . $product->sku . '. '
            . 'Türkiye geneli sevkiyat, teknik danışmanlık ve satış sonrası destek. Teklif için WhatsApp\'tan yazın.');
    $pageDesc = trim(preg_replace('/\s+/', ' ', strip_tags($descRaw)));
    if (mb_strlen($pageDesc) > 300) {
        $pageDesc = mb_substr($pageDesc, 0, 297) . '...';
    }

    $pageTitle = $product->name . ' (' . $product->sku . ') — '
        . ($altName ?: 'Sondaj Ekipmanı') . ' | Asef Sondaj';
@endphp

@push('meta')
    <meta name="title" content="{{ $pageTitle }}" />
    <meta name="description" content="{{ e($pageDesc) }}" />
    <meta name="keywords" content="{{ $product->name }}, {{ $product->sku }}, {{ $altName }}, {{ $anaName }}, sondaj ekipmanı, sondaj yedek parça, {{ $ebatSistem }}" />

    {{-- Product structured data (Google rich card) — fiyat/stok BİLİNÇLİ olarak yok --}}
    @php
        $productJsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product->name,
            'sku' => $product->sku,
            'mpn' => $product->sku,
            'description' => $pageDesc,
            'image' => [$imgSrc],
            'brand' => ['@type' => 'Brand', 'name' => $product->brand],
            'manufacturer' => ['@type' => 'Organization', 'name' => 'Asef Sondaj'],
            'url' => url()->current(),
        ];
        if ($altKat) $productJsonLd['category'] = $altKat->name;
    @endphp
    <script type="application/ld+json">{!! json_encode($productJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>

    {{-- Breadcrumb JSON-LD --}}
    @php
        $breadcrumbItems = [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana Sayfa', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Ürünler', 'item' => route('shop.search.index')],
        ];
        $pos = 3;
        if ($anaKat) {
            $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $anaKat->name, 'item' => route('shop.search.index', ['ana' => $anaKat->code])];
        }
        if ($altKat && $anaKat) {
            $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => $pos++, 'name' => $altKat->name, 'item' => route('shop.search.index', ['ana' => $anaKat->code, 'alt' => $altKat->code])];
        }
        $breadcrumbItems[] = ['@type' => 'ListItem', 'position' => $pos, 'name' => $product->name, 'item' => url()->current()];
        $breadcrumbJsonLd = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => $breadcrumbItems];
    @endphp
    <script type="application/ld+json">{!! json_encode($breadcrumbJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .pd-sku-copy {
        display: inline-flex; align-items: center; gap: 6px;
        background: var(--surface-alt); padding: 4px 10px; border-radius: 8px;
        font-family: "SF Mono", ui-monospace, Menlo, monospace; font-size: 12px;
        color: var(--on-surface); cursor: pointer; border: 1px solid transparent;
        transition: background .15s, border-color .15s;
    }
    .pd-sku-copy:hover { background: #EEEEF0; border-color: var(--outline); }
    .pd-sku-copy svg { width: 12px; height: 12px; }
    .pd-copy-toast {
        position: fixed; left: 50%; bottom: 32px; transform: translateX(-50%) translateY(20px);
        background: #1d1d1f; color: #fff; padding: 12px 22px; border-radius: 999px;
        font-size: 14px; font-weight: 500; z-index: 9999;
        opacity: 0; pointer-events: none; transition: opacity .25s, transform .25s;
        box-shadow: 0 14px 34px rgba(0,0,0,0.24);
    }
    .pd-copy-toast.on { opacity: 1; transform: translateX(-50%) translateY(0); }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>{{ $product->name }} — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- BREADCRUMB --}}
            <div class="asef-pd-wrap" style="padding-bottom: 0;">
                <nav class="asef-breadcrumb" aria-label="breadcrumb">
                    <a href="{{ url('/') }}">Ana Sayfa</a>
                    <span class="sep">/</span>
                    <a href="{{ route('shop.search.index') }}">Ürünler</a>
                    @if ($anaKat)
                        <span class="sep">/</span>
                        <a href="{{ route('shop.search.index', ['ana' => $anaKat->code]) }}">{{ $anaKat->name }}</a>
                    @endif
                    @if ($altKat)
                        <span class="sep">/</span>
                        <a href="{{ route('shop.search.index', ['ana' => $anaKat->code, 'alt' => $altKat->code]) }}">{{ $altKat->name }}</a>
                    @endif
                    <span class="sep">/</span>
                    <span class="current">{{ $product->name }}</span>
                </nav>
            </div>

            {{-- PRODUCT MAIN --}}
            <section class="asef-pd-wrap" style="padding-top: 0;">
                <div class="asef-pd-grid">
                    <div>
                        <div class="asef-pd-gallery">
                            <img src="{{ $imgSrc }}" alt="{{ $product->sku }} — {{ $product->name }}{{ $altName ? ' | ' . $altName : '' }} | Asef Sondaj sondaj ekipmanı" loading="eager" fetchpriority="high" />
                        </div>
                    </div>

                    <div class="asef-pd-info">
                        <div class="asef-pd-cat">{{ mb_strtoupper($catLabel, 'UTF-8') }}</div>
                        <h1 class="asef-pd-title">{{ $product->name }}</h1>

                        {{-- SKU + copy button --}}
                        <div class="asef-pd-sku-line" style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
                            <span>Ürün Kodu:</span>
                            <button type="button" class="pd-sku-copy" data-pd-copy="{{ $product->sku }}" aria-label="Ürün kodunu kopyala">
                                {{ $product->sku }}
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15V5a2 2 0 0 1 2-2h10"/></svg>
                            </button>
                        </div>

                        @php
                            // Description: DB'den (varsa) VEYA otomatik generator (kategori+attrs bazlı)
                            $productDescHtml = trim($product->description ?? '');
                            if ($productDescHtml === '') {
                                // Runtime generator — DB'de description yoksa view seviyesinde üret
                                $anaMap = [
                                    'WLS' => 'wireline karotiyer sistemi bileşeni. DCDMA standardında maden ve jeoteknik sondaj operasyonları için özel tasarlanmıştır.',
                                    'DTS' => 'düz takım karotiyer sistemi ürünü. Konvansiyonel karot sondajında sığ ve orta derinlik uygulamaları için uygundur.',
                                    'DVD' => 'elmas veya vidye tabanlı sondaj kesici ürünü. Kaya sertliğine ve delik çapına göre optimize edilmiş kesici performansı sağlar.',
                                    'TMB' => 'sondaj tiji veya muhafaza borusu. Doğru bağlantı standardıyla kuyu operasyonunda güvenli ve verimli çalışma sağlar.',
                                    'AKS' => 'sondaj aksesuar ürünü. Ana ekipmanın performansını tamamlayarak saha operasyonunu güvenli ve akıcı kılar.',
                                    'ADP' => 'sondaj adaptörü. Farklı bağlantı standartlarına sahip ekipmanlar arasında geçiş sağlar.',
                                    'THL' => 'sondaj tahlisiyesi (kurtarma ekipmanı). Kuyuda sıkışan veya kopan ekipmanların çıkarılması için özel tasarlanmıştır.',
                                    'NUM' => 'numune alma ekipmanı. Jeoteknik etüt ve maden aramaları için laboratuvar analizine uygun numune sağlar.',
                                    'KDL' => 'kaya delgi ekipmanı. DTH veya rotary sondajda sert ve orta sertlikte formasyonlarda hızlı ilerleme sağlar.',
                                    'AEL' => 'sondaj sahasında kullanılan anahtar veya el aleti. Operasyon güvenliği ve verimi için ergonomik tasarım.',
                                    'KSN' => 'karot sandığı veya numune ekipmanı. Alınan kaya numunelerinin sırayla, kırılmadan saklanmasını sağlar.',
                                    'SKS' => 'sondaj kimyasalı. Çamur sistemi performansını optimize ederek formasyon stabilitesi ve kesik taşımayı iyileştirir.',
                                    'JEO' => 'jeoteknik ekipman. Zemin etüdü, standart penetrasyon testi ve zemin mekaniği araştırmaları için özel üretilmiştir.',
                                    'GVN' => 'sondaj güvenlik ekipmanı. Saha operasyonunda operatör güvenliği ve yasal zorunluluk için sertifikalıdır.',
                                    'SMK' => 'sondaj makinesi veya makine yedek parçası. Operasyon verimliliği ve makine ömrü için orijinal üretici garantisi.',
                                ];
                                $ctx = $anaMap[$product->ana_code] ?? 'profesyonel sondaj sektörü ürünü.';

                                $techParts = [];
                                $a = $product->attrs ?? [];
                                if (! empty($a['ebat_sistem']))    $techParts[] = $a['ebat_sistem'] . ' sistemi';
                                if (! empty($a['boy_uzunluk']))    $techParts[] = $a['boy_uzunluk'] . ' uzunluğunda';
                                if (! empty($a['karot_capi_mm']))  $techParts[] = $a['karot_capi_mm'] . ' mm karot çapı';
                                if (! empty($a['kuyu_capi_mm']))   $techParts[] = $a['kuyu_capi_mm'] . ' mm kuyu çapı';
                                if (! empty($a['dis_cap_od_mm']))  $techParts[] = $a['dis_cap_od_mm'] . ' mm dış çap';
                                if (! empty($a['ic_cap_id_mm']))   $techParts[] = $a['ic_cap_id_mm'] . ' mm iç çap';
                                if (! empty($a['dis_baglanti']))   $techParts[] = $a['dis_baglanti'] . ' bağlantı';

                                $productDescHtml = '<p><strong>' . e($product->name) . '</strong> (' . e($product->sku) . ') — ' . $ctx . '</p>';
                                if ($techParts) {
                                    $productDescHtml .= '<p><strong>Teknik özellikler:</strong> ' . e(implode(', ', $techParts)) . '.</p>';
                                }
                                $productDescHtml .= '<p><strong>Sevkiyat ve destek:</strong> Türkiye geneli 81 ilde 2-5 iş günü sevkiyat. Teknik danışmanlık ve satış sonrası destek dahil. Teklif için WhatsApp: <a href="https://wa.me/905320542975">0532 054 29 75</a>.</p>';
                            }
                        @endphp
                        <div class="asef-pd-desc">
                            @if (strpos($productDescHtml, '<') !== false)
                                {!! $productDescHtml !!}
                            @else
                                <p>{{ $productDescHtml }}</p>
                            @endif
                        </div>

                        {{-- TEKNİK ÖZELLİKLER — sadece DOLU alanlar --}}
                        @if (count($filledAttrs) > 0)
                            <div class="asef-pd-spec-head">
                                <div class="asef-pd-spec-title">Teknik özellikler</div>
                                <div class="asef-pd-spec-sub">{{ count($filledAttrs) }} DEĞER</div>
                            </div>
                            <div class="asef-pd-spec-grid">
                                @foreach ($filledAttrs as $i => $a)
                                    <div class="asef-pd-spec-card">
                                        <span class="asef-pd-spec-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                        <span class="asef-pd-spec-label-new">{{ $a['label'] }}</span>
                                        <span class="asef-pd-spec-value-new">{{ $a['value'] }}{{ $a['unit'] ? ' ' . $a['unit'] : '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

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
                                        data-sku="{{ $product->sku }}"
                                        data-name="{{ $product->name }}"
                                        data-img="{{ $imgSrc }}"
                                        data-cat="{{ $catLabel }}">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                                    Sepete Ekle
                                </button>
                                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill outline">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#25D366"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.06 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.13 1.6 5.93L0 24l6.34-1.67a11.87 11.87 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.45-8.41zM12.07 21.8h-.01a9.9 9.9 0 0 1-5.05-1.38l-.36-.22-3.76.99 1-3.67-.24-.38a9.88 9.88 0 0 1-1.51-5.24c0-5.46 4.44-9.9 9.91-9.9 2.64 0 5.13 1.03 7 2.9a9.83 9.83 0 0 1 2.9 7c0 5.46-4.44 9.9-9.88 9.9zm5.43-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.93-2.22-.24-.58-.49-.5-.67-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.22 1.35.19 1.86.11.57-.08 1.76-.72 2-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35z"/></svg>
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

            {{-- RELATED --}}
            @if ($related->count() > 0)
                <section class="asef-related-wrap">
                    <div class="asef-related-head">
                        <h2>Birlikte iyi gider.</h2>
                    </div>
                    <div class="asef-related-grid">
                        @foreach ($related as $r)
                            @php
                                $rImg = url('asef/' . ($r->image ?: 'asef-hero-equipment.jpg'));
                            @endphp
                            <a href="{{ route('shop.asef.product', ['sku' => $r->sku]) }}" class="asef-related-card">
                                <div class="asef-related-media">
                                    <img src="{{ $rImg }}" alt="{{ $r->sku }} — {{ $r->name }} sondaj ekipmanı" loading="lazy" />
                                </div>
                                <div class="asef-related-name">{{ $r->name }}</div>
                                <div class="asef-related-desc">{{ $r->attrs['ebat_sistem'] ?? '' }} {{ $r->attrs['boy_uzunluk'] ? '· ' . $r->attrs['boy_uzunluk'] : '' }}</div>
                                <span class="asef-related-link">İncele ›</span>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

        </main>

        <div id="pdCopyToast" class="pd-copy-toast" role="status" aria-live="polite">Kod kopyalandı</div>
        <script>
        (function () {
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('[data-pd-copy]');
                if (!btn) return;
                e.preventDefault();
                var val = btn.getAttribute('data-pd-copy');
                var toast = document.getElementById('pdCopyToast');
                function ok() { if (toast) { toast.classList.add('on'); setTimeout(function(){ toast.classList.remove('on'); }, 1800); } }
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(val).then(ok);
                } else {
                    var ta = document.createElement('textarea');
                    ta.value = val; ta.style.position='fixed'; ta.style.opacity='0';
                    document.body.appendChild(ta); ta.select();
                    try { document.execCommand('copy'); ok(); } catch(_){}
                    document.body.removeChild(ta);
                }
            });
        })();
        </script>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
