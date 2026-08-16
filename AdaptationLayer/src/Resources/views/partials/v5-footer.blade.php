{{-- Shared v5 footer — premium, tüm sayfalarla dolu + sosyal iconlar.
     Requires from parent scope: $catalogUrl, $waLink.
     Cache-buster: 20260816-social-icons-v2 --}}
@php
    $footAnaAll = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::orderBy('sort')->limit(8)->get();
@endphp
<footer class="asef-footer">
    <div class="asef-container">
        <div class="asef-footer-grid">
            {{-- MARKA BLOK --}}
            <div class="asef-footer-brand">
                <a href="{{ url('/') }}" class="asef-brand">Asef Sondaj</a>
                <p>20 yıllık saha tecrübesiyle Türkiye'nin dört bir yanındaki sondaj operasyonlarına ekipman, yedek parça ve teknik danışmanlık.</p>
                <div class="asef-footer-social" style="display:flex; gap:10px; margin-top:20px;">
                    <a href="https://instagram.com/asefsondajj" target="_blank" rel="noopener" aria-label="Instagram"
                       style="width:36px;height:36px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;background:#F5F5F7;color:#1a1c1d;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 1.17.05 1.8.25 2.23.41.56.22.96.48 1.38.9.42.42.68.82.9 1.38.16.42.36 1.06.41 2.23.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.05 1.17-.25 1.8-.41 2.23-.22.56-.48.96-.9 1.38-.42.42-.82.68-1.38.9-.42.16-1.06.36-2.23.41-1.27.06-1.64.07-4.85.07-3.2 0-3.58-.01-4.85-.07-1.17-.05-1.8-.25-2.23-.41a3.71 3.71 0 0 1-1.38-.9 3.7 3.7 0 0 1-.9-1.38c-.16-.42-.36-1.06-.41-2.23-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.05-1.17.25-1.8.41-2.23.22-.56.48-.96.9-1.38a3.7 3.7 0 0 1 1.38-.9c.42-.16 1.06-.36 2.23-.41 1.27-.06 1.65-.07 4.85-.07M12 0C8.74 0 8.33.01 7.05.07 5.78.13 4.9.33 4.14.63a5.87 5.87 0 0 0-2.13 1.38A5.87 5.87 0 0 0 .63 4.14c-.3.76-.5 1.64-.56 2.91C.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.06 1.27.26 2.15.56 2.91a5.87 5.87 0 0 0 1.38 2.13 5.87 5.87 0 0 0 2.13 1.38c.76.3 1.64.5 2.91.56 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c1.27-.06 2.15-.26 2.91-.56a5.87 5.87 0 0 0 2.13-1.38 5.87 5.87 0 0 0 1.38-2.13c.3-.76.5-1.64.56-2.91.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.06-1.27-.26-2.15-.56-2.91a5.87 5.87 0 0 0-1.38-2.13A5.87 5.87 0 0 0 19.86.63c-.76-.3-1.64-.5-2.91-.56C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 1 0 0 12.32 6.16 6.16 0 0 0 0-12.32zm0 10.16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm7.85-10.4a1.44 1.44 0 1 1-2.88 0 1.44 1.44 0 0 1 2.88 0z"/></svg>
                    </a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" aria-label="WhatsApp"
                       style="width:36px;height:36px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;background:#F5F5F7;color:#1a1c1d;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347M12.05 21.785h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413"/></svg>
                    </a>
                    <a href="tel:+905320542975" aria-label="Telefon"
                       style="width:36px;height:36px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;background:#F5F5F7;color:#1a1c1d;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </a>
                    <a href="mailto:iletisim@asefsondaj.com" aria-label="E-posta"
                       style="width:36px;height:36px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;background:#F5F5F7;color:#1a1c1d;">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg>
                    </a>
                </div>
            </div>

            {{-- ÜRÜNLER --}}
            <div class="asef-footer-col">
                <h4>Ürün Grupları</h4>
                <ul>
                    <li><a href="{{ $catalogUrl }}">Tüm Ürünler</a></li>
                    @foreach ($footAnaAll->take(6) as $_a)
                        <li><a href="{{ $catalogUrl }}?ana={{ $_a->code }}">{{ $_a->name }}</a></li>
                    @endforeach
                    <li><a href="{{ url('sepet') }}">Teklif Sepetim</a></li>
                </ul>
            </div>

            {{-- KURUMSAL --}}
            <div class="asef-footer-col">
                <h4>Kurumsal</h4>
                <ul>
                    <li><a href="{{ url('kurumsal') }}">Kurumsal Hakkında</a></li>
                    <li><a href="{{ url('hakkimizda') }}">Hakkımızda</a></li>
                    <li><a href="{{ url('sondaj-makinalarimiz') }}">Sondaj Makinalarımız</a></li>
                    <li><a href="{{ url('hizmetlerimiz') }}">Hizmetlerimiz</a></li>
                    <li><a href="{{ url('referanslar') }}">Referanslar</a></li>
                </ul>
            </div>

            {{-- BLOG & KAYNAK --}}
            <div class="asef-footer-col">
                <h4>Blog & Kaynak</h4>
                <ul>
                    <li><a href="{{ url('blog') }}">Blog Ana Sayfa</a></li>
                    <li><a href="{{ url('tum-bloglar') }}">Tüm Yazılar</a></li>
                    <li><a href="{{ url('sondaj-sozlugu') }}">Sondaj Sözlüğü</a></li>
                    <li><a href="{{ url('blog/fotograf') }}">Fotoğraf Galerisi</a></li>
                    <li><a href="{{ url('blog/video') }}">Video Galerisi</a></li>
                    <li><a href="{{ url('sss') }}">Sık Sorulan Sorular</a></li>
                </ul>
            </div>

            {{-- DESTEK + İLETİŞİM --}}
            <div class="asef-footer-col">
                <h4>Destek & İletişim</h4>
                <ul>
                    <li><a href="{{ url('iletisim') }}">İletişim</a></li>
                    <li><a href="{{ url('destek') }}">Destek Merkezi</a></li>
                    <li><a href="{{ $waLink }}" target="_blank" rel="noopener">+90 532 054 29 75</a></li>
                    <li><a href="mailto:iletisim@asefsondaj.com">iletisim@asefsondaj.com</a></li>
                    <li><a href="mailto:destek@asefsondaj.com">destek@asefsondaj.com</a></li>
                    <li style="color: var(--gray-secondary); line-height: 1.5; margin-top: 6px;">Duaçınarı Mah. 1. Özgünay Sk<br>No:10, Yıldırım / Bursa</li>
                </ul>
            </div>
        </div>

        <div class="asef-footer-bottom">
            <div>© {{ date('Y') }} Asef Sondaj — Tüm hakları saklıdır. <span style="color: var(--gray-secondary); margin-left: 8px;">Bursa, Türkiye</span></div>
            <div class="asef-footer-legal">
                <a href="{{ url('kvkk') }}">KVKK</a>
                <a href="{{ url('gizlilik-politikasi') }}">Gizlilik Politikası</a>
                <a href="{{ url('cerez-politikasi') }}">Çerez Politikası</a>
                <a href="{{ url('kullanim-sartlari') }}">Kullanım Şartları</a>
            </div>
        </div>
    </div>
</footer>
