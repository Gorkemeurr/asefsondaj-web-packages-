<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * CEO isteği (geri alma): AS-KRT-001 (BWL Karotiyer 1,5 m) yine aktif olsun.
 * Önceki 000004 migration'ı is_active=false yapmıştı — bu migration reaktive eder.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('asef_products') || ! Schema::hasColumn('asef_products', 'is_active')) {
            return;
        }
        DB::table('asef_products')->where('sku', 'AS-KRT-001')->update(['is_active' => true]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('asef_products') || ! Schema::hasColumn('asef_products', 'is_active')) {
            return;
        }
        DB::table('asef_products')->where('sku', 'AS-KRT-001')->update(['is_active' => false]);
    }
};
