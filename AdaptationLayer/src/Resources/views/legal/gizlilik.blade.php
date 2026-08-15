{{-- Gizlilik Politikası — /gizlilik-politikasi --}}
@php
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, gizlilik politikanız hakkında bilgi almak istiyorum.');
@endphp

@push('meta')
    <meta name="title" content="Gizlilik Politikası — Asef Sondaj" />
    <meta name="description" content="Asef Sondaj web sitesi gizlilik politikası." />
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
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Gizlilik Politikası — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero" style="padding-bottom: 24px;">
                <div class="asef-label-caps">YASAL BİLGİ</div>
                <h1>Gizlilik Politikası.</h1>
                <p>Kişisel verilerinizi nasıl işlediğimizin ve koruduğumuzun özeti.</p>
            </section>

            <section class="lg-wrap">
                <div class="lg-meta">Son güncelleme: {{ date('d.m.Y') }}</div>

                <h2>Giriş</h2>
                <p>Asef Sondaj olarak ziyaretçilerimizin gizliliğine önem veriyoruz. Bu politika, web sitemizi kullandığınızda hangi bilgileri topladığımızı ve bu bilgileri nasıl kullandığımızı açıklar.</p>

                <h2>Topladığımız Bilgiler</h2>
                <ul>
                    <li>Siz bize gönüllü olarak sağladığınızda: ad, e-posta, telefon, mesaj içeriği.</li>
                    <li>Otomatik olarak: IP adresi, tarayıcı tipi, ziyaret zamanı, kaynak sayfa.</li>
                    <li>Yerel olarak: teklif sepetiniz cihazınızda saklanır (localStorage), bize gönderilmez.</li>
                </ul>

                <h2>Bilgilerin Kullanımı</h2>
                <ul>
                    <li>Teklif ve sipariş taleplerini karşılamak.</li>
                    <li>Sizinle iletişim kurmak ve teknik destek sağlamak.</li>
                    <li>Web sitesi performansını ve kullanıcı deneyimini iyileştirmek.</li>
                    <li>Yasal yükümlülükleri yerine getirmek.</li>
                </ul>

                <h2>Bilgi Güvenliği</h2>
                <p>Bilgileriniz endüstri standardı güvenlik önlemleriyle korunur. Yalnızca yetkili personel ve iş ortaklarımız (kargo, muhasebe vb.) hizmet ifası için gerekli bilgilere erişebilir.</p>

                <h2>Üçüncü Taraflarla Paylaşım</h2>
                <p>Kişisel verileriniz izniniz olmadan üçüncü taraflarla ticari amaçla paylaşılmaz. Yasal zorunluluk halinde yetkili kurumlarla paylaşılabilir.</p>

                <h2>Çerezler</h2>
                <p>Web sitemiz temel işlevler için çerezler kullanır. Detaylı bilgi için <a href="{{ route('shop.asef.cookies') }}" style="color:var(--link-blue);">Çerez Politikası</a> sayfamıza göz atabilirsiniz.</p>

                <h2>Politika Değişiklikleri</h2>
                <p>Bu politikada değişiklik yapma hakkımızı saklı tutarız. Güncellemeler bu sayfada yayınlanır.</p>

                <h2>İletişim</h2>
                <p>Gizlilik ile ilgili soru veya talepleriniz için: <a href="mailto:destek@asefsondaj.com" style="color:var(--link-blue);">destek@asefsondaj.com</a></p>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
