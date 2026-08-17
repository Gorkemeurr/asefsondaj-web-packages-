<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * "Portkron" → "Pörtkron" DB standardizasyonu.
 *
 * Ürün adları, açıklamalar, kategori SEO içerikleri, ayarlar, SSS,
 * sözlük ve blog gövde metinlerinde "Portkron" varsa "Pörtkron" yapar.
 *
 * DİKKAT: SLUG'A DOKUNULMAZ (asef_products.slug = "portkron-vt" gibi
 * URL değerleri koruyor — bunlar URL-safe küçük harfli ASCII olmalı).
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1) asef_products — name + description
        if (Schema::hasTable('asef_products')) {
            foreach (['name', 'description'] as $col) {
                if (Schema::hasColumn('asef_products', $col)) {
                    DB::statement("UPDATE asef_products SET {$col} = REPLACE(REPLACE({$col}, 'Portkron', 'Pörtkron'), 'portkron', 'pörtkron') WHERE {$col} IS NOT NULL");
                }
            }
        }

        // 2) asef_ana_kategoriler.seo_content
        if (Schema::hasTable('asef_ana_kategoriler') && Schema::hasColumn('asef_ana_kategoriler', 'seo_content')) {
            DB::statement(
                "UPDATE asef_ana_kategoriler
                 SET seo_content = REPLACE(REPLACE(seo_content, 'Portkron', 'Pörtkron'), 'portkron', 'pörtkron')
                 WHERE seo_content IS NOT NULL"
            );
        }

        // 3) asef_settings.value
        if (Schema::hasTable('asef_settings') && Schema::hasColumn('asef_settings', 'value')) {
            DB::statement(
                "UPDATE asef_settings
                 SET value = REPLACE(REPLACE(value, 'Portkron', 'Pörtkron'), 'portkron', 'pörtkron')
                 WHERE value IS NOT NULL"
            );
        }

        // 4) asef_faqs.q + a
        if (Schema::hasTable('asef_faqs')) {
            foreach (['q', 'a'] as $col) {
                if (Schema::hasColumn('asef_faqs', $col)) {
                    DB::statement("UPDATE asef_faqs SET {$col} = REPLACE(REPLACE({$col}, 'Portkron', 'Pörtkron'), 'portkron', 'pörtkron') WHERE {$col} IS NOT NULL");
                }
            }
        }

        // 5) asef_glossary_terms.term + definition
        if (Schema::hasTable('asef_glossary_terms')) {
            foreach (['term', 'definition'] as $col) {
                if (Schema::hasColumn('asef_glossary_terms', $col)) {
                    DB::statement("UPDATE asef_glossary_terms SET {$col} = REPLACE(REPLACE({$col}, 'Portkron', 'Pörtkron'), 'portkron', 'pörtkron') WHERE {$col} IS NOT NULL");
                }
            }
        }

        // 6) asef_bloglar.title + lede + body
        //    NOT: asef_bloglar.slug KOLONUNA DOKUNULMAZ.
        if (Schema::hasTable('asef_bloglar')) {
            foreach (['title', 'lede', 'body'] as $col) {
                if (Schema::hasColumn('asef_bloglar', $col)) {
                    DB::statement("UPDATE asef_bloglar SET {$col} = REPLACE(REPLACE({$col}, 'Portkron', 'Pörtkron'), 'portkron', 'pörtkron') WHERE {$col} IS NOT NULL");
                }
            }
        }
    }

    public function down(): void
    {
        // Geri alma yok — standardizasyon kararı.
    }
};
