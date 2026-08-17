<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * "karotier" → "karotiyer" standardizasyonu — DB tarafı.
 * Config/blade tarafı ilgili commit'lerde çözüldü ama admin panelinden
 * DB'ye seed edilmiş kategori SEO içerikleri, ayarlar, SSS ve sözlük
 * kayıtları hâlâ "karotier" içerebiliyor. Bu migration onları da düzeltir.
 *
 * DİKKAT: Slug kolonlarına dokunulmaz — sadece serbest metin alanları.
 * Blog slug'ı "karotier-ipuclari" olarak KORUNUYOR (bu column'lara migration
 * girmez; asef_bloglar tablosundaki slug ayrı).
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1) asef_ana_kategoriler.seo_content — kategori SEO metinleri
        if (Schema::hasTable('asef_ana_kategoriler') && Schema::hasColumn('asef_ana_kategoriler', 'seo_content')) {
            DB::statement(
                "UPDATE asef_ana_kategoriler
                 SET seo_content = REPLACE(REPLACE(seo_content, 'Karotier', 'Karotiyer'), 'karotier', 'karotiyer')
                 WHERE seo_content IS NOT NULL"
            );
        }

        // 2) asef_settings.value — genel ayarlar (hero_subtitle vb.)
        if (Schema::hasTable('asef_settings') && Schema::hasColumn('asef_settings', 'value')) {
            DB::statement(
                "UPDATE asef_settings
                 SET value = REPLACE(REPLACE(value, 'Karotier', 'Karotiyer'), 'karotier', 'karotiyer')
                 WHERE value IS NOT NULL"
            );
        }

        // 3) asef_faqs — q (soru) + a (cevap) alanları
        if (Schema::hasTable('asef_faqs')) {
            foreach (['q', 'a'] as $col) {
                if (Schema::hasColumn('asef_faqs', $col)) {
                    DB::statement("UPDATE asef_faqs SET {$col} = REPLACE(REPLACE({$col}, 'Karotier', 'Karotiyer'), 'karotier', 'karotiyer') WHERE {$col} IS NOT NULL");
                }
            }
        }

        // 4) asef_glossary_terms — term + definition
        if (Schema::hasTable('asef_glossary_terms')) {
            foreach (['term', 'definition'] as $col) {
                if (Schema::hasColumn('asef_glossary_terms', $col)) {
                    DB::statement("UPDATE asef_glossary_terms SET {$col} = REPLACE(REPLACE({$col}, 'Karotier', 'Karotiyer'), 'karotier', 'karotiyer') WHERE {$col} IS NOT NULL");
                }
            }
        }

        // 5) asef_products.description — ürün açıklamaları (varsa manuel yazılmış olabilir)
        if (Schema::hasTable('asef_products') && Schema::hasColumn('asef_products', 'description')) {
            DB::statement(
                "UPDATE asef_products
                 SET description = REPLACE(REPLACE(description, 'Karotier', 'Karotiyer'), 'karotier', 'karotiyer')
                 WHERE description IS NOT NULL"
            );
        }

        // 6) asef_bloglar — title + lede + body (blog gövde)
        //    NOT: asef_bloglar.slug KOLONUNA DOKUNULMAZ (karotier-ipuclari korunur).
        if (Schema::hasTable('asef_bloglar')) {
            foreach (['title', 'lede', 'body'] as $col) {
                if (Schema::hasColumn('asef_bloglar', $col)) {
                    DB::statement("UPDATE asef_bloglar SET {$col} = REPLACE(REPLACE({$col}, 'Karotier', 'Karotiyer'), 'karotier', 'karotiyer') WHERE {$col} IS NOT NULL");
                }
            }
        }
    }

    public function down(): void
    {
        // Geri alma yok — standardizasyon kararı geri döndürülmez.
    }
};
