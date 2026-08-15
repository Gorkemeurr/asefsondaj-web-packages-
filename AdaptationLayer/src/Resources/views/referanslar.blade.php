{{-- Referanslar — /referanslar --}}
@php
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, referans projeleriniz hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $stats = [
        ['n' => '500+', 'l' => 'Tamamlanan Proje'],
        ['n' => '47',   'l' => 'İl Hizmet Alanı'],
        ['n' => '20+',  'l' => 'Yıl Tecrübe'],
        ['n' => '150+', 'l' => 'Çözüm Ortağı Firma'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Referanslar — Asef Sondaj" />
    <meta name="description" content="20 yıllık saha tecrübesiyle 500+ proje. Türkiye'nin dört bir yanında sondaj çözümleri." />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .rf-stats { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px; }
    @media (min-width: 768px) { .rf-stats { grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 120px; } }
    .rf-stat {
        background: var(--surface-alt); border-radius: 22px; padding: 32px 24px;
        text-align: center;
        transition: transform .28s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
    }
    .rf-stat:hover { transform: translateY(-2px); box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 12px 30px rgba(0,0,0,0.08); }
    .rf-stat-n { display: block; font-size: clamp(38px, 5vw, 56px); font-weight: 700; letter-spacing: -0.03em; color: var(--primary); line-height: 1; margin-bottom: 8px; }
    .rf-stat-l { display: block; font-size: 13px; color: var(--gray-secondary); letter-spacing: 0.02em; }

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
                <p>Türkiye'nin dört bir yanında tamamladığımız sondaj projeleri; kalıcı iş birlikleri ve güven ile büyüyor.</p>
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
