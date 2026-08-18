<x-admin::layouts>
    <x-slot:title>
        {{ $mode === 'edit' ? 'Teklif Duzenle — ' . $quote->quote_no : 'Yeni E-Fatura' }}
    </x-slot>

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                {{ $mode === 'edit' ? 'Teklif Duzenle' : 'Yeni E-Fatura Olustur' }}
            </p>
            @if($mode === 'edit')
                <p class="text-sm text-gray-500 mt-1 font-mono">{{ $quote->quote_no }}</p>
            @endif
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('admin.asef.quotes.index') }}"
               class="px-4 py-2 border border-gray-200 dark:border-gray-800 text-gray-700 dark:text-gray-300 rounded-lg text-sm hover:bg-gray-50 dark:hover:bg-gray-800">Vazgec</a>
            @if($mode === 'edit')
                <a href="{{ route('admin.asef.quotes.pdf', $quote->id) }}" target="_blank"
                   class="px-4 py-2 border border-blue-600 text-blue-600 rounded-lg text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 font-medium">PDF Onizle</a>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ $mode === 'edit' ? route('admin.asef.quotes.update', $quote->id) : route('admin.asef.quotes.store') }}"
          id="quote-form"
          class="space-y-6">
        @csrf
        @if($mode === 'edit') @method('PUT') @endif

        {{-- MUSTERI BILGILERI (mobil uyumlu padding) --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Musteri Bilgileri</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Ad Soyad *</label>
                    <input type="text" name="customer_name" required value="{{ old('customer_name', $quote->customer_name) }}"
                           class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Telefon *</label>
                    <input type="text" name="customer_phone" required value="{{ old('customer_phone', $quote->customer_phone) }}"
                           class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Firma</label>
                    <input type="text" name="customer_company" value="{{ old('customer_company', $quote->customer_company) }}"
                           class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Pozisyon</label>
                    <select name="customer_position"
                            class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                        <option value="">Seciniz</option>
                        @foreach(['Firma Sahibi','Yonetici','Satin Alma','Muhendis','Teknik Personel','Diger'] as $poz)
                            <option value="{{ $poz }}" @selected(old('customer_position', $quote->customer_position) === $poz)>{{ $poz }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Il</label>
                    <input type="text" name="customer_city" value="{{ old('customer_city', $quote->customer_city) }}"
                           class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Ilce</label>
                    <input type="text" name="customer_district" value="{{ old('customer_district', $quote->customer_district) }}"
                           class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">E-posta</label>
                    <input type="email" name="customer_email" value="{{ old('customer_email', $quote->customer_email) }}"
                           class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Not</label>
                    <textarea name="customer_note" rows="2"
                              class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">{{ old('customer_note', $quote->customer_note) }}</textarea>
                </div>
            </div>
        </div>

        {{-- URUN EKLE — mobil uyumlu --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Urun Kalemleri</h3>
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2">
                    <input type="text" id="product-lookup-input"
                           placeholder="Urun kodu, link veya isim yapistir…"
                           class="w-full sm:w-72 px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                    <button type="button" id="product-lookup-btn"
                            style="background:#0071E3;color:#fff;padding:10px 16px;border-radius:8px;font-size:14px;font-weight:600;border:0;cursor:pointer;">Ekle</button>
                </div>
            </div>

            <div id="lookup-error" class="hidden mb-3 p-2 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded text-xs"></div>

            <div id="items-list" class="space-y-2">
                {{-- JS burasi doldurur --}}
            </div>

            <div id="items-empty" class="py-10 text-center text-sm text-gray-500 border border-dashed border-gray-200 dark:border-gray-700 rounded-lg">
                Henuz urun eklenmedi. Ustteki kutuya urun kodu veya link yapistir.
            </div>
        </div>

        {{-- TOPLAM (KDV disi — PDF'te "Fiyatlarimiza KDV dahil degildir" belirtilir) --}}
        <input type="hidden" name="kdv_rate" value="20">
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 md:p-6">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Toplam</h3>
            <div class="max-w-md ml-auto text-sm">
                <div class="flex justify-between items-center text-base font-semibold text-gray-900 dark:text-white">
                    <span>TOPLAM (KDV Hariç)</span>
                    <span><span id="sum-subtotal">0,00</span> ₺</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <button type="submit"
                    style="background:#0071E3;color:#fff;padding:12px 32px;border-radius:8px;font-size:14px;font-weight:600;border:0;cursor:pointer;">
                {{ $mode === 'edit' ? 'Guncelle' : 'Teklifi Kaydet' }}
            </button>
        </div>
    </form>

    {{-- Row template --}}
    <template id="item-row-template">
        <div class="item-row flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-800 rounded-lg">
            <img class="item-img w-14 h-14 rounded-lg object-cover bg-gray-200 dark:bg-gray-700" alt="">
            <div class="flex-1 min-w-0">
                <div class="item-name text-sm font-medium text-gray-900 dark:text-white truncate"></div>
                <div class="item-sku text-xs text-gray-500 font-mono mt-0.5"></div>
            </div>
            <div class="flex items-center gap-2">
                <div>
                    <label class="block text-[10px] text-gray-500 mb-0.5">Adet</label>
                    <input type="number" min="1" max="999999" value="1"
                           class="item-qty w-20 px-2 py-1.5 border border-gray-200 dark:border-gray-700 rounded text-sm bg-white dark:bg-gray-800 text-right">
                </div>
                <div>
                    <label class="block text-[10px] text-gray-500 mb-0.5">Birim Fiyat (₺)</label>
                    <input type="number" min="0" step="0.01" value="0"
                           class="item-price w-32 px-2 py-1.5 border border-gray-200 dark:border-gray-700 rounded text-sm bg-white dark:bg-gray-800 text-right">
                </div>
                <div class="text-right">
                    <div class="text-[10px] text-gray-500">Toplam</div>
                    <div class="item-line-total text-sm font-semibold text-gray-900 dark:text-white whitespace-nowrap">0,00 ₺</div>
                </div>
                <button type="button" class="item-remove-btn"
                        style="background:transparent;border:0;color:#dc2626;padding:6px 10px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;"
                        title="Sil">Sil</button>
            </div>
        </div>
    </template>

    <script>
    console.log('[Asef Quote Form] Script loaded v6 (fresh DOM refs)');
    (function(){
        const LOOKUP_URL = @json(route('admin.asef.quotes.lookup'));
        console.log('[Asef Quote Form] Lookup URL config:', LOOKUP_URL);

        // DOM refs — HER cagirmada tazele (Vue rerender'a karsi guvenli)
        const $ = (id) => document.getElementById(id);
        const form  = () => $('quote-form');
        const list  = () => $('items-list');
        const empty = () => $('items-empty');
        const input = () => $('product-lookup-input');
        const err   = () => $('lookup-error');

        const initialItems = @json($items);

        function formatTL(n) {
            return Number(n || 0).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function toggleEmpty() {
            empty().style.display = list().children.length === 0 ? '' : 'none';
        }

        // ROW HTML — string olarak insa et, <template> tag'ine guvenme
        // (Vue bazi ortamlarda <template>'i yiyor)
        function addRow(item) {
            const row = document.createElement('div');
            row.className = 'item-row';
            // Mobil uyumlu: flex-wrap ile mobile'da satır sarar
            row.style.cssText = 'display:flex;flex-wrap:wrap;align-items:center;gap:10px;padding:12px;background:#F5F5F7;border:1px solid #E8E8ED;border-radius:8px;margin-bottom:8px;';
            row.dataset.sku = item.sku || '';
            row.dataset.name = item.name || '';
            row.dataset.image = item.image || '';

            const imgSrc = item.image_url || '';
            const name = (item.name || '').replace(/</g, '&lt;');
            const sku = (item.sku || '').replace(/</g, '&lt;');
            const qty = item.quantity || 1;
            const price = item.unit_price || 0;

            row.innerHTML = `
                <img class="item-img" src="${imgSrc}" alt="" style="width:52px;height:52px;object-fit:cover;border-radius:6px;background:#eee;flex-shrink:0;">
                <div style="flex:1 1 200px;min-width:0;">
                    <div class="item-name" style="font-size:14px;font-weight:600;color:#1D1D1F;">${name}</div>
                    <div class="item-sku" style="font-size:11px;color:#6E6E73;font-family:monospace;margin-top:2px;">${sku}</div>
                </div>
                <div style="display:flex;flex-wrap:wrap;align-items:flex-end;gap:8px;width:100%;justify-content:flex-end;" class="asef-item-controls">
                    <div>
                        <div style="font-size:10px;color:#6E6E73;margin-bottom:2px;">Adet</div>
                        <input type="number" min="1" max="999999" value="${qty}" class="item-qty" style="width:74px;padding:8px;border:1px solid #DDDDDD;border-radius:6px;font-size:14px;text-align:right;">
                    </div>
                    <div>
                        <div style="font-size:10px;color:#6E6E73;margin-bottom:2px;">Birim Fiyat (₺)</div>
                        <input type="number" min="0" step="0.01" value="${price}" class="item-price" style="width:110px;padding:8px;border:1px solid #DDDDDD;border-radius:6px;font-size:14px;text-align:right;">
                    </div>
                    <div style="text-align:right;min-width:100px;">
                        <div style="font-size:10px;color:#6E6E73;">Toplam</div>
                        <div class="item-line-total" style="font-size:14px;font-weight:600;color:#1D1D1F;white-space:nowrap;">0,00 ₺</div>
                    </div>
                    <button type="button" class="item-remove-btn" title="Sil"
                        style="background:transparent;border:1px solid #FEE2E2;color:#dc2626;padding:8px 12px;border-radius:6px;cursor:pointer;font-size:12px;font-weight:600;">Sil</button>
                </div>
            `;

            list().appendChild(row);
            toggleEmpty();
            recalcTotals();
        }

        async function addProductByLookup() {
            err().classList.add('hidden');
            const q = input().value.trim();
            if (!q) return;

            try {
                const url = LOOKUP_URL + '?q=' + encodeURIComponent(q);
                console.log('[Asef] Lookup URL:', url);
                const res = await fetch(url, {
                    credentials: 'same-origin',
                    headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
                });
                console.log('[Asef] Lookup response status:', res.status);
                const text = await res.text();
                console.log('[Asef] Lookup response body:', text.substring(0, 300));
                let data;
                try { data = JSON.parse(text); } catch (e) {
                    err().textContent = 'Sunucu JSON dondurmedi (status ' + res.status + '). Konsolu ac.';
                    err().classList.remove('hidden');
                    return;
                }
                if (!data.ok) {
                    err().textContent = data.error || 'Urun bulunamadi';
                    err().classList.remove('hidden');
                    return;
                }
                addRow(data.item);
                input().value = '';
                input().focus();
            } catch (e) {
                console.error('[Asef] Lookup error:', e);
                err().textContent = 'Sunucu hatasi: ' + e.message;
                err().classList.remove('hidden');
            }
        }

        function removeRow(btn) {
            const row = btn.closest('.item-row');
            row.remove();
            toggleEmpty();
            recalcTotals();
        }

        // 2 desimale yuvarla (para matematigi icin fp guvenli)
        function round2(n) {
            return Math.round((Number(n) + Number.EPSILON) * 100) / 100;
        }

        function recalcTotals() {
            let subtotal = 0;
            list().querySelectorAll('.item-row').forEach(row => {
                const qty = Math.max(0, parseInt(row.querySelector('.item-qty').value) || 0);
                const price = Math.max(0, parseFloat(row.querySelector('.item-price').value) || 0);
                const line = round2(qty * price);
                row.querySelector('.item-line-total').textContent = formatTL(line) + ' ₺';
                subtotal += line;
            });
            subtotal = round2(subtotal);
            document.getElementById('sum-subtotal').textContent = formatTL(subtotal);
        }

        // Form gonderirken satirlari items[] olarak topla — document DELEGATION
        document.addEventListener('submit', function(e) {
            if (!e.target || e.target.id !== 'quote-form') return;
            const f = e.target;
            // Onceki hidden inputlari temizle
            f.querySelectorAll('input[name^="items["]').forEach(el => el.remove());
            const rows = list().querySelectorAll('.item-row');
            console.log('[Asef] Form submit — collecting', rows.length, 'items');
            if (rows.length === 0) {
                e.preventDefault();
                err().textContent = 'En az bir urun eklemelisin';
                err().classList.remove('hidden');
                return;
            }
            rows.forEach((row, i) => {
                const fields = {
                    product_sku: row.dataset.sku,
                    product_name: row.dataset.name,
                    product_image: row.dataset.image,
                    quantity: row.querySelector('.item-qty').value,
                    unit_price: row.querySelector('.item-price').value,
                };
                Object.entries(fields).forEach(([k, v]) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `items[${i}][${k}]`;
                    input.value = v ?? '';
                    f.appendChild(input);
                });
            });
        }, true);

        // Baslangicta mevcut satirlari yukle (edit modu)
        initialItems.forEach(it => addRow({
            sku: it.product_sku,
            name: it.product_name,
            image: it.product_image,
            image_url: it.product_image ? (@json(url('asef')) + '/' + it.product_image) : '',
            quantity: it.quantity,
            unit_price: it.unit_price,
        }));
        toggleEmpty();
        recalcTotals();

        // EVENT DELEGATION — Vue rerender'a karsi bulletproof
        // document seviyesinde dinle, target'a gore filtrele
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('#product-lookup-btn');
            if (btn) {
                e.preventDefault();
                console.log('[Asef Quote Form] Ekle button clicked (delegated)');
                addProductByLookup();
                return;
            }
        }, true);
        document.addEventListener('keydown', function(e) {
            if (e.target && e.target.id === 'product-lookup-input' && e.key === 'Enter') {
                e.preventDefault();
                console.log('[Asef Quote Form] Enter pressed (delegated)');
                addProductByLookup();
            }
        }, true);
        // item row input/remove delegation
        document.addEventListener('input', function(e) {
            if (e.target && (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price'))) {
                recalcTotals();
            }
        }, true);
        document.addEventListener('click', function(e) {
            const removeBtn = e.target.closest('.item-remove-btn');
            if (removeBtn) {
                const row = removeBtn.closest('.item-row');
                if (row) { row.remove(); toggleEmpty(); recalcTotals(); }
            }
        }, true);
        console.log('[Asef Quote Form] Delegated event listeners bound to document');

        window.quoteApp = { addProductByLookup, removeRow, recalcTotals };
    })();
    </script>
</x-admin::layouts>
