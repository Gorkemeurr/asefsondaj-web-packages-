<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Genel site ayarları: hero başlığı, iletişim bilgileri, WhatsApp, footer metin.
 * Key/value store — admin panelden yönetilebilir.
 */
return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('asef_settings')) {
            Schema::create('asef_settings', function (Blueprint $t) {
                $t->id();
                $t->string('key', 100)->unique();
                $t->string('label', 200);
                $t->text('value')->nullable();
                $t->string('type', 20)->default('text');  // text, textarea, url, tel, email
                $t->text('help')->nullable();
                $t->integer('sort')->default(0);
                $t->timestamps();
            });
        }

        $this->seedDefaults();
    }

    protected function seedDefaults(): void
    {
        $defaults = [
            ['key' => 'iletisim_telefon',    'label' => 'İletişim Telefon',    'value' => '+90 532 054 29 75', 'type' => 'tel', 'help' => 'Uluslararası formatta, WhatsApp linki için de kullanılır.'],
            ['key' => 'iletisim_email',      'label' => 'İletişim E-posta',    'value' => 'iletisim@asefsondaj.com', 'type' => 'email'],
            ['key' => 'iletisim_email_destek', 'label' => 'Destek E-posta',    'value' => 'destek@asefsondaj.com', 'type' => 'email'],
            ['key' => 'iletisim_adres',      'label' => 'Adres',                'value' => 'Duaçınarı Mah. 1. Özgünay Sk No:10, Yıldırım / Bursa', 'type' => 'textarea'],
            ['key' => 'iletisim_saatleri',   'label' => 'Çalışma Saatleri',    'value' => 'Pazartesi - Cumartesi 09:00 - 18:00', 'type' => 'text'],
            ['key' => 'whatsapp_message',    'label' => 'WhatsApp Varsayılan Mesajı', 'value' => 'Merhaba, Asef Sondaj ürünleriniz hakkında bilgi ve teklif almak istiyorum.', 'type' => 'textarea', 'help' => 'WhatsApp CTA butonlarında otomatik dolu gelir.'],
            ['key' => 'instagram_url',       'label' => 'Instagram URL',        'value' => 'https://instagram.com/asefsondajj', 'type' => 'url'],
            ['key' => 'google_isletme_url',  'label' => 'Google İşletme URL',  'value' => 'https://share.google/feiNpSvOEuMJtBfwL', 'type' => 'url'],
            ['key' => 'hero_title',          'label' => 'Ana Sayfa H1 Başlık', 'value' => 'Sondaj Teknolojisinde Geleceğe Ortak.', 'type' => 'text'],
            ['key' => 'hero_subtitle',       'label' => 'Ana Sayfa Alt Başlık', 'value' => 'Yirmi yılı aşkın saha tecrübemizle Türkiye genelinde sondaj ekipmanları, karotier, DTH çekiç, sondaj tijleri ve yedek parça tedariki sağlıyoruz.', 'type' => 'textarea'],
            ['key' => 'footer_intro',        'label' => 'Footer Marka Metni', 'value' => '20 yıllık saha tecrübesiyle Türkiye\'nin dört bir yanındaki sondaj operasyonlarına ekipman, yedek parça ve teknik danışmanlık.', 'type' => 'textarea'],
        ];

        $sort = 0;
        $now = date('Y-m-d H:i:s');
        foreach ($defaults as $d) {
            $exists = DB::table('asef_settings')->where('key', $d['key'])->exists();
            if ($exists) continue;

            DB::table('asef_settings')->insert([
                'key'        => $d['key'],
                'label'      => $d['label'],
                'value'      => $d['value'],
                'type'       => $d['type'] ?? 'text',
                'help'       => $d['help'] ?? null,
                'sort'       => $sort++,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('asef_settings');
    }
};
