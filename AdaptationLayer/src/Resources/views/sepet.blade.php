{{-- ============================================================
     Asef Sondaj — Teklif Sepetim (v5)
     Route: /sepet
     Fully client-side; reads localStorage via AsefCart, renders
     rows dynamically, sends WhatsApp message with items.
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = asef_wa_link('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Master catalog used to enrich legacy cart rows that lack img/cat/name.
    // 813 ürünün tümü DB'den — sepette hangisi varsa lookup ile enrich edilir.
    $asefJsCatalog = \AsefSondaj\AdaptationLayer\Models\AsefProduct::query()
        ->where('is_active', true)
        ->with('altKategori')
        ->get(['sku', 'name', 'image', 'alt_code'])
        ->mapWithKeys(function ($p) use ($asefUrl) {
            return [$p->sku => [
                'name' => $p->name,
                'cat'  => optional($p->altKategori)->name ?: '',
                'img'  => $asefUrl($p->image ?: 'asef-hero-equipment.jpg'),
            ]];
        })
        ->toArray();
@endphp

@push('meta')
    <meta name="title" content="Teklif Sepetim — Asef Sondaj" />
    <meta name="description" content="Seçtiğiniz sondaj ekipmanları için teklif oluşturun. WhatsApp'tan doğrudan bize ulaşın." />
    <meta name="theme-color" content="#ffffff" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    /* ============ SEPET FORMU (v5 Apple minimalist) ============ */
    .asef-cart-form {
        margin-top: 24px; padding-top: 24px;
        border-top: 1px solid var(--outline);
        display: flex; flex-direction: column; gap: 14px;
    }
    .asef-cart-form-title {
        font-size: 15px; font-weight: 600; letter-spacing: -0.01em;
        color: var(--primary); margin: 0;
    }
    .asef-cart-form-lede {
        font-size: 12px; color: var(--gray-secondary); line-height: 1.5;
        margin: -6px 0 6px;
    }
    .asef-cart-field { display: flex; flex-direction: column; gap: 6px; }
    .asef-cart-field label {
        font-size: 12px; font-weight: 500; color: var(--secondary);
        letter-spacing: 0.01em;
    }
    .asef-cart-field label span[aria-hidden] {
        color: #DC2626; margin-left: 2px; font-weight: 700;
    }
    .asef-cart-field input,
    .asef-cart-field textarea {
        width: 100%; box-sizing: border-box;
        padding: 11px 14px;
        font: 400 14px/1.4 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--primary);
        background: #FFFFFF;
        border: 1px solid var(--outline); border-radius: 12px;
        transition: border-color .15s, box-shadow .15s, background .15s;
        -webkit-appearance: none; appearance: none;
    }
    .asef-cart-field input::placeholder,
    .asef-cart-field textarea::placeholder {
        color: var(--gray-secondary); font-weight: 400;
    }
    .asef-cart-field input:focus,
    .asef-cart-field textarea:focus {
        outline: none; border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
    }
    .asef-cart-field input.is-invalid,
    .asef-cart-field textarea.is-invalid {
        border-color: #DC2626;
        box-shadow: 0 0 0 3px rgba(220,38,38,0.10);
    }
    .asef-cart-field textarea { resize: vertical; min-height: 78px; }

    /* ============ CUSTOM SELECT (v5 Apple minimalist) ============ */
    .asef-select { position: relative; }
    .asef-select-trigger {
        width: 100%; box-sizing: border-box;
        display: inline-flex; align-items: center; justify-content: space-between;
        gap: 10px; padding: 11px 14px;
        font: 400 14px/1.4 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        color: var(--primary);
        background: #FFFFFF;
        border: 1px solid var(--outline); border-radius: 12px;
        cursor: pointer; text-align: left;
        transition: border-color .15s, box-shadow .15s;
    }
    .asef-select-trigger[data-empty="true"] { color: var(--gray-secondary); }
    .asef-select-trigger:hover { border-color: #B0B0B7; }
    .asef-select-trigger:focus,
    .asef-select.is-open .asef-select-trigger {
        outline: none; border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0,0,0,0.05);
    }
    .asef-select-trigger svg {
        flex-shrink: 0; color: var(--gray-secondary);
        transition: transform .2s cubic-bezier(0.16,1,0.3,1);
    }
    .asef-select.is-open .asef-select-trigger svg { transform: rotate(180deg); }

    .asef-select-panel {
        position: absolute; z-index: 20;
        top: calc(100% + 6px); left: 0; right: 0;
        background: #FFFFFF;
        border: 1px solid var(--outline);
        border-radius: 14px;
        padding: 6px;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.8) inset,
            0 8px 24px -4px rgba(0,0,0,0.14),
            0 3px 6px -1px rgba(0,0,0,0.06);
        opacity: 0; transform: translateY(-4px);
        transition: opacity .18s cubic-bezier(0.16,1,0.3,1), transform .22s cubic-bezier(0.16,1,0.3,1);
        pointer-events: none;
    }
    .asef-select-panel[hidden] { display: none; }
    .asef-select.is-open .asef-select-panel {
        opacity: 1; transform: translateY(0); pointer-events: auto;
    }
    .asef-select-option {
        display: block; width: 100%; box-sizing: border-box;
        padding: 10px 12px; margin: 0;
        text-align: left; background: transparent; border: 0;
        border-radius: 10px; cursor: pointer;
        font: 400 14px/1.4 'Inter', -apple-system, sans-serif;
        color: var(--primary);
        transition: background .12s, color .12s;
    }
    .asef-select-option:hover,
    .asef-select-option:focus {
        outline: none; background: var(--surface-alt);
    }
    .asef-select-option.is-selected {
        background: var(--primary); color: #FFFFFF;
    }
    .asef-select-option.is-selected:hover { background: var(--primary); }

    /* İl + İlçe yan yana (mobile'da alt alta) */
    .asef-cart-row-2 { display: grid; grid-template-columns: 1fr; gap: 14px; }
    @media (min-width: 480px) {
        .asef-cart-row-2 { grid-template-columns: 1fr 1fr; }
    }

    .asef-cart-form-hint {
        min-height: 0; font-size: 12px; color: #DC2626; letter-spacing: -0.005em;
    }

    /* ============ 3D HATA MODALI (Apple depth) ============ */
    .asef-cart-modal-backdrop {
        position: fixed; inset: 0;
        background: rgba(15,17,20,0.42);
        backdrop-filter: blur(18px) saturate(180%);
        -webkit-backdrop-filter: blur(18px) saturate(180%);
        display: none; align-items: center; justify-content: center;
        z-index: 10001; padding: 20px;
        opacity: 0; transition: opacity .28s cubic-bezier(0.16,1,0.3,1);
    }
    .asef-cart-modal-backdrop.on { display: flex; opacity: 1; }
    .asef-cart-modal {
        width: 100%; max-width: 420px;
        background: linear-gradient(180deg, #FFFFFF 0%, #F5F5F7 100%);
        border-radius: 28px;
        padding: 32px 28px 24px;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.9) inset,
            0 0 0 1px rgba(0,0,0,0.04),
            0 24px 80px -8px rgba(0,0,0,0.35),
            0 8px 20px -4px rgba(0,0,0,0.18);
        transform: scale(.94) translateY(10px);
        opacity: 0; transition: transform .32s cubic-bezier(0.16,1,0.3,1), opacity .28s;
        text-align: center;
    }
    .asef-cart-modal-backdrop.on .asef-cart-modal {
        transform: scale(1) translateY(0); opacity: 1;
    }
    .asef-cart-modal-icon {
        width: 72px; height: 72px; margin: 0 auto 20px;
        border-radius: 20px;
        background: linear-gradient(180deg, #FEE2E2 0%, #FCA5A5 100%);
        display: flex; align-items: center; justify-content: center;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.65) inset,
            0 10px 24px -6px rgba(220,38,38,0.35),
            0 3px 6px -1px rgba(220,38,38,0.15);
    }
    .asef-cart-modal-icon svg {
        width: 36px; height: 36px; color: #B91C1C;
        filter: drop-shadow(0 1px 1px rgba(255,255,255,0.4));
    }
    .asef-cart-modal h4 {
        font-size: 20px; font-weight: 700; letter-spacing: -0.02em;
        color: var(--primary); margin: 0 0 10px; line-height: 1.25;
    }
    .asef-cart-modal p {
        font-size: 14px; color: var(--secondary); line-height: 1.55;
        margin: 0 0 24px;
    }
    .asef-cart-modal-actions { display: flex; flex-direction: column; gap: 10px; }
    .asef-cart-modal-btn {
        display: inline-flex; align-items: center; justify-content: center;
        padding: 13px 22px; border-radius: 999px; border: 0;
        font: 600 14px/1 'Inter', -apple-system, sans-serif;
        letter-spacing: -0.005em; cursor: pointer;
        transition: transform .15s cubic-bezier(0.16,1,0.3,1), box-shadow .2s, background .2s;
    }
    .asef-cart-modal-btn.primary {
        background: var(--primary); color: #FFFFFF;
        box-shadow: 0 6px 16px -4px rgba(0,0,0,0.4), 0 2px 4px -1px rgba(0,0,0,0.2);
    }
    .asef-cart-modal-btn.primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 22px -4px rgba(0,0,0,0.45), 0 3px 6px -1px rgba(0,0,0,0.25);
    }
    .asef-cart-modal-btn.ghost {
        background: transparent; color: var(--secondary);
    }
    .asef-cart-modal-btn.ghost:hover { color: var(--primary); }

    @media (prefers-reduced-motion: reduce) {
        .asef-cart-modal-backdrop, .asef-cart-modal {
            transition: none;
        }
    }

    /* Mobile */
    @media (max-width: 640px) {
        .asef-cart-modal { max-width: 100%; padding: 26px 22px 22px; border-radius: 22px; }
        .asef-cart-modal-icon { width: 60px; height: 60px; border-radius: 16px; margin-bottom: 16px; }
        .asef-cart-modal-icon svg { width: 30px; height: 30px; }
        .asef-cart-modal h4 { font-size: 18px; }
        .asef-cart-modal p { font-size: 13.5px; margin-bottom: 20px; }
        .asef-cart-modal-btn { padding: 14px 22px; font-size: 15px; }
    }
