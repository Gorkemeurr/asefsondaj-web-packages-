{{-- Fotoğraf Galeri Hub — /blog/fotograf --}}
@php
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, saha fotoğraflarınız hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $albums = [
        [
            'url'   => url('blog/saha-fotograflari'),
            'label' => '01',
            'title' => 'Saha Fotoğrafları',
            'desc'  => 'Kuyu başı, operasyon anı, ekip çalışması — sahadan orijinal kadrajlar.',
            'count' => '8 fotoğraf',
            'img'   => 'drilling-hero.jpg',
        ],
        [
            'url'   => url('blog/ekipman-fotograflari'),
            'label' => '02',
            'title' => 'Ekipman Fotoğrafları',
            'desc'  => 'DTH çekiçler, tijler, karotierler, pompalar ve yedek parçalarımızın detay çekimleri.',
            'count' => '11 fotoğraf',
            'img'   => 'asef-hero-equipment.jpg',
        ],
        [
            'url'   => url('blog/proje-fotograflari'),
            'label' => '03',
            'title' => 'Proje Fotoğrafları',
            'desc'  => 'Türkiye\'nin dört bir yanında tamamladığımız projelerden kadrajlar.',
            'count' => '5 fotoğraf',
            'img'   => 'asef-hero-rig.jpg',
        ],
    ];
@endphp

@push('meta')
    <meta name="title" content="Fotoğraf Galerisi — Asef Sondaj" />
    <meta name="description" content="Saha fotoğrafları, ekipman detayları ve proje kadrajları — Asef Sondaj görsel arşivi." />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .gh-albums-wrap { max-width: 1024px; margin: 0 auto 100px; padding: 0 20px; }
    @media (min-width: 768px) { .gh-albums-wrap { margin-bottom: 140px; } }
    .gh-albums { display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 768px) { .gh-albums { grid-template-columns: repeat(3, 1fr); gap: 24px; } }
    .gh-album {
        background: var(--surface-alt); border-radius: 24px; overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s, box-shadow .3s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 14px rgba(0,0,0,0.03);
    }
    .gh-album:hover { transform: translateY(-4px); box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 14px 34px rgba(0,0,0,0.09); }
    .gh-album-media { aspect-ratio: 4/3; background: #14161a; overflow: hidden; position: relative; }
    .gh-album-media img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .gh-album:hover .gh-album-media img { transform: scale(1.04); }
    .gh-album-badge {
        position: absolute; top: 14px; right: 14px; z-index: 2;
        background: rgba(0,0,0,0.7); backdrop-filter: blur(10px);
        color: #fff; padding: 6px 12px; border-radius: 999px;
        font-size: 11px; font-weight: 500; letter-spacing: 0.04em;
    }
    .gh-album-body { padding: 24px 26px 26px; display: flex; flex-direction: column; gap: 10px; }
    .gh-album-num { font-family: "SF Mono", ui-monospace, Menlo, monospace; font-size: 11px; letter-spacing: 0.12em; color: var(--gray-secondary); }
    .gh-album-title { font-size: 22px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .gh-album-desc { font-size: 14px; color: var(--secondary); line-height: 1.55; }
    .gh-album-cta { color: var(--link-blue); font-size: 14px; font-weight: 500; margin-top: 4px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Fotoğraf Galerisi — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">FOTOĞRAF GALERİSİ</div>
                <h1>Sahadan, ekipmandan, projeden kareler.</h1>
                <p>20 yıllık saha tecrübemizden fotoğrafları üç ana albümde topladık.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ url('blog/video') }}" class="asef-cta-pill ghost">Video Galerisi <span class="asef-cta-arrow">›</span></a>
                    <a href="{{ url('blog') }}" class="asef-cta-pill ghost">Blog'a Dön</a>
                </div>
            </section>

            <section class="gh-albums-wrap">
                <div class="gh-albums">
                    @foreach ($albums as $a)
                        <a href="{{ $a['url'] }}" class="gh-album">
                            <div class="gh-album-media">
                                <span class="gh-album-badge">{{ $a['count'] }}</span>
                                <img src="{{ $asefUrl($a['img']) }}" alt="{{ $a['title'] }}" loading="lazy">
                            </div>
                            <div class="gh-album-body">
                                <span class="gh-album-num">{{ $a['label'] }}</span>
                                <div class="gh-album-title">{{ $a['title'] }}</div>
                                <p class="gh-album-desc">{{ $a['desc'] }}</p>
                                <span class="gh-album-cta">Galeriyi aç ›</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">ORİJİNAL FOTOĞRAF TALEBİ</div>
                    <h2>Yüksek çözünürlüklü fotoğraf mı gerekli?</h2>
                    <p>Sunum, katalog veya iş birliği için orijinal boyutta fotoğraf isteyebilirsiniz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Talep Et</a>
                        <a href="{{ url('blog') }}" class="asef-cta-pill ghost">Blog'a Dön</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
