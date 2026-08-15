{{-- ============================================================
     Asef Sondaj — Custom Homepage (Adaptation Layer override)
     Design source: Stitch "Ana Sayfa - Apple Style - asef sondaj"
     (dark, apple.com-style: fixed glass nav, full-screen hero,
     two product cards, minimal footer).
     Overrides shop::home.index via prependNamespace — Bagisto core untouched.
     Bagisto default header/footer disabled; Asef header/footer rendered inline.
     ============================================================ --}}
@php
    $channel = core()->getCurrentChannel();
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $instagramUrl = 'https://www.instagram.com/asefsondajj';
@endphp

@push('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? 'Asef Sondaj — Gücün ve Hassasiyetin Zirvesi' }}" />
    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? 'Endüstriyel sondajda yeni bir çağ başlıyor. Sondaj makineleri, elmas kesim teknolojisi ve yedek parça servisi.' }}" />
    <meta name="theme-color" content="#000000" />
@endpush

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" />
    <link rel="stylesheet" href="{{ url('asef/asef-home.css') }}" />
@endpush

{{-- MUST be pushed BEFORE <x-shop::layouts> renders — the layout's
     @stack('scripts') is evaluated when the component tag closes, so a
     push placed after it never reaches the page. --}}
@push('scripts')
    <script src="{{ url('asef/asef-home.js') }}" defer></script>
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? 'asef sondaj - Gücün ve Hassasiyetin Zirvesi' }}
    </x-slot>

    <div class="asef-home">
        {{-- ================= TOP NAV (fixed, glass) ================= --}}
        <nav class="asef-nav" aria-label="Ana gezinme">
            <div class="asef-nav-inner">
                <a href="{{ route('shop.home.index') }}" class="asef-brand" aria-label="asef sondaj ana sayfa">
                    <img src="{{ url('asef/asef-logo-dark.jpg') }}" alt="asef sondaj" width="28" height="28" />
                </a>

                <div class="asef-nav-links" id="asef-nav-links">
                    <a href="{{ $catalogUrl }}">Ürünler</a>
                    <a href="#hizmetler">Hizmetler</a>
                    <a href="#yedek-parca">Yedek Parça</a>
                    <a href="#teknoloji">Teknoloji</a>
                    <a href="#hakkimizda">Hakkımızda</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener">İletişim</a>
                </div>

                <div class="asef-nav-actions">
                    <a href="{{ $catalogUrl }}" class="asef-nav-icon" aria-label="Ara">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                    </a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-blue asef-btn-xs asef-nav-cta">Satın Al</a>
                    <button type="button" class="asef-nav-icon asef-nav-burger" id="asef-nav-burger" aria-label="Menü" aria-expanded="false" aria-controls="asef-nav-links">
                        <svg class="asef-ic-menu" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                        <svg class="asef-ic-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M6 6l12 12M18 6 6 18"/></svg>
                    </button>
                </div>
            </div>
        </nav>

        <main class="asef-main">
            {{-- ================= HERO ================= --}}
            <section class="asef-hero" aria-labelledby="hero-heading">
                <div class="asef-hero-bg" aria-hidden="true">
                    <img
                        src="{{ url('asef/asef-hero-rig.jpg') }}"
                        alt=""
                        width="1376" height="768"
                        fetchpriority="high"
                    />
                    <div class="asef-hero-shade"></div>
                    <div class="asef-hero-fade"></div>
                </div>

                <div class="asef-hero-content">
                    <h1 id="hero-heading">Gücün ve Hassasiyetin Zirvesi.</h1>
                    <p class="asef-hero-sub">Endüstriyel sondajda yeni bir çağ başlıyor.</p>
                    <div class="asef-hero-actions">
                        <a href="{{ $catalogUrl }}" class="asef-btn asef-btn-blue asef-btn-md">Keşfedin</a>
                        <a href="{{ $instagramUrl }}" target="_blank" rel="noopener" class="asef-btn asef-btn-outline asef-btn-md">
                            Videoyu İzle
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m10 8.5 5 3.5-5 3.5z" fill="currentColor" stroke="none"/></svg>
                        </a>
                    </div>
                </div>
            </section>

            {{-- ================= TWO PRODUCT CARDS ================= --}}
            <section class="asef-cards" id="hizmetler" aria-label="Öne çıkanlar">
                <div class="asef-cards-grid">
                    <article class="asef-card" id="teknoloji">
                        <div class="asef-card-head">
                            <h2>Elmas Kesim Teknolojisi</h2>
                            <div class="asef-card-actions">
                                <a href="{{ $catalogUrl }}" class="asef-btn asef-btn-blue asef-btn-sm">Daha Fazla Bilgi</a>
                                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-ghost asef-btn-sm">Satın Alın</a>
                            </div>
                        </div>
                        <div class="asef-card-media">
                            <div class="asef-card-vignette" aria-hidden="true"></div>
                            <img src="{{ url('asef/asef-diamond-bit.jpg') }}" alt="Elmas kesim matkap ucu" width="1024" height="1024" loading="lazy" class="is-contain" />
                        </div>
                    </article>

                    <article class="asef-card" id="yedek-parca">
                        <div class="asef-card-head">
                            <h2>Yedek Parça Servisi</h2>
                            <div class="asef-card-actions">
                                <a href="{{ $catalogUrl }}" class="asef-btn asef-btn-blue asef-btn-sm">Daha Fazla Bilgi</a>
                                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-ghost asef-btn-sm">Satın Alın</a>
                            </div>
                        </div>
                        <div class="asef-card-media">
                            <div class="asef-card-vignette" aria-hidden="true"></div>
                            <img src="{{ url('asef/asef-spare-parts.jpg') }}" alt="Yedek parçalar" width="1376" height="768" loading="lazy" class="is-cover" />
                        </div>
                    </article>
                </div>
            </section>
        </main>

        {{-- ================= FOOTER ================= --}}
        <footer class="asef-footer" id="hakkimizda">
            <div class="asef-footer-inner">
                <div class="asef-footer-brand">
                    <p class="asef-footer-name">asef sondaj</p>
                    <p class="asef-footer-copy">© {{ date('Y') }} asef sondaj. Tüm hakları saklıdır.</p>
                </div>
                <div class="asef-footer-cols">
                    <div class="asef-footer-col">
                        <a href="#">Gizlilik Politikası</a>
                        <a href="#">Kullanım Şartları</a>
                    </div>
                    <div class="asef-footer-col">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener">İletişim</a>
                        <a href="mailto:destek@asefsondaj.com">Destek</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-shop::layouts>
