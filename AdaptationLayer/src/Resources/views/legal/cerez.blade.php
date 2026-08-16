@php
    $lpKind      = 'YASAL METİN';
    $lpTitle     = 'Çerez Politikası';
    $lpLede      = 'Web sitemizde ve mobil uygulamamızda kullanılan çerezler, hangi amaçla kullanıldıkları ve kontrol seçenekleri hakkında bilgi.';
    $lpUpdatedAt = '16 Ağustos 2026';

    $lpToc = [
        ['nedir',      'Çerez nedir?'],
        ['turler',     'Kullanılan çerez türleri'],
        ['amac',       'Kullanım amaçları'],
        ['ucuncu',     'Üçüncü taraf çerezleri'],
        ['kontrol',    'Çerez kontrolü'],
        ['tarayici',   'Tarayıcı ayarları'],
        ['degisiklik', 'Politika değişiklikleri'],
        ['iletisim',   'İletişim'],
    ];

    $lpSections = [
        ['nedir', 'Çerez nedir?', '
            <p><strong>Çerez (cookie)</strong>, ziyaret ettiğiniz web siteleri tarafından tarayıcınıza küçük bir metin dosyası olarak yerleştirilen veridir. Çerezler, siteyi bir sonraki ziyaretinizde sizi tanımak, tercihlerinizi hatırlamak ve deneyimi kişiselleştirmek amacıyla kullanılır.</p>
            <p>Bu politika 5809 sayılı <strong>Elektronik Haberleşme Kanunu</strong> ve 6698 sayılı <strong>Kişisel Verilerin Korunması Kanunu (KVKK)</strong> çerçevesinde hazırlanmıştır.</p>
        '],
        ['turler', 'Kullanılan çerez türleri', '
            <p>Sitemizde aşağıdaki çerez türleri kullanılmaktadır:</p>
            <table>
                <thead><tr><th>Tür</th><th>Kullanım</th><th>Süre</th></tr></thead>
                <tbody>
                    <tr><td><strong>Zorunlu</strong></td><td>Site fonksiyonlarını çalıştırır (oturum, güvenlik). Onay gerektirmez.</td><td>Oturum / 1 yıl</td></tr>
                    <tr><td><strong>İşlevsel</strong></td><td>Tercihlerinizi hatırlar (dil, teklif sepeti).</td><td>1 yıl</td></tr>
                    <tr><td><strong>Performans</strong></td><td>Kullanım istatistikleri toplar (sayfa süresi, tıklama).</td><td>2 yıl</td></tr>
                    <tr><td><strong>Pazarlama</strong></td><td>Kişiselleştirilmiş reklam ve içerik gösterir. <em>Sadece rızanız varsa aktifleşir.</em></td><td>2 yıl</td></tr>
                </tbody>
            </table>
        '],
        ['amac', 'Kullanım amaçları', '
            <p>Çerezleri aşağıdaki amaçlar için kullanırız:</p>
            <ul>
                <li><strong>Site fonksiyonelliği</strong>: Teklif sepetinin doğru çalışması, oturum yönetimi.</li>
                <li><strong>Kullanıcı deneyimi</strong>: Tercihlerinizi hatırlama, hızlı erişim.</li>
                <li><strong>Analitik</strong>: Site kullanım istatistiklerinin toplanması, iyileştirme çalışmaları.</li>
                <li><strong>Güvenlik</strong>: Yetkisiz erişim tespiti ve önlenmesi.</li>
            </ul>
        '],
        ['ucuncu', 'Üçüncü taraf çerezleri', '
            <p>Aşağıdaki üçüncü taraf servisleri de çerez kullanabilir:</p>
            <ul>
                <li><strong>Google Analytics</strong>: Kullanım istatistikleri (anonim). Anonim kimlik ve oturum verisi tutar.</li>
                <li><strong>Cloudflare</strong>: Güvenlik ve performans altyapısı (zorunlu).</li>
                <li><strong>Meta Pixel / Google Ads</strong>: Sadece pazarlama izniniz varsa aktifleşir.</li>
            </ul>
            <p>Bu servislerin kendi gizlilik politikaları vardır. Detaylar için ilgili sağlayıcının politikasına bakabilirsiniz.</p>
        '],
        ['kontrol', 'Çerez kontrolü', '
            <p>Sitemizi ilk ziyaretinizde çerez tercih paneli görürsünüz. Buradan:</p>
            <ul>
                <li>Zorunlu dışındaki tüm çerezleri <strong>reddedebilir</strong>,</li>
                <li>Kategori bazında (işlevsel / analitik / pazarlama) <strong>seçim yapabilir</strong>,</li>
                <li>Tercihlerinizi <strong>istediğiniz zaman değiştirebilirsiniz</strong>.</li>
            </ul>
        '],
        ['tarayici', 'Tarayıcı ayarları', '
            <p>Tarayıcınızın ayarlarından da çerezleri yönetebilirsiniz:</p>
            <ul>
                <li><strong>Chrome</strong>: Ayarlar → Gizlilik ve güvenlik → Çerezler</li>
                <li><strong>Safari</strong>: Tercihler → Gizlilik → Çerezleri ve web sitesi verilerini yönet</li>
                <li><strong>Firefox</strong>: Ayarlar → Gizlilik ve Güvenlik → Çerezler ve Site Verileri</li>
                <li><strong>Edge</strong>: Ayarlar → Çerezler ve site izinleri</li>
            </ul>
            <div class="lp-note">Tüm çerezleri devre dışı bırakırsanız site fonksiyonlarının bir kısmı çalışmayabilir (özellikle teklif sepeti).</div>
        '],
        ['degisiklik', 'Politika değişiklikleri', '
            <p>Kullanılan çerez türleri veya süreleri değiştikçe bu politika güncellenir. Değişiklikler bu sayfada yayınlanır.</p>
        '],
        ['iletisim', 'İletişim', '
            <p>Çerez uygulamalarımızla ilgili sorularınız için:</p>
            <ul>
                <li><strong>E-posta</strong>: <a href="mailto:destek@asefsondaj.com">destek@asefsondaj.com</a></li>
                <li><strong>Telefon</strong>: +90 532 054 29 75</li>
            </ul>
        '],
    ];
@endphp

@include('asef-adaptation::partials.legal-shell')
