<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Asef Sondaj Brand
    |--------------------------------------------------------------------------
    */
    'brand' => [
        'name'        => 'Asef Sondaj',
        'description' => 'Sondaj ekipmanları, yedek parça ve teknik çözüm ortağınız',
        'url'         => 'https://www.asefsondaj.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Contact Info (mirrors the mobile app)
    |--------------------------------------------------------------------------
    */
    'contact' => [
        'whatsapp'      => '905320542975',   // digits only, wa.me format
        'phone'         => '+90 532 054 29 75',
        'email'         => 'iletisim@asefsondaj.com',
        'support_email' => 'destek@asefsondaj.com',
        'address'       => 'Duaçınarı Mah. 1. Özgünay Sk No:10, Yıldırım/Bursa',
    ],

    /*
    |--------------------------------------------------------------------------
    | Feature Flags (adapt storefront to catalog-only + WhatsApp quote flow)
    |--------------------------------------------------------------------------
    */
    'features' => [
        'hide_prices'          => true,
        'block_checkout'       => true,
        'block_customer_flows' => true,
        'block_wishlist'       => true,
        'block_orders'         => true,
        'show_quote_button'    => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Blocked URL prefixes (relative to storefront root)
    | Requests whose path starts with any of these get redirected to home.
    | Admin routes (prefix "admin") are always excluded.
    |--------------------------------------------------------------------------
    */
    'blocked_prefixes' => [
        'checkout',
        'cart',
        'customer/register',
        'customer/login',
        'customer/forgot-password',
        'customer/reset-password',
        'customer/session',
        'customer/account',
        'account',
        'orders',
        'wishlist',
        'compare',
        'notifications',
    ],

    /*
    |--------------------------------------------------------------------------
    | Redirect target when a blocked route is hit
    | 'home'   -> redirect(url('/'))
    | 'abort'  -> abort(404)
    |--------------------------------------------------------------------------
    */
    'blocked_action' => 'home',

    /*
    |--------------------------------------------------------------------------
    | WhatsApp quote message template
    | Placeholders: :product_name, :sku, :url
    |--------------------------------------------------------------------------
    */
    'whatsapp' => [
        'quote_message_template' => 'Merhaba, bu ürün hakkında teklif almak istiyorum: :product_name (:sku) - :url',
    ],
];
