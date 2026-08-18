{{-- Hizmetlerimiz — /hizmetlerimiz --}}
@php
    $waLink = asef_wa_link('Merhaba, hizmetleriniz hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $services = [
        [
            'label' => '01',
            'title' => 'Teknik Danışmanlık',
            'desc' => 'Delik çapı, formasyon, çalışma basıncı ve bağlantı bilgilerinize göre doğru ekipmanı birlikte seçeriz. 20 yıllık saha tecrübemiz, doğru soruları sormanızı kolaylaştırır.',
            'bullets' => ['Delik çapı ve formasyon analizi', 'Ekipman seçim danışmanlığı', 'Bağlantı standardı uyumluluğu', 'Alternatif ürün önerileri'],
        ],
        [
            'label' => '02',
            'title' => 'Proje Bazlı Tedarik',
            'desc' => 'Küçük yedek parça siparişinden çok kalemli proje tedariğine kadar, sahaya özel çözüm ve zamanında teslimatla operasyonunuzu aksatmayız.',
            'bullets' => ['Türkiye geneli sevkiyat', 'Proje bazlı bütçe planlama', 'Tek noktadan çoklu marka tedarik', 'Şeffaf fiyat ve teslim süreleri'],
        ],
        [
            'label' => '03',
            'title' => 'Satış Sonrası Destek',
            'desc' => 'Ekipmanınız çalışır durumda kaldığı sürece yanınızdayız. Kurulum, yedek parça, servis ve teknik destek — hepsi tek numara.',
            'bullets' => ['Kurulum ve devreye alma', 'Orijinal yedek parça garantisi', 'Teknik servis desteği', 'WhatsApp\'tan 7/24 iletişim'],
        ],
    ];
@endphp

