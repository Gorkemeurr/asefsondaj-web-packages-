<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * asef_settings tablosuna 'group' alanı ekle — admin panelde tab bazlı gruplandırma.
 * Ayrıca statik sayfa metinleri (hakkımızda, kurumsal, hizmetler, referanslar)
 * için content block settings seed edilir.
 */
return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('asef_settings')) return;

        if (! Schema::hasColumn('asef_settings', 'group')) {
            Schema::table('asef_settings', function (Blueprint $t) {
                $t->string('group', 50)->default('genel')->after('key')->index();
            });
        }

        // Mevcut settings'i "iletisim" ve "site" gruplarına ata
        $groupMap = [
            'iletisim_telefon'      => 'iletisim',
            'iletisim_email'        => 'iletisim',
            'iletisim_email_destek' => 'iletisim',
            'iletisim_adres'        => 'iletisim',
            'iletisim_saatleri'     => 'iletisim',
            'whatsapp_message'      => 'iletisim',
            'instagram_url'         => 'sosyal',
            'google_isletme_url'    => 'sosyal',
            'hero_title'            => 'anasayfa',
            'hero_subtitle'         => 'anasayfa',
            'footer_intro'          => 'anasayfa',
        ];
        foreach ($groupMap as $key => $group) {
            DB::table('asef_settings')->where('key', $key)->update(['group' => $group]);
        }

        // Yeni sayfa metin settings seed
        $this->seedPageContent();
    }

    protected function seedPageContent(): void
    {
        $defaults = [
            // Hakkımızda
            ['key' => 'hakkimizda_hero_title', 'group' => 'hakkimizda', 'label' => 'Hakkımızda Hero Başlık', 'value' => 'Sondaj sektöründe iki dekat.', 'type' => 'text'],
            ['key' => 'hakkimizda_hero_desc', 'group' => 'hakkimizda', 'label' => 'Hakkımızda Hero Alt Metin', 'value' => 'Bursa merkezimizden Türkiye\'nin sondaj operasyonlarına ekipman, yedek parça ve teknik danışmanlık.', 'type' => 'textarea'],
            // Kurumsal
            ['key' => 'kurumsal_hero_title', 'group' => 'kurumsal', 'label' => 'Kurumsal Hero Başlık', 'value' => 'Kurumsal.', 'type' => 'text'],
            ['key' => 'kurumsal_hero_desc', 'group' => 'kurumsal', 'label' => 'Kurumsal Hero Alt Metin', 'value' => '20 yıllık saha tecrübesiyle Türkiye\'nin dört bir yanındaki sondaj operasyonlarında güvenilir çözüm ortağıyız.', 'type' => 'textarea'],
            // Hizmetler
            ['key' => 'hizmetlerimiz_hero_title', 'group' => 'hizmetler', 'label' => 'Hizmetler Hero Başlık', 'value' => 'Ekipmandan öte, çözüm.', 'type' => 'text'],
            ['key' => 'hizmetlerimiz_hero_desc', 'group' => 'hizmetler', 'label' => 'Hizmetler Hero Alt Metin', 'value' => 'Danışmanlıktan tedarike, kurulumdan satış sonrası desteğe — her adımda yanınızdayız.', 'type' => 'textarea'],
            // Referanslar
            ['key' => 'referanslar_hero_title', 'group' => 'referanslar', 'label' => 'Referanslar Hero Başlık', 'value' => 'Sahada denendi.', 'type' => 'text'],
            ['key' => 'referanslar_hero_desc', 'group' => 'referanslar', 'label' => 'Referanslar Hero Alt Metin', 'value' => '20 yılda 500+ tamamlanan proje. Türkiye\'nin 81 ilinde maden, su, jeotermal ve jeoteknik sondaj operasyonlarında güven ortaklığımız.', 'type' => 'textarea'],
            // Sondaj Makineleri
            ['key' => 'sondaj_makinalari_hero_title', 'group' => 'makineler', 'label' => 'Sondaj Makineleri Hero Başlık', 'value' => 'Sahada denendi. Kanıtlandı.', 'type' => 'text'],
            ['key' => 'sondaj_makinalari_hero_desc', 'group' => 'makineler', 'label' => 'Sondaj Makineleri Hero Alt Metin', 'value' => 'Yerüstü, yeraltı, su ve jeoteknik sondaj için hazır makineler — Türkiye geneli teslimat ve orijinal yedek parça desteği.', 'type' => 'textarea'],
        ];

        $sort = 100;
        $now = date('Y-m-d H:i:s');
        foreach ($defaults as $d) {
            $exists = DB::table('asef_settings')->where('key', $d['key'])->exists();
            if ($exists) continue;
            DB::table('asef_settings')->insert([
                'key'        => $d['key'],
                'group'      => $d['group'],
                'label'      => $d['label'],
                'value'      => $d['value'],
                'type'       => $d['type'],
                'help'       => null,
                'sort'       => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('asef_settings') && Schema::hasColumn('asef_settings', 'group')) {
            Schema::table('asef_settings', fn (Blueprint $t) => $t->dropColumn('group'));
        }
    }
};
