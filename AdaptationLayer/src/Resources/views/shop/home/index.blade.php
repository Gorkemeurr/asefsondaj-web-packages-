{{-- ============================================================
     Asef Sondaj — Custom Homepage (Adaptation Layer override)
     Overrides shop::home.index via prependNamespace — Bagisto core untouched.
     Bagisto default header/footer disabled; Asef header/footer rendered inline.
     ============================================================ --}}
@php
    $channel = core()->getCurrentChannel();
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
@endphp

@push('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? 'Asef Sondaj — Sondaj Makineleri, Ekipman ve Yedek Parça' }}" />
    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? 'Profesyonel sondaj makineleri, yedek parça ve teknik destek ile projelerinize değer katıyoruz.' }}" />
@endpush

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="{{ url('asef/asef-home.css') }}" />
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? 'Asef Sondaj — Sondajda Güvenilir Çözüm Ortağınız' }}
    </x-slot>

    <div class="asef-home">
        {{-- ================= HEADER ================= --}}
        <header class="asef-header">
            <div class="asef-container asef-header-inner">
                <a href="{{ route('shop.home.index') }}" class="asef-brand" aria-label="Asef Sondaj ana sayfa">
                    <img src="{{ url('asef-logo.png') }}" alt="Asef Sondaj logosu" width="40" height="40" />
                    <span class="asef-brand-word">Asef<br>Sondaj</span>
                </a>

                <nav class="asef-nav" aria-label="Ana gezinme">
                    <a href="{{ route('shop.home.index') }}" class="is-active">Ana Sayfa</a>
                    <a href="#urun-katalogu">Ürünler</a>
                    <a href="#teklif">Teklif Al</a>
                    <a href="#hakkimizda">Hakkımızda</a>
                    <a href="#iletisim">İletişim</a>
                </nav>

                <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-primary asef-header-cta">
                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.87 9.87 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm5.83 14.15c-.25.7-1.45 1.34-2.02 1.39-.52.05-1.17.07-1.89-.12a17 17 0 0 1-1.71-.63c-3.01-1.3-4.98-4.33-5.13-4.53-.15-.2-1.22-1.63-1.22-3.1 0-1.48.77-2.2 1.05-2.5.27-.3.6-.38.8-.38l.57.01c.18.01.43-.07.67.51.25.6.85 2.07.92 2.22.08.15.13.33.03.53-.1.2-.15.32-.3.5-.15.17-.32.39-.45.52-.15.15-.31.31-.13.61.18.3.79 1.31 1.7 2.12 1.17 1.04 2.16 1.37 2.46 1.52.3.15.48.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.67-.15.28.1 1.75.83 2.05.98.3.15.5.22.58.35.07.13.07.75-.18 1.4Z"/></svg>
                    Teklif Al / İletişim
                </a>
            </div>
        </header>

        {{-- ================= HERO ================= --}}
        <section class="asef-hero" aria-labelledby="hero-heading">
            <div class="asef-container asef-hero-inner">
                <div class="asef-reveal is-visible">
                    <h1 id="hero-heading">
                        Asef Sondaj ile
                        <span class="asef-hero-accent">Güçlü, Verimli ve Güvenli Sondaj Çözümleri</span>
                    </h1>

                    <p class="asef-hero-sub">
                        Profesyonel sondaj makineleri, yedek parça ve teknik destek ile
                        projelerinize değer katıyoruz.
                    </p>

                    <div class="asef-hero-actions">
                        <a href="#urun-katalogu" class="asef-btn asef-btn-primary">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                            Ürünleri Keşfet
                        </a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-glass">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5Z"/></svg>
                            Teklif Al
                        </a>
                    </div>

                    <div class="asef-hero-badges">
                        <span class="asef-hero-badge">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1Z"/><path d="m9 12 2 2 4-4"/></svg>
                            Yüksek<br>Performans
                        </span>
                        <span class="asef-hero-badge">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20a8 8 0 1 0 0-16 8 8 0 0 0 0 16Z"/><path d="M12 8v4l2.5 2.5"/></svg>
                            Uzun Ömürlü<br>Kullanım
                        </span>
                        <span class="asef-hero-badge">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 0 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"/><path d="M21 16v2a4 4 0 0 1-4 4h-5"/></svg>
                            Hızlı Teknik<br>Destek
                        </span>
                    </div>
                </div>

                <div class="asef-hero-media asef-reveal is-visible" style="--reveal-delay: 120ms">
                    <img
                        src="{{ url('asef/drilling-hero.jpg') }}"
                        alt="Sahada çalışan Asef Sondaj sondaj makinesi"
                        width="800" height="680"
                        fetchpriority="high"
                    />
                </div>
            </div>
        </section>

        {{-- ================= FEATURE CARDS ================= --}}
        <section class="asef-features" id="hakkimizda" aria-label="Hizmetlerimiz">
            <div class="asef-container asef-features-grid">
                <article class="asef-feature-card asef-reveal">
                    <span class="asef-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4v16M9 4h10M9 20h10M14 4 5 13v7h3l6-6"/><path d="M5 20h3"/></svg>
                    </span>
                    <h3>Sondaj Makinesi Çözümleri</h3>
                    <p>Farklı zemin koşulları için profesyonel makineler</p>
                    <span class="asef-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </span>
                </article>

                <article class="asef-feature-card asef-reveal" style="--reveal-delay: 80ms">
                    <span class="asef-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.01a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.01a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
                    </span>
                    <h3>Yedek Parça</h3>
                    <p>Orijinal ve uzun ömürlü parça çözümleri</p>
                    <span class="asef-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </span>
                </article>

                <article class="asef-feature-card asef-reveal" style="--reveal-delay: 160ms">
                    <span class="asef-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 11h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5Zm0 0a9 9 0 0 1 18 0m0 0v5a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3Z"/></svg>
                    </span>
                    <h3>Teknik Destek</h3>
                    <p>Uzman kadro ile 7/24 yanınızdayız</p>
                    <span class="asef-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </span>
                </article>

                <article class="asef-feature-card asef-reveal" style="--reveal-delay: 240ms">
                    <span class="asef-feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                    </span>
                    <h3>Proje Danışmanlığı</h3>
                    <p>İhtiyacınıza özel mühendislik çözümleri</p>
                    <span class="asef-card-arrow" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </span>
                </article>
            </div>
        </section>

        {{-- ================= PRODUCT CATALOG ================= --}}
        <section class="asef-catalog" id="urun-katalogu" aria-labelledby="katalog-heading">
            <div class="asef-container">
                <div class="asef-section-head asef-reveal">
                    <h2 class="asef-section-title" id="katalog-heading">Ürün Kataloğu</h2>
                    <a href="{{ route('shop.search.index') }}" class="asef-section-link">
                        Tüm Ürünleri Gör
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                    </a>
                </div>

                <p class="asef-section-sub asef-reveal">
                    Sondaj projeleriniz için güvenilir, dayanıklı ve yüksek performanslı ekipmanlar.
                </p>

                <div class="asef-catalog-grid">
                    <a href="{{ route('shop.search.index') }}" class="asef-product-card asef-reveal">
                        <span class="asef-product-media">
                            <img src="{{ url('asef/drilling-hero.jpg') }}" alt="Sondaj makinesi sahada" width="600" height="450" loading="lazy" />
                        </span>
                        <span class="asef-product-body">
                            <h3>Sondaj Makineleri</h3>
                            <p>Derinlik ve zemin koşullarına uygun profesyonel sondaj çözümleri</p>
                            <span class="asef-card-arrow" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </span>
                    </a>

                    <a href="{{ route('shop.search.index') }}" class="asef-product-card asef-reveal" style="--reveal-delay: 100ms">
                        <span class="asef-product-media">
                            <img src="{{ url('asef/drill-rods.jpg') }}" alt="Sondaj tijleri ve boruları" width="600" height="450" loading="lazy" />
                        </span>
                        <span class="asef-product-body">
                            <h3>Sondaj Ekipmanları</h3>
                            <p>Dayanıklı ve uzun ömürlü sondaj ekipmanları</p>
                            <span class="asef-card-arrow" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </span>
                    </a>

                    <a href="{{ route('shop.search.index') }}" class="asef-product-card asef-reveal" style="--reveal-delay: 200ms">
                        <span class="asef-product-media">
                            <img src="{{ url('asef/dth-hammer.jpg') }}" alt="DTH çekiç ve yedek parçalar" width="600" height="450" loading="lazy" />
                        </span>
                        <span class="asef-product-body">
                            <h3>Yedek Parçalar</h3>
                            <p>Orijinal yedek parçalar ile kesintisiz çalışma</p>
                            <span class="asef-card-arrow" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14m-6-6 6 6-6 6"/></svg>
                            </span>
                        </span>
                    </a>
                </div>
            </div>
        </section>

        {{-- ================= STATS ================= --}}
        <section class="asef-stats" aria-label="Rakamlarla Asef Sondaj">
            <div class="asef-container">
                <div class="asef-stats-inner asef-reveal">
                    <div class="asef-stat">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6"/></svg>
                        <div>
                            <div class="asef-stat-num" data-count="200" data-suffix="+">200+</div>
                            <div class="asef-stat-label">Tamamlanan Proje</div>
                        </div>
                    </div>
                    <div class="asef-stat">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <div>
                            <div class="asef-stat-num" data-count="500" data-suffix="+">500+</div>
                            <div class="asef-stat-label">Memnun Müşteri</div>
                        </div>
                    </div>
                    <div class="asef-stat">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.01a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.01a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/></svg>
                        <div>
                            <div class="asef-stat-num" data-count="15" data-suffix="+">15+</div>
                            <div class="asef-stat-label">Yıllık Tecrübe</div>
                        </div>
                    </div>
                    <div class="asef-stat">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <div>
                            <div class="asef-stat-num">Türkiye Geneli</div>
                            <div class="asef-stat-label">Hizmet Ağı</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= CTA BANNER ================= --}}
        <section class="asef-cta" id="teklif" aria-labelledby="cta-heading">
            <div class="asef-container">
                <div class="asef-cta-inner asef-reveal">
                    <div class="asef-cta-bg" style="background-image: url('{{ url('asef/drilling-hero.jpg') }}')" aria-hidden="true"></div>
                    <div class="asef-cta-content">
                        <h2 id="cta-heading">Projeniz İçin Doğru Çözüm<br>Asef Sondaj'da</h2>
                        <p>Hemen teklif almak için bizimle iletişime geçin.</p>
                    </div>
                    <div class="asef-cta-action">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-btn asef-btn-white">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.87 9.87 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm5.83 14.15c-.25.7-1.45 1.34-2.02 1.39-.52.05-1.17.07-1.89-.12a17 17 0 0 1-1.71-.63c-3.01-1.3-4.98-4.33-5.13-4.53-.15-.2-1.22-1.63-1.22-3.1 0-1.48.77-2.2 1.05-2.5.27-.3.6-.38.8-.38l.57.01c.18.01.43-.07.67.51.25.6.85 2.07.92 2.22.08.15.13.33.03.53-.1.2-.15.32-.3.5-.15.17-.32.39-.45.52-.15.15-.31.31-.13.61.18.3.79 1.31 1.7 2.12 1.17 1.04 2.16 1.37 2.46 1.52.3.15.48.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.67-.15.28.1 1.75.83 2.05.98.3.15.5.22.58.35.07.13.07.75-.18 1.4Z"/></svg>
                            WhatsApp ile Teklif Al
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= FOOTER ================= --}}
        <footer class="asef-footer" id="iletisim">
            <div class="asef-container asef-footer-inner">
                <div class="asef-footer-brand">
                    <img src="{{ url('asef-logo.png') }}" alt="Asef Sondaj logosu" width="32" height="32" />
                    <span class="asef-footer-copy">© {{ date('Y') }} Asef Sondaj. Tüm hakları saklıdır.</span>
                </div>

                <nav class="asef-footer-nav" aria-label="Alt gezinme">
                    <a href="{{ route('shop.home.index') }}">Ana Sayfa</a>
                    <a href="#urun-katalogu">Ürünler</a>
                    <a href="#teklif">Teklif Al</a>
                    <a href="#hakkimizda">Hakkımızda</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener">İletişim</a>
                </nav>

                <div class="asef-footer-social">
                    <a href="https://www.instagram.com/asefsondajj" target="_blank" rel="noopener" aria-label="Instagram">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><path d="M17.5 6.5h.01"/></svg>
                    </a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.87 9.87 0 0 0 4.79 1.22c5.46 0 9.91-4.45 9.91-9.91S17.5 2 12.04 2Zm5.83 14.15c-.25.7-1.45 1.34-2.02 1.39-.52.05-1.17.07-1.89-.12a17 17 0 0 1-1.71-.63c-3.01-1.3-4.98-4.33-5.13-4.53-.15-.2-1.22-1.63-1.22-3.1 0-1.48.77-2.2 1.05-2.5.27-.3.6-.38.8-.38l.57.01c.18.01.43-.07.67.51.25.6.85 2.07.92 2.22.08.15.13.33.03.53-.1.2-.15.32-.3.5-.15.17-.32.39-.45.52-.15.15-.31.31-.13.61.18.3.79 1.31 1.7 2.12 1.17 1.04 2.16 1.37 2.46 1.52.3.15.48.13.65-.08.18-.2.75-.87.95-1.17.2-.3.4-.25.67-.15.28.1 1.75.83 2.05.98.3.15.5.22.58.35.07.13.07.75-.18 1.4Z"/></svg>
                    </a>
                    <a href="mailto:iletisim@asefsondaj.com" aria-label="E-posta">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="3"/><path d="m2 7 10 7L22 7"/></svg>
                    </a>
                    <a href="tel:+905320542975" aria-label="Telefon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.34 1.78.65 2.62a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.46-1.22a2 2 0 0 1 2.11-.45c.84.31 1.72.53 2.62.65A2 2 0 0 1 22 16.92Z"/></svg>
                    </a>
                </div>
            </div>
        </footer>
    </div>
</x-shop::layouts>

@push('scripts')
    <script src="{{ url('asef/asef-home.js') }}" defer></script>
@endpush
