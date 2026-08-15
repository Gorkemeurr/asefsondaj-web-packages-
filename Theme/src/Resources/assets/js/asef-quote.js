/* Asef Sondaj — client-side Teklif Listem (localStorage)
   Depends on nothing (vanilla JS). */

(function () {
    'use strict';

    const KEY  = 'asef_quote_items_v1';
    const WA   = document.documentElement.dataset.asefWhatsapp || '905320542975';

    function read() {
        try { return JSON.parse(localStorage.getItem(KEY)) || []; }
        catch { return []; }
    }

    function write(items) {
        localStorage.setItem(KEY, JSON.stringify(items));
        renderBadges();
        document.dispatchEvent(new CustomEvent('asef:quote:changed', { detail: items }));
    }

    function totalQty(items) {
        return items.reduce((s, i) => s + (parseInt(i.qty, 10) || 0), 0);
    }

    function renderBadges() {
        const items = read();
        const count = totalQty(items);
        document.querySelectorAll('[data-asef-quote-badge]').forEach(el => {
            el.textContent = count;
            el.classList.toggle('is-visible', count > 0);
        });
    }

    function add(product, qty = 1) {
        const items = read();
        const idx = items.findIndex(i => i.sku === product.sku);
        if (idx >= 0) {
            items[idx].qty = Math.min(99, items[idx].qty + qty);
        } else {
            items.push({ sku: product.sku, name: product.name, qty: Math.max(1, Math.min(99, qty)), image: product.image || '' });
        }
        write(items);
        toast(`✓ ${product.name} teklif listesine eklendi`);
    }

    function remove(sku) {
        write(read().filter(i => i.sku !== sku));
    }

    function setQty(sku, qty) {
        const items = read();
        const idx = items.findIndex(i => i.sku === sku);
        if (idx < 0) return;
        const n = parseInt(qty, 10);
        if (!isFinite(n) || n < 1) { remove(sku); return; }
        items[idx].qty = Math.min(99, Math.max(1, n));
        write(items);
    }

    function clear() {
        if (confirm('Teklif listesini temizlemek istediğinizden emin misiniz?')) {
            write([]);
        }
    }

    function buildWhatsAppUrl() {
        const items = read();
        if (!items.length) return null;
        const lines = items.map(i => `• ${i.name} (${i.sku}) — ${i.qty} adet`).join('\n');
        const msg   = `Merhaba, aşağıdaki ürünler için teklif almak istiyorum:\n\n${lines}\n\nİletişim bilgilerim: `;
        return `https://wa.me/${WA}?text=${encodeURIComponent(msg)}`;
    }

    function buildMailtoUrl() {
        const items = read();
        const email = document.documentElement.dataset.asefEmail || 'iletisim@asefsondaj.com';
        const lines = items.length ? items.map(i => `• ${i.name} (${i.sku}) — ${i.qty} adet`).join('\n') : '(Ürün seçimi yok)';
        const subject = 'Asef Sondaj — Teklif Talebi';
        const body    = `Merhaba,\n\nAşağıdaki ürünler için teklif rica ediyorum:\n\n${lines}\n\nSaygılarımla`;
        return `mailto:${email}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    }

    function toast(msg) {
        let el = document.getElementById('asef-toast');
        if (!el) {
            el = document.createElement('div');
            el.id = 'asef-toast';
            el.style.cssText =
                'position:fixed;bottom:120px;left:50%;transform:translateX(-50%) translateY(20px);' +
                'background:#1D1D1F;color:#FFF;padding:12px 20px;border-radius:999px;font-size:14px;' +
                'font-weight:500;box-shadow:0 12px 32px -12px rgba(0,0,0,.4);z-index:100;opacity:0;' +
                'transition:opacity .25s ease, transform .25s ease;pointer-events:none;font-family:inherit;';
            document.body.appendChild(el);
        }
        el.textContent = msg;
        requestAnimationFrame(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateX(-50%) translateY(0)';
        });
        clearTimeout(el._t);
        el._t = setTimeout(() => {
            el.style.opacity = '0';
            el.style.transform = 'translateX(-50%) translateY(20px)';
        }, 2200);
    }

    // Auto-wire clicks: [data-asef-add] with data-sku/data-name/data-image
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-asef-add]');
        if (btn) {
            e.preventDefault();
            add({
                sku:   btn.dataset.sku,
                name:  btn.dataset.name,
                image: btn.dataset.image || '',
            }, parseInt(btn.dataset.qty || '1', 10));
        }
        const remBtn = e.target.closest('[data-asef-remove]');
        if (remBtn) {
            e.preventDefault();
            remove(remBtn.dataset.sku);
            const row = remBtn.closest('[data-asef-quote-row]');
            if (row) row.remove();
            if (read().length === 0) location.reload();
        }
        const clearBtn = e.target.closest('[data-asef-clear]');
        if (clearBtn) {
            e.preventDefault();
            clear();
            location.reload();
        }
        const sendBtn = e.target.closest('[data-asef-send-wa]');
        if (sendBtn) {
            e.preventDefault();
            const url = buildWhatsAppUrl();
            if (url) window.open(url, '_blank');
            else alert('Teklif listeniz boş.');
        }
        const mailBtn = e.target.closest('[data-asef-send-mail]');
        if (mailBtn) {
            e.preventDefault();
            window.location.href = buildMailtoUrl();
        }
    });

    // Stepper changes
    document.addEventListener('change', function (e) {
        const inp = e.target.closest('[data-asef-qty]');
        if (inp) setQty(inp.dataset.sku, inp.value);
    });
    document.addEventListener('click', function (e) {
        const inc = e.target.closest('[data-asef-qty-inc]');
        const dec = e.target.closest('[data-asef-qty-dec]');
        if (!inc && !dec) return;
        e.preventDefault();
        const wrap = (inc || dec).closest('[data-asef-stepper]');
        const input = wrap.querySelector('[data-asef-qty]');
        let n = parseInt(input.value, 10) || 1;
        n = inc ? Math.min(99, n + 1) : Math.max(1, n - 1);
        input.value = n;
        setQty(input.dataset.sku, n);
    });

    // Renders quote list rows on the quote page
    function renderQuotePage() {
        const container = document.querySelector('[data-asef-quote-list]');
        if (!container) return;
        const items = read();
        const empty = document.querySelector('[data-asef-quote-empty]');
        const filled = document.querySelector('[data-asef-quote-filled]');

        if (!items.length) {
            if (empty)  empty.style.display  = 'block';
            if (filled) filled.style.display = 'none';
            return;
        }
        if (empty)  empty.style.display  = 'none';
        if (filled) filled.style.display = 'block';

        container.innerHTML = items.map(item => `
            <div class="asef-quote__item" data-asef-quote-row data-sku="${item.sku}">
                <div class="asef-quote__item__img" style="background-image:url('${item.image}')"></div>
                <div>
                    <p class="asef-quote__item__name">${escape(item.name)}</p>
                    <p class="asef-quote__item__sku">${escape(item.sku)}</p>
                    <div class="asef-stepper" data-asef-stepper>
                        <button type="button" data-asef-qty-dec aria-label="Azalt">−</button>
                        <input type="number" min="1" max="99" value="${item.qty}" data-asef-qty data-sku="${item.sku}" />
                        <button type="button" data-asef-qty-inc aria-label="Artır">+</button>
                    </div>
                </div>
                <button type="button" class="asef-quote__item__remove" data-asef-remove data-sku="${item.sku}" aria-label="Kaldır">×</button>
            </div>
        `).join('');

        const countEl = document.querySelector('[data-asef-quote-count]');
        if (countEl) countEl.textContent = items.length + ' adet ürün';
    }

    function escape(s) { return String(s).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c])); }

    document.addEventListener('DOMContentLoaded', () => {
        renderBadges();
        renderQuotePage();
    });
    document.addEventListener('asef:quote:changed', renderQuotePage);
})();
