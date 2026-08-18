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
     * 81 il — Turkce alfabetik siralanmis, plaka kodu ile eslesmis
     * (form dropdown'unda kullanilir). Anahtar = display adi, deger = plaka kodu.
     *
     * @return array<string,string>
     */
    public static function all(): array
    {
        return [
            'Adana'          => '01',
            'Adıyaman'       => '02',
            'Afyonkarahisar' => '03',
            'Ağrı'           => '04',
            'Aksaray'        => '68',
            'Amasya'         => '05',
            'Ankara'         => '06',
            'Antalya'        => '07',
            'Ardahan'        => '75',
            'Artvin'         => '08',
            'Aydın'          => '09',
            'Balıkesir'      => '10',
            'Bartın'         => '74',
            'Batman'         => '72',
            'Bayburt'        => '69',
            'Bilecik'        => '11',
            'Bingöl'         => '12',
            'Bitlis'         => '13',
            'Bolu'           => '14',
            'Burdur'         => '15',
            'Bursa'          => '16',
            'Çanakkale'      => '17',
            'Çankırı'        => '18',
            'Çorum'          => '19',
            'Denizli'        => '20',
            'Diyarbakır'     => '21',
            'Düzce'          => '81',
            'Edirne'         => '22',
            'Elazığ'         => '23',
            'Erzincan'       => '24',
            'Erzurum'        => '25',
            'Eskişehir'      => '26',
            'Gaziantep'      => '27',
            'Giresun'        => '28',
            'Gümüşhane'      => '29',
            'Hakkari'        => '30',
            'Hatay'          => '31',
            'Iğdır'          => '76',
            'Isparta'        => '32',
            'İstanbul'       => '34',
            'İzmir'          => '35',
            'Kahramanmaraş'  => '46',
            'Karabük'        => '78',
            'Karaman'        => '70',
            'Kars'           => '36',
            'Kastamonu'      => '37',
            'Kayseri'        => '38',
            'Kilis'          => '79',
            'Kırıkkale'      => '71',
            'Kırklareli'     => '39',
            'Kırşehir'       => '40',
            'Kocaeli'        => '41',
            'Konya'          => '42',
            'Kütahya'        => '43',
            'Malatya'        => '44',
            'Manisa'         => '45',
            'Mardin'         => '47',
            'Mersin'         => '33',
            'Muğla'          => '48',
            'Muş'            => '49',
            'Nevşehir'       => '50',
            'Niğde'          => '51',
            'Ordu'           => '52',
            'Osmaniye'       => '80',
            'Rize'           => '53',
            'Sakarya'        => '54',
            'Samsun'         => '55',
            'Siirt'          => '56',
            'Sinop'          => '57',
            'Sivas'          => '58',
            'Şanlıurfa'      => '63',
            'Şırnak'         => '73',
            'Tekirdağ'       => '59',
            'Tokat'          => '60',
            'Trabzon'        => '61',
            'Tunceli'        => '62',
            'Uşak'           => '64',
            'Van'            => '65',
            'Yalova'         => '77',
            'Yozgat'         => '66',
            'Zonguldak'      => '67',
        ];
    }

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
