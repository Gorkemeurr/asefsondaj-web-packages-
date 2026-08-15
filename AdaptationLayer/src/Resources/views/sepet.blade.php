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
                            <button type="button" class="asef-cart-clear" data-asef-cart-clear>Sepeti temizle</button>
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
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="margin-right: 4px;"><path d="M17.6 6.32A7.85 7.85 0 0 0 12.05 4a7.94 7.94 0 0 0-6.88 11.9L4 20l4.2-1.1a7.94 7.94 0 0 0 3.85.98A7.94 7.94 0 0 0 17.6 6.32Z"/></svg>
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

    {{-- Sepet-specific renderer --}}
    @push('scripts')
    <script>
    (function () {
        var listEl    = document.querySelector('[data-asef-cart-list]');
        var emptyEl   = document.querySelector('[data-asef-cart-empty]');
        var filledEl  = document.querySelector('[data-asef-cart-filled]');
        var countEl   = document.querySelector('[data-asef-cart-count]');
        var totalEl   = document.querySelector('[data-asef-cart-total]');
        var clearBtn  = document.querySelector('[data-asef-cart-clear]');

        if (!listEl) return;

        function esc(str) {
            return String(str == null ? '' : str)
                .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
        }

        function itemHtml(it) {
            var img = it.img ? '<img src="' + esc(it.img) + '" alt="' + esc(it.name) + '">' : '';
            return ''
                + '<div class="asef-cart-item">'
                +   '<div class="asef-cart-item-img">' + img + '</div>'
                +   '<div class="asef-cart-item-body">'
                +     '<div class="asef-cart-item-name">' + esc(it.name) + '</div>'
                +     '<div class="asef-cart-item-sku">' + esc(it.sku) + (it.cat ? ' · ' + esc(it.cat) : '') + '</div>'
                +     '<div class="asef-cart-item-qty-row">'
                +       '<div class="asef-qty-picker">'
                +         '<button class="asef-qty-btn" data-dec="' + esc(it.sku) + '" aria-label="Azalt"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M5 12h14"/></svg></button>'
                +         '<span class="asef-qty-value">' + (parseInt(it.qty, 10) || 1) + '</span>'
                +         '<button class="asef-qty-btn" data-inc="' + esc(it.sku) + '" aria-label="Arttır"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg></button>'
                +       '</div>'
                +     '</div>'
                +   '</div>'
                +   '<button type="button" class="asef-cart-item-remove" data-remove="' + esc(it.sku) + '" aria-label="Kaldır">'
                +     '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>'
                +   '</button>'
                + '</div>';
        }

        function render() {
            var items = window.AsefCart.get();
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

        // Delegated handlers
        listEl.addEventListener('click', function (ev) {
            var t = ev.target.closest('button');
            if (!t) return;
            if (t.dataset.inc) {
                var items = window.AsefCart.get();
                var it = items.find(function (x) { return x.sku === t.dataset.inc; });
                if (it) window.AsefCart.setQty(t.dataset.inc, (it.qty || 1) + 1);
            } else if (t.dataset.dec) {
                var items2 = window.AsefCart.get();
                var it2 = items2.find(function (x) { return x.sku === t.dataset.dec; });
                if (it2 && it2.qty > 1) window.AsefCart.setQty(t.dataset.dec, it2.qty - 1);
            } else if (t.dataset.remove) {
                window.AsefCart.remove(t.dataset.remove);
            }
        });

        clearBtn.addEventListener('click', function () {
            if (window.AsefCart.count() === 0) return;
            if (confirm('Sepetteki tüm ürünler silinecek. Onaylıyor musun?')) {
                window.AsefCart.clear();
            }
        });

        window.addEventListener('asef-cart:changed', render);
        render();
    })();
    </script>
    @endpush
</x-shop::layouts>
