<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Blog yazıları
        if (! Schema::hasTable('asef_bloglar')) {
            Schema::create('asef_bloglar', function (Blueprint $t) {
                $t->id();
                $t->string('slug', 200)->unique();
                $t->string('title', 300);
                $t->string('cat', 100)->index();  // Ekipman Rehberi, Vaka Çalışmaları, Sektör Trendleri, Teknik İpuçları
                $t->text('lede');
                $t->longText('body');  // HTML — admin rich editor
                $t->string('image', 200)->nullable();
                $t->string('author', 100)->default('Asef Teknik Ekip');
                $t->string('read_time', 30)->nullable();  // "12 dakika okuma"
                $t->date('published_at')->nullable();
                $t->boolean('is_active')->default(true)->index();
                $t->integer('sort')->default(0);
                $t->timestamps();
            });
        }

        // SSS
        if (! Schema::hasTable('asef_faqs')) {
            Schema::create('asef_faqs', function (Blueprint $t) {
                $t->id();
                $t->text('q');
                $t->longText('a');
                $t->boolean('is_active')->default(true)->index();
                $t->integer('sort')->default(0)->index();
                $t->timestamps();
            });
        }

        // Sözlük terimleri
        if (! Schema::hasTable('asef_glossary_terms')) {
            Schema::create('asef_glossary_terms', function (Blueprint $t) {
                $t->id();
                $t->string('term', 200)->unique();
                $t->text('definition');
                $t->boolean('is_active')->default(true)->index();
                $t->integer('sort')->default(0);
                $t->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asef_bloglar');
        Schema::dropIfExists('asef_faqs');
        Schema::dropIfExists('asef_glossary_terms');
    }
};
