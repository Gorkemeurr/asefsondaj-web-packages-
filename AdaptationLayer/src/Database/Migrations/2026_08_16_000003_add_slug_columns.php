<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Adım 1: Sadece slug column ekle (autofill yok). Sonraki migration doldurur.
 * Bu ayrı migration ile risk minimize edilir.
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

        // Autofill — Türkçe folded slug (Karotier normalization ayrı migration'da)
        $this->fillSlugs();
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
            $rows = DB::table('asef_ana_kategoriler')->whereNull('slug')->get(['code', 'name']);
            foreach ($rows as $r) {
                $slug = $trFold($r->name);
                if ($slug === '') $slug = strtolower($r->code);
                if (DB::table('asef_ana_kategoriler')->where('slug', $slug)->where('code', '!=', $r->code)->exists()) {
                    $slug .= '-' . strtolower($r->code);
                }
                DB::table('asef_ana_kategoriler')->where('code', $r->code)->update(['slug' => $slug]);
            }
        }

        // Alt kategoriler
        if (Schema::hasTable('asef_alt_kategoriler')) {
            $rows = DB::table('asef_alt_kategoriler')->whereNull('slug')->get(['code', 'name']);
            foreach ($rows as $r) {
                $slug = $trFold($r->name);
                if ($slug === '') $slug = strtolower($r->code);
                if (DB::table('asef_alt_kategoriler')->where('slug', $slug)->where('code', '!=', $r->code)->exists()) {
                    $slug .= '-' . strtolower($r->code);
                }
                DB::table('asef_alt_kategoriler')->where('code', $r->code)->update(['slug' => $slug]);
            }
        }

        // Ürünler
        if (Schema::hasTable('asef_products')) {
            $rows = DB::table('asef_products')->whereNull('slug')->get(['sku', 'name']);
            foreach ($rows as $r) {
                $slug = $trFold($r->name);
                if ($slug === '') $slug = strtolower(str_replace(['_'], '-', $r->sku));
                if (DB::table('asef_products')->where('slug', $slug)->where('sku', '!=', $r->sku)->exists()) {
                    $slug .= '-' . strtolower(preg_replace('/[^a-z0-9]+/i', '-', $r->sku));
                }
                DB::table('asef_products')->where('sku', $r->sku)->update(['slug' => $slug]);
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
