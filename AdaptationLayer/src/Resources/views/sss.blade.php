{{-- SSS (Sıkça Sorulan Sorular) — /sss --}}
@php
    $waLink     = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, sormak istediğim bir konu var.');
    $catalogUrl = route('shop.search.index');
    $asefUrl    = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $faqs = [
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
            'a' => 'Evet. 20 yılı aşkın süredir 47 ile ekipman ve yedek parça sevkiyatı sağlıyoruz. Bulunduğunuz ile göre teslim süresi ve kargo bilgilerini teklifle birlikte paylaşıyoruz.',
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
    ];
@endphp

@push('meta')
    <meta name="title" content="Sıkça Sorulan Sorular — Asef Sondaj" />
    <meta name="description" content="Asef Sondaj ile ilgili sıkça sorulan sorular. Fiyat, sipariş, teslimat, yedek parça, teknik danışmanlık ve garanti hakkında bilgi." />
    <meta name="theme-color" content="#ffffff" />
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
