{{-- ============================================================
     Asef Sondaj — Hakkımızda (v5)
     Route: /hakkimizda
     ============================================================ --}}
@php
    $channel      = core()->getCurrentChannel();
    $waLink       = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, Asef Sondaj hakkında bilgi almak istiyorum.');
    $catalogUrl   = route('shop.search.index');
    $asefUrl      = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));
@endphp

@push('meta')
    <meta name="title" content="Hakkımızda — Asef Sondaj" />
    <meta name="description" content="20 yıllık saha tecrübesiyle Türkiye'nin sondaj operasyonlarına ekipman, yedek parça ve teknik çözüm sağlıyoruz. Bursa merkezli, uluslararası standartta hizmet." />
    <meta name="theme-color" content="#ffffff" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    /* Hakkımızda özel */
    .ab-hero {
        max-width: 1024px; margin: 0 auto;
        padding: 56px 20px 40px; text-align: center;
    }
    @media (min-width: 768px) { .ab-hero { padding: 88px 20px 64px; } }
    .ab-hero h1 {
        font-size: clamp(40px, 6vw, 64px);
        font-weight: 600; letter-spacing: -0.03em; line-height: 1.05;
        color: var(--primary); margin: 20px auto 20px;
        max-width: 820px;
    }
    .ab-hero p {
        font-size: clamp(17px, 1.8vw, 21px);
        color: var(--gray-secondary); max-width: 620px; margin: 0 auto 32px;
        line-height: 1.55;
    }

    /* Story split */
    .ab-story {
        max-width: 1440px; margin: 0 auto 80px; padding: 0 20px;
        display: grid; grid-template-columns: 1fr; gap: 32px;
    }
    @media (min-width: 768px) { .ab-story { padding: 0 32px; margin-bottom: 120px; } }
    @media (min-width: 900px) { .ab-story { grid-template-columns: 1.1fr 1fr; gap: 48px; align-items: center; } }
    .ab-story-img {
        aspect-ratio: 4/5;
        border-radius: 24px; overflow: hidden;
        background: #14161a;
    }
    .ab-story-img img { width: 100%; height: 100%; object-fit: cover; }
    .ab-story-body { max-width: 480px; }
    .ab-story-body h2 {
        font-size: clamp(28px, 3.5vw, 40px);
        font-weight: 600; letter-spacing: -0.02em; line-height: 1.15;
        color: var(--primary); margin-bottom: 20px;
    }
    .ab-story-body p {
        font-size: 17px; color: var(--secondary);
        line-height: 1.6; margin-bottom: 16px;
    }

    /* Stats bento (3D) */
    .ab-stats-wrap { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .ab-stats-wrap { margin-bottom: 120px; } }
    .ab-stats-grid {
        display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;
    }
    @media (min-width: 768px) { .ab-stats-grid { grid-template-columns: repeat(4, 1fr); gap: 16px; } }
    .ab-stat-card {
        background: var(--surface-alt);
        border-radius: 22px;
        padding: 32px 24px 28px;
        position: relative;
        overflow: hidden;
        transition: transform .28s cubic-bezier(0.16, 1, 0.3, 1), box-shadow .3s;
        box-shadow:
            0 1px 0 rgba(255,255,255,0.9) inset,
            0 4px 12px rgba(0,0,0,0.03);
    }
    .ab-stat-card::before {
        content: "";
        position: absolute; inset: 0;
        background: radial-gradient(circle at 80% 10%, rgba(0,102,204,0.09), transparent 55%);
        pointer-events: none;
    }
    .ab-stat-card:hover {
        transform: translateY(-3px);
        box-shadow:
            0 1px 0 rgba(255,255,255,1) inset,
            0 12px 32px rgba(0,0,0,0.08);
    }
    .ab-stat-num {
        display: block;
        font-size: clamp(38px, 5vw, 56px);
        font-weight: 700; letter-spacing: -0.03em; line-height: 1;
        color: var(--primary);
        margin-bottom: 8px;
    }
    .ab-stat-label {
        display: block;
        font-size: 13px; color: var(--gray-secondary);
        letter-spacing: 0.02em;
    }

    /* Values bento */
    .ab-values-wrap { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .ab-values-wrap { margin-bottom: 120px; } }
    .ab-values-head { text-align: center; margin-bottom: 40px; }
    .ab-values-head h2 {
        font-size: clamp(28px, 4vw, 40px);
        font-weight: 600; letter-spacing: -0.02em; color: var(--primary);
    }
    .ab-values-grid {
        display: grid; grid-template-columns: 1fr; gap: 16px;
    }
    @media (min-width: 640px) { .ab-values-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (min-width: 900px) { .ab-values-grid { grid-template-columns: repeat(4, 1fr); } }
    .ab-value {
        background: var(--surface-alt);
        border-radius: 22px;
        padding: 28px 24px 30px;
        display: flex; flex-direction: column; gap: 12px;
        position: relative;
        transition: transform .32s cubic-bezier(0.16, 1, 0.3, 1), background .2s;
    }
    .ab-value:hover {
        transform: translateY(-2px) rotate(-0.3deg);
        background: #EEEEF0;
    }
    .ab-value-icon {
        width: 44px; height: 44px; border-radius: 14px;
        background: #FFFFFF;
        display: grid; place-items: center;
        color: var(--link-blue);
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 10px rgba(0,102,204,0.08);
    }
    .ab-value-icon svg { width: 22px; height: 22px; }
    .ab-value-title {
        font-size: 17px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary);
    }
    .ab-value-desc {
        font-size: 14px; color: var(--secondary); line-height: 1.5;
    }

    /* Timeline reuses global .asef-timeline-wrap */

    /* Reveal animation — starts visible for safety; adds subtle in-motion only when JS says so */
    .ab-reveal { transition: opacity .7s ease, transform .7s cubic-bezier(0.16, 1, 0.3, 1); }
    @media (prefers-reduced-motion: no-preference) {
        html.js-ready .ab-reveal:not(.visible) { opacity: 0; transform: translateY(18px); }
    }
