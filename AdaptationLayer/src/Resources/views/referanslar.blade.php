{{-- Referanslar — /referanslar --}}
@php
    $waLink = asef_wa_link('Merhaba, referans projeleriniz hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $stats = [
        ['n' => '500+', 'l' => 'Tamamlanan Proje'],
        ['n' => '81',   'l' => 'İl Hizmet Kapsamı'],
        ['n' => '20+',  'l' => 'Yıl Tecrübe'],
        ['n' => '150+', 'l' => 'Çözüm Ortağı Firma'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Referanslar — 500+ Sondaj Projesi | Asef Sondaj Türkiye" />
    <meta name="description" content="20 yıllık saha tecrübesiyle 500+ tamamlanan sondaj projesi. Türkiye'nin 81 ilinde maden, su, jeotermal ve jeoteknik sondaj operasyonları için ekipman ve teknik çözüm." />
    <meta name="keywords" content="Asef Sondaj referanslar, sondaj projeleri, maden sondaj referansları, su sondaj projeleri, jeotermal sondaj referansları" />
    <link rel="canonical" href="{{ url('referanslar') }}" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .rf-stats { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    @media (min-width: 768px) { .rf-stats { grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 120px; } }
    .rf-stat {
        position: relative; overflow: hidden;
        background: var(--surface-alt); border-radius: 24px;
        padding: 36px 26px 30px;
        transition: transform .32s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.95) inset,
            0 -1px 0 rgba(0,0,0,0.04) inset,
            0 4px 14px rgba(0,0,0,0.04);
    }
    .rf-stat::before {
        content: ""; position: absolute; top: 0; right: 0; width: 60%; height: 60%;
        background: radial-gradient(circle at top right, rgba(0,102,204,0.12), transparent 60%);
        pointer-events: none;
    }
    .rf-stat:hover {
        transform: translateY(-4px);
        box-shadow:
            0 1px 0 rgba(255,255,255,1) inset,
            0 -1px 0 rgba(0,0,0,0.05) inset,
            0 16px 40px rgba(0,0,0,0.1);
    }
    .rf-stat-n { display: block; font-size: clamp(24px, 2.6vw, 34px); font-weight: 600; letter-spacing: -0.02em; line-height: 1; color: var(--primary); margin-bottom: 8px; }
    .rf-stat-l { display: block; font-size: 13px; color: var(--gray-secondary); letter-spacing: 0.02em; line-height: 1.4; }

    .rf-placeholder {
        max-width: 1024px; margin: 0 auto 80px; padding: 40px 24px;
        background: var(--surface-alt); border-radius: 22px;
        text-align: center;
    }
    .rf-placeholder .asef-label-caps { margin-bottom: 12px; }
    .rf-placeholder h3 { font-size: 22px; font-weight: 600; color: var(--primary); margin-bottom: 8px; }
    .rf-placeholder p { font-size: 15px; color: var(--secondary); max-width: 480px; margin: 0 auto 20px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Referanslar — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">REFERANSLAR</div>
                <h1>Yirmi yılın izleri, sahada.</h1>
                <p>{{ asef_setting('referanslar_hero_desc', "Türkiye'nin dört bir yanında tamamladığımız sondaj projeleri; kalıcı iş birlikleri ve güven ile büyüyor.") }}</p>
            </section>

            <section class="rf-stats">
                @foreach ($stats as $s)
                    <div class="rf-stat"><span class="rf-stat-n">{{ $s['n'] }}</span><span class="rf-stat-l">{{ $s['l'] }}</span></div>
                @endforeach
            </section>

            <section class="rf-placeholder">
                <div class="asef-label-caps">PROJE GALERİSİ</div>
                <h3>Detaylı vaka çalışmaları yakında.</h3>
                <p>Tamamladığımız projelerin detay sayfaları hazırlanıyor. O zamana kadar spesifik bir proje veya sektör referansı için doğrudan bize ulaşabilirsiniz.</p>
                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Referans Talep Et</a>
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">SİZ DE KATILIN</div>
                    <h2>Bir sonraki referansımız sizinle.</h2>
                    <p>Projenizi birlikte planlayalım; başarınız bizim de referansımız olsun.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="{{ $catalogUrl }}" class="asef-cta-pill ghost">Ürünleri Keşfet <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
