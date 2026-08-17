<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sehire gore plaka kodu + sira numarasi. PDF dosya adi 34-01 gibi olusur.
 * plate_code: 01..81 (2 haneli TR plaka kodu), null olabilir (sehir girilmezse)
 * plate_seq : O plakadaki kacinci teklif (1'den baslar). Silme olsa bile forward-only.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('asef_quotes', function (Blueprint $t) {
            $t->string('plate_code', 2)->nullable()->after('customer_district');
            $t->unsignedInteger('plate_seq')->nullable()->after('plate_code');
            $t->index(['plate_code', 'plate_seq']);
        });
    }

    public function down(): void
    {
        Schema::table('asef_quotes', function (Blueprint $t) {
            $t->dropIndex(['plate_code', 'plate_seq']);
            $t->dropColumn(['plate_code', 'plate_seq']);
        });
    }
};
