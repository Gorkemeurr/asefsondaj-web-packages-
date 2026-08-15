{{-- Client-side "Teklif Sepetim" using localStorage.
     Include on every page so badge stays in sync and any page can call window.AsefCart. --}}
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
        } catch (e) {
            return [];
        }
    }

    function writeCart(items) {
        try {
            localStorage.setItem(STORAGE_KEY, JSON.stringify(items));
        } catch (e) { /* quota or private mode — ignore */ }
        syncBadges();
        window.dispatchEvent(new CustomEvent('asef-cart:changed', { detail: items }));
    }

    function totalCount(items) {
        return items.reduce(function (sum, it) { return sum + (parseInt(it.qty, 10) || 0); }, 0);
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

    function findItem(items, sku) {
        for (var i = 0; i < items.length; i++) { if (items[i].sku === sku) return i; }
        return -1;
    }

    function add(sku, name, qty, meta) {
        qty = Math.max(1, parseInt(qty, 10) || 1);
        var items = readCart();
        var idx = findItem(items, sku);
        if (idx >= 0) {
            items[idx].qty = Math.max(1, items[idx].qty + qty);
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
        var idx = findItem(items, sku);
        if (idx >= 0) {
            items[idx].qty = qty;
            writeCart(items);
        }
        return items;
    }

    function clear() {
        writeCart([]);
    }

    function buildWhatsAppUrl() {
        var items = readCart();
        var msg = WA_TEMPLATE;
        if (items.length === 0) {
            msg = 'Merhaba, sondaj ekipmanları hakkında teklif almak istiyorum.';
        } else {
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

    // Toast — subtle bottom-center notification
    var toastEl = null;
    var toastTimer = null;
    function showToast(text) {
        if (!toastEl) {
            toastEl = document.createElement('div');
            toastEl.style.cssText = 'position:fixed;bottom:24px;left:50%;transform:translateX(-50%) translateY(20px);background:#1a1c1d;color:#fff;padding:12px 22px;border-radius:999px;font:500 14px/1.4 -apple-system,BlinkMacSystemFont,Inter,sans-serif;box-shadow:0 8px 32px rgba(0,0,0,0.2);z-index:9999;opacity:0;transition:opacity .25s,transform .25s;pointer-events:none;max-width:calc(100vw - 32px);text-align:center;';
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
        get: readCart,
        add: add,
        remove: remove,
        setQty: setQty,
        clear: clear,
        count: function () { return totalCount(readCart()); },
        whatsappUrl: buildWhatsAppUrl,
        openWhatsApp: openWhatsApp,
        syncBadges: syncBadges,
    };

    // Wire up any [data-asef-add-to-cart] buttons + [data-asef-wa-quote] links
    function bindHandlers() {
        document.querySelectorAll('[data-asef-add-to-cart]').forEach(function (btn) {
            if (btn.__asefBound) return;
            btn.__asefBound = true;
            btn.addEventListener('click', function (ev) {
                ev.preventDefault();
                var sku  = btn.getAttribute('data-sku');
                var name = btn.getAttribute('data-name');
                var qty  = btn.getAttribute('data-qty') || 1;
                var qtyInput = btn.getAttribute('data-qty-input');
                if (qtyInput) {
                    var el = document.querySelector(qtyInput);
                    if (el) qty = el.value || qty;
                }
                if (sku && name) add(sku, name, qty);
            });
        });
        document.querySelectorAll('[data-asef-wa-quote]').forEach(function (el) {
            if (el.__asefBound) return;
            el.__asefBound = true;
            el.addEventListener('click', function (ev) {
                ev.preventDefault();
                openWhatsApp();
            });
        });
    }

    // Init
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () { bindHandlers(); syncBadges(); });
    } else {
        bindHandlers(); syncBadges();
    }

    // Sync across tabs
    window.addEventListener('storage', function (ev) {
        if (ev.key === STORAGE_KEY) syncBadges();
    });
})();
</script>
@endpush
