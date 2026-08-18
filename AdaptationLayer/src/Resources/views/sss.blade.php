{{-- SSS (Sıkça Sorulan Sorular) — /sss --}}
@php
    $waLink     = asef_wa_link('Merhaba, sormak istediğim bir konu var.');
    $catalogUrl = route('shop.search.index');
    $asefUrl    = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    // Öncelik: DB (admin panelden yönetilenler). Boş ise Blade fallback array.
    $dbFaqs = collect();
    try {
        $dbFaqs = \AsefSondaj\AdaptationLayer\Models\AsefFaq::where('is_active', true)
            ->orderBy('sort')->orderBy('id')->get()
            ->map(fn ($f) => ['q' => $f->q, 'a' => $f->a])->all();
    } catch (\Throwable $e) {
        $dbFaqs = [];
    }

    $faqsBladeArray = [
        [
            'q' => 'Fiyat almak için ne yapmalıyım?',
            'a' => 'Katalogdan ilgilendiğiniz ürünleri "Sepete Ekle" ile teklif sepetinize atın, ardından "WhatsApp\'tan Teklif Al" butonu ile ürünler listesini doğrudan bize gönderin. Ekibimiz en kısa sürede fiyat ve teslim süresi ile döner.',
        ],
        [
            'q' => 'Web sitesinde neden fiyat gösterilmiyor?',
            'a' => 'Sondaj ekipmanlarında fiyatlar; ölçü, bağlantı standardı, formasyon ve adet gibi teknik parametrelere göre değişir. Doğru fiyat için operasyon bilgilerinizi birlikte değerlendirmemiz gerekir; bu yüzden sabit liste fiyatı yayınlamıyoruz.',
        ],
        [
            'q' => 'Türkiye\'nin her yerine gönderim yapıyor musunuz?',
            'a' => 'Evet. 20 yılı aşkın süredir Türkiye geneline ekipman ve yedek parça sevkiyatı sağlıyoruz. Bulunduğunuz ile göre teslim süresi ve kargo bilgilerini teklifle birlikte paylaşıyoruz.',
        ],
        [
            'q' => 'Yedek parça bulabilir miyim?',
            'a' => 'Katalogdaki tüm ekipmanlar için orijinal yedek parça ve bakım seti temin ediyoruz. Elimizde olmayan modeller için de tedarik desteği sunuyoruz — WhatsApp\'tan model bilgisi paylaşmanız yeterli.',
        ],
        [
            'q' => 'Teknik danışmanlık ücretli mi?',
            'a' => 'Hayır. Ürün seçimi ve teknik uygunluk için danışmanlık ücretsizdir. Delik çapı, formasyon tipi, çalışma basıncı gibi bilgileri paylaştığınızda size en uygun ekipmanı öneriyoruz.',
        ],
        [
            'q' => 'Ürünlerin garantisi var mı?',
            'a' => 'Katalogdaki tüm ekipmanlar üretici garantisi altındadır. Garanti süresi ve şartları ürüne göre değişir; teklif aşamasında detaylarını iletiyoruz. Satış sonrası servis desteği tüm ürünler için mevcuttur.',
        ],
        [
            'q' => 'Sipariş sonrası teslim süresi ne kadar?',
            'a' => 'Stokta olan ürünler için 2-5 iş günü içinde kargoya veriyoruz. Sipariş üzerine tedarik edilen özel ürünler için süre ürüne göre değişir; her siparişte net süreyi teklifte belirtiyoruz.',
        ],
        [
            'q' => 'Farklı marka/model ekipman tedarik edebilir misiniz?',
            'a' => 'Evet. Katalogda olmayan ancak ihtiyacınız olan ekipmanları da tedarik ediyoruz. Marka, model ve teknik özellikleri WhatsApp\'tan iletmeniz yeterli — biz araştırıp size dönüyoruz.',
        ],
        [
            'q' => 'HQ, NQ ve PQ karotiyer standartları arasındaki fark nedir?',
            'a' => 'DCDMA (Diamond Core Drill Manufacturers Association) standartlarıdır. NQ (75.7 mm delik / 47.6 mm karot çapı), HQ (96 mm / 63.5 mm) ve PQ (122.6 mm / 85 mm) — sırayla daha büyük karot çapı ve daha derin sondaj kapasitesi anlamına gelir. Formasyon türü ve istenilen karot çapına göre seçilir.',
        ],
        [
            'q' => 'DTH çekiç hangi delik çaplarında kullanılır?',
            'a' => 'Down-the-hole (DTH) çekiçler genellikle 90 mm ile 305 mm arasındaki delik çaplarında kullanılır. Sert kaya formasyonlarında hem hız hem verim açısından rotary sondajdan üstündür. Kaya sertliği + delik çapı kombinasyonuna göre uygun DTH modeli önerilir.',
        ],
        [
            'q' => 'Su sondajı ile jeotermal sondaj ekipmanı arasında fark var mı?',
            'a' => 'Evet. Su sondajı genelde 30-200 metre derinliğe, jeotermal sondaj ise 500-3000 metre + yüksek sıcaklık ortamına inebilir. Jeotermal için özel yüksek sıcaklık dayanımlı tij, çamur ve sızdırmazlık ekipmanı gerekir. Detayları operasyon bilgilerinizle birlikte planlıyoruz.',
        ],
        [
            'q' => 'API IF, API REG ve DCDMA bağlantı standartları nedir?',
            'a' => 'Sondaj tijlerinde kullanılan diş standartlarıdır. API IF (Internal Flush) genelde su/jeotermal sondaj tijlerinde, API REG (Regular) rotary sondajda, DCDMA ise karot sondajında yaygındır. Ekipman değişimi yapılacaksa mutlaka mevcut bağlantı standardı ile uyumlu ürün seçilmelidir.',
        ],
        [
            'q' => 'Sondaj tijleri ne kadar dayanıklı, ne sıklıkla değişmeli?',
            'a' => 'Kaliteli sondaj tiji doğru kullanımla 2-4 yıl dayanır. Ancak korozyon, aşırı torque, yanlış bağlantı ve formasyon aşındırıcılığı ömrü kısaltır. Diş aşınması, gövde çatlağı ve düzgün olmayan yüzeyler değişim işaretidir — periyodik kontrol öneririz.',
        ],
        [
            'q' => 'Sondaj matkap ucu (bit) seçimi nasıl yapılır?',
            'a' => 'Matkap ucu seçimi 3 faktöre bağlıdır: formasyon tipi (yumuşak/orta/sert), delik çapı ve çalışma basıncı. Yumuşak formasyonda PDC bit, sert kaya için tricone veya karbür button bit tercih edilir. Doğru bit seçimi hem sondaj hızını hem bit ömrünü ciddi artırır.',
        ],
        [
            'q' => 'Çamur pompası (mud pump) kapasitesi nasıl seçilir?',
            'a' => 'Çamur pompası seçiminde 3 parametre önemli: gerekli basınç (bar), debi (L/min) ve tijli-formasyon kombinasyonu için minimum çamur hızı. Yanlış boyutlandırma pompayı aşırı yorar, verimi düşürür. Delik çapı + derinlik + tij ölçünüzü paylaşırsanız hesaplayıp öneririz.',
        ],
        [
            'q' => 'Yerinde bakım veya servis desteği veriyor musunuz?',
            'a' => 'Bursa merkez + civar iller için yerinde teknik destek verebiliyoruz. Uzak iller için WhatsApp/telefonla adım-adım servis rehberliği + gerekli parçanın hızlı sevkiyatı çözüm sunuyoruz.',
        ],
        [
            'q' => 'Ödeme koşulları nelerdir?',
            'a' => 'Havale/EFT, çek ve kurumsal siparişlerde açık hesap yöntemleriyle çalışıyoruz. Kredi kartı ile online ödeme şu an sitede yok — teklif aşamasında birlikte en uygun ödeme planını belirliyoruz.',
        ],
        [
            'q' => 'İhracat / yurt dışı gönderim yapıyor musunuz?',
            'a' => 'Evet. Türk cumhuriyetleri, Balkanlar ve Ortadoğu\'ya sondaj ekipmanı ihracatı sağlıyoruz. Fatura, gümrük evrakı ve nakliye organizasyonu ile ilgili detayları teklifle birlikte iletiyoruz.',
        ],
        [
            'q' => 'Kullanılmış / ikinci el ekipman satıyor musunuz?',
            'a' => 'Zaman zaman revizyondan geçmiş, garantili ikinci el ekipmanlarımız olabiliyor. Stok durumu değişkendir — WhatsApp\'tan bilgi alabilirsiniz.',
        ],
        [
            'q' => 'Katalogda hangi kategoriler var?',
            'a' => '15 ana kategori altında 63 alt kategori ve 900+ ürün bulunuyor: Wireline Karotiyer Sistemi (BWL/HQ/NQ/PQ), Düz Takım Karotiyer Sistemi, Elmas ve Vidye Ürünler, Karot Bit, Sondaj Tijleri ve Muhafaza Boruları (API IF, API REG, DCDMA), Aksesuarlar, Adaptörler, Tahlisiyeler, Numune Alıcılar, Kaya Delgi Ekipmanları (pörtkron sistemleri), Anahtarlar ve El Aletleri, Karot Sandıkları, Sondaj Kimyasalları, Jeoteknik ve Güvenlik Ekipmanları.',
        ],
    ];

    // Nihai listeleme: DB doluysa DB, boşsa Blade fallback (site kesintisiz)
    $faqs = ! empty($dbFaqs) ? $dbFaqs : $faqsBladeArray;
