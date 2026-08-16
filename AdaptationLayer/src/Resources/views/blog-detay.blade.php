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

    @if (! $isPlaceholder)
        {{-- Article structured data — Google Discover + Search --}}
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "Article",
          "headline": {!! json_encode($post['title'], JSON_UNESCAPED_UNICODE) !!},
          "description": {!! json_encode($post['lede'], JSON_UNESCAPED_UNICODE) !!},
          "image": [{!! json_encode($asefUrl($post['img'])) !!}],
          "datePublished": {!! json_encode(date('c')) !!},
          "dateModified": {!! json_encode(date('c')) !!},
          "author": { "@type": "Organization", "name": {!! json_encode($post['author'] ?? 'Asef Sondaj', JSON_UNESCAPED_UNICODE) !!}, "url": {!! json_encode(url('/')) !!} },
          "publisher": {
            "@type": "Organization",
            "name": "Asef Sondaj",
            "logo": { "@type": "ImageObject", "url": {!! json_encode(url('android-chrome-512x512.png')) !!} }
          },
          "mainEntityOfPage": { "@type": "WebPage", "@id": {!! json_encode(url()->current()) !!} },
          "articleSection": {!! json_encode($post['cat'] ?? 'Blog', JSON_UNESCAPED_UNICODE) !!}
        }
        </script>

        {{-- Breadcrumb --}}
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [
            { "@type": "ListItem", "position": 1, "name": "Ana Sayfa", "item": {!! json_encode(url('/')) !!} },
            { "@type": "ListItem", "position": 2, "name": "Blog", "item": {!! json_encode(url('blog')) !!} },
            { "@type": "ListItem", "position": 3, "name": {!! json_encode($post['title'], JSON_UNESCAPED_UNICODE) !!}, "item": {!! json_encode(url()->current()) !!} }
          ]
        }
        </script>

        @php
            $seoTitle = $post['title'] . ' — Asef Sondaj Blog';
            $seoDescription = $post['lede'];
            $seoImage = $asefUrl($post['img']);
            $seoType = 'article';
        @endphp
    @endif
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

    .bd-share { max-width: 720px; margin: 40px auto 0; padding: 24px 20px; border-top: 1px solid var(--outline); display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
    .bd-share-label { font-size: 13px; color: var(--gray-secondary); font-weight: 500; }
    .bd-share-btns { display: flex; gap: 10px; flex-wrap: wrap; }
    .bd-share-btn {
        width: 40px; height: 40px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: var(--surface-alt); color: #1d1d1f;
        transition: background .2s, color .2s, transform .2s, box-shadow .2s;
        position: relative;
    }
    .bd-share-btn svg { width: 18px; height: 18px; display: block; }
    .bd-share-btn:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 6px 14px rgba(0,0,0,0.14); }
    .bd-share-btn[data-brand="whatsapp"]:hover { background: #25D366; }
    .bd-share-btn[data-brand="x"]:hover        { background: #000000; }
    .bd-share-btn[data-brand="facebook"]:hover { background: #1877F2; }
    .bd-share-btn[data-brand="linkedin"]:hover { background: #0A66C2; }
    .bd-share-btn[data-brand="telegram"]:hover { background: #26A5E4; }
    .bd-share-btn[data-brand="reddit"]:hover   { background: #FF4500; }
    .bd-share-btn[data-brand="pinterest"]:hover{ background: #BD081C; }
    .bd-share-btn[data-brand="email"]:hover    { background: #444444; }
    .bd-share-btn[data-brand="copy"]:hover     { background: #0066CC; }
    .bd-share-btn::after {
        content: attr(data-tip);
        position: absolute; bottom: calc(100% + 8px); left: 50%; transform: translateX(-50%);
        background: #1d1d1f; color: #fff; font-size: 11px; padding: 4px 8px; border-radius: 6px;
        white-space: nowrap; opacity: 0; pointer-events: none; transition: opacity .15s;
    }
    .bd-share-btn:hover::after { opacity: 1; }
    .bd-share-toast {
        position: fixed; left: 50%; bottom: 32px; transform: translateX(-50%) translateY(20px);
        background: #1d1d1f; color: #fff; padding: 12px 22px; border-radius: 999px;
        font-size: 14px; font-weight: 500; z-index: 9999;
        opacity: 0; pointer-events: none; transition: opacity .25s, transform .25s;
        box-shadow: 0 14px 34px rgba(0,0,0,0.24);
    }
    .bd-share-toast.on { opacity: 1; transform: translateX(-50%) translateY(0); }

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
                @php
                    $shareUrl   = url()->current();
                    $shareTitle = $post['title'];
                    $shareText  = $post['lede'];
                    $encUrl     = rawurlencode($shareUrl);
                    $encTitle   = rawurlencode($shareTitle);
                    $encText    = rawurlencode($shareText);
                    $encTitleUrl= rawurlencode($shareTitle . ' — ' . $shareUrl);
                @endphp
                <div class="bd-share">
                    <span class="bd-share-label">Paylaş</span>
                    <div class="bd-share-btns">
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text={{ $encTitleUrl }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="whatsapp" data-tip="WhatsApp" aria-label="WhatsApp'ta paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 21.785h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413"/></svg>
                        </a>
                        {{-- X --}}
                        <a href="https://twitter.com/intent/tweet?url={{ $encUrl }}&text={{ $encTitle }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="x" data-tip="X (Twitter)" aria-label="X'te paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encUrl }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="facebook" data-tip="Facebook" aria-label="Facebook'ta paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z"/></svg>
                        </a>
                        {{-- LinkedIn --}}
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $encUrl }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="linkedin" data-tip="LinkedIn" aria-label="LinkedIn'de paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        {{-- Telegram --}}
                        <a href="https://t.me/share/url?url={{ $encUrl }}&text={{ $encTitle }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="telegram" data-tip="Telegram" aria-label="Telegram'da paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>
                        </a>
                        {{-- Reddit --}}
                        <a href="https://www.reddit.com/submit?url={{ $encUrl }}&title={{ $encTitle }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="reddit" data-tip="Reddit" aria-label="Reddit'te paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z"/></svg>
                        </a>
                        {{-- Pinterest --}}
                        <a href="https://pinterest.com/pin/create/button/?url={{ $encUrl }}&description={{ $encTitle }}" target="_blank" rel="noopener" class="bd-share-btn" data-brand="pinterest" data-tip="Pinterest" aria-label="Pinterest'te paylaş">
                            <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.401.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.354-.629-2.758-1.379l-.749 2.848c-.269 1.045-1.004 2.352-1.498 3.146 1.123.345 2.306.535 3.55.535 6.607 0 11.985-5.365 11.985-11.987C23.97 5.39 18.592.026 11.985.026L12.017 0z"/></svg>
                        </a>
                        {{-- E-posta --}}
                        <a href="mailto:?subject={{ $encTitle }}&body={{ $encTitleUrl }}" class="bd-share-btn" data-brand="email" data-tip="E-posta" aria-label="E-posta ile paylaş">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                        </a>
                        {{-- Copy link --}}
                        <button type="button" class="bd-share-btn" data-brand="copy" data-tip="Bağlantıyı kopyala" data-copy="{{ $shareUrl }}" aria-label="Bağlantıyı kopyala">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </button>
                    </div>
                </div>
                <div id="bdShareToast" class="bd-share-toast" role="status" aria-live="polite">Bağlantı kopyalandı</div>
                <script>
                (function () {
                    document.addEventListener('click', function (e) {
                        var btn = e.target.closest('.bd-share-btn[data-copy]');
                        if (!btn) return;
                        e.preventDefault();
                        var url = btn.getAttribute('data-copy');
                        var toast = document.getElementById('bdShareToast');
                        function showToast(msg) {
                            if (!toast) return;
                            toast.textContent = msg;
                            toast.classList.add('on');
                            setTimeout(function () { toast.classList.remove('on'); }, 2200);
                        }
                        if (navigator.clipboard && navigator.clipboard.writeText) {
                            navigator.clipboard.writeText(url).then(function () { showToast('Bağlantı kopyalandı'); }, function () { showToast('Kopyalanamadı'); });
                        } else {
                            try {
                                var ta = document.createElement('textarea');
                                ta.value = url; ta.style.position = 'fixed'; ta.style.opacity = '0';
                                document.body.appendChild(ta); ta.select();
                                document.execCommand('copy'); document.body.removeChild(ta);
                                showToast('Bağlantı kopyalandı');
                            } catch (err) { showToast('Kopyalanamadı'); }
                        }
                    });
                })();
                </script>
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
