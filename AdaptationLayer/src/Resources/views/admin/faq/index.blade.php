<x-admin::layouts>
    <x-slot:title>SSS — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">Sıkça Sorulan Sorular</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ count($items) }} soru DB'de</p>
        </div>
        <a href="{{ route('admin.asef.faqs.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">+ Yeni Soru</a>
    </div>

    @if(session('success')) <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">{{ session('success') }}</div> @endif

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Sıra</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Soru</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Durum</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $f)
                    <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $f->sort }}</td>
                        <td class="px-4 py-3 text-gray-800 dark:text-white">{{ mb_strimwidth($f->q, 0, 120, '...', 'UTF-8') }}</td>
                        <td class="px-4 py-3">
                            @if($f->is_active)
                                <span class="inline-block px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded text-xs">Yayında</span>
                            @else
                                <span class="inline-block px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 rounded text-xs">Gizli</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.asef.faqs.edit', $f->id) }}" class="inline-block px-3 py-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded text-xs font-medium">Düzenle</a>
                            <form action="{{ route('admin.asef.faqs.destroy', $f->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Silmek istediğinden emin misin?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-xs font-medium">Sil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-4 py-10 text-center text-gray-500">Henüz DB'de soru yok. Mevcut 20 soru hala sss.blade.php içinde — Faz 2b'de DB'ye taşınacak.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-admin::layouts>
