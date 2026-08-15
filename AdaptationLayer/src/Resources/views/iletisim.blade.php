{{-- İletişim — /iletisim --}}
@php
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, iletişim sayfasından bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));
@endphp

@push('meta')
    <meta name="title" content="İletişim — Asef Sondaj" />
    <meta name="description" content="Asef Sondaj'a WhatsApp, telefon, e-posta ile ulaşın. Duaçınarı Mah. 1. Özgünay Sk No:10, Yıldırım/Bursa" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .ct-grid { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: 1fr; gap: 16px; }
    @media (min-width: 768px) { .ct-grid { grid-template-columns: repeat(3, 1fr); margin-bottom: 120px; } }
    .ct-card {
        background: var(--surface-alt); border-radius: 20px; padding: 28px 24px 30px;
        display: flex; flex-direction: column; gap: 12px;
        transition: transform .28s cubic-bezier(0.16,1,0.3,1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
    }
    .ct-card:hover { transform: translateY(-3px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 12px 32px rgba(0,0,0,0.08); }
    .ct-icon { width: 44px; height: 44px; border-radius: 14px; background: white; display: grid; place-items: center; color: var(--link-blue); box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 10px rgba(0,102,204,0.08); }
    .ct-icon svg { width: 22px; height: 22px; }
    .ct-label { font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--gray-secondary); }
    .ct-value { font-size: 17px; font-weight: 600; color: var(--primary); letter-spacing: -0.01em; }
    .ct-value a { transition: color .15s; }
    .ct-value a:hover { color: var(--link-blue); }
    .ct-sub { font-size: 13px; color: var(--secondary); }

    .ct-map-wrap { max-width: 1440px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .ct-map-wrap { padding: 0 32px; margin-bottom: 120px; } }
    .ct-map { width: 100%; height: 420px; border-radius: 22px; overflow: hidden; background: var(--surface-alt); border: 0; box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.04); }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>İletişim — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">İLETİŞİM</div>
                <h1>Sizinle konuşmak için buradayız.</h1>
                <p>Delik çapı, formasyon, çalışma basıncı — projeniz için doğru ekipmanı birlikte belirleyelim. WhatsApp en hızlı yol.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                </div>
            </section>

            <section class="ct-grid">
                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="ct-card">
                    <div class="ct-icon"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.06 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.13 1.6 5.93L0 24l6.34-1.67a11.87 11.87 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.45-8.41zM12.07 21.8h-.01a9.9 9.9 0 0 1-5.05-1.38l-.36-.22-3.76.99 1-3.67-.24-.38a9.88 9.88 0 0 1-1.51-5.24c0-5.46 4.44-9.9 9.91-9.9 2.64 0 5.13 1.03 7 2.9a9.83 9.83 0 0 1 2.9 7c0 5.46-4.44 9.9-9.88 9.9z"/></svg></div>
                    <div><div class="ct-label">WHATSAPP</div><div class="ct-value">+90 532 054 29 75</div><div class="ct-sub">Anında yanıt, teknik danışmanlık</div></div>
                </a>
                <a href="tel:+905320542975" class="ct-card">
                    <div class="ct-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13 1 .37 1.95.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.86.33 1.81.57 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                    <div><div class="ct-label">TELEFON</div><div class="ct-value">+90 532 054 29 75</div><div class="ct-sub">Hafta içi 09:00 – 18:00</div></div>
                </a>
                <a href="mailto:iletisim@asefsondaj.com" class="ct-card">
                    <div class="ct-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="3"/><path d="m3 7 9 6 9-6"/></svg></div>
                    <div><div class="ct-label">E-POSTA</div><div class="ct-value">iletisim@asefsondaj.com</div><div class="ct-sub">Kurumsal iletişim</div></div>
                </a>
                <a href="mailto:destek@asefsondaj.com" class="ct-card">
                    <div class="ct-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
                    <div><div class="ct-label">TEKNİK DESTEK</div><div class="ct-value">destek@asefsondaj.com</div><div class="ct-sub">Ürün ve teknik sorular</div></div>
                </a>
                <div class="ct-card">
                    <div class="ct-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
                    <div><div class="ct-label">ADRES</div><div class="ct-value">Duaçınarı Mah.</div><div class="ct-sub">1. Özgünay Sk No:10<br>Yıldırım / Bursa</div></div>
                </div>
                <a href="https://instagram.com/asefsondajj" target="_blank" rel="noopener" class="ct-card">
                    <div class="ct-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.6" fill="currentColor"/></svg></div>
                    <div><div class="ct-label">INSTAGRAM</div><div class="ct-value">@asefsondajj</div><div class="ct-sub">Saha fotoğrafları ve içerikler</div></div>
                </a>
            </section>

            <div class="ct-map-wrap">
                <iframe class="ct-map" src="https://www.google.com/maps?q=Dua%C3%A7%C4%B1nar%C4%B1%20Mah.%201.%20%C3%96zg%C3%BCnay%20Sk%20No%3A10%20Y%C4%B1ld%C4%B1r%C4%B1m%20Bursa&output=embed" loading="lazy" title="Asef Sondaj konumu" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">HEMEN İLETİŞİM</div>
                    <h2>Teklif için tek tık.</h2>
                    <p>Katalogdan ürünlerinizi seçin, WhatsApp'tan liste olarak bize gönderin. Ekibimiz en kısa sürede fiyat ve teslim süresi ile döner.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $catalogUrl }}" class="asef-cta-pill primary">Kataloga Git</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">WhatsApp'tan Yaz <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
