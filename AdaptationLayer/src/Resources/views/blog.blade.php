{{-- Blog Landing — /blog --}}
@php
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, blog içeriği hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Featured post (öne çıkan)
    $featured = [
        'cat'   => 'EKİPMAN REHBERİ',
        'title' => 'Sondaj operasyonlarında ekipman seçimi rehberi.',
        'excerpt' => 'Delik çapı, formasyon karakteri, çalışma basıncı ve bağlantı standardı — doğru ekipmanı seçerken göz önünde bulundurmanız gereken kritik parametrelerin tam listesi.',
        'date'  => '12 Ağustos 2026',
        'read'  => '6 dakika okuma',
        'img'   => 'asef-hero-rig.jpg',
        'slug'  => 'ekipman-secim-rehberi',
    ];

    // Post list
    $posts = [
        ['slug' => 'dth-cekic-bakim',      'cat' => 'EKİPMAN REHBERİ',   'title' => 'DTH çekiç bakımı: uzun ömür için 5 kritik nokta',      'excerpt' => 'Sızdırmazlık, yağlama, buton kontrolü, torque değerleri ve saha temizliği.', 'date' => '10 Ağustos 2026', 'read' => '5 dk', 'img' => 'dth-hammer.jpg'],
        ['slug' => 'sondaj-tiji-baglanti', 'cat' => 'TEKNİK İPUÇLARI',   'title' => 'Sondaj tiji seçimi ve bağlantı standartları',           'excerpt' => 'API IF, API REG, DCDMA — hangi standart hangi operasyona uygun.',              'date' => '05 Ağustos 2026', 'read' => '4 dk', 'img' => 'drill-rods.jpg'],
        ['slug' => 'camur-pompa-verim',    'cat' => 'TEKNİK',            'title' => 'Çamur pompası performansı ve verim optimizasyonu',     'excerpt' => 'Triplex piston hareket eğrisi, debi-basınç dengesi, aşınma yönetimi.',        'date' => '28 Temmuz 2026', 'read' => '7 dk', 'img' => 'mud-pump.jpg'],
        ['slug' => 'karot-hatalari',       'cat' => 'VAKA ÇALIŞMASI',    'title' => 'Karot alma operasyonlarında yaygın hatalar',            'excerpt' => 'Doğru derinlikte doğru karot — sahadan 4 gerçek vaka üzerinden ders.',       'date' => '22 Temmuz 2026', 'read' => '6 dk', 'img' => 'asef-macro-diamond.jpg'],
        ['slug' => 'su-sondaji-mevzuat',   'cat' => 'SEKTÖR REHBERİ',    'title' => 'Türkiye\'de su sondajı: yasal süreç ve izinler',        'excerpt' => 'DSİ izin başvurusu, hidrojeoloji raporu, ruhsatlandırma adım adım.',           'date' => '18 Temmuz 2026', 'read' => '8 dk', 'img' => 'drilling-hero.jpg'],
        ['slug' => 'yerustu-yeralti',      'cat' => 'SEKTÖR ANALİZ',     'title' => 'Yerüstü vs yeraltı sondaj: proje bazlı karar',          'excerpt' => 'Formasyon derinliği, saha erişimi, maliyet — hangi tip operasyonunuza uygun?', 'date' => '14 Temmuz 2026', 'read' => '5 dk', 'img' => 'asef-hero-equipment.jpg'],
    ];

    $categories = ['Tümü', 'Sondaj Sektörü', 'Ekipman Rehberi', 'Vaka Çalışmaları', 'Teknik İpuçları'];

    // Galleries preview cards
    $galleries = [
        ['url' => url('blog/fotograf'), 'label' => 'FOTOĞRAF', 'title' => 'Sahadan Görüntüler', 'desc' => 'Türkiye\'nin dört bir yanından sondaj sahası fotoğrafları.',  'img' => 'asef-macro-thread.jpg'],
        ['url' => url('blog/video'),    'label' => 'VİDEO',    'title' => 'Uygulama Videoları', 'desc' => 'Ürün tanıtımı, saha uygulaması ve teknik anlatım videoları.', 'img' => 'asef-macro-valve.jpg'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Blog — Asef Sondaj" />
    <meta name="description" content="Sondaj sektörü içgörüleri, ekipman rehberleri, vaka çalışmaları ve teknik anlatımlar." />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    /* Featured */
    .bg-featured-wrap { max-width: 1440px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .bg-featured-wrap { padding: 0 32px; margin-bottom: 100px; } }
    .bg-featured {
        display: grid; grid-template-columns: 1fr; gap: 24px; align-items: center;
        border-radius: 28px; overflow: hidden;
        background: var(--surface-alt);
        transition: background .3s;
    }
    .bg-featured:hover { background: #EEEEF0; }
    @media (min-width: 900px) { .bg-featured { grid-template-columns: 1.1fr 1fr; gap: 0; } }
    .bg-featured-media {
        aspect-ratio: 16/10;
        overflow: hidden;
        background: #14161a;
    }
    .bg-featured-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s; }
    .bg-featured:hover .bg-featured-media img { transform: scale(1.04); }
    .bg-featured-body { padding: 32px; display: flex; flex-direction: column; gap: 16px; }
    @media (min-width: 900px) { .bg-featured-body { padding: 56px 48px; } }
    .bg-featured-cat { font-size: 12px; letter-spacing: 0.1em; color: var(--link-blue); font-weight: 500; }
    .bg-featured-title { font-size: clamp(24px, 3vw, 36px); font-weight: 600; letter-spacing: -0.02em; line-height: 1.15; color: var(--primary); }
    .bg-featured-excerpt { font-size: 16px; color: var(--secondary); line-height: 1.6; }
    .bg-featured-meta { display: flex; gap: 16px; align-items: center; font-size: 13px; color: var(--gray-secondary); }
    .bg-featured-meta span { display: flex; align-items: center; gap: 6px; }
    .bg-featured-link { color: var(--link-blue); font-size: 14px; font-weight: 500; }

    /* Chips (blog) */
    .bg-chips-row {
        max-width: 1024px; margin: 0 auto 32px; padding: 0 20px;
        display: flex; gap: 10px; justify-content: center; flex-wrap: wrap;
    }
    .bg-chip {
        display: inline-flex; align-items: center;
        padding: 10px 20px; border-radius: 999px;
        font-size: 13px; font-weight: 500;
        border: 1px solid var(--outline);
        background: white; color: var(--on-surface);
        transition: all .2s; cursor: pointer;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 1px 2px rgba(0,0,0,0.03);
    }
    .bg-chip:hover { border-color: var(--primary); }
    .bg-chip.active { background: var(--primary); color: white; border-color: var(--primary); box-shadow: 0 4px 12px rgba(0,0,0,0.14); }

    /* Post grid */
    .bg-posts-wrap { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .bg-posts-wrap { margin-bottom: 120px; } }
    .bg-posts-head { display: flex; justify-content: space-between; align-items: baseline; margin-bottom: 24px; }
    .bg-posts-head h2 { font-size: clamp(24px, 3vw, 32px); font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .bg-all-link { color: var(--link-blue); font-size: 14px; font-weight: 500; }
    .bg-all-link:hover { opacity: 0.7; }
    .bg-posts-grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 640px) { .bg-posts-grid { grid-template-columns: 1fr 1fr; } }
    @media (min-width: 900px) { .bg-posts-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; } }
    .bg-post {
        background: var(--surface-alt); border-radius: 20px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
    }
    .bg-post:hover { transform: translateY(-3px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 14px 30px rgba(0,0,0,0.08); }
    .bg-post-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .bg-post-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .bg-post:hover .bg-post-media img { transform: scale(1.05); }
    .bg-post-body { padding: 20px 22px 22px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
    .bg-post-cat { font-size: 11px; letter-spacing: 0.1em; color: var(--link-blue); font-weight: 500; }
    .bg-post-title { font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); line-height: 1.3; }
    .bg-post-excerpt { font-size: 14px; color: var(--secondary); line-height: 1.5; flex: 1; }
    .bg-post-meta { display: flex; gap: 14px; font-size: 12px; color: var(--gray-secondary); margin-top: 4px; }

    /* Galleries */
    .bg-galleries { display: grid; grid-template-columns: 1fr; gap: 20px; max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 640px) { .bg-galleries { grid-template-columns: 1fr 1fr; } }
    @media (min-width: 768px) { .bg-galleries { margin-bottom: 120px; } }
    .bg-gallery {
        position: relative; aspect-ratio: 3/2;
        border-radius: 24px; overflow: hidden;
        background: #14161a;
        transition: transform .3s;
    }
    .bg-gallery:hover { transform: translateY(-3px); }
    .bg-gallery img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s; }
    .bg-gallery:hover img { transform: scale(1.06); }
    .bg-gallery::after {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.3) 50%, transparent 100%);
    }
    .bg-gallery-body {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
        padding: 24px 28px; color: white;
    }
    .bg-gallery-label { font-size: 12px; letter-spacing: 0.1em; color: rgba(255,255,255,0.8); font-weight: 500; margin-bottom: 6px; }
    .bg-gallery-title { font-size: 22px; font-weight: 600; letter-spacing: -0.01em; margin-bottom: 4px; }
    .bg-gallery-desc { font-size: 14px; color: rgba(255,255,255,0.85); line-height: 1.5; max-width: 400px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Blog — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO --}}
            <section class="asef-hero">
                <div class="asef-label-caps">BLOG</div>
                <h1>Sahadan, ekipmandan, sektörden.</h1>
                <p>Sondaj sektöründen içgörüler, ekipman rehberleri, vaka çalışmaları ve teknik anlatımlar — deneyimden yazılmış.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ url('tum-bloglar') }}" class="asef-cta-pill primary">Tüm Yazılar</a>
                    <a href="{{ url('blog/fotograf') }}" class="asef-cta-pill ghost">Galeriler <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            {{-- FEATURED POST --}}
            <div class="bg-featured-wrap">
                <a href="{{ url('blog/' . $featured['slug']) }}" style="text-decoration:none;color:inherit;display:block;">
                    <div class="bg-featured">
                        <div class="bg-featured-media"><img src="{{ $asefUrl($featured['img']) }}" alt="{{ $featured['title'] }}"></div>
                        <div class="bg-featured-body">
                            <span class="bg-featured-cat">ÖNE ÇIKAN · {{ $featured['cat'] }}</span>
                            <h2 class="bg-featured-title">{{ $featured['title'] }}</h2>
                            <p class="bg-featured-excerpt">{{ $featured['excerpt'] }}</p>
                            <div class="bg-featured-meta">
                                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>{{ $featured['date'] }}</span>
                                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $featured['read'] }}</span>
                            </div>
                            <span class="bg-featured-link">Yazıyı oku ›</span>
                        </div>
                    </div>
                </a>
            </div>

            {{-- CHIPS --}}
            <div class="bg-chips-row">
                @foreach ($categories as $i => $c)
                    <span class="bg-chip {{ $i === 0 ? 'active' : '' }}">{{ $c }}</span>
                @endforeach
            </div>

            {{-- POSTS --}}
            <section class="bg-posts-wrap">
                <div class="bg-posts-head">
                    <h2>Son yazılar.</h2>
                    <a href="{{ url('tum-bloglar') }}" class="bg-all-link">Tüm yazılar ›</a>
                </div>
                <div class="bg-posts-grid">
                    @foreach ($posts as $p)
                        <a href="{{ url('blog/' . $p['slug']) }}" class="bg-post">
                            <div class="bg-post-media"><img src="{{ $asefUrl($p['img']) }}" alt="{{ $p['title'] }}" loading="lazy"></div>
                            <div class="bg-post-body">
                                <span class="bg-post-cat">{{ $p['cat'] }}</span>
                                <div class="bg-post-title">{{ $p['title'] }}</div>
                                <p class="bg-post-excerpt">{{ $p['excerpt'] }}</p>
                                <div class="bg-post-meta">
                                    <span>{{ $p['date'] }}</span>
                                    <span>· {{ $p['read'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- GALLERIES --}}
            <section class="bg-galleries">
                @foreach ($galleries as $g)
                    <a href="{{ $g['url'] }}" class="bg-gallery">
                        <img src="{{ $asefUrl($g['img']) }}" alt="{{ $g['title'] }}" loading="lazy">
                        <div class="bg-gallery-body">
                            <div class="bg-gallery-label">{{ $g['label'] }}</div>
                            <div class="bg-gallery-title">{{ $g['title'] }}</div>
                            <p class="bg-gallery-desc">{{ $g['desc'] }}</p>
                        </div>
                    </a>
                @endforeach
            </section>

            {{-- CTA --}}
            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">TÜM YAZILAR</div>
                    <h2>50+ blog yazısı, tek arşivde.</h2>
                    <p>Sondaj sektöründen bilgi arıyorsan, tüm arşive göz atabilir veya doğrudan teknik ekibimizle iletişime geçebilirsin.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ url('tum-bloglar') }}" class="asef-cta-pill primary">Tüm Yazılara Git</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">Uzmana Sor <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>

        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
