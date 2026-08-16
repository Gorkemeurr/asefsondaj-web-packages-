<x-admin::layouts>
    <x-slot:title>{{ $mode === 'create' ? 'Yeni Ürün' : 'Ürün Düzenle' }} — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                {{ $mode === 'create' ? 'Yeni Ürün Ekle' : 'Düzenle: ' . $item->name }}
            </p>
            @if($mode === 'edit')
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">SKU: <span class="font-mono">{{ $item->sku }}</span></p>
            @endif
        </div>
        <a href="{{ route('admin.asef.products.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm">← Geri</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('admin.asef.products.store') : route('admin.asef.products.update', $item->sku) }}"
          method="POST" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 space-y-5 max-w-3xl">
        @csrf
        @if($mode === 'edit') @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SKU (Ürün Kodu) *</label>
                @if($mode === 'edit')
                    <input type="text" value="{{ $item->sku }}" disabled class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-500 font-mono uppercase" />
                @else
                    <input type="text" name="sku" value="{{ old('sku') }}" required maxlength="40" placeholder="AS-KRT-042" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm font-mono uppercase" />
                @endif
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Aktif</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    <option value="1" @selected(old('is_active', $item->is_active ?? 1))>Aktif</option>
                    <option value="0" @selected(! old('is_active', $item->is_active ?? 1))>Pasif</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ürün Adı *</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" required maxlength="300" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ana Kategori *</label>
                <select name="ana_code" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    <option value="">-- Seç --</option>
                    @foreach($anaKategoriler as $ana)
                        <option value="{{ $ana->code }}" @selected(old('ana_code', $item->ana_code) === $ana->code)>{{ $ana->code }} — {{ $ana->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alt Kategori *</label>
                <select name="alt_code" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    <option value="">-- Seç --</option>
                    @foreach($altKategoriler as $alt)
                        <option value="{{ $alt->code }}" @selected(old('alt_code', $item->alt_code) === $alt->code) data-parent="{{ $alt->parent_code }}">{{ $alt->code }} — {{ $alt->name }} ({{ $alt->parent_code }})</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ebat / Sistem</label>
                <input type="text" name="attrs_ebat_sistem" value="{{ old('attrs_ebat_sistem', $item->attrs['ebat_sistem'] ?? '') }}" maxlength="100" placeholder="ör: HQ 96 mm" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Boy / Uzunluk</label>
                <input type="text" name="attrs_boy_uzunluk" value="{{ old('attrs_boy_uzunluk', $item->attrs['boy_uzunluk'] ?? '') }}" maxlength="100" placeholder="ör: 3 metre" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Açıklama</label>
            <textarea name="description" rows="4" maxlength="2000" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sıralama</label>
                <input type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Görsel dosya adı <span class="text-xs text-gray-500">(public/asef/)</span></label>
                <input type="text" name="image" value="{{ old('image', $item->image) }}" maxlength="200" placeholder="ör: karotier-hq.jpg" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
        </div>

        <div class="flex items-center gap-3 pt-3">
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">{{ $mode === 'create' ? 'Oluştur' : 'Kaydet' }}</button>
            <a href="{{ route('admin.asef.products.index') }}" class="px-5 py-2 text-gray-700 dark:text-gray-300 rounded-lg text-sm">İptal</a>
        </div>
    </form>
</x-admin::layouts>
