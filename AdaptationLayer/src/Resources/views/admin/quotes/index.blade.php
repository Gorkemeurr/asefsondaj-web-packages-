<x-admin::layouts>
    <x-slot:title>E-Fatura Olustur — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">E-Fatura Teklifleri</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                Toplam {{ $quotes->total() }} teklif
            </p>
        </div>
        <a href="{{ route('admin.asef.quotes.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
            Yeni Teklif
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Fatura No</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Musteri</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Firma</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Sehir</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Tutar</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Tarih</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Islemler</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quotes as $q)
                    <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                        <td class="px-4 py-3 text-gray-800 dark:text-white">
                            <div class="font-mono font-semibold text-blue-600">{{ $q->plateLabel() }}</div>
                            <div class="text-[10px] text-gray-500 font-mono mt-0.5">{{ $q->quote_no }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-800 dark:text-white">
                            {{ $q->customer_name }}
                            <div class="text-xs text-gray-500 mt-0.5">{{ $q->customer_phone }}</div>
                        </td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $q->customer_company ?: '—' }}</td>
                        <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $q->customer_city ?: '—' }}</td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900 dark:text-white">
                            {{ number_format((float) $q->subtotal, 2, ',', '.') }} ₺
                        </td>
                        <td class="px-4 py-3 text-gray-500 text-xs">
                            {{ $q->created_at->copy()->setTimezone('Europe/Istanbul')->format('d.m.Y H:i') }}
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <a href="{{ route('admin.asef.quotes.pdf', $q->id) }}" target="_blank"
                               class="inline-block px-3 py-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded text-xs font-medium">PDF</a>
                            <a href="{{ route('admin.asef.quotes.edit', $q->id) }}"
                               class="inline-block px-3 py-1 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded text-xs font-medium">Duzenle</a>
                            <form action="{{ route('admin.asef.quotes.destroy', $q->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Silmek istediginden emin misin?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-xs font-medium">Sil</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-16 text-center text-gray-500">
                        Henuz teklif olusturulmadi. Sag ustten <b>Yeni Teklif</b> ile ilk teklifi olustur.
                    </td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($quotes->hasPages())
        <div class="mt-4">{{ $quotes->links() }}</div>
    @endif
</x-admin::layouts>
