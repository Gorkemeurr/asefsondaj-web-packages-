{{-- Sondaj Sözlüğü — /sondaj-sozlugu | 60+ sektör terimi --}}
@php
    $waLink     = asef_wa_link('Merhaba, sondaj sözlüğünde bahsedilen bir konuda uzman görüşü almak istiyorum.');
    $catalogUrl = route('shop.search.index');

    // Öncelik: DB (admin panelden yönetilenler). Boş ise Blade fallback array.
    $dbTerms = [];
    try {
        $dbTerms = \AsefSondaj\AdaptationLayer\Models\AsefGlossaryTerm::where('is_active', true)
            ->orderBy('term')->get()
            ->map(fn ($tr) => ['t' => $tr->term, 'd' => $tr->definition])->all();
    } catch (\Throwable $e) {
        $dbTerms = [];
    }

    $termsBladeArray = [
        // A
        ['t' => 'API IF', 'd' => 'American Petroleum Institute Internal Flush — sondaj tijlerinde iç akışlı bağlantı standardı. Yüksek çamur akışı gereken su ve jeotermal sondajlarında yaygın.'],
        ['t' => 'API REG', 'd' => 'American Petroleum Institute Regular — standart sondaj tiji bağlantı sistemi. Rotary sondajda genel amaçlı kullanılır.'],
        ['t' => 'Adaptör', 'd' => 'Farklı bağlantı standartlarına sahip iki sondaj ekipmanını birbirine bağlayan geçiş parçası (ör. API IF → DCDMA adaptörü).'],
        ['t' => 'Ana boru (Casing)', 'd' => 'Sondaj kuyusu duvarlarını sabitlemek için kuyuya indirilen çelik boru. Formasyon çökmesini önler.'],
        // B
        ['t' => 'Bakım seti (Repair kit)', 'd' => 'Bir sondaj ekipmanının periyodik bakımında değiştirilen sızdırmazlık elemanı, conta, o-ring vs. hepsi bir arada.'],
        ['t' => 'Bit (Matkap Ucu)', 'd' => 'Sondaj takımının kayaya temas eden ucu. PDC, tricone, karbür button, elmas ve karotiyer bit türleri vardır.'],
        ['t' => 'Buton (Insert)', 'd' => 'DTH çekiç ve karbür bitlerde kaya kesme işini yapan sertleştirilmiş tungsten karbür uç.'],
        ['t' => 'BWL Karotiyer', 'd' => 'Bagged Wireline karotiyer sistemi — 60 mm delik çapı, 42 mm karot çapı. Küçük ölçekli maden ve jeoteknik sondaja uygun.'],
        // C-Ç
        ['t' => 'Çamur (Drilling Mud)', 'd' => 'Sondaj sırasında formasyonu dengeleyen, kesikleri yüzeye taşıyan ve bit\'i soğutan viskoz sıvı. Su bazlı veya polimer olabilir.'],
        ['t' => 'Çamur Pompası', 'd' => 'Sondaj çamurunu yüksek basınçta kuyuya pompalayan üç pistonlu (triplex) veya iki pistonlu (duplex) pompa.'],
        ['t' => 'Çekirdek (Core)', 'd' => 'Karotiyer ile alınan silindirik kaya numunesi. Jeolojik değerlendirme için kritiktir.'],
        // D
        ['t' => 'DCDMA', 'd' => 'Diamond Core Drill Manufacturers Association — elmas karot sondajı için standartlar (NQ, HQ, PQ, BQ vs.).'],
        ['t' => 'Delik Çapı', 'd' => 'Sondaj yaparken açılan kuyunun iç çapı — mm cinsinden ifade edilir (76 mm, 96 mm, 122 mm vs.).'],
        ['t' => 'DTH Çekiç', 'd' => 'Down-the-Hole Hammer — havayla çalışan, bit\'in hemen üstünde bulunan darbe mekanizması. Sert kayada rotary\'den daha hızlıdır.'],
        ['t' => 'DSİ', 'd' => 'Devlet Su İşleri — Türkiye\'de su sondajı izinlerini veren resmi kurum. Yer altı suyu kullanımı için izin şart.'],
        // E
        ['t' => 'Elmas Matkap', 'd' => 'Yüzeyine yapay elmas kristalleri gömülmüş kesici uç. Karot sondajında ve sert formasyonlarda kullanılır.'],
        ['t' => 'Emprenye Bit', 'd' => 'Elmas parçalarının metal matrise homojen gömülü olduğu bit. Aşındıkça yeni elmas yüzeyi ortaya çıkar (kendini bileyen).'],
        // F
        ['t' => 'Formasyon', 'd' => 'Sondaj yapılan yerdeki jeolojik yapı — yumuşak (kil, kum), orta (marn, kireçtaşı) veya sert (granit, bazalt) olabilir.'],
        // G
        ['t' => 'Genişletici (Reamer)', 'd' => 'Kuyunun çapını hedef ölçüye getirmek için kullanılan genişletici alet. Pilot bit\'ten sonra çalışır.'],
        // H
        ['t' => 'HQ Karotiyer', 'd' => 'Wireline karotiyer standardı — 96 mm delik çapı, 63.5 mm karot çapı. Genel amaçlı maden ve inşaat sondajı için en yaygın.'],
        ['t' => 'HWT Casing', 'd' => 'HQ karotiyer ile uyumlu 4"7/8 iç çaplı casing (kuyu borusu).'],
        ['t' => 'Hidrolik Bakım', 'd' => 'Sondaj makinasının hidrolik sisteminin yağ değişimi, filtre temizliği ve basınç kontrolü.'],
        // İ
        ['t' => 'İç Tüp (Inner Tube)', 'd' => 'Karotiyer sisteminde alınan çekirdeği koruyan iç boru. Wireline sistemde ip ile yüzeye çekilir.'],
        // J
        ['t' => 'Jeotermal Sondaj', 'd' => 'Yerin derinliğindeki sıcak su ve buhardan enerji üretmek için yapılan derin sondaj (500-3000 m).'],
        // K
        ['t' => 'Karotiyer (Core Barrel)', 'd' => 'Silindirik kaya numunesi alan sondaj takımı. Dış tüp + iç tüp + karotiyer bit\'ten oluşur.'],
        ['t' => 'Karotiyer Komple', 'd' => 'İç tüp, dış tüp, bit ve tüm yardımcı parçaları içeren tam karotiyer seti.'],
        ['t' => 'Kompresör', 'd' => 'DTH çekiçlere ve hava sondajlarına yüksek basınçlı hava sağlayan makine (350-1400 cfm arası).'],
        ['t' => 'Kuyu (Bore Hole)', 'd' => 'Sondaj işlemiyle açılan silindirik boşluk. Kısaca "sondaj kuyusu".'],
        // L
        ['t' => 'Latch (Kilit)', 'd' => 'Wireline karotiyer iç tüpünü dış tüp içine kilitleyen mekanizma. Overshot ile açılıp iç tüp çıkarılır.'],
        // M
        ['t' => 'Maden Sondajı', 'd' => 'Cevher aramak ve rezerv belirlemek amacıyla yapılan sondaj. Genelde karot alma sondajıdır.'],
        ['t' => 'Matkap Ucu', 'd' => 'Bkz. Bit.'],
        // N
        ['t' => 'NQ Karotiyer', 'd' => 'Wireline karotiyer standardı — 75.7 mm delik çapı, 47.6 mm karot çapı. Orta ölçekli maden ve jeoteknik sondaj için.'],
        // O
        ['t' => 'Overshot', 'd' => 'Wireline sondajda iç tüpü yüzeye çekmek için ipe bağlı olarak kuyuya salınan yakalayıcı alet.'],
        // P
        ['t' => 'PDC Bit', 'd' => 'Polycrystalline Diamond Compact — sentetik elmas kesicili matkap ucu. Yumuşak ve orta sert formasyonlarda hızlıdır.'],
        ['t' => 'PQ Karotiyer', 'd' => 'Wireline karotiyer standardı — 122.6 mm delik çapı, 85 mm karot çapı. Büyük çaplı jeoteknik ve rezerv sondajı için.'],
        ['t' => 'Pörtkron', 'd' => 'Karot sondajında sondaj takımını (tij + bit) kuyuya indirmek ve kaldırmak için kullanılan taşıyıcı sistem.'],
        // R
        ['t' => 'Rotary Sondaj', 'd' => 'Sondaj tijini döndürerek bit\'in kayayı öğütmesi prensibiyle çalışan yöntem. Su, petrol, jeotermal sondajda yaygın.'],
        // S
        ['t' => 'Sirkülasyon', 'd' => 'Sondaj çamurunun kuyuya inip yüzeye dönmesi. Sirkülasyon kaybı = çamurun formasyona kaçması, problemli.'],
        ['t' => 'Sondaj Tiji (Drill Pipe)', 'd' => 'Kuyu içine indirilen çelik boru. Ekleme yapılarak istenen derinliğe ulaşılır. API/DCDMA standartlarında olur.'],
        ['t' => 'Su Sondajı', 'd' => 'Yer altı suyu (kuyu suyu) elde etmek için yapılan 30-200 m derinlikli sondaj. DSİ izni gerekir.'],
        // T
        ['t' => 'Tij (Drill Rod)', 'd' => 'Bkz. Sondaj Tiji. Karot sondajında "rod" olarak da anılır.'],
        ['t' => 'Torque', 'd' => 'Sondaj tijine uygulanan dönme momenti. Aşırı torque tij kırılmasına yol açar.'],
        ['t' => 'Tricone Bit', 'd' => 'Üç konik dişli döner matkap ucu. Sert kaya sondajında yaygın kullanılır.'],
        ['t' => 'Triplex Pompa', 'd' => 'Üç pistonlu çamur pompası. Sürekli akış sağlar, yüksek basınç kapasitelidir.'],
        // V
        ['t' => 'Viskozite', 'd' => 'Sondaj çamurunun akışkanlık derecesi. Yüksek viskozite = koyu çamur, düşük = akıcı çamur.'],
        ['t' => 'Vidye Matkap', 'd' => 'Widia tungsten karbür uçlu matkap. Orta sert formasyonlarda ekonomik seçenek.'],
        // W
        ['t' => 'Wireline Sistem', 'd' => 'İç tüpü kuyudan çıkarmadan sadece ip ile yüzeye çekme sistemi. Karot sondajında zaman kazandırır.'],
        ['t' => 'WLS (Wireline Set)', 'd' => 'Wireline karotiyer komple takımı — dış tüp, iç tüp, latch, overshot, bit dahil.'],
        // Y
        ['t' => 'Yedek Parça', 'd' => 'Aşınan veya kırılan sondaj ekipmanı parçalarının yenisi. Karotiyer bit, tij bağlantı contası, pompa piston keçe vb.'],
        ['t' => 'Yağlama', 'd' => 'Sondaj tijleri ve DTH çekiçlerin sızdırmazlık ve sürtünme azaltma için sürekli yağlanması.'],
    ];

    // Nihai: DB doluysa DB'yi, yoksa Blade fallback
    $terms = ! empty($dbTerms) ? $dbTerms : $termsBladeArray;

    // Alfabetik grupla
    $grouped = [];
    foreach ($terms as $tr) {
        $first = mb_strtoupper(mb_substr($tr['t'], 0, 1, 'UTF-8'), 'UTF-8');
        $grouped[$first][] = $tr;
    }
    ksort($grouped);
