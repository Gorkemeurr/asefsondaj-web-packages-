{{-- Video Galerisi — /blog/{urun-tanitim-videolari|saha-uygulamalari|teknik-anlatimlar} --}}
@php
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, videolarınız hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $galleries = [
        'urun-tanitim-videolari' => [
            'title'    => 'Ürün Tanıtım Videoları',
            'lede'     => 'DTH çekiçler, matkap uçları, tijler ve pompaların yakın çekim tanıtımları.',
            'crumb'    => 'Video Galerisi',
            'crumbUrl' => url('blog/video'),
            'hub'      => 'Video',
            'videos'   => [
                ['thumb' => 'dth-hammer.jpg',           'title' => 'DTH Çekiç 4 İnç Tanıtımı',            'dur' => '01:24', 'yt' => ''],
                ['thumb' => 'asef-macro-diamond.jpg',   'title' => 'Elmas Uçlu Karotier Yakın Çekim',      'dur' => '00:52', 'yt' => ''],
                ['thumb' => 'asef-macro-thread.jpg',    'title' => 'Sondaj Tiji Bağlantı Detayı',          'dur' => '01:12', 'yt' => ''],
                ['thumb' => 'mud-pump.jpg',             'title' => 'Triplex Çamur Pompası',                'dur' => '02:04', 'yt' => ''],
                ['thumb' => 'asef-diamond-bit.jpg',     'title' => 'Diamond Bit — Aşınma Testi',           'dur' => '00:48', 'yt' => ''],
                ['thumb' => 'drill-rods.jpg',           'title' => 'API IF vs API REG Bağlantı Farkı',     'dur' => '01:30', 'yt' => ''],
                ['thumb' => 'asef-macro-valve.jpg',     'title' => 'Pompa Valfi İç Yapısı',                'dur' => '01:08', 'yt' => ''],
                ['thumb' => 'asef-spare-parts.jpg',     'title' => 'Yedek Parça Ailesi Tanıtımı',          'dur' => '01:56', 'yt' => ''],
                ['thumb' => 'asef-yedek-parca-bar.jpg', 'title' => 'Stok Süreç Anlatımı',                  'dur' => '01:12', 'yt' => ''],
                ['thumb' => 'asef-cat-delici.jpg',      'title' => 'Delici Ekipman Ailesi',                'dur' => '00:44', 'yt' => ''],
                ['thumb' => 'dth-hammer.jpg',           'title' => 'DTH Çekiç 5 İnç — Detaylar',           'dur' => '01:16', 'yt' => ''],
                ['thumb' => 'asef-innovation-render.jpg','title' => 'İnovasyon Render — Yeni Nesil Çekiç', 'dur' => '00:36', 'yt' => ''],
            ],
        ],
        'saha-uygulamalari' => [
            'title'    => 'Saha Uygulamaları',
            'lede'     => 'Gerçek operasyondan görüntüler — kuyu açımı, ekipman montajı, sahada işleyiş.',
            'crumb'    => 'Video Galerisi',
            'crumbUrl' => url('blog/video'),
            'hub'      => 'Video',
            'videos'   => [
                ['thumb' => 'drilling-hero.jpg',        'title' => 'Kuyu Başı Kurulumu',                   'dur' => '02:32', 'yt' => ''],
                ['thumb' => 'asef-hero-rig.jpg',        'title' => 'Rotary Sondaj Operasyonu',             'dur' => '03:14', 'yt' => ''],
                ['thumb' => 'asef-rig-1.jpg',           'title' => 'Bursa — Su Sondajı Sahası',            'dur' => '01:48', 'yt' => ''],
                ['thumb' => 'asef-rig-2.jpg',           'title' => 'Konya — Derin Kuyu Açımı',             'dur' => '02:10', 'yt' => ''],
                ['thumb' => 'asef-rig-3.jpg',           'title' => 'Denizli — Jeotermal Etüd',             'dur' => '01:56', 'yt' => ''],
                ['thumb' => 'asef-rig-4.jpg',           'title' => 'Manisa — Zemin Etüt Sondajı',          'dur' => '02:22', 'yt' => ''],
                ['thumb' => 'asef-hero-equipment.jpg',  'title' => 'Ekipman Sevkiyat Süreci',              'dur' => '01:04', 'yt' => ''],
                ['thumb' => 'asef-rig-2-clean.jpg',     'title' => 'Ekipman Bakım Protokolü',              'dur' => '02:44', 'yt' => ''],
                ['thumb' => 'asef-rig-4-clean.jpg',     'title' => 'Operasyon Sonrası Temizlik',           'dur' => '01:36', 'yt' => ''],
                ['thumb' => 'mud-pump.jpg',             'title' => 'Çamur Devri — Canlı Anlatım',          'dur' => '02:08', 'yt' => ''],
                ['thumb' => 'drilling-hero.jpg',        'title' => 'Kuyu Tamamlama Aşamaları',             'dur' => '02:52', 'yt' => ''],
                ['thumb' => 'asef-rig-1.jpg',           'title' => 'Ekip Çalışması — Bir Gün',             'dur' => '04:12', 'yt' => ''],
            ],
        ],
        'teknik-anlatimlar' => [
            'title'    => 'Teknik Anlatımlar',
            'lede'     => 'Bakım prosedürleri, arıza teşhisi ve doğru kullanım için mühendis anlatımları.',
            'crumb'    => 'Video Galerisi',
            'crumbUrl' => url('blog/video'),
            'hub'      => 'Video',
            'videos'   => [
                ['thumb' => 'dth-hammer.jpg',           'title' => 'DTH Çekiç Sızdırmazlık Kontrolü',      'dur' => '03:12', 'yt' => ''],
                ['thumb' => 'asef-macro-thread.jpg',    'title' => 'Bağlantı Torque Değerleri',            'dur' => '02:04', 'yt' => ''],
                ['thumb' => 'mud-pump.jpg',             'title' => 'Piston Aşınma Teşhisi',                'dur' => '02:36', 'yt' => ''],
                ['thumb' => 'asef-macro-diamond.jpg',   'title' => 'Karotier Elmas Uç Aşınma Paterni',     'dur' => '01:48', 'yt' => ''],
                ['thumb' => 'asef-macro-valve.jpg',     'title' => 'Pompa Valfi Değişimi Adım Adım',       'dur' => '04:22', 'yt' => ''],
                ['thumb' => 'asef-diamond-bit.jpg',     'title' => 'Bit Ömrü — Yağlama Rejimi',            'dur' => '02:16', 'yt' => ''],
                ['thumb' => 'drill-rods.jpg',           'title' => 'API Standartları Karşılaştırma',       'dur' => '03:04', 'yt' => ''],
                ['thumb' => 'asef-spare-parts.jpg',     'title' => 'Kritik Yedek Parça Stoğu',             'dur' => '02:12', 'yt' => ''],
                ['thumb' => 'asef-yedek-parca-bar.jpg', 'title' => 'Yedek Parça Sipariş Süreci',           'dur' => '01:36', 'yt' => ''],
                ['thumb' => 'asef-cat-delici.jpg',      'title' => 'Formasyona Göre Bit Seçimi',           'dur' => '02:28', 'yt' => ''],
                ['thumb' => 'dth-hammer.jpg',           'title' => 'DTH Basınç ve Debi Dengesi',           'dur' => '03:52', 'yt' => ''],
                ['thumb' => 'asef-innovation-render.jpg','title' => 'Yeni Nesil Ekipman Avantajları',      'dur' => '01:44', 'yt' => ''],
            ],
        ],
    ];

    $meta = $galleries[$slug] ?? $galleries['urun-tanitim-videolari'];
    $videos = $meta['videos'];
    $total = count($videos);
    $initial = min(12, $total);
