<?php

namespace AsefSondaj\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class AsefHomeController extends Controller
{
    public function index(Request $request)
    {
        // Pull categories + counts from Bagisto DB. Fall back to a static list if DB not seeded.
        $categories = $this->fetchCategories();
        $featured   = $this->fetchFeaturedProducts();

        return view('asef-theme::shop.home.index', [
            'categories' => $categories,
            'featured'   => $featured,
        ]);
    }

    protected function fetchCategories(): array
    {
        $rows = [];
        try {
            $rows = DB::table('categories')
                ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
                ->where('categories.status', 1)
                ->where('categories.parent_id', '!=', null)
                ->where('category_translations.locale', 'tr')
                ->select(
                    'categories.id',
                    'categories.slug',
                    'category_translations.name'
                )
                ->distinct()
                ->get()
                ->map(fn ($c) => [
                    'id'    => $c->id,
                    'slug'  => $c->slug,
                    'name'  => $c->name,
                    'count' => DB::table('product_categories')->where('category_id', $c->id)->count(),
                    'image' => asset('asef-theme/images/products/'.$this->categoryImage($c->slug)),
                ])
                ->toArray();
        } catch (\Throwable $e) {
            $rows = [];
        }

        // Fallback (matches app's 4 categories exactly)
        if (empty($rows)) {
            $rows = [
                ['id' => 0, 'slug' => 'delici-ekipmanlar', 'name' => 'Delici Ekipmanlar', 'count' => 3, 'image' => asset('asef-theme/images/products/dth-hammer.jpg')],
                ['id' => 0, 'slug' => 'tij-ve-borular',    'name' => 'Tij ve Borular',    'count' => 2, 'image' => asset('asef-theme/images/products/drill-rods.jpg')],
                ['id' => 0, 'slug' => 'pompa-sistemleri',  'name' => 'Pompa Sistemleri',  'count' => 2, 'image' => asset('asef-theme/images/products/mud-pump.jpg')],
                ['id' => 0, 'slug' => 'yedek-parca',       'name' => 'Yedek Parça',       'count' => 1, 'image' => asset('asef-theme/images/products/dth-hammer.jpg')],
            ];
        }

        return $rows;
    }

    protected function fetchFeaturedProducts(): array
    {
        // Fall back to static featured list (app's 5 featured products)
        return [
            ['sku' => 'AS-DTH-040', 'name' => 'DTH Çekiç 4 İnç',           'category' => 'Delici Ekipmanlar', 'image' => asset('asef-theme/images/products/dth-hammer.jpg'),  'short' => 'Yüksek darbe enerjili profesyonel kuyu delme çekici.'],
            ['sku' => 'AS-BIT-152', 'name' => 'DTH Button Bit 6 İnç',      'category' => 'Delici Ekipmanlar', 'image' => asset('asef-theme/images/products/dth-hammer.jpg'),  'short' => 'Sert formasyonlar için karbür butonlu delici matkap.'],
            ['sku' => 'AS-TRI-215', 'name' => 'Tricone Matkap 8 1/2 İnç',  'category' => 'Delici Ekipmanlar', 'image' => asset('asef-theme/images/products/tricone-bit.jpg'), 'short' => 'Rotary sondaj için rulmanlı üç konili matkap.'],
            ['sku' => 'AS-ROD-300', 'name' => 'Sondaj Tiji 3 Metre',       'category' => 'Tij ve Borular',    'image' => asset('asef-theme/images/products/drill-rods.jpg'),  'short' => 'Yüksek tork aktarımı için hassas dişli sondaj tiji.'],
            ['sku' => 'AS-PMP-600', 'name' => 'Triplex Çamur Pompası',     'category' => 'Pompa Sistemleri',  'image' => asset('asef-theme/images/products/mud-pump.jpg'),    'short' => 'Sondaj devridaimi için yüksek basınçlı pompa ünitesi.'],
        ];
    }

    protected function categoryImage(string $slug): string
    {
        return match ($slug) {
            'delici-ekipmanlar' => 'dth-hammer.jpg',
            'tij-ve-borular'    => 'drill-rods.jpg',
            'pompa-sistemleri'  => 'mud-pump.jpg',
            'yedek-parca'       => 'dth-hammer.jpg',
            default             => 'dth-hammer.jpg',
        };
    }
}
