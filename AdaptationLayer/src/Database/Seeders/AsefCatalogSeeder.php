<?php

namespace AsefSondaj\AdaptationLayer\Database\Seeders;

use AsefSondaj\AdaptationLayer\Models\AsefAltKategori;
use AsefSondaj\AdaptationLayer\Models\AsefAnaKategori;
use AsefSondaj\AdaptationLayer\Models\AsefProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Excel'den üretilen catalog.json'u DB'ye upsert eder.
 * Idempotent: 2. çalıştırmada 0 değişiklik olur (aynı veri).
 *
 * Sadece INSERT/UPDATE — DELETE YOK. Excel'de olmayan bir ürün DB'de
 * kalır (kullanıcı kararına bırakılır).
 *
 * Kullanım:
 *   php artisan db:seed --class=\AsefSondaj\AdaptationLayer\Database\Seeders\AsefCatalogSeeder
 *
 * Rapor tetiği (dry-run):
 *   ASEF_SEED_DRY_RUN=1 php artisan db:seed --class=...
 */
class AsefCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $dryRun = env('ASEF_SEED_DRY_RUN', false);
        $jsonPath = __DIR__ . '/../../Resources/data/catalog.json';

        if (! file_exists($jsonPath)) {
            $this->command->error("catalog.json not found at $jsonPath");
            return;
        }

        $data = json_decode(file_get_contents($jsonPath), true);
        if (! is_array($data)) {
            $this->command->error("catalog.json invalid");
            return;
        }

        $this->command->info(sprintf(
            'Katalog verisi: %d ana, %d alt, %d ürün, %d ebat ref',
            count($data['ana_kategoriler']),
            count($data['alt_kategoriler']),
            count($data['products']),
            count($data['ebat_ref']),
        ));
        if ($dryRun) $this->command->warn('DRY RUN — DB\'ye YAZILMAYACAK');

        DB::beginTransaction();

        // === ANA KATEGORİLER ===
        $anaNew = 0; $anaUpd = 0; $anaSame = 0;
        foreach ($data['ana_kategoriler'] as $r) {
            $existing = AsefAnaKategori::where('code', $r['code'])->first();
            $payload = [
                'code'        => $r['code'],
                'name'        => $r['name'],
                'slug'        => $r['slug'],
                'description' => $r['description'] ?: null,
                'meta_title'  => $r['meta_title'] ?: null,
                'image'       => $r['image'] ?: null,
                'sort'        => $r['sort'],
            ];
            if (! $existing) { $anaNew++; if (!$dryRun) AsefAnaKategori::create($payload); }
            elseif ($this->diff($existing, $payload)) { $anaUpd++; if (!$dryRun) $existing->update($payload); }
            else $anaSame++;
        }
        $this->command->info("Ana kategori: yeni=$anaNew, güncellenen=$anaUpd, değişmeyen=$anaSame");

        // === ALT KATEGORİLER ===
        $altNew = 0; $altUpd = 0; $altSame = 0;
        foreach ($data['alt_kategoriler'] as $r) {
            $existing = AsefAltKategori::where('code', $r['code'])->first();
            $payload = [
                'code'        => $r['code'],
                'name'        => $r['name'],
                'slug'        => $r['slug'],
                'parent_code' => $r['parent_code'],
                'description' => $r['description'] ?: null,
                'meta_title'  => $r['meta_title'] ?: null,
                'image'       => $r['image'] ?: null,
                'sort'        => $r['sort'],
            ];
            if (! $existing) { $altNew++; if (!$dryRun) AsefAltKategori::create($payload); }
            elseif ($this->diff($existing, $payload)) { $altUpd++; if (!$dryRun) $existing->update($payload); }
            else $altSame++;
        }
        $this->command->info("Alt kategori: yeni=$altNew, güncellenen=$altUpd, değişmeyen=$altSame");

        // === ÜRÜNLER ===
        $prodNew = 0; $prodUpd = 0; $prodSame = 0;
        foreach ($data['products'] as $r) {
            $existing = AsefProduct::where('sku', $r['sku'])->first();
            $payload = [
                'sku'         => $r['sku'],
                'name'        => $r['name'],
                'brand'       => $r['brand'],
                'alt_code'    => $r['alt_code'],
                'ana_code'    => $r['ana_code'],
                'slug'        => $r['slug'],
                'sort'        => $r['sort'],
                'description' => $r['description'] ?: null,
                'meta_title'  => $r['meta_title'] ?: null,
                'image'       => $r['image'] ?: null,
                'attrs'       => $r['attrs'],
                'is_active'   => true,
            ];
            if (! $existing) { $prodNew++; if (!$dryRun) AsefProduct::create($payload); }
            elseif ($this->diff($existing, $payload)) { $prodUpd++; if (!$dryRun) $existing->update($payload); }
            else $prodSame++;
        }
        $this->command->info("Ürün: yeni=$prodNew, güncellenen=$prodUpd, değişmeyen=$prodSame");

        // === EBAT REF ===
        if (Schema::hasTable('asef_ebat_ref')) {
            $ebatNew = 0; $ebatUpd = 0;
            foreach ($data['ebat_ref'] as $ebat => $r) {
                $payload = ['ebat' => $ebat] + $r;
                $existing = DB::table('asef_ebat_ref')->where('ebat', $ebat)->first();
                if (! $existing) { $ebatNew++; if (!$dryRun) DB::table('asef_ebat_ref')->insert($payload + ['created_at' => now(), 'updated_at' => now()]); }
                else { $ebatUpd++; if (!$dryRun) DB::table('asef_ebat_ref')->where('ebat', $ebat)->update($payload + ['updated_at' => now()]); }
            }
            $this->command->info("Ebat ref: yeni=$ebatNew, güncellenen=$ebatUpd");
        }

        if ($dryRun) {
            DB::rollBack();
            $this->command->warn('DRY RUN sona erdi — hiçbir değişiklik yapılmadı');
        } else {
            DB::commit();
            $this->command->info('✓ Katalog senkronize edildi');
        }
    }

    /**
     * Modeldeki mevcut değerler ile payload arasında fark var mı?
     * (JSON alanlar için normalized karşılaştırma)
     */
    private function diff($model, array $payload): bool
    {
        foreach ($payload as $k => $v) {
            $curr = $model->getAttribute($k);
            if ($k === 'attrs') {
                if (json_encode($curr) !== json_encode($v)) return true;
                continue;
            }
            if ((string) $curr !== (string) $v) return true;
        }
        return false;
    }
}
