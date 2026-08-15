/* ============================================================
 * Asef Sondaj — Storefront JS overrides (Faz 2A extended)
 * Injected via core_config.general.content.custom_scripts.custom_javascript
 * ZERO risk: does DOM manipulation client-side, no PHP touch
 * ============================================================ */

(function () {
    'use strict';

    const ASEF = {
        whatsapp: '905320542975',
        phone: '+90 532 054 29 75',
        email: 'iletisim@asefsondaj.com',
        supportEmail: 'destek@asefsondaj.com',
        web: 'www.asefsondaj.com',
        brand: 'Asef Sondaj',
        tagline: 'Sondaj ekipmanları ve teknik çözümler',
    };

    function whatsappLink(text) {
        return 'https://wa.me/' + ASEF.whatsapp + '?text=' + encodeURIComponent(text || 'Merhaba, bilgi almak istiyorum.');
    }

    // -------------------------------------------------------------
    // 1) Inject bottom pill nav (mobile + desktop)
    // -------------------------------------------------------------
    function injectBottomNav() {
        if (document.getElementById('asef-bottom-nav')) return;

        const currentPath = location.pathname;
        const isHome = currentPath === '/' || currentPath === '';
        const isKatalog = currentPath.includes('/categories') || currentPath.includes('/catalog') || currentPath.includes('/search');
        const isTeklif = false; // no route yet
        const isIletisim = currentPath.includes('/contact');

        const nav = document.createElement('nav');
        nav.id = 'asef-bottom-nav';
        nav.setAttribute('aria-label', 'Ana navigasyon');
        nav.innerHTML = `
            <div class="asef-nav-container">
                <a href="/" class="asef-nav-item ${isHome ? 'active' : ''}" aria-label="Ana Sayfa">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    ${isHome ? '<span>Ana Sayfa</span>' : ''}
                </a>
                <a href="/categories" class="asef-nav-item ${isKatalog ? 'active' : ''}" aria-label="Katalog">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    ${isKatalog ? '<span>Katalog</span>' : ''}
                </a>
                <button type="button" class="asef-nav-item asef-nav-teklif" aria-label="Teklif Listem" onclick="window.__asef_openTeklif && window.__asef_openTeklif()">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <span class="asef-nav-badge" id="asef-teklif-badge" style="display:none">0</span>
                </button>
                <a href="${whatsappLink()}" target="_blank" rel="noopener" class="asef-nav-item ${isIletisim ? 'active' : ''}" aria-label="İletişim">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    ${isIletisim ? '<span>İletişim</span>' : ''}
                </a>
            </div>
        `;
        document.body.appendChild(nav);
    }

    // -------------------------------------------------------------
    // 2) Teklif Listem — localStorage-based quote list
    // -------------------------------------------------------------
    const QUOTE_KEY = 'asef_teklif_items';

    function getQuoteItems() {
        try {
            return JSON.parse(localStorage.getItem(QUOTE_KEY) || '[]');
        } catch (e) {
            return [];
        }
    }

    function saveQuoteItems(items) {
        localStorage.setItem(QUOTE_KEY, JSON.stringify(items));
        updateQuoteBadge();
    }

    function addToQuote(sku, name, url) {
        const items = getQuoteItems();
        const existing = items.find(x => x.sku === sku);
        if (existing) {
            existing.qty += 1;
        } else {
            items.push({ sku, name, url, qty: 1 });
        }
        saveQuoteItems(items);
        showToast('Teklif listenize eklendi: ' + name);
    }

    function updateQuoteBadge() {
        const badge = document.getElementById('asef-teklif-badge');
        if (!badge) return;
        const items = getQuoteItems();
        const totalQty = items.reduce((sum, x) => sum + x.qty, 0);
        if (totalQty > 0) {
            badge.textContent = totalQty;
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    window.__asef_openTeklif = function () {
        const items = getQuoteItems();
        if (items.length === 0) {
            alert('Teklif listeniz boş. Ürün eklemek için katalog sayfasına gidin.');
            return;
        }

        // Build WhatsApp message
        let msg = 'Merhaba, aşağıdaki ürünler için teklif almak istiyorum:\n\n';
        items.forEach((item, i) => {
            msg += `${i + 1}. ${item.name} (${item.sku}) — ${item.qty} adet\n   ${item.url}\n\n`;
        });
        msg += 'Fiyat + teslim süresi bilgisi rica ederim.';

        window.open(whatsappLink(msg), '_blank');
    };

    // -------------------------------------------------------------
    // 3) Product page: replace "Sepete Ekle" with "Teklif Listesine Ekle"
    // -------------------------------------------------------------
    function replaceAddToCart() {
        // Find add-to-cart buttons on product pages
        const buttons = document.querySelectorAll(
            'button[class*="add-to-cart"], button.add-to-cart, ' +
            'button[type="submit"]:not(.asef-processed)'
        );
        buttons.forEach(btn => {
            if (btn.classList.contains('asef-processed')) return;
            const text = (btn.textContent || '').toLowerCase();
            const parentForm = btn.closest('form');
            const isCartAction = text.includes('sepete') || text.includes('cart') ||
                (parentForm && (parentForm.action || '').includes('cart'));

            if (!isCartAction) return;
            btn.classList.add('asef-processed');

            // Try to extract product info from surrounding DOM
            const productContainer = btn.closest('[data-product]') || btn.closest('form') || btn.parentElement;
            const nameEl = document.querySelector('h1, .product-name, [class*="product-title"]');
            const skuEl = document.querySelector('[class*="sku"], .product-sku');
            const productName = nameEl ? nameEl.textContent.trim() : 'Ürün';
            const productSku = skuEl ? skuEl.textContent.trim().replace(/[^\w-]+/g, '') : '';
            const productUrl = location.href;

            // Create replacement button
            const newBtn = document.createElement('button');
            newBtn.type = 'button';
            newBtn.className = 'asef-teklif-btn';
            newBtn.innerHTML = `
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right:8px"><path d="M9 11H1l8-8 8 8h-8v10"/></svg>
                Teklif Listesine Ekle
            `;
            newBtn.onclick = (e) => {
                e.preventDefault();
                addToQuote(productSku, productName, productUrl);
            };

            btn.parentNode.insertBefore(newBtn, btn);
            btn.style.display = 'none';
        });
    }

    // -------------------------------------------------------------
    // 4) Toast notification
    // -------------------------------------------------------------
    function showToast(msg) {
        let toast = document.getElementById('asef-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'asef-toast';
            document.body.appendChild(toast);
        }
        toast.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 3000);
    }

    // -------------------------------------------------------------
    // 5) Boot on DOMContentLoaded
    // -------------------------------------------------------------
    function boot() {
        injectBottomNav();
        updateQuoteBadge();
        replaceAddToCart();

        // Re-scan periodically (in case Bagisto loads content dynamically)
        setInterval(replaceAddToCart, 1500);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
