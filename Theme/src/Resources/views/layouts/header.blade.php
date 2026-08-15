<header class="asef-header">
    <div class="asef-container asef-header__inner">
        <a href="/" class="asef-header__logo" aria-label="Ana Sayfa">
            <img src="/asef-theme/images/logo.png" alt="{{ $asefBrand['name'] }}">
        </a>
        <div class="asef-header__brand">
            <h1>{{ $asefBrand['name'] }}</h1>
            <p>{{ $asefBrand['tagline'] }}</p>
        </div>
        <a href="/teklif" class="asef-header__cart" aria-label="Teklif Listem">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            <span class="asef-header__cart__badge" data-asef-quote-badge>0</span>
        </a>
    </div>
</header>
