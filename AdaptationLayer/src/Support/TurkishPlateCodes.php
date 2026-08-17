<?php

namespace AsefSondaj\AdaptationLayer\Support;

/**
 * Turkiye 81 il — plaka kodu tablosu ve normalize helper'lari.
 *
 * Kullanim:
 *   TurkishPlateCodes::codeFor('Istanbul') -> '34'
 *   TurkishPlateCodes::codeFor('istanbul') -> '34'
 *   TurkishPlateCodes::codeFor('  Muğla ') -> '48'
 *   TurkishPlateCodes::codeFor('BURSA')    -> '16'
 *   TurkishPlateCodes::codeFor('sanliurfa')-> '63'
 *   TurkishPlateCodes::codeFor('')         -> null
 */
class TurkishPlateCodes
{
    /** @var array<string,string> normalize edilmis sehir adi -> plaka kodu */
    private const CODES = [
        'adana'          => '01',
        'adiyaman'       => '02',
        'afyonkarahisar' => '03',
        'afyon'          => '03', // eski/kisa yazim
        'agri'           => '04',
        'amasya'         => '05',
        'ankara'         => '06',
        'antalya'        => '07',
        'artvin'         => '08',
        'aydin'          => '09',
        'balikesir'      => '10',
        'bilecik'        => '11',
        'bingol'         => '12',
        'bitlis'         => '13',
        'bolu'           => '14',
        'burdur'         => '15',
        'bursa'          => '16',
        'canakkale'      => '17',
        'cankiri'        => '18',
        'corum'          => '19',
        'denizli'        => '20',
        'diyarbakir'     => '21',
        'edirne'         => '22',
        'elazig'         => '23',
        'erzincan'       => '24',
        'erzurum'        => '25',
        'eskisehir'      => '26',
        'gaziantep'      => '27',
        'antep'          => '27',
        'giresun'        => '28',
        'gumushane'      => '29',
        'hakkari'        => '30',
        'hatay'          => '31',
        'isparta'        => '32',
        'mersin'         => '33',
        'icel'           => '33', // eski ad
        'istanbul'       => '34',
        'izmir'          => '35',
        'kars'           => '36',
        'kastamonu'      => '37',
        'kayseri'        => '38',
        'kirklareli'     => '39',
        'kirsehir'       => '40',
        'kocaeli'        => '41',
        'izmit'          => '41', // yaygin kullanim
        'konya'          => '42',
        'kutahya'        => '43',
        'malatya'        => '44',
        'manisa'         => '45',
        'kahramanmaras'  => '46',
        'maras'          => '46',
        'mardin'         => '47',
        'mugla'          => '48',
        'mus'            => '49',
        'nevsehir'       => '50',
        'nigde'          => '51',
        'ordu'           => '52',
        'rize'           => '53',
        'sakarya'        => '54',
        'adapazari'      => '54', // yaygin kullanim
        'samsun'         => '55',
        'siirt'          => '56',
        'sinop'          => '57',
        'sivas'          => '58',
        'tekirdag'       => '59',
        'tokat'          => '60',
        'trabzon'        => '61',
        'tunceli'        => '62',
        'sanliurfa'      => '63',
        'urfa'           => '63',
        'usak'           => '64',
        'van'            => '65',
        'yozgat'         => '66',
        'zonguldak'      => '67',
        'aksaray'        => '68',
        'bayburt'        => '69',
        'karaman'        => '70',
        'kirikkale'      => '71',
        'batman'         => '72',
        'sirnak'         => '73',
        'bartin'         => '74',
        'ardahan'        => '75',
        'igdir'          => '76',
        'yalova'         => '77',
        'karabuk'        => '78',
        'kilis'          => '79',
        'osmaniye'       => '80',
        'duzce'          => '81',
    ];

    /**
     * Sehir adini plaka kodu iki haneye cevirir. Bulunamazsa null.
     */
    public static function codeFor(?string $city): ?string
    {
        if ($city === null) return null;
        $key = self::normalize($city);
        if ($key === '') return null;
        return self::CODES[$key] ?? null;
    }

    /**
     * Turkce karakterleri ASCII'ye cevir, kucuk harf, trim, tek bosluk.
     * "Muğla" -> "mugla" | "  ŞANLIURFA  " -> "sanliurfa"
     */
    public static function normalize(string $city): string
    {
        $s = trim($city);
        if ($s === '') return '';
        $map = [
            'ç'=>'c','Ç'=>'c','ğ'=>'g','Ğ'=>'g','ı'=>'i','İ'=>'i',
            'ö'=>'o','Ö'=>'o','ş'=>'s','Ş'=>'s','ü'=>'u','Ü'=>'u',
            'â'=>'a','Â'=>'a','î'=>'i','Î'=>'i','û'=>'u','Û'=>'u',
        ];
        $s = strtr($s, $map);
        $s = mb_strtolower($s, 'UTF-8');
        $s = preg_replace('/\s+/u', ' ', $s);
        // "izmir " gibi trailing bosluklari at, tirnak/noktalama at
        $s = preg_replace('/[^a-z0-9 ]/i', '', $s);
        $s = trim($s);
        return $s;
    }
}
