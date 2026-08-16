{{-- ============================================================
     Asef Sondaj — Hakkımızda (v5, zengin içerik + wow tasarım)
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = asef_wa_link('Merhaba, Asef Sondaj hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $stats = [
        ['n' => 20,   'suf' => '+', 'l' => 'Yıl Saha Tecrübesi'],
        ['n' => 500,  'suf' => '+', 'l' => 'Tamamlanan Proje'],
        ['n' => 81,   'suf' => '',  'l' => 'İl Hizmet Kapsamı'],
        ['n' => 150,  'suf' => '+', 'l' => 'Çözüm Ortağı Firma'],
    ];

    $values = [
        ['icon' => 'shield',    'title' => 'Güvenilirlik', 'desc' => 'Söz verdiğimiz zamanda, söz verdiğimiz koşulda teslim. Sahada bize güvenmenizin karşılığını her sipariş, her serviste veriyoruz.'],
        ['icon' => 'target',    'title' => 'Kalite',       'desc' => 'Yalnızca sahada denenmiş, standartlara uygun ekipmanları katalogumuza dahil ediyoruz. Her ürün, arkasında test var.'],
        ['icon' => 'zap',       'title' => 'Hız',          'desc' => 'Teklif isteğinden teslimatına kadar en hızlı yolu buluyor, operasyonunuzu aksatmıyoruz. WhatsApp\'tan direkt iletişim.'],
        ['icon' => 'eye',       'title' => 'Şeffaflık',    'desc' => 'Fiyattan teslim süresine, teknik özellikten alternatiflere kadar her bilgiyi net paylaşıyoruz. Sürpriz maliyet yok.'],
    ];

    $sectors = [
        ['icon' => 'mountain',  'title' => 'Madencilik',    'desc' => 'Yerüstü ve yeraltı madencilik operasyonlarında delici ekipman ve pompa çözümleri.'],
        ['icon' => 'droplet',   'title' => 'Su Sondajı',    'desc' => 'İçme suyu ve tarımsal su kuyuları için kanıtlanmış makine ve tij setleri.'],
        ['icon' => 'grid',      'title' => 'Zemin Etüdü',   'desc' => 'İnşaat öncesi zemin karakterizasyonu ve karot alma operasyonları.'],
        ['icon' => 'building',  'title' => 'İnşaat',        'desc' => 'Temel araştırma sondajları, mikropilot ve zemin iyileştirme projeleri.'],
        ['icon' => 'flame',     'title' => 'Enerji',        'desc' => 'Enerji altyapı projelerinde derin sondaj ve özel formasyon çözümleri.'],
        ['icon' => 'sun',       'title' => 'Jeotermal',     'desc' => 'Yüksek sıcaklık ve derinlik gerektiren jeotermal enerji sondajları.'],
    ];

    $process = [
        ['n' => '01', 'title' => 'Danışma',  'desc' => 'Delik çapı, formasyon ve operasyon bilgilerinizi WhatsApp\'tan paylaşıyorsunuz.'],
        ['n' => '02', 'title' => 'Teklif',   'desc' => 'Teknik ekibimiz ihtiyaca en uygun ekipmanı fiyat ve teslim süresiyle sunuyor.'],
        ['n' => '03', 'title' => 'Tedarik',  'desc' => 'Stoktan veya özel siparişle, Türkiye geneli hızlı sevkiyat.'],
        ['n' => '04', 'title' => 'Servis',   'desc' => 'Kurulum, yedek parça ve teknik destek — ekipman çalıştığı sürece yanınızdayız.'],
    ];

    $equipStrip = [
        ['img' => 'dth-hammer.jpg',        'label' => 'Delici Ekipmanlar'],
        ['img' => 'drill-rods.jpg',        'label' => 'Tij ve Borular'],
        ['img' => 'mud-pump.jpg',          'label' => 'Pompa Sistemleri'],
        ['img' => 'asef-diamond-bit.jpg',  'label' => 'Karot Ürünleri'],
    ];

    $certs = [
        'ISO 9001', 'CE Uyumlu', 'API Standart', 'DIN Onaylı', 'TSE Belgeli', '20+ Yıl Garanti',
    ];

    $timeline = [
        ['y' => 2005, 't' => 'Asef Sondaj kuruldu. Bursa merkezli ilk ekipman tedarik faaliyeti başladı.'],
        ['y' => 2010, 't' => 'Türkiye genelinde saha operasyonları — 15 il, 60+ proje.'],
        ['y' => 2016, 't' => 'Yedek parça deposu ve teknik servis birimi kuruldu.'],
        ['y' => 2019, 't' => '250+ proje eşiği geçildi. Uluslararası markalarla resmi temsilcilik.'],
        ['y' => 2022, 't' => 'Dijital katalog ve mobil uygulama — sahaya anında erişim.'],
        ['y' => 2026, 't' => 'Yeni nesil web platformu ve genişleyen ürün ailesi.'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Hakkımızda — 20 Yıllık Sondaj Ekipmanı Tedarikçisi | Asef Sondaj Bursa" />
    <meta name="description" content="Asef Sondaj — 20 yıllık saha tecrübesiyle Türkiye'nin 81 ilindeki sondaj operasyonlarına ekipman, yedek parça ve teknik danışmanlık. Bursa merkezli, karotiyer, DTH çekiç, sondaj tijleri, matkap uçları tedariği." />
    <meta name="keywords" content="Asef Sondaj hakkımızda, sondaj ekipmanı tedarikçisi, Bursa sondaj firması, 20 yıllık sondaj tecrübesi, Türkiye sondaj çözüm ortağı" />
    <link rel="canonical" href="{{ url('hakkimizda') }}" />
    <meta name="theme-color" content="#ffffff" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    /* Common section spacing */
    .ab-sec { max-width: 1024px; margin: 0 auto 90px; padding: 0 20px; }
    .ab-sec-wide { max-width: 1440px; margin: 0 auto 90px; padding: 0 20px; }
    @media (min-width: 768px) { .ab-sec, .ab-sec-wide { margin-bottom: 128px; } .ab-sec-wide { padding: 0 32px; } }

    .ab-head { text-align: center; margin-bottom: 40px; }
    .ab-head .asef-label-caps { margin-bottom: 10px; }
    .ab-head h2 { font-size: clamp(28px, 4vw, 44px); font-weight: 600; letter-spacing: -0.02em; color: var(--primary); }
    .ab-head p { font-size: 17px; color: var(--secondary); max-width: 620px; margin: 12px auto 0; line-height: 1.55; }

    /* ==================== HERO ==================== */
    .ab-hero {
        position: relative; overflow: hidden;
        max-width: 1440px; margin: 0 auto 90px;
        padding: 80px 20px 100px; text-align: center;
        border-radius: 0 0 32px 32px;
        background:
            radial-gradient(ellipse at 20% 20%, rgba(0,102,204,0.06), transparent 55%),
            radial-gradient(ellipse at 80% 80%, rgba(0,0,0,0.04), transparent 55%),
            #FFFFFF;
    }
    @media (min-width: 768px) { .ab-hero { padding: 120px 20px 140px; margin-bottom: 128px; } }
    .ab-hero h1 {
        font-size: clamp(44px, 7vw, 72px);
        font-weight: 700; letter-spacing: -0.03em; line-height: 1.02;
        color: var(--primary); margin: 24px auto 20px;
        max-width: 900px;
    }
    .ab-hero-accent { color: var(--link-blue); font-style: normal; }
    .ab-hero p {
        font-size: clamp(17px, 1.8vw, 21px);
        color: var(--gray-secondary); max-width: 620px; margin: 0 auto 32px;
        line-height: 1.55;
    }

    /* ==================== MANIFESTO ==================== */
    .ab-manifesto {
        position: relative; overflow: hidden;
        border-radius: 28px;
        background: linear-gradient(180deg, #0A0A0B 0%, #17181B 100%);
        color: #FFFFFF;
        padding: 72px 32px;
        text-align: center;
    }
    @media (min-width: 768px) { .ab-manifesto { padding: 120px 60px; } }
    .ab-manifesto::before {
        content: ""; position: absolute; inset: 0;
        background:
            radial-gradient(ellipse at 20% 20%, rgba(0,102,204,0.2), transparent 55%),
            radial-gradient(ellipse at 80% 80%, rgba(255,255,255,0.05), transparent 55%);
        pointer-events: none;
    }
    .ab-manifesto-content { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
    .ab-manifesto-label { font-size: 12px; letter-spacing: 0.14em; text-transform: uppercase; color: rgba(255,255,255,0.55); margin-bottom: 20px; }
    .ab-manifesto-text {
        font-size: clamp(24px, 3.4vw, 42px);
        font-weight: 500; letter-spacing: -0.02em; line-height: 1.25;
        color: #FFFFFF;
    }
    .ab-manifesto-text em { font-style: normal; color: #7FB8FF; }
    .ab-manifesto-sig {
        margin-top: 32px; font-size: 14px; letter-spacing: 0.08em; text-transform: uppercase;
        color: rgba(255,255,255,0.65);
    }

    /* ==================== STORY ==================== */
    .ab-story-grid { display: grid; grid-template-columns: 1fr; gap: 32px; align-items: center; }
    @media (min-width: 900px) { .ab-story-grid { grid-template-columns: 1.1fr 1fr; gap: 56px; } }
    .ab-story-media {
        aspect-ratio: 4/5; border-radius: 24px; overflow: hidden;
        background: #14161a;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 20px 60px rgba(0,0,0,0.12);
    }
    .ab-story-media img { width: 100%; height: 100%; object-fit: cover; }
    .ab-story-body { max-width: 500px; }
    .ab-story-body h2 { font-size: clamp(28px, 3.5vw, 40px); font-weight: 600; letter-spacing: -0.02em; line-height: 1.15; color: var(--primary); margin-bottom: 20px; }
    .ab-story-body p { font-size: 17px; color: var(--secondary); line-height: 1.65; margin-bottom: 16px; }

    /* ==================== STATS (3D bento) ==================== */
    .ab-stats { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
    @media (min-width: 768px) { .ab-stats { grid-template-columns: repeat(4, 1fr); gap: 18px; } }
    .ab-stat {
        position: relative; overflow: hidden;
        background: var(--surface-alt); border-radius: 24px;
        padding: 36px 26px 30px;
        transition: transform .32s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow:
            0 1px 0 rgba(255,255,255,0.95) inset,
            0 -1px 0 rgba(0,0,0,0.04) inset,
            0 4px 14px rgba(0,0,0,0.04);
    }
    .ab-stat::before {
        content: ""; position: absolute; top: 0; right: 0; width: 60%; height: 60%;
        background: radial-gradient(circle at top right, rgba(0,102,204,0.12), transparent 60%);
        pointer-events: none;
    }
    .ab-stat:hover {
        transform: translateY(-4px);
        box-shadow:
            0 1px 0 rgba(255,255,255,1) inset,
            0 -1px 0 rgba(0,0,0,0.05) inset,
            0 16px 40px rgba(0,0,0,0.1);
    }
    .ab-stat-num { display: block; font-size: clamp(24px, 2.6vw, 34px); font-weight: 600; letter-spacing: -0.02em; line-height: 1; color: var(--primary); margin-bottom: 8px; }
    .ab-stat-label { display: block; font-size: 13px; color: var(--gray-secondary); letter-spacing: 0.02em; line-height: 1.4; }

    /* ==================== VALUES ==================== */
    .ab-values { display: grid; grid-template-columns: 1fr; gap: 16px; }
    @media (min-width: 640px) { .ab-values { grid-template-columns: 1fr 1fr; } }
    @media (min-width: 900px) { .ab-values { grid-template-columns: repeat(4, 1fr); } }
    .ab-value {
        background: var(--surface-alt); border-radius: 22px; padding: 28px 24px 28px;
        display: flex; flex-direction: column; gap: 12px;
        transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
    }
    .ab-value:hover { transform: translateY(-3px) rotate(-0.3deg); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 14px 30px rgba(0,0,0,0.08); }
    .ab-value-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: #EAF1F8;
        display: grid; place-items: center; color: var(--link-blue);
    }
    .ab-value-icon svg { width: 22px; height: 22px; stroke-width: 1.9; }
    .ab-value-title { font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .ab-value-desc { font-size: 14px; color: var(--secondary); line-height: 1.55; }

    /* ==================== SECTORS ==================== */
    .ab-sectors { display: grid; grid-template-columns: 1fr; gap: 14px; }
    @media (min-width: 640px) { .ab-sectors { grid-template-columns: 1fr 1fr; } }
    @media (min-width: 900px) { .ab-sectors { grid-template-columns: repeat(3, 1fr); } }
    .ab-sector {
        position: relative; overflow: hidden;
        background: white; border: 1px solid var(--outline);
        border-radius: 22px; padding: 30px 26px;
        display: flex; flex-direction: column; gap: 10px;
        transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1), border-color .2s, box-shadow .3s;
    }
    .ab-sector:hover {
        transform: translateY(-3px);
        border-color: rgba(0,102,204,0.4);
        box-shadow: 0 14px 34px rgba(0,102,204,0.08);
    }
    .ab-sector::before {
        content: ""; position: absolute; top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, transparent, var(--link-blue), transparent);
        opacity: 0; transition: opacity .3s;
    }
    .ab-sector:hover::before { opacity: 1; }
    .ab-sector-icon-wrap {
        width: 44px; height: 44px; border-radius: 12px;
        background: #EAF1F8;
        display: grid; place-items: center;
        margin-bottom: 4px;
    }
    .ab-sector-icon { width: 22px; height: 22px; color: var(--link-blue); stroke-width: 1.9; }
    .ab-sector h3 { font-size: 18px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .ab-sector p { font-size: 14px; color: var(--secondary); line-height: 1.55; }

    /* ==================== PROCESS ==================== */
    .ab-process { display: grid; grid-template-columns: 1fr; gap: 20px; position: relative; }
    @media (min-width: 768px) { .ab-process { grid-template-columns: repeat(4, 1fr); gap: 20px; } }
    .ab-process-step {
        position: relative;
        background: var(--surface-alt); border-radius: 22px; padding: 32px 26px 30px;
        transition: transform .3s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
    }
    .ab-process-step:hover { transform: translateY(-3px); }
    .ab-process-num {
        display: inline-block;
        font-family: "SF Mono", ui-monospace, Menlo, monospace;
        font-size: 12px; letter-spacing: 0.14em; color: var(--gray-secondary);
        margin-bottom: 16px;
    }
    .ab-process-title { font-size: 22px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); margin-bottom: 8px; }
    .ab-process-desc { font-size: 14px; color: var(--secondary); line-height: 1.55; }
    .ab-process-dot {
        position: absolute; top: 40px; right: -13px;
        width: 26px; height: 26px; border-radius: 999px;
        background: white; border: 1px solid var(--outline);
        display: none; place-items: center;
        color: var(--gray-secondary); z-index: 2;
    }
    @media (min-width: 768px) {
        .ab-process-step:not(:last-child) .ab-process-dot { display: grid; }
    }

    /* ==================== EQUIPMENT STRIP ==================== */
    .ab-equip { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (min-width: 768px) { .ab-equip { grid-template-columns: repeat(4, 1fr); gap: 16px; } }
    .ab-equip-item {
        position: relative; aspect-ratio: 3/4; border-radius: 22px; overflow: hidden;
        background: #14161a;
        transition: transform .32s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .ab-equip-item:hover { transform: translateY(-3px); }
    .ab-equip-item img { width: 100%; height: 100%; object-fit: cover; transition: transform .6s; }
    .ab-equip-item:hover img { transform: scale(1.06); }
    .ab-equip-item::after {
        content: ""; position: absolute; inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.75) 0%, rgba(0,0,0,0.2) 40%, transparent 70%);
    }
    .ab-equip-label {
        position: absolute; left: 20px; bottom: 20px; z-index: 2;
        color: #FFFFFF; font-size: 15px; font-weight: 600; letter-spacing: -0.005em;
    }

    /* ==================== CERTIFICATES ==================== */
    .ab-certs { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (min-width: 640px) { .ab-certs { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 900px) { .ab-certs { grid-template-columns: repeat(6, 1fr); } }
    .ab-cert {
        background: white; border: 1px solid var(--outline);
        border-radius: 18px; padding: 22px 16px;
        display: flex; flex-direction: column; align-items: center; gap: 8px;
        transition: transform .28s cubic-bezier(0.16, 1, 0.3, 1), box-shadow .3s;
        text-align: center;
    }
    .ab-cert:hover { transform: translateY(-3px); box-shadow: 0 12px 30px rgba(0,0,0,0.06); }
    .ab-cert-icon {
        width: 36px; height: 36px; color: var(--link-blue);
    }
    .ab-cert-label { font-size: 13px; font-weight: 600; color: var(--primary); letter-spacing: -0.005em; }

    /* ==================== TEAM ==================== */
    .ab-team {
        background: var(--surface-alt); border-radius: 28px; overflow: hidden;
        display: grid; grid-template-columns: 1fr;
    }
    @media (min-width: 900px) { .ab-team { grid-template-columns: 1fr 1fr; } }
    .ab-team-img {
        aspect-ratio: 4/3; background: #14161a;
    }
    .ab-team-img img { width: 100%; height: 100%; object-fit: cover; }
    .ab-team-body { padding: 40px 32px; display: flex; flex-direction: column; justify-content: center; gap: 16px; }
    @media (min-width: 900px) { .ab-team-body { padding: 56px 48px; } }
    .ab-team-body h3 { font-size: clamp(24px, 3vw, 32px); font-weight: 600; letter-spacing: -0.02em; color: var(--primary); }
    .ab-team-body p { font-size: 16px; color: var(--secondary); line-height: 1.65; }

    /* ==================== TIMELINE (deeper) ==================== */
    .ab-timeline { max-width: 720px; margin: 0 auto; padding: 20px 0; position: relative; }
    .ab-timeline::before {
        content: ""; position: absolute; top: 20px; bottom: 20px; left: 50%; transform: translateX(-50%);
        width: 2px; background: linear-gradient(180deg, transparent, #E5E5EA, transparent);
    }
    @media (max-width: 767px) { .ab-timeline::before { left: 12px; transform: none; } }
    .ab-tl-item {
        position: relative;
        display: grid; grid-template-columns: 1fr 40px 1fr;
        align-items: center; margin-bottom: 32px;
    }
    .ab-tl-item:last-child { margin-bottom: 0; }
    .ab-tl-dot {
        justify-self: center; width: 14px; height: 14px; border-radius: 999px;
        background: var(--primary);
        box-shadow: 0 0 0 4px white, 0 0 0 5px rgba(0,0,0,0.06), 0 6px 14px rgba(0,102,204,0.18);
        position: relative; z-index: 2;
    }
    .ab-tl-content {
        background: var(--surface-alt); border-radius: 18px; padding: 22px 26px;
        transition: transform .3s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 14px rgba(0,0,0,0.04);
    }
    .ab-tl-content:hover { transform: translateY(-2px); }
    .ab-tl-year { font-size: 26px; font-weight: 700; color: var(--primary); letter-spacing: -0.02em; margin-bottom: 4px; }
    .ab-tl-text { font-size: 15px; color: var(--secondary); line-height: 1.55; }
    .ab-tl-item.l .ab-tl-content { grid-column: 1; }
    .ab-tl-item.r .ab-tl-content { grid-column: 3; }
    @media (max-width: 767px) {
        .ab-tl-item { grid-template-columns: 40px 1fr; }
        .ab-tl-dot { grid-column: 1; }
        .ab-tl-content, .ab-tl-item.l .ab-tl-content, .ab-tl-item.r .ab-tl-content { grid-column: 2; }
    }

    /* Reveal — content is ALWAYS visible; no opacity trick. Guaranteed to render even without JS. */
    .ab-reveal { }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Hakkımızda — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO --}}
            <section class="ab-hero ab-reveal">
                <div class="asef-label-caps">HAKKIMIZDA</div>
                <h1>Yirmi yıllık saha,<br>tek bir söz: <span class="ab-hero-accent">güven.</span></h1>
                <p>{{ asef_setting('hakkimizda_hero_desc', "Bursa merkezimizden Türkiye'nin dört bir yanındaki sondaj operasyonlarına ekipman, yedek parça ve teknik çözüm sunuyoruz. Sahaya hazır olan biziz.") }}</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill primary">Ürünleri Keşfet</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">Uzmana Sor <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            {{-- MANIFESTO --}}
            <section class="ab-sec-wide ab-reveal">
                <div class="ab-manifesto">
                    <div class="ab-manifesto-content">
                        <div class="ab-manifesto-label">MARKAMIZIN MANİFESTOSU</div>
                        <p class="ab-manifesto-text">Her sondaj, sahadaki güveni test eder.<br>Bizim işimiz — o güveni, yirmi yıldır <em>hiç bozmadan taşımak.</em></p>
                        <div class="ab-manifesto-sig">Asef Sondaj · Bursa · 2005</div>
                    </div>
                </div>
            </section>

            {{-- MARKA HIKAYESI --}}
            <section class="ab-sec-wide ab-reveal">
                <div class="ab-story-grid">
                    <div class="ab-story-media"><img src="{{ $asefUrl('asef-hero-rig.jpg') }}" alt="Asef Sondaj sahada" loading="lazy" width="1200" height="800"></div>
                    <div class="ab-story-body">
                        <h2>Sahaya hazır çözümler, mühendislikte hassasiyet.</h2>
                        <p>Asef Sondaj, 2005'ten bu yana Türkiye'nin sondaj sektöründe faaliyet gösteren, Bursa merkezli teknik çözüm ortağıdır. Delici ekipmandan pompa sistemlerine, tijden karot ürünlerine kadar geniş bir yelpazede ürün ve hizmet sunuyoruz.</p>
                        <p>Her bir ürünün arkasında saha tecrübesi, her bir sevkiyatın arkasında teknik danışmanlık vardır. Amacımız, sondaj operasyonlarınızda güvenli, kesintisiz ve verimli çözümler sağlamak.</p>
                        <p>Bizi farklı kılan; ürünün ötesinde çözümü, teslimatın ötesinde teknik desteği ve tek satışın ötesinde uzun soluklu iş birliğini önemsememizdir. Her müşteri, her proje bizim için bir referans.</p>
                    </div>
                </div>
            </section>

            {{-- RAKAMLAR --}}
            <section class="ab-sec ab-reveal">
                <div class="ab-stats">
                    @foreach ($stats as $s)
                        <div class="ab-stat">
                            <span class="ab-stat-num" data-count-to="{{ $s['n'] }}" data-suffix="{{ $s['suf'] }}">{{ $s['n'] . $s['suf'] }}</span>
                            <span class="ab-stat-label">{{ $s['l'] }}</span>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- DEĞERLER --}}
            <section class="ab-sec ab-reveal">
                <div class="ab-head">
                    <div class="asef-label-caps">DEĞERLERİMİZ</div>
                    <h2>Uzun soluklu iş birliğinin dört temeli.</h2>
                    <p>Yirmi yıldır tekrarladığımız her satış ve servis, aynı prensiplere dayanıyor.</p>
                </div>
                <div class="ab-values">
                    @foreach ($values as $v)
                        <div class="ab-value">
                            <div class="ab-value-icon">
                                @if ($v['icon'] === 'shield')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                                @elseif ($v['icon'] === 'target')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2" fill="currentColor"/></svg>
                                @elseif ($v['icon'] === 'zap')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                @endif
                            </div>
                            <div class="ab-value-title">{{ $v['title'] }}</div>
                            <div class="ab-value-desc">{{ $v['desc'] }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- SEKTÖRLER --}}
            <section class="ab-sec ab-reveal">
                <div class="ab-head">
                    <div class="asef-label-caps">HİZMET VERDİĞİMİZ SEKTÖRLER</div>
                    <h2>Türkiye'nin her sondaj alanında.</h2>
                    <p>Madencilikten enerjiye, su sondajından zemin etüdüne — bir çok sektörde profesyonel çözüm ortağınız.</p>
                </div>
                <div class="ab-sectors">
                    @foreach ($sectors as $sec)
                        <div class="ab-sector">
                            <svg class="ab-sector-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                                @switch($sec['icon'])
                                    @case('mountain') <path d="m8 3 4 8 5-5 5 15H2L8 3z"/> @break
                                    @case('droplet')  <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/> @break
                                    @case('grid')     <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/> @break
                                    @case('building') <rect x="4" y="2" width="16" height="20" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/> @break
                                    @case('flame')    <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z"/> @break
                                    @case('sun')      <circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/> @break
                                @endswitch
                            </svg>
                            <h3>{{ $sec['title'] }}</h3>
                            <p>{{ $sec['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- NASIL ÇALIŞIYORUZ --}}
            <section class="ab-sec ab-reveal">
                <div class="ab-head">
                    <div class="asef-label-caps">NASIL ÇALIŞIYORUZ</div>
                    <h2>Basit, hızlı ve şeffaf süreç.</h2>
                    <p>WhatsApp'tan attığınız mesajdan servise kadar dört adımda tamamlıyoruz.</p>
                </div>
                <div class="ab-process">
                    @foreach ($process as $p)
                        <div class="ab-process-step">
                            <span class="ab-process-num">{{ $p['n'] }}</span>
                            <div class="ab-process-title">{{ $p['title'] }}</div>
                            <p class="ab-process-desc">{{ $p['desc'] }}</p>
                            <div class="ab-process-dot" aria-hidden="true">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- EQUIPMENT STRIP --}}
            <section class="ab-sec-wide ab-reveal">
                <div class="ab-head">
                    <div class="asef-label-caps">EKİPMAN AİLESİ</div>
                    <h2>Sondaj operasyonunun her katmanına dokunuyoruz.</h2>
                </div>
                <div class="ab-equip">
                    @foreach ($equipStrip as $e)
                        <a href="{{ $catalogUrl }}" class="ab-equip-item">
                            <img src="{{ $asefUrl($e['img']) }}" alt="{{ $e['label'] }}" loading="lazy" width="300" height="300">
                            <span class="ab-equip-label">{{ $e['label'] }}</span>
                        </a>
                    @endforeach
                </div>
            </section>

            {{-- SONDAJ MAKINALARIMIZ CINEMATIC --}}
            <section class="ab-sec-wide ab-reveal">
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

            {{-- TARIHÇE --}}
            <section class="ab-sec ab-reveal">
                <div class="ab-head">
                    <div class="asef-label-caps">TARİHÇE</div>
                    <h2>Yirmi yılın izleri.</h2>
                    <p>Kuruluşumuzdan bugüne uzanan dönüm noktaları.</p>
                </div>
                <div class="ab-timeline">
                    @foreach ($timeline as $i => $t)
                        <div class="ab-tl-item {{ $i % 2 === 0 ? 'l' : 'r' }}">
                            @if ($i % 2 === 0)
                                <div class="ab-tl-content"><div class="ab-tl-year">{{ $t['y'] }}</div><div class="ab-tl-text">{{ $t['t'] }}</div></div>
                                <span class="ab-tl-dot"></span>
                                <div></div>
                            @else
                                <div></div>
                                <span class="ab-tl-dot"></span>
                                <div class="ab-tl-content"><div class="ab-tl-year">{{ $t['y'] }}</div><div class="ab-tl-text">{{ $t['t'] }}</div></div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- EKİBİMİZ --}}
            <section class="ab-sec ab-reveal">
                <div class="ab-team">
                    <div class="ab-team-img">
                        <img src="{{ $asefUrl('asef-hero-equipment.jpg') }}" alt="Asef Sondaj ekibi" loading="lazy" width="800" height="600">
                    </div>
                    <div class="ab-team-body">
                        <div class="asef-label-caps">EKİBİMİZ</div>
                        <h3>Sahada yıllarını geçirmiş bir ekip.</h3>
                        <p>Teknik danışmanlarımızın, servis uzmanlarımızın ve operasyon ekibimizin ortak paydası: hepsi sahada büyüdü. Her ürünü sattığımız değil, kullandığımız için biliyoruz.</p>
                        <p>Sorularınıza teori değil, deneyimden yanıt veriyoruz.</p>
                        <div style="margin-top: 8px;">
                            <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Ekibimizle Konuş</a>
                        </div>
                    </div>
                </div>
            </section>

            {{-- İLETİŞİM CTA --}}
            <section class="ab-sec ab-reveal">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">İLETİŞİM</div>
                    <h2>Projenizi birlikte planlayalım.</h2>
                    <p>Delik çapı, formasyon ve bağlantı bilgilerinizi paylaşın; teknik ekibimiz size en uygun çözümü önerir.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>

        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>

    {{-- Reveal + counter animasyonu --}}
    @push('scripts')
    <script>
    (function () {
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (!reduce) document.documentElement.classList.add('js-ready');

        var reveals = document.querySelectorAll('.ab-reveal');
        setTimeout(function () { reveals.forEach(function (el) { el.classList.add('visible'); }); }, 2000);

        if (reveals.length && !reduce && 'IntersectionObserver' in window) {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (e.isIntersecting) { e.target.classList.add('visible'); io.unobserve(e.target); }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
            reveals.forEach(function (el) { io.observe(el); });
        } else {
            reveals.forEach(function (el) { el.classList.add('visible'); });
        }

        // Counter
        var counters = document.querySelectorAll('[data-count-to]');
        if (counters.length && !reduce && 'IntersectionObserver' in window) {
            var cio = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    var el = e.target; cio.unobserve(el);
                    var target = parseInt(el.getAttribute('data-count-to'), 10) || 0;
                    var suffix = el.getAttribute('data-suffix') || '';
                    var duration = 1600, start = performance.now();
                    el.textContent = '0' + suffix;
                    function tick(now) {
                        var t = Math.min(1, (now - start) / duration);
                        var eased = 1 - Math.pow(1 - t, 3);
                        var v = Math.floor(target * eased);
                        el.textContent = v + suffix;
                        if (t < 1) requestAnimationFrame(tick);
                        else el.textContent = target + suffix;
                    }
                    requestAnimationFrame(tick);
                });
            }, { threshold: 0.4 });
            counters.forEach(function (c) { cio.observe(c); });
        }
    })();
    </script>
    @endpush
</x-shop::layouts>