@endphp

@push('meta')
    <meta name="title" content="{{ $meta['title'] }} — Asef Sondaj" />
    <meta name="description" content="{{ $meta['lede'] }}" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .gv-crumb { max-width: 1024px; margin: 0 auto 8px; padding: 0 20px; font-size: 12px; color: var(--gray-secondary); letter-spacing: 0.06em; }
    .gv-crumb a { color: var(--link-blue); }

    .gv-count { max-width: 1024px; margin: 20px auto 24px; padding: 0 20px; font-size: 13px; color: var(--gray-secondary); }

    .gv-grid-wrap { max-width: 1200px; margin: 0 auto 60px; padding: 0 16px; }
    .gv-grid {
        display: grid; gap: 12px;
        grid-template-columns: repeat(2, 1fr);
    }
    @media (min-width: 640px) { .gv-grid { grid-template-columns: repeat(3, 1fr); gap: 14px; } }
    @media (min-width: 1000px) { .gv-grid { grid-template-columns: repeat(4, 1fr); gap: 16px; } }
    .gv-cell {
        display: block; text-align: left; border: 0; padding: 0; background: transparent; cursor: pointer;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1);
    }
    .gv-cell:hover { transform: translateY(-3px); }
    .gv-cell.is-hidden { display: none; }
    .gv-cell-thumb {
        position: relative; aspect-ratio: 16/10; overflow: hidden; border-radius: 14px;
        background: #14161a;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.06);
    }
    .gv-cell-thumb img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; }
    .gv-cell:hover .gv-cell-thumb img { transform: scale(1.05); }
    .gv-cell-play {
        position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;
        pointer-events: none;
    }
    .gv-cell-play span {
        width: 48px; height: 48px; border-radius: 50%;
        background: rgba(255,255,255,0.94); color: #1d1d1f;
        display: inline-flex; align-items: center; justify-content: center;
        box-shadow: 0 10px 24px rgba(0,0,0,0.28);
        transition: transform .25s;
    }
    .gv-cell:hover .gv-cell-play span { transform: scale(1.1); }
    .gv-cell-play svg { width: 18px; height: 18px; margin-left: 2px; }
    .gv-cell-dur {
        position: absolute; bottom: 10px; right: 10px;
        background: rgba(0,0,0,0.75); backdrop-filter: blur(6px);
        color: #fff; padding: 3px 8px; border-radius: 6px;
        font-size: 11px; font-family: "SF Mono", ui-monospace, Menlo, monospace;
    }
    .gv-cell-title {
        margin: 12px 4px 0; font-size: 14px; font-weight: 500; color: var(--primary); line-height: 1.4;
    }

    .gv-more-wrap { max-width: 1024px; margin: 0 auto 100px; padding: 0 20px; text-align: center; }
    @media (min-width: 768px) { .gv-more-wrap { margin-bottom: 140px; } }
    .gv-more {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 14px 28px; border-radius: 999px;
        background: var(--primary); color: white;
        font-size: 14px; font-weight: 500; letter-spacing: 0.02em;
        cursor: pointer; border: 0;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 6px 18px rgba(0,0,0,0.14);
    }
    .gv-more:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(0,0,0,0.2); }
    .gv-more[disabled] { opacity: .5; cursor: not-allowed; }

    /* Lightbox */
    .gv-lb { position: fixed; inset: 0; z-index: 10000; display: none; background: rgba(15,17,20,0.94); backdrop-filter: blur(24px); align-items: center; justify-content: center; }
    .gv-lb.on { display: flex; }
    .gv-lb-stage { width: min(92vw, 1000px); }
    .gv-lb-frame {
        position: relative; aspect-ratio: 16/9; background: #000; border-radius: 12px; overflow: hidden;
        box-shadow: 0 30px 80px rgba(0,0,0,0.6);
    }
    .gv-lb-frame iframe { position: absolute; inset: 0; width: 100%; height: 100%; border: 0; }
    .gv-lb-placeholder {
        position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;
        color: #fff; padding: 24px; text-align: center;
    }
    .gv-lb-placeholder-icon { width: 60px; height: 60px; margin-bottom: 16px; opacity: 0.6; }
    .gv-lb-placeholder h4 { font-size: 20px; font-weight: 600; margin-bottom: 8px; }
    .gv-lb-placeholder p { font-size: 14px; color: rgba(255,255,255,0.7); margin-bottom: 20px; max-width: 400px; }
    .gv-lb-placeholder a {
        padding: 12px 22px; border-radius: 999px; background: #25D366; color: #fff;
        font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; gap: 8px;
    }
    .gv-lb-title { color: #fff; font-size: 15px; font-weight: 500; margin-top: 16px; text-align: center; letter-spacing: -0.01em; }
    .gv-lb-btn { position: absolute; z-index: 2; width: 48px; height: 48px; border-radius: 50%; background: rgba(255,255,255,0.12); backdrop-filter: blur(10px); color: #fff; border: 0; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: background .2s; }
    .gv-lb-btn:hover { background: rgba(255,255,255,0.24); }
    .gv-lb-btn svg { width: 20px; height: 20px; }
    .gv-lb-close { top: 22px; right: 22px; }
    .gv-lb-prev { left: 22px; top: 50%; transform: translateY(-50%); }
    .gv-lb-next { right: 22px; top: 50%; transform: translateY(-50%); }
    @media (max-width: 640px) {
        .gv-lb-prev { left: 10px; }
        .gv-lb-next { right: 10px; }
        .gv-lb-close { top: 12px; right: 12px; }
    }
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

            <div class="gv-count"><span data-gv-visible>{{ $initial }}</span> / {{ $total }} video gösteriliyor</div>

            <section class="gv-grid-wrap">
                <div class="gv-grid" id="gvGrid">
                    @foreach ($videos as $i => $v)
                        <button type="button" class="gv-cell {{ $i >= $initial ? 'is-hidden' : '' }}" data-gv-idx="{{ $i }}" data-gv-yt="{{ $v['yt'] }}" data-gv-title="{{ $v['title'] }}">
                            <div class="gv-cell-thumb">
                                <img src="{{ $asefUrl($v['thumb']) }}" alt="{{ $v['title'] }}" loading="lazy">
                                <span class="gv-cell-play"><span><svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg></span></span>
                                <span class="gv-cell-dur">{{ $v['dur'] }}</span>
                            </div>
                            <div class="gv-cell-title">{{ $v['title'] }}</div>
                        </button>
                    @endforeach
                </div>
            </section>

            @if ($total > $initial)
                <div class="gv-more-wrap">
                    <button type="button" class="gv-more" id="gvMore">
                        Daha fazla göster
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                </div>
            @endif

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">ÖZEL VİDEO TALEBİ</div>
                    <h2>Belirli bir ekipmanın anlatımını mı istiyorsunuz?</h2>
                    <p>İhtiyaç duyduğunuz videoyu WhatsApp üzerinden bize iletin — mümkünse çekim planlarız.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Video Talep Et</a>
                        <a href="{{ url('blog/video') }}" class="asef-cta-pill ghost">Tüm Video Albümleri</a>
                    </div>
                </div>
            </section>
        </main>

        {{-- Lightbox --}}
        <div class="gv-lb" id="gvLb" role="dialog" aria-modal="true" aria-label="Video görüntüleyici">
            <button type="button" class="gv-lb-btn gv-lb-close" id="gvLbClose" aria-label="Kapat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
            <button type="button" class="gv-lb-btn gv-lb-prev" id="gvLbPrev" aria-label="Önceki">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="gv-lb-stage">
                <div class="gv-lb-frame" id="gvLbFrame"></div>
                <div class="gv-lb-title" id="gvLbTitle"></div>
            </div>
            <button type="button" class="gv-lb-btn gv-lb-next" id="gvLbNext" aria-label="Sonraki">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>
            </button>
        </div>

        <script>
        (function () {
            var grid = document.getElementById('gvGrid');
            if (!grid) return;
            var cells = Array.prototype.slice.call(grid.querySelectorAll('.gv-cell'));
            var visible = {{ $initial }};
            var total = {{ $total }};
            var waLink = @json($waLink);

            var moreBtn = document.getElementById('gvMore');
            var counter = document.querySelector('[data-gv-visible]');
            if (moreBtn) {
                moreBtn.addEventListener('click', function () {
                    var next = Math.min(visible + 12, total);
                    for (var i = visible; i < next; i++) {
                        cells[i] && cells[i].classList.remove('is-hidden');
                    }
                    visible = next;
                    if (counter) counter.textContent = String(visible);
                    if (visible >= total) { moreBtn.disabled = true; moreBtn.textContent = 'Tümü gösterildi'; }
                });
            }

            var lb       = document.getElementById('gvLb');
            var lbFrame  = document.getElementById('gvLbFrame');
            var lbTitle  = document.getElementById('gvLbTitle');
            var lbClose  = document.getElementById('gvLbClose');
            var lbPrev   = document.getElementById('gvLbPrev');
            var lbNext   = document.getElementById('gvLbNext');
            var current  = 0;

            function render(i) {
                current = i;
                var cell = cells[i];
                var yt = cell.getAttribute('data-gv-yt');
                var title = cell.getAttribute('data-gv-title');
                lbTitle.textContent = title;
                if (yt) {
                    lbFrame.innerHTML = '<iframe src="https://www.youtube.com/embed/' + yt + '?autoplay=1&rel=0" title="' + title + '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
                } else {
                    lbFrame.innerHTML = ''
                        + '<div class="gv-lb-placeholder">'
                        +   '<svg class="gv-lb-placeholder-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="12" rx="2"/><polygon points="10 10 15 13 10 16"/></svg>'
                        +   '<h4>Bu video yakında yüklenecek</h4>'
                        +   '<p>İçeriği daha erken izlemek istiyorsanız WhatsApp\'tan bize yazın — özel gönderiyoruz.</p>'
                        +   '<a href="' + waLink + '" target="_blank" rel="noopener">WhatsApp\'tan Talep Et</a>'
                        + '</div>';
                }
            }
            function open(i) { render(i); lb.classList.add('on'); document.body.style.overflow = 'hidden'; }
            function close() { lb.classList.remove('on'); lbFrame.innerHTML = ''; document.body.style.overflow = ''; }
            function step(delta) { render((current + delta + total) % total); }

            grid.addEventListener('click', function (e) {
                var cell = e.target.closest('.gv-cell'); if (!cell) return;
                open(parseInt(cell.getAttribute('data-gv-idx'), 10));
            });
            lbClose.addEventListener('click', close);
            lbPrev.addEventListener('click', function () { step(-1); });
            lbNext.addEventListener('click', function () { step(1); });
            lb.addEventListener('click', function (e) { if (e.target === lb) close(); });
            document.addEventListener('keydown', function (e) {
                if (!lb.classList.contains('on')) return;
                if (e.key === 'Escape') close();
                if (e.key === 'ArrowLeft') step(-1);
                if (e.key === 'ArrowRight') step(1);
            });
        })();
        </script>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
