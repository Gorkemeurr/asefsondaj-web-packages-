<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsefQuote extends Model
{
    protected $table = 'asef_quotes';

    protected $fillable = [
        'quote_no',
        'customer_name', 'customer_phone', 'customer_company', 'customer_position',
        'customer_city', 'customer_district', 'customer_email', 'customer_note',
        'plate_code', 'plate_seq',
        'kdv_rate', 'subtotal', 'kdv_amount', 'grand_total',
    ];

    protected $casts = [
        'kdv_rate'   => 'integer',
        'plate_seq'  => 'integer',
        'subtotal'   => 'decimal:2',
        'kdv_amount' => 'decimal:2',
        'grand_total'=> 'decimal:2',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(AsefQuoteItem::class, 'quote_id')->orderBy('sort')->orderBy('id');
    }

    /**
     * Bir sehir icin bir sonraki plate_seq. Silme oldugunda gap birakir,
     * asla yeniden kullanmaz (forward-only).
     */
    public static function nextPlateSeq(string $plateCode): int
    {
        $max = static::where('plate_code', $plateCode)->max('plate_seq');
        return ((int) $max) + 1;
    }

    /**
     * PDF dosya adi icin plaka-sira etiketi: "34-01", "34-12", "05-04" ...
     * Fallback: quote_no (plaka yoksa).
     */
    public function plateLabel(): string
    {
        if ($this->plate_code && $this->plate_seq) {
            return $this->plate_code . '-' . str_pad((string) $this->plate_seq, 2, '0', STR_PAD_LEFT);
        }
        return $this->quote_no;
    }

    /**
     * Bir sonraki teklif numarasi: AS-YYYY-NNNN (yil basi 0001'den saymaya baslar).
     */
    public static function nextQuoteNo(): string
    {
        $year = date('Y');
        $prefix = 'AS-' . $year . '-';
        $last = static::where('quote_no', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('quote_no');

        $seq = 1;
        if ($last) {
            $parts = explode('-', $last);
            $seq = (int) end($parts) + 1;
        }
        return $prefix . str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Kalemlerden ara/kdv/genel toplami hesaplar (fiyatlar KDV haric girilir).
     *
     * Para matematigi kurallari:
     *  1) Her satir totali once yuvarlanir (2 desimal).
     *  2) Ara toplam yuvarlanmis satirlarin toplami — display'de gorunen
     *     kalemler ile toplam bire bir eslesir (1 kurus fark cikmaz).
     *  3) KDV ara toplamdan hesaplanir, yuvarlanir.
     *  4) Genel toplam iki yuvarlanmis degerin toplami.
     *
     * $items: [{quantity, unit_price}, ...]
     */
    public static function calcTotals(array $items, int $kdvRate = 20): array
    {
        $subtotal = 0.0;
        foreach ($items as $it) {
            $qty  = max(0, (int) ($it['quantity'] ?? 0));
            $unit = max(0.0, (float) ($it['unit_price'] ?? 0));
            // Satir totalini once yuvarla, sonra ara toplama ekle.
            $lineTotal = round($qty * $unit, 2);
            $subtotal += $lineTotal;
        }
        $subtotal = round($subtotal, 2);
        $kdvRate  = max(0, min(100, $kdvRate));
        $kdv      = round($subtotal * ($kdvRate / 100), 2);
        $grand    = round($subtotal + $kdv, 2);

        return [
            'subtotal'    => $subtotal,
            'kdv_amount'  => $kdv,
            'grand_total' => $grand,
        ];
    }
}
