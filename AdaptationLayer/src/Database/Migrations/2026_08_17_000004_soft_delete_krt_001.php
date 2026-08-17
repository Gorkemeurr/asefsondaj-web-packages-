<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * CEO isteği: /urun/bwl-karotiyer-15-m (AS-KRT-001) frontend'den kaldır.
 * Soft delete — DB'de kayıt kalır, is_active=false.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('asef_products') || ! Schema::hasColumn('asef_products', 'is_active')) {
            return;
        }
        DB::table('asef_products')->where('sku', 'AS-KRT-001')->update(['is_active' => false]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('asef_products') || ! Schema::hasColumn('asef_products', 'is_active')) {
            return;
        }
        DB::table('asef_products')->where('sku', 'AS-KRT-001')->update(['is_active' => true]);
    }
};
