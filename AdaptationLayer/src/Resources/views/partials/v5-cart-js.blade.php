{{-- Client-side "Teklif Sepetim" — localStorage backed, event-delegated so
     it survives Vue re-mounts (Bagisto uses Vue 3 on #app root).
     Include on every page. Public API: window.AsefCart. --}}
@push('scripts')
<script>
(function () {
    'use strict';

    var STORAGE_KEY = 'asef_quote_cart_v1';
    var WA_PHONE    = '905320542975';
    var WA_TEMPLATE = "Merhaba, aşağıdaki ekipmanlar için teklif almak istiyorum:\n\n";

    function readCart() {
        try {
            var raw = localStorage.getItem(STORAGE_KEY);
            if (!raw) return [];
            var data = JSON.parse(raw);
            return Array.isArray(data) ? data : [];
        } catch (e) { return []; }
    }

    function writeCart(items) {
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(items)); } catch (e) {}
        syncBadges();
        window.dispatchEvent(new CustomEvent('asef-cart:changed', { detail: items }));
    }

    function totalCount(items) {
        return items.reduce(function (s, it) { return s + (parseInt(it.qty, 10) || 0); }, 0);
    }

    function syncBadges() {
        var count = totalCount(readCart());
        document.querySelectorAll('[data-asef-cart-badge]').forEach(function (el) {
            if (count > 0) {
                el.textContent = count > 99 ? '99+' : String(count);
                el.style.display = '';
            } else {
                el.textContent = '';
                el.style.display = 'none';
            }
        });
    }

    function findIndex(items, sku) {
        for (var i = 0; i < items.length; i++) { if (items[i].sku === sku) return i; }
        return -1;
    }

    function add(sku, name, qty, meta) {
        qty = Math.max(1, parseInt(qty, 10) || 1);
        var items = readCart();
        var idx = findIndex(items, sku);
        if (idx >= 0) {
            items[idx].qty = Math.max(1, (items[idx].qty || 0) + qty);
        } else {
            items.push(Object.assign({ sku: sku, name: name, qty: qty }, meta || {}));
        }
        writeCart(items);
        showToast(name + ' teklif sepetine eklendi.');
        return items;
    }

    function remove(sku) {
        var items = readCart().filter(function (it) { return it.sku !== sku; });
        writeCart(items);
        return items;
    }

    function setQty(sku, qty) {
        qty = Math.max(1, parseInt(qty, 10) || 1);
        var items = readCart();
        var idx = findIndex(items, sku);
        if (idx >= 0) {
            items[idx].qty = qty;
            writeCart(items);
        }
        return items;
    }

    function clear() { writeCart([]); }

    function buildWhatsAppUrl() {
        var items = readCart();
        var msg;
        if (items.length === 0) {
            msg = 'Merhaba, sondaj ekipmanları hakkında teklif almak istiyorum.';
        } else {
            msg = WA_TEMPLATE;
            items.forEach(function (it, i) {
                msg += (i + 1) + '. ' + it.name + ' (' + it.sku + ') — ' + it.qty + ' adet\n';
            });
            msg += '\nEn uygun teklif ve teslim süresi için geri dönüşünüzü bekliyorum.';
        }
        return 'https://wa.me/' + WA_PHONE + '?text=' + encodeURIComponent(msg);
    }

    function openWhatsApp() {
        window.open(buildWhatsAppUrl(), '_blank', 'noopener');
    }

    // Toast
    var toastEl = null;
    var toastTimer = null;
    function showToast(text) {
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(20px);background:linear-gradient(180deg,#1c1c1e,#000);color:#fff;padding:12px 22px;border-radius:999px;font:600 14px/1.4 -apple-system,BlinkMacSystemFont,Inter,sans-serif;box-shadow:0 8px 32px rgba(0,0,0,0.28);z-index:9999;opacity:0;transition:opacity .25s,transform .25s;pointer-events:none;max-width:calc(100vw - 32px);text-align:center;letter-spacing:-0.005em;';
            document.body.appendChild(toastEl);
        }
        toastEl.textContent = text;
        requestAnimationFrame(function () {
            toastEl.style.opacity = '1';
            toastEl.style.transform = 'translateX(-50%) translateY(0)';
        });
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () {
            toastEl.style.opacity = '0';
            toastEl.style.transform = 'translateX(-50%) translateY(20px)';
        }, 2400);
    }

    // Public API
    window.AsefCart = {
        get: readCart, add: add, remove: remove, setQty: setQty, clear: clear,
        count: function () { return totalCount(readCart()); },
        whatsappUrl: buildWhatsAppUrl, openWhatsApp: openWhatsApp,
        syncBadges: syncBadges, showToast: showToast,
    };

    // ============ EVENT DELEGATION ============
    // All clicks flow through document to survive Vue re-mounts.

    function readQty(btn) {
        // Support data-qty-input (CSS selector) or data-qty-picker (adjacent picker)
        var input = btn.getAttribute('data-qty-input');
        if (input) {
            var el = document.querySelector(input);
            if (el) return parseInt(el.value || el.textContent, 10) || 1;
        }
        var picker = btn.getAttribute('data-qty-picker');
        if (picker) {
            var p = document.querySelector(picker);
            var v = p ? p.querySelector('[data-asef-qty-value]') : null;
            if (v) return parseInt(v.textContent, 10) || 1;
        }
        // Look for a sibling picker in the same card / same parent group
        var parent = btn.closest('[data-asef-pd-card], .asef-pd-card, .asef-cart-item, form, section, body');
        if (parent) {
            var v2 = parent.querySelector('[data-asef-qty-value]');
            if (v2) return parseInt(v2.textContent, 10) || 1;
        }
        return parseInt(btn.getAttribute('data-qty'), 10) || 1;
    }

    document.addEventListener('click', function (ev) {
        // Add to cart (search cards, product detail, anywhere)
        var addBtn = ev.target.closest('[data-asef-add-to-cart], [data-asef-pd-add]');
        if (addBtn) {
            ev.preventDefault();
            var sku  = addBtn.getAttribute('data-sku');
            var name = addBtn.getAttribute('data-name');
            if (!sku || !name) return;
            var qty  = readQty(addBtn);
            var meta = {
                img: addBtn.getAttribute('data-img'),
                cat: addBtn.getAttribute('data-cat'),
            };
            add(sku, name, qty, meta);
            return;
        }

        // WhatsApp quote link
        var waBtn = ev.target.closest('[data-asef-wa-quote]');
        if (waBtn) {
            ev.preventDefault();
            openWhatsApp();
            return;
        }

        // Qty picker + / -
        var incBtn = ev.target.closest('[data-asef-qty-inc]');
        var decBtn = ev.target.closest('[data-asef-qty-dec]');
        if (incBtn || decBtn) {
            ev.preventDefault();
            var btn = incBtn || decBtn;
            var picker = btn.closest('[data-asef-qty-picker], .asef-qty-picker');
            if (!picker) return;
            var val = picker.querySelector('[data-asef-qty-value], .asef-qty-value');
            if (!val) return;
            var current = parseInt(val.textContent, 10) || 1;
            var next = incBtn ? current + 1 : Math.max(1, current - 1);
            val.textContent = String(next);
            var dec = picker.querySelector('[data-asef-qty-dec]');
            if (dec) dec.disabled = next <= 1;

            // Sync to cart if this picker belongs to a cart row with SKU
            var sku = btn.getAttribute('data-sku');
            if (!sku) {
                var row = picker.closest('[data-asef-cart-row]');
                if (row) sku = row.getAttribute('data-sku');
            }
            if (sku) setQty(sku, next);
            return;
        }

        // Remove cart row
        var rmBtn = ev.target.closest('[data-asef-cart-remove]');
        if (rmBtn) {
            ev.preventDefault();
            var rmSku = rmBtn.getAttribute('data-sku');
            if (rmSku) remove(rmSku);
            return;
        }

        // Clear all
        var clrBtn = ev.target.closest('[data-asef-cart-clear]');
        if (clrBtn) {
            ev.preventDefault();
            if (totalCount(readCart()) === 0) return;
            if (confirm('Sepetteki tüm ürünler silinecek. Onaylıyor musun?')) clear();
        }
    }, false);

    // Init badges — supports late DOM ready + Vue mount
    function init() { syncBadges(); }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    // Second pass after Vue likely mounts
    setTimeout(syncBadges, 500);
    setTimeout(syncBadges, 1500);

    // Sync across tabs
    window.addEventListener('storage', function (ev) {
        if (ev.key === STORAGE_KEY) syncBadges();
    });
})();
</script>
@endpush
