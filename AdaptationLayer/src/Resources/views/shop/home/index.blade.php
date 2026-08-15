{{-- ============================================================
     Asef Sondaj — Custom Homepage (Adaptation Layer override)
     Design source: Stitch v3 "asef sondaj" — apple-quality light
     (fixed glass nav, centred hero, bento categories with a
     full-width dark spare-parts bar, macro gallery, feature list).
     Overrides shop::home.index via prependNamespace — Bagisto
     core untouched.
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $instagramUrl = 'https://www.instagram.com/asefsondajj';

    // Cache-buster for CSS/JS — file mtime changes on every deploy.
    $assetVer = static fn (string $rel): string => (string) (@filemtime(public_path($rel)) ?: 1);
@endphp

@push('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? 'Asef Sondaj — Endüstriyel Hassasiyet. Teknolojiyle Yeniden Tanımlandı.' }}" />
    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? 'Türkiye’nin en gelişmiş sondaj ekipmanları. Mikron hassasiyetiyle üretilen sondaj makineleri, tijler, çamur pompaları ve orijinal yedek parçalar.' }}" />
    <meta name="theme-color" content="#ffffff" />
@endpush

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" />
    <link rel="stylesheet" href="{{ url('asef/asef-home.css') }}?v={{ $assetVer('asef/asef-home.css') }}" />
@endpush

{{-- Layout's @stack('scripts') is evaluated when the component tag
     closes, so a push placed after it never reaches the page. --}}
@push('scripts')
    <script src="{{ url('asef/asef-home.js') }}?v={{ $assetVer('asef/asef-home.js') }}" defer></script>
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? 'asef sondaj — Endüstriyel Hassasiyet. Teknolojiyle Yeniden Tanımlandı.' }}
    </x-slot>

    <div class="asef-home">
        {{-- ================= TOP NAV ================= --}}
        <nav class="asef-nav" aria-label="Ana gezinme">
            <div class="asef-nav-inner">
                <a href="{{ route('shop.home.index') }}" class="asef-brand" aria-label="asef sondaj ana sayfa">
                    <img src="{{ url('asef/asef-mark-dark.png') }}" alt="" width="20" height="18" aria-hidden="true" />
                    <span class="asef-brand-name">asef sondaj</span>
                </a>

                <div class="asef-nav-links" id="asef-nav-links">
                    <a href="{{ $catalogUrl }}">Ürünler</a>
                    <a href="#hizmetler">Hizmetler</a>
                    <a href="#yedek-parca">Yedek Parça</a>
                    <a href="#destek">Destek</a>
                    <a href="#hakkimizda">Hakkımızda</a>
                </div>

                <div class="asef-nav-actions">
                    <a href="{{ $catalogUrl }}" class="asef-nav-icon" aria-label="Ara">
                        <svg viewBox="0 0 17 17" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" aria-hidden="true"><circle cx="7.2" cy="7.2" r="5.2"/><path d="m11 11 4.3 4.3"/></svg>
                    </a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-blue asef-btn-sm asef-nav-cta">İletişim</a>
                    <button type="button" class="asef-nav-icon asef-nav-burger" id="asef-nav-burger" aria-label="Menü" aria-expanded="false" aria-controls="asef-nav-links">
                        <svg class="asef-ic-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true"><path d="M4 8h16M4 16h16"/></svg>
                        <svg class="asef-ic-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
                    </button>
                </div>
            </div>
        </nav>

        <main class="asef-main">

            {{-- ================= HERO ================= --}}
            <section class="asef-hero" aria-labelledby="hero-heading">
                <div class="asef-hero-copy">
                    <h1 id="hero-heading">Endüstriyel Hassasiyet.<br />Teknolojiyle Yeniden Tanımlandı.</h1>
                    <p>Yirmi yılı aşkın saha tecrübesi ve mikron hassasiyetli mühendislik ile üretilen sondaj ekipmanları.</p>
                    <div class="asef-hero-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-blue">Teklif Al</a>
                        <a href="{{ $catalogUrl }}" class="asef-link asef-link-arrow">Ürünleri İncele<span aria-hidden="true">›</span></a>
                    </div>
                </div>
                <figure class="asef-hero-media">
                    <img src="{{ url('asef/asef-hero-equipment.jpg') }}" alt="Asef Sondaj yüksek hassasiyetli matkap ucu"
                         width="1600" height="900" loading="eager" fetchpriority="high" decoding="async" />
                </figure>
            </section>

            {{-- ================= KATEGORİLER (BENTO) ================= --}}
            <section class="asef-section" id="hizmetler" aria-labelledby="cat-heading">
                <header class="asef-section-head">
                    <h2 id="cat-heading">Kategoriler</h2>
                </header>

                <div class="asef-bento">
                    <a class="asef-tile asef-tile--feature" href="{{ $catalogUrl }}">
                        <div class="asef-tile-copy">
                            <h3>Delici Ekipmanlar</h3>
                            <p>Zorlu zeminler için üstün performans.</p>
                        </div>
                        <div class="asef-tile-media" aria-hidden="true">
                            <img src="{{ url('asef/asef-cat-delici.jpg') }}" alt=""
                                 width="1200" height="900" loading="lazy" decoding="async" />
                        </div>
                    </a>

                    <a class="asef-tile asef-tile--stack" href="{{ $catalogUrl }}">
                        <span class="asef-tile-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3v18"/><path d="M8 5h8"/><path d="M8 19h8"/><path d="M9 8h6"/><path d="M9 12h6"/><path d="M9 16h6"/></svg>
                        </span>
                        <h3>Tij ve Borular</h3>
                        <span class="asef-link asef-link-arrow asef-link-blue">İncele<span aria-hidden="true">›</span></span>
                    </a>

                    <a class="asef-tile asef-tile--stack" href="{{ $catalogUrl }}">
                        <span class="asef-tile-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="6"/><path d="M12 2v3"/><path d="M12 19v3"/><path d="M2 12h3"/><path d="M19 12h3"/><path d="M5 5l2 2"/><path d="M17 17l2 2"/><path d="M5 19l2-2"/><path d="M17 7l2-2"/></svg>
                        </span>
                        <h3>Pompa Sistemleri</h3>
                        <span class="asef-link asef-link-arrow asef-link-blue">İncele<span aria-hidden="true">›</span></span>
                    </a>

                    <a class="asef-tile asef-tile--wide asef-tile--dark" id="yedek-parca" href="{{ $waLink }}" target="_blank" rel="noopener">
                        <div class="asef-tile-copy">
                            <h3>Orijinal Yedek Parça</h3>
                            <p>Sisteminizin ömrünü uzatır, kesintisiz çalışmayı sürdürür.</p>
                            <span class="asef-btn asef-btn-white asef-btn-sm">Parça Sor</span>
                        </div>
                        <div class="asef-tile-media asef-tile-media--right" aria-hidden="true">
                            <img src="{{ url('asef/asef-yedek-parca-bar.jpg') }}" alt=""
                                 width="900" height="520" loading="lazy" decoding="async" />
                        </div>
                    </a>
                </div>
            </section>

            {{-- ================= DETAYLARDA GİZLİ MÜKEMMELLİK ================= --}}
            <section class="asef-macro" id="destek" aria-labelledby="macro-heading">
                <header class="asef-section-head asef-section-head--center">
                    <h2 id="macro-heading">Detaylarda Gizli Mükemmellik</h2>
                    <p>Her bir parça mikron hassasiyetiyle üretilir.</p>
                </header>
                <div class="asef-macro-track" role="list">
                    <figure class="asef-macro-item" role="listitem">
                        <img src="{{ url('asef/asef-macro-diamond.jpg') }}" alt="Elmas uçlu sondaj matkabının makro çekimi"
                             width="1200" height="900" loading="lazy" decoding="async" />
                    </figure>
                    <figure class="asef-macro-item" role="listitem">
                        <img src="{{ url('asef/asef-macro-thread.jpg') }}" alt="Sondaj borusu dişlerinin yakın çekimi"
                             width="1200" height="900" loading="lazy" decoding="async" />
                    </figure>
                    <figure class="asef-macro-item" role="listitem">
                        <img src="{{ url('asef/asef-macro-valve.jpg') }}" alt="Paslanmaz çelik yüksek basınç valfi"
                             width="1200" height="900" loading="lazy" decoding="async" />
                    </figure>
                </div>
            </section>

            {{-- ================= İNOVASYONUN TEMELİ ================= --}}
            <section class="asef-innov" id="hakkimizda" aria-labelledby="innov-heading">
                <figure class="asef-innov-media">
                    <img src="{{ url('asef/asef-innovation-render.jpg') }}" alt="Sondaj ekipmanının teknik kesit görseli"
                         width="1200" height="900" loading="lazy" decoding="async" />
                </figure>
                <div class="asef-innov-copy">
                    <h2 id="innov-heading">İnovasyonun Temeli.</h2>

                    <ul class="asef-feature-list">
                        <li>
                            <span class="asef-feature-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7 9 18l-5-5"/></svg>
                            </span>
                            <div>
                                <h3>API Standartları</h3>
                                <p>Tüm ürünlerimiz uluslararası API normlarına tam uyumlu olarak üretilir.</p>
                            </div>
                        </li>
                        <li>
                            <span class="asef-feature-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 3v6l-3 6a5 5 0 0 0 10 0l-3-6V3"/><path d="M8 3h8"/></svg>
                            </span>
                            <div>
                                <h3>HSS-Co Alaşımlar</h3>
                                <p>Kobalt katkılı yüksek hız çeliği ile aşınma direnci maksimize edilir.</p>
                            </div>
                        </li>
                        <li>
                            <span class="asef-feature-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><rect x="4" y="4" width="16" height="16" rx="3"/><rect x="9" y="9" width="6" height="6" rx="1"/><path d="M4 9h1M4 15h1M19 9h1M19 15h1M9 4v1M15 4v1M9 19v1M15 19v1"/></svg>
                            </span>
                            <div>
                                <h3>7/24 Teknik Destek</h3>
                                <p>Uzman mühendis kadromuz saha operasyonlarınızda her an yanınızda.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </section>
        </main>

        {{-- ================= FOOTER ================= --}}
        <footer class="asef-footer">
            <div class="asef-footer-inner">
                <div class="asef-footer-brand">
                    <span class="asef-footer-name">asef sondaj</span>
                    <p>© {{ date('Y') }} asef sondaj. Tüm hakları saklıdır.</p>
                </div>
                <nav class="asef-footer-links" aria-label="Yasal">
                    <a href="#">Gizlilik Politikası</a>
                    <a href="#">Kullanım Şartları</a>
                    <a href="#">Çerez Ayarları</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener">İletişim</a>
                </nav>
            </div>
        </footer>
    </div>
</x-shop::layouts>
