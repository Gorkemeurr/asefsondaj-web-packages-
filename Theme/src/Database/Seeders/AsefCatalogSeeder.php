<?php

namespace AsefSondaj\Theme\Database\Seeders;

use AsefSondaj\Theme\Http\Controllers\AsefKatalogController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * AsefCatalogSeeder
 *
 * Idempotently seeds Bagisto categories + products from the Flutter app's
 * static catalog (AsefKatalogController::staticProducts).
 *
 * NOTE: Bagisto's product model is deep (attribute values in multiple tables).
 * This seeder does the MINIMUM to make products visible via the Bagisto admin
 * panel — SKU + name + category association. Full attribute population
 * (specs as EAV, images) should be done via Bagisto's admin importer or a
 * follow-up seeder in Faz 3B.
 */
class AsefCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->info('Asef Catalog Seeder starting…');

        $rootId = $this->ensureRootCategory();

        $catNames = ['Delici Ekipmanlar', 'Tij ve Borular', 'Pompa Sistemleri', 'Yedek Parça'];
        $catMap   = [];
        foreach ($catNames as $name) {
            $catMap[$name] = $this->upsertCategory($name, $rootId);
        }

        foreach (AsefKatalogController::staticProducts() as $p) {
            $this->upsertProduct($p, $catMap[$p['category']] ?? $rootId);
        }

        $this->command?->info('Asef Catalog Seeder done. ' . count(AsefKatalogController::staticProducts()) . ' products.');
    }

    protected function ensureRootCategory(): int
    {
        $root = DB::table('categories')->whereNull('parent_id')->orderBy('id')->first();
        if ($root) return $root->id;

        // Fallback: create root
        return DB::table('categories')->insertGetId([
            'position'         => 1,
            'status'           => 1,
            'display_mode'     => 'products_and_description',
            'parent_id'        => null,
            'additional'       => json_encode([]),
            '_lft'             => 1,
            '_rgt'             => 2,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }

    protected function upsertCategory(string $name, int $parentId): int
    {
        $slug = Str::slug($name);

        // Check if a translation with this slug already exists
        $existing = DB::table('category_translations')
            ->where('slug', $slug)->orWhere('name', $name)
            ->first();

        if ($existing) return $existing->category_id;

        $categoryId = DB::table('categories')->insertGetId([
            'position'     => 10,
            'status'       => 1,
            'display_mode' => 'products_and_description',
            'parent_id'    => $parentId,
            'additional'   => json_encode([]),
            '_lft'         => 0,
            '_rgt'         => 0,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // Insert translations for every enabled locale
        $locales = DB::table('locales')->pluck('code')->toArray();
        if (empty($locales)) $locales = ['tr', 'en'];

        foreach ($locales as $locale) {
            DB::table('category_translations')->insert([
                'category_id'      => $categoryId,
                'locale'           => $locale,
                'name'             => $name,
                'slug'             => $slug,
                'description'      => '',
                'meta_title'       => $name . ' — Asef Sondaj',
                'meta_description' => $name . ' kategorisindeki tüm ürünler.',
                'meta_keywords'    => strtolower($name) . ', asef sondaj',
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }

        return $categoryId;
    }

    protected function upsertProduct(array $p, int $categoryId): void
    {
        // Skip if SKU already exists
        $existing = DB::table('products')->where('sku', $p['sku'])->first();
        if ($existing) {
            $this->ensureCategoryLink($existing->id, $categoryId);
            return;
        }

        // Bagisto product row (bare minimum for "simple" type)
        $productId = DB::table('products')->insertGetId([
            'type'                => 'simple',
            'sku'                 => $p['sku'],
            'parent_id'           => null,
            'attribute_family_id' => 1,  // default family
            'additional'          => json_encode([]),
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        $this->ensureCategoryLink($productId, $categoryId);

        // Populate a few EAV attributes so the product renders in admin datagrid.
        // These attribute codes match Bagisto's default attribute definitions.
        $attrIds = $this->attributeIds();

        // name (attribute_value in product_attribute_values, text_value)
        $this->setAttributeValue($productId, $attrIds['name'] ?? 2, 'text_value', $p['name']);
        // url_key
        $this->setAttributeValue($productId, $attrIds['url_key'] ?? 3, 'text_value', Str::slug($p['name']) . '-' . strtolower($p['sku']));
        // status
        $this->setAttributeValue($productId, $attrIds['status'] ?? 8, 'boolean_value', 1);
        // description (short + long — same text)
        $this->setAttributeValue($productId, $attrIds['short_description'] ?? 6, 'text_value', $p['short']);
        $this->setAttributeValue($productId, $attrIds['description'] ?? 7, 'text_value', $p['desc']);
        // price (0 — hidden anyway)
        $this->setAttributeValue($productId, $attrIds['price'] ?? 11, 'float_value', 0.00);
        // cost
        $this->setAttributeValue($productId, $attrIds['cost'] ?? 12, 'float_value', 0.00);
        // weight
        $this->setAttributeValue($productId, $attrIds['weight'] ?? 25, 'float_value', 1.00);
        // tax_class_id
        $this->setAttributeValue($productId, $attrIds['tax_category_id'] ?? 24, 'integer_value', 1);
        // meta_title / description / keywords
        $this->setAttributeValue($productId, $attrIds['meta_title'] ?? 15, 'text_value', $p['name'] . ' — Asef Sondaj');
        $this->setAttributeValue($productId, $attrIds['meta_description'] ?? 16, 'text_value', $p['short']);
        $this->setAttributeValue($productId, $attrIds['meta_keywords'] ?? 17, 'text_value', strtolower($p['category']) . ', asef sondaj, sondaj ekipmanları');
    }

    protected function ensureCategoryLink(int $productId, int $categoryId): void
    {
        $exists = DB::table('product_categories')
            ->where('product_id', $productId)
            ->where('category_id', $categoryId)
            ->exists();
        if (!$exists) {
            DB::table('product_categories')->insert([
                'product_id'  => $productId,
                'category_id' => $categoryId,
            ]);
        }
    }

    protected array $attrCache = [];

    protected function attributeIds(): array
    {
        if (!empty($this->attrCache)) return $this->attrCache;
        $rows = DB::table('attributes')->pluck('id', 'code')->toArray();
        return $this->attrCache = $rows;
    }

    protected function setAttributeValue(int $productId, int $attributeId, string $column, mixed $value): void
    {
        // channel/locale scoping: Bagisto stores unscoped values with channel + locale null
        // For text fields with is_translatable=1 Bagisto expects per-locale entries; we
        // insert one for 'tr' locale + one channel-agnostic to be safe.
        $baseAttr = DB::table('attributes')->where('id', $attributeId)->first();
        if (!$baseAttr) return;

        $channelCode = $baseAttr->value_per_channel ?? 0 ? 'default' : null;
        $localeCode  = $baseAttr->value_per_locale  ?? 0 ? 'tr'      : null;

        $existing = DB::table('product_attribute_values')
            ->where('product_id', $productId)
            ->where('attribute_id', $attributeId)
            ->where(function ($q) use ($channelCode) {
                $channelCode ? $q->where('channel', $channelCode) : $q->whereNull('channel');
            })
            ->where(function ($q) use ($localeCode) {
                $localeCode ? $q->where('locale', $localeCode) : $q->whereNull('locale');
            })
            ->first();

        $data = [
            'product_id'    => $productId,
            'attribute_id'  => $attributeId,
            'channel'       => $channelCode,
            'locale'        => $localeCode,
            $column         => $value,
        ];

        if ($existing) {
            DB::table('product_attribute_values')->where('id', $existing->id)->update([$column => $value]);
        } else {
            try {
                DB::table('product_attribute_values')->insert($data);
            } catch (\Throwable $e) {
                // silent: schema drift; the essential 'sku' + product row exist regardless
            }
        }
    }
}
