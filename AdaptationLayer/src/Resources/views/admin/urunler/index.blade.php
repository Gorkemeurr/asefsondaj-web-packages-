<x-admin::layouts>
    <x-slot:title>Ürünler — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">Ürünler</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $items->total() }} ürün ({{ $items->count() }} bu sayfada)</p>
        </div>
        <a href="{{ route('admin.asef.products.create') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
            + Yeni Ürün
        </a>
    </div>

    {{-- Filtreler --}}
    <form method="GET" action="{{ route('admin.asef.products.index') }}"
          class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 mb-4 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Arama (SKU veya isim)</label>
            <input type="text" name="q" value="{{ $searchQuery }}" placeholder="AS-KRT veya karotier..."
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Ana Kategori</label>
            <select name="ana" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm min-w-[180px]">
                <option value="">Tümü</option>
                @foreach($anaKategoriler as $ana)
                    <option value="{{ $ana->code }}" @selected($anaFilter === $ana->code)>{{ $ana->code }} — {{ $ana->name }}</option>
                @endforeach
            </select>
        </div>
        @if($anaFilter && $altKategoriler->count() > 0)
            <div>
                <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Alt Kategori</label>
                <select name="alt" onchange="this.form.submit()" class="px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm min-w-[180px]">
                    <option value="">Tümü</option>
                    @foreach($altKategoriler as $alt)
                        <option value="{{ $alt->code }}" @selected($altFilter === $alt->code)>{{ $alt->code }} — {{ $alt->name }}</option>
                    @endforeach
                </select>
            </div>
        @endif
        <button type="submit" class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm">Ara</button>
        @if($searchQuery || $anaFilter || $altFilter)
            <a href="{{ route('admin.asef.products.index') }}" class="px-4 py-2 text-gray-600 dark:text-gray-400 rounded-lg text-sm">Temizle</a>
        @endif
    </form>

    @if(session('success')) <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">{{ session('error') }}</div> @endif

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">SKU</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">İsim</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Kategori</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Ebat</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Aktif</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $p)
                    <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-3 font-mono text-xs text-blue-600 dark:text-blue-400">{{ $p->sku }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $p->name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $p->ana_code }} / {{ $p->alt_code }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $p->attrs['ebat_sistem'] ?? '—' }}</td>
                        <td class="px-4 py-3">
                            @if($p->is_active)
                                <span class="inline-block px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded text-xs">Aktif</span>
                            @else
                                <span class="inline-block px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 rounded text-xs">Pasif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ url('urun/' . $p->sku) }}" target="_blank" class="inline-block px-2 py-1 text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 rounded text-xs">Görüntüle</a>
                            <a href="{{ route('admin.asef.products.edit', $p->sku) }}" class="inline-block px-3 py-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded text-xs font-medium">Düzenle</a>
                            <form action="{{ route('admin.asef.products.destroy', $p->sku) }}" method="POST" class="inline-block" onsubmit="return confirm('Ürünü silmek istediğinden emin misin? Bu işlem geri alınamaz.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-xs font-medium">Sil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-gray-500">Ürün bulunamadı.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $items->links() }}
    </div>
</x-admin::layouts>
