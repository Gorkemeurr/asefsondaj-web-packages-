<x-admin::layouts>
    <x-slot:title>{{ $mode === 'create' ? 'Yeni Terim' : 'Terim Düzenle' }} — Sözlük | Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <p class="text-xl font-bold text-gray-800 dark:text-white">{{ $mode === 'create' ? 'Yeni Sözlük Terimi' : 'Terimi Düzenle' }}</p>
        <a href="{{ route('admin.asef.glossary.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm">← Geri</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('admin.asef.glossary.store') : route('admin.asef.glossary.update', $item->id) }}"
          method="POST" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 space-y-5 max-w-3xl">
        @csrf
        @if($mode === 'edit') @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Terim *</label>
            <input type="text" name="term" value="{{ old('term', $item->term) }}" required maxlength="200" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tanım *</label>
            <textarea name="definition" rows="6" required maxlength="2000" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">{{ old('definition', $item->definition) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sıralama</label>
                <input type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Yayın Durumu</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    <option value="1" @selected(old('is_active', $item->is_active ?? 1))>Yayında</option>
                    <option value="0" @selected(! old('is_active', $item->is_active ?? 1))>Gizli</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-3">
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">{{ $mode === 'create' ? 'Ekle' : 'Kaydet' }}</button>
            <a href="{{ route('admin.asef.glossary.index') }}" class="px-5 py-2 text-gray-700 dark:text-gray-300 rounded-lg text-sm">İptal</a>
        </div>
    </form>
</x-admin::layouts>
