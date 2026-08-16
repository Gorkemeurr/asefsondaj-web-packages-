<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 813 ürüne kategori + attrs bazlı unique description üretir.
 * Sadece description boş olan ürünlere yazar (mevcut manuel açıklama korunur).
 *
 * Uzman uyarısı: "scaled content abuse" — sabit template değil, attrs'a göre
 * dinamik cümle üretimi ile her ürüne özgün metin.
 */
return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('asef_products')) return;
        if (! Schema::hasColumn('asef_products', 'description')) return;

        $rows = DB::table('asef_products')
            ->where(function ($q) {
                $q->whereNull('description')->orWhere('description', '');
            })
            ->get(['id', 'sku', 'name', 'ana_code', 'alt_code', 'attrs']);

        foreach ($rows as $r) {
            $attrs = is_string($r->attrs) ? (json_decode($r->attrs, true) ?: []) : [];
            $desc = $this->generateDescription($r->name, $r->sku, $r->ana_code, $r->alt_code, $attrs);
            if ($desc) {
                DB::table('asef_products')->where('id', $r->id)->update(['description' => $desc]);
            }
        }
    }

    protected function generateDescription(string $name, string $sku, ?string $anaCode, ?string $altCode, array $attrs): string
    {
        $ebat = $attrs['ebat_sistem'] ?? '';
        $boy = $attrs['boy_uzunluk'] ?? '';
        $dishOD = $attrs['dis_cap_od_mm'] ?? '';
        $icID = $attrs['ic_cap_id_mm'] ?? '';
        $karotCap = $attrs['karot_capi_mm'] ?? '';
        $kuyuCap = $attrs['kuyu_capi_mm'] ?? '';
        $baglanti = $attrs['dis_baglanti'] ?? '';
        $malzeme = $attrs['malzeme_kaplama'] ?? '';
        $matkap = $attrs['matkap_derecesi'] ?? '';
        $sert = $attrs['kayac_sertligi'] ?? '';
        $tac = $attrs['tac_yuksekligi'] ?? '';
        $satis = $attrs['satis_birimi'] ?? '';

        // Attrs cümlesi (mevcut değerleri birleştir)
        $techParts = [];
        if ($ebat) $techParts[] = $ebat . ' sistemi';
        if ($boy) $techParts[] = $boy . ' uzunluğunda';
        if ($karotCap) $techParts[] = $karotCap . ' mm karot çapı';
        if ($kuyuCap) $techParts[] = $kuyuCap . ' mm kuyu çapı';
        if ($dishOD) $techParts[] = $dishOD . ' mm dış çap (OD)';
        if ($icID) $techParts[] = $icID . ' mm iç çap (ID)';
        if ($baglanti) $techParts[] = $baglanti . ' bağlantı';
        if ($malzeme) $techParts[] = $malzeme . ' malzeme';
        if ($matkap) $techParts[] = $matkap . ' matkap derecesi';
        if ($sert) $techParts[] = $sert . ' formasyon sertliği';
        if ($tac) $techParts[] = 'taç yüksekliği ' . $tac;

        $techSentence = $techParts ? '<strong>Teknik özellikler:</strong> ' . implode(', ', $techParts) . '.' : '';

        // Kategori bazlı bağlam cümlesi
        $ctx = $this->contextByCategory($anaCode, $altCode, $name);

        // Kullanım alanı — attrs'a göre
        $usage = $this->usageByAttrs($sert, $ebat, $anaCode);

        // Satış birimi cümlesi
        $unitSentence = $satis ? '<strong>Satış birimi:</strong> ' . $satis . '.' : '';

        $desc = trim(implode("\n\n", array_filter([
            "<p><strong>{$name}</strong> ({$sku}) — {$ctx}</p>",
            $techSentence ? "<p>{$techSentence}</p>" : '',
            $usage ? "<p>{$usage}</p>" : '',
            $unitSentence ? "<p>{$unitSentence}</p>" : '',
            "<p><strong>Sevkiyat ve destek:</strong> Türkiye geneli 81 ilde 2-5 iş günü sevkiyat. Teknik danışmanlık ve satış sonrası destek dahil. Teklif için WhatsApp: <a href=\"https://wa.me/905320542975\">0532 054 29 75</a>.</p>",
        ])));

        return $desc;
    }

    protected function contextByCategory(?string $anaCode, ?string $altCode, string $name): string
    {
        $anaMap = [
            'WLS' => 'wireline karotiyer sistemi bileşeni. DCDMA standardında maden ve jeoteknik sondaj operasyonları için özel tasarlanmıştır.',
            'DTS' => 'düz takım karotiyer sistemi ürünü. Konvansiyonel karot sondajında sığ ve orta derinlik uygulamaları için uygundur.',
            'DVD' => 'elmas veya vidye tabanlı sondaj kesici ürünü. Kaya sertliğine ve delik çapına göre optimize edilmiş kesici performansı sağlar.',
            'TMB' => 'sondaj tiji veya muhafaza borusu. Doğru bağlantı standardıyla kuyu operasyonunda güvenli ve verimli çalışma sağlar.',
            'AKS' => 'sondaj aksesuar ürünü. Ana ekipmanın performansını tamamlayarak saha operasyonunu güvenli ve akıcı kılar.',
            'ADP' => 'sondaj adaptörü. Farklı bağlantı standartlarına sahip ekipmanlar arasında geçiş sağlar.',
            'THL' => 'sondaj tahlisiyesi (kurtarma ekipmanı). Kuyuda sıkışan veya kopan ekipmanların çıkarılması için özel tasarlanmıştır.',
            'NUM' => 'numune alma ekipmanı. Jeoteknik etüt ve maden aramaları için laboratuvar analizine uygun numune sağlar.',
            'KDL' => 'kaya delgi ekipmanı. DTH veya rotary sondajda sert ve orta sertlikte formasyonlarda hızlı ilerleme sağlar.',
            'AEL' => 'sondaj sahasında kullanılan anahtar veya el aleti. Operasyon güvenliği ve verimi için ergonomik tasarım.',
            'KSN' => 'karot sandığı veya numune ekipmanı. Alınan kaya numunelerinin sırayla, kırılmadan saklanmasını sağlar.',
            'SKS' => 'sondaj kimyasalı. Çamur sistemi performansını optimize ederek formasyon stabilitesi ve kesik taşımayı iyileştirir.',
            'JEO' => 'jeoteknik ekipman. Zemin etüdü, standart penetrasyon testi ve zemin mekaniği araştırmaları için özel üretilmiştir.',
            'GVN' => 'sondaj güvenlik ekipmanı. Saha operasyonunda operatör güvenliği ve yasal zorunluluk için sertifikalıdır.',
            'SMK' => 'sondaj makinesi veya makine yedek parçası. Operasyon verimliliği ve makine ömrü için orijinal üretici garantisi.',
        ];
        return $anaMap[$anaCode] ?? 'profesyonel sondaj sektörü ürünü, orijinal üretici garantisi ve teknik destekle sunulmaktadır.';
    }

    protected function usageByAttrs(string $sert, string $ebat, ?string $anaCode): string
    {
        if ($sert) {
            return '<strong>Kullanım alanı:</strong> ' . $sert . ' formasyonlarda maden, su, jeotermal ve jeoteknik sondaj operasyonlarında tercih edilir.';
        }
        if ($ebat && in_array($anaCode, ['WLS', 'DTS'])) {
            return '<strong>Kullanım alanı:</strong> ' . $ebat . ' standardındaki karotiyer sistemleriyle uyumlu, maden arama ve jeoteknik zemin etüdü projelerinde yaygın kullanılır.';
        }
        if (in_array($anaCode, ['KDL'])) {
            return '<strong>Kullanım alanı:</strong> Su sondajı, inşaat kazık delme, maden arama ve jeotermal proje ilerleme aşamalarında etkin performans.';
        }
        return '';
    }

    public function down(): void
    {
        // Reversible değil — üretilmiş description'ları silmek riskli (manuel eklenenler karışabilir)
    }
};
