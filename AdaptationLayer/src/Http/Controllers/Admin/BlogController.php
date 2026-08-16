<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefBlog;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /** Mevcut Blade $store'daki 9 yazı — read-only listede referans için */
    protected const LEGACY_SLUGS = [
        'ekipman-secim-rehberi' => 'Sondaj Operasyonlarında Ekipman Seçimi (2026)',
        'dth-cekic-bakim'       => 'DTH Çekiç Bakımı: 5 Kritik Nokta',
        'sondaj-tiji-baglanti'  => 'Sondaj Tiji ve Bağlantı Standartları',
        'camur-pompa-verim'     => 'Çamur Pompası Performansı',
        'karot-hatalari'        => 'Karot Alma Hataları: 4 Vaka',
        'su-sondaji-mevzuat'    => 'Su Sondajı DSİ İzin Süreci',
        'yerustu-yeralti'       => 'Yerüstü ve Yeraltı Sondaj Karşılaştırması',
        'karotier-ipuclari'     => 'Karotier Seçimi HQ/NQ/PQ',
        'yedek-parca-stok'      => 'Sondaj Yedek Parça Planlaması',
    ];

    public function index()
    {
        $dbItems = AsefBlog::orderByDesc('published_at')->orderByDesc('sort')->get();

        return view('asef-adaptation::admin.blog.index', [
            'items' => $dbItems,
            'legacy' => self::LEGACY_SLUGS,
        ]);
    }

    public function create()
    {
        return view('asef-adaptation::admin.blog.form', [
            'item' => new AsefBlog(['is_active' => true, 'sort' => 0, 'author' => 'Asef Teknik Ekip']),
            'mode' => 'create',
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'slug'         => 'required|string|max:200|unique:asef_bloglar,slug|regex:/^[a-z0-9\-]+$/',
            'title'        => 'required|string|max:300',
            'cat'          => 'required|string|max:100',
            'lede'         => 'required|string|max:1000',
            'body'         => 'required|string',
            'image'        => 'nullable|string|max:200',
            'author'       => 'nullable|string|max:100',
            'read_time'    => 'nullable|string|max:30',
            'published_at' => 'nullable|date',
            'is_active'    => 'nullable|boolean',
            'sort'         => 'nullable|integer',
        ]);
        $data['author']    = $data['author'] ?? 'Asef Teknik Ekip';
        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $data['sort']      = $data['sort'] ?? 0;
        AsefBlog::create($data);

        return redirect()->route('admin.asef.blog.index')->with('success', 'Blog yazısı yayınlandı.');
    }

    public function edit(int $id)
    {
        $item = AsefBlog::findOrFail($id);
        return view('asef-adaptation::admin.blog.form', ['item' => $item, 'mode' => 'edit']);
    }

    public function update(Request $req, int $id)
    {
        $item = AsefBlog::findOrFail($id);
        $data = $req->validate([
            'title'        => 'required|string|max:300',
            'cat'          => 'required|string|max:100',
            'lede'         => 'required|string|max:1000',
            'body'         => 'required|string',
            'image'        => 'nullable|string|max:200',
            'author'       => 'nullable|string|max:100',
            'read_time'    => 'nullable|string|max:30',
            'published_at' => 'nullable|date',
            'is_active'    => 'nullable|boolean',
            'sort'         => 'nullable|integer',
        ]);
        $data['author']    = $data['author'] ?? 'Asef Teknik Ekip';
        $data['is_active'] = (bool) ($data['is_active'] ?? true);
        $data['sort']      = $data['sort'] ?? 0;
        $item->update($data);

        return redirect()->route('admin.asef.blog.index')->with('success', 'Blog yazısı güncellendi.');
    }

    public function destroy(int $id)
    {
        $item = AsefBlog::findOrFail($id);
        $item->delete();
        return redirect()->route('admin.asef.blog.index')->with('success', 'Blog yazısı silindi.');
    }
}
