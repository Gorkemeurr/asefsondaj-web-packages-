<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AnaKategoriController extends Controller
{
    public function index()
    {
        $items = AsefAnaKategori::orderBy('sort')->orderBy('code')->get();
        return view('asef-adaptation::admin.kategoriler.ana-index', compact('items'));
    }

    public function create()
    {
        return view('asef-adaptation::admin.kategoriler.ana-form', [
            'item' => new AsefAnaKategori(),
            'mode' => 'create',
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'code' => 'required|string|max:20|unique:asef_ana_kategoriler,code',
            'name' => 'required|string|max:200',
            'sort' => 'nullable|integer',
            'image' => 'nullable|string|max:200',
            'seo_content' => 'nullable|string',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        AsefAnaKategori::create($data);

        return redirect()->route('admin.asef.categories.ana.index')
            ->with('success', 'Ana kategori oluşturuldu.');
    }

    public function edit(string $code)
    {
        $item = AsefAnaKategori::where('code', $code)->firstOrFail();
        return view('asef-adaptation::admin.kategoriler.ana-form', [
            'item' => $item,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $req, string $code)
    {
        $item = AsefAnaKategori::where('code', $code)->firstOrFail();
        $data = $req->validate([
            'name' => 'required|string|max:200',
            'sort' => 'nullable|integer',
            'image' => 'nullable|string|max:200',
            'seo_content' => 'nullable|string',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        $item->update($data);

        return redirect()->route('admin.asef.categories.ana.index')
            ->with('success', 'Ana kategori güncellendi.');
    }

    public function destroy(string $code)
    {
        $item = AsefAnaKategori::where('code', $code)->firstOrFail();

        // Alt kategorileri var mı kontrol et
        $altCount = \AsefSondaj\AdaptationLayer\Models\AsefAltKategori::where('parent_code', $code)->count();
        if ($altCount > 0) {
            return redirect()->route('admin.asef.categories.ana.index')
                ->with('error', "Bu ana kategoriye bağlı {$altCount} alt kategori var. Önce onları silmelisin.");
        }

        // Ürünleri var mı kontrol et
        $prodCount = \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('ana_code', $code)->count();
        if ($prodCount > 0) {
            return redirect()->route('admin.asef.categories.ana.index')
                ->with('error', "Bu ana kategoride {$prodCount} ürün var. Önce ürünleri başka kategoriye taşı.");
        }

        $item->delete();
        return redirect()->route('admin.asef.categories.ana.index')
            ->with('success', 'Ana kategori silindi.');
    }
}
