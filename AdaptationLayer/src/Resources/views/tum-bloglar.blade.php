{{-- Tüm Bloglar (arşiv) — /tum-bloglar --}}
@php
    $waLink       = asef_wa_link('Merhaba, blog içeriği hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $posts = [
        ['slug' => 'ekipman-secim-rehberi', 'cat' => 'Ekipman Rehberi', 'title' => 'Sondaj operasyonlarında ekipman seçimi rehberi', 'excerpt' => 'Delik çapı, formasyon karakteri, çalışma basıncı ve bağlantı standardı — kritik parametrelerin tam listesi.', 'date' => '12 Ağustos 2026', 'read' => '6 dk', 'img' => 'asef-hero-rig.jpg'],
        ['slug' => 'dth-cekic-bakim',      'cat' => 'Ekipman Rehberi', 'title' => 'DTH çekiç bakımı: uzun ömür için 5 kritik nokta',   'excerpt' => 'Sızdırmazlık, yağlama, buton kontrolü, torque ve saha temizliği.',            'date' => '10 Ağustos 2026', 'read' => '5 dk', 'img' => 'dth-hammer.jpg'],
        ['slug' => 'sondaj-tiji-baglanti', 'cat' => 'Teknik İpuçları', 'title' => 'Sondaj tiji seçimi ve bağlantı standartları',        'excerpt' => 'API IF, API REG, DCDMA — hangi standart hangi operasyona uygun.',              'date' => '05 Ağustos 2026', 'read' => '4 dk', 'img' => 'drill-rods.jpg'],
        ['slug' => 'camur-pompa-verim',    'cat' => 'Teknik İpuçları', 'title' => 'Çamur pompası performansı ve verim optimizasyonu',   'excerpt' => 'Triplex piston hareket eğrisi, debi-basınç dengesi, aşınma yönetimi.',        'date' => '28 Temmuz 2026', 'read' => '7 dk', 'img' => 'mud-pump.jpg'],
        ['slug' => 'karot-hatalari',       'cat' => 'Vaka Çalışması',  'title' => 'Karot alma operasyonlarında yaygın hatalar',          'excerpt' => 'Doğru derinlikte doğru karot — sahadan 4 gerçek vaka üzerinden ders.',       'date' => '22 Temmuz 2026', 'read' => '6 dk', 'img' => 'asef-macro-diamond.jpg'],
        ['slug' => 'su-sondaji-mevzuat',   'cat' => 'Sondaj Sektörü',  'title' => 'Türkiye\'de su sondajı: yasal süreç ve izinler',      'excerpt' => 'DSİ izin başvurusu, hidrojeoloji raporu, ruhsatlandırma adım adım.',           'date' => '18 Temmuz 2026', 'read' => '8 dk', 'img' => 'drilling-hero.jpg'],
        ['slug' => 'yerustu-yeralti',      'cat' => 'Sondaj Sektörü',  'title' => 'Yerüstü vs yeraltı sondaj: proje bazlı karar',        'excerpt' => 'Formasyon derinliği, saha erişimi, maliyet — hangi tip uygun?',              'date' => '14 Temmuz 2026', 'read' => '5 dk', 'img' => 'asef-hero-equipment.jpg'],
        ['slug' => 'karotiyer-ipuclari',    'cat' => 'Ekipman Rehberi', 'title' => 'Karotiyer seçiminde iç tüp / dış tüp uyumu',           'excerpt' => 'HQ, NQ, PQ standartları arasında geçiş ve karot verim analizi.',              'date' => '08 Temmuz 2026', 'read' => '6 dk', 'img' => 'asef-macro-thread.jpg'],
        ['slug' => 'yedek-parca-stok',     'cat' => 'Vaka Çalışması',  'title' => 'Yedek parça planlaması — 20 yıllık iş birliğinden',   'excerpt' => 'Kritik yedek parça stok stratejisi ve operasyon sürekliliği.',                 'date' => '02 Temmuz 2026', 'read' => '5 dk', 'img' => 'asef-spare-parts.jpg'],
    ];

    $categories = ['Tümü', 'Sondaj Sektörü', 'Ekipman Rehberi', 'Vaka Çalışması', 'Teknik İpuçları'];

    $activeCat = trim((string) request()->query('kat', 'Tümü'));

    $filtered = [];
    foreach ($posts as $p) {
        if ($activeCat !== 'Tümü' && $p['cat'] !== $activeCat) continue;
        $filtered[] = $p;
    }
@endphp

