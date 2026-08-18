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
        // Tiji urunlerinde (TIJ kategori) "Malzeme / Kaplama" ve "Teknik Not"
        // alanlari boilerplate ("Sementasyon / isil islemli" + "Erkek dis
        // induksiyonla sertlestirilmistir") — kullaniciya deger katmiyor,
        // teknik bilgi gridini kalabaliklastiriyor. TIJ icin bu iki alan gizli.
        $hiddenKeysByAna = [
            'TIJ' => ['malzeme_kaplama', 'teknik_not'],
        ];
        $hiddenKeys = $hiddenKeysByAna[$this->ana_code] ?? [];

        // Belirli alan-deger kombinasyonlari tum urunlerde gizli.
        // "Standart celik" gibi generic placeholder degerler kullaniciya
        // bilgi katmiyor — herhangi bir urunun teknik ozelliklerinde
        // gorunmesin. Karsilastirma diakritik ve buyuk-kucuk harf duyarsiz.
        // Substring match (contains). Normalized deger bu tokenlerden birini
        // icerirse alan gizlenir. "Kromajlı (Cr, Plated)", "Kromajlı",
        // "Krom Kapli" gibi tum varyantlar tek "kromajli" veya "krom" ile yakalanir.
        $hiddenValueSubstringsByKey = [
            'malzeme_kaplama' => [
                'standart celik',
                'kromajli',
                'cr plated',
                'krom kapli',
                'chrome',
            ],
        ];

        $result = [];
        $attrs = $this->attrs ?? [];
        foreach ($labels as $key => $label) {
            if (in_array($key, $hiddenKeys, true)) continue;
            $v = $attrs[$key] ?? null;
            if ($v === null || $v === '' ) continue;

            // Alan-deger blocklist (substring match)
            if (isset($hiddenValueSubstringsByKey[$key])) {
                $normalized = self::normalizeValue((string) $v);
                $skip = false;
                foreach ($hiddenValueSubstringsByKey[$key] as $needle) {
                    if ($needle !== '' && strpos($normalized, $needle) !== false) {
                        $skip = true;
                        break;
                    }
                }
                if ($skip) continue;
            }

            $unit = $units[$key] ?? '';
            // Ondalıkta virgül kullan (Türkçe format)
            $val  = str_replace('.', ',', (string) $v);
            $result[] = ['key' => $key, 'label' => $label, 'value' => $val, 'unit' => $unit];
        }
        return $result;
    }

    /**
     * Deger karsilastirmasi icin normalize eder: Turkce diakritikleri
     * ASCII'ye cevirir, kucuk harfe indirir, noktalama/parantez atar,
     * whitespace'i tekilleştirir.
     *
     * "Standart Çelik ", "STANDART ÇELİK", "standart  celik"        -> "standart celik"
     * "Kromajli (Cr, Plated)", "KROMAJLI CR PLATED", "kromajli cr"  -> "kromajli cr plated" / "kromajli cr"
     */
    private static function normalizeValue(string $v): string
    {
        $s = trim($v);
        if ($s === '') return '';
        $map = [
            'ç'=>'c','Ç'=>'c','ğ'=>'g','Ğ'=>'g','ı'=>'i','İ'=>'i',
            'ö'=>'o','Ö'=>'o','ş'=>'s','Ş'=>'s','ü'=>'u','Ü'=>'u',
            'â'=>'a','Â'=>'a','î'=>'i','Î'=>'i','û'=>'u','Û'=>'u',
        ];
        $s = strtr($s, $map);
        $s = mb_strtolower($s, 'UTF-8');
        // Noktalama/parantez/tire/slash -> bosluk
        $s = preg_replace('/[^a-z0-9]+/u', ' ', $s);
        return trim($s);
    }
}
