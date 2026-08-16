<?php

/**
 * Asef Sondaj — Bagisto Admin panel menu entries.
 *
 * Merges into 'menu.admin' config namespace via AdaptationServiceProvider.
 * Bagisto core menu.php dosyası dokunulmadan yeni menü grup + alt öğeler eklenir.
 */

return [
    [
        'key'   => 'asef',
        'name'  => 'Asef Sondaj',
        'route' => 'admin.asef.categories.ana.index',
        'sort'  => 3,
        'icon'  => 'icon-product',
    ],
    [
        'key'   => 'asef.categories',
        'name'  => 'Kategoriler',
        'route' => 'admin.asef.categories.ana.index',
        'sort'  => 1,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.categories.ana',
        'name'  => 'Ana Kategoriler',
        'route' => 'admin.asef.categories.ana.index',
        'sort'  => 1,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.categories.alt',
        'name'  => 'Alt Kategoriler',
        'route' => 'admin.asef.categories.alt.index',
        'sort'  => 2,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.products',
        'name'  => 'Ürünler',
        'route' => 'admin.asef.products.index',
        'sort'  => 2,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.blog',
        'name'  => 'Blog Yazıları',
        'route' => 'admin.asef.blog.index',
        'sort'  => 3,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.faqs',
        'name'  => 'SSS',
        'route' => 'admin.asef.faqs.index',
        'sort'  => 4,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.glossary',
        'name'  => 'Sözlük',
        'route' => 'admin.asef.glossary.index',
        'sort'  => 5,
        'icon'  => '',
    ],
    [
        'key'   => 'asef.settings',
        'name'  => 'Genel Ayarlar',
        'route' => 'admin.asef.settings.index',
        'sort'  => 6,
        'icon'  => '',
    ],
];
