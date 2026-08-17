<x-admin::layouts>
    <x-slot:title>
        {{ $mode === 'edit' ? 'Teklif Duzenle — ' . $quote->quote_no : 'Yeni E-Fatura' }}
    </x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                {{ $mode === 'edit' ? 'Teklif Duzenle' : 'Yeni E-Fatura Olustur' }}
            </p>
            @if($mode === 'edit')
                <p class="text-sm text-gray-500 mt-1 font-mono">{{ $quote->quote_no }}</p>
            @endif
        </div>
        <div class="flex items-center gap-2">
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

        {{-- MUSTERI BILGILERI --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
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

        {{-- URUN EKLE --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Urun Kalemleri</h3>
                <div class="flex items-center gap-2">
                    <input type="text" id="product-lookup-input"
                           placeholder="Urun kodu, link veya isim yapistir…"
                           class="w-72 px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none"
                           onkeydown="if(event.key==='Enter'){event.preventDefault();window.quoteApp.addProductByLookup();}">
                    <button type="button" onclick="window.quoteApp.addProductByLookup()"
                            class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">Ekle</button>
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

        {{-- FIYATLANDIRMA / TOPLAM --}}
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800 dark:text-white">Toplam</h3>
                <div class="flex items-center gap-2">
                    <label class="text-xs font-medium text-gray-600 dark:text-gray-400">KDV Orani (%)</label>
                    <select name="kdv_rate" id="kdv-rate"
                            onchange="window.quoteApp.recalcTotals()"
                            class="w-24 px-3 py-2 border border-gray-200 dark:border-gray-700 rounded-lg text-sm bg-white dark:bg-gray-800 focus:border-blue-600 focus:ring-1 focus:ring-blue-600 outline-none">
                        @foreach([0,1,10,20] as $r)
                            <option value="{{ $r }}" @selected((int) old('kdv_rate', $quote->kdv_rate ?? 20) === $r)>%{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="max-w-md ml-auto space-y-2 text-sm">
                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                    <span>Ara Toplam</span>
                    <span><span id="sum-subtotal">0,00</span> ₺</span>
                </div>
                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                    <span>KDV (<span id="sum-kdv-rate">20</span>%)</span>
                    <span><span id="sum-kdv">0,00</span> ₺</span>
                </div>
                <div class="border-t border-gray-200 dark:border-gray-800 pt-2 flex justify-between text-base font-semibold text-gray-900 dark:text-white">
                    <span>Genel Toplam</span>
                    <span><span id="sum-grand">0,00</span> ₺</span>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
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
                           class="item-qty w-20 px-2 py-1.5 border border-gray-200 dark:border-gray-700 rounded text-sm bg-white dark:bg-gray-800 text-right"
                           oninput="window.quoteApp.recalcTotals()">
                </div>
                <div>
                    <label class="block text-[10px] text-gray-500 mb-0.5">Birim Fiyat (₺)</label>
                    <input type="number" min="0" step="0.01" value="0"
                           class="item-price w-32 px-2 py-1.5 border border-gray-200 dark:border-gray-700 rounded text-sm bg-white dark:bg-gray-800 text-right"
                           oninput="window.quoteApp.recalcTotals()">
                </div>
                <div class="text-right">
                    <div class="text-[10px] text-gray-500">Toplam</div>
                    <div class="item-line-total text-sm font-semibold text-gray-900 dark:text-white whitespace-nowrap">0,00 ₺</div>
                </div>
                <button type="button" onclick="window.quoteApp.removeRow(this)"
                        class="ml-1 p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded transition"
                        title="Sil">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M8 6V4a2 2 0 012-2h4a2 2 0 012 2v2m3 0v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6h14z"/></svg>
                </button>
            </div>
        </div>
    </template>

    <script>
    (function(){
        const LOOKUP_URL = @json(route('admin.asef.quotes.lookup'));
        const FORM = document.getElementById('quote-form');
        const LIST = document.getElementById('items-list');
        const EMPTY = document.getElementById('items-empty');
        const LOOKUP_INPUT = document.getElementById('product-lookup-input');
        const LOOKUP_ERR = document.getElementById('lookup-error');
        const CSRF = document.querySelector('meta[name="csrf-token"]')?.content
                   || FORM.querySelector('input[name="_token"]')?.value || '';

        const initialItems = @json($items);

        function formatTL(n) {
            return Number(n || 0).toLocaleString('tr-TR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        }

        function toggleEmpty() {
            EMPTY.style.display = LIST.children.length === 0 ? '' : 'none';
        }

        function addRow(item) {
            const tpl = document.getElementById('item-row-template').content.cloneNode(true);
            const row = tpl.querySelector('.item-row');
            row.querySelector('.item-img').src = item.image_url || '';
            row.querySelector('.item-name').textContent = item.name || '';
            row.querySelector('.item-sku').textContent = item.sku || '';
            row.dataset.sku = item.sku || '';
            row.dataset.name = item.name || '';
            row.dataset.image = item.image || '';
            row.querySelector('.item-qty').value = item.quantity || 1;
            row.querySelector('.item-price').value = item.unit_price || 0;
            LIST.appendChild(row);
            toggleEmpty();
            recalcTotals();
        }

        async function addProductByLookup() {
            LOOKUP_ERR.classList.add('hidden');
            const q = LOOKUP_INPUT.value.trim();
            if (!q) return;

            try {
                const res = await fetch(LOOKUP_URL + '?q=' + encodeURIComponent(q), {
                    headers: {'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}
                });
                const data = await res.json();
                if (!data.ok) {
                    LOOKUP_ERR.textContent = data.error || 'Urun bulunamadi';
                    LOOKUP_ERR.classList.remove('hidden');
                    return;
                }
                addRow(data.item);
                LOOKUP_INPUT.value = '';
                LOOKUP_INPUT.focus();
            } catch (e) {
                LOOKUP_ERR.textContent = 'Sunucu hatasi: ' + e.message;
                LOOKUP_ERR.classList.remove('hidden');
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
            LIST.querySelectorAll('.item-row').forEach(row => {
                const qty = Math.max(0, parseInt(row.querySelector('.item-qty').value) || 0);
                const price = Math.max(0, parseFloat(row.querySelector('.item-price').value) || 0);
                // Satir totalini once yuvarla, sonra ara toplama ekle — backend ile eslesir
                const line = round2(qty * price);
                row.querySelector('.item-line-total').textContent = formatTL(line) + ' ₺';
                subtotal += line;
            });
            subtotal = round2(subtotal);
            const rate = Math.max(0, Math.min(100, parseInt(document.getElementById('kdv-rate').value) || 0));
            const kdv = round2(subtotal * rate / 100);
            const grand = round2(subtotal + kdv);
            document.getElementById('sum-subtotal').textContent = formatTL(subtotal);
            document.getElementById('sum-kdv').textContent = formatTL(kdv);
            document.getElementById('sum-kdv-rate').textContent = rate;
            document.getElementById('sum-grand').textContent = formatTL(grand);
        }

        // Form gonderirken satirlari items[] olarak topla
        FORM.addEventListener('submit', function(e) {
            // Onceki hidden inputlari temizle
            FORM.querySelectorAll('input[name^="items["]').forEach(el => el.remove());
            const rows = LIST.querySelectorAll('.item-row');
            if (rows.length === 0) {
                e.preventDefault();
                LOOKUP_ERR.textContent = 'En az bir urun eklemelisin';
                LOOKUP_ERR.classList.remove('hidden');
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
                    FORM.appendChild(input);
                });
            });
        });

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

        window.quoteApp = { addProductByLookup, removeRow, recalcTotals };
    })();
    </script>
</x-admin::layouts>
