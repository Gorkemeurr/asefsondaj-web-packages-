<?php

return [
    'brand' => [
        'name'     => 'Asef Sondaj',
        'tagline'  => 'Sondaj ekipmanları ve teknik çözümler',
        'url'      => 'https://www.asefsondaj.com',
    ],

    'contact' => [
        'whatsapp'      => '905320542975',
        'phone'         => '+90 532 054 29 75',
        'email'         => 'iletisim@asefsondaj.com',
        'support_email' => 'destek@asefsondaj.com',
        'address'       => 'Duaçınarı Mah. 1. Özgünay Sk No:10, Yıldırım/Bursa',
    ],

    'whatsapp' => [
        'default_message' => 'Merhaba, Asef Sondaj ekibi ile iletişime geçmek istiyorum.',
        'quote_template'  => "Merhaba, aşağıdaki ürünler için teklif almak istiyorum:\n\n:items\n\nİletişim bilgilerim: ",
    ],

    'nav' => [
        ['key' => 'home',     'label' => 'Ana Sayfa', 'url' => '/',          'icon' => 'home'],
        ['key' => 'catalog',  'label' => 'Katalog',   'url' => '/katalog',   'icon' => 'grid'],
        ['key' => 'quote',    'label' => 'Teklif',    'url' => '/teklif',    'icon' => 'cart'],
        ['key' => 'contact',  'label' => 'İletişim',  'url' => '/iletisim',  'icon' => 'chat'],
    ],
];