</style>
@endpush

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
                            <span class="asef-cart-summary-value"><span data-asef-cart-count>0</span> ürün</span>
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

                        {{-- Sipariş bilgileri formu — WhatsApp mesajına otomatik eklenir --}}
                        <form class="asef-cart-form" data-asef-cart-form novalidate autocomplete="on">
                            <div class="asef-cart-form-title">Sipariş bilgileriniz</div>
                            <p class="asef-cart-form-lede">Bilgilerinizi girin, WhatsApp'a otomatik iletilsin.</p>

                            <div class="asef-cart-field">
                                <label for="cart-fullname">
                                    Ad Soyad <span aria-hidden="true">*</span>
                                </label>
                                <input type="text" id="cart-fullname" name="fullname" required
                                       autocomplete="name" placeholder="Örn: Ali Yılmaz"
                                       data-asef-cart-input="fullname" />
                            </div>

                            <div class="asef-cart-field">
                                <label for="cart-company">Firma adı</label>
                                <input type="text" id="cart-company" name="company"
                                       autocomplete="organization" placeholder="Örn: XYZ Sondaj Ltd. Şti."
                                       data-asef-cart-input="company" />
                            </div>

                            <div class="asef-cart-field">
                                <label for="cart-position">Firmadaki pozisyonunuz</label>
                                {{-- Custom dropdown — native select yerine v5 tasarımlı --}}
                                <div class="asef-select" data-asef-select>
                                    <button type="button" class="asef-select-trigger" data-asef-select-trigger
                                            aria-haspopup="listbox" aria-expanded="false" data-empty="true">
                                        <span data-asef-select-label>Seçiniz</span>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
                                    </button>
                                    <div class="asef-select-panel" role="listbox" data-asef-select-panel hidden>
                                        <button type="button" class="asef-select-option" role="option" data-asef-select-option data-value="Firma Sahibi">Firma Sahibi</button>
                                        <button type="button" class="asef-select-option" role="option" data-asef-select-option data-value="Firma Mühendisi">Firma Mühendisi</button>
                                        <button type="button" class="asef-select-option" role="option" data-asef-select-option data-value="Firma Operatörü">Firma Operatörü</button>
                                    </div>
                                    <input type="hidden" id="cart-position" name="position" data-asef-cart-input="position" value="" />
                                </div>
                            </div>

                            <div class="asef-cart-field">
                                <label for="cart-phone">
                                    Telefon <span aria-hidden="true">*</span>
                                </label>
                                <input type="tel" id="cart-phone" name="phone" required
                                       autocomplete="tel" placeholder="Örn: 0532 xxx xx xx"
                                       data-asef-cart-input="phone" />
                            </div>

                            <div class="asef-cart-row-2">
                                <div class="asef-cart-field">
                                    <label for="cart-city">İl</label>
                                    <input type="text" id="cart-city" name="city"
                                           autocomplete="address-level1" placeholder="Örn: Bursa"
                                           data-asef-cart-input="city" />
                                </div>
                                <div class="asef-cart-field">
                                    <label for="cart-district">İlçe</label>
                                    <input type="text" id="cart-district" name="district"
                                           autocomplete="address-level2" placeholder="Örn: Yıldırım"
                                           data-asef-cart-input="district" />
                                </div>
                            </div>

                            <div class="asef-cart-field">
                                <label for="cart-email">E-posta</label>
                                <input type="email" id="cart-email" name="email"
                                       autocomplete="email" placeholder="ornek@firma.com"
                                       data-asef-cart-input="email" />
                            </div>

                            <div class="asef-cart-field">
                                <label for="cart-note">Sipariş notu</label>
                                <textarea id="cart-note" name="note" rows="3"
                                          placeholder="Teslim tarihi, kargo adresi, özel istek..."
                                          data-asef-cart-input="note"></textarea>
                            </div>

                            <div class="asef-cart-form-hint" data-asef-cart-form-hint aria-live="polite"></div>
                        </form>

                        <div class="asef-cart-cta-block">
                            <button type="button" data-asef-wa-quote class="asef-cta-pill primary asef-cart-wa-btn"
                                    style="display:inline-flex !important;align-items:center !important;justify-content:center !important;gap:8px !important;width:100% !important;padding:14px 22px !important;background:#0066CC !important;color:#FFFFFF !important;border:0 !important;border-radius:999px !important;font-family:inherit !important;font-size:15px !important;font-weight:600 !important;letter-spacing:-0.005em !important;cursor:pointer !important;box-shadow:0 6px 16px rgba(0,102,204,0.28) !important;transition:transform .15s, box-shadow .2s, background .2s !important;margin-bottom:10px !important;">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="#FFFFFF" style="flex-shrink:0;"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.06 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.13 1.6 5.93L0 24l6.34-1.67a11.87 11.87 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.45-8.41zM12.07 21.8h-.01a9.9 9.9 0 0 1-5.05-1.38l-.36-.22-3.76.99 1-3.67-.24-.38a9.88 9.88 0 0 1-1.51-5.24c0-5.46 4.44-9.9 9.91-9.9 2.64 0 5.13 1.03 7 2.9a9.83 9.83 0 0 1 2.9 7c0 5.46-4.44 9.9-9.88 9.9zm5.43-7.42c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.17-.17.2-.35.22-.65.07-.3-.15-1.25-.46-2.38-1.47-.88-.79-1.47-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.67-1.62-.93-2.22-.24-.58-.49-.5-.67-.51-.17-.01-.37-.01-.57-.01-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48s1.07 2.88 1.22 3.08c.15.2 2.1 3.2 5.08 4.49.71.31 1.26.49 1.69.63.71.22 1.35.19 1.86.11.57-.08 1.76-.72 2-1.42.25-.7.25-1.29.17-1.42-.07-.13-.27-.2-.57-.35z"/></svg>
                                WhatsApp'tan Teklif Al
                            </button>
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

    {{-- 3D tasarımlı hata modalı — form validation başarısız olduğunda gösterilir --}}
    <div class="asef-cart-modal-backdrop" data-asef-cart-modal role="dialog" aria-modal="true" aria-labelledby="asef-cart-modal-title" aria-hidden="true">
        <div class="asef-cart-modal">
            <div class="asef-cart-modal-icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                    <path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                </svg>
            </div>
            <h4 id="asef-cart-modal-title">Formu doldurmanız gerekiyor</h4>
            <p data-asef-cart-modal-msg>Sipariş talebinizi WhatsApp'a gönderebilmemiz için lütfen Ad Soyad ve Telefon alanlarını doldurun.</p>
            <div class="asef-cart-modal-actions">
                <button type="button" class="asef-cart-modal-btn primary" data-asef-cart-modal-close>Tamam, dolduruyorum</button>
            </div>
        </div>
    </div>

    {{-- Sepet renderer — reads localStorage via AsefCart, generates rows.
         Clicks on rows are handled by AsefCart delegation (v5-cart-js). --}}
    @push('scripts')
    <script>
        window.ASEF_URUN_BASE = @json(url('urun'));
        window.ASEF_CATALOG = @json($asefJsCatalog);
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
                +   '<button type="button" data-asef-cart-remove data-sku="' + esc(it.sku) + '" aria-label="Ürünü sepetten sil" '
                +     'style="width:44px !important;height:44px !important;min-width:44px !important;border-radius:12px !important;display:inline-flex !important;align-items:center !important;justify-content:center !important;background:#DC2626 !important;color:#FFFFFF !important;border:0 !important;cursor:pointer !important;flex-shrink:0 !important;box-shadow:0 2px 8px rgba(220,38,38,0.35) !important;padding:0 !important;margin:0 0 0 16px !important;align-self:center !important;">'
                +     '<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="pointer-events:none;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/></svg>'
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

    {{-- Form validation + WhatsApp mesajı zenginleştirme --}}
    <script>
    (function () {
        var WA_PHONE = '905320542975';

        function $(sel, root) { return (root || document).querySelector(sel); }
        function $$(sel, root) { return Array.from((root || document).querySelectorAll(sel)); }

        function readForm() {
            var out = {};
            $$('[data-asef-cart-input]').forEach(function (el) {
                out[el.getAttribute('data-asef-cart-input')] = (el.value || '').trim();
            });
            return out;
        }

        function validateForm(data) {
            var errors = [];
            if (!data.fullname || data.fullname.length < 2) errors.push('fullname');
            // Telefon: en az 10 rakam
            var phoneDigits = (data.phone || '').replace(/\D/g, '');
            if (!data.phone || phoneDigits.length < 10) errors.push('phone');
            return errors;
        }

        function markInvalid(fieldNames) {
            $$('[data-asef-cart-input]').forEach(function (el) {
                el.classList.remove('is-invalid');
            });
            fieldNames.forEach(function (name) {
                var el = $('[data-asef-cart-input="' + name + '"]');
                if (el) el.classList.add('is-invalid');
            });
            var hint = $('[data-asef-cart-form-hint]');
            if (!hint) return;
            if (fieldNames.length === 0) {
                hint.textContent = '';
            } else {
                var labels = { fullname: 'Ad Soyad', phone: 'Telefon' };
                var need = fieldNames.map(function (f) { return labels[f] || f; }).join(', ');
                hint.textContent = 'Lütfen zorunlu alanları doldurun: ' + need;
            }
        }

        function buildEnrichedWaUrl(items, form) {
            var lines = ['Merhaba Asef Sondaj,', ''];

            lines.push('━ Müşteri ━');
            lines.push('Ad Soyad: ' + form.fullname);
            if (form.company) lines.push('Firma: ' + form.company);
            if (form.position) lines.push('Pozisyon: ' + form.position);
            lines.push('Telefon: ' + form.phone);
            if (form.email) lines.push('E-posta: ' + form.email);
            var loc = [];
            if (form.city) loc.push(form.city);
            if (form.district) loc.push(form.district);
            if (loc.length) lines.push('Konum: ' + loc.join(' / '));
            lines.push('');

            lines.push('━ Ürünler ━');
            items.forEach(function (it, i) {
                lines.push((i + 1) + '. ' + it.name + ' (' + it.sku + ') — ' + it.qty + ' adet');
            });
            lines.push('');

            if (form.note) {
                lines.push('━ Not ━');
                lines.push(form.note);
                lines.push('');
            }

            lines.push('En uygun teklif ve teslim süresi için geri dönüşünüzü bekliyorum.');
            return 'https://wa.me/' + WA_PHONE + '?text=' + encodeURIComponent(lines.join('\n'));
        }

        // Modal
        function openModal(customMsg) {
            var backdrop = $('[data-asef-cart-modal]');
            if (!backdrop) return;
            var msg = $('[data-asef-cart-modal-msg]');
            if (msg && customMsg) msg.textContent = customMsg;
            backdrop.classList.add('on');
            backdrop.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        }
        function closeModal() {
            var backdrop = $('[data-asef-cart-modal]');
            if (!backdrop) return;
            backdrop.classList.remove('on');
            backdrop.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        // Click delegation — capture:true → v5-cart-js handler'ından ÖNCE çalış
        document.addEventListener('click', function (ev) {
            // WhatsApp gönder butonu
            var waBtn = ev.target.closest('[data-asef-wa-quote]');
            if (waBtn) {
                var items = (window.AsefCart && window.AsefCart.get) ? window.AsefCart.get() : [];
                if (items.length === 0) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    openModal('Sepetinizde ürün bulunmuyor. Önce ürün ekleyin, sonra teklif gönderin.');
                    return;
                }
                var form = readForm();
                var errors = validateForm(form);
                if (errors.length > 0) {
                    ev.preventDefault();
                    ev.stopPropagation();
                    markInvalid(errors);
                    openModal();
                    // İlk boş alanı focus et
                    var firstErrorEl = $('[data-asef-cart-input="' + errors[0] + '"]');
                    if (firstErrorEl) setTimeout(function () { firstErrorEl.focus(); }, 400);
                    return;
                }
                // Form OK — v5-cart-js handler'ını atla, zenginleştirilmiş URL ile aç
                ev.preventDefault();
                ev.stopPropagation();
                markInvalid([]);
                var url = buildEnrichedWaUrl(items, form);
                window.open(url, '_blank', 'noopener');
                return;
            }

            // Modal kapatma
            var closeBtn = ev.target.closest('[data-asef-cart-modal-close]');
            if (closeBtn) { ev.preventDefault(); closeModal(); return; }

            // Backdrop tıklaması
            var backdrop = ev.target.closest('[data-asef-cart-modal]');
            if (backdrop && ev.target === backdrop) { closeModal(); return; }
        }, true); // capture:true — v5-cart-js'den önce yakala

        // ESC ile modal kapat
        document.addEventListener('keydown', function (ev) {
            if (ev.key === 'Escape') {
                var backdrop = $('[data-asef-cart-modal]');
                if (backdrop && backdrop.classList.contains('on')) closeModal();
            }
        });

        // Yazdıkça hata işaretini temizle
        document.addEventListener('input', function (ev) {
            var el = ev.target.closest('[data-asef-cart-input]');
            if (el && el.classList.contains('is-invalid')) {
                el.classList.remove('is-invalid');
                var hint = $('[data-asef-cart-form-hint]');
                if (hint) hint.textContent = '';
            }
        });

        // ============ CUSTOM SELECT (v5) ============
        function closeAllSelects(except) {
            $$('[data-asef-select].is-open').forEach(function (sel) {
                if (sel === except) return;
                sel.classList.remove('is-open');
                var trigger = sel.querySelector('[data-asef-select-trigger]');
                if (trigger) trigger.setAttribute('aria-expanded', 'false');
                var panel = sel.querySelector('[data-asef-select-panel]');
                if (panel) panel.setAttribute('hidden', '');
            });
        }

        document.addEventListener('click', function (ev) {
            // Trigger tıklama → aç/kapa
            var trigger = ev.target.closest('[data-asef-select-trigger]');
            if (trigger) {
                ev.preventDefault();
                var wrap = trigger.closest('[data-asef-select]');
                if (!wrap) return;
                var isOpen = wrap.classList.toggle('is-open');
                trigger.setAttribute('aria-expanded', String(isOpen));
                var panel = wrap.querySelector('[data-asef-select-panel]');
                if (panel) {
                    if (isOpen) panel.removeAttribute('hidden');
                    else panel.setAttribute('hidden', '');
                }
                if (isOpen) closeAllSelects(wrap);
                return;
            }
            // Option tıklama → değeri set et
            var opt = ev.target.closest('[data-asef-select-option]');
            if (opt) {
                ev.preventDefault();
                var wrap2 = opt.closest('[data-asef-select]');
                if (!wrap2) return;
                var value = opt.getAttribute('data-value') || '';
                var label = opt.textContent.trim();
                var hidden = wrap2.querySelector('input[type="hidden"]');
                var trg = wrap2.querySelector('[data-asef-select-trigger]');
                var lbl = wrap2.querySelector('[data-asef-select-label]');
                if (hidden) hidden.value = value;
                if (lbl) lbl.textContent = label;
                if (trg) {
                    trg.removeAttribute('data-empty');
                    trg.setAttribute('aria-expanded', 'false');
                }
                // Seçili durum işaretle
                $$('[data-asef-select-option]', wrap2).forEach(function (o) { o.classList.remove('is-selected'); });
                opt.classList.add('is-selected');
                // Panel kapat
                wrap2.classList.remove('is-open');
                var pnl = wrap2.querySelector('[data-asef-select-panel]');
                if (pnl) pnl.setAttribute('hidden', '');
                return;
            }
            // Dışına tıklama → tüm select'leri kapat
            closeAllSelects(null);
        });

        // ESC ile select kapat
        document.addEventListener('keydown', function (ev) {
            if (ev.key === 'Escape') closeAllSelects(null);
        });
    })();
    </script>
    @endpush
</x-shop::layouts>
