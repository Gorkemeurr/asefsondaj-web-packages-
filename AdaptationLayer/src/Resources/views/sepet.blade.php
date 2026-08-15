{{-- ============================================================
     Asef Sondaj — Teklif Sepetim (v5)
     Route: /sepet
     Fully client-side; reads localStorage via AsefCart, renders
     rows dynamically, sends WhatsApp message with items.
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));
@endphp

@push('meta')
    <meta name="title" content="Teklif Sepetim — Asef Sondaj" />
    <meta name="description" content="Seçtiğiniz sondaj ekipmanları için teklif oluşturun. WhatsApp'tan doğrudan bize ulaşın." />
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
        Teklif Sepetim — Asef Sondaj
    </x-slot>

    <div class="asef-root">

        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <div class="asef-cart-wrap">
                <h1 class="asef-cart-title">Teklif Sepetim.</h1>

                {{-- Empty state (shown if cart empty) --}}
                <div class="asef-cart-empty" data-asef-cart-empty style="display: none;">
                    <svg class="asef-cart-empty-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                        <path d="M3 6h18"/>
                        <path d="M16 10a4 4 0 0 1-8 0"/>
                    </svg>
                    <h3>Sepetiniz boş.</h3>
                    <p>Ürünleri keşfedip teklif listenize ekleyin, ardından WhatsApp'tan tek adımda bize iletin.</p>
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill primary">Ürünleri keşfet</a>
                </div>

                {{-- Cart with items (shown if cart non-empty) --}}
                <div class="asef-cart-grid" data-asef-cart-filled style="display: none;">
                    <div>
                        <div class="asef-cart-items" data-asef-cart-list>
                            {{-- JS renders <div class="asef-cart-item"> here --}}
                        </div>
                        <div class="asef-cart-clear-row">
                            <button type="button" class="asef-cart-clear" data-asef-cart-clear>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:-2px;margin-right:4px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-2 14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                Sepeti temizle
                            </button>
                        </div>
                    </div>

                    <aside class="asef-cart-summary">
                        <h3>Sipariş Özeti</h3>
                        <div class="asef-cart-summary-row">
                            <span class="asef-cart-summary-label">Seçilen Ürün Sayısı</span>
                            <span class="asef-cart-summary-value"><span data-asef-cart-count>0</span> kalem</span>
                        </div>
                        <div class="asef-cart-summary-row">
                            <span class="asef-cart-summary-label">Toplam Adet</span>
                            <span class="asef-cart-summary-value"><span data-asef-cart-total>0</span></span>
                        </div>
                        <div class="asef-cart-summary-row">
                            <span class="asef-cart-summary-label">Teklif Tutarı</span>
                            <span class="asef-cart-summary-value muted">İletişimde belirlenecek</span>
                        </div>
                        <div class="asef-cart-summary-row">
                            <span class="asef-cart-summary-label">Teknik İnceleme</span>
                            <span class="asef-cart-summary-value">Dahil</span>
                        </div>

                        <div class="asef-cart-cta-block">
                            <a href="#" data-asef-wa-quote class="asef-cta-pill primary">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#FFFFFF" style="flex-shrink:0;"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.06 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.13 1.6 5.93L0 24l6.34-1.67a11.87 11.87 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.45-8.41zM12.07 21.8h-.01a9.9 9.9 0 0 1-5.05-1.38l-.36-.22-3.76.99 1-3.67-.24-.38a9.88 9.88 0 0 1-1.51-5.24c0-5.46 4.44-9.9 9.91-9.9 2.64 0 5.13 1.03 7 2.9a9.83 9.83 0 0 1 2.9 7c0 5.46-4.44 9.9-9.88 9.9zm5.43-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.93-2.22-.24-.58-.49-.5-.67-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.22 1.35.19 1.86.11.57-.08 1.76-.72 2-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35z"/></svg>
                                WhatsApp'tan Teklif Al
                            </a>
                            <a href="{{ $catalogUrl }}" class="asef-cart-continue">Alışverişe devam et</a>
                        </div>

                        <div class="asef-cart-trust">
                            <div class="asef-cart-trust-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                Güvenli iletişim ve teknik destek
                            </div>
                            <div class="asef-cart-trust-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 2"/></svg>
                                7/24 WhatsApp danışmanlık
                            </div>
                            <div class="asef-cart-trust-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="7" width="16" height="13" rx="2"/><path d="M4 11h16"/><path d="M9 3h6v4"/></svg>
                                20 yıllık saha tecrübesi
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>

    {{-- Sepet renderer — reads localStorage via AsefCart, generates rows.
         Clicks on rows are handled by AsefCart delegation (v5-cart-js). --}}
    @push('scripts')
    <script>
        window.ASEF_URUN_BASE = @json(url('urun'));
        // Master catalog — used to enrich legacy cart rows that lack img/cat/name
        window.ASEF_CATALOG = @json([
            'AS-DTH-040' => ['name' => 'DTH Çekiç 4 İnç',             'cat' => 'Delici Ekipmanlar', 'img' => $asefUrl('dth-hammer.jpg')],
            'AS-BIT-152' => ['name' => 'DTH Button Bit 6 İnç',        'cat' => 'Delici Ekipmanlar', 'img' => $asefUrl('asef-diamond-bit.jpg')],
            'AS-TRI-215' => ['name' => 'Tricone Matkap 8 1/2 İnç',    'cat' => 'Delici Ekipmanlar', 'img' => $asefUrl('asef-macro-diamond.jpg')],
            'AS-ROD-300' => ['name' => 'Sondaj Tiji 3 Metre',         'cat' => 'Tij ve Borular',    'img' => $asefUrl('drill-rods.jpg')],
            'AS-CAS-168' => ['name' => 'Muhafaza Borusu 6 5/8 İnç',   'cat' => 'Tij ve Borular',    'img' => $asefUrl('asef-macro-thread.jpg')],
            'AS-PMP-600' => ['name' => 'Triplex Çamur Pompası',       'cat' => 'Pompa Sistemleri',  'img' => $asefUrl('mud-pump.jpg')],
            'AS-SWI-250' => ['name' => 'Yüksek Basınçlı Döner Başlık','cat' => 'Pompa Sistemleri',  'img' => $asefUrl('asef-macro-valve.jpg')],
            'AS-SRV-001' => ['name' => 'DTH Bakım ve Sızdırmazlık Seti','cat' => 'Yedek Parça',    'img' => $asefUrl('asef-spare-parts.jpg')],
        ]);
    </script>
    <script>
    (function () {
        // Enrich legacy items missing meta (img / cat / name)
        function enrich(it) {
            var cat = window.ASEF_CATALOG || {};
            var master = cat[it.sku];
            if (master) {
                if (!it.img)  it.img  = master.img;
                if (!it.cat)  it.cat  = master.cat;
                if (!it.name) it.name = master.name;
            }
            return it;
        }
        function esc(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function itemHtml(it) {
            var qty = parseInt(it.qty, 10) || 1;
            var url = (window.ASEF_URUN_BASE || '/urun') + '/' + encodeURIComponent(it.sku);
            var img = it.img
                ? '<img src="' + esc(it.img) + '" alt="' + esc(it.name) + '" loading="lazy">'
                : '<div class="asef-cart-item-img-fallback" aria-hidden="true">'
                +   '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>'
                + '</div>';
            return ''
                + '<div class="asef-cart-item" data-asef-cart-row data-sku="' + esc(it.sku) + '">'
                +   '<a href="' + url + '" class="asef-cart-item-img">' + img + '</a>'
                +   '<div class="asef-cart-item-body">'
                +     '<a href="' + url + '" class="asef-cart-item-name">' + esc(it.name) + '</a>'
                +     '<div class="asef-cart-item-sku">' + esc(it.sku) + (it.cat ? ' · ' + esc(it.cat) : '') + '</div>'
                +     '<div class="asef-cart-item-qty-row">'
                +       '<div class="asef-qty-picker" data-asef-qty-picker>'
                +         '<button type="button" class="asef-qty-btn" data-asef-qty-dec aria-label="Azalt"' + (qty <= 1 ? ' disabled' : '') + '><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14"/></svg></button>'
                +         '<span class="asef-qty-value" data-asef-qty-value>' + qty + '</span>'
                +         '<button type="button" class="asef-qty-btn" data-asef-qty-inc aria-label="Arttır"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg></button>'
                +       '</div>'
                +     '</div>'
                +   '</div>'
                +   '<button type="button" class="asef-cart-item-remove" data-asef-cart-remove data-sku="' + esc(it.sku) + '" aria-label="Kaldır">'
                +     '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>'
                +   '</button>'
                + '</div>';
        }

        function render() {
            var listEl   = document.querySelector('[data-asef-cart-list]');
            var emptyEl  = document.querySelector('[data-asef-cart-empty]');
            var filledEl = document.querySelector('[data-asef-cart-filled]');
            var countEl  = document.querySelector('[data-asef-cart-count]');
            var totalEl  = document.querySelector('[data-asef-cart-total]');
            if (!listEl || !window.AsefCart) return;

            var items = window.AsefCart.get().map(enrich);
            var totalQty = items.reduce(function (s, i) { return s + (parseInt(i.qty, 10) || 0); }, 0);

            if (items.length === 0) {
                emptyEl.style.display = '';
                filledEl.style.display = 'none';
                return;
            }
            emptyEl.style.display = 'none';
            filledEl.style.display = '';
            countEl.textContent = String(items.length);
            totalEl.textContent = String(totalQty);
            listEl.innerHTML = items.map(itemHtml).join('');
        }

        // Re-render whenever cart changes (from any source)
        window.addEventListener('asef-cart:changed', render);

        function tryRender() { if (window.AsefCart) render(); else setTimeout(tryRender, 100); }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', tryRender);
        } else {
            tryRender();
        }
        // Second pass after Vue mount likely settled
        setTimeout(tryRender, 300);
        setTimeout(tryRender, 1000);
    })();
    </script>
    @endpush
</x-shop::layouts>
