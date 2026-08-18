{{-- Video Galerisi — /blog/{urun-tanitim-videolari|saha-uygulamalari|teknik-anlatimlar}
     İÇERİK HAZIRLANIYOR. Sahte video listesi göstermeyiz. --}}
@php
    $waMsgMap = [
        'urun-tanitim-videolari' => 'Merhaba, ürün tanıtım videolarınız hakkında bilgi almak istiyorum.',
        'saha-uygulamalari'      => 'Merhaba, saha uygulama videolarınız hakkında bilgi almak istiyorum.',
        'teknik-anlatimlar'      => 'Merhaba, teknik anlatım videolarınız hakkında bilgi almak istiyorum.',
    ];
    $galleries = [
        'urun-tanitim-videolari' => [
            'title' => 'Ürün Tanıtım Videoları',
            'lede'  => 'Karotiyer sistemleri, karot bit\'ler, tijler, kaya delgi ekipmanları ve pörtkron sistemlerinin yakın çekim tanıtımları.',
            'crumb' => 'Video Galerisi', 'crumbUrl' => url('blog/video'), 'hub' => 'Video',
        ],
        'saha-uygulamalari' => [
            'title' => 'Saha Uygulamaları',
            'lede'  => 'Gerçek operasyondan görüntüler — kuyu açımı, ekipman montajı, sahada işleyiş.',
            'crumb' => 'Video Galerisi', 'crumbUrl' => url('blog/video'), 'hub' => 'Video',
        ],
        'teknik-anlatimlar' => [
            'title' => 'Teknik Anlatımlar',
            'lede'  => 'Bakım prosedürleri, arıza teşhisi ve doğru kullanım için mühendis anlatımları.',
            'crumb' => 'Video Galerisi', 'crumbUrl' => url('blog/video'), 'hub' => 'Video',
        ],
    ];
    $meta = $galleries[$slug] ?? $galleries['urun-tanitim-videolari'];
    $waLink     = asef_wa_link($waMsgMap[$slug] ?? 'Merhaba, videolarınız hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
@endphp

@push('meta')
    <meta name="title" content="{{ $meta['title'] }} — Asef Sondaj" />
    <meta name="description" content="{{ $meta['lede'] }}" />
    <meta name="robots" content="noindex" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .gv-crumb { max-width: 1024px; margin: 0 auto 8px; padding: 0 20px; font-size: 12px; color: var(--gray-secondary); letter-spacing: 0.06em; }
    .gv-crumb a { color: var(--link-blue); }

    .gv-empty {
        max-width: 720px; margin: 40px auto 120px; padding: 0 20px;
    }
    .gv-empty-card {
        background: var(--surface-alt); border-radius: 28px;
        padding: 60px 40px; text-align: center;
        box-shadow: 0 1px 0 rgba(255,255,255,0.95) inset, 0 6px 22px rgba(0,0,0,0.05);
    }
    .gv-empty-icon-wrap {
        width: 72px; height: 72px; border-radius: 50%;
        background: #EAF1F8; margin: 0 auto 20px;
        display: inline-flex; align-items: center; justify-content: center;
        color: #0066CC;
    }
    .gv-empty-icon-wrap svg { width: 32px; height: 32px; }
    .gv-empty-card h3 { font-size: clamp(20px, 2.4vw, 26px); font-weight: 600; letter-spacing: -0.01em; color: var(--primary); margin-bottom: 12px; }
    .gv-empty-card p { font-size: 15px; color: var(--secondary); line-height: 1.6; margin-bottom: 24px; max-width: 480px; margin-left: auto; margin-right: auto; }
    .gv-empty-ctas { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>{{ $meta['title'] }} — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero" style="padding-bottom: 20px;">
                <div class="asef-label-caps">{{ $meta['hub'] }} · GALERİ</div>
                <h1>{{ $meta['title'] }}</h1>
                <p>{{ $meta['lede'] }}</p>
            </section>

            <div class="gv-crumb">
                <a href="{{ $meta['crumbUrl'] }}">‹ {{ $meta['crumb'] }}</a>
            </div>

            <section class="gv-empty">
                <div class="gv-empty-card">
                    <span class="gv-empty-icon-wrap" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"/><polygon points="10 9 15 12 10 15"/></svg>
                    </span>
                    <h3>Videolar hazırlanıyor.</h3>
                    <p>Sahadan kaydedilen orijinal videoları düzenli olarak buraya ekliyoruz. Belirli bir konuda video ihtiyacınız varsa WhatsApp üzerinden bize iletin — mümkünse özel çekim yaparız.</p>
                    <div class="gv-empty-ctas">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Talep Et</a>
                        <a href="{{ url('blog/video') }}" class="asef-cta-pill ghost">Diğer Video Kategorileri</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
