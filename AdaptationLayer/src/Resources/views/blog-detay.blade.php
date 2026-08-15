{{-- Blog yazı detay — /blog/{slug} --}}
@php
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, blog yazısı hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Master blog store (slug ⇒ full article payload).
    $store = [
        'ekipman-secim-rehberi' => [
            'cat'   => 'Ekipman Rehberi',
            'title' => 'Sondaj operasyonlarında ekipman seçimi rehberi',
            'lede'  => 'Delik çapı, formasyon karakteri, çalışma basıncı ve bağlantı standardı — doğru ekipmanı seçerken göz önünde bulundurmanız gereken kritik parametreler.',
            'date'  => '12 Ağustos 2026', 'read' => '6 dakika okuma', 'img'   => 'asef-hero-rig.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['h', 'Neden Doğru Ekipman Seçimi Kritik?'],
                ['p', 'Bir sondaj operasyonunun başarısı, sahaya inen her bir parçanın operasyona uygunluğuna bağlıdır. Yanlış ekipman seçimi; verim kaybı, gecikme, ekstra maliyet ve emniyet riski demektir. Doğru ekipman ise sadece hızlı ilerleme değil, uzun servis ömrü, öngörülebilir bakım ve daha güvenli bir çalışma sahası sağlar.'],
                ['p', 'Bu rehberde, 20 yıllık saha tecrübemizden damıttığımız beş temel karar noktasını sizinle paylaşıyoruz.'],
                ['h', '1) Delik Çapı ve Derinlik'],
                ['p', 'Delik çapı, seçtiğiniz tijden matkaba, muhafaza borusundan pompaya kadar her şeyi belirler. Küçük çaplı yüzeysel bir kuyu ile derin bir su sondajı için gerekli ekipman aynı sınıfta olsa da farklı boyutlardadır. Delik çapı belirlenirken hedeflenen su/mineral rezervi, formasyon geometrisi ve kuyu ömrü birlikte değerlendirilmelidir.'],
                ['h', '2) Formasyon Karakteri'],
                ['p', 'Yumuşak zeminden aşırı aşındırıcı sert kayaca uzanan formasyon skalasında, tek bir matkap ideal değildir. Kil ağırlıklı formasyonlar için tricone, sert kayaç için DTH çekiç, hassas karot alımı için ise elmas uçlu karotier tercih edilir. Yanlış seçim, ekipman ömrünü aylardan haftalara indirebilir.'],
                ['h', '3) Çalışma Basıncı ve Debi'],
                ['p', 'Sondaj sisteminde havanın veya çamurun sirkülasyonu, hem soğutma hem de kesme malzemesinin yüzeye çıkarılması için hayati önemdedir. Ekipman seçilirken pompa debisi, kompresör kapasitesi ve hortum kesitleri birlikte planlanmalıdır. Çalışma basıncı, tüm zincirin en zayıf halkasına göre değil, sürekli çalışma değerine göre ayarlanmalıdır.'],
                ['h', '4) Bağlantı Standardı'],
                ['p', 'API IF, API REG, DCDMA gibi bağlantı standartları farklı sondaj ailesi için tasarlanmıştır. Uyumsuz bağlantı, ilk günden itibaren sızıntı, yorgunluk ve ekipman kaybıyla sonuçlanır. Yeni ekipman siparişinde mevcut sondaj setinizin bağlantı standardını mutlaka teyit edin.'],
                ['h', '5) Servis ve Yedek Parça Sürekliliği'],
                ['p', 'İyi bir ekipman, sadece satın alındığı gün değil, servis ömrü boyunca değer üretir. Yedek parça temin süresi, servis eğitimi ve teknik destek erişimi, ilk fiyat kadar önemli kriterlerdir. Uzun soluklu iş birlikleri, sondaj sürekliliğinin güvencesidir.'],
                ['h', 'Sonuç'],
                ['p', 'Sondaj ekipmanı seçimi tek boyutlu bir karar değildir. Delik çapı, formasyon, basınç, bağlantı ve servis; hepsinin birlikte planlanması gerekir. Ekibimiz, operasyonunuza özel değerlendirme yapmak için hazır — WhatsApp\'tan iletmeniz yeterli.'],
            ],
        ],
        'dth-cekic-bakim' => [
            'cat'   => 'Ekipman Rehberi',
            'title' => 'DTH çekiç bakımı: uzun ömür için 5 kritik nokta',
            'lede'  => 'Down-the-hole çekicin ömrünü doğrudan etkileyen 5 bakım disiplini: sızdırmazlık, yağlama, buton kontrolü, torque ve saha temizliği.',
            'date'  => '10 Ağustos 2026', 'read' => '5 dakika okuma', 'img'   => 'dth-hammer.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'DTH çekiç, sondaj setinizin en yorulan ve en pahalı ekipmanlarından biridir. Bakım disipliniyle 3-4 kat uzayan servis ömrü, saha maliyetinizi doğrudan aşağı çeker.'],
                ['h', '1) Sızdırmazlık Kontrolü'],
                ['p', 'DTH içindeki hava, yağ ve tozun izolasyonu; conta ve o-ring sağlığına bağlıdır. Her operasyon sonrası contalar kontrol edilmeli, aşınma belirtisi görülürse hemen yenilenmelidir.'],
                ['h', '2) Yağlama Rejimi'],
                ['p', 'Piston hareketi ve iç yüzey aşınması, doğru yağ ve doğru miktar ile en aza iner. Üretici tavsiyesi olan viskozite ve akış oranı tam olarak uygulanmalı.'],
                ['h', '3) Buton (Bit) Kontrolü'],
                ['p', 'DTH çekicin altındaki buton bit, karbür uçlarının aşınma paterni ile size formasyon hakkında bilgi verir. Anormal aşınma sadece bit değil, çekiç iç mekanizmasında da sorun olabileceğinin işaretidir.'],
                ['h', '4) Torque Değerleri'],
                ['p', 'Bağlantı torque\'u eksik veya fazla verilirse; ya sızdırma başlar ya da dişler yorulur. Üretici tavsiye ettiği torque değerine tam olarak sıkın; elle veya körlemesine "iyi bağladım" mantığı DTH için felakettir.'],
                ['h', '5) Saha Temizliği'],
                ['p', 'Her operasyondan sonra çekiç dışardan temizlenmeli, iç kanallar hafif basınçlı hava ile temizlenmelidir. Toz, çamur ve pas birikimi bir sonraki operasyonda basınç kaybına yol açar.'],
            ],
        ],
        'sondaj-tiji-baglanti' => [
            'cat'   => 'Teknik İpuçları',
            'title' => 'Sondaj tiji seçimi ve bağlantı standartları',
            'lede'  => 'API IF, API REG, DCDMA — bağlantı standartları arasındaki farklar ve hangi standart hangi operasyona uygun.',
            'date'  => '05 Ağustos 2026', 'read' => '4 dakika okuma', 'img'   => 'drill-rods.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Sondaj tijinin bağlantı standardı, ekipman ailesinin uyumluluğunu belirler. Yanlış standart, ilk sevkiyattan itibaren yorgunluk çatlaklarına ve tij kaybına yol açar.'],
                ['h', 'API IF — American Petroleum Institute Internal Flush'],
                ['p', 'Petrol ve derin su sondaj operasyonlarında yaygın kullanılan bir standart. İç akış geometrisi çamur devrini kolaylaştırır.'],
                ['h', 'API REG — Regular'],
                ['p', 'Klasik ve dayanıklı bir bağlantı. Yerüstü rotary sondajında sıklıkla tercih edilir.'],
                ['h', 'DCDMA — Diamond Core Drill Manufacturers Association'],
                ['p', 'Karot alımı ve hassas sondaj için standartlaştırılmış bağlantılar. HQ, NQ, PQ ölçüleri en yaygınlarıdır.'],
                ['p', 'Yeni tij siparişinde mevcut setinizin bağlantı standardını, dişini ve iç çapını mutlaka teyit edin. Karışık bağlantılar arayüz zorlaması yaratır ve setinizin ömrünü kısaltır.'],
            ],
        ],
        'camur-pompa-verim' => [
            'cat'   => 'Teknik İpuçları',
            'title' => 'Çamur pompası performansı ve verim optimizasyonu',
            'lede'  => 'Triplex pistonlu çamur pompasında debi-basınç dengesi, piston hareket eğrisi ve aşınma yönetimi.',
            'date'  => '28 Temmuz 2026', 'read' => '7 dakika okuma', 'img'   => 'mud-pump.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Sondaj devrindeki çamur pompası, sistemin kalbi konumundadır. Doğru boyutlandırma ve düzenli bakım, hem verim hem de maliyet üzerinde belirleyicidir.'],
                ['h', 'Debi ve Basınç Dengesi'],
                ['p', 'Aşırı debi, yüksek aşınma anlamına gelir; düşük debi ise kuyu temizliğinin yetersiz kalması. Optimum aralık, formasyon ve derinlik ile birlikte belirlenmelidir.'],
                ['h', 'Piston Hareket Eğrisi'],
                ['p', 'Triplex pompada üç pistonun senkron çalışması, sabit basınç ve düşük titreşim demektir. Piston contası aşınmalarında bu senkron bozulur ve basınç dalgalanır.'],
                ['h', 'Aşınma Yönetimi'],
                ['p', 'Piston, silindir gömleği ve valfler ana aşınma noktalarıdır. Belirli çalışma saatinde plansız arıza yerine planlı değişim, hem maliyet hem de operasyon sürekliliği açısından avantajlıdır.'],
            ],
        ],
        'karot-hatalari' => [
            'cat'   => 'Vaka Çalışması',
            'title' => 'Karot alma operasyonlarında yaygın hatalar',
            'lede'  => 'Doğru derinlikte doğru karot — sahadan 4 gerçek vaka üzerinden çıkardığımız dersler.',
            'date'  => '22 Temmuz 2026', 'read' => '6 dakika okuma', 'img'   => 'asef-macro-diamond.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Karot alma operasyonu; hem ekipman hem de disiplin gerektirir. En sık karşılaştığımız 4 hata:'],
                ['h', '1) Yanlış Karotier Boyutu'],
                ['p', 'HQ, NQ, PQ arasında geçiş yaparken bağlantı, iç tüp uyumu ve karot verimi değişir. Standart geçişini doğru planlamak kritik.'],
                ['h', '2) Hızlı İlerleme'],
                ['p', 'Karot alımı hızlı ilerleme değil, tam ilerlemedir. Aşırı basınç ve devir; karotu parçalar, temsili örnek almayı zorlaştırır.'],
                ['h', '3) Yetersiz Soğutma'],
                ['p', 'Elmas uçların ömrü, doğru soğutma sıvısı akışıyla katlanır. Yetersiz akış aşırı ısınma ve elmas kaybı demektir.'],
                ['h', '4) Karot Sandığı Yönetimi'],
                ['p', 'Alınan karotun sistematik olarak numaralandırılması, fotoğraflanması ve saklanması; jeolojik analizin doğruluğunu belirler.'],
            ],
        ],
        'su-sondaji-mevzuat' => [
            'cat'   => 'Sondaj Sektörü',
            'title' => 'Türkiye\'de su sondajı: yasal süreç ve izinler',
            'lede'  => 'DSİ izin başvurusu, hidrojeoloji raporu, ruhsatlandırma — su sondajı öncesi bilinmesi gereken temel adımlar.',
            'date'  => '18 Temmuz 2026', 'read' => '8 dakika okuma', 'img'   => 'drilling-hero.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Türkiye\'de su sondajı; DSİ (Devlet Su İşleri) izin ve denetimi altında gerçekleştirilir. Bu rehberde temel süreci adım adım paylaşıyoruz.'],
                ['h', '1) Ön Etüt'],
                ['p', 'Sondaj öncesi bölge hidrojeoloji haritasının incelenmesi ve gerekirse mühendislik ön raporu hazırlanması.'],
                ['h', '2) DSİ Başvurusu'],
                ['p', 'Belirlenen koordinatlar için DSİ Bölge Müdürlüğüne izin başvurusu; parsel bilgisi, kullanım amacı ve derinlik projeksiyonu ile.'],
                ['h', '3) Ruhsat ve Denetim'],
                ['p', 'İzin sonrası sondaj gerçekleştirilir ve DSİ tarafından denetlenir. Kuyu tamamlama raporu ve verim testi sonuçları sunulur.'],
                ['h', '4) İşletme İzni'],
                ['p', 'Belirli debinin üzerindeki kuyular için işletme izni gerekir. Bu izin, yıllık su sayacı okumaları ile takip edilir.'],
                ['p', 'Yasal süreç bölgeye ve kuyu tipine göre değişebilir. Ekibimiz süreç danışmanlığı da sağlar — WhatsApp üzerinden detay isteyebilirsiniz.'],
            ],
        ],
        'yerustu-yeralti' => [
            'cat'   => 'Sondaj Sektörü',
            'title' => 'Yerüstü vs yeraltı sondaj: proje bazlı karar',
            'lede'  => 'Formasyon derinliği, saha erişimi ve maliyet — hangi tip operasyonunuza uygun?',
            'date'  => '14 Temmuz 2026', 'read' => '5 dakika okuma', 'img'   => 'asef-hero-equipment.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['h', 'Yerüstü Sondaj'],
                ['p', 'Açık sahada, kamyon veya palet üstü konfigürasyonlarda; erişimi kolay ve büyük çaplı operasyonlar için uygun. Su sondajı, temel araştırması ve büyük çaplı jeotermal operasyonlarda tercih edilir.'],
                ['h', 'Yeraltı Sondaj'],
                ['p', 'Madencilik ve tünel operasyonlarında kompakt gövdeli setler kullanılır. Manevra kabiliyeti ön plandadır; havalandırma ve emniyet önlemleri farklıdır.'],
                ['h', 'Karar Kriterleri'],
                ['p', 'Formasyon derinliği, saha erişimi, operasyon büyüklüğü ve maliyet — dört ana kriter. Doğru tip seçimi hem güvenlik hem de operasyon süresi üzerinde belirleyicidir.'],
            ],
        ],
        'karotier-ipuclari' => [
            'cat'   => 'Ekipman Rehberi',
            'title' => 'Karotier seçiminde iç tüp / dış tüp uyumu',
            'lede'  => 'HQ, NQ, PQ standartları arasında geçiş ve karot verim analizi.',
            'date'  => '08 Temmuz 2026', 'read' => '6 dakika okuma', 'img'   => 'asef-macro-thread.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Karotier setinin iç ve dış tüp uyumu, alınan karotun kalitesini ve elmas ucun ömrünü doğrudan etkiler.'],
                ['h', 'Standart Boyutları'],
                ['p', 'HQ (96 mm), NQ (75.7 mm), PQ (122 mm) — en yaygın kullanılan uluslararası standartlardır. Her standardın kendine özgü tij, iç tüp ve uç ölçüleri vardır.'],
                ['h', 'Uyumsuzluk Riskleri'],
                ['p', 'Farklı standart parçaların birlikte kullanımı; yorulmayı hızlandırır, sızıntı yaratır ve karot verimini düşürür.'],
            ],
        ],
        'yedek-parca-stok' => [
            'cat'   => 'Vaka Çalışması',
            'title' => 'Yedek parça planlaması — 20 yıllık iş birliğinden',
            'lede'  => 'Kritik yedek parça stok stratejisi ve operasyon sürekliliği.',
            'date'  => '02 Temmuz 2026', 'read' => '5 dakika okuma', 'img'   => 'asef-spare-parts.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Sondaj operasyonlarında ekipman arızası her zaman ihtimal. Fark yaratan; arıza anında yedek parçaya erişim süresidir.'],
                ['h', 'Kritik Yedek Parça Listesi'],
                ['p', 'DTH conta setleri, tij bağlantıları, piston contaları, valf grupları — sahada her zaman bulunması gereken temel parçalardır.'],
                ['h', 'Stok Stratejisi'],
                ['p', 'Ana kullanıcı için 3 saatlik acil ihtiyaç, 24 saatlik operasyon devamı ve 1 haftalık planlanmış bakım için ayrı stok seviyeleri tanımlanmalıdır.'],
            ],
        ],
    ];

    $slug = $slug ?? '';
    $post = $store[$slug] ?? null;
    $isPlaceholder = $post === null;

    if ($isPlaceholder) {
        $post = [
            'cat'   => 'Blog',
            'title' => 'Bu yazı yakında yayınlanacak.',
            'lede'  => 'Blog içeriğimizi düzenli olarak güncelliyoruz. İçerik önerinizi WhatsApp\'tan iletmeniz yeterli.',
            'date'  => date('d.m.Y'), 'read' => '—', 'img' => 'asef-hero-rig.jpg', 'author' => 'Asef',
            'body'  => [],
        ];
    }

    // Related — same category, exclude current
    $related = [];
    if (! $isPlaceholder) {
        foreach ($store as $s => $p) {
            if ($s === $slug) continue;
            if ($p['cat'] !== $post['cat']) continue;
            $related[$s] = $p;
            if (count($related) >= 3) break;
        }
    }
