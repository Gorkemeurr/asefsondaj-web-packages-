<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use AsefSondaj\AdaptationLayer\Models\AsefProduct;
use AsefSondaj\AdaptationLayer\Models\AsefQuote;
use AsefSondaj\AdaptationLayer\Models\AsefQuoteItem;
use AsefSondaj\AdaptationLayer\Support\TurkishPlateCodes;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

/**
 * E-Fatura Olustur (Proforma / Fiyat Teklifi)
 *
 * Admin panelinde /admin/asef/e-fatura altinda:
 * - Teklif liste, olustur, duzenle, sil
 * - PDF cikti (dompdf, Apple minimalist tasarim)
 * - Urun lookup (AJAX): kod/link/isim ile Asef katalogundan urun cek
 */
class QuoteController extends Controller
{
    public function index()
    {
        $quotes = AsefQuote::orderByDesc('created_at')->paginate(30);
        return view('asef-adaptation::admin.quotes.index', compact('quotes'));
    }

    public function create()
    {
        return view('asef-adaptation::admin.quotes.form', [
            'quote' => new AsefQuote(['kdv_rate' => 20]),
            'items' => [],
            'mode'  => 'create',
        ]);
    }

    public function store(Request $req)
    {
        $data = $this->validateInput($req);
        $items = $this->normalizeItems($data['items']);
        $totals = AsefQuote::calcTotals($items, (int) $data['kdv_rate']);

        // Plaka kodu + o sehir icin bir sonraki sira (sehir bulunmazsa null kalir)
        $plateCode = TurkishPlateCodes::codeFor($data['customer_city'] ?? null);
        $plateSeq  = $plateCode ? AsefQuote::nextPlateSeq($plateCode) : null;

        $quote = AsefQuote::create([
            'quote_no'          => AsefQuote::nextQuoteNo(),
            'customer_name'     => $data['customer_name'],
            'customer_phone'    => $data['customer_phone'],
            'customer_company'  => $data['customer_company'] ?? null,
            'customer_position' => $data['customer_position'] ?? null,
            'customer_city'     => $data['customer_city'] ?? null,
            'customer_district' => $data['customer_district'] ?? null,
            'customer_email'    => $data['customer_email'] ?? null,
            'customer_note'     => $data['customer_note'] ?? null,
            'plate_code'        => $plateCode,
            'plate_seq'         => $plateSeq,
            'kdv_rate'          => (int) $data['kdv_rate'],
            'subtotal'          => $totals['subtotal'],
            'kdv_amount'        => $totals['kdv_amount'],
            'grand_total'       => $totals['grand_total'],
        ]);

        $this->syncItems($quote, $items);

        return redirect()->route('admin.asef.quotes.edit', $quote->id)
            ->with('success', 'Teklif olusturuldu: ' . $quote->quote_no . ' (Fatura: ' . $quote->plateLabel() . ')');
    }

    public function edit(int $id)
    {
        $quote = AsefQuote::with('items')->findOrFail($id);
        return view('asef-adaptation::admin.quotes.form', [
            'quote' => $quote,
            'items' => $quote->items->toArray(),
            'mode'  => 'edit',
        ]);
    }

    public function update(Request $req, int $id)
    {
        $quote = AsefQuote::findOrFail($id);
        $data = $this->validateInput($req);
        $items = $this->normalizeItems($data['items']);
        $totals = AsefQuote::calcTotals($items, (int) $data['kdv_rate']);

        // Plaka: sehir degistiyse yeniden hesapla (yeni plaka + yeni seq).
        // Ayni sehir kaldiysa eski numara korunur.
        $update = [
            'customer_name'     => $data['customer_name'],
            'customer_phone'    => $data['customer_phone'],
            'customer_company'  => $data['customer_company'] ?? null,
            'customer_position' => $data['customer_position'] ?? null,
            'customer_city'     => $data['customer_city'] ?? null,
            'customer_district' => $data['customer_district'] ?? null,
            'customer_email'    => $data['customer_email'] ?? null,
            'customer_note'     => $data['customer_note'] ?? null,
            'kdv_rate'          => (int) $data['kdv_rate'],
            'subtotal'          => $totals['subtotal'],
            'kdv_amount'        => $totals['kdv_amount'],
            'grand_total'       => $totals['grand_total'],
        ];
        $newPlateCode = TurkishPlateCodes::codeFor($data['customer_city'] ?? null);
        if ($newPlateCode !== $quote->plate_code) {
            $update['plate_code'] = $newPlateCode;
            $update['plate_seq']  = $newPlateCode ? AsefQuote::nextPlateSeq($newPlateCode) : null;
        }
        $quote->update($update);

        $this->syncItems($quote, $items);

        return redirect()->route('admin.asef.quotes.edit', $quote->id)
            ->with('success', 'Teklif guncellendi.');
    }

    public function destroy(int $id)
    {
        $quote = AsefQuote::findOrFail($id);
        $quote->delete(); // cascade -> items
        return redirect()->route('admin.asef.quotes.index')
            ->with('success', 'Teklif silindi.');
    }

