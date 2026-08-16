<x-admin::layouts>
    <x-slot:title>Alt Kategoriler — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">Alt Kategoriler</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ count($items) }} alt kategori</p>
        </div>
        <div class="flex items-center gap-3">
            <form method="GET" action="{{ route('admin.asef.categories.alt.index') }}" class="flex items-center gap-2">
                <select name="ana" onchange="this.form.submit()"
                        class="px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    <option value="">Tüm ana kategoriler</option>
                    @foreach($anaKategoriler as $ana)
                        <option value="{{ $ana->code }}" @selected($anaFilter === $ana->code)>{{ $ana->code }} — {{ $ana->name }}</option>
                    @endforeach
                </select>
            </form>
            <a href="{{ route('admin.asef.categories.alt.create') }}"
               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                + Yeni Alt Kategori
            </a>
        </div>
    </div>

    @if(session('success')) <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">{{ session('error') }}</div> @endif

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Sıra</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Kod</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">İsim</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Ana Kategori</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Ürün</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $it)
                    <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $it->sort }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-blue-600 dark:text-blue-400">{{ $it->code }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $it->name }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $it->parent_code }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                            {{ \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('alt_code', $it->code)->count() }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.asef.categories.alt.edit', $it->code) }}" class="inline-block px-3 py-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded text-xs font-medium">Düzenle</a>
                            <form action="{{ route('admin.asef.categories.alt.destroy', $it->code) }}" method="POST" class="inline-block" onsubmit="return confirm('Sil?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-xs font-medium">Sil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-10 text-center text-gray-500">Henüz alt kategori yok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin::layouts>