@push('meta')
    <meta name="title" content="Tüm Bloglar — Asef Sondaj" />
    <meta name="description" content="Sondaj sektörü blog arşivi — tüm yazılar, kategori bazında filtre." />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .tb-chips { max-width: 1024px; margin: 0 auto 32px; padding: 0 20px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; }
    .tb-chip {
        display: inline-flex; align-items: center;
        padding: 10px 20px; border-radius: 999px;
        font-size: 13px; font-weight: 500;
        border: 1px solid var(--outline);
        background: white; color: var(--on-surface);
        transition: all .2s;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 1px 2px rgba(0,0,0,0.03);
    }
    .tb-chip:hover { border-color: var(--primary); }
    .tb-chip.active { background: var(--primary); color: white; border-color: var(--primary); box-shadow: 0 4px 12px rgba(0,0,0,0.14); }

    .tb-count { max-width: 1024px; margin: 0 auto 20px; padding: 0 20px; font-size: 13px; color: var(--gray-secondary); }

    .tb-grid { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 640px) { .tb-grid { grid-template-columns: 1fr 1fr; } }
    @media (min-width: 900px) { .tb-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; } }
    @media (min-width: 768px) { .tb-grid { margin-bottom: 120px; } }

    .tb-post {
        background: var(--surface-alt); border-radius: 20px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
    }
    .tb-post:hover { transform: translateY(-3px); background: #EEEEF0; }
    .tb-post-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .tb-post-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .tb-post:hover .tb-post-media img { transform: scale(1.05); }
    .tb-post-body { padding: 20px 22px 22px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
    .tb-post-cat { font-size: 11px; letter-spacing: 0.1em; color: var(--link-blue); font-weight: 500; text-transform: uppercase; }
    .tb-post-title { font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); line-height: 1.3; }
    .tb-post-excerpt { font-size: 14px; color: var(--secondary); line-height: 1.5; flex: 1; }
    .tb-post-meta { font-size: 12px; color: var(--gray-secondary); margin-top: 4px; }

    .tb-empty { max-width: 720px; margin: 0 auto 80px; padding: 60px 20px; text-align: center; background: var(--surface-alt); border-radius: 22px; }
    .tb-empty h3 { font-size: 22px; font-weight: 600; color: var(--primary); margin-bottom: 8px; }
    .tb-empty p { font-size: 15px; color: var(--gray-secondary); margin-bottom: 20px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Tüm Bloglar — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            {{-- HERO --}}
            <section class="asef-hero" style="padding-bottom: 32px;">
                <div class="asef-label-caps">BLOG ARŞİVİ</div>
                <h1>Tüm yazılar, tek arşivde.</h1>
                <p>Sondaj sektörü içgörüleri, ekipman rehberleri, vaka çalışmaları ve teknik anlatımlar.</p>
            </section>

            {{-- CATEGORY CHIPS --}}
            <div class="tb-chips">
                @foreach ($categories as $c)
                    <a href="{{ url('tum-bloglar') . ($c === 'Tümü' ? '' : '?kat=' . urlencode($c)) }}" class="tb-chip {{ $activeCat === $c ? 'active' : '' }}">{{ $c }}</a>
                @endforeach
            </div>

            {{-- COUNT --}}
            <div class="tb-count">{{ count($filtered) }} yazı gösteriliyor</div>

            {{-- POSTS --}}
            @if (count($filtered) > 0)
                <div class="tb-grid">
                    @foreach ($filtered as $p)
                        <a href="{{ url('blog/' . $p['slug']) }}" class="tb-post">
                            <div class="tb-post-media"><img src="{{ $asefUrl($p['img']) }}" alt="{{ $p['title'] }}" loading="lazy"></div>
                            <div class="tb-post-body">
                                <span class="tb-post-cat">{{ $p['cat'] }}</span>
                                <div class="tb-post-title">{{ $p['title'] }}</div>
                                <p class="tb-post-excerpt">{{ $p['excerpt'] }}</p>
                                <div class="tb-post-meta">{{ $p['date'] }} · {{ $p['read'] }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="tb-empty">
                    <h3>Bu kategoride yazı yok.</h3>
                    <p>Farklı bir kategori seçin veya tüm yazılara dönün.</p>
                    <a href="{{ url('tum-bloglar') }}" class="asef-cta-pill primary">Tümüne dön</a>
                </div>
            @endif

            {{-- CTA --}}
            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">SORUNUZ MU VAR</div>
                    <h2>Bir konu hakkında yazı isteyin.</h2>
                    <p>Sizi ilgilendiren bir sondaj konusu için içerik önerinizi bize iletebilirsiniz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="{{ url('blog') }}" class="asef-cta-pill ghost">Blog Ana Sayfa <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
