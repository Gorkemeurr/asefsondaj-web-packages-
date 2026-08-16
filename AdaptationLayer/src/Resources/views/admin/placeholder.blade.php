<x-admin::layouts>
    <x-slot:title>{{ $title }} — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $title }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">{{ $desc }}</p>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
        <p class="text-sm text-gray-700 dark:text-gray-300 mb-4">
            <strong>Şu anki durum:</strong> Bu içerik hâlâ Blade template içinde tutuluyor.
            Aşama 2'de DB'ye taşınacak ve buradan tam CRUD ile yönetebileceksin.
        </p>

        @if(! empty($items))
            <div class="mt-6 border-t border-gray-200 dark:border-gray-800 pt-6">
                <p class="font-medium text-gray-800 dark:text-white mb-3">Şu anda yayında:</p>
                <ul class="space-y-2">
                    @foreach($items as $it)
                        <li class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg text-sm">
                            <span class="text-gray-700 dark:text-gray-300">{{ $it['sıra'] ?? '' }}. {{ $it['başlık'] ?? '' }}</span>
                            @if(! empty($it['url']))
                                <a href="{{ url($it['url']) }}" target="_blank" class="text-blue-600 hover:underline text-xs">
                                    Sayfayı gör →
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</x-admin::layouts>
