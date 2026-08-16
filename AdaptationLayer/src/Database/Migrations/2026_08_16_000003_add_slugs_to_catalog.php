<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Add SEO-friendly Turkish slugs to catalog tables.
 * Auto-generate slugs from name/sku on first run.
 */
return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('asef_ana_kategoriler') && ! Schema::hasColumn('asef_ana_kategoriler', 'slug')) {
            Schema::table('asef_ana_kategoriler', function (Blueprint $t) {
                $t->string('slug', 200)->nullable()->after('code')->index();
            });
        }

        if (Schema::hasTable('asef_alt_kategoriler') && ! Schema::hasColumn('asef_alt_kategoriler', 'slug')) {
            Schema::table('asef_alt_kategoriler', function (Blueprint $t) {
                $t->string('slug', 200)->nullable()->after('code')->index();
            });
        }

        if (Schema::hasTable('asef_products') && ! Schema::hasColumn('asef_products', 'slug')) {
            Schema::table('asef_products', function (Blueprint $t) {
                $t->string('slug', 250)->nullable()->after('sku')->index();
            });
        }

        // Standard yazım: Karotier → Karotiyer (Türkçe resmi kullanım)
        $this->standardizeNaming();

        // Auto-generate slugs
        $this->fillSlugs();
    }

    protected function standardizeNaming(): void
    {
        // Kategori ve ürün isimlerinde 'Karotier' → 'Karotiyer'
        foreach (['asef_ana_kategoriler', 'asef_alt_kategoriler', 'asef_products'] as $table) {
            if (! Schema::hasTable($table)) continue;
            $col = 'name';
            DB::table($table)
                ->where($col, 'like', '%Karotier%')
                ->orderBy($table === 'asef_products' ? 'sku' : 'code')
                ->chunkById(200, function ($rows) use ($table, $col) {
                    foreach ($rows as $row) {
                        $new = str_replace(['Karotier', 'karotier', 'KAROTIER'], ['Karotiyer', 'karotiyer', 'KAROTİYER'], $row->{$col});
                        DB::table($table)->where(['id' => $row->id])->update([$col => $new]);
                    }
                }, 'id');
        }
    }

    protected function fillSlugs(): void
    {
        $trFold = static function (string $s): string {
            $s = mb_strtolower($s, 'UTF-8');
            $s = strtr($s, ['ç'=>'c','ş'=>'s','ı'=>'i','ğ'=>'g','ö'=>'o','ü'=>'u','â'=>'a','î'=>'i','û'=>'u']);
            $s = preg_replace('/[^a-z0-9\s\-]/', '', $s);
            $s = preg_replace('/[\s\-]+/', '-', $s);
            return trim($s, '-');
        };

        // Ana kategoriler
        if (Schema::hasTable('asef_ana_kategoriler')) {
            $anas = DB::table('asef_ana_kategoriler')->whereNull('slug')->get();
            foreach ($anas as $a) {
                $slug = $trFold($a->name);
                // Uniqueness: eğer aynı slug varsa code ekle
                if (DB::table('asef_ana_kategoriler')->where('slug', $slug)->where('code', '!=', $a->code)->exists()) {
                    $slug .= '-' . strtolower($a->code);
                }
                DB::table('asef_ana_kategoriler')->where('code', $a->code)->update(['slug' => $slug]);
            }
        }

        // Alt kategoriler
        if (Schema::hasTable('asef_alt_kategoriler')) {
            $alts = DB::table('asef_alt_kategoriler')->whereNull('slug')->get();
            foreach ($alts as $al) {
                $slug = $trFold($al->name);
                if (DB::table('asef_alt_kategoriler')->where('slug', $slug)->where('code', '!=', $al->code)->exists()) {
                    $slug .= '-' . strtolower($al->code);
                }
                DB::table('asef_alt_kategoriler')->where('code', $al->code)->update(['slug' => $slug]);
            }
        }

        // Ürünler
        if (Schema::hasTable('asef_products')) {
            $products = DB::table('asef_products')->whereNull('slug')->get(['sku', 'name']);
            foreach ($products as $p) {
                $slug = $trFold($p->name);
                if ($slug === '') $slug = strtolower(str_replace(['_'], '-', $p->sku));
                // Uniqueness: eğer aynı slug varsa SKU'nun son parçasını ekle
                if (DB::table('asef_products')->where('slug', $slug)->where('sku', '!=', $p->sku)->exists()) {
                    $lastPart = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $p->sku));
                    $slug .= '-' . $lastPart;
                }
                DB::table('asef_products')->where('sku', $p->sku)->update(['slug' => $slug]);
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('asef_products') && Schema::hasColumn('asef_products', 'slug')) {
            Schema::table('asef_products', fn (Blueprint $t) => $t->dropColumn('slug'));
        }
        if (Schema::hasTable('asef_alt_kategoriler') && Schema::hasColumn('asef_alt_kategoriler', 'slug')) {
            Schema::table('asef_alt_kategoriler', fn (Blueprint $t) => $t->dropColumn('slug'));
        }
        if (Schema::hasTable('asef_ana_kategoriler') && Schema::hasColumn('asef_ana_kategoriler', 'slug')) {
            Schema::table('asef_ana_kategoriler', fn (Blueprint $t) => $t->dropColumn('slug'));
        }
    }
};
