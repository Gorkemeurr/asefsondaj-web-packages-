<x-admin::layouts>
    <x-slot:title>{{ $mode === 'create' ? 'Yeni Ana Kategori' : 'Ana Kategori Düzenle' }} — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                {{ $mode === 'create' ? 'Yeni Ana Kategori' : 'Düzenle: ' . $item->name }}
            </p>
        </div>
        <a href="{{ route('admin.asef.categories.ana.index') }}"
           class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm">
            ← Geri
        </a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('admin.asef.categories.ana.store') : route('admin.asef.categories.ana.update', $item->code) }}"
          method="POST"
          class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 space-y-5 max-w-2xl">
        @csrf
        @if($mode === 'edit') @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kod * <span class="text-xs text-gray-500">(sadece harf/rakam, ör: WLS, DTH)</span></label>
            @if($mode === 'edit')
                <input type="text" value="{{ $item->code }}" disabled
                       class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-500 font-mono uppercase" />
                <p class="text-xs text-gray-500 mt-1">Kod değiştirilemez — ürünler ve alt kategoriler bu koda bağlı.</p>
            @else
                <input type="text" name="code" value="{{ old('code') }}" required maxlength="20"
                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm font-mono uppercase" />
            @endif
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">İsim *</label>
            <input type="text" name="name" value="{{ old('name', $item->name) }}" required maxlength="200"
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sıralama <span class="text-xs text-gray-500">(küçük = önce)</span></label>
            <input type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}"
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Görsel dosya adı <span class="text-xs text-gray-500">(public/asef/ altında)</span></label>
            <input type="text" name="image" value="{{ old('image', $item->image) }}" maxlength="200"
                   placeholder="ör: karotier-hero.jpg"
                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">SEO İçerik (Kategori Sayfası Alt Bölümü)</label>
            <textarea name="seo_content" rows="12" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm font-mono">{{ old('seo_content', $item->seo_content) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Kategori sayfasında ürün listesinin ÜSTÜNDE görünen 300-600 kelimelik teknik SEO metni. HTML formatlı yaz: <code>&lt;h2&gt;</code>, <code>&lt;h3&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;ul&gt;&lt;li&gt;</code>. Boş bırakırsan config dosyasındaki varsayılan içerik gösterilir.</p>
        </div>

        <div class="flex items-center gap-3 pt-3">
            <button type="submit"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
                {{ $mode === 'create' ? 'Oluştur' : 'Kaydet' }}
            </button>
            <a href="{{ route('admin.asef.categories.ana.index') }}"
               class="px-5 py-2 text-gray-700 dark:text-gray-300 rounded-lg text-sm">
                İptal
            </a>
        </div>
    </form>
</x-admin::layouts>
