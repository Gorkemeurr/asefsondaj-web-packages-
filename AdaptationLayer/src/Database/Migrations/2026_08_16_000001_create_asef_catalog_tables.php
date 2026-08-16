<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Asef Sondaj katalog tabloları.
 *
 * Bagisto core Product/Category tablolarına DOKUNMAZ — kendi flat
 * tablolarımızı yaratır. Site sayfaları ve admin panel bu tablolardan
 * okur; Bagisto EAV yerine hız + basitlik.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asef_ana_kategoriler', function (Blueprint $t) {
            $t->id();
            $t->string('code', 8)->unique();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('meta_title')->nullable();
            $t->string('image')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
            $t->index('sort');
        });

        Schema::create('asef_alt_kategoriler', function (Blueprint $t) {
            $t->id();
            $t->string('code', 8)->unique();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('parent_code', 8);
            $t->text('description')->nullable();
            $t->string('meta_title')->nullable();
            $t->string('image')->nullable();
            $t->unsignedInteger('sort')->default(0);
            $t->timestamps();
            $t->index('parent_code');
            $t->index('sort');
            $t->foreign('parent_code')
                ->references('code')->on('asef_ana_kategoriler')
                ->cascadeOnUpdate()->restrictOnDelete();
        });

        Schema::create('asef_products', function (Blueprint $t) {
            $t->id();
            $t->string('sku', 16)->unique();
            $t->string('name');
            $t->string('brand')->default('Asef Sondaj');
            $t->string('alt_code', 8);
            $t->string('ana_code', 8);
            $t->string('slug')->unique();
            $t->unsignedInteger('sort')->default(0);
            $t->text('description')->nullable();
            $t->string('meta_title')->nullable();
            $t->string('image')->nullable();
            $t->json('attrs')->nullable();  // teknik alanlar (dolu olanlar)
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->index('alt_code');
            $t->index('ana_code');
            $t->index('sort');
            $t->index('is_active');
            $t->fullText(['sku', 'name']);  // arama için
            $t->foreign('alt_code')
                ->references('code')->on('asef_alt_kategoriler')
                ->cascadeOnUpdate()->restrictOnDelete();
        });

        Schema::create('asef_ebat_ref', function (Blueprint $t) {
            $t->id();
            $t->string('ebat', 32)->unique();
            $t->string('sistem')->nullable();
            $t->string('karot_capi_mm')->nullable();
            $t->string('kuyu_capi_mm')->nullable();
            $t->string('tij_od_mm')->nullable();
            $t->string('tij_id_mm')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asef_products');
        Schema::dropIfExists('asef_alt_kategoriler');
        Schema::dropIfExists('asef_ana_kategoriler');
        Schema::dropIfExists('asef_ebat_ref');
    }
};
