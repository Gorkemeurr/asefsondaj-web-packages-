<x-admin::layouts>
    <x-slot:title>Genel Ayarlar — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">Genel Ayarlar</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                Sitede kullanılan iletişim bilgileri, WhatsApp mesajı, hero başlıkları ve sayfa metinleri.
                Bir alanı değiştirdiğin an sitede tüm bağlı yerlerde anında güncellenir.
            </p>
        </div>
    </div>

    @if(session('success')) <div class="mb-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg text-sm text-green-800 dark:text-green-200">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">{{ session('error') }}</div> @endif

    <form action="{{ route('admin.asef.settings.update') }}" method="POST" class="max-w-4xl space-y-6">
        @csrf
        @method('PUT')

        @foreach($grouped as $groupKey => $groupItems)
            <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden">
                <div class="px-6 py-3 bg-gray-50 dark:bg-gray-800 border-b border-gray-200 dark:border-gray-800">
                    <p class="font-semibold text-gray-800 dark:text-white text-sm uppercase tracking-wide">
                        {{ $groupLabels[$groupKey] ?? ucfirst($groupKey) }}
                    </p>
                </div>
                <div class="p-6 space-y-5">
                    @foreach($groupItems as $s)
                        <div>
                            <label class="block text-sm font-medium text-gray-800 dark:text-white mb-1">{{ $s->label }}</label>
                            @if($s->type === 'textarea')
                                <textarea name="settings[{{ $s->key }}]" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">{{ $s->value }}</textarea>
                            @else
                                <input type="{{ in_array($s->type, ['url','tel','email']) ? $s->type : 'text' }}" name="settings[{{ $s->key }}]" value="{{ $s->value }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
                            @endif
                            @if($s->help)
                                <p class="text-xs text-gray-500 mt-1">{{ $s->help }}</p>
                            @endif
                            <p class="text-xs text-gray-400 mt-1 font-mono">key: {{ $s->key }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="sticky bottom-4 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-lg">
            <button type="submit" class="w-full px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">Tüm Ayarları Kaydet</button>
        </div>
    </form>
</x-admin::layouts>
