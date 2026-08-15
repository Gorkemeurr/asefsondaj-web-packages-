<?php

namespace AsefSondaj\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AsefKatalogController extends Controller
{
    public function index(Request $request, ?string $category = null)
    {
        // Static app-parity dataset (mirrors Flutter asef_catalog.dart).
        // In Faz 3B this will pull live from Bagisto products table.
        $all = $this->staticProducts();

        $categories = ['Tümü', 'Delici Ekipmanlar', 'Tij ve Borular', 'Pompa Sistemleri', 'Yedek Parça'];

        $selected = $request->query('kategori', $category ? $this->categoryFromSlug($category) : 'Tümü');
        $search   = trim((string) $request->query('q', ''));

        $products = collect($all)
            ->when($selected !== 'Tümü', fn ($c) => $c->where('category', $selected))
            ->when($search !== '', fn ($c) => $c->filter(function ($p) use ($search) {
                $needle = mb_strtolower($search, 'UTF-8');
                return str_contains(mb_strtolower($p['name'], 'UTF-8'), $needle)
                    || str_contains(mb_strtolower($p['sku'], 'UTF-8'), $needle);
            }))
            ->values()
            ->all();

        return view('asef-theme::shop.categories.view', [
            'products'   => $products,
            'categories' => $categories,
            'selected'   => $selected,
            'search'     => $search,
            'total'      => count($products),
        ]);
    }

    protected function categoryFromSlug(string $slug): string
    {
        return match ($slug) {
            'delici-ekipmanlar' => 'Delici Ekipmanlar',
            'tij-ve-borular'    => 'Tij ve Borular',
            'pompa-sistemleri'  => 'Pompa Sistemleri',
            'yedek-parca'       => 'Yedek Parça',
            default             => 'Tümü',
        };
    }

