{{-- Sondaj Makinalarımız — /sondaj-makinalarimiz --}}
@php
    $waLink = asef_wa_link('Merhaba, sondaj makineleri hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $types = [
        ['num' => '01', 'title' => 'Yerüstü Sondaj Makineleri', 'desc' => 'Kayaç ve zemin operasyonları için palet veya kamyon üstü konfigürasyonlarda yüksek verim.',   'img' => 'drilling-hero.jpg'],
        ['num' => '02', 'title' => 'Yeraltı Sondaj Makineleri', 'desc' => 'Madencilik ve tünel operasyonlarında kompakt gövde ile yüksek manevra kabiliyeti.',           'img' => 'asef-hero-rig.jpg'],
        ['num' => '03', 'title' => 'Su Sondaj Makineleri',      'desc' => 'Yeraltı su kaynakları için hassas delme; derin ve verimli su sondajı çözümleri.',            'img' => 'dth-hammer.jpg'],
        ['num' => '04', 'title' => 'Zemin Etüd Makineleri',     'desc' => 'İnşaat öncesi zemin karakterizasyonu, karot alımı ve sondaj analizi için profesyonel setler.','img' => 'asef-macro-diamond.jpg'],
    ];
@endphp

@push('meta')
    <meta name="title" content="Sondaj Makineleri — Yerüstü, Yeraltı, Su, Jeoteknik | Asef Sondaj" />
    <meta name="description" content="Karot, rotary, DTH ve jeoteknik sondaj makineleri: yerüstü, yeraltı, su ve zemin etüd operasyonları için Türkiye geneli tedariği. Makine ve orijinal yedek parça ile birlikte teknik destek." />
    <meta name="keywords" content="sondaj makineleri, karot sondaj makinesi, rotary sondaj makinesi, DTH sondaj makinesi, jeoteknik sondaj makinesi, su sondaj makinesi" />
    <link rel="canonical" href="{{ url('sondaj-makinalarimiz') }}" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .mk-grid { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: 1fr; gap: 20px; }
    @media (min-width: 768px) { .mk-grid { grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 120px; } }
    .mk-card {
        background: var(--surface-alt); border-radius: 24px; overflow: hidden;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s;
        display: flex; flex-direction: column;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 14px rgba(0,0,0,0.04);
    }
    .mk-card:hover { transform: translateY(-3px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 14px 34px rgba(0,0,0,0.09); }
    .mk-media { aspect-ratio: 16/10; background: #14161a; overflow: hidden; }
    .mk-media img { width: 100%; height: 100%; object-fit: cover; }
    .mk-body { padding: 24px 26px 26px; display: flex; flex-direction: column; gap: 8px; }
    .mk-num { font-family: "SF Mono", ui-monospace, Menlo, monospace; font-size: 11px; letter-spacing: 0.1em; color: var(--gray-secondary); }
    .mk-title { font-size: 22px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); }
    .mk-desc { font-size: 15px; color: var(--secondary); line-height: 1.55; }
    .mk-link { margin-top: 6px; font-size: 14px; color: var(--link-blue); font-weight: 500; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Sondaj Makinalarımız — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">SONDAJ MAKİNALARIMIZ</div>
                <h1>Sahada denendi. Kanıtlandı.</h1>
                <p>{{ asef_setting('sondaj_makinalari_hero_desc', 'Yerüstü, yeraltı, su ve zemin etüd operasyonları için hazır çözümler. Doğru makine için ekibimiz size özel öneride bulunur.') }}</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Uzmana Danış</a>
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill ghost">Ekipman Kataloğu <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            <section class="mk-grid">
                @foreach ($types as $t)
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="mk-card">
                        <div class="mk-media"><img src="{{ $asefUrl($t['img']) }}" alt="{{ $t['title'] }}" loading="lazy" width="600" height="400"></div>
                        <div class="mk-body">
                            <span class="mk-num">{{ $t['num'] }}</span>
                            <div class="mk-title">{{ $t['title'] }}</div>
                            <p class="mk-desc">{{ $t['desc'] }}</p>
                            <span class="mk-link">WhatsApp'tan bilgi al ›</span>
                        </div>
                    </a>
                @endforeach
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">EKİPMAN SEÇİMİ</div>
                    <h2>Hangisi sizin operasyonunuza uygun?</h2>
                    <p>Delik çapı, formasyon ve derinlik bilgilerinizi paylaşın; en uygun makine tipini birlikte belirleyelim.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
