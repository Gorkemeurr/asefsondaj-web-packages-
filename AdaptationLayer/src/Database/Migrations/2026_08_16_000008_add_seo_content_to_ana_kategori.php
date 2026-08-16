<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Ana kategori tablosuna seo_content (LONGTEXT) column ekle.
 * Kategori sayfası altında görünen 300-600 kelimelik teknik SEO metni.
 * Config/kategori-seo-content.php dosyasındaki mevcut içerik DB'ye seed edilir.
 */
return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('asef_ana_kategoriler')) return;

        if (! Schema::hasColumn('asef_ana_kategoriler', 'seo_content')) {
            Schema::table('asef_ana_kategoriler', function (Blueprint $t) {
                $t->longText('seo_content')->nullable()->after('description');
            });
        }

        $this->seedFromConfig();
    }

    protected function seedFromConfig(): void
    {
        $configFile = dirname(__DIR__, 2) . '/Config/kategori-seo-content.php';
        if (! is_file($configFile)) return;

        $seoAll = require $configFile;
        if (! is_array($seoAll)) return;

        foreach ($seoAll as $code => $html) {
            // Sadece boş olan kategorilere yaz (mevcut manuel içerik korunur)
            DB::table('asef_ana_kategoriler')
                ->where('code', $code)
                ->where(function ($q) {
                    $q->whereNull('seo_content')->orWhere('seo_content', '');
                })
                ->update(['seo_content' => $html]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('asef_ana_kategoriler') && Schema::hasColumn('asef_ana_kategoriler', 'seo_content')) {
            Schema::table('asef_ana_kategoriler', fn (Blueprint $t) => $t->dropColumn('seo_content'));
        }
    }
};
