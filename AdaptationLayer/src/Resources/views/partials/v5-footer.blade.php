{{-- Shared v5 footer.
     Requires from parent scope: $catalogUrl, $waLink. --}}
<footer class="asef-footer">
    <div class="asef-container">
        <div class="asef-footer-grid">
            <div class="asef-footer-brand">
                <a href="{{ url('/') }}" class="asef-brand">Asef Sondaj</a>
                <p>20 yıllık saha tecrübesiyle sondaj ekipmanları, yedek parça ve teknik çözüm ortağınız.</p>
            </div>
            <div class="asef-footer-col">
                <h4>Kurumsal</h4>
                <ul>
                    <li><a href="{{ url('/') }}#hakkimizda">Hakkımızda</a></li>
                    <li><a href="#">Sondaj Makinalarımız</a></li>
                    <li><a href="{{ url('/') }}#hizmetler">Hizmetlerimiz</a></li>
                    <li><a href="#">Referanslar</a></li>
                    <li><a href="#">SSS</a></li>
                </ul>
            </div>
            <div class="asef-footer-col">
                <h4>Katalog</h4>
                <ul>
                    <li><a href="{{ $catalogUrl }}">Ürünler</a></li>
                    <li><a href="{{ $catalogUrl }}?cat=delici">Delici Ekipmanlar</a></li>
                    <li><a href="{{ $catalogUrl }}?cat=tij">Tij ve Borular</a></li>
                    <li><a href="{{ $catalogUrl }}?cat=pompa">Pompa Sistemleri</a></li>
                    <li><a href="{{ $catalogUrl }}">Teklif Sepetim</a></li>
                </ul>
            </div>
            <div class="asef-footer-col">
                <h4>İletişim</h4>
                <ul>
                    <li><a href="{{ $waLink }}" target="_blank" rel="noopener">+90 532 054 29 75</a></li>
                    <li><a href="mailto:iletisim@asefsondaj.com">iletisim@asefsondaj.com</a></li>
                    <li><a href="mailto:destek@asefsondaj.com">destek@asefsondaj.com</a></li>
                    <li>Duaçınarı Mah. 1. Özgünay Sk<br>No:10, Yıldırım / Bursa</li>
                </ul>
            </div>
        </div>
        <div class="asef-footer-bottom">
            <div>© {{ date('Y') }} Asef Sondaj — Tüm hakları saklıdır.</div>
            <div class="asef-footer-legal">
                <a href="#">KVKK</a>
                <a href="#">Gizlilik</a>
                <a href="#">Çerez</a>
                <a href="#">Kullanım Şartları</a>
            </div>
        </div>
    </div>
</footer>
