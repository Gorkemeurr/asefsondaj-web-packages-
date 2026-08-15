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
                            <a href="{{ $catalogUrl }}?cat=delici">Delici Ekipmanlar</a>
                            <a href="{{ $catalogUrl }}?cat=tij">Tij ve Borular</a>
                            <a href="{{ $catalogUrl }}?cat=pompa">Pompa Sistemleri</a>
                            <a href="{{ $catalogUrl }}?cat=karot">Karot Ürünleri</a>
                            <a href="{{ $catalogUrl }}?cat=yedek-parca">Yedek Parça</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Hızlı Bağlantılar</h5>
                            <a href="{{ $catalogUrl }}">Ürün Arama</a>
                            <a href="{{ $catalogUrl }}">Teklif Sepetim</a>
                            <a href="{{ $waLink }}" target="_blank" rel="noopener">WhatsApp'tan Yaz</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Popüler Ürünler</h5>
                            <a href="{{ $catalogUrl }}">DTH Çekiç 4 İnç</a>
                            <a href="{{ $catalogUrl }}">DTH Button Bit 6 İnç</a>
                            <a href="{{ $catalogUrl }}">Sondaj Tiji 3 Metre</a>
                            <a href="{{ $catalogUrl }}">Triplex Çamur Pompası</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="asef-nav-item">
                <a href="{{ url('/') }}#hakkimizda">Kurumsal</a>
                <div class="asef-mega" role="menu" aria-label="Kurumsal menüsü">
                    <div class="asef-mega-grid">
                        <div class="asef-mega-col asef-mega-main">
                            <h5>Kurumsalı Keşfedin</h5>
                            <a href="{{ url('/') }}#hakkimizda">Hakkımızda</a>
                            <a href="#">Sondaj Makinalarımız</a>
                            <a href="{{ url('/') }}#hizmetler">Hizmetlerimiz</a>
                            <a href="#">Referanslar</a>
                            <a href="#">SSS</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Hızlı Bağlantılar</h5>
                            <a href="{{ url('/') }}#iletisim">İletişim</a>
                            <a href="{{ $waLink }}" target="_blank" rel="noopener">WhatsApp'a Yaz</a>
                        </div>
                        <div class="asef-mega-col asef-mega-side">
                            <h5>Daha Fazla</h5>
                            <a href="#">Blog</a>
                            <a href="#">Destek</a>
                            <a href="tel:+905320542975">Hemen Ara</a>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#">Blog</a>
            <a href="#">Destek</a>
        </div>
        <div class="asef-nav-actions">
            <a href="{{ $catalogUrl }}" class="asef-nav-icon-btn" aria-label="Arama">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            </a>
            <a href="{{ url('sepet') }}" class="asef-nav-icon-btn" aria-label="Teklif Sepetim">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                <span class="asef-badge" data-asef-cart-badge style="display: none;"></span>
            </a>
            <a href="{{ $waLink }}" class="asef-nav-cta" target="_blank" rel="noopener">İletişim</a>
        </div>
        <button class="asef-nav-mobile-btn" aria-label="Menü">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" y1="7" x2="20" y2="7"/><line x1="4" y1="17" x2="20" y2="17"/></svg>
        </button>
    </div>
</nav>