@push('meta')
    <meta name="title" content="Sondaj Hizmetlerimiz — Teknik Danışmanlık, Tedarik, Satış Sonrası | Asef Sondaj" />
    <meta name="description" content="Sondaj ekipmanı seçim danışmanlığı, proje bazlı tedarik, Türkiye geneli hızlı sevkiyat ve satış sonrası teknik destek. 20 yıllık saha tecrübesiyle 81 ilde hizmet." />
    <meta name="keywords" content="sondaj hizmetleri, sondaj ekipmanı danışmanlığı, sondaj tedariği, sondaj proje bazlı, satış sonrası destek, teknik danışmanlık" />
    <link rel="canonical" href="{{ url('hizmetlerimiz') }}" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .sv-list { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: flex; flex-direction: column; gap: 20px; }
    @media (min-width: 768px) { .sv-list { margin-bottom: 120px; gap: 24px; } }
    .sv-card {
        background: var(--surface-alt); border-radius: 24px; padding: 32px 28px;
        display: grid; grid-template-columns: 1fr; gap: 20px;
        transition: transform .3s cubic-bezier(0.16,1,0.3,1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 14px rgba(0,0,0,0.03);
    }
    @media (min-width: 768px) { .sv-card { grid-template-columns: 80px 1fr; padding: 40px; gap: 32px; } }
    .sv-card:hover { transform: translateY(-2px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 12px 32px rgba(0,0,0,0.08); }
    .sv-num {
        font-family: "SF Mono", ui-monospace, Menlo, monospace;
        font-size: 32px; font-weight: 700; letter-spacing: -0.02em;
        color: var(--link-blue); line-height: 1;
    }
    .sv-title { font-size: clamp(22px, 2.6vw, 28px); font-weight: 600; letter-spacing: -0.01em; color: var(--primary); margin-bottom: 10px; }
    .sv-desc { font-size: 16px; color: var(--secondary); line-height: 1.6; margin-bottom: 16px; }
    .sv-bullets { list-style: none; display: grid; grid-template-columns: 1fr; gap: 8px; }
    @media (min-width: 640px) { .sv-bullets { grid-template-columns: 1fr 1fr; } }
    .sv-bullets li { display: flex; align-items: flex-start; gap: 8px; font-size: 14px; color: var(--on-surface); }
    .sv-bullets svg { flex-shrink: 0; margin-top: 3px; color: var(--link-blue); }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Hizmetlerimiz — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">HİZMETLERİMİZ</div>
                <h1>Ekipmandan öte, çözüm.</h1>
                <p>{{ asef_setting('hizmetlerimiz_hero_desc', 'Danışmanlıktan tedarike, kurulumdan satış sonrası desteğe — her adımda yanınızdayız.') }}</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">Uzmana Danış</a>
                    <a href="{{ $catalogUrl }}" class="asef-cta-pill ghost">Kataloga Git <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            <section class="sv-list">
                @foreach ($services as $s)
                    <div class="sv-card">
                        <div class="sv-num">{{ $s['label'] }}</div>
                        <div>
                            <div class="sv-title">{{ $s['title'] }}</div>
                            <p class="sv-desc">{{ $s['desc'] }}</p>
                            <ul class="sv-bullets">
                                @foreach ($s['bullets'] as $b)
                                    <li>
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
                                        {{ $b }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </section>

            {{-- TÜRKİYE GENELİ HİZMET AĞI — 81 İL --}}
            <section class="asef-section" style="max-width:1024px; margin:0 auto; padding:60px 20px 20px;">
                <div style="text-align:center; margin-bottom:32px;">
                    <div class="asef-label-caps">TÜRKİYE GENELİ HİZMET</div>
                    <h2 style="font-size:clamp(28px, 3.4vw, 40px); font-weight:600; letter-spacing:-0.02em; color:var(--primary); margin:12px 0 16px;">81 ilde sondaj çözüm ortağınız.</h2>
                    <p style="font-size:17px; color:var(--secondary); line-height:1.6; max-width:720px; margin:0 auto;">Bursa merkezli olarak Türkiye'nin 81 ilinde sondaj ekipmanı tedariki, teknik danışmanlık ve satış sonrası servis sağlıyoruz. 20 yıllık saha tecrübemiz, tüm bölgelerdeki iklim, formasyon ve mevzuat farklılıklarına özel çözüm üretmemizi mümkün kılıyor.</p>
                </div>
                <div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:14px; margin-bottom:40px;">
                    @foreach ([
                        ['🚚', 'Türkiye içi hızlı kargo — ekipman siparişleriniz 2-5 iş gününde teslim.'],
                        ['🏗️', 'Ağır yük organizasyonu — sondaj makinesi ve komple set için kamyon+kurulum desteği.'],
                        ['📞', 'Teknik danışmanlık 7/24 — WhatsApp ve telefon üzerinden anında yanıt.'],
                        ['⚡', 'Yedek parça acil sevkiyat — kritik parçalar için 24 saat hızlı çözüm.'],
                    ] as $svc)
                        <div style="background:var(--surface-alt); padding:20px; border-radius:14px; display:flex; gap:12px; align-items:flex-start;">
                            <span style="font-size:22px; flex-shrink:0;">{{ $svc[0] }}</span>
                            <span style="font-size:14px; color:var(--on-surface); line-height:1.5;">{{ $svc[1] }}</span>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:32px;">
                    <h3 style="font-size:18px; font-weight:600; color:var(--primary); margin-bottom:16px; letter-spacing:-0.01em;">Hizmet Verdiğimiz İller</h3>
                    @php
                        $iller = ['Adana','Adıyaman','Afyonkarahisar','Ağrı','Aksaray','Amasya','Ankara','Antalya','Ardahan','Artvin','Aydın','Balıkesir','Bartın','Batman','Bayburt','Bilecik','Bingöl','Bitlis','Bolu','Burdur','Bursa','Çanakkale','Çankırı','Çorum','Denizli','Diyarbakır','Düzce','Edirne','Elazığ','Erzincan','Erzurum','Eskişehir','Gaziantep','Giresun','Gümüşhane','Hakkari','Hatay','Iğdır','Isparta','İstanbul','İzmir','Kahramanmaraş','Karabük','Karaman','Kars','Kastamonu','Kayseri','Kırıkkale','Kırklareli','Kırşehir','Kilis','Kocaeli','Konya','Kütahya','Malatya','Manisa','Mardin','Mersin','Muğla','Muş','Nevşehir','Niğde','Ordu','Osmaniye','Rize','Sakarya','Samsun','Siirt','Sinop','Sivas','Şanlıurfa','Şırnak','Tekirdağ','Tokat','Trabzon','Tunceli','Uşak','Van','Yalova','Yozgat','Zonguldak'];
                    @endphp
                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(120px, 1fr)); gap:6px 12px; font-size:14px; color:var(--on-surface);">
                        @foreach ($iller as $il)
                            <span style="padding:6px 0;{{ $il === 'Bursa' ? 'font-weight:600; color:var(--primary);' : '' }}">
                                {{ $il }}{{ $il === 'Bursa' ? ' (Merkez)' : '' }}
                            </span>
                        @endforeach
                    </div>
                    <p style="margin-top:24px; font-size:14px; color:var(--gray-secondary); line-height:1.6;">Bulunduğunuz ilden bağımsız olarak teklif almak veya teknik görüş sormak için WhatsApp'tan iletişime geçebilirsiniz. Sondaj sektörü ekipmanı, wireline karotiyer, karot bit, kaya delgi ekipmanları, matkap, tij, pompa ve yedek parça ihtiyaçlarınızın hepsi için Türkiye geneli servis ağımız hizmetinizdedir.</p>
                </div>
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">HAZIR MISIN?</div>
                    <h2>Projenizi birlikte planlayalım.</h2>
                    <p>Operasyon bilgilerinizi paylaşın; teknik ekibimiz size en uygun ekipman ve hizmet paketini önersin.</p>
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
