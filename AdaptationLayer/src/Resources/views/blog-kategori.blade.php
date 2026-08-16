{{-- Blog Kategori Landing — /blog/kategori/{cat} --}}
@php
    $waLink     = asef_wa_link('Merhaba, blog kategorinizi inceledim, ürünleriniz hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl    = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Kategori slug → görünen isim + açıklama
    $catMap = [
        'ekipman-rehberi'  => [
            'name' => 'Ekipman Rehberi',
            'desc' => 'Sondaj ekipmanı seçimi, teknik karşılaştırma ve doğru ürünü bulma rehberleri. Karotier, DTH çekiç, sondaj tijleri, matkap uçları ve pörtkron için detaylı seçim kılavuzları.',
            'icon' => '🔧',
        ],
        'vaka-calismalari' => [
            'name' => 'Vaka Çalışmaları',
            'desc' => 'Sahada karşılaştığımız gerçek sondaj operasyonu vakalarından çıkarılan dersler. 20 yıllık tecrübemizden formasyon, ekipman ve çözüm hikayeleri.',
            'icon' => '📊',
        ],
        'sektor-trendleri' => [
            'name' => 'Sektör Trendleri',
            'desc' => 'Türkiye ve dünyada sondaj sektörünün güncel gelişmeleri, mevzuat değişiklikleri, yeni teknoloji ve trend analizleri.',
            'icon' => '📈',
        ],
        'teknik-ipuclari'  => [
            'name' => 'Teknik İpuçları',
            'desc' => 'Sondaj operasyonlarında verimi artıran pratik ipuçları, bakım rehberleri, sorun giderme ve uzman önerileri.',
            'icon' => '💡',
        ],
    ];

    $activeCat = $catMap[$cat] ?? null;
    if (! $activeCat) abort(404);

    // Blog store (blog-detay ile aynı — 9 yazı)
    $catBlogs = [
        'ekipman-secim-rehberi' => ['cat' => 'Ekipman Rehberi', 'title' => 'Sondaj Operasyonlarında Ekipman Seçimi: Kapsamlı Rehber (2026)', 'lede' => 'Delik çapı, formasyon karakteri, çalışma basıncı ve bağlantı standardı — doğru ekipman seçim rehberi.', 'date' => '12 Ağustos 2026', 'read' => '12 dakika', 'img' => 'asef-hero-rig.jpg'],
        'dth-cekic-bakim'       => ['cat' => 'Ekipman Rehberi', 'title' => 'DTH Çekiç Bakımı: Uzun Ömür İçin 5 Kritik Nokta', 'lede' => 'Down-the-hole çekicin ömrünü etkileyen 5 bakım disiplini: sızdırmazlık, yağlama, buton analizi, torque, saha temizliği.', 'date' => '10 Ağustos 2026', 'read' => '10 dakika', 'img' => 'dth-hammer.jpg'],
        'sondaj-tiji-baglanti'  => ['cat' => 'Teknik İpuçları', 'title' => 'Sondaj Tiji ve Bağlantı Standartları: API IF, REG, DCDMA', 'lede' => 'API IF, API REG ve DCDMA bağlantı standartları karşılaştırma ve seçim rehberi.', 'date' => '5 Ağustos 2026', 'read' => '8 dakika', 'img' => 'drill-pipes.jpg'],
        'camur-pompa-verim'     => ['cat' => 'Ekipman Rehberi', 'title' => 'Çamur Pompası Performansı: Triplex Pompa Bakım Rehberi', 'lede' => 'Çamur pompası verim optimizasyonu ve triplex pompa bakım disiplini.', 'date' => '1 Ağustos 2026', 'read' => '9 dakika', 'img' => 'mud-pump.jpg'],
        'karot-hatalari'        => ['cat' => 'Vaka Çalışmaları', 'title' => 'Karot Alma Operasyonlarında Yaygın Hatalar: 4 Vaka', 'lede' => 'Sahadan derlenmiş 4 karot alma vakası ve alınan dersler.', 'date' => '28 Temmuz 2026', 'read' => '11 dakika', 'img' => 'core-sampling.jpg'],
        'su-sondaji-mevzuat'    => ['cat' => 'Sektör Trendleri', 'title' => 'Türkiye\'de Su Sondajı: DSİ İzin Süreci Rehberi (2026)', 'lede' => 'Su sondajı için DSİ izin süreci, gerekli evraklar ve yasal çerçeve.', 'date' => '25 Temmuz 2026', 'read' => '13 dakika', 'img' => 'water-drilling.jpg'],
        'yerustu-yeralti'       => ['cat' => 'Ekipman Rehberi', 'title' => 'Yerüstü ve Yeraltı Sondaj Karşılaştırması', 'lede' => 'Proje bazlı yerüstü ve yeraltı sondaj ekipmanı seçim rehberi.', 'date' => '20 Temmuz 2026', 'read' => '10 dakika', 'img' => 'surface-drilling.jpg'],
        'karotier-ipuclari'     => ['cat' => 'Teknik İpuçları', 'title' => 'Karotier Seçimi: HQ/NQ/PQ Standartları ve İç/Dış Tüp Uyumu', 'lede' => 'Karotier seçim rehberi: HQ, NQ, PQ standartları, iç tüp ve dış tüp uyumu.', 'date' => '15 Temmuz 2026', 'read' => '9 dakika', 'img' => 'core-barrel.jpg'],
        'yedek-parca-stok'      => ['cat' => 'Vaka Çalışmaları', 'title' => 'Sondaj Yedek Parça Planlaması: 20 Yıllık Dersler', 'lede' => 'Uzun soluklu iş birliklerinden çıkarılmış yedek parça stok yönetimi.', 'date' => '10 Temmuz 2026', 'read' => '12 dakika', 'img' => 'spare-parts.jpg'],
    ];

    // Filtre: aktif kategoriye ait yazılar
    $filteredBlogs = array_filter($catBlogs, fn ($b) => $b['cat'] === $activeCat['name']);

    $pageTitle = $activeCat['name'] . ' — Blog Kategorisi | ' . count($filteredBlogs) . ' Yazı | Asef Sondaj';
    $pageDesc  = $activeCat['desc'] . ' — ' . count($filteredBlogs) . ' yazı, sondaj sektörü uzman içerikleri.';
@endphp

@push('meta')
    <meta name="title" content="{{ $pageTitle }}" />
    <meta name="description" content="{{ e($pageDesc) }}" />
    <meta name="keywords" content="{{ $activeCat['name'] }}, sondaj blog, sondaj ekipmanları rehberi, sondaj sektörü, Asef Sondaj blog" />
    <link rel="canonical" href="{{ url('blog/kategori/' . $cat) }}" />
    <meta name="theme-color" content="#ffffff" />

    {{-- BreadcrumbList JSON-LD --}}
    @php
        $breadcrumb = [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana Sayfa', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Blog', 'item' => url('blog')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $activeCat['name'], 'item' => url('blog/kategori/' . $cat)],
            ],
        ];

        $collection = [
            '@context'    => 'https://schema.org',
            '@type'       => 'CollectionPage',
            'name'        => $activeCat['name'],
            'description' => $activeCat['desc'],
            'url'         => url('blog/kategori/' . $cat),
            'inLanguage'  => 'tr-TR',
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($breadcrumb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($collection, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .bk-hero { max-width: 820px; margin: 0 auto; padding: 60px 20px 40px; text-align: center; }
    .bk-icon { font-size: 44px; margin-bottom: 16px; }
    .bk-list { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 768px) { .bk-list { grid-template-columns: 1fr 1fr; gap: 24px; } }
    .bk-card { background: var(--surface-alt); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s; text-decoration: none; color: inherit; }
    .bk-card:hover { transform: translateY(-3px); background: #EEEEF0; }
    .bk-card-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .bk-card-media img { width: 100%; height: 100%; object-fit: cover; }
    .bk-card-body { padding: 22px 24px 26px; display: flex; flex-direction: column; gap: 10px; flex: 1; }
    .bk-card-cat { font-size: 11px; letter-spacing: 0.1em; color: var(--link-blue); font-weight: 500; text-transform: uppercase; }
    .bk-card-title { font-size: 18px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); line-height: 1.35; }
    .bk-card-lede { font-size: 14px; color: var(--secondary); line-height: 1.55; }
    .bk-card-meta { font-size: 12px; color: var(--gray-secondary); margin-top: auto; padding-top: 8px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>{{ $pageTitle }}</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="bk-hero">
                <div class="bk-icon">{{ $activeCat['icon'] }}</div>
                <div class="asef-label-caps">BLOG KATEGORİSİ</div>
                <h1 style="font-size:clamp(32px, 4vw, 44px); font-weight:600; letter-spacing:-0.02em; color:var(--primary); margin:12px 0 16px;">{{ $activeCat['name'] }}</h1>
                <p style="font-size:17px; color:var(--secondary); line-height:1.6; margin:0 auto; max-width:640px;">{{ $activeCat['desc'] }}</p>
                <div style="margin-top:20px; font-size:13px; color:var(--gray-secondary);">{{ count($filteredBlogs) }} yazı</div>
            </section>

            <section class="bk-list">
                @foreach ($filteredBlogs as $slug => $b)
                    <a href="{{ url('blog/' . $slug) }}" class="bk-card">
                        <div class="bk-card-media"><img src="{{ $asefUrl($b['img']) }}" alt="{{ $b['title'] }} — {{ $b['cat'] }} | Asef Sondaj" loading="lazy" width="400" height="250"></div>
                        <div class="bk-card-body">
                            <span class="bk-card-cat">{{ $b['cat'] }}</span>
                            <div class="bk-card-title">{{ $b['title'] }}</div>
                            <div class="bk-card-lede">{{ $b['lede'] }}</div>
                            <div class="bk-card-meta">{{ $b['date'] }} · {{ $b['read'] }}</div>
                        </div>
                    </a>
                @endforeach
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">DAHA FAZLASI</div>
                    <h2>Blog ana sayfasına dön veya kataloğa bak.</h2>
                    <div class="asef-cta-band-actions">
                        <a href="{{ url('blog') }}" class="asef-cta-pill primary">Tüm Blog</a>
                        <a href="{{ $catalogUrl }}" class="asef-cta-pill ghost">Kataloga Git <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
