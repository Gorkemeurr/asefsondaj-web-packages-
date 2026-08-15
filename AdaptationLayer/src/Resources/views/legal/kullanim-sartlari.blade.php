{{-- Kullanım Şartları — /kullanim-sartlari --}}
@php $waLink = 'https://wa.me/905320542975'; @endphp

@push('meta')
    <meta name="title" content="Kullanım Şartları — Asef Sondaj" />
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
    <x-slot:title>Kullanım Şartları — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero" style="padding-bottom: 24px;">
                <div class="asef-label-caps">YASAL BİLGİ</div>
                <h1>Kullanım Şartları.</h1>
                <p>Web sitesini kullanırken uygulanan kurallar ve sorumluluklar.</p>
            </section>

            <section class="lg-wrap">
                <div class="lg-meta">Son güncelleme: {{ date('d.m.Y') }}</div>

                <h2>1. Genel Hükümler</h2>
                <p>Bu web sitesini (asefsondaj.com) ziyaret ederek ve kullanarak aşağıdaki şartları kabul etmiş sayılırsınız. Şartları kabul etmiyorsanız siteyi kullanmayınız.</p>

                <h2>2. Site İçeriği</h2>
                <p>Web sitesindeki tüm içerik (metin, görsel, tasarım, logo, ürün fotoğrafları) Asef Sondaj'a aittir. İzinsiz kopyalama, çoğaltma veya ticari amaçla kullanım yasaktır.</p>

                <h2>3. Ürün Bilgileri</h2>
                <p>Web sitesindeki ürün bilgileri, teknik özellikler ve görseller bilgi amaçlıdır. Kesin ürün özellikleri ve fiyatlandırma için WhatsApp veya telefon yoluyla iletişime geçilmelidir. Ürün özelliklerinde ve stok durumunda değişiklik yapma hakkı saklıdır.</p>

                <h2>4. Teklif Sistemi</h2>
                <p>"Teklif Sepeti"ne eklenen ürünler bağlayıcı bir sipariş oluşturmaz. Nihai teklif, iletişime geçtikten sonra teknik ekibimizin değerlendirmesi sonrasında oluşturulur. Fiyat, teslim süresi ve ürün uygunluğu bu aşamada netleştirilir.</p>

                <h2>5. Kullanıcı Sorumlulukları</h2>
                <ul>
                    <li>Verdiği bilgilerin doğru ve güncel olmasından sorumludur.</li>
                    <li>Site içeriğini yasal amaçlar dışında kullanamaz.</li>
                    <li>Site güvenliğini tehdit edici davranışlarda bulunamaz.</li>
                </ul>

                <h2>6. Sorumluluk Sınırlandırması</h2>
                <p>Web sitesindeki bilgilerin kullanımından kaynaklanan doğrudan veya dolaylı zararlardan Asef Sondaj sorumlu tutulamaz. Site içeriği önceden haber verilmeksizin değiştirilebilir.</p>

                <h2>7. Değişiklikler</h2>
                <p>Bu kullanım şartları önceden haber verilmeksizin güncellenebilir. Değişiklikler bu sayfada yayınlandığı andan itibaren yürürlüğe girer.</p>

                <h2>8. Yetkili Mahkeme</h2>
                <p>İşbu şartlardan doğabilecek uyuşmazlıklarda Bursa Mahkemeleri ve İcra Daireleri yetkilidir.</p>

                <h2>9. İletişim</h2>
                <p>Sorularınız için: <a href="mailto:iletisim@asefsondaj.com" style="color:var(--link-blue);">iletisim@asefsondaj.com</a></p>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
