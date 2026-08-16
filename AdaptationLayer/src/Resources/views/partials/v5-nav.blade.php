{{-- Shared v5 nav (Apple-esque, mega menu Ürünler + Kurumsal).
     Requires from parent scope: $catalogUrl, $waLink. --}}
<nav class="asef-nav" aria-label="Ana gezinme">
    <div class="asef-nav-inner">
        <a href="{{ url('/') }}" class="asef-brand">Asef Sondaj</a>
        <div class="asef-nav-menu">
            <div class="asef-nav-item">
                <a href="{{ $catalogUrl }}">Ürünler</a>
                <div class="asef-mega" role="menu" aria-label="Ürünler menüsü">
                    <div class="asef-mega-grid">
                        <div class="asef-mega-col asef-mega-main">
                            <h5>Ürün Gruplarını Keşfedin</h5>
                            <a href="{{ $catalogUrl }}">Tüm Ürünler</a>
                            @php
                                $navAna = \AsefSondaj\AdaptationLayer\Models\AsefAnaKategori::orderBy('sort')->limit(6)->get();
                            @endphp
                            @foreach ($navAna as $_ak)
                                <a href="{{ $_ak->slug ? url('urunler/' . $_ak->slug) : $catalogUrl . '?ana=' . $_ak->code }}">{{ $_ak->name }}</a>
                            @endforeach
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Hızlı Bağlantılar</h5>
                            <a href="{{ $catalogUrl }}">Ürün Arama</a>
                            <a href="{{ url('sepet') }}">Teklif Sepetim</a>
                            <a href="{{ $waLink }}" target="_blank" rel="noopener">WhatsApp'tan Yaz</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Popüler Ürünler</h5>
                            @php
                                $navPopular = \AsefSondaj\AdaptationLayer\Models\AsefProduct::query()
                                    ->where('is_active', true)
                                    ->whereIn('sku', ['AS-DTH-001','AS-EMB-001','AS-KRT-001','AS-TRC-001'])
                                    ->get()->keyBy('sku');
                                foreach (['AS-DTH-001','AS-EMB-001','AS-KRT-001','AS-TRC-001'] as $_sku) {
                                    if (! isset($navPopular[$_sku])) continue;
                                    $_p = $navPopular[$_sku];
                                    echo '<a href="'.route('shop.asef.product', ['sku' => $_p->sku]).'">'.e($_p->name).'</a>';
                                }
                            @endphp
                        </div>
                    </div>
                </div>
            </div>
            <div class="asef-nav-item">
                <a href="{{ url('kurumsal') }}">Kurumsal</a>
                <div class="asef-mega" role="menu" aria-label="Kurumsal menüsü">
                    <div class="asef-mega-grid">
                        <div class="asef-mega-col asef-mega-main">
                            <h5>Kurumsalı Keşfedin</h5>
                            <a href="{{ url('hakkimizda') }}">Hakkımızda</a>
                            <a href="{{ url('sondaj-makinalarimiz') }}">Sondaj Makinalarımız</a>
                            <a href="{{ url('hizmetlerimiz') }}">Hizmetlerimiz</a>
                            <a href="{{ url('referanslar') }}">Referanslar</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Hızlı Bağlantılar</h5>
                            <a href="{{ url('iletisim') }}">İletişim</a>
                            <a href="{{ $waLink }}" target="_blank" rel="noopener">WhatsApp'a Yaz</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Daha Fazla</h5>
                            <a href="{{ url('blog') }}">Blog</a>
                            <a href="{{ url('destek') }}">Destek</a>
                            <a href="tel:+905320542975">Hemen Ara</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="asef-nav-item">
                <a href="{{ url('blog') }}">Blog</a>
                <div class="asef-mega" role="menu" aria-label="Blog menüsü">
                    <div class="asef-mega-grid">
                        <div class="asef-mega-col asef-mega-main">
                            <h5>Blog'u Keşfedin</h5>
                            <a href="{{ url('tum-bloglar') }}">Tüm Bloglar</a>
                            <a href="{{ url('blog/fotograf') }}">Fotoğraf Galerisi</a>
                            <a href="{{ url('blog/video') }}">Video Galerisi</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Fotoğraf Galerisi</h5>
                            <a href="{{ url('blog/saha-fotograflari') }}">Saha Fotoğrafları</a>
                            <a href="{{ url('blog/ekipman-fotograflari') }}">Ekipman Fotoğrafları</a>
                            <a href="{{ url('blog/proje-fotograflari') }}">Proje Fotoğrafları</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Video Galerisi</h5>
                            <a href="{{ url('blog/urun-tanitim-videolari') }}">Ürün Tanıtım Videoları</a>
                            <a href="{{ url('blog/saha-uygulamalari') }}">Saha Uygulamaları</a>
                            <a href="{{ url('blog/teknik-anlatimlar') }}">Teknik Anlatımlar</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="asef-nav-item">
                <a href="{{ url('destek') }}">Destek</a>
                <div class="asef-mega" role="menu" aria-label="Destek menüsü">
                    <div class="asef-mega-grid">
                        <div class="asef-mega-col asef-mega-main">
                            <h5>Destek Merkezi</h5>
                            <a href="{{ url('iletisim') }}">İletişim</a>
                            <a href="{{ url('sss') }}">SSS</a>
                            <a href="{{ url('kvkk') }}">KVKK Aydınlatma Metni</a>
                            <a href="{{ url('gizlilik-politikasi') }}">Gizlilik Politikası</a>
                            <a href="{{ url('cerez-politikasi') }}">Çerez Politikası</a>
                            <a href="{{ url('kullanim-sartlari') }}">Kullanım Şartları</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>İletişim Kanalları</h5>
                            <a href="{{ $waLink }}" target="_blank" rel="noopener">WhatsApp'a Yaz</a>
                            <a href="tel:+905320542975">+90 532 054 29 75</a>
                            <a href="mailto:iletisim@asefsondaj.com">iletisim@asefsondaj.com</a>
                            <a href="mailto:destek@asefsondaj.com">destek@asefsondaj.com</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Yasal Bağlantılar</h5>
                            <a href="{{ url('kvkk') }}">KVKK Aydınlatma</a>
                            <a href="{{ url('cerez-politikasi') }}">Çerez Ayarları</a>
                            <a href="{{ url('gizlilik-politikasi') }}">Veri İşleme Politikası</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="asef-nav-actions" style="display:flex !important; align-items:center; gap:2px;">
            <a href="{{ $catalogUrl }}" class="asef-nav-icon-btn" aria-label="Arama"
               style="display:inline-flex !important; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; color:#1a1c1d; text-decoration:none;">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            </a>
            <a href="{{ url('sepet') }}" class="asef-nav-icon-btn" aria-label="Teklif Sepetim"
               style="display:inline-flex !important; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; color:#1a1c1d; text-decoration:none; position:relative;">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="asef-badge" data-asef-cart-badge style="display: none;"></span>
            </a>
            {{-- Desktop only — mobile'de JS + media query ile gizli --}}
            <a href="{{ $waLink }}" class="asef-nav-cta asef-desktop-only" target="_blank" rel="noopener"
               id="asefNavContact"
               style="background:#0066CC !important; color:#FFFFFF !important; text-decoration:none !important;">
                <span style="color:#FFFFFF !important; -webkit-text-fill-color:#FFFFFF !important;">İletişim</span>
            </a>
            <script>
            (function () {
                function hideOnMobile() {
                    var el = document.getElementById('asefNavContact');
                    if (!el) return;
                    if (window.innerWidth < 900) {
                        el.style.setProperty('display', 'none', 'important');
                    } else {
                        el.style.setProperty('display', 'inline-flex', 'important');
                    }
                }
                if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', hideOnMobile); }
                else { hideOnMobile(); }
                window.addEventListener('resize', hideOnMobile);
            })();
            </script>
            <script>
            (function () {
                function forceWhite() {
                    document.querySelectorAll('.asef-nav-cta').forEach(function (a) {
                        a.style.setProperty('color', '#FFFFFF', 'important');
                        a.style.setProperty('background', '#0066CC', 'important');
                        a.querySelectorAll('*').forEach(function (el) {
                            el.style.setProperty('color', '#FFFFFF', 'important');
                        });
                    });
                }
                if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', forceWhite); }
                else { forceWhite(); }
                setTimeout(forceWhite, 300);
                setTimeout(forceWhite, 1000);
            })();
            </script>
            <button type="button" class="asef-nav-mobile-btn" aria-label="Menü" data-asef-mobile-toggle
                    style="margin-left:2px;">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
            </button>
        </div>
    </div>
</nav>

{{-- Force fresh reload — deploy version bump ile tarayıcı cache'i bir kez bypass --}}
<script>
(function () {
    var VERSION = '20260816t-desktop-nav-fix';
    try {
        if (window.sessionStorage && sessionStorage.getItem('asef_ver') !== VERSION) {
            sessionStorage.setItem('asef_ver', VERSION);
            if (!window.location.href.match(/[?&]_asef=\d/)) {
                window.location.href = window.location.href +
                    (window.location.href.indexOf('?') > -1 ? '&' : '?') +
                    '_asef=' + Date.now();
                return;
            }
        }
        // Sayfa yüklendiyse ve URL'de ?_asef= varsa temizle (kullanıcıya gösterilmesin).
        if (window.location.search && /[?&]_asef=\d+/.test(window.location.search) && window.history && window.history.replaceState) {
            var clean = window.location.pathname
                + window.location.search.replace(/([?&])_asef=\d+/, '$1').replace(/[?&]$/, '').replace(/\?&/, '?')
                + window.location.hash;
            window.history.replaceState({}, '', clean);
        }
    } catch (e) {}
})();
</script>

{{-- Nav + Drawer için inline CSS — v5-styles cache sorunu için garanti fallback --}}
<style>
    /* Nav actions — desktop: doğal akışta sağda (nav-menu flex:1 zaten iter), mobile: margin-left:auto ile sağa iter */
    .asef-nav-actions {
        display: flex !important;
        align-items: center;
        gap: 2px;
    }
    @media (min-width: 900px) { .asef-nav-actions { gap: 8px; } }
    @media (max-width: 899px) {
        .asef-nav-actions { margin-left: auto !important; }
    }
    /* İletişim CTA mobil'de gizli, masaüstünde görünür */
    .asef-nav-cta { display: none !important; }
    @media (min-width: 900px) { .asef-nav-cta { display: inline-flex !important; } }
    /* Nav icon butonları (arama, sepet) HER BOYUT'ta görünür */
    .asef-nav-icon-btn {
        display: inline-flex !important; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px;
        color: #1a1c1d; position: relative;
        text-decoration: none;
    }
    .asef-nav-icon-btn:hover { background: #F5F5F7; }
    /* Nav sticky + üstte kalsın */
    .asef-nav { position: sticky !important; top: 0; z-index: 100; background: rgba(255,255,255,0.95); backdrop-filter: blur(12px); border-bottom: 1px solid #E5E5EA; }
    .asef-nav-inner { display: flex; align-items: center; justify-content: space-between; max-width: 1440px; margin: 0 auto; padding: 12px 20px; gap: 12px; }
    /* Menu mobile'de gizli, masaüstünde flex — ORTALANMIŞ */
    .asef-nav-menu { display: none; }
    @media (min-width: 900px) {
        .asef-nav-menu {
            display: flex !important;
            flex: 1 1 auto;
            align-items: center;
            justify-content: center;
            gap: 32px;
        }
    }
    /* Hamburger sadece mobile'de */
    .asef-nav-mobile-btn { display: grid !important; place-items: center; width: 36px; height: 36px; background: transparent; border: 0; cursor: pointer; color: #1a1c1d; border-radius: 8px; }
    .asef-nav-mobile-btn:hover { background: #F5F5F7; }
    @media (min-width: 900px) { .asef-nav-mobile-btn { display: none !important; } }

</style>
<style>
    .asef-mobile-drawer {
        position: fixed !important; inset: 0 !important; z-index: 10000 !important;
        display: none !important;
        background: rgba(15,17,20,0.5); backdrop-filter: blur(6px);
        justify-content: flex-end;
    }
    .asef-mobile-drawer.on { display: flex !important; }
    .asef-mobile-drawer-panel {
        width: min(340px, 88vw); height: 100%; background: #FFFFFF;
        display: flex; flex-direction: column;
        box-shadow: -20px 0 60px rgba(0,0,0,0.24);
    }
    .asef-mobile-drawer-head {
        display: flex; justify-content: space-between; align-items: center;
        padding: 20px 22px; border-bottom: 1px solid #E5E5EA;
        font-size: 15px; font-weight: 600; color: #1a1c1d;
    }
    .asef-mobile-drawer-close {
        width: 34px; height: 34px; border-radius: 50%;
        background: #F5F5F7; border: 0; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        color: #1a1c1d;
    }
    .asef-mobile-drawer-nav {
        flex: 1; overflow-y: auto; padding: 12px 8px;
        display: flex; flex-direction: column;
    }
    .asef-mobile-drawer-nav a {
        padding: 12px 16px; font-size: 15px; font-weight: 500;
        color: #1a1c1d; border-radius: 8px;
        text-decoration: none !important;
    }
    .asef-mobile-drawer-nav a:hover { background: #F5F5F7; }
    .asef-mobile-drawer-nav a.sub {
        font-size: 13px; font-weight: 400; color: #5f5e60;
        padding: 8px 16px 8px 30px;
    }
    .asef-mobile-drawer-cta { padding: 16px; border-top: 1px solid #E5E5EA; }
    .asef-mobile-drawer-wa {
        display: flex; align-items: center; justify-content: center; gap: 10px;
        background: #25D366; color: #FFFFFF !important;
        padding: 14px 20px; border-radius: 12px;
        font-size: 14px; font-weight: 600;
        text-decoration: none;
    }
    .asef-mobile-drawer-wa:hover { background: #1EAF54; }
</style>

{{-- MOBILE DRAWER — Apple tarzı fullscreen menü (beyaz zemin, büyük font).
     TÜM style INLINE — CSS parse bug'a karşı bulletproof. --}}
<div id="asefMobileDrawer" role="dialog" aria-modal="true" aria-label="Menü"
     style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; z-index:10000; background:#FFFFFF; flex-direction:column; overflow-y:auto;">
    <div style="display:flex; justify-content:flex-end; align-items:center; padding:16px 20px; border-bottom:1px solid #EBEBEB;">
        <button type="button" data-asef-mobile-close aria-label="Kapat"
                style="width:44px; height:44px; border:0; background:transparent; cursor:pointer; color:#1a1c1d; display:inline-flex; align-items:center; justify-content:center;">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><line x1="6" y1="6" x2="18" y2="18"/><line x1="6" y1="18" x2="18" y2="6"/></svg>
        </button>
    </div>
    <nav style="flex:1; padding:24px 32px 40px 32px; display:flex; flex-direction:column; gap:4px;">
        <a href="{{ $catalogUrl }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Ürünler</a>
        <a href="{{ url('kurumsal') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Kurumsal</a>
        <a href="{{ url('sondaj-makinalarimiz') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Sondaj Makinaları</a>
        <a href="{{ url('hizmetlerimiz') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Hizmetler</a>
        <a href="{{ url('referanslar') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Referanslar</a>
        <a href="{{ url('blog') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Blog</a>
        <a href="{{ url('destek') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Destek</a>
        <a href="{{ url('iletisim') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">İletişim</a>
        <a href="{{ url('hakkimizda') }}" style="font-size:28px; font-weight:600; color:#1a1c1d; text-decoration:none; padding:12px 0; letter-spacing:-0.01em;">Hakkımızda</a>
    </nav>
    <div style="padding:20px 32px 40px 32px; border-top:1px solid #EBEBEB;">
        <a href="{{ $waLink }}" target="_blank" rel="noopener"
           style="display:flex; align-items:center; justify-content:center; gap:10px; background:#25D366; color:#FFFFFF !important; padding:16px 24px; border-radius:14px; font-size:16px; font-weight:600; text-decoration:none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#FFFFFF"><path d="M20.52 3.48A11.86 11.86 0 0 0 12.06 0C5.5 0 .16 5.34.16 11.9c0 2.1.55 4.13 1.6 5.93L0 24l6.34-1.67a11.87 11.87 0 0 0 5.72 1.46h.01c6.56 0 11.9-5.34 11.9-11.9 0-3.18-1.24-6.17-3.45-8.41z"/></svg>
            WhatsApp'tan Yaz
        </a>
    </div>
</div>
<script>
(function () {
    function bindMobileNav() {
        var drawer = document.getElementById('asefMobileDrawer');
        if (!drawer || drawer._asefBound) return;
        drawer._asefBound = true;
        function open()  {
            drawer.style.setProperty('display', 'flex', 'important');
            document.body.style.overflow = 'hidden';
            document.documentElement.style.overflow = 'hidden';
        }
        function close() {
            drawer.style.setProperty('display', 'none', 'important');
            document.body.style.overflow = '';
            document.documentElement.style.overflow = '';
        }
        document.querySelectorAll('[data-asef-mobile-toggle]').forEach(function (b) {
            b.addEventListener('click', function (e) { e.preventDefault(); e.stopPropagation(); open(); });
        });
        drawer.querySelectorAll('[data-asef-mobile-close]').forEach(function (b) {
            b.addEventListener('click', function (e) { e.preventDefault(); close(); });
        });
        drawer.addEventListener('click', function (e) { if (e.target === drawer) close(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && drawer.classList.contains('on')) close(); });
    }
    if (document.readyState === 'loading') { document.addEventListener('DOMContentLoaded', bindMobileNav); }
    else { bindMobileNav(); }
    setTimeout(bindMobileNav, 500);
})();
</script>
