{{-- Kurumsal Landing — /kurumsal --}}
@php
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, kurumsal bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $panels = [
        [
            'url'   => url('hakkimizda'),
            'label' => '01',
            'title' => 'Hakkımızda',
            'desc'  => 'Yirmi yıllık saha, tek bir söz: güven. Firma hikayemiz, değerlerimiz ve tarihçemiz.',
            'img'   => 'asef-hero-rig.jpg',
            'cta'   => 'Firmayı tanı',
        ],
        [
            'url'   => url('sondaj-makinalarimiz'),
            'label' => '02',
            'title' => 'Sondaj Makinalarımız',
            'desc'  => 'Yerüstü, yeraltı, su ve zemin etüd operasyonları için hazır makine ailemiz.',
            'img'   => 'drilling-hero.jpg',
            'cta'   => 'Makineleri incele',
        ],
        [
            'url'   => url('hizmetlerimiz'),
            'label' => '03',
            'title' => 'Hizmetlerimiz',
            'desc'  => 'Teknik danışmanlık, proje bazlı tedarik ve satış sonrası destek — çözüm odaklı.',
            'img'   => 'asef-macro-thread.jpg',
            'cta'   => 'Hizmetlerimiz',
        ],
        [
            'url'   => url('referanslar'),
            'label' => '04',
            'title' => 'Referanslar',
            'desc'  => '20 yıllık saha tecrübesiyle 500+ proje. Türkiye\'nin dört bir yanında.',
            'img'   => 'asef-hero-equipment.jpg',
            'cta'   => 'Projelere göz at',
        ],
    ];

    $stats = [
        ['n' => '20+',  'l' => 'Yıl Saha Tecrübesi'],
        ['n' => '500+', 'l' => 'Tamamlanan Proje'],
        ['n' => '81',   'l' => 'İl Hizmet Kapsamı'],
        ['n' => '150+', 'l' => 'Çözüm Ortağı Firma'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Kurumsal — Asef Sondaj" />
    <meta name="description" content="Asef Sondaj kurumsal — Hakkımızda, Sondaj Makinalarımız, Hizmetlerimiz ve Referanslar." />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    /* Panels */
    .kr-panels-wrap { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .kr-panels-wrap { margin-bottom: 120px; } }
    .kr-panels {
        display: grid; grid-template-columns: 1fr; gap: 20px;
    }
    @media (min-width: 768px) { .kr-panels { grid-template-columns: 1fr 1fr; gap: 24px; } }
    .kr-panel {
        background: var(--surface-alt); border-radius: 24px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 14px rgba(0,0,0,0.03);
    }
    .kr-panel:hover { transform: translateY(-3px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 14px 34px rgba(0,0,0,0.08); }
    .kr-panel-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .kr-panel-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .kr-panel:hover .kr-panel-media img { transform: scale(1.04); }
    .kr-panel-body { padding: 26px 28px 28px; display: flex; flex-direction: column; gap: 10px; }
    .kr-panel-num { font-family: "SF Mono", ui-monospace, Menlo, monospace; font-size: 12px; letter-spacing: 0.12em; color: var(--gray-secondary); }
    .kr-panel-title { font-size: 24px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .kr-panel-desc { font-size: 15px; color: var(--secondary); line-height: 1.55; }
    .kr-panel-cta { color: var(--link-blue); font-size: 14px; font-weight: 500; margin-top: 4px; }

    /* Stats bento */
    .kr-stats-wrap { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .kr-stats-wrap { margin-bottom: 120px; } }
    .kr-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
    @media (min-width: 768px) { .kr-stats { grid-template-columns: repeat(4, 1fr); gap: 18px; } }
    .kr-stat {
        position: relative; overflow: hidden;
        background: var(--surface-alt); border-radius: 24px;
        padding: 36px 26px 30px;
        transition: transform .32s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.95) inset,
            0 -1px 0 rgba(0,0,0,0.04) inset,
            0 4px 14px rgba(0,0,0,0.04);
    }
    .kr-stat::before {
        content: ""; position: absolute; top: 0; right: 0; width: 60%; height: 60%;
        background: radial-gradient(circle at top right, rgba(0,102,204,0.12), transparent 60%);
    }
    .kr-stat:hover { transform: translateY(-4px); }
    .kr-stat-n { display: block; font-size: clamp(24px, 2.6vw, 34px); font-weight: 600; letter-spacing: -0.02em; color: var(--primary); margin-bottom: 8px; }
    .kr-stat-l { display: block; font-size: 13px; color: var(--gray-secondary); }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Kurumsal — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            {{-- HERO --}}
            <section class="asef-hero">
                <div class="asef-label-caps">KURUMSAL</div>
                <h1>Sahada güvenilir. Kurumsal duruşta ciddi.</h1>
                <p>Firma hikayemizden hizmetlerimize, sondaj makinalarımızdan referans projelerimize — Asef Sondaj'ın tüm kurumsal sayfalarına buradan ulaşın.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ url('hakkimizda') }}" class="asef-cta-pill primary">Hakkımızda</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">Uzmana Sor <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            {{-- STATS --}}
            <section class="kr-stats-wrap">
                <div class="kr-stats">
                    @foreach ($stats as $s)
                        <div class="kr-stat"><span class="kr-stat-n">{{ $s['n'] }}</span><span class="kr-stat-l">{{ $s['l'] }}</span></div>
                    @endforeach
                </div>
            </section>

            {{-- PANELS (4 sub pages) --}}
            <section class="kr-panels-wrap">
                <div class="kr-panels">
                    @foreach ($panels as $p)
                        <a href="{{ $p['url'] }}" class="kr-panel">
                            <div class="kr-panel-media"><img src="{{ $asefUrl($p['img']) }}" alt="{{ $p['title'] }}" loading="lazy"></div>
                            <div class="kr-panel-body">
                                <span class="kr-panel-num">{{ $p['label'] }}</span>
                                <div class="kr-panel-title">{{ $p['title'] }}</div>
                                <p class="kr-panel-desc">{{ $p['desc'] }}</p>
                                <span class="kr-panel-cta">{{ $p['cta'] }} ›</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- CTA --}}
            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">İLETİŞİM</div>
                    <h2>Projenizi birlikte planlayalım.</h2>
                    <p>Sondaj operasyonlarınıza özel çözüm için ekibimiz hazır.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
