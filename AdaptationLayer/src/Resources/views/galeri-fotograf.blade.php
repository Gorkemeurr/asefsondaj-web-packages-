{{-- Fotoğraf Galerisi — /blog/{saha|ekipman|proje}-fotograflari --}}
@php
    $waLink       = asef_wa_link('Merhaba, saha fotoğrafları hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Available asset pool (mevcut asef/ görselleri).
    $pool = [
        'drilling-hero.jpg', 'asef-hero-rig.jpg', 'asef-hero-equipment.jpg',
        'dth-hammer.jpg', 'drill-rods.jpg', 'mud-pump.jpg',
        'asef-diamond-bit.jpg', 'asef-macro-diamond.jpg', 'asef-macro-thread.jpg',
        'asef-macro-valve.jpg', 'asef-cat-delici.jpg', 'asef-spare-parts.jpg',
        'asef-yedek-parca-bar.jpg', 'asef-innovation-render.jpg',
        'asef-rig-1.jpg', 'asef-rig-2.jpg', 'asef-rig-3.jpg', 'asef-rig-4.jpg',
        'asef-rig-2-clean.jpg', 'asef-rig-4-clean.jpg',
    ];

    // Slug metadata + gerçek benzersiz görsel seçimi (TEKRAR YOK).
    $galleries = [
        'saha-fotograflari' => [
            'title'    => 'Saha Fotoğrafları',
            'lede'     => 'Sahadan çekilen orijinal fotoğraflar. Yeni fotoğraflar ekledikçe burası genişler.',
            'crumb'    => 'Fotoğraf Galerisi',
            'crumbUrl' => url('blog/fotograf'),
            'hub'      => 'Fotoğraf',
            'order'    => ['drilling-hero.jpg','asef-hero-rig.jpg','asef-rig-1.jpg','asef-rig-2.jpg','asef-rig-3.jpg','asef-rig-4.jpg','asef-rig-2-clean.jpg','asef-rig-4-clean.jpg'],
        ],
        'ekipman-fotograflari' => [
            'title'    => 'Ekipman Fotoğrafları',
            'lede'     => 'Karotiyerler, karot bit\'ler, tijler, muhafaza boruları, kaya delgi ekipmanları — orijinal ürün fotoğraflarımız.',
            'crumb'    => 'Fotoğraf Galerisi',
            'crumbUrl' => url('blog/fotograf'),
            'hub'      => 'Fotoğraf',
            'order'    => ['dth-hammer.jpg','drill-rods.jpg','mud-pump.jpg','asef-diamond-bit.jpg','asef-macro-diamond.jpg','asef-macro-thread.jpg','asef-macro-valve.jpg','asef-cat-delici.jpg','asef-spare-parts.jpg','asef-yedek-parca-bar.jpg','asef-hero-equipment.jpg'],
        ],
        'proje-fotograflari' => [
            'title'    => 'Proje Fotoğrafları',
            'lede'     => 'Tamamladığımız projelerden kadrajlar. Yeni projeler eklendikçe koleksiyon büyüyor.',
            'crumb'    => 'Fotoğraf Galerisi',
            'crumbUrl' => url('blog/fotograf'),
            'hub'      => 'Fotoğraf',
            'order'    => ['asef-innovation-render.jpg','asef-rig-1.jpg','asef-rig-3.jpg','asef-rig-2-clean.jpg','asef-rig-4-clean.jpg'],
        ],
    ];

    $meta = $galleries[$slug] ?? $galleries['saha-fotograflari'];

    // Build item list (image path + caption).
    $items = [];
    foreach ($meta['order'] as $i => $rel) {
        $items[] = [
            'src' => $asefUrl($rel),
            'alt' => $meta['title'] . ' — ' . ($i + 1),
        ];
    }
    $total = count($items);
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
    .gf-crumb { max-width: 1024px; margin: 0 auto 8px; padding: 0 20px; font-size: 12px; color: var(--gray-secondary); letter-spacing: 0.06em; }
    .gf-crumb a { color: var(--link-blue); }

    .gf-count { max-width: 1024px; margin: 20px auto 24px; padding: 0 20px; font-size: 13px; color: var(--gray-secondary); }

    .gf-grid-wrap { max-width: 1200px; margin: 0 auto 60px; padding: 0 16px; }
    .gf-grid {
        display: grid; gap: 10px;
        grid-template-columns: repeat(2, 1fr);
    }
    @media (min-width: 640px) { .gf-grid { grid-template-columns: repeat(3, 1fr); gap: 12px; } }
    @media (min-width: 900px) { .gf-grid { grid-template-columns: repeat(4, 1fr); gap: 14px; } }
    .gf-cell {
        aspect-ratio: 1/1; overflow: hidden; border-radius: 14px;
        background: #14161a; cursor: zoom-in; position: relative;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1);
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 2px 8px rgba(0,0,0,0.05);
    }
    .gf-cell:hover { transform: translateY(-2px); }
    .gf-cell img { width: 100%; height: 100%; object-fit: cover; transition: transform .4s; display: block; }
    .gf-cell:hover img { transform: scale(1.05); }
    .gf-cell::after {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(180deg, transparent 60%, rgba(0,0,0,0.35));
        opacity: 0; transition: opacity .2s;
    }
    .gf-cell:hover::after { opacity: 1; }
    .gf-cell.is-hidden { display: none; }

    .gf-more-wrap { max-width: 1024px; margin: 0 auto 100px; padding: 0 20px; text-align: center; }
    @media (min-width: 768px) { .gf-more-wrap { margin-bottom: 140px; } }
    .gf-more {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 14px 28px; border-radius: 999px;
        background: var(--primary); color: white;
        font-size: 14px; font-weight: 500; letter-spacing: 0.02em;
        cursor: pointer; border: 0;
        transition: transform .2s, box-shadow .2s;
        box-shadow: 0 6px 18px rgba(0,0,0,0.14);
    }
    .gf-more:hover { transform: translateY(-2px); box-shadow: 0 10px 24px rgba(0,0,0,0.2); }
    .gf-more[disabled] { opacity: .5; cursor: not-allowed; }

    /* Lightbox */
    .gf-lb {
        position: fixed; inset: 0; z-index: 10000; display: none;
        background: rgba(15,17,20,0.94); backdrop-filter: blur(24px);
        align-items: center; justify-content: center;
    }
    .gf-lb.on { display: flex; }
    .gf-lb-img { max-width: 92vw; max-height: 84vh; border-radius: 8px; box-shadow: 0 30px 80px rgba(0,0,0,0.6); }
    .gf-lb-btn {
        position: absolute; z-index: 2;
        width: 48px; height: 48px; border-radius: 50%;
        background: rgba(255,255,255,0.12); backdrop-filter: blur(10px);
        color: #fff; border: 0; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: background .2s;
    }
    .gf-lb-btn:hover { background: rgba(255,255,255,0.24); }
    .gf-lb-btn svg { width: 20px; height: 20px; }
    .gf-lb-close { top: 22px; right: 22px; }
    .gf-lb-prev { left: 22px; top: 50%; transform: translateY(-50%); }
    .gf-lb-next { right: 22px; top: 50%; transform: translateY(-50%); }
    .gf-lb-counter {
        position: absolute; bottom: 26px; left: 50%; transform: translateX(-50%);
        color: rgba(255,255,255,0.7); font-size: 13px; letter-spacing: 0.04em;
        font-family: "SF Mono", ui-monospace, Menlo, monospace;
    }
    @media (max-width: 640px) {
        .gf-lb-prev { left: 10px; }
        .gf-lb-next { right: 10px; }
        .gf-lb-close { top: 12px; right: 12px; }
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

            <div class="gf-crumb">
                <a href="{{ $meta['crumbUrl'] }}">‹ {{ $meta['crumb'] }}</a>
            </div>

            <div class="gf-count"><span data-gf-visible>{{ $initial }}</span> / {{ $total }} fotoğraf gösteriliyor</div>

            <section class="gf-grid-wrap">
                <div class="gf-grid" id="gfGrid">
                    @foreach ($items as $i => $it)
                        <button type="button" class="gf-cell {{ $i >= $initial ? 'is-hidden' : '' }}" data-gf-idx="{{ $i }}" data-gf-src="{{ $it['src'] }}" data-gf-alt="{{ $it['alt'] }}">
                            <img src="{{ $it['src'] }}" alt="{{ $it['alt'] }}" loading="{{ $i < 6 ? 'eager' : 'lazy' }}" width="400" height="300" decoding="async">
                        </button>
                    @endforeach
                </div>
            </section>

            @if ($total > $initial)
                <div class="gf-more-wrap">
                    <button type="button" class="gf-more" id="gfMore">
                        Daha fazla göster
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 9l6 6 6-6"/></svg>
                    </button>
                </div>
            @endif

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">ORİJİNAL FOTOĞRAF</div>
                    <h2>Yüksek çözünürlüklü versiyonu ister misiniz?</h2>
                    <p>Sunum, katalog veya iş birliği için orijinal boyutta fotoğrafı WhatsApp'tan iletiyoruz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan İste</a>
                        <a href="{{ url('blog/fotograf') }}" class="asef-cta-pill ghost">Tüm Fotoğraf Albümleri</a>
                    </div>
                </div>
            </section>
        </main>

        {{-- Lightbox --}}
        <div class="gf-lb" id="gfLb" role="dialog" aria-modal="true" aria-label="Fotoğraf görüntüleyici">
            <button type="button" class="gf-lb-btn gf-lb-close" id="gfLbClose" aria-label="Kapat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/></svg>
            </button>
            <button type="button" class="gf-lb-btn gf-lb-prev" id="gfLbPrev" aria-label="Önceki">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <img class="gf-lb-img" id="gfLbImg" src="" alt="">
            <button type="button" class="gf-lb-btn gf-lb-next" id="gfLbNext" aria-label="Sonraki">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 6 15 12 9 18"/></svg>
            </button>
            <div class="gf-lb-counter" id="gfLbCounter">1 / {{ $total }}</div>
        </div>

        <script>
        (function () {
            var grid = document.getElementById('gfGrid');
            if (!grid) return;
            var cells = Array.prototype.slice.call(grid.querySelectorAll('.gf-cell'));
            var visible = {{ $initial }};
            var total = {{ $total }};

            var moreBtn = document.getElementById('gfMore');
            var counter = document.querySelector('[data-gf-visible]');
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

            // Lightbox
            var lb        = document.getElementById('gfLb');
            var lbImg     = document.getElementById('gfLbImg');
            var lbClose   = document.getElementById('gfLbClose');
            var lbPrev    = document.getElementById('gfLbPrev');
            var lbNext    = document.getElementById('gfLbNext');
            var lbCounter = document.getElementById('gfLbCounter');
            var current = 0;

            function open(i) {
                current = i;
                lbImg.src = cells[i].getAttribute('data-gf-src');
                lbImg.alt = cells[i].getAttribute('data-gf-alt');
                lbCounter.textContent = (i + 1) + ' / ' + total;
                lb.classList.add('on');
                document.body.style.overflow = 'hidden';
            }
            function close() { lb.classList.remove('on'); document.body.style.overflow = ''; }
            function step(delta) {
                var n = (current + delta + total) % total;
                open(n);
            }

            grid.addEventListener('click', function (e) {
                var cell = e.target.closest('.gf-cell'); if (!cell) return;
                open(parseInt(cell.getAttribute('data-gf-idx'), 10));
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