    /**
     * PDF cikisi — dompdf ile Apple minimalist tasarim.
     * ?download=1 -> attachment, aksi halde inline goruntule.
     */
    public function pdf(Request $req, int $id)
    {
        $quote = AsefQuote::with('items')->findOrFail($id);
        $pdf = Pdf::loadView('asef-adaptation::admin.quotes.pdf', [
            'quote' => $quote,
        ])->setPaper('a4', 'portrait')
          ->setOptions([
              // Turkce karakter destegi + font sub-setting
              'defaultFont'            => 'DejaVu Sans',
              'isRemoteEnabled'        => true,
              'isFontSubsettingEnabled'=> true,
              'isHtml5ParserEnabled'   => true,
              'chroot'                 => public_path(),
          ]);

        // Dosya adi: sehir plaka kodu + sira (34-01 gibi). Sehir yoksa quote_no fallback.
        $filename = $quote->plateLabel() . '.pdf';
        return $req->boolean('download')
            ? $pdf->download($filename)
            : $pdf->stream($filename);
    }

    /**
     * AJAX urun lookup — admin form'da kod/link/isim ile ara.
     * GET /admin/asef/e-fatura/product-lookup?q=AS-KRT-001
     *   veya ?q=/urun/bwl-karotiyer-15-m
     *   veya ?q=BWL Karotiyer
     */
    public function productLookup(Request $req): JsonResponse
    {
        $q = trim((string) $req->query('q', ''));
        if ($q === '') {
            return response()->json(['ok' => false, 'error' => 'Bos sorgu']);
        }

        // URL ise, son segmenti al (ornek: /urun/bwl-karotiyer-15-m)
        if (preg_match('#/urun/([A-Za-z0-9\-]+)#', $q, $m)) {
            $q = $m[1];
        }

        // Once slug, sonra SKU (case-insensitive), sonra isim ile ara
        $product = AsefProduct::where('slug', $q)
            ->orWhere('sku', strtoupper($q))
            ->orWhere('name', 'like', '%' . $q . '%')
            ->where('is_active', true)
            ->orderByRaw("CASE WHEN slug = ? THEN 0 WHEN sku = ? THEN 1 ELSE 2 END", [$q, strtoupper($q)])
            ->first();

        if (! $product) {
            return response()->json(['ok' => false, 'error' => 'Urun bulunamadi']);
        }

        return response()->json([
            'ok'   => true,
            'item' => [
                'sku'   => $product->sku,
                'name'  => $product->name,
                'image' => $product->image,       // dosya adi (snapshot)
                'image_url' => $product->imageUrl(),
                'slug'  => $product->slug,
            ],
        ]);
    }

    // ---------------------------------------------------------------

    private function validateInput(Request $req): array
    {
        return $req->validate([
            'customer_name'     => 'required|string|max:200',
            'customer_phone'    => 'required|string|max:40',
            'customer_company'  => 'nullable|string|max:200',
            'customer_position' => 'nullable|string|max:100',
            'customer_city'     => 'nullable|string|max:100',
            'customer_district' => 'nullable|string|max:100',
            'customer_email'    => 'nullable|email|max:200',
            'customer_note'     => 'nullable|string|max:5000',
            'kdv_rate'          => ['required', 'integer', Rule::in([0, 1, 10, 20])],
            'items'             => 'required|array|min:1',
            'items.*.product_sku'   => 'nullable|string|max:64',
            'items.*.product_name'  => 'required|string|max:255',
            'items.*.product_image' => 'nullable|string|max:255',
            'items.*.quantity'      => 'required|integer|min:1|max:999999',
            'items.*.unit_price'    => 'required|numeric|min:0|max:99999999.99',
        ]);
    }

    /**
     * Item satirlarini normalize et: line_total hesapla, sort ver.
     */
    private function normalizeItems(array $rawItems): array
    {
        $sort = 0;
        $out = [];
        foreach ($rawItems as $it) {
            $qty  = (int) ($it['quantity'] ?? 0);
            $unit = (float) ($it['unit_price'] ?? 0);
            if ($qty < 1) continue;
            $out[] = [
                'product_sku'   => $it['product_sku'] ?? null,
                'product_name'  => $it['product_name'],
                'product_image' => $it['product_image'] ?? null,
                'quantity'      => $qty,
                'unit_price'    => $unit,
                'line_total'    => round($qty * $unit, 2),
                'sort'          => $sort++,
            ];
        }
        return $out;
    }

    private function syncItems(AsefQuote $quote, array $items): void
    {
        // Basit yaklasim: eski satirlari sil, yenilerini yaz. Az kayit oldugu icin ok.
        AsefQuoteItem::where('quote_id', $quote->id)->delete();
        foreach ($items as $it) {
            $it['quote_id'] = $quote->id;
            AsefQuoteItem::create($it);
        }
    }
}
