<?php

namespace AsefSondaj\AdaptationLayer\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsefProduct extends Model
{
    protected $table = 'asef_products';

    protected $fillable = [
        'sku', 'name', 'brand', 'alt_code', 'ana_code', 'slug', 'sort',
        'description', 'meta_title', 'image', 'attrs', 'is_active',
    ];

    protected $casts = [
        'attrs'     => 'array',
        'is_active' => 'boolean',
    ];

    public function altKategori(): BelongsTo
    {
        return $this->belongsTo(AsefAltKategori::class, 'alt_code', 'code');
    }

    public function anaKategori(): BelongsTo
    {
        return $this->belongsTo(AsefAnaKategori::class, 'ana_code', 'code');
    }

    public function getRouteKeyName(): string
    {
        return 'sku';
    }

    /**
     * Görsel yolu (public/asef/<image> veya placeholder).
     */
    public function imageUrl(): string
    {
        if (! empty($this->image)) {
            return url('asef/' . $this->image);
        }
        return url('asef/asef-hero-equipment.jpg');  // fallback
    }

    /**
     * Sadece dolu attribute'ları döner — ürün sayfasında satır göstermek için.
     * Boş / null olan alanlar hiç görünmez.
     */
    public function filledAttrs(): array
    {
        $labels = [
            'ebat_sistem'     => 'Ebat / Sistem',
            'karot_capi_mm'   => 'Karot Çapı',
            'kuyu_capi_mm'    => 'Kuyu Çapı',
            'dis_cap_od_mm'   => 'Dış Çap (OD)',
            'ic_cap_id_mm'    => 'İç Çap (ID)',
            'boy_uzunluk'     => 'Boy / Uzunluk',
            'dis_baglanti'    => 'Diş / Bağlantı',
            'malzeme_kaplama' => 'Malzeme / Kaplama',
            'matkap_derecesi' => 'Matkap Derecesi',
            'kayac_sertligi'  => 'Kayaç Sertliği',
            'tac_yuksekligi'  => 'Taç Yüksekliği',
            'teknik_not'      => 'Teknik Not',
            'satis_birimi'    => 'Satış Birimi',
        ];
        $units = [
            'karot_capi_mm'  => 'mm',
            'kuyu_capi_mm'   => 'mm',
            'dis_cap_od_mm'  => 'mm',
            'ic_cap_id_mm'   => 'mm',
            'tac_yuksekligi' => '',  // zaten Excel'de "10 mm" olarak yazılı
        ];
        $result = [];
        $attrs = $this->attrs ?? [];
        foreach ($labels as $key => $label) {
            $v = $attrs[$key] ?? null;
            if ($v === null || $v === '' ) continue;
            $unit = $units[$key] ?? '';
            // Ondalıkta virgül kullan (Türkçe format)
            $val  = str_replace('.', ',', (string) $v);
            $result[] = ['key' => $key, 'label' => $label, 'value' => $val, 'unit' => $unit];
        }
        return $result;
    }
}