</style>
@endpush

<x-shop::layouts
    :has-header="false"
    :has-feature="false"
    :has-footer="false"
>
    <x-slot:title>
        Hakkımızda — Asef Sondaj
    </x-slot>

    <div class="asef-root">

        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            {{-- HERO --}}
            <section class="ab-hero ab-reveal">
                <div class="asef-label-caps">HAKKIMIZDA</div>
                <h1>Yirmi yıllık saha, tek bir söz: <em style="font-style:normal;color:var(--link-blue);">güven.</em></h1>
                <p>Bursa merkezimizden Türkiye'nin dört bir yanındaki sondaj operasyonlarına ekipman, yedek parça ve teknik çözüm sunuyoruz. Sahaya hazır olan biziz.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill primary">Ürünleri Keşfet</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">Uzmana Sor <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            {{-- MARKA HIKAYESI --}}
            <section class="ab-story">
                <div class="ab-story-img ab-reveal">
                    <img src="{{ $asefUrl('asef-hero-rig.jpg') }}" alt="Asef Sondaj sahada" />
                </div>
                <div class="ab-story-body ab-reveal">
                    <h2>Sahaya hazır çözümler, mühendislikte hassasiyet.</h2>
                    <p>Asef Sondaj, 2005'ten bu yana Türkiye'nin sondaj sektöründe faaliyet gösteren, Bursa merkezli teknik çözüm ortağıdır. Delici ekipmandan pompa sistemlerine, tijden karot ürünlerine kadar geniş bir yelpazede ürün ve hizmet sunuyoruz.</p>
                    <p>Her bir ürünün arkasında saha tecrübesi, her bir sevkiyatın arkasında teknik danışmanlık vardır. Amacımız, sondaj operasyonlarınızda güvenli, kesintisiz ve verimli çözümler sağlamak.</p>
                    <p>Bizi farklı kılan; ürünün ötesinde çözümü, teslimatın ötesinde teknik desteği ve tek satışın ötesinde uzun soluklu iş birliğini önemsememizdir.</p>
                </div>
            </section>

            {{-- RAKAMLAR (3D bento) --}}
            <section class="ab-stats-wrap">
                <div class="ab-stats-grid">
                    <div class="ab-stat-card ab-reveal">
                        <span class="ab-stat-num" data-count-to="20">20+</span>
                        <span class="ab-stat-label">Yıl Saha Tecrübesi</span>
                    </div>
                    <div class="ab-stat-card ab-reveal">
                        <span class="ab-stat-num" data-count-to="500">500+</span>
                        <span class="ab-stat-label">Tamamlanan Proje</span>
                    </div>
                    <div class="ab-stat-card ab-reveal">
                        <span class="ab-stat-num" data-count-to="47">47</span>
                        <span class="ab-stat-label">İl Hizmet Alanı</span>
                    </div>
                    <div class="ab-stat-card ab-reveal">
                        <span class="ab-stat-num">7/24</span>
                        <span class="ab-stat-label">Teknik Danışmanlık</span>
                    </div>
                </div>
            </section>

            {{-- DEĞERLERİMİZ --}}
            <section class="ab-values-wrap">
                <div class="ab-values-head ab-reveal">
                    <div class="asef-label-caps" style="margin-bottom: 8px;">DEĞERLERİMİZ</div>
                    <h2>Uzun soluklu iş birliğinin dört temeli.</h2>
                </div>
                <div class="ab-values-grid">
                    <div class="ab-value ab-reveal">
                        <div class="ab-value-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                        <div class="ab-value-title">Güvenilirlik</div>
                        <div class="ab-value-desc">Söz verdiğimiz zamanda, söz verdiğimiz koşulda teslim ediyoruz. Sahada bize güvenmenizin karşılığını veriyoruz.</div>
                    </div>
                    <div class="ab-value ab-reveal">
                        <div class="ab-value-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2" fill="currentColor"/></svg>
                        </div>
                        <div class="ab-value-title">Kalite</div>
                        <div class="ab-value-desc">Yalnızca sahada denenmiş, standartlara uygun ekipmanları katalogumuza dahil ediyoruz. Her ürün, arkasında test var.</div>
                    </div>
                    <div class="ab-value ab-reveal">
                        <div class="ab-value-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><polyline points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                        </div>
                        <div class="ab-value-title">Hız</div>
                        <div class="ab-value-desc">Teklif isteğinizden teslimatına kadar en hızlı yolu buluyor, operasyonunuzu aksatmıyoruz. WhatsApp ile direkt iletişim.</div>
                    </div>
                    <div class="ab-value ab-reveal">
                        <div class="ab-value-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                        </div>
                        <div class="ab-value-title">Şeffaflık</div>
                        <div class="ab-value-desc">Fiyattan teslim süresine, teknik özellikten alternatiflere kadar her bilgiyi net paylaşıyoruz. Sürpriz maliyet yok.</div>
                    </div>
                </div>
            </section>

            {{-- SONDAJ MAKİNALARIMIZ CTA --}}
            <section class="asef-section-wide ab-reveal">
                <div class="asef-machine-showcase">
                    <div class="asef-machine-showcase-bg" style="background-image: url('{{ $asefUrl('drilling-hero.jpg') }}');"></div>
                    <div class="asef-machine-content">
                        <div class="asef-label-caps">SONDAJ MAKİNALARIMIZ</div>
                        <h2>Her operasyon türü için hazır ekipman.</h2>
                        <p>Yerüstü, yeraltı ve su sondaj makineleri; delici ekipman ve pompa sistemleriyle birlikte.</p>
                        <a href="{{ $catalogUrl }}" class="asef-cta-pill white-bg">Kataloga Göz At</a>
                    </div>
                </div>
            </section>

            {{-- TARIHÇE --}}
            <section class="asef-section ab-reveal">
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
                            <div class="asef-timeline-text">Yeni nesil web platformu ve genişleyen ürün ailesi.</div>
                        </div>
                        <span class="asef-timeline-dot"></span>
                        <div></div>
                    </div>
                </div>
            </section>

            {{-- İLETİŞİM CTA --}}
            <section class="asef-section ab-reveal">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">İLETİŞİM</div>
                    <h2>Projenizi birlikte planlayalım.</h2>
                    <p>Delik çapı, formasyon, çalışma basıncı ve bağlantı bilgilerinizi paylaşın; teknik ekibimiz size en uygun çözümü önerir.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>

        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>

    {{-- Scroll reveal + counter animation --}}
    @push('scripts')
    <script>
    (function () {
        // Reduced motion guard
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Only opt into the "hide until visible" state when we know JS is ready.
        if (!reduce) {
            document.documentElement.classList.add('js-ready');
        }

        // Reveal on scroll
        var reveals = document.querySelectorAll('.ab-reveal');
        // Safety net: after 2s show everything unconditionally in case IO didn't fire.
        setTimeout(function () {
            reveals.forEach(function (el) { el.classList.add('visible'); });
        }, 2000);

        if (reveals.length) {
            if (reduce || !('IntersectionObserver' in window)) {
                reveals.forEach(function (el) { el.classList.add('visible'); });
            } else {
                var io = new IntersectionObserver(function (entries) {
                    entries.forEach(function (e) {
                        if (e.isIntersecting) {
                            e.target.classList.add('visible');
                            io.unobserve(e.target);
                        }
                    });
                }, { threshold: 0.15, rootMargin: '0px 0px -60px 0px' });
                reveals.forEach(function (el) { io.observe(el); });
            }
        }

        // Counter (stat numbers)
        var counters = document.querySelectorAll('[data-count-to]');
        if (counters.length && !reduce && 'IntersectionObserver' in window) {
            var counterIo = new IntersectionObserver(function (entries) {
                entries.forEach(function (e) {
                    if (!e.isIntersecting) return;
                    var el = e.target;
                    counterIo.unobserve(el);
                    var target = parseInt(el.getAttribute('data-count-to'), 10) || 0;
                    var duration = 1400;
                    var start = performance.now();
                    var suffix = /\+/.test(el.textContent) ? '+' : '';
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
            counters.forEach(function (c) { counterIo.observe(c); });
        }
    })();
    </script>
    @endpush
</x-shop::layouts>
