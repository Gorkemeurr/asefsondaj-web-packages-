<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;
use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use AsefSondaj\AdaptationLayer\Models\AsefProduct;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UrunController extends Controller
{
    public function index(Request $req)
    {
        $anaFilter = $req->query('ana');
        $altFilter = $req->query('alt');
        $searchQuery = trim((string) $req->query('q', ''));

        $q = AsefProduct::query();
        if ($anaFilter) $q->where('ana_code', $anaFilter);
        if ($altFilter) $q->where('alt_code', $altFilter);
        if ($searchQuery) {
            $q->where(function ($sub) use ($searchQuery) {
                $sub->where('sku', 'like', '%' . $searchQuery . '%')
                    ->orWhere('name', 'like', '%' . $searchQuery . '%');
            });
        }

        $items = $q->orderBy('sort')->orderBy('sku')->paginate(30)->appends($req->query());
        $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();
        $altKategoriler = $anaFilter
            ? AsefAltKategori::where('parent_code', $anaFilter)->orderBy('sort')->get()
            : collect();

        return view('asef-adaptation::admin.urunler.index', compact(
            'items', 'anaKategoriler', 'altKategoriler', 'anaFilter', 'altFilter', 'searchQuery'
        ));
    }

    public function create()
    {
        $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();
        $altKategoriler = AsefAltKategori::orderBy('sort')->get();
        return view('asef-adaptation::admin.urunler.form', [
            'item' => new AsefProduct(['is_active' => true, 'sort' => 0, 'attrs' => []]),
            'mode' => 'create',
            'anaKategoriler' => $anaKategoriler,
            'altKategoriler' => $altKategoriler,
        ]);
    }

    public function store(Request $req)
    {
        $data = $req->validate([
            'sku' => 'required|string|max:40|unique:asef_products,sku',
            'name' => 'required|string|max:300',
            'ana_code' => 'required|string|exists:asef_ana_kategoriler,code',
            'alt_code' => 'required|string|exists:asef_alt_kategoriler,code',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:200',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'attrs_ebat_sistem' => 'nullable|string|max:100',
            'attrs_boy_uzunluk' => 'nullable|string|max:100',
        ]);

        $attrs = [];
        if (! empty($data['attrs_ebat_sistem'])) $attrs['ebat_sistem'] = $data['attrs_ebat_sistem'];
        if (! empty($data['attrs_boy_uzunluk'])) $attrs['boy_uzunluk'] = $data['attrs_boy_uzunluk'];

        AsefProduct::create([
            'sku' => strtoupper($data['sku']),
            'name' => $data['name'],
            'ana_code' => $data['ana_code'],
            'alt_code' => $data['alt_code'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'sort' => $data['sort'] ?? 0,
            'is_active' => (bool) ($data['is_active'] ?? true),
            'attrs' => $attrs,
        ]);

        return redirect()->route('admin.asef.products.index')
            ->with('success', 'Ürün oluşturuldu.');
    }

    public function edit(string $sku)
    {
        $item = AsefProduct::where('sku', $sku)->firstOrFail();
        $anaKategoriler = AsefAnaKategori::orderBy('sort')->get();
        $altKategoriler = AsefAltKategori::orderBy('sort')->get();
        return view('asef-adaptation::admin.urunler.form', [
            'item' => $item,
            'mode' => 'edit',
            'anaKategoriler' => $anaKategoriler,
            'altKategoriler' => $altKategoriler,
        ]);
    }

    public function update(Request $req, string $sku)
    {
        $item = AsefProduct::where('sku', $sku)->firstOrFail();
        $data = $req->validate([
            'name' => 'required|string|max:300',
            'ana_code' => 'required|string|exists:asef_ana_kategoriler,code',
            'alt_code' => 'required|string|exists:asef_alt_kategoriler,code',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:200',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
            'attrs_ebat_sistem' => 'nullable|string|max:100',
            'attrs_boy_uzunluk' => 'nullable|string|max:100',
        ]);

        $attrs = $item->attrs ?? [];
        $attrs['ebat_sistem'] = $data['attrs_ebat_sistem'] ?? null;
        $attrs['boy_uzunluk'] = $data['attrs_boy_uzunluk'] ?? null;
        $attrs = array_filter($attrs, fn ($v) => $v !== null && $v !== '');

        $item->update([
            'name' => $data['name'],
            'ana_code' => $data['ana_code'],
            'alt_code' => $data['alt_code'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'sort' => $data['sort'] ?? 0,
            'is_active' => (bool) ($data['is_active'] ?? true),
            'attrs' => $attrs,
        ]);

        return redirect()->route('admin.asef.products.index')
            ->with('success', 'Ürün güncellendi.');
    }

    public function destroy(string $sku)
    {
        $item = AsefProduct::where('sku', $sku)->firstOrFail();
        $item->delete();
        return redirect()->route('admin.asef.products.index')
            ->with('success', 'Ürün silindi.');
    }
}
