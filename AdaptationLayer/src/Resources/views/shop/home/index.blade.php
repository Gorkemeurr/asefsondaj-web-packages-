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
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-nav-icon" aria-label="Teklif iste">
                        <svg viewBox="0 0 14 16" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2.4 4.2h9.2L12.5 15c.03.37-.26.7-.62.7H2.12c-.36 0-.65-.33-.62-.7L2.4 4.2Z"/>
                            <path d="M4.6 4.2v-.8a2.4 2.4 0 0 1 4.8 0v.8"/>
                        </svg>
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
                <div class="asef-hero-bg" aria-hidden="true">
                    <div class="asef-hero-slide" style="background-image: url('{{ url('asef/asef-rig-2.jpg') }}');"></div>
                    <div class="asef-hero-slide" style="background-image: url('{{ url('asef/asef-rig-3.jpg') }}');"></div>
                    <div class="asef-hero-slide" style="background-image: url('{{ url('asef/asef-rig-4.jpg') }}');"></div>
                    <div class="asef-hero-slide" style="background-image: url('{{ url('asef/asef-rig-1.jpg') }}');"></div>
                </div>
                <div class="asef-hero-copy">
                    <h1 id="hero-heading">Sondaj Teknolojisinde Geleceğe Ortak.</h1>
                    <p>Yirmi yılı aşkın saha tecrübemizle Türkiye’nin en zorlu projelerinde güvenle çalışan sondaj ekipmanlarını sizinle buluşturuyoruz.</p>
                    <div class="asef-hero-actions">
                        <a href="{{ $catalogUrl }}" class="asef-btn asef-btn-blue">Ürünleri Keşfet</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-link asef-link-arrow">Daha Fazla Bilgi<span aria-hidden="true">›</span></a>
                    </div>
                </div>
            </section>

            {{-- ================= ÜRÜNLER (PREMIUM BENTO) ================= --}}
            <section class="asef-section asef-section--tight" id="hizmetler" aria-labelledby="prod-heading">
                <header class="asef-chips-head">
                    <div>
                        <span class="asef-eyebrow asef-eyebrow--dark">Öne Çıkan Portföy</span>
                        <h2 id="prod-heading">Ürünler.</h2>
                    </div>
                    <a href="{{ $catalogUrl }}" class="asef-link asef-link-arrow asef-link-blue">Tüm Ürünlere Bak<span aria-hidden="true">→</span></a>
                </header>

                @php
                    $products = [
                        [
                            'name'  => 'ERD Sondaj Makinesi',
                            'eyebrow' => 'Karot · Su · Mineral',
                            'spec'  => 'Paletli şasi · 200 m derinlik kapasitesi',
                            'image' => 'asef/asef-rig-2.jpg',
                            'span'  => 'feature',
                        ],
                        [
                            'name'  => 'Elmas Uçlu Matkap',
                            'eyebrow' => 'PCD Kesici',
                            'spec'  => 'Sert kayaç formasyonları için',
                            'image' => 'asef/asef-macro-diamond.jpg',
                            'span'  => 'tall',
                        ],
                        [
                            'name'  => 'Karot Uçları',
                            'eyebrow' => 'HQ · NQ · BQ',
                            'spec'  => 'Yüksek geri kazanım oranı',
                            'image' => 'asef/asef-diamond-bit.jpg',
                            'span'  => 'std',
                        ],
                        [
                            'name'  => 'Sondaj Tijleri',
                            'eyebrow' => 'Yüksek Mukavemet',
                            'spec'  => 'API standartlarına uygun çelik',
                            'image' => 'asef/drill-rods.jpg',
                            'span'  => 'std',
                        ],
                        [
                            'name'  => 'Çamur Pompası',
                            'eyebrow' => 'Yüksek Basınç',
                            'spec'  => 'Kesintisiz akış, endüstriyel',
                            'image' => 'asef/mud-pump.jpg',
                            'span'  => 'std',
                        ],
                        [
                            'name'  => 'Orijinal Yedek Parça',
                            'eyebrow' => 'Sistem Güvenliği',
                            'spec'  => 'Sistem ömrünü uzatan orijinal parçalar',
                            'image' => 'asef/asef-yedek-parca-bar.jpg',
                            'span'  => 'wide',
                        ],
                    ];
                @endphp
                <div class="asef-prod-grid">
                    @foreach ($products as $p)
                        <a href="{{ $catalogUrl }}" class="asef-prod asef-prod--{{ $p['span'] }}">
                            <div class="asef-prod-media" aria-hidden="true">
                                <img src="{{ url($p['image']) }}" alt="" loading="lazy" decoding="async" />
                            </div>
                            <div class="asef-prod-copy">
                                <span class="asef-prod-eyebrow">{{ $p['eyebrow'] }}</span>
                                <h3>{{ $p['name'] }}</h3>
                                <p>{{ $p['spec'] }}</p>
                                <span class="asef-prod-cta" aria-hidden="true">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- ================= 2 ÇÖZÜM KARTI ================= --}}
            <section class="asef-section" aria-label="Çözümler">
                <div class="asef-duo">
                    <a class="asef-duo-card" href="{{ $catalogUrl }}">
                        <div class="asef-duo-copy">
                            <h3>Maden Arama Çözümleri</h3>
                            <p>Derinlere inen güç, kusursuz analiz.</p>
                            <span class="asef-link asef-link-arrow asef-link-blue">İnceleyin<span aria-hidden="true">›</span></span>
                        </div>
                        <div class="asef-duo-media" aria-hidden="true">
                            <img src="{{ url('asef/asef-macro-diamond.jpg') }}" alt=""
                                 width="1200" height="900" loading="lazy" decoding="async" />
                        </div>
                    </a>

                    <a class="asef-duo-card" href="{{ $waLink }}" target="_blank" rel="noopener">
                        <div class="asef-duo-copy">
                            <h3>Su Sondajı Paketi</h3>
                            <p>Kesintisiz akış için entegre ekipman.</p>
                            <span class="asef-link asef-link-arrow asef-link-blue">Teklif Alın<span aria-hidden="true">›</span></span>
                        </div>
                        <div class="asef-duo-media" aria-hidden="true">
                            <img src="{{ url('asef/drill-rods.jpg') }}" alt=""
                                 width="1200" height="900" loading="lazy" decoding="async" />
                        </div>
                    </a>
                </div>
            </section>

            @php /* Detaylarda Gizli Mükemmellik makro galerisi kaldırıldı — CEO 2026-08-15: site daha temiz olsun. */ @endphp

            {{-- ================= PRO SEVİYE EKİPMAN (SPOTLIGHT) ================= --}}
            <section class="asef-pro" id="destek" aria-labelledby="pro-heading">
                <header class="asef-section-head asef-section-head--center">
                    <h2 id="pro-heading">Pro Seviye Ekipman.</h2>
                    <p>API standartlarına uygun, her detayı özenle seçilmiş özel alaşımlı ekipman portföyü.</p>
                </header>
                <figure class="asef-pro-stage" aria-hidden="true">
                    <span class="asef-pro-label asef-pro-label--left">
                        <span class="asef-pro-label-name">Titanyum</span>
                        <span class="asef-pro-label-desc">Özel çelik alaşım gövde.</span>
                    </span>
                    <img src="{{ url('asef/asef-macro-diamond.jpg') }}" alt=""
                         width="1200" height="900" loading="lazy" decoding="async" />
                    <span class="asef-pro-label asef-pro-label--right">
                        <span class="asef-pro-label-name">Elmas</span>
                        <span class="asef-pro-label-desc">PCD kesici uçlar.</span>
                    </span>
                </figure>
                <ul class="asef-pro-specs">
                    <li>
                        <span class="asef-pro-spec-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a13 13 0 0 1 0 18M12 3a13 13 0 0 0 0 18"/></svg>
                        </span>
                        <h3>Küresel Portföy</h3>
                        <p>50+ ülkede kanıtlanmış endüstri standardında ekipman.</p>
                    </li>
                    <li>
                        <span class="asef-pro-spec-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a5 5 0 0 0-5 5c0 3 2 4 2 6h6c0-2 2-3 2-6a5 5 0 0 0-5-5zM9 17h6M10 20h4"/></svg>
                        </span>
                        <h3>Uzman Desteği</h3>
                        <p>Saha operasyonlarınız için 7/24 profesyonel danışmanlık.</p>
                    </li>
                    <li>
                        <span class="asef-pro-spec-ic" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V8l6-4 6 4v12M4 20h16M10 20v-6h4v6"/></svg>
                        </span>
                        <h3>Hassas Tedarik</h3>
                        <p>Mikron düzeyinde toleransları karşılayan özenle seçilmiş marka portföyü.</p>
                    </li>
                </ul>
            </section>

            {{-- ================= İNOVASYONUN TEMELİ ================= --}}
            <section class="asef-innov" id="hakkimizda" aria-labelledby="innov-heading">
                <figure class="asef-innov-media">
                    <img src="{{ url('asef/asef-hero-rig.jpg') }}" alt="Asef Sondaj saha operasyonu"
                         width="1600" height="1200" loading="lazy" decoding="async" />
                </figure>
                <div class="asef-innov-copy">
                    <h2 id="innov-heading">Sahada Kanıtlanmış.</h2>

                    <ul class="asef-feature-list">
                        <li>
                            <span class="asef-feature-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
                            </span>
                            <div>
                                <h3>20+ Yıl Saha Tecrübesi</h3>
                                <p>Bursa merkezli operasyonumuz, karot ve su sondajından mineral aramaya kadar Türkiye’nin dört bir yanında iki on yılı aşkın süredir sahada.</p>
                            </div>
                        </li>
                        <li>
                            <span class="asef-feature-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6l8-4z"/><path d="M9 12l2 2 4-4"/></svg>
                            </span>
                            <div>
                                <h3>Uluslararası Kalite Ekipman</h3>
                                <p>Sondaj makineleri, tijler, karot sistemleri ve pompalar için özenle seçilmiş marka portföyü — her operasyonda güvenle çalışın.</p>
                            </div>
                        </li>
                        <li>
                            <span class="asef-feature-ic" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a4 4 0 0 0-5.66 5.66l-6.04 6.04 2.83 2.83 6.04-6.04a4 4 0 0 0 5.66-5.66l-2.24 2.24-1.83-1.83 2.24-2.24z"/></svg>
                            </span>
                            <div>
                                <h3>Türkiye Geneli Yedek Parça &amp; Servis</h3>
                                <p>Nerede sondaj yaparsanız yapın, orijinal yedek parça temini ve teknik destek WhatsApp'ın bir mesajı kadar yakın.</p>
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
