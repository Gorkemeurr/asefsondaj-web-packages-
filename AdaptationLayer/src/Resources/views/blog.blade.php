{{-- Blog — /blog --}}
@php
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, blog içeriği hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $sections = [
        ['url' => route('shop.asef.blog', ['slug' => 'tumu']),           'label' => 'YAZILAR',   'title' => 'Tüm Bloglar',       'desc' => 'Sektör içgörüleri, ekipman rehberleri ve vaka çalışmaları.',    'img' => 'asef-macro-thread.jpg'],
        ['url' => route('shop.asef.blog', ['slug' => 'fotograf']),       'label' => 'FOTOĞRAF',  'title' => 'Fotoğraf Galerisi', 'desc' => 'Sahadan, ekipmanlarımızdan ve projelerimizden fotoğraflar.',    'img' => 'asef-hero-rig.jpg'],
        ['url' => route('shop.asef.blog', ['slug' => 'video']),          'label' => 'VİDEO',     'title' => 'Video Galerisi',    'desc' => 'Ürün tanıtımları, saha uygulamaları ve teknik anlatımlar.',      'img' => 'drilling-hero.jpg'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Blog — Asef Sondaj" />
    <meta name="description" content="Sondaj sektörü içgörüleri, ekipman rehberleri, saha fotoğrafları ve video anlatımlar." />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .bg-grid { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 768px) { .bg-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 120px; } }
    .bg-card {
        background: var(--surface-alt); border-radius: 24px; overflow: hidden;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s;
        display: flex; flex-direction: column;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 14px rgba(0,0,0,0.04);
    }
    .bg-card:hover { transform: translateY(-3px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 14px 34px rgba(0,0,0,0.09); }
    .bg-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .bg-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .bg-card:hover .bg-media img { transform: scale(1.05); }
    .bg-body { padding: 20px 22px 22px; display: flex; flex-direction: column; gap: 6px; flex: 1; }
    .bg-label { font-size: 11px; letter-spacing: 0.08em; color: var(--gray-secondary); }
    .bg-title { font-size: 20px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .bg-desc { font-size: 14px; color: var(--secondary); line-height: 1.5; flex: 1; }
    .bg-link { margin-top: 6px; font-size: 13px; color: var(--link-blue); font-weight: 500; }

    .bg-empty { max-width: 720px; margin: 0 auto 80px; padding: 60px 24px; text-align: center; background: var(--surface-alt); border-radius: 22px; }
    .bg-empty .asef-label-caps { margin-bottom: 12px; }
    .bg-empty h3 { font-size: 22px; font-weight: 600; color: var(--primary); margin-bottom: 8px; }
    .bg-empty p { font-size: 15px; color: var(--secondary); max-width: 480px; margin: 0 auto 20px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Blog — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">BLOG + GALERİLER</div>
                <h1>Sahadan, ekipmandan, sektörden.</h1>
                <p>Sondaj dünyasından içgörüler, teknik anlatımlar ve saha kareleri.</p>
            </section>

            <section class="bg-grid">
                @foreach ($sections as $s)
                    <a href="{{ $s['url'] }}" class="bg-card">
                        <div class="bg-media"><img src="{{ $asefUrl($s['img']) }}" alt="{{ $s['title'] }}" loading="lazy"></div>
                        <div class="bg-body">
                            <span class="bg-label">{{ $s['label'] }}</span>
                            <div class="bg-title">{{ $s['title'] }}</div>
                            <p class="bg-desc">{{ $s['desc'] }}</p>
                            <span class="bg-link">Aç ›</span>
                        </div>
                    </a>
                @endforeach
            </section>

            <div class="bg-empty">
                <div class="asef-label-caps">İÇERİK PROGRAMI</div>
                <h3>İlk yazılarımız yolda.</h3>
                <p>Bu sayfayı düzenli olarak güncelleyeceğiz. Belirli bir konu için soru veya öneriniz varsa, WhatsApp'tan iletebilirsiniz.</p>
                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Öneride Bulun</a>
            </div>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