@endphp

@push('meta')
    <meta name="title" content="Sıkça Sorulan Sorular — Sondaj Ekipmanları, Karotiyer, Karot Bit | Asef Sondaj" />
    <meta name="description" content="Sondaj ekipmanları hakkında {{ count($faqs) }} sıkça sorulan soru: HQ/NQ/PQ karotiyer farkı, karot bit seçimi, API IF/REG/DCDMA bağlantı standartları, çamur pompası kapasitesi, tij dayanıklılığı, fiyat, teslimat, yedek parça." />
    <meta name="keywords" content="sondaj ekipmanları SSS, karotiyer standartları, karot bit seçimi, API bağlantı standardı, sondaj tiji, kaya delgi ucu, çamur pompası, sondaj yedek parça" />
    <link rel="canonical" href="{{ url('sss') }}" />
    <meta name="theme-color" content="#ffffff" />

    {{-- FAQPage JSON-LD — Google zengin sonuçlar (accordion) --}}
    @php
        $faqJsonLd = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => array_map(function ($f) {
                return [
                    '@type'          => 'Question',
                    'name'           => $f['q'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text'  => $f['a'],
                    ],
                ];
            }, $faqs),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .faq-wrap { max-width: 820px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .faq-wrap { margin-bottom: 120px; } }
    .faq-item {
        border-bottom: 1px solid var(--outline);
    }
    .faq-item:first-child { border-top: 1px solid var(--outline); }
    .faq-q {
        display: flex; align-items: center; justify-content: space-between;
        gap: 20px;
        padding: 22px 4px;
        cursor: pointer; user-select: none;
        transition: color .15s;
    }
    .faq-q:hover { color: var(--link-blue); }
    .faq-q-text {
        font-size: 17px; font-weight: 600; letter-spacing: -0.01em;
        color: inherit;
    }
    .faq-toggle {
        flex-shrink: 0;
        width: 32px; height: 32px; border-radius: 999px;
        background: var(--surface-alt);
        display: grid; place-items: center;
        color: var(--primary);
        transition: transform .3s cubic-bezier(0.16, 1, 0.3, 1), background .2s;
    }
    .faq-item.open .faq-toggle { transform: rotate(45deg); background: var(--primary); color: white; }
    .faq-a {
        max-height: 0; overflow: hidden;
        transition: max-height .35s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .faq-item.open .faq-a { max-height: 500px; }
    .faq-a-inner {
        padding: 0 4px 24px;
        font-size: 15px; line-height: 1.6; color: var(--secondary);
    }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Sıkça Sorulan Sorular — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">DESTEK MERKEZİ</div>
                <h1>Sıkça sorulan sorular.</h1>
                <p>Sipariş, teslimat, teknik danışmanlık ve daha fazlası. Aradığınız cevap yoksa bize WhatsApp'tan yazın.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Doğrudan Yaz</a>
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill ghost">Kataloga Git <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            <section class="faq-wrap">
                @foreach ($faqs as $i => $faq)
                    <div class="faq-item" data-faq>
                        <div class="faq-q" role="button" tabindex="0" aria-expanded="false">
                            <span class="faq-q-text">{{ $faq['q'] }}</span>
                            <span class="faq-toggle" aria-hidden="true">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14"/><path d="M5 12h14"/></svg>
                            </span>
                        </div>
                        <div class="faq-a"><div class="faq-a-inner">{!! nl2br(e($faq['a'])) !!}</div></div>
                    </div>
                @endforeach
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">DAHA FAZLA SORU</div>
                    <h2>Cevabı bulamadın mı?</h2>
                    <p>Teknik ekibimiz sondaj operasyonlarınıza özel her türlü sorunuzu WhatsApp veya telefonla yanıtlar.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>

    @push('scripts')
    <script>
    (function () {
        document.addEventListener('click', function (ev) {
            var q = ev.target.closest('.faq-q');
            if (!q) return;
            var item = q.closest('[data-faq]');
            var open = item.classList.toggle('open');
            q.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('keydown', function (ev) {
            if (ev.key !== 'Enter' && ev.key !== ' ') return;
            var q = document.activeElement.closest('.faq-q');
            if (!q) return;
            ev.preventDefault();
            q.click();
        });
    })();
    </script>
    @endpush
</x-shop::layouts>
