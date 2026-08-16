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

    /** Tüm attrs alanları — form + validation için tek yerde tanımlı */
    protected const ATTR_KEYS = [
        'ebat_sistem', 'boy_uzunluk', 'karot_capi_mm', 'kuyu_capi_mm',
        'dis_cap_od_mm', 'ic_cap_id_mm', 'dis_baglanti', 'malzeme_kaplama',
        'matkap_derecesi', 'kayac_sertligi', 'tac_yuksekligi', 'satis_birimi',
        'teknik_not',
    ];

    protected function buildAttrsFromRequest(array $data): array
    {
        $attrs = [];
        foreach (self::ATTR_KEYS as $k) {
            $formKey = 'attrs_' . $k;
            if (! empty($data[$formKey])) {
                $attrs[$k] = $data[$formKey];
            }
        }
        return $attrs;
    }

    protected function attrValidationRules(): array
    {
        $rules = [];
        foreach (self::ATTR_KEYS as $k) {
            $rules['attrs_' . $k] = 'nullable|string|max:500';
        }
        return $rules;
    }

    public function store(Request $req)
    {
        $data = $req->validate(array_merge([
            'sku' => 'required|string|max:40|unique:asef_products,sku',
            'name' => 'required|string|max:300',
            'ana_code' => 'required|string|exists:asef_ana_kategoriler,code',
            'alt_code' => 'required|string|exists:asef_alt_kategoriler,code',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:200',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], $this->attrValidationRules()));

        AsefProduct::create([
            'sku' => strtoupper($data['sku']),
            'name' => $data['name'],
            'ana_code' => $data['ana_code'],
            'alt_code' => $data['alt_code'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
            'sort' => $data['sort'] ?? 0,
            'is_active' => (bool) ($data['is_active'] ?? true),
            'attrs' => $this->buildAttrsFromRequest($data),
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
        $data = $req->validate(array_merge([
            'name' => 'required|string|max:300',
            'ana_code' => 'required|string|exists:asef_ana_kategoriler,code',
            'alt_code' => 'required|string|exists:asef_alt_kategoriler,code',
            'description' => 'nullable|string',
            'image' => 'nullable|string|max:200',
            'sort' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ], $this->attrValidationRules()));

        // Mevcut attrs'i koru, form'dan gelenlerle merge et
        $attrs = $item->attrs ?? [];
        foreach (self::ATTR_KEYS as $k) {
            $formKey = 'attrs_' . $k;
            if (array_key_exists($formKey, $data)) {
                $val = $data[$formKey] ?? null;
                if ($val === null || $val === '') {
                    unset($attrs[$k]);
                } else {
                    $attrs[$k] = $val;
                }
            }
        }

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
