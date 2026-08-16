<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Mevcut 20 SSS + 50 sözlük terimini asef_faqs + asef_glossary_terms
 * tablolarına seed eder. Idempotent — sadece tablo boşsa insert eder.
 */
return new class extends Migration {
    public function up(): void
    {
        $this->seedFaqs();
        $this->seedGlossary();
    }

    protected function seedFaqs(): void
    {
        if (! Schema::hasTable('asef_faqs')) return;
        if (DB::table('asef_faqs')->exists()) return;  // Tablo dolu ise skip

        $seedFile = dirname(__DIR__, 2) . '/Config/asef-faq-seed.php';
        if (! is_file($seedFile)) return;

        $rows = require $seedFile;
        if (! is_array($rows)) return;

        $now = date('Y-m-d H:i:s');
        $sort = 0;
        foreach ($rows as $r) {
            if (empty($r['q']) || empty($r['a'])) continue;
            DB::table('asef_faqs')->insert([
                'q'          => $r['q'],
                'a'          => $r['a'],
                'is_active'  => true,
                'sort'       => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    protected function seedGlossary(): void
    {
        if (! Schema::hasTable('asef_glossary_terms')) return;
        if (DB::table('asef_glossary_terms')->exists()) return;

        $seedFile = dirname(__DIR__, 2) . '/Config/asef-glossary-seed.php';
        if (! is_file($seedFile)) return;

        $rows = require $seedFile;
        if (! is_array($rows)) return;

        $now = date('Y-m-d H:i:s');
        $sort = 0;
        foreach ($rows as $r) {
            if (empty($r['t']) || empty($r['d'])) continue;
            // Uniqueness — term column unique index; duplicate skip
            $exists = DB::table('asef_glossary_terms')->where('term', $r['t'])->exists();
            if ($exists) continue;

            DB::table('asef_glossary_terms')->insert([
                'term'       => $r['t'],
                'definition' => $r['d'],
                'is_active'  => true,
                'sort'       => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        // Reversible değil — seed edilen verileri manuel silme
    }
};
