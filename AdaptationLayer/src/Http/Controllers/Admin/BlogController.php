<?php

namespace AsefSondaj\AdaptationLayer\Http\Controllers\Admin;

use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('asef-adaptation::admin.placeholder', [
            'title' => 'Blog Yazıları',
            'desc'  => '9 blog yazısı şu an Blade template içinde. Faz 2\'de DB\'ye taşınacak (asef_bloglar tablosu + admin CRUD). Şimdilik yazı içeriklerini doğrudan blog-detay.blade.php üzerinde düzenleyebilirsin.',
            'items' => [
                ['sıra' => 1, 'başlık' => 'Sondaj Operasyonlarında Ekipman Seçimi (2026)', 'url' => '/blog/ekipman-secim-rehberi'],
                ['sıra' => 2, 'başlık' => 'DTH Çekiç Bakımı — 5 Kritik Nokta', 'url' => '/blog/dth-cekic-bakim'],
                ['sıra' => 3, 'başlık' => 'Sondaj Tiji ve Bağlantı Standartları', 'url' => '/blog/sondaj-tiji-baglanti'],
                ['sıra' => 4, 'başlık' => 'Çamur Pompası Performansı', 'url' => '/blog/camur-pompa-verim'],
                ['sıra' => 5, 'başlık' => 'Karot Alma Hataları — 4 Vaka', 'url' => '/blog/karot-hatalari'],
                ['sıra' => 6, 'başlık' => 'Su Sondajı DSİ İzin Süreci', 'url' => '/blog/su-sondaji-mevzuat'],
                ['sıra' => 7, 'başlık' => 'Yerüstü ve Yeraltı Sondaj Karşılaştırması', 'url' => '/blog/yerustu-yeralti'],
                ['sıra' => 8, 'başlık' => 'Karotier Seçimi HQ/NQ/PQ', 'url' => '/blog/karotier-ipuclari'],
                ['sıra' => 9, 'başlık' => 'Sondaj Yedek Parça Planlaması', 'url' => '/blog/yedek-parca-stok'],
            ],
        ]);
    }
}