    /**
     * Static catalog — mirrors Flutter asef_catalog.dart line-for-line.
     */
    public static function staticProducts(): array
    {
        $img = fn ($f) => asset('asef-theme/images/products/'.$f);

        return [
            [
                'id' => 'dth-hammer-4', 'sku' => 'AS-DTH-040', 'name' => 'DTH Çekiç 4 İnç',
                'category' => 'Delici Ekipmanlar', 'image' => $img('dth-hammer.jpg'),
                'short' => 'Yüksek darbe enerjili profesyonel kuyu delme çekici.',
                'desc'  => 'Su kuyusu, maden ve jeotermal sondaj operasyonlarında istikrarlı ilerleme için tasarlanmış, servis edilebilir DTH çekiç sistemi.',
                'applications' => ['Su kuyusu', 'Jeotermal', 'Maden arama'],
                'specs' => ['Çekiç sınıfı' => '4 inç', 'Çalışma basıncı' => '10-24 bar', 'Bağlantı' => 'API 2 3/8 REG', 'Gövde' => 'Isıl işlemli alaşımlı çelik'],
                'featured' => true,
            ],
            [
                'id' => 'dth-button-bit-6', 'sku' => 'AS-BIT-152', 'name' => 'DTH Button Bit 6 İnç',
                'category' => 'Delici Ekipmanlar', 'image' => $img('dth-hammer.jpg'),
                'short' => 'Sert formasyonlar için karbür butonlu delici matkap.',
                'desc'  => 'Dengeli hava dağılımı ve optimize edilmiş buton yerleşimi sayesinde sert kaya formasyonlarında düzgün delik geometrisi sağlar.',
                'applications' => ['Sert kaya', 'Kuyu genişletme', 'DTH delgi'],
                'specs' => ['Çap' => '152 mm', 'Yüz tipi' => 'Konveks', 'Buton' => 'Tungsten karbür', 'Uyumlu şank' => 'DHD 340'],
                'featured' => true,
            ],
            [
                'id' => 'tricone-8-5', 'sku' => 'AS-TRI-215', 'name' => 'Tricone Matkap 8 1/2 İnç',
                'category' => 'Delici Ekipmanlar', 'image' => $img('tricone-bit.jpg'),
                'short' => 'Rotary sondaj için rulmanlı üç konili matkap.',
                'desc'  => 'Orta ve sert formasyonlarda yüksek kesme verimi sunan, akışkan kanalları optimize edilmiş dayanıklı tricone matkap.',
                'applications' => ['Rotary sondaj', 'Su kuyusu', 'Jeotermal'],
                'specs' => ['Çap' => '215.9 mm', 'Bağlantı' => 'API 4 1/2 REG', 'Rulman' => 'Sızdırmaz yatak', 'Formasyon' => 'Orta - sert'],
                'featured' => true,
            ],
            [
                'id' => 'drill-rod-3m', 'sku' => 'AS-ROD-300', 'name' => 'Sondaj Tiji 3 Metre',
                'category' => 'Tij ve Borular', 'image' => $img('drill-rods.jpg'),
                'short' => 'Yüksek tork aktarımı için hassas dişli sondaj tiji.',
                'desc'  => 'Düzgünlük toleransı ve hassas işlenmiş diş yapısı ile uzun servis ömrü ve güvenilir tork aktarımı için üretilmiştir.',
                'applications' => ['Rotary sistem', 'DTH sistem', 'Kuyu sondajı'],
                'specs' => ['Uzunluk' => '3.000 mm', 'Dış çap' => '76 / 89 / 102 mm', 'Bağlantı' => 'API seçenekli', 'Malzeme' => 'Alaşımlı çelik'],
                'featured' => true,
            ],
            [
                'id' => 'casing-pipe-6', 'sku' => 'AS-CAS-168', 'name' => 'Muhafaza Borusu 6 5/8 İnç',
                'category' => 'Tij ve Borular', 'image' => $img('drill-rods.jpg'),
                'short' => 'Kuyu stabilitesi için ağır hizmet muhafaza borusu.',
                'desc'  => 'Çökme riski bulunan zeminlerde kuyu cidarını korumak için yüksek dayanımlı çelikten ve kontrollü dış toleranslarıyla üretilir.',
                'applications' => ['Kuyu muhafaza', 'Gevşek zemin', 'Jeotermal'],
                'specs' => ['Dış çap' => '168.3 mm', 'Et kalınlığı' => '7.1 mm', 'Boy' => '3 / 6 metre', 'Bağlantı' => 'Manşonlu'],
                'featured' => false,
            ],
            [
                'id' => 'triplex-mud-pump', 'sku' => 'AS-PMP-600', 'name' => 'Triplex Çamur Pompası',
                'category' => 'Pompa Sistemleri', 'image' => $img('mud-pump.jpg'),
                'short' => 'Sondaj devridaimi için yüksek basınçlı pompa ünitesi.',
                'desc'  => 'Değişken saha koşullarında kararlı debi sağlayan, bakımı kolay triplex pompa ve manifold sistemi.',
                'applications' => ['Çamur devridaimi', 'Jet grouting', 'Kuyu temizleme'],
                'specs' => ['Maks. debi' => '600 L/dk', 'Maks. basınç' => '70 bar', 'Pompa tipi' => 'Triplex pistonlu', 'Tahrik' => 'Dizel / elektrik'],
                'featured' => true,
            ],
            [
                'id' => 'high-pressure-swivel', 'sku' => 'AS-SWI-250', 'name' => 'Yüksek Basınçlı Döner Başlık',
                'category' => 'Pompa Sistemleri', 'image' => $img('mud-pump.jpg'),
                'short' => 'Akışkan aktarımı için sızdırmaz rotary swivel sistemi.',
                'desc'  => 'Sondaj dizisi dönerken akışkan aktarımını kesintisiz sürdüren, değiştirilebilir conta grubuna sahip ağır hizmet döner başlık.',
                'applications' => ['Rotary sondaj', 'Su enjeksiyonu', 'Hava aktarımı'],
                'specs' => ['Çalışma basıncı' => '250 bar', 'Bağlantı' => 'API seçenekli', 'Gövde' => 'Çelik', 'Conta' => 'Değiştirilebilir kartuş'],
                'featured' => false,
            ],
            [
                'id' => 'seal-maintenance-kit', 'sku' => 'AS-SRV-001', 'name' => 'DTH Bakım ve Sızdırmazlık Seti',
                'category' => 'Yedek Parça', 'image' => $img('dth-hammer.jpg'),
                'short' => 'Sahada hızlı servis için conta ve bakım parçaları.',
                'desc'  => 'DTH çekiç ve hava hatlarının periyodik bakımı için seçilmiş sızdırmazlık elemanları, burçlar ve sarf parçalarından oluşur.',
                'applications' => ['Periyodik bakım', 'Saha servisi', 'Arıza onarımı'],
                'specs' => ['İçerik' => 'Conta, O-ring, burç', 'Paket' => 'Model bazlı', 'Malzeme' => 'NBR / Viton / PU', 'Tedarik' => 'Stok ve özel set'],
                'featured' => false,
            ],
        ];
    }

    public static function findBySku(string $sku): ?array
    {
        foreach (self::staticProducts() as $p) {
            if (strcasecmp($p['sku'], $sku) === 0) return $p;
        }
        return null;
    }

    public function show(Request $request, string $sku)
    {
        $product = self::findBySku($sku);
        if (!$product) abort(404);

        return view('asef-theme::shop.products.view', ['p' => $product]);
    }
}
