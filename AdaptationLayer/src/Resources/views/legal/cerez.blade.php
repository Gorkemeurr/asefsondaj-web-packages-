{{-- Çerez Politikası — /cerez-politikasi --}}
@php $waLink = 'https://wa.me/905320542975'; @endphp

@push('meta')
    <meta name="title" content="Çerez Politikası — Asef Sondaj" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .lg-wrap { max-width: 780px; margin: 0 auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .lg-wrap { margin-bottom: 120px; } }
    .lg-wrap h2 { font-size: 24px; font-weight: 600; letter-spacing: -0.01em; color: var(--primary); margin: 40px 0 12px; }
    .lg-wrap h2:first-child { margin-top: 0; }
    .lg-wrap p { font-size: 16px; color: var(--on-surface); line-height: 1.7; margin-bottom: 14px; }
    .lg-wrap ul { padding-left: 20px; margin-bottom: 16px; }
    .lg-wrap li { font-size: 16px; color: var(--on-surface); line-height: 1.7; margin-bottom: 6px; }
    .lg-meta { font-size: 13px; color: var(--gray-secondary); padding: 20px 0; border-bottom: 1px solid var(--outline); margin-bottom: 32px; }
    .lg-table { width: 100%; border-collapse: collapse; margin: 16px 0 24px; font-size: 14px; }
    .lg-table th, .lg-table td { text-align: left; padding: 12px; border-bottom: 1px solid var(--outline); }
    .lg-table th { color: var(--gray-secondary); font-weight: 500; letter-spacing: 0.02em; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Çerez Politikası — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero" style="padding-bottom: 24px;">
                <div class="asef-label-caps">YASAL BİLGİ</div>
                <h1>Çerez Politikası.</h1>
                <p>Web sitemizde kullanılan çerezler ve amaçları.</p>
            </section>

            <section class="lg-wrap">
                <div class="lg-meta">Son güncelleme: {{ date('d.m.Y') }}</div>

                <h2>Çerez Nedir?</h2>
                <p>Çerezler, web sitesini ziyaret ettiğinizde tarayıcınıza gönderilen ve cihazınızda saklanan küçük metin dosyalarıdır. Web sitesinin doğru çalışmasını sağlamak ve deneyiminizi iyileştirmek için kullanılır.</p>

                <h2>Kullandığımız Çerezler</h2>
                <table class="lg-table">
                    <thead>
                        <tr><th>Tür</th><th>Amaç</th><th>Süre</th></tr>
                    </thead>
                    <tbody>
                        <tr><td>Zorunlu</td><td>Site fonksiyonları (dil, oturum)</td><td>Oturum</td></tr>
                        <tr><td>Fonksiyonel</td><td>Teklif sepeti (localStorage)</td><td>Kalıcı</td></tr>
                        <tr><td>Analitik</td><td>Ziyaret istatistikleri (anonim)</td><td>~1 yıl</td></tr>
                    </tbody>
                </table>

                <h2>Üçüncü Taraf Çerezler</h2>
                <p>Web sitemizde gömülü Google Maps gibi üçüncü taraf servisler kendi çerezlerini yerleştirebilir. Bu çerezler ilgili sağlayıcıların politikalarına tabidir.</p>

                <h2>Çerez Yönetimi</h2>
                <p>Çerezleri tarayıcınızın ayarlarından yönetebilir veya silebilirsiniz. Ancak zorunlu çerezleri devre dışı bırakırsanız site fonksiyonları düzgün çalışmayabilir.</p>

                <h2>Değişiklikler</h2>
                <p>Bu politika güncellenebilir. Değişiklikler bu sayfada yayınlanır.</p>

                <h2>İletişim</h2>
                <p>Sorularınız için: <a href="mailto:destek@asefsondaj.com" style="color:var(--link-blue);">destek@asefsondaj.com</a></p>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