@endphp

@push('meta')
    <meta name="title" content="{{ $post['title'] }} — Asef Sondaj Blog" />
    <meta name="description" content="{{ $post['lede'] }}" />
    @if ($isPlaceholder) <meta name="robots" content="noindex" /> @endif
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .bd-hero { max-width: 780px; margin: 0 auto; padding: 40px 20px 24px; text-align: center; }
    @media (min-width: 768px) { .bd-hero { padding: 72px 20px 32px; } }
    .bd-cat { font-size: 12px; letter-spacing: 0.14em; color: var(--link-blue); font-weight: 600; text-transform: uppercase; margin-bottom: 14px; }
    .bd-title { font-size: clamp(30px, 4.5vw, 52px); font-weight: 600; letter-spacing: -0.02em; line-height: 1.1; color: var(--primary); margin-bottom: 18px; }
    .bd-lede { font-size: clamp(17px, 1.8vw, 21px); color: var(--secondary); line-height: 1.55; margin: 0 auto 24px; }
    .bd-meta { display: flex; gap: 16px; justify-content: center; align-items: center; font-size: 13px; color: var(--gray-secondary); }
    .bd-meta span { display: inline-flex; align-items: center; gap: 6px; }

    .bd-hero-img-wrap { max-width: 1024px; margin: 24px auto 48px; padding: 0 20px; }
    @media (min-width: 768px) { .bd-hero-img-wrap { margin: 32px auto 72px; } }
    .bd-hero-img { aspect-ratio: 16/9; border-radius: 24px; overflow: hidden; background: #14161a; box-shadow: 0 20px 60px rgba(0,0,0,0.1); }
    .bd-hero-img img { width: 100%; height: 100%; object-fit: cover; }

    .bd-article { max-width: 720px; margin: 0 auto; padding: 0 20px; }
    .bd-article h2 { font-size: clamp(22px, 2.8vw, 30px); font-weight: 600; letter-spacing: -0.01em; color: var(--primary); margin: 40px 0 14px; line-height: 1.2; }
    .bd-article p { font-size: 17px; line-height: 1.75; color: var(--on-surface); margin-bottom: 18px; }
    .bd-article p:first-of-type::first-letter { }

    .bd-share { max-width: 720px; margin: 40px auto 0; padding: 24px 20px; border-top: 1px solid var(--outline); display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
    .bd-share-label { font-size: 13px; color: var(--gray-secondary); }
    .bd-share-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 999px; background: var(--surface-alt); color: var(--on-surface); font-size: 13px; font-weight: 500; transition: background .15s; }
    .bd-share-btn:hover { background: #EEEEF0; }
    .bd-share-btn svg { width: 14px; height: 14px; }

    .bd-related-wrap { max-width: 1024px; margin: 80px auto 100px; padding: 0 20px; }
    .bd-related-head { text-align: center; margin-bottom: 28px; }
    .bd-related-head h3 { font-size: clamp(22px, 3vw, 28px); font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .bd-related-grid { display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 768px) { .bd-related-grid { grid-template-columns: repeat(3, 1fr); gap: 24px; } }
    .bd-related-card { background: var(--surface-alt); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s; }
    .bd-related-card:hover { transform: translateY(-3px); background: #EEEEF0; }
    .bd-related-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .bd-related-media img { width: 100%; height: 100%; object-fit: cover; }
    .bd-related-body { padding: 20px 22px 22px; display: flex; flex-direction: column; gap: 8px; flex: 1; }
    .bd-related-cat { font-size: 11px; letter-spacing: 0.1em; color: var(--link-blue); font-weight: 500; text-transform: uppercase; }
    .bd-related-title { font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>{{ $post['title'] }} — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO --}}
            <section class="bd-hero">
                <div class="bd-cat">{{ $post['cat'] }}</div>
                <h1 class="bd-title">{{ $post['title'] }}</h1>
                <p class="bd-lede">{{ $post['lede'] }}</p>
                <div class="bd-meta">
                    <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>{{ $post['date'] }}</span>
                    <span>· {{ $post['read'] }}</span>
                    <span>· {{ $post['author'] }}</span>
                </div>
            </section>

            {{-- HERO IMAGE --}}
            <div class="bd-hero-img-wrap">
                <div class="bd-hero-img"><img src="{{ $asefUrl($post['img']) }}" alt="{{ $post['title'] }}"></div>
            </div>

            {{-- BODY --}}
            <article class="bd-article">
                @if ($isPlaceholder)
                    <p>Bu blog yazısı içeriği hazırlanıyor. Belirli bir konuda öneriniz varsa WhatsApp üzerinden iletebilir, güncellendiğinde bildirim isteyebilirsiniz.</p>
                    <p style="text-align: center; margin-top: 32px;">
                        <a href="{{ url('blog') }}" class="asef-cta-pill primary">Blog'a Dön</a>
                    </p>
                @else
                    @foreach ($post['body'] as [$type, $text])
                        @if ($type === 'h')
                            <h2>{{ $text }}</h2>
                        @else
                            <p>{{ $text }}</p>
                        @endif
                    @endforeach
                @endif
            </article>

            {{-- SHARE --}}
            @if (! $isPlaceholder)
                <div class="bd-share">
                    <span class="bd-share-label">Paylaş:</span>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="bd-share-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.6 6.32A7.85 7.85 0 0 0 12.05 4a7.94 7.94 0 0 0-6.88 11.9L4 20l4.2-1.1a7.94 7.94 0 0 0 3.85.98A7.94 7.94 0 0 0 17.6 6.32Z"/></svg>
                        WhatsApp
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post['title']) }}" target="_blank" rel="noopener" class="bd-share-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                        X
                    </a>
                    <a href="mailto:?subject={{ urlencode($post['title']) }}&body={{ urlencode(url()->current()) }}" class="bd-share-btn">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        E-posta
                    </a>
                </div>
            @endif

            {{-- RELATED --}}
            @if (count($related) > 0)
                <section class="bd-related-wrap">
                    <div class="bd-related-head">
                        <h3>İlgili yazılar</h3>
                    </div>
                    <div class="bd-related-grid">
                        @foreach ($related as $rslug => $r)
                            <a href="{{ url('blog/' . $rslug) }}" class="bd-related-card">
                                <div class="bd-related-media"><img src="{{ $asefUrl($r['img']) }}" alt="{{ $r['title'] }}" loading="lazy"></div>
                                <div class="bd-related-body">
                                    <span class="bd-related-cat">{{ $r['cat'] }}</span>
                                    <div class="bd-related-title">{{ $r['title'] }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </section>
            @endif

            {{-- CTA --}}
            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">UZMAN GÖRÜŞÜ</div>
                    <h2>Yazıyla ilgili sorunuz mu var?</h2>
                    <p>Sondaj sektörüne özel her türlü sorunuz için ekibimiz WhatsApp'tan yanıt verir.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="{{ url('blog') }}" class="asef-cta-pill ghost">Blog Ana Sayfa <span class="asef-cta-arrow">›</span></a>
                    </div>
                </div>
            </section>

        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
