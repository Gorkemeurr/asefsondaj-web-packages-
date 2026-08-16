<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;
use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AltKategoriController extends Controller
{
    public function index(Request $req)
    {
        $anaFilter = $req->query('ana');
        $q = AsefAltKategori::query()->orderBy('sort')->orderBy('code');
        if ($anaFilter) $q->where('parent_code', $anaFilter);

        $items = $q->get();
        $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();

        return view('asef-adaptation::admin.kategoriler.alt-index', compact('items', 'anaKategoriler', 'anaFilter'));
    }

    public function create()
    {
        $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();
        return view('asef-adaptation::admin.kategoriler.alt-form', [
            'item' => new AsefAltKategori(),
            'mode' => 'create',
            'anaKategoriler' => $anaKategoriler,
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'code' => 'required|string|max:20|unique:asef_alt_kategoriler,code',
            'name' => 'required|string|max:200',
            'parent_code' => 'required|string|exists:asef_ana_kategoriler,code',
            'sort' => 'nullable|integer',
            'image' => 'nullable|string|max:200',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        AsefAltKategori::create($data);

        return redirect()->route('admin.asef.categories.alt.index')
            ->with('success', 'Alt kategori oluşturuldu.');
    }

    public function edit(string $code)
    {
        $item = AsefAltKategori::where('code', $code)->firstOrFail();
        $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();
        return view('asef-adaptation::admin.kategoriler.alt-form', [
            'item' => $item,
            'mode' => 'edit',
            'anaKategoriler' => $anaKategoriler,
        ]);
    }

    public function update(Request $req, string $code)
    {
        $item = AsefAltKategori::where('code', $code)->firstOrFail();
        $data = $req->validate([
            'name' => 'required|string|max:200',
            'parent_code' => 'required|string|exists:asef_ana_kategoriler,code',
            'sort' => 'nullable|integer',
            'image' => 'nullable|string|max:200',
        ]);
        $data['sort'] = $data['sort'] ?? 0;
        $item->update($data);

        return redirect()->route('admin.asef.categories.alt.index')
            ->with('success', 'Alt kategori güncellendi.');
    }

    public function destroy(string $code)
    {
        $item = AsefAltKategori::where('code', $code)->firstOrFail();

        $prodCount = \AsefSondaj\AdaptationLayer\Models\AsefProduct::where('alt_code', $code)->count();
        if ($prodCount > 0) {
            return redirect()->route('admin.asef.categories.alt.index')
                ->with('error', "Bu alt kategoride {$prodCount} ürün var. Önce ürünleri başka alt kategoriye taşı.");
        }

        $item->delete();
        return redirect()->route('admin.asef.categories.alt.index')
            ->with('success', 'Alt kategori silindi.');
    }
}
