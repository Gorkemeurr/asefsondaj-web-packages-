{{-- Blog yazı detay — /blog/{slug} --}}
@php
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, blog yazısı hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Master blog store (slug ⇒ full article payload).
    // 9 yazı — her biri uzun form SEO içerik, keyword-rich Türkçe, 1000-1500 kelime.
    $store = [
        'ekipman-secim-rehberi' => [
            'cat'   => 'Ekipman Rehberi',
            'title' => 'Sondaj Operasyonlarında Ekipman Seçimi: Kapsamlı Rehber (2026)',
            'lede'  => 'Delik çapı, formasyon karakteri, çalışma basıncı ve bağlantı standardı — sondaj projesinde doğru ekipmanı seçerken bilmeniz gereken tüm parametreler, 20 yıllık saha tecrübemizden çıkardığımız pratik rehber.',
            'date'  => '12 Ağustos 2026', 'read' => '12 dakika okuma', 'img'   => 'asef-hero-rig.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['h', 'Neden Doğru Sondaj Ekipmanı Seçimi Bu Kadar Kritik?'],
                ['p', 'Bir sondaj operasyonunun başarısı, sahaya inen her bir parçanın operasyona uygunluğuna bağlıdır. Yanlış ekipman seçimi verim kaybı, gecikme, ekstra maliyet ve ciddi bir emniyet riski anlamına gelir. Doğru ekipman ise sadece hızlı ilerleme değil; uzun servis ömrü, öngörülebilir bakım programı ve çok daha güvenli bir çalışma sahası sağlar. Sondaj sektöründe bir hafta gecikme, projenin toplam maliyetini %20-30 arttırabilir.'],
                ['p', 'Asef Sondaj olarak 20 yılı aşkın saha tecrübemizde binlerce operasyonda gördük ki, sondaj başarısının %70\'i ekipman seçiminde belirlenir. Kuyunun tamamlanıp tamamlanmayacağı, aslında ilk gün planlanır — kalanı uygulamadır. Bu kapsamlı rehberde, doğru sondaj ekipmanı seçmek için bilmeniz gereken beş temel karar noktasını, gerçek saha örnekleriyle sizinle paylaşıyoruz.'],
                ['h', '1. Delik Çapı ve Hedef Derinlik'],
                ['p', 'Delik çapı, seçtiğiniz tijden matkaba, muhafaza borusundan çamur pompasına kadar her şeyi belirleyen ana parametredir. Küçük çaplı yüzeysel bir kuyu (30-50 m su sondajı) ile 200-500 m derinliğe inen bir maden veya jeotermal kuyusu için gereken ekipman aynı sınıfta olsa da tamamen farklı boyutlarda ve dayanımlardadır.'],
                ['p', 'Delik çapı belirlenirken üç kritik faktör birlikte değerlendirilmelidir: (1) hedeflenen su, mineral veya jeotermal rezervin akış geometrisi — geniş kuyu daha yüksek debi ama daha yüksek maliyet; (2) formasyon geometrisi — kaya katmanının kalınlığı ve dağılımı ekipman aşınmasını doğrudan etkiler; (3) kuyu ömrü beklentisi — 5 yıl kullanılacak bir kuyu ile 25 yıl işletilecek bir kuyunun muhafaza borusu ve tamamlama malzemeleri farklı kalitede olmalıdır.'],
                ['p', '<strong>Pratik ipucu:</strong> Su sondajında 165-215 mm arası, jeotermal projelerde 250-450 mm arası, karot alımı için ise NQ (75.7 mm), HQ (96 mm) veya PQ (122.6 mm) standart çapları en yaygın seçimlerdir. Delik çapı arttıkça ekipman maliyetleri katlanarak yükselir; ihtiyaçtan büyük çap seçmek klasik bir israftır.'],
                ['h', '2. Formasyon Karakteri ve Kaya Sertliği'],
                ['p', 'Türkiye\'nin farklı bölgelerinde jeolojik formasyon karakterleri çok değişkendir. Ege\'nin killi zeminleri, İç Anadolu\'nun sert kalker katmanları, Karadeniz\'in andezit ve bazalt yoğunluklu kayaçları, Güneydoğu\'nun kalın kireçtaşı yataklarıyla tamamen farklı matkap sınıflarına ihtiyaç doğurur. Yumuşak zeminden aşırı aşındırıcı sert kayaca uzanan skalada, tek bir matkap ideal değildir; formasyonu tanımadan seçim yapmak, ekipmanı bir haftada bitirmek demektir.'],
                ['p', 'Kil ağırlıklı ve orta sertlikte formasyonlar için Tricone (üç konili döner) matkap en yaygın tercihtir. Rulmanlı iç yapısıyla yüksek dönüş verimi sağlar. Sert ve çok sert kayaç formasyonlarında ise DTH (Down-The-Hole) çekiç kullanılır — pnömatik darbe ile kayacı parçalar. Hassas karot alımı gerektiren jeoteknik ve maden aramalarında elmas uçlu karotier setleri tercih edilir; bu setler jeolojik yapıyı bozmadan sağlam kayaç örneği alır.'],
                ['p', 'Kayaç sertliği Mohs skalasında ölçülür; 1-3 arası yumuşak (kil, alçıtaşı), 4-6 orta (kireçtaşı, kum), 7-9 sert (granit, bazalt) olarak sınıflandırılır. Seçtiğiniz matkap kayaç sertliğine uygun değilse ekipman ömrü, saha tecrübemize göre aylardan haftalara iner. Sondaj öncesi bölgesel jeoloji raporu almak, uzun vadede en ekonomik yatırımdır.'],
                ['h', '3. Çalışma Basıncı, Debi ve Sirkülasyon Sistemi'],
                ['p', 'Sondaj sisteminde havanın (rotary hava sondajı) veya çamurun (rotary çamur sondajı) sirkülasyonu, hem matkap ve tijin soğutulması hem de kırıntı malzemenin (cutting) yüzeye taşınması için hayati önemdedir. Yetersiz sirkülasyon, matkap ömrünü kısaltır, kuyuda tıkanma yaratır ve ilerlemeyi durdurur.'],
                ['p', 'Ekipman seçilirken pompa debisi (l/dk veya m³/saat), kompresör kapasitesi (m³/dk ve bar) ve hortum/tij iç kesitleri birlikte planlanmalıdır. Örnek: 6 inç DTH çekiç için minimum 25 m³/dk hava debisi ve 25 bar sürekli çalışma basıncı gerekir. Bu değer sağlanamıyorsa çekiç darbe enerjisini kaybeder, ilerleme %40-60 düşer.'],
                ['p', 'Çalışma basıncı, tüm zincirin en zayıf halkasına göre değil, sürekli çalışma değerine göre ayarlanmalıdır. Peak basınç ile continuous basınç arasında %20 margin bırakmak, ekipman ömrünü uzatır. Kompresör, hortum, tij ve matkap — hepsi aynı basınç sınıfında seçilmelidir. Karışık sınıflar felakete davetiyedir.'],
                ['h', '4. Bağlantı Standardı — API IF, API REG, DCDMA'],
                ['p', 'Sondaj tij ve matkap bağlantı standartları, farklı sondaj aileleri için tasarlanmıştır. API IF (American Petroleum Institute Internal Flush) petrol ve derin su sondaj operasyonlarında yaygındır — iç akış geometrisi çamur devrini kolaylaştırır. API REG (Regular) klasik ve dayanıklı bir bağlantıdır; yerüstü rotary sondajında sıkça tercih edilir. DCDMA (Diamond Core Drill Manufacturers Association) ise karot alımı için standartlaştırılmış bağlantılardır — HQ, NQ, PQ ölçüleri en yaygınlarıdır.'],
                ['p', 'Uyumsuz bağlantı, ilk günden itibaren sızıntı, yorgunluk çatlağı ve tij/matkap kaybıyla sonuçlanır. Yeni ekipman siparişinde mevcut sondaj setinizin bağlantı standardını, diş sayısını ve iç çapını mutlaka teyit edin. Karışık bağlantılar arayüz zorlaması yaratır; bir sezonda tüm setinizi kaybedebilirsiniz.'],
                ['p', '<strong>Pratik tavsiye:</strong> Sipariş öncesi mevcut setinizin bağlantı fotoğrafını ve teknik veri sayfasını (spec sheet) tedarikçinize gönderin. Asef Sondaj olarak WhatsApp üzerinden bize gönderilen bağlantı fotoğraflarından standardı doğrulayabiliyoruz — 20 yıllık deneyim bu tarz sürprizleri sahada değil ofiste yakalamamızı sağlıyor.'],
                ['h', '5. Servis, Yedek Parça ve Teknik Destek Sürekliliği'],
                ['p', 'İyi bir sondaj ekipmanı, sadece satın alındığı gün değil, tüm servis ömrü boyunca değer üretir. Yedek parça temin süresi, servis eğitimi ve teknik destek erişimi — ilk fiyat kadar önemli üç kriterdir. Bir ekipman 30% daha ucuz olabilir ama yedek parçası 4-6 hafta gecikirse, operasyon durmasının maliyeti bu farkı katlar.'],
                ['p', 'Asef Sondaj olarak müşterilerimize verdiğimiz garanti şu üç kademeden oluşur: (1) Kritik yedek parçalar için 24 saat acil sevkiyat — DTH conta seti, piston contası, valf grubu; (2) Standart yedek parçalar için 2-5 iş günü teslimat — Türkiye içi tüm illerde; (3) Bakım eğitimi — sahanızda ekibinizi eğitiyoruz, uzaktan telefon/WhatsApp desteği veriyoruz.'],
                ['p', 'Uzun soluklu iş birlikleri, sondaj sürekliliğinin güvencesidir. 20 yıldır aynı müşterilerimizle çalışıyoruz çünkü ekipman satmak değil, sondaj operasyonunuzun aksamamasını sağlamak amaç. Yeni ekipman satın alırken tedarikçinin sadece fiyatına değil, geçmişine, referanslarına ve servis kapasitesine de bakın.'],
                ['h', 'Bonus: Sondaj Ekipmanı Alırken En Sık Yapılan 5 Hata'],
                ['p', '<strong>1. Sadece ilk fiyata bakmak</strong> — 20% ucuz ekipman 6 ay sonra %50 daha pahalıya mal olabilir. Toplam sahip olma maliyeti (TCO) bakışıyla hareket edin. <strong>2. Sistem uyumunu kontrol etmemek</strong> — Yeni matkap alırsanız kompresör kapasiteniz yetiyor mu, tijleriniz uyumlu mu? Sistem bütüncül düşünülmeli. <strong>3. Yedek parça planlamamak</strong> — İlk gün için değil, üçüncü ay için düşünün; kritik parçalar sahada bulunmuyorsa duruş kaçınılmaz.'],
                ['p', '<strong>4. Referans sormamak</strong> — Tedarikçinizin daha önce hangi projelerde hangi ekipmanları teslim ettiğini sorun; 5-10 referans arayabilirsiniz. <strong>5. Teknik destek kapasitesini test etmemek</strong> — Satış öncesi tedarikçinizden bir teknik soru sorun, cevap gelme süresi ve derinliği size satış sonrası nasıl bir destek alacağınızı gösterir.'],
                ['h', 'Sonuç ve Sıradaki Adım'],
                ['p', 'Sondaj ekipmanı seçimi tek boyutlu bir karar değildir. Delik çapı, formasyon karakteri, çalışma basıncı, bağlantı standardı ve servis kapasitesi — bu beş kritik parametrenin hepsinin birlikte planlanması gerekir. Yanlış tek bir tercih, projenizin tamamını tehlikeye atar.'],
                ['p', 'Asef Sondaj ekibi, operasyonunuza özel ekipman değerlendirmesi yapmak için hazır. Bize proje detaylarınızı (delik çapı, derinlik, formasyon tipi, mevcut ekipman envanteri) WhatsApp\'tan iletmeniz yeterli — 20 yıllık saha tecrübemizden faydalanarak size en uygun ekipman kombinasyonunu ücretsiz olarak öneririz. Türkiye\'nin 81 ilinde teslimat ve teknik destek ağımız hizmetinizdedir.'],
            ],
        ],
        'dth-cekic-bakim' => [
            'cat'   => 'Ekipman Rehberi',
            'title' => 'DTH Çekiç Bakımı: Uzun Ömür İçin 5 Kritik Nokta ve Saha Deneyimleri',
            'lede'  => 'Down-the-hole (DTH) çekicin ömrünü doğrudan etkileyen 5 bakım disiplini: sızdırmazlık kontrolü, doğru yağlama, buton (bit) analizi, torque değerleri ve saha temizliği. Asef Sondaj\'ın 20 yıllık DTH tecrübesinden çıkardığımız pratik rehber.',
            'date'  => '10 Ağustos 2026', 'read' => '10 dakika okuma', 'img'   => 'dth-hammer.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'DTH çekiç (Down-The-Hole hammer), sondaj setinizin en çok yorulan ve en pahalı ekipmanlarından biridir. Sert kayaç formasyonlarında saniyede 10-30 darbe uygulayan bu pnömatik cihaz, doğru bakımla yıllarca sorunsuz çalışabilir; yanlış kullanımda ise haftalar içinde tümüyle rebuild gerektirir. Asef Sondaj olarak sahada gördüğümüz DTH arızalarının %85\'i bakım disiplini eksikliğinden kaynaklanıyor — parça hatası değil.'],
                ['p', 'Bakım disipliniyle 3-4 kat uzayan servis ömrü, saha maliyetinizi doğrudan aşağı çeker. Bir DTH çekiç 4-6 ayda arızalanıyorsa, siz aslında ekipmandan değil bakım sürecinizden zarar görüyorsunuz. Bu rehberde 5 kritik bakım noktasını sahadan gerçek örneklerle anlatıyoruz.'],
                ['h', '1. Sızdırmazlık ve O-Ring Kontrolü'],
                ['p', 'DTH içindeki hava, yağ ve tozun izolasyonu conta ve o-ring sağlığına bağlıdır. Piston üstündeki üst conta, alt conta, bit shank contası ve check valve o-ring\'i — bu dört nokta her operasyon başında görsel kontrolden geçmelidir. Aşınma belirtisi (çatlak, ezilme, sertleşme) görülürse operasyona başlamadan mutlaka yenileyin. Bir o-ring yenileme maliyeti 50-200 TL; sızıntı sonucu çekiç iç mekanizması bozulması 5000-15000 TL rebuild demektir.'],
                ['p', 'Sızıntı kontrol testi: çekiç kurulu iken düşük basınçla (5-10 bar) sistem çalıştırılır, bit ile shank çevresinden hava kaçağı olup olmadığı el ile kontrol edilir. Herhangi bir sızıntı hissedilirse operasyona geçmeyin — kuyuda çekicin durmasından çok daha ekonomik bir müdahaledir.'],
                ['h', '2. Doğru Yağlama Rejimi — Miktar, Viskozite, Akış Oranı'],
                ['p', 'DTH çekicin iç piston hareketi ve silindir yüzey aşınması, doğru yağ ve doğru miktar ile en aza iner. Yağlama üretici tavsiyesi olan viskozite (genellikle ISO VG 100-320 aralığı) ve akış oranı (dakikada 0.3-1.2 litre, çekiç boyutuna göre) tam olarak uygulanmalıdır. Az yağ, iç yüzeylerde metal-metal sürtünmesi ve tez aşınma; çok yağ ise contaları zorlar ve toza yapışıp abrazyon yaratır.'],
                ['p', 'Yağlayıcı olarak "rock drilling oil" olarak satılan özel formüle edilmiş yağları tercih edin. Standart hidrolik yağ DTH için tasarlanmamıştır; darbe frekansı ve iç basınçlar altında yeterli film gücü sağlamaz. Türkiye piyasasında Shell Torcula, Mobil Almo 525, Chevron Clarity Synthetic Compressor Oil gibi seçenekler yaygın.'],
                ['h', '3. Buton (Bit) Aşınma Analizi ve Değişim Zamanlaması'],
                ['p', 'DTH çekicin altındaki buton bit\'in karbür uçları, kayaçla en yoğun temas eden parçalardır. Karbür uçların aşınma paterni size sadece bit ömrü değil, çekiç iç mekanizması, torque kalitesi ve formasyon karakteri hakkında da bilgi verir. Anormal (asimetrik, tek yönlü) aşınma sadece bit değil, çekiç iç piston veya bit shank\'inde de sorun olabileceğinin işaretidir.'],
                ['p', 'Aşınma sınıflandırması: (a) Normal aşınma — tüm karbürler yuvarlaklaşmış ama kırık yok; %30-50 karbür kaybında değiştir. (b) Kırık karbür — hemen değiştir, sert formasyon veya darbe artışı gerekmiş. (c) Yıldız aşınma (butonlarda yıldız şeklinde çatlak) — aşırı torque veya yanlış yağlama işareti; çekiç iç kontrolü yap. (d) Yalnız merkez butonlar aşınmış — düşük çamur/hava debisi işareti, sirkülasyon sistemini kontrol et.'],
                ['h', '4. Torque Değerleri ve Bağlantı Disiplini'],
                ['p', 'DTH çekiç ve bit bağlantı torque değeri, üreticinin belirttiği aralıkta olmalıdır. Eksik torque sızıntı ve gevşemeye, aşırı torque ise diş yorulmasına ve kırılmasına yol açar. Elle veya körlemesine "iyi bağladım" mantığı DTH için felakettir; her bağlantıda kalibre torque anahtarı kullanılmalı.'],
                ['p', 'Örnek torque değerleri (bilgi amaçlı, üretici sayfası öncelikli): 4 inç DTH bit-shank: 2500-3500 Nm; 5 inç: 3500-5000 Nm; 6 inç: 5500-7500 Nm; 8 inç: 8000-12000 Nm. Yeni ekipman aldığınızda mutlaka üretici torque tablosunu isteyin ve saha ekibinize eğitim verin.'],
                ['h', '5. Saha Temizliği ve Depolama Şartları'],
                ['p', 'Her operasyondan sonra çekiç dışardan temizlenmeli, iç kanallar hafif basınçlı hava ile temizlenmelidir. Toz, çamur ve pas birikimi bir sonraki operasyonda basınç kaybına, sırasında ise piston hareketinde parazite yol açar. Temizlik sonrası koruyucu yağ ile sprey yapıp kuru bir alanda depolama önerilir.'],
                ['p', 'Depolama sırasında bit takılı bırakılmamalı — bit ayrı, çekiç ayrı saklanmalı. Vantiladolusu, nem çekici bir çevre veya nemli depo çekiç iç yüzeylerinde pas ve mikroskopik korozyon başlatır. Uzun süreli depolama (>3 ay) için tüm iç yüzeyler koruyucu yağ ile yağlanmalı, ağız kapatılmalı.'],
                ['h', 'Bonus: DTH Çekiç Ömrünü Uzatan 3 Pratik İpucu'],
                ['p', '<strong>1. Pre-warm-up döngüsü</strong> — Soğuk sabah başlangıcında çekici düşük basınçla (10-15 bar) 3-5 dakika çalıştırın, sonra tam basınca çıkın. Ani soğuk-yüksek basınç piston contalarını hasarsız açar. <strong>2. Basınç günlüğü tut</strong> — Her operasyon başı ve sonu sistem basıncını not edin; giderek düşen basınç sızıntı işaretidir. <strong>3. Yıllık üretici kontrolü</strong> — Yılda bir kez çekici yetkili servise gönderin; iç parça ölçümü ve rebuild kararı erken alınırsa maliyet %60 daha az.'],
                ['h', 'Sonuç'],
                ['p', 'DTH çekiç bakımı 5 disipline dayanır: sızdırmazlık, yağlama, buton analizi, torque, temizlik. Bu 5 alandan birinde bile ihmal, ekipman ömrünü aylardan haftalara indirir. Asef Sondaj olarak müşterilerimize DTH bakım eğitimi ücretsiz veriyoruz — sahada ekibinizi eğitiyor, ilk 3 ay uzaktan destek sağlıyoruz. Yeni DTH almayı düşünüyorsanız veya mevcut çekicinizi rebuild ettirmek istiyorsanız WhatsApp\'tan bize yazın.'],
            ],
        ],
        'sondaj-tiji-baglanti' => [
            'cat'   => 'Teknik İpuçları',
            'title' => 'Sondaj Tiji Seçimi ve Bağlantı Standartları: API IF, API REG, DCDMA Karşılaştırması',
            'lede'  => 'Sondaj tijinde API IF, API REG ve DCDMA bağlantı standartları arasındaki farklar, hangi standardın hangi operasyona uygun olduğu ve doğru seçim rehberi — uyumsuz bağlantıların yol açtığı hasarları önlemek için bilmeniz gerekenler.',
            'date'  => '05 Ağustos 2026', 'read' => '9 dakika okuma', 'img'   => 'drill-rods.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Sondaj tijinin bağlantı standardı, ekipman ailesinin uyumluluğunu ve tüm sistemin dayanıklılığını belirleyen en temel karardır. Yanlış standart tercihi, ilk sevkiyattan itibaren yorgunluk çatlaklarına, dişlerde soyulmaya ve tij kaybına yol açar. Türkiye\'de sondaj sahalarında en sık karşılaştığımız arıza sebebi, karışık standart bağlantı kullanımıdır.'],
                ['p', 'Bu rehberde sondaj sektöründe kullanılan üç ana bağlantı standardını — API IF, API REG ve DCDMA — teknik özellikleri, kullanım alanları ve seçim kriterleri ile detaylı olarak inceleyeceğiz. Amaç, tij siparişinizde doğru standardı seçmenize yardımcı olmak.'],
                ['h', 'API IF — American Petroleum Institute Internal Flush'],
                ['p', 'API IF standardı, adından da anlaşılacağı üzere Amerikan Petrol Enstitüsü tarafından geliştirilmiş "iç akışlı" bir bağlantıdır. İç akış geometrisi, sondaj çamurunun tij içinden akışını maksimize edecek şekilde tasarlanmıştır — daha az basınç kaybı, daha verimli sirkülasyon. Bu özellik onu özellikle petrol ve derin su sondaj operasyonlarında tercih edilen standart yapıyor.'],
                ['p', 'API IF bağlantıları taper (koni) dişli yapıdadır ve genellikle 2-3/8 inç ile 5-1/2 inç arasında değişen boyutlarda üretilir. En yaygın ölçüler: NC26 (2-3/8" IF), NC38 (3-1/2" IF), NC46 (4" IF), NC50 (4-1/2" IF). Türkiye\'de derin su sondajı ve jeotermal projelerde API IF standardı yaygındır. Boru cidar kalınlığı ve iç akış çapı diğer standartlara göre daha büyüktür.'],
                ['h', 'API REG — Regular Konnektör'],
                ['p', 'API REG (Regular) klasik ve son derece dayanıklı bir bağlantı türüdür. İç akış geometrisi API IF kadar optimize değildir ancak diş yapısının dayanıklılığı ile öne çıkar. Yerüstü rotary sondajı, su sondajı ve maden aramalarında sıklıkla tercih edilir.'],
                ['p', 'API REG bağlantıları da taper dişlidir ancak diş açısı ve profil geometrisi farklıdır — bu nedenle IF ile REG bağlantıları KESİNLİKLE uyumsuzdur, birbiri yerine kullanılamaz. En yaygın REG ölçüleri: 2-3/8" REG, 2-7/8" REG, 3-1/2" REG, 4-1/2" REG, 6-5/8" REG. Yerüstü sondaj operasyonlarında bit-shank ve tij-tij bağlantılarında yaygın olarak karşılaşılır.'],
                ['h', 'DCDMA — Diamond Core Drill Manufacturers Association'],
                ['p', 'DCDMA standardı, karot alımı ve hassas jeoteknik sondaj için özel olarak geliştirilmiştir. HQ (96 mm dış çap), NQ (75.7 mm), PQ (122 mm), BQ (60 mm) — bu tanıdık ölçüler DCDMA standardından gelir. Her ölçü kendi tij, karotier, iç tüp ve elmas uç setiyle bir bütün oluşturur.'],
                ['p', 'DCDMA bağlantıları wireline (kablo destekli) karotier sistemleri için optimize edilmiştir. İç tüpün kablo ile hızlıca çıkarılıp değiştirilebilmesi, karot verimini büyük ölçüde artırır. Türkiye\'de maden arama, jeoteknik zemin etüdü ve altın-bakır aramalarında DCDMA yaygın standarttır. Uluslararası projelerde de standart olarak kabul edilir.'],
                ['h', 'Bağlantı Standartları Karşılaştırma Tablosu'],
                ['p', '<strong>API IF</strong>: iç akış optimize, derin/petrol sondajı, orta-yüksek dayanım. <strong>API REG</strong>: dayanıklılık ön planda, yerüstü rotary/su sondajı, en yaygın. <strong>DCDMA</strong>: karot alımı için özel, jeoteknik/maden arama, wireline sistem uyumlu. Yanlış tercih maliyeti: sadece finansal değil, aynı zamanda operasyon süresi kaybı, iş kazası riski ve müşteri güven kaybıdır.'],
                ['h', 'Yeni Tij Siparişinde 5 Kontrol Noktası'],
                ['p', '<strong>1. Standart teyidi:</strong> Mevcut setinizin bağlantı standardını (IF/REG/DCDMA) tam olarak teyit edin — fotoğraf gönderin, teknik veri sayfası (spec sheet) isteyin. <strong>2. Diş açısı ve profili:</strong> Standart aynı olsa bile üretici farklılığından kaynaklanan mikro-farklar olabilir; ilk siparişte 2-3 test tiji ile deneyin. <strong>3. İç çap:</strong> Çamur akış hızı için kritik; küçük iç çap basınç kaybına yol açar.'],
                ['p', '<strong>4. Malzeme kalitesi:</strong> AISI 4145H, 4130, 4140 gibi yüksek dayanımlı çelik alaşımları standart olmalıdır. Ucuz karbon çelik alternatifleri kısa sürede yorulur. <strong>5. Üretici sertifikası:</strong> API 5DP, API 7 gibi uluslararası sertifikalı üreticileri tercih edin — sertifikasız tijler ilk günden itibaren belirsizlik içerir.'],
                ['h', 'Sonuç ve Pratik Tavsiye'],
                ['p', 'Sondaj tiji bağlantı standardı, tüm sondaj setinizin geleceğini belirleyen kritik karardır. Karışık bağlantı kullanımı, arayüz zorlaması yaratır ve setinizin ömrünü %50-70 kısaltabilir. Yeni tij siparişinde mevcut setinizin bağlantı standardını, dişini, iç çapını ve malzeme sınıfını mutlaka teyit edin.'],
                ['p', 'Asef Sondaj olarak müşterilerimize tij siparişi öncesi ücretsiz teknik doğrulama sağlıyoruz — WhatsApp\'tan mevcut tijinizin bağlantı fotoğrafını ve teknik özelliklerini gönderin, uyum kontrolünü yapıp uygun tij önerelim. 20 yıllık saha tecrübemizle bu tarz sürprizleri sizden önce yakalıyoruz.'],
            ],
        ],
        'camur-pompa-verim' => [
            'cat'   => 'Teknik İpuçları',
            'title' => 'Çamur Pompası Performansı ve Verim Optimizasyonu: Triplex Pompa Bakım Rehberi',
            'lede'  => 'Triplex pistonlu çamur pompasında debi-basınç dengesi, piston hareket eğrisi, aşınma yönetimi ve verim optimizasyonu. Sondaj devrinin kalbini uzun ömürlü tutmak için bilinmesi gereken teknik detaylar.',
            'date'  => '28 Temmuz 2026', 'read' => '11 dakika okuma', 'img'   => 'mud-pump.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Sondaj devrindeki çamur pompası, sistemin kalbi konumundadır. Kuyudan çıkan kırıntı malzemenin yüzeye taşınması, matkabın soğutulması ve kuyu içi basınç kontrolünün sağlanması — hepsi bu pompaya bağlıdır. Doğru boyutlandırma ve düzenli bakım, hem verim hem de operasyon maliyeti üzerinde belirleyicidir.'],
                ['p', 'Türkiye\'de sondaj sektöründe en yaygın kullanılan çamur pompası tipi triplex pistonlu pompadır. Üç pistonun senkron çalışması sabit debi ve düşük titreşim sağlar. Ancak bu tip pompaların da kendine özgü bakım gereksinimleri ve verim optimizasyon noktaları vardır. Bu rehberde 20 yıllık saha tecrübemizle çamur pompası performansını maksimize etmenin yollarını paylaşıyoruz.'],
                ['h', 'Debi ve Basınç Dengesi — Optimum Aralık Nasıl Belirlenir?'],
                ['p', 'Aşırı debi yüksek aşınma ve yüksek yakıt/enerji tüketimi anlamına gelir; düşük debi ise kuyu temizliğinin yetersiz kalması, kırıntının kuyu tabanında birikmesi ve matkap aşırı ısınması demektir. Optimum aralık, formasyon karakteri, delik çapı ve derinlik ile birlikte belirlenmelidir.'],
                ['p', 'Pratik hesaplama: kuyu yıllık halka alanı × minimum akış hızı (0.9-1.5 m/s) = minimum debi. Örneğin 165 mm delik ve 89 mm tij için halka kesit alanı yaklaşık 15 cm², minimum akış hızı 1.2 m/s alırsak minimum debi ~110 lt/dk. Küçük çaplı sondajda 200-400 lt/dk, büyük çaplı jeotermal veya su sondajında 800-2000 lt/dk aralığı normal.'],
                ['h', 'Piston Hareket Eğrisi ve Senkron Çalışma'],
                ['p', 'Triplex pompada üç pistonun senkron çalışması sabit basınç ve düşük titreşim demektir. Her piston 120° faz farkı ile hareket eder ve toplam debi eğrisi neredeyse düz bir çizgi olur. Piston contası aşınmalarında bu senkron bozulur, debi eğrisi dalgalı hale gelir ve basınç darbeleri başlar.'],
                ['p', 'Basınç darbesi tespit yöntemi: pompa çıkış manometresinde okuma dalgalanması >%5 ise senkron bozulmuş demektir. Bu durumda üç pistonun contalarını, valflerini ve silindir gömleklerini eş zamanlı kontrol edin — çoğu zaman tek piston değil, birkaç piston aynı yaşta olduğu için beraber aşınır.'],
                ['h', 'Aşınma Noktaları ve Planlı Bakım'],
                ['p', 'Çamur pompasında dört ana aşınma noktası vardır: (1) Piston contası (fluid end kısmında, kauçuk/poliüretan), 300-800 saat ömür; (2) Silindir gömleği (liner, kromlu çelik), 2000-4000 saat; (3) Emiş valfi ve basınç valfi, 500-1500 saat; (4) Pompa şaftı yatakları, 5000-8000 saat.'],
                ['p', 'Belirli çalışma saatinde plansız arıza yerine planlı değişim, hem maliyet hem de operasyon sürekliliği açısından avantajlıdır. Bir piston contası patlaması sahada 4-8 saat duruş demek; planlı değişim 30-45 dakika. Aradaki fark saha ücretiyle çarpılınca kritik. Yıllık bakım takvimi tutun ve çalışma saatlerini not edin.'],
                ['h', 'Çamur Kalitesi ve Filtreleme'],
                ['p', 'Pompaya giren çamurun temizliği aşınma hızını doğrudan belirler. Aşındırıcı katı madde (kum, ince taş kırıntısı) piston ve valflerdeki metal yüzeylerde mikron ölçüde aşınma yaratır — kısa vadede fark edilmez, uzun vadede pompa ömrünü %40 kısaltır. Çamur devri sonunda mutlaka shale shaker (titreşimli elek) ve gerekirse desander (kum ayırıcı) kullanın.'],
                ['p', 'Çamur viskozitesi de kritiktir. Yüksek viskozite (aşırı bentonit) pompa yükünü artırır ve enerji tüketimini yükseltir; düşük viskozite (su kadar akışkan) katıları tutamaz. Marsh Funnel testi ile viskoziteyi düzenli ölçün — 40-55 saniye aralığı çoğu su sondajı için uygundur.'],
                ['h', 'Sonuç ve Servis Sürekliliği'],
                ['p', 'Çamur pompası performansı; debi-basınç dengesi, senkron çalışma, aşınma yönetimi ve çamur kalitesi olmak üzere dört ayaklı bir bakım disiplinine bağlıdır. Bir alanda ihmal, diğerlerini de zamanla bozar. Türkiye\'de sondaj operatörleri en çok "pompa arıza yapıyor" derken, aslında bakım eksikliğinin sonuçlarını yaşarlar.'],
                ['p', 'Asef Sondaj olarak triplex ve diğer sondaj pompalarında yedek parça (piston, contası, valf, gömlek), servis ve teknik danışmanlık sağlıyoruz. Pompanızın performansı düşüyorsa veya beklenmedik arıza yaşadıysanız WhatsApp\'tan bize yazın — pompa model ve seri numarasıyla birlikte durumu iletin, uygun yedek parça ve müdahale önerisi verelim.'],
            ],
        ],
        'karot-hatalari' => [
            'cat'   => 'Vaka Çalışması',
            'title' => 'Karot Alma Operasyonlarında Yaygın Hatalar: 4 Sahadan Vaka Analizi',
            'lede'  => 'Karot alma operasyonlarında en sık yapılan hatalar, gerçek saha vakalarından örneklerle ve önleme yöntemleri. Doğru derinlikte doğru karot almanın disiplini.',
            'date'  => '22 Temmuz 2026', 'read' => '10 dakika okuma', 'img'   => 'asef-macro-diamond.jpg', 'author' => 'Asef Teknik Ekip',
            'body'  => [
                ['p', 'Karot alma operasyonu; hem doğru ekipman hem de saha disiplini gerektiren hassas bir iştir. Jeolojik analiz, madencilik, jeoteknik zemin araştırması ve altyapı projelerinde alınan karotun kalitesi, tüm projenin dayandığı temel veridir. Yanlış alınmış bir karot, milyonlarca liralık kararların yanlış temele oturmasına neden olabilir.'],
                ['p', 'Asef Sondaj olarak 20 yıllık saha tecrübemizde binlerce karot operasyonunda gördük ki, karot kalite kaybının %90\'ı 4 tekrar eden hataya dayanır. Bu rehberde bu 4 hatayı gerçek saha vakalarımızdan örneklerle anlatıyor, önleme yöntemlerini paylaşıyoruz.'],
                ['h', '1. Yanlış Karotier Boyutu Seçimi (HQ/NQ/PQ Karışıklığı)'],
                ['p', 'HQ (96 mm), NQ (75.7 mm), PQ (122 mm) — bu üç ölçü karot alımının temelidir. Aralarında geçiş yaparken bağlantı standartları, iç tüp uyumu, elmas uç boyutu ve karot verimi tamamen değişir. Standart geçişini doğru planlamamak, hem karotu hem de ekipmanı riske atar.'],
                ['p', '<strong>Saha vakası (Denizli, 2023):</strong> Bir müşterimiz NQ ile başladığı sondajda 120 m sonra formasyon sertliğine bağlı olarak HQ\'ya geçmek istedi. Ancak HQ karotier iç tüp standartları için uyumsuz muhafaza borusu kullandığı için ilk 15 m\'de karot verimi %40\'a düştü. Sorun, geçiş öncesinde muhafaza borusu değişimi ve ara ölçü karotier kullanımıyla çözülebilirdi. Sonuç: 3 gün gecikme, yeniden karot alımı.'],
                ['h', '2. Hızlı İlerleme Yanılgısı'],
                ['p', 'Karot alımı hızlı ilerleme değil, TAM ilerlemedir. Aşırı basınç (weight-on-bit, WOB) ve yüksek devir (RPM); karot parçalar, temsili örnek almayı zorlaştırır ve elmas ucun ömrünü kısaltır. Karot sondajında kalite hızdan önce gelmelidir.'],
                ['p', '<strong>Saha vakası (Manisa, 2024):</strong> Bir jeoteknik firma proje süresini kısaltmak için WOB\'u üretici tavsiyesinin %30 üzerine çıkardı. İlk 20 m\'de günlük 8 m ilerlediler (normal 5 m), ama %60 fragmented (parçalanmış) karot geldi. Jeolog kabul etmedi, aynı bölgeden tekrar sondaj gerekti. Süre kaybı: 5 gün. Ekonomik kayıp: proje bütçesinin %8\'i.'],
                ['p', 'Doğru pratik: her formasyon değişikliğinde WOB ve RPM parametrelerini yeniden ayarlayın. Yumuşak formasyon: düşük WOB (500-1500 kg), orta RPM (400-600). Sert formasyon: yüksek WOB (2000-4000 kg), düşük RPM (200-400). Elmas uç üreticisinin veri sayfasını takip edin.'],
                ['h', '3. Yetersiz Soğutma ve Sirkülasyon'],
                ['p', 'Elmas uçların ömrü, doğru soğutma sıvısı akışıyla katlanır. Yetersiz akış aşırı ısınma, elmas taş kaybı ve iç tüp tıkanması demektir. Karot alımında sirkülasyon sıvısı sadece kırıntı taşıma değil, aynı zamanda uç soğutma ve karot koruma görevi de görür.'],
                ['p', '<strong>Saha vakası (Van, 2024):</strong> Bir maden arama firması pompa kapasitesini gereksiz görerek yarıya düşürdü. HQ karotier ile 150 m derinlikte 12 lt/dk sıvı akışı ile sondaja devam etti (normal 40 lt/dk). Elmas uç 8 saatte tükendi (normal ömür: 25-40 saat). Ek olarak, karot 3 farklı noktada ısıl deformasyona uğradı — analiz sonuçları güvenilir olmadı.'],
                ['p', 'Genel kural: karotier boyutuna göre minimum sıvı akış hızları: BQ 15-25 lt/dk, NQ 25-45 lt/dk, HQ 40-70 lt/dk, PQ 60-100 lt/dk. Pompa kapasitesi bu değerleri tam olarak destekleyebiliyor olmalı. Sıvı sıcaklığı 40°C\'yi geçmemeli — üzerinde ise soğutma sistemi eklenmeli.'],
                ['h', '4. Karot Sandığı Yönetimi ve Belgeleme'],
                ['p', 'Alınan karotun sistematik olarak numaralandırılması, fotoğraflanması ve saklanması; tüm operasyonun anlamını belirler. Yanlış belgelendirilmiş karot, kaybolmuş karot ile eşdeğerdir — jeolojik analizde kullanılamaz.'],
                ['p', '<strong>Saha vakası (Trabzon, 2023):</strong> Bir altın arama projesinde ilk 200 m karot düzgün belgelendi. Ancak 200-350 m arası ekip değişimi ve karot sandığı isim etiketleme disiplini kaybolunca, 40 m karotun hangi derinlikten geldiği net belirlenemedi. Jeolog analiz raporunda "belirsiz aralık" olarak işaretledi, projenin bu kısmı için tekrar sondaj kararı verildi. Ek maliyet: proje bütçesinin %12\'si.'],
                ['p', 'Karot sandığı disiplini: (1) her kutu üzerinde proje adı, kuyu numarası, derinlik aralığı, tarih yazılmalı; (2) her karot parçası kutuya derinlik sırasıyla yerleştirilmeli; (3) alınır alınmaz fotoğraflanmalı (referans cetvel ile); (4) etiketlerde silinmez marker veya baskı kullanılmalı; (5) kutu içinde bölmeler ile bloklama yapılmalı — düşme veya karışma önlensin.'],
                ['h', 'Bonus: Karot Verimini Artıran 3 Pratik İpucu'],
                ['p', '<strong>1. Karotu her run\'da (koşta) hemen çıkarın</strong> — karot iç tüpte bırakmak, formasyon sıvısı emerek şişmesine ve parçalanmasına yol açar. <strong>2. Uygun elmas serisi seçin</strong> — matrix sertliği formasyon sertliğine göre olmalı; ters seçim ya elmas taşımaz ya da uç aşınır. <strong>3. İç tüp temizliği</strong> — her run öncesi iç tüp basınçlı suyla yıkanmalı; kalıntı formasyon sonraki karot ile karışır.'],
                ['h', 'Sonuç'],
                ['p', 'Karot alma operasyonlarında yaygın 4 hata — yanlış karotier boyutu, hızlı ilerleme, yetersiz soğutma, karot sandığı yönetimi eksikliği — proje süresini uzatır ve bütçeyi artırır. Ancak sistematik disiplin ile bu hatalar tamamen önlenebilir. Karot kalitesi, tüm jeolojik analiz sürecinizin sağlam bir temele oturmasını sağlar.'],
                ['p', 'Asef Sondaj olarak karot ekipmanları (HQ/NQ/PQ karotier setleri, iç tüp, elmas uçlar, matrix çeşitleri) tedariki ve karot operasyonu teknik danışmanlığı sağlıyoruz. Projeniz için ekipman veya operasyon planlaması destek arıyorsanız WhatsApp\'tan bize yazın.'],
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
