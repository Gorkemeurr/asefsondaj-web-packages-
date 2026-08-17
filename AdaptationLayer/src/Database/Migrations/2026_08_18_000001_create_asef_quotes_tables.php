<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * E-Fatura (Proforma / Fiyat Teklifi) sistemi tablolari.
 *
 * asef_quotes       : teklif basligi + musteri bilgileri + toplamlar
 * asef_quote_items  : teklif kalemleri (urun snapshot + adet + fiyat)
 *
 * Urun bilgilerini snapshot'lariz — urun sonra silinse/degisse bile
 * eski teklif oldugu haliyle tekrar PDF'e cevrilebilsin.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('asef_quotes', function (Blueprint $t) {
            $t->id();
            $t->string('quote_no', 32)->unique();
            // Musteri
            $t->string('customer_name', 200);
            $t->string('customer_phone', 40);
            $t->string('customer_company', 200)->nullable();
            $t->string('customer_position', 100)->nullable();
            $t->string('customer_city', 100)->nullable();
            $t->string('customer_district', 100)->nullable();
            $t->string('customer_email', 200)->nullable();
            $t->text('customer_note')->nullable();
            // Fiyatlandirma (TL, KDV haric giris)
            $t->unsignedTinyInteger('kdv_rate')->default(20);
            $t->decimal('subtotal', 14, 2)->default(0);
            $t->decimal('kdv_amount', 14, 2)->default(0);
            $t->decimal('grand_total', 14, 2)->default(0);
            $t->timestamps();

            $t->index('created_at');
        });

        Schema::create('asef_quote_items', function (Blueprint $t) {
            $t->id();
            $t->foreignId('quote_id')->constrained('asef_quotes')->cascadeOnDelete();
            $t->string('product_sku', 64)->nullable();
            $t->string('product_name', 255);
            $t->string('product_image', 255)->nullable();
            $t->unsignedInteger('quantity')->default(1);
            $t->decimal('unit_price', 12, 2)->default(0);
            $t->decimal('line_total', 14, 2)->default(0);
            $t->unsignedSmallInteger('sort')->default(0);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asef_quote_items');
        Schema::dropIfExists('asef_quotes');
    }
};
