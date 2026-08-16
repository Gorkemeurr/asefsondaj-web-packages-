<x-admin::layouts>
    <x-slot:title>Blog Yazıları — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6 flex-wrap">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">Blog Yazıları</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                {{ count($items) }} DB'de + {{ count($legacy) }} kod içinde
            </p>
        </div>
        <a href="{{ route('admin.asef.blog.create') }}"
           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
            + Yeni Blog Yazısı
        </a>
    </div>

    @if(session('success')) <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">{{ session('success') }}</div> @endif

    {{-- DB'deki yazılar --}}
    @if(count($items) > 0)
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden mb-6">
            <div class="px-4 py-2 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800 text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wide">
                DB'de Yönetilen (yeni ekledin/düzenledin)
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-gray-800">
                    <tr>
                        <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Slug</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Başlık</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Kategori</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Tarih</th>
                        <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Durum</th>
                        <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $p)
                        <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-4 py-3 font-mono text-xs text-blue-600 dark:text-blue-400">{{ $p->slug }}</td>
                            <td class="px-4 py-3 font-medium text-gray-800 dark:text-white">{{ $p->title }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $p->cat }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $p->published_at?->format('d.m.Y') ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @if($p->is_active)
                                    <span class="inline-block px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded text-xs">Yayında</span>
                                @else
                                    <span class="inline-block px-2 py-0.5 bg-gray-100 dark:bg-gray-800 text-gray-500 rounded text-xs">Taslak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ url('blog/' . $p->slug) }}" target="_blank" class="inline-block px-2 py-1 text-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 rounded text-xs">Görüntüle</a>
                                <a href="{{ route('admin.asef.blog.edit', $p->id) }}" class="inline-block px-3 py-1 text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded text-xs font-medium">Düzenle</a>
                                <form action="{{ route('admin.asef.blog.destroy', $p->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Silmek istediğinden emin misin?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="px-3 py-1 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded text-xs font-medium">Sil</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Legacy $store'daki 9 yazı --}}
    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="px-4 py-2 bg-yellow-50 dark:bg-yellow-900/20 border-b border-yellow-200 dark:border-yellow-800 text-xs font-medium text-yellow-800 dark:text-yellow-400 uppercase tracking-wide flex items-center gap-2">
            <span>⚠️</span>
            <span>Kod İçinde Sabit — Düzenlemek için henüz DB'ye taşınmadı (Faz 2b'de yapılacak)</span>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
                <tr>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Slug</th>
                    <th class="px-4 py-3 text-left font-medium text-gray-700 dark:text-gray-300">Başlık</th>
                    <th class="px-4 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Sayfa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($legacy as $slug => $title)
                    <tr class="border-b border-gray-100 dark:border-gray-800 last:border-0">
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $slug }}</td>
                        <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $title }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ url('blog/' . $slug) }}" target="_blank" class="text-blue-600 hover:underline text-xs">Görüntüle →</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin::layouts>
