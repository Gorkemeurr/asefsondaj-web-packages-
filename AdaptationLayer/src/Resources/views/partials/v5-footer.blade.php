{{-- Shared v5 footer.
     Requires from parent scope: $catalogUrl, $waLink. --}}
<footer class="asef-footer">
    <div class="asef-container">
        <div class="asef-footer-grid">
            <div class="asef-footer-brand">
                <a href="{{ url('/') }}" class="asef-brand" aria-label="Asef Sondaj ana sayfa">
                    <span class="asef-brand-mark" aria-hidden="true">
                        <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path d="M50 8 L95 92 L74 92 L64 71 L36 71 L26 92 L5 92 Z M44 55 L56 55 L50 41 Z"/></svg>
                    </span>
                    <span class="asef-brand-text">Asef Sondaj</span>
                </a>
                <p>20 yıllık saha tecrübesiyle sondaj ekipmanları, yedek parça ve teknik çözüm ortağınız.</p>
            </div>
            <div class="asef-footer-col">
                <h4>Kurumsal</h4>
                <ul>
                    <li><a href="{{ url('hakkimizda') }}">Hakkımızda</a></li>
                    <li><a href="{{ url('sondaj-makinalarimiz') }}">Sondaj Makinalarımız</a></li>
                    <li><a href="{{ url('hizmetlerimiz') }}">Hizmetlerimiz</a></li>
                    <li><a href="{{ url('referanslar') }}">Referanslar</a></li>
                    <li><a href="{{ url('sss') }}">SSS</a></li>
                </ul>
            </div>
            <div class="asef-footer-col">
                <h4>Katalog</h4>
                <ul>
                    <li><a href="{{ $catalogUrl }}">Ürünler</a></li>
                    @php
                        $footPartAna = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::orderBy('sort')->limit(3)->get();
                    @endphp
                    @foreach ($footPartAna as $_fpa)
                        <li><a href="{{ $catalogUrl }}?ana={{ $_fpa->code }}">{{ $_fpa->name }}</a></li>
                    @endforeach
                    <li><a href="{{ url('sepet') }}">Teklif Sepetim</a></li>
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
                <a href="{{ url('kvkk') }}">KVKK</a>
                <a href="{{ url('gizlilik-politikasi') }}">Gizlilik</a>
                <a href="{{ url('cerez-politikasi') }}">Çerez</a>
                <a href="{{ url('kullanim-sartlari') }}">Kullanım Şartları</a>
            </div>
        </div>
    </div>
</footer>
