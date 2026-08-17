{{-- ============================================================
     Asef Sondaj — Ana Sayfa (Adaptation Layer override)
     Design v5: Apple-esque minimalist, kompakt kategoriler, marka
     tanıtımı ağırlıklı, tarihçe timeline dahil. Bagisto core
     untouched, inline CSS, external images from public/asef.
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = asef_wa_link('Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));
@endphp

@push('meta')
    <meta name="title" content="Asef Sondaj — Sondaj Ekipmanları, Karotiyer, DTH Çekiç ve Yedek Parça | Türkiye Geneli Tedarik" />
    <meta name="description" content="Türkiye geneli sondaj ekipmanları tedariki: karotiyer, DTH çekiç, sondaj tijleri, matkap uçları, pörtkron ve yedek parça. 20 yıllık saha tecrübesi, hızlı sevkiyat, teknik danışmanlık. Bursa merkezli — 81 ilde hizmet." />
    <meta name="keywords" content="sondaj ekipmanları, sondaj makinesi yedek parça, karotiyer, DTH çekiç, sondaj tijleri, sondaj matkap uçları, pörtkron, sondaj kompresörü, karot alma ekipmanı, Türkiye sondaj tedarikçisi, Bursa sondaj" />
    <link rel="canonical" href="{{ url('/') }}" />

    {{-- LCP boost: hero image preload --}}
    <link rel="preload" as="image" href="{{ url('asef/asef-hero-rig.jpg') }}" fetchpriority="high" />

    {{-- Font preload (Inter 400+600 en kritik) --}}
    <link rel="preload" as="font" type="font/woff2" href="https://fonts.gstatic.com/s/inter/v13/UcC73FwrK3iLTeHuS_fvQtMwCp50KnMa1ZL7.woff2" crossorigin />

    {{-- WhatsApp preconnect kaldırıldı — sadece etkileşim anında açılıyor, önden bağlantı gereksiz.
         Lighthouse: 4'ten fazla preconnect ile sayfa yavaşlar. --}}

    {{-- LocalBusiness + Organization + Website JSON-LD (Google Maps + Knowledge Graph) --}}
    @php
        $localBusinessJsonLd = [
            '@context'      => 'https://schema.org',
            '@type'         => 'LocalBusiness',
            '@id'           => url('/') . '#organization',
            'name'          => 'Asef Sondaj',
            'legalName'     => 'Asef Sondaj Ekipmanları',
            'description'   => 'Türkiye geneli sondaj ekipmanı tedariki: karotiyer, DTH çekiç, sondaj tijleri, matkap uçları, pörtkron ve yedek parça. 20 yıllık saha tecrübesi.',
            'url'           => url('/'),
            'logo'          => url('asef/asef-logo.png'),
            'image'         => url('asef/asef-hero-rig.jpg'),
            'telephone'     => '+90 532 054 29 75',
            'email'         => 'iletisim@asefsondaj.com',
            'address'       => [
                '@type'           => 'PostalAddress',
                'streetAddress'   => 'Duaçınarı Mah. 1. Özgünay Sk No:10',
                'addressLocality' => 'Yıldırım',
                'addressRegion'   => 'Bursa',
                'postalCode'      => '16270',
                'addressCountry'  => 'TR',
            ],
            'geo'           => [
                '@type'     => 'GeoCoordinates',
                'latitude'  => 40.2119,
                'longitude' => 29.1000,
            ],
            'areaServed'    => [
                '@type' => 'Country',
                'name'  => 'Türkiye',
            ],
            'openingHoursSpecification' => [
                '@type'      => 'OpeningHoursSpecification',
                'dayOfWeek'  => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'opens'      => '09:00',
                'closes'     => '18:00',
            ],
            'sameAs'        => [
                'https://instagram.com/asefsondajj',
                'https://share.google/feiNpSvOEuMJtBfwL',
            ],
            'contactPoint'  => [
                '@type'         => 'ContactPoint',
                'telephone'     => '+90 532 054 29 75',
                'contactType'   => 'customer service',
                'availableLanguage' => ['Turkish'],
            ],
        ];

        $websiteJsonLd = [
            '@context'      => 'https://schema.org',
            '@type'         => 'WebSite',
            '@id'           => url('/') . '#website',
            'url'           => url('/'),
            'name'          => 'Asef Sondaj',
            'description'   => 'Türkiye geneli sondaj ekipmanları, karotiyer, DTH çekiç, tijler ve yedek parça tedariki.',
            'inLanguage'    => 'tr-TR',
            'publisher'     => ['@id' => url('/') . '#organization'],
            'potentialAction' => [
                '@type'         => 'SearchAction',
                'target'        => [
                    '@type'       => 'EntryPoint',
                    'urlTemplate' => url('search') . '?query={search_term_string}',
                ],
                'query-input'   => 'required name=search_term_string',
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($localBusinessJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <script type="application/ld+json">{!! json_encode($websiteJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    <meta name="theme-color" content="#ffffff" />
@endpush

@push('styles')
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" />
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "SF Pro Display", "Helvetica Neue", Arial, sans-serif;
            background: #FFFFFF;
            color: #1a1c1d;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            line-height: 1.5;
        }
        img { max-width: 100%; display: block; }

        .asef-root a { color: inherit; text-decoration: none; }
        .asef-root button { font-family: inherit; cursor: pointer; border: 0; background: none; }

        :root {
            --primary: #000000;
            --on-surface: #1a1c1d;
            --secondary: #5f5e60;
            --gray-secondary: #86868B;
            --outline: #D2D2D7;
            --surface-alt: #F5F5F7;
            --link-blue: #0066CC;
        }

        .asef-container { max-width: 1024px; margin: 0 auto; padding: 0 20px; }
        .asef-container-wide { max-width: 1440px; margin: 0 auto; padding: 0 20px; }
        @media (min-width: 768px) { .asef-container-wide { padding: 0 32px; } }

        /* NAV */
        .asef-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            background: rgba(255,255,255,0.82);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(210,210,215,0.5);
        }
        .asef-nav-inner {
            display: flex; align-items: center; justify-content: space-between;
            height: 56px;
            max-width: 1024px; margin: 0 auto; padding: 0 20px;
        }
        .asef-brand {
            font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary);
        }
        .asef-nav-menu { display: none; align-items: center; gap: 32px; }
        @media (min-width: 900px) { .asef-nav-menu { display: flex; } }
        .asef-nav-menu > a,
        .asef-nav-item > a {
            font-size: 13px; color: var(--secondary); font-weight: 500;
            transition: color .15s; cursor: pointer;
        }
        .asef-nav-menu > a:hover,
        .asef-nav-item:hover > a,
        .asef-nav-item:focus-within > a { color: var(--primary); }
        .asef-nav-item { position: static; }

        /* MEGA MENU */
        .asef-mega {
            position: absolute; top: 100%; left: 0; right: 0;
            background: rgba(255,255,255,0.98);
            backdrop-filter: saturate(180%) blur(20px);
            -webkit-backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(210,210,215,0.5);
            padding: 36px 0 40px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity .22s ease, transform .28s ease, visibility 0s linear .22s;
            z-index: 99;
        }
        .asef-nav-item:hover .asef-mega,
        .asef-nav-item:focus-within .asef-mega,
        .asef-mega:hover {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            transition: opacity .22s ease, transform .28s ease, visibility 0s linear 0s;
        }
        .asef-mega-grid {
            display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 60px;
            max-width: 1024px; margin: 0 auto; padding: 0 20px;
        }
        .asef-mega-col h5 {
            font-size: 12px; font-weight: 400; color: var(--gray-secondary);
            margin-bottom: 14px; letter-spacing: 0;
        }
        .asef-mega-main a {
            display: block; padding: 4px 0;
            font-size: 22px; font-weight: 600; letter-spacing: -0.01em;
            color: var(--primary); line-height: 1.3;
        }
        .asef-mega-main a:hover { color: var(--link-blue); }
        .asef-mega-side a {
            display: block; padding: 4px 0;
            font-size: 12px; color: var(--on-surface);
            font-weight: 400;
        }
        .asef-mega-side a:hover { color: var(--link-blue); }
        .asef-mega-small { margin-top: 10px; }
        .asef-mega-small a {
            display: block; padding: 3px 0;
            font-size: 12px; font-weight: 400; color: var(--secondary);
            letter-spacing: 0;
        }
        .asef-mega-small a:hover { color: var(--link-blue); }
        .asef-nav-actions { display: none; align-items: center; gap: 8px; }
        @media (min-width: 900px) { .asef-nav-actions { display: flex; } }
        .asef-nav-icon-btn {
            width: 34px; height: 34px; display: grid; place-items: center;
            color: var(--secondary); transition: color .15s; position: relative;
        }
        .asef-nav-icon-btn:hover { color: var(--primary); }
        .asef-nav-icon-btn .asef-badge {
            position: absolute; top: -1px; right: -3px;
            background: var(--link-blue); color: white;
            font-size: 9px; font-weight: 700;
            min-width: 15px; height: 15px; padding: 0 4px; border-radius: 999px;
            display: grid; place-items: center;
        }
        .asef-nav-cta,
        .asef-nav-cta:link,
        .asef-nav-cta:visited,
        .asef-nav-cta:hover,
        .asef-nav-cta:active {
            background: #0066CC !important;
            color: #FFFFFF !important;
            -webkit-text-fill-color: #FFFFFF !important;
            padding: 0 14px; height: 34px; border-radius: 999px;
            font-size: 12.5px; font-weight: 500; letter-spacing: -0.005em;
            margin-left: 8px;
            display: inline-flex !important; align-items: center; justify-content: center;
            text-decoration: none !important;
            text-transform: none !important;
            box-sizing: border-box;
            transition: background .15s, transform .15s;
        }
        .asef-nav-cta:hover { background: #0055B0 !important; transform: translateY(-1px); }
        .asef-nav-cta * { color: #FFFFFF !important; -webkit-text-fill-color: #FFFFFF !important; }
        .asef-nav-mobile-btn {
            display: grid; place-items: center; width: 34px; height: 34px; color: var(--primary);
        }
        @media (min-width: 900px) { .asef-nav-mobile-btn { display: none; } }

        .asef-main { padding-top: 56px; }

        .asef-label-caps {
            font-size: 12px; font-weight: 500; letter-spacing: 0.08em;
            text-transform: uppercase; color: var(--gray-secondary);
        }

        /* HERO */
        .asef-hero {
            max-width: 1024px; margin: 0 auto;
            padding: 40px 20px 48px;
            text-align: center;
        }
        @media (min-width: 768px) { .asef-hero { padding: 56px 20px 72px; } }
        .asef-hero h1 {
            font-size: clamp(36px, 5.8vw, 56px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.08;
            color: var(--primary); margin: 24px auto;
            max-width: 780px;
        }
        .asef-hero p {
            font-size: clamp(17px, 1.8vw, 21px);
            color: var(--gray-secondary);
            max-width: 620px; margin: 0 auto 32px;
            line-height: 1.5;
        }
        .asef-hero-ctas { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        .asef-cta-pill {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 11px 22px; border-radius: 999px;
            font-size: 15px; font-weight: 500;
            transition: opacity .15s;
        }
        .asef-cta-pill.primary { background: var(--link-blue); color: white; }
        .asef-cta-pill.primary:hover { opacity: 0.9; }
        .asef-cta-pill.ghost { color: var(--link-blue); }
        .asef-cta-pill.ghost:hover { opacity: 0.7; }
        .asef-cta-pill.white-bg { background: white; color: var(--primary); }
        .asef-cta-pill.white-bg:hover { opacity: 0.9; }
        .asef-cta-arrow { font-weight: 400; margin-left: 2px; transition: transform .2s; display: inline-block; }
        .asef-cta-pill:hover .asef-cta-arrow { transform: translateX(2px); }

        /* HERO IMAGE */
        .asef-hero-image-wrap {
            max-width: 1440px; margin: 0 auto 80px;
            padding: 0 20px;
        }
        @media (min-width: 768px) {
            .asef-hero-image-wrap { padding: 0 32px; margin-bottom: 120px; }
        }
        .asef-hero-image {
            width: 100%;
            height: 380px;
            border-radius: 20px;
            overflow: hidden;
            background: #14161a;
        }
        @media (min-width: 768px) { .asef-hero-image { height: 560px; } }
        .asef-hero-image img { width: 100%; height: 100%; object-fit: cover; }

        /* SECTION SPACING */
        .asef-section { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
        @media (min-width: 768px) { .asef-section { margin-bottom: 120px; } }
        .asef-section-wide { max-width: 1440px; margin: 0 auto 80px; padding: 0 20px; }
        @media (min-width: 768px) { .asef-section-wide { margin-bottom: 120px; padding: 0 32px; } }

        .asef-section-head {
            display: flex; align-items: flex-end; justify-content: space-between;
            margin-bottom: 32px;
        }
        .asef-section-head-left { display: flex; flex-direction: column; gap: 6px; }
        .asef-section-head h2 {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 600; letter-spacing: -0.01em; line-height: 1.1;
            color: var(--primary);
        }
        .asef-section-head-center {
            text-align: center; margin-bottom: 40px;
        }
        .asef-section-head-center .asef-label-caps { margin-bottom: 8px; }
        .asef-section-head-center h2 { margin: 0 auto; max-width: 700px; }
        .asef-section-link {
            color: var(--link-blue); font-size: 14px; font-weight: 500;
            display: none; align-items: center; gap: 4px;
        }
        @media (min-width: 768px) { .asef-section-link { display: inline-flex; } }
        .asef-section-link:hover { opacity: 0.7; }

        /* CATEGORY GRID (kompakt) */
        .asef-cat-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;
        }
        @media (min-width: 768px) { .asef-cat-grid { grid-template-columns: repeat(4, 1fr); } }
        .asef-cat-card {
            background: var(--surface-alt); border-radius: 20px; overflow: hidden;
            transition: transform .25s ease, background .2s;
            display: flex; flex-direction: column;
        }
        .asef-cat-card:hover { transform: translateY(-2px); background: #EEEEF0; }
        .asef-cat-media {
            aspect-ratio: 1/1;
            overflow: hidden;
            background: #14161a;
        }
        .asef-cat-media img { width: 100%; height: 100%; object-fit: cover; }
        .asef-cat-body {
            padding: 14px 16px 16px;
        }
        .asef-cat-title { font-size: 15px; font-weight: 600; color: var(--primary); }
        .asef-cat-meta { font-size: 12px; color: var(--gray-secondary); margin-top: 2px; }

        /* PRODUCT BENTO */
        .asef-prod-grid {
            display: grid; grid-template-columns: 1fr; gap: 16px;
        }
        @media (min-width: 768px) { .asef-prod-grid { grid-template-columns: 1fr 1fr; } }
        .asef-prod-card {
            background: var(--surface-alt); border-radius: 20px; overflow: hidden;
            display: flex; flex-direction: column;
            transition: transform .25s ease, background .2s;
        }
        .asef-prod-card:hover { transform: translateY(-2px); background: #EEEEF0; }
        .asef-prod-media {
            aspect-ratio: 16/10;
            background: #14161a;
            overflow: hidden;
        }
        .asef-prod-media img { width: 100%; height: 100%; object-fit: cover; }
        .asef-prod-body { padding: 24px; }
        .asef-prod-sku {
            font-family: "SF Mono", ui-monospace, Menlo, monospace;
            font-size: 11px; letter-spacing: 0.1em;
            color: var(--gray-secondary); margin-bottom: 6px;
        }
        .asef-prod-title {
            font-size: 22px; font-weight: 600; letter-spacing: -0.005em;
            color: var(--primary); margin-bottom: 8px;
        }
        .asef-prod-desc {
            font-size: 15px; color: var(--secondary);
            line-height: 1.5; margin-bottom: 16px;
        }
        .asef-prod-link {
            color: var(--link-blue); font-size: 14px; font-weight: 500;
        }

        /* MARKA TANITIMI */
        .asef-brand-block { text-align: center; }
        .asef-brand-block h2 {
            font-size: clamp(32px, 5vw, 48px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.1;
            color: var(--primary); max-width: 720px; margin: 20px auto 20px;
        }
        .asef-brand-block p {
            font-size: clamp(17px, 1.6vw, 19px);
            color: var(--gray-secondary); max-width: 620px; margin: 0 auto 24px;
            line-height: 1.55;
        }

        /* HIZMETLER */
        .asef-services-grid {
            display: grid; grid-template-columns: 1fr; gap: 16px;
        }
        @media (min-width: 768px) { .asef-services-grid { grid-template-columns: repeat(3, 1fr); } }
        .asef-service-card {
            background: var(--surface-alt); border-radius: 20px; padding: 32px;
        }
        .asef-service-icon {
            width: 40px; height: 40px; color: var(--primary);
            margin-bottom: 20px;
        }
        .asef-service-title {
            font-size: 22px; font-weight: 600; color: var(--primary);
            margin-bottom: 10px; letter-spacing: -0.005em;
        }
        .asef-service-desc {
            font-size: 15px; color: var(--secondary); line-height: 1.55;
        }

        /* MAKINE VITRIN */
        .asef-machine-showcase {
            position: relative; border-radius: 20px; overflow: hidden;
            height: 420px;
        }
        @media (min-width: 768px) { .asef-machine-showcase { height: 560px; } }
        .asef-machine-showcase-bg {
            position: absolute; inset: 0;
            background-size: cover; background-position: center;
        }
        .asef-machine-showcase::after {
            content: "";
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 50%, transparent 100%);
        }
        .asef-machine-content {
            position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
            padding: 32px;
            color: white;
        }
        @media (min-width: 768px) { .asef-machine-content { padding: 56px; } }
        .asef-machine-content .asef-label-caps { color: rgba(255,255,255,0.7); margin-bottom: 12px; }
        .asef-machine-content h2 {
            font-size: clamp(32px, 4.5vw, 48px);
            font-weight: 600; letter-spacing: -0.02em; line-height: 1.1;
            color: white; margin-bottom: 16px; max-width: 600px;
        }
        .asef-machine-content p {
            font-size: clamp(15px, 1.6vw, 19px);
            color: rgba(255,255,255,0.85);
            max-width: 500px; margin-bottom: 24px;
            line-height: 1.55;
        }

        /* TIMELINE */
        .asef-timeline-wrap { max-width: 720px; margin: 0 auto; padding: 20px 0; position: relative; }
        .asef-timeline-wrap::before {
            content: "";
            position: absolute; top: 20px; bottom: 20px;
            left: 50%; transform: translateX(-50%);
            width: 2px; background: #E5E5EA;
        }
        @media (max-width: 767px) {
            .asef-timeline-wrap::before { left: 12px; transform: none; }
        }
        .asef-timeline-item {
            position: relative;
            display: grid; grid-template-columns: 1fr 40px 1fr;
            align-items: center;
            margin-bottom: 32px;
        }
        .asef-timeline-item:last-child { margin-bottom: 0; }
        .asef-timeline-dot {
            position: relative; z-index: 2;
            width: 12px; height: 12px; border-radius: 999px; background: var(--primary);
            justify-self: center;
            box-shadow: 0 0 0 4px white;
        }
        .asef-timeline-content {
            background: var(--surface-alt); border-radius: 16px; padding: 20px 24px;
        }
        .asef-timeline-year {
            font-size: 24px; font-weight: 600; color: var(--primary); margin-bottom: 4px;
            letter-spacing: -0.01em;
        }
        .asef-timeline-text {
            font-size: 15px; color: var(--secondary); line-height: 1.5;
        }
        .asef-timeline-item.left .asef-timeline-content { grid-column: 1; }
        .asef-timeline-item.right .asef-timeline-content { grid-column: 3; }
        @media (max-width: 767px) {
            .asef-timeline-item { grid-template-columns: 40px 1fr; }
            .asef-timeline-dot { grid-column: 1; }
            .asef-timeline-content,
            .asef-timeline-item.left .asef-timeline-content,
            .asef-timeline-item.right .asef-timeline-content {
                grid-column: 2;
            }
        }

        /* CTA BAND */
        .asef-cta-band {
            background: var(--surface-alt); border-radius: 20px;
            padding: 48px 32px; text-align: center;
        }
        @media (min-width: 768px) { .asef-cta-band { padding: 64px 48px; } }
        .asef-cta-band .asef-label-caps { margin-bottom: 16px; }
        .asef-cta-band h2 {
            font-size: clamp(28px, 4vw, 40px);
            font-weight: 600; letter-spacing: -0.02em;
            color: var(--primary); margin-bottom: 12px; max-width: 640px;
            margin-left: auto; margin-right: auto;
        }
        .asef-cta-band p {
            font-size: 15px; color: var(--gray-secondary);
            max-width: 500px; margin: 0 auto 24px; line-height: 1.55;
        }
        .asef-cta-band-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }

        /* FOOTER */
        .asef-footer {
            border-top: 1px solid rgba(210,210,215,0.5);
            padding: 60px 0 24px;
        }
        .asef-footer-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 40px 24px;
            margin-bottom: 40px;
        }
        @media (min-width: 768px) {
            .asef-footer-grid { grid-template-columns: 1.5fr 1fr 1fr 1fr; }
        }
        .asef-footer-brand { grid-column: 1 / -1; }
        @media (min-width: 768px) { .asef-footer-brand { grid-column: auto; max-width: 300px; } }
        .asef-footer-brand .asef-brand { display: block; margin-bottom: 12px; }
        .asef-footer-brand p { font-size: 13px; color: var(--gray-secondary); line-height: 1.55; }
        .asef-footer-col h4 {
            font-size: 11px; font-weight: 600; text-transform: uppercase;
            letter-spacing: 0.08em; color: var(--gray-secondary); margin-bottom: 16px;
        }
        .asef-footer-col ul { list-style: none; }
        .asef-footer-col li { margin-bottom: 12px; font-size: 13px; color: var(--secondary); line-height: 1.55; }
        .asef-footer-col a { font-size: 13px; color: var(--secondary); }
        .asef-footer-col a:hover { color: var(--primary); }
        .asef-footer-bottom {
            padding-top: 20px;
            border-top: 1px solid rgba(210,210,215,0.5);
            display: flex; flex-direction: column; gap: 12px;
            justify-content: space-between; align-items: center;
            font-size: 12px; color: var(--gray-secondary);
        }
        @media (min-width: 768px) { .asef-footer-bottom { flex-direction: row; } }
        .asef-footer-legal { display: flex; gap: 20px; }
        .asef-footer-legal a:hover { color: var(--primary); }
    </style>
@endpush

@include('asef-adaptation::partials.v5-cart-js')

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? 'Asef Sondaj — Sondaj Teknolojisinde Geleceğe Ortak' }}
    </x-slot>

    <div class="asef-root">

        {{-- ============= NAV ============= --}}
        {{-- Use shared partial nav for consistency across all pages --}}
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO --}}
            <section class="asef-hero">
                <div class="asef-label-caps">SONDAJ EKİPMANLARI TEDARİKÇİSİ · 20 YILLIK TECRÜBE</div>
                <h1>{!! nl2br(e(asef_setting('hero_title', 'Sondaj Teknolojisinde Geleceğe Ortak.'))) !!}</h1>
                <p>{!! asef_setting('hero_subtitle', 'Yirmi yılı aşkın saha tecrübemizle Türkiye genelinde <strong>sondaj ekipmanları</strong>, <strong>karotiyer</strong>, <strong>DTH çekiç</strong>, <strong>sondaj tijleri</strong> ve <strong>yedek parça</strong> tedariki sağlıyoruz — hızlı sevkiyat, teknik danışmanlık ve satış sonrası destekle.') !!}</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill primary">Ürünleri Keşfet</a>
                    <a href="{{ url('hakkimizda') }}" class="asef-cta-pill ghost">Daha Fazla Bilgi <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            {{-- HERO IMAGE --}}
            <div class="asef-hero-image-wrap">
                <div class="asef-hero-image">
                    <img src="{{ $asefUrl('asef-hero-rig.jpg') }}" alt="Asef Sondaj sahada çalışan sondaj makinesi — Türkiye geneli sondaj ekipmanı tedariki, 20 yıllık saha tecrübesi" loading="eager" fetchpriority="high" width="1200" height="800" />
                </div>
            </div>

            {{-- URUN GRUPLARI --}}
            <section id="urunler" class="asef-section">
                <div class="asef-section-head">
                    <div class="asef-section-head-left">
                        <span class="asef-label-caps">SONDAJ EKİPMANLARI KATALOĞU</span>
                        <h2>Ürün gruplarımız.</h2>
                        <p style="font-size:15px; color:var(--secondary); line-height:1.6; margin-top:8px; max-width:600px;">15 ana kategori, 63 alt kategori, 813 ürün — karotiyer, DTH çekiç, sondaj tijleri, matkap uçları, pörtkron ve sondaj makinesi yedek parçaları tek noktadan.</p>
                    </div>
                    <a href="{{ $catalogUrl }}" class="asef-section-link">Tümünü gör <span>›</span></a>
                </div>
                <div class="asef-cat-grid">
                    @php
                        $homeCatList = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::query()
                            ->orderBy('sort')
                            ->limit(4)
                            ->get()
                            ->map(function ($k) {
                                $k->cnt = $k->products()->where('is_active', true)->count();
                                return $k;
                            });
                    @endphp
                    @foreach ($homeCatList as $_kat)
                        <a href="{{ ($_kat->slug ?? null) ? url('urunler/' . $_kat->slug) : $catalogUrl . '?ana=' . $_kat->code }}" class="asef-cat-card">
                            <div class="asef-cat-media"><img src="{{ $asefUrl($_kat->image ?: 'asef-hero-equipment.jpg') }}" alt="{{ $_kat->name }} kategorisi — sondaj ekipmanları | Asef Sondaj" loading="lazy" width="400" height="300" /></div>
                            <div class="asef-cat-body">
                                <div class="asef-cat-title">{{ $_kat->name }}</div>
                                <div class="asef-cat-meta">{{ $_kat->cnt }} ürün</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- MARKA TANITIMI --}}
            <section id="hakkimizda" class="asef-section asef-brand-block">
                <div class="asef-label-caps">HAKKIMIZDA</div>
                <h2>Yirmi yıllık saha, tek bir söz: güven.</h2>
                <p>Bursa merkezimizden Türkiye'nin 81 ilindeki sondaj operasyonlarına <strong>sondaj ekipmanları</strong>, <strong>sondaj makinesi yedek parça</strong> ve teknik danışmanlık sağlıyoruz. Karotiyer, tij, matkap ucu ve pörtkron — her ürünün arkasında 20 yıllık saha tecrübesi vardır.</p>
                <a href="{{ url('hakkimizda') }}" class="asef-cta-pill ghost">Firma hikayemiz <span class="asef-cta-arrow">›</span></a>
            </section>

            {{-- ONE CIKAN EKIPMANLAR --}}
            <section class="asef-section">
                <div class="asef-section-head">
                    <div class="asef-section-head-left">
                        <span class="asef-label-caps">ÖNE ÇIKAN</span>
                        <h2>Öne çıkan sondaj ekipmanları.</h2>
                    </div>
                    <a href="{{ $catalogUrl }}" class="asef-section-link">Tüm ürünlere bak <span>›</span></a>
                </div>
                <div class="asef-prod-grid">
                    @php
                        // AS-DTH-001 ve AS-TRC-001 gerçekte bizde yok — bu yüzden featured whitelist'ten çıkarıldı.
                        // Yerlerine AS-KRT-002 (BWL Karotiyer 3m) ve AS-EMB-002 (BWL Emprenye 3/5) eklendi.
                        $featured = \AsefSondaj\AdaptationLayer\Models\AsefProduct::query()
                            ->where('is_active', true)
                            ->whereIn('sku', ['AS-EMB-001','AS-EMB-002','AS-KRT-001','AS-KRT-002','AS-PDC-001','AS-WTJ-001'])
                            ->orderByRaw("FIELD(sku,'AS-KRT-001','AS-KRT-002','AS-EMB-001','AS-EMB-002','AS-PDC-001','AS-WTJ-001')")
                            ->get();
                    @endphp
                    @foreach ($featured as $_f)
                        <a href="{{ url('urun/' . (($_f->slug ?? null) ?: $_f->sku)) }}" class="asef-prod-card">
                            <div class="asef-prod-media"><img src="{{ url('asef/' . ($_f->image ?: 'asef-hero-equipment.jpg')) }}" alt="{{ $_f->sku }} — {{ $_f->name }} sondaj ekipmanı | Asef Sondaj" loading="lazy" width="400" height="300" /></div>
                            <div class="asef-prod-body">
                                <div class="asef-prod-sku">{{ $_f->sku }}</div>
                                <div class="asef-prod-title">{{ $_f->name }}</div>
                                <div class="asef-prod-desc">{{ optional($_f->altKategori)->name }}</div>
                                <span class="asef-prod-link">Detay <span>›</span></span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- HIZMETLER --}}
            <section id="hizmetler" class="asef-section">
                <div class="asef-section-head-center">
                    <div class="asef-label-caps">HİZMETLERİMİZ</div>
                    <h2>Ekipmandan öte, çözüm.</h2>
                    <p style="font-size:15px; color:var(--secondary); line-height:1.6; margin-top:12px; max-width:640px; margin-left:auto; margin-right:auto;">Sondaj ekipmanı seçim danışmanlığı, proje bazlı tedarik, hızlı yedek parça sevkiyatı ve satış sonrası teknik destek — Türkiye geneli hizmet.</p>
                </div>
                <div class="asef-services-grid">
                    <div class="asef-service-card">
                        <svg class="asef-service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>
                        </svg>
                        <div class="asef-service-title">Teknik Danışmanlık</div>
                        <div class="asef-service-desc">Delik çapı, formasyon ve basınç bilgilerinize göre doğru ekipmanı birlikte seçeriz.</div>
                    </div>
                    <div class="asef-service-card">
                        <svg class="asef-service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="4" y="7" width="16" height="13" rx="2"/><path d="M4 11h16"/><path d="M9 3h6v4"/>
                        </svg>
                        <div class="asef-service-title">Proje Bazlı Tedarik</div>
                        <div class="asef-service-desc">Sahaya özel çözüm ve zamanında teslimatla operasyonunuzu aksatmayız.</div>
                    </div>
                    <div class="asef-service-card">
                        <svg class="asef-service-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                        </svg>
                        <div class="asef-service-title">Satış Sonrası Destek</div>
                        <div class="asef-service-desc">Kurulum, servis ve yedek parça garantisi ile ekipmanlarınızı çalışır tutarız.</div>
                    </div>
                </div>
            </section>

            {{-- SONDAJ MAKINALARIMIZ --}}
            <section class="asef-section-wide">
                <div class="asef-machine-showcase">
                    <div class="asef-machine-showcase-bg" style="background-image: url('{{ $asefUrl('drilling-hero.jpg') }}');"></div>
                    <div class="asef-machine-content">
                        <div class="asef-label-caps">SONDAJ MAKİNALARIMIZ</div>
                        <h2>Sahada denendi. Kanıtlandı.</h2>
                        <p>Yerüstü, yeraltı ve su sondaj makineleri — tüm operasyon türleri için hazır çözümler.</p>
                        <a href="{{ url('sondaj-makinalarimiz') }}" class="asef-cta-pill white-bg">Makineleri İncele</a>
                    </div>
                </div>
            </section>

            {{-- TARIHCE --}}
            <section class="asef-section">
                <div class="asef-section-head-center">
                    <div class="asef-label-caps">TARİHÇE</div>
                    <h2>Yirmi yılın izleri.</h2>
                </div>
                <div class="asef-timeline-wrap">
                    <div class="asef-timeline-item left">
                        <div class="asef-timeline-content">
                            <div class="asef-timeline-year">2005</div>
                            <div class="asef-timeline-text">Asef Sondaj kuruldu. Bursa merkezli ilk ekipman tedarik faaliyeti başladı.</div>
                        </div>
                        <span class="asef-timeline-dot"></span>
                        <div></div>
                    </div>
                    <div class="asef-timeline-item right">
                        <div></div>
                        <span class="asef-timeline-dot"></span>
                        <div class="asef-timeline-content">
                            <div class="asef-timeline-year">2010</div>
                            <div class="asef-timeline-text">Türkiye genelinde saha operasyonları — 15 il, 60+ proje.</div>
                        </div>
                    </div>
                    <div class="asef-timeline-item left">
                        <div class="asef-timeline-content">
                            <div class="asef-timeline-year">2016</div>
                            <div class="asef-timeline-text">Yedek parça deposu ve teknik servis birimi kuruldu.</div>
                        </div>
                        <span class="asef-timeline-dot"></span>
                        <div></div>
                    </div>
                    <div class="asef-timeline-item right">
                        <div></div>
                        <span class="asef-timeline-dot"></span>
                        <div class="asef-timeline-content">
                            <div class="asef-timeline-year">2022</div>
                            <div class="asef-timeline-text">Dijital katalog ve mobil uygulama — sahaya anında erişim.</div>
                        </div>
                    </div>
                    <div class="asef-timeline-item left">
                        <div class="asef-timeline-content">
                            <div class="asef-timeline-year">2026</div>
                            <div class="asef-timeline-text">Yeni nesil web platformu — tüm katalog ve teknik desteğe tek noktadan erişim.</div>
                        </div>
                        <span class="asef-timeline-dot"></span>
                        <div></div>
                    </div>
                </div>
            </section>

            {{-- ILETISIM CTA --}}
            <section id="iletisim" class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">İLETİŞİM</div>
                    <h2>Projenizi birlikte planlayalım.</h2>
                    <p>Delik çapı, formasyon ve bağlantı bilgilerinizi paylaşın; doğru ekipman seçimini birlikte yapalım.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>

        </main>

        {{-- FOOTER --}}
        <footer class="asef-footer">
            <div class="asef-container">
                <div class="asef-footer-grid">
                    <div class="asef-footer-brand">
                        <span class="asef-brand">Asef Sondaj</span>
                        <p>20 yıllık saha tecrübesiyle sondaj ekipmanları, yedek parça ve teknik çözüm ortağınız.</p>
                    </div>
                    <div class="asef-footer-col">
                        <h4>Kurumsal</h4>
                        <ul>
                            <li><a href="{{ url('hakkimizda') }}">Hakkımızda</a></li>
                            <li><a href="{{ url('sondaj-makinalarimiz') }}">Sondaj Makinalarımız</a></li>
                            <li><a href="{{ url('hizmetlerimiz') }}">Hizmetlerimiz</a></li>
                            <li><a href="{{ url('referanslar') }}">Referanslar</a></li>
                            <li><a href="{{ url('sss') }}">SSS</a></li>
                        </ul>
                    </div>
                    <div class="asef-footer-col">
                        <h4>Katalog</h4>
                        <ul>
                            <li><a href="{{ $catalogUrl }}">Ürünler</a></li>
                            @php
                                $footAna = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::orderBy('sort')->limit(3)->get();
                            @endphp
                            @foreach ($footAna as $_fak)
                                <li><a href="{{ ($_fak->slug ?? null) ? url('urunler/' . $_fak->slug) : $catalogUrl . '?ana=' . $_fak->code }}">{{ $_fak->name }}</a></li>
                            @endforeach
                            <li><a href="{{ url('sepet') }}">Teklif Sepetim</a></li>
                        </ul>
                    </div>
                    <div class="asef-footer-col">
                        <h4>İletişim</h4>
                        <ul>
                            <li><a href="{{ $waLink }}" target="_blank" rel="noopener">+90 532 054 29 75</a></li>
                            <li><a href="mailto:iletisim@asefsondaj.com">iletisim@asefsondaj.com</a></li>
                            <li><a href="mailto:destek@asefsondaj.com">destek@asefsondaj.com</a></li>
                            <li>Duaçınarı Mah. 1. Özgünay Sk<br>No:10, Yıldırım / Bursa</li>
                        </ul>
                    </div>
                </div>
                <div class="asef-footer-bottom">
                    <div>© {{ date('Y') }} Asef Sondaj — Tüm hakları saklıdır.</div>
                    <div class="asef-footer-legal">
                        <a href="{{ url('kvkk') }}">KVKK</a>
                        <a href="{{ url('gizlilik-politikasi') }}">Gizlilik</a>
                        <a href="{{ url('cerez-politikasi') }}">Çerez</a>
                        <a href="{{ url('kullanim-sartlari') }}">Kullanım Şartları</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</x-shop::layouts>
