{{-- KVKK Aydınlatma Metni — /kvkk --}}
@php
    $waLink = asef_wa_link('Merhaba, KVKK ile ilgili başvuruda bulunmak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));
@endphp

@push('meta')
    <meta name="title" content="KVKK Aydınlatma Metni — Asef Sondaj" />
    <meta name="description" content="6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında aydınlatma metni." />
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
    <x-slot:title>KVKK Aydınlatma Metni — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero" style="padding-bottom: 24px;">
                <div class="asef-label-caps">YASAL BİLGİ</div>
                <h1>KVKK Aydınlatma Metni.</h1>
                <p>6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında hazırlanmıştır.</p>
            </section>

            <section class="lg-wrap">
                <div class="lg-meta">Son güncelleme: {{ date('d.m.Y') }}</div>

                <h2>1. Veri Sorumlusu</h2>
                <p>Asef Sondaj (bundan sonra "Asef Sondaj") olarak veri sorumlusu sıfatıyla, kişisel verilerinizin güvenliği ve gizliliğine büyük önem veriyoruz. İşbu aydınlatma metni, 6698 sayılı Kişisel Verilerin Korunması Kanunu ("KVKK") kapsamında hazırlanmıştır.</p>

                <h2>2. İşlenen Kişisel Veriler</h2>
                <p>Web sitemizi ziyaret ettiğinizde veya bizimle iletişime geçtiğinizde şu veriler işlenebilir:</p>
                <ul>
                    <li>Kimlik bilgileri (ad, soyad)</li>
                    <li>İletişim bilgileri (telefon, e-posta, adres)</li>
                    <li>İşlem bilgileri (teklif talebi, sipariş geçmişi)</li>
                    <li>Trafik bilgileri (IP, tarayıcı, ziyaret zamanı)</li>
                </ul>

                <h2>3. İşleme Amaçları</h2>
                <p>Kişisel verileriniz aşağıdaki amaçlarla işlenmektedir:</p>
                <ul>
                    <li>Teklif ve sipariş süreçlerinin yönetilmesi</li>
                    <li>Ürün ve hizmetlerin sunulması</li>
                    <li>Teknik destek ve müşteri hizmetleri</li>
                    <li>Yasal yükümlülüklerin yerine getirilmesi</li>
                    <li>İletişim ve bilgilendirme faaliyetleri</li>
                </ul>

                <h2>4. Hukuki Sebep</h2>
                <p>Kişisel verileriniz, KVKK'nın 5. ve 6. maddelerinde belirtilen hukuki sebepler çerçevesinde; sözleşmenin kurulması, hukuki yükümlülüğün yerine getirilmesi ve meşru menfaat gerekçeleriyle işlenmektedir.</p>

                <h2>5. Veri Aktarımı</h2>
                <p>Kişisel verileriniz, hizmet sunumu ve yasal yükümlülükler kapsamında; kargo firmaları, ödeme sistemleri, muhasebe hizmet sağlayıcıları ve yetkili kamu kurumlarıyla paylaşılabilir. Yurt dışına veri aktarımı yapılmamaktadır.</p>

                <h2>6. Haklarınız</h2>
                <p>KVKK'nın 11. maddesi kapsamında; kişisel verilerinizin işlenip işlenmediğini öğrenme, işlenmişse bilgi talep etme, düzeltme, silme, aktarıma itiraz etme haklarına sahipsiniz.</p>

                <h2>7. Başvuru</h2>
                <p>Haklarınızı kullanmak için başvurunuzu <a href="mailto:destek@asefsondaj.com" style="color:var(--link-blue);">destek@asefsondaj.com</a> adresine iletebilir veya Duaçınarı Mah. 1. Özgünay Sk No:10, Yıldırım/Bursa adresine yazılı olarak gönderebilirsiniz.</p>
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">SORULARINIZ</div>
                    <h2>KVKK ile ilgili başvuru mu var?</h2>
                    <p>Kişisel veri talepleriniz için doğrudan iletişim kanallarımızı kullanabilirsiniz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="mailto:destek@asefsondaj.com" class="asef-cta-pill primary">E-posta Gönder</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">WhatsApp'tan Yaz</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
