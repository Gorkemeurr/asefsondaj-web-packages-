<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * CEO'nun 17.08.2026 sabahı işaretlediği "bizde olmayan ürünleri"
 * frontend'den kaldır (soft delete: is_active=false).
 *
 * DB'de kayıtlar kalır — CEO ileride "geri getir" derse tek satır UPDATE
 * ile is_active=true yapılır. Slug/URL/görsel dokunulmadı.
 *
 * NOT: AS-MUH-003 (BW Muhafaza Borusu 1,5 m) belirsiz kaldı (bir ekranda
 * çarpı vardı bir ekranda yoktu) — bu listeye dahil EDİLMEDİ. Konservatif
 * yaklaşım: emin olunmayan üründen çekim, CEO net olarak isterse ekler.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('asef_products') || ! Schema::hasColumn('asef_products', 'is_active')) {
            return;
        }

        $skus = [
            'AS-DTH-001', 'AS-TRC-001',
            'AS-WTJ-009', 'AS-WTJ-010',
            'AS-KTJ-001', 'AS-KTJ-002', 'AS-KTJ-003', 'AS-KTJ-004',
            'AS-KTJ-008', 'AS-KTJ-009', 'AS-KTJ-010',
            'AS-JTJ-001', 'AS-JTJ-002',
            'AS-MUH-001', 'AS-MUH-002',
            'AS-MNS-001',
            'AS-KLY-005',
        ];

        DB::table('asef_products')
            ->whereIn('sku', $skus)
            ->update(['is_active' => false]);
    }

    public function down(): void
    {
        // Geri alma: aynı SKU'ları is_active=true yap
        if (! Schema::hasTable('asef_products') || ! Schema::hasColumn('asef_products', 'is_active')) {
            return;
        }

        $skus = [
            'AS-DTH-001', 'AS-TRC-001',
            'AS-WTJ-009', 'AS-WTJ-010',
            'AS-KTJ-001', 'AS-KTJ-002', 'AS-KTJ-003', 'AS-KTJ-004',
            'AS-KTJ-008', 'AS-KTJ-009', 'AS-KTJ-010',
            'AS-JTJ-001', 'AS-JTJ-002',
            'AS-MUH-001', 'AS-MUH-002',
            'AS-MNS-001',
            'AS-KLY-005',
        ];

        DB::table('asef_products')
            ->whereIn('sku', $skus)
            ->update(['is_active' => true]);
    }
};
