<x-admin::layouts>
    <x-slot:title>{{ $mode === 'create' ? 'Yeni Blog' : 'Blog Düzenle' }} — Asef Sondaj</x-slot>

    <div class="flex items-center justify-between gap-4 mb-6">
        <div><p class="text-xl font-bold text-gray-800 dark:text-white">{{ $mode === 'create' ? 'Yeni Blog Yazısı' : 'Düzenle: ' . $item->title }}</p></div>
        <a href="{{ route('admin.asef.blog.index') }}" class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm">← Geri</a>
    </div>

    @if ($errors->any())
        <div class="mb-4 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg text-sm text-red-800 dark:text-red-200">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
        </div>
    @endif

    <form action="{{ $mode === 'create' ? route('admin.asef.blog.store') : route('admin.asef.blog.update', $item->id) }}"
          method="POST" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6 space-y-5 max-w-4xl">
        @csrf
        @if($mode === 'edit') @method('PUT') @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug (URL) *</label>
                @if($mode === 'edit')
                    <input type="text" value="{{ $item->slug }}" disabled class="w-full px-3 py-2 border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 rounded-lg text-sm text-gray-500 font-mono" />
                @else
                    <input type="text" name="slug" value="{{ old('slug') }}" required maxlength="200" pattern="[a-z0-9\-]+"
                           placeholder="ornek-blog-yazisi"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm font-mono" />
                    <p class="text-xs text-gray-500 mt-1">Sadece küçük harf, rakam, tire. URL: /blog/{slug}</p>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kategori *</label>
                <select name="cat" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    @foreach(['Ekipman Rehberi', 'Vaka Çalışmaları', 'Sektör Trendleri', 'Teknik İpuçları'] as $cat)
                        <option value="{{ $cat }}" @selected(old('cat', $item->cat) === $cat)>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Başlık *</label>
            <input type="text" name="title" value="{{ old('title', $item->title) }}" required maxlength="300" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Lede (Kısa Açıklama) *</label>
            <textarea name="lede" rows="3" required maxlength="1000" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">{{ old('lede', $item->lede) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Meta description + hero'da kullanılır. 150-300 karakter arası ideal.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body (İçerik — HTML) *</label>
            <textarea name="body" rows="20" required class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm font-mono" placeholder='<h2>Alt başlık</h2><p>Paragraf içerik...</p><ul><li>Madde</li></ul>'>{{ old('body', $item->body) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">HTML formatında yaz: <code>&lt;h2&gt;</code>, <code>&lt;p&gt;</code>, <code>&lt;ul&gt;</code>, <code>&lt;strong&gt;</code>, <code>&lt;a&gt;</code>. 1000-1500 kelime SEO için ideal.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Yazar</label>
                <input type="text" name="author" value="{{ old('author', $item->author ?? 'Asef Teknik Ekip') }}" maxlength="100" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Okuma süresi</label>
                <input type="text" name="read_time" value="{{ old('read_time', $item->read_time) }}" placeholder="10 dakika okuma" maxlength="30" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Yayın tarihi</label>
                <input type="date" name="published_at" value="{{ old('published_at', $item->published_at?->format('Y-m-d')) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Görsel dosya adı <span class="text-xs text-gray-500">(public/asef/)</span></label>
                <input type="text" name="image" value="{{ old('image', $item->image) }}" maxlength="200" placeholder="dth-hammer.jpg" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sıralama</label>
                <input type="number" name="sort" value="{{ old('sort', $item->sort ?? 0) }}" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Yayın Durumu</label>
                <select name="is_active" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-700 dark:bg-gray-800 rounded-lg text-sm">
                    <option value="1" @selected(old('is_active', $item->is_active ?? 1))>Yayında</option>
                    <option value="0" @selected(! old('is_active', $item->is_active ?? 1))>Taslak</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-3">
            <button type="submit" class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">{{ $mode === 'create' ? 'Yayınla' : 'Kaydet' }}</button>
            <a href="{{ route('admin.asef.blog.index') }}" class="px-5 py-2 text-gray-700 dark:text-gray-300 rounded-lg text-sm">İptal</a>
        </div>
    </form>
</x-admin::layouts>
