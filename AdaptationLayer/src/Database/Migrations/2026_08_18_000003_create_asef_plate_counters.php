<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Sehir plaka kodu basina teklif sayaci — gercek forward-only garantisi.
 *
 * Neden ayri tablo?
 *   Onceden nextPlateSeq() MAX(plate_seq) ile hesapliyordu. Bir teklif hard-delete
 *   edildiginde (AsefQuote'da SoftDeletes yok) sayac geriye dusuyordu:
 *   Kars 36-01 olustur -> sil -> yeni Kars -> 36-01 tekrar (bug).
 *
 *   Ayri sayac tablosu, teklif kayitlarindan bagimsiz olarak monotonik artar.
 *   Silme, restore, taruncatlama fark etmez — 34 ili icin sayac 100'e ulastiysa
 *   bir sonraki 101 olur, hep boyle kalir.
 *
 * Seed:
 *   Mevcut asef_quotes tablosundaki her plate_code icin MAX(plate_seq) ile baslatilir.
 *   Boylece varolan teklifler kayipsiz devam eder.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::create('asef_plate_counters', function (Blueprint $t) {
            $t->string('plate_code', 2)->primary();
            $t->unsignedInteger('last_seq')->default(0);
            $t->timestamps();
        });

        // Mevcut tekliflerden sayaclari seed et — kayipsiz gecis.
        if (Schema::hasTable('asef_quotes')
            && Schema::hasColumn('asef_quotes', 'plate_code')
            && Schema::hasColumn('asef_quotes', 'plate_seq')) {
            $rows = DB::table('asef_quotes')
                ->whereNotNull('plate_code')
                ->whereNotNull('plate_seq')
                ->groupBy('plate_code')
                ->selectRaw('plate_code, MAX(plate_seq) as max_seq')
                ->get();

            $now = now();
            foreach ($rows as $row) {
                DB::table('asef_plate_counters')->insertOrIgnore([
                    'plate_code' => $row->plate_code,
                    'last_seq'   => (int) $row->max_seq,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asef_plate_counters');
    }
};