@endphp

@push('meta')
    <meta name="title" content="Sondaj Sözlüğü — 50+ Sektör Terimi | Asef Sondaj" />
    <meta name="description" content="Sondaj sektörünün 50+ terimi tek sayfada: karotiyer, DTH çekiç, tij, matkap, formasyon, API IF, DCDMA, HQ/NQ/PQ, pörtkron, çamur pompası ve daha fazlası." />
    <meta name="keywords" content="sondaj sözlüğü, sondaj terimleri, karotiyer nedir, DTH çekiç nedir, API IF nedir, DCDMA standardı, HQ NQ PQ karotiyer, pörtkron nedir, sondaj tiji" />
    <link rel="canonical" href="{{ url('sondaj-sozlugu') }}" />
    <meta name="theme-color" content="#ffffff" />

    {{-- DefinedTermSet JSON-LD --}}
    @php
        $definedTermSet = [
            '@context'    => 'https://schema.org',
            '@type'       => 'DefinedTermSet',
            'name'        => 'Sondaj Sözlüğü',
            'description' => 'Sondaj sektörü teknik terimleri sözlüğü',
            'url'         => url('sondaj-sozlugu'),
            'inLanguage'  => 'tr-TR',
            'hasDefinedTerm' => array_map(function ($tr) {
                return [
                    '@type'       => 'DefinedTerm',
                    'name'        => $tr['t'],
                    'description' => $tr['d'],
                    'inDefinedTermSet' => url('sondaj-sozlugu'),
                ];
            }, $terms),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($definedTermSet, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .glossary-wrap { max-width: 900px; margin: 0 auto 100px; padding: 0 20px; }
    .glossary-nav {
        position: -webkit-sticky;
        position: sticky;
        top: 56px;
        background: #FFFFFF;
        padding: 14px 12px;
        margin: 0 -12px 30px;
        border-bottom: 1px solid var(--outline);
        border-top: 1px solid var(--outline);
        z-index: 50;
        display: flex; flex-wrap: wrap; gap: 6px; justify-content: center;
        box-shadow: 0 4px 12px -8px rgba(0,0,0,0.1);
    }
    @media (min-width: 900px) { .glossary-nav { top: 64px; } }
    .glossary-nav a { display: inline-flex; width: 32px; height: 32px; align-items: center; justify-content: center; border-radius: 8px; background: var(--surface-alt); color: var(--primary); text-decoration: none; font-weight: 600; font-size: 13px; transition: background 0.2s; }
    .glossary-nav a:hover { background: var(--primary); color: #fff; }
    .glossary-letter-block { margin-bottom: 48px; }
    .glossary-letter { font-size: 32px; font-weight: 700; color: var(--link-blue); border-bottom: 2px solid var(--outline); padding-bottom: 8px; margin-bottom: 20px; }
    .glossary-term { padding: 16px 0; border-bottom: 1px solid var(--outline); }
    .glossary-term:last-child { border-bottom: none; }
    .glossary-term-name { font-size: 17px; font-weight: 600; color: var(--primary); margin-bottom: 6px; }
    .glossary-term-desc { font-size: 15px; line-height: 1.6; color: var(--secondary); }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Sondaj Sözlüğü — 50+ Sektör Terimi | Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">SEKTÖR REFERANSI</div>
                <h1>Sondaj Sözlüğü</h1>
                <p>Sondaj sektörünün 50+ teknik terimi. Karotiyer, DTH çekiç, tij, formasyon, API standartları — hepsi tek sayfada.</p>
            </section>

            <section class="glossary-wrap">
                <nav class="glossary-nav" aria-label="Alfabetik navigasyon">
                    @foreach ($grouped as $letter => $_)
                        <a href="#harf-{{ $letter }}">{{ $letter }}</a>
                    @endforeach
                </nav>

                @foreach ($grouped as $letter => $items)
                    <div class="glossary-letter-block" id="harf-{{ $letter }}">
                        <div class="glossary-letter">{{ $letter }}</div>
                        @foreach ($items as $tr)
                            <div class="glossary-term" id="terim-{{ Str::slug($tr['t']) }}">
                                <div class="glossary-term-name">{{ $tr['t'] }}</div>
                                <div class="glossary-term-desc">{{ $tr['d'] }}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">TEKNİK SORU</div>
                    <h2>Daha detay bilgi mi lazım?</h2>
                    <p>Teknik ekibimiz sondaj operasyonlarınıza özel her türlü sorunuzu WhatsApp veya telefonla yanıtlar.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="{{ $catalogUrl }}" class="asef-cta-pill ghost">Kataloga Git <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
