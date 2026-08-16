<?php

use AsefSondaj\AdaptationLayer\Models\AsefSetting;

if (! function_exists('asef_setting')) {
    /**
     * Global helper — DB'den ayar oku. Yoksa default fallback.
     *
     * Blade'de kullanım:
     *   {{ asef_setting('iletisim_telefon', '+90 532 054 29 75') }}
     *   {{ asef_setting('whatsapp_message') }}
     */
    function asef_setting(string $key, ?string $default = null): ?string
    {
        return AsefSetting::get($key, $default);
    }
}

if (! function_exists('asef_wa_link')) {
    /**
     * WhatsApp link builder — DB'den telefon + varsayılan mesaj alır.
     * Özel mesaj için parametre ver:
     *   asef_wa_link('Ürününüzü sordum...')
     */
    function asef_wa_link(?string $customMessage = null): string
    {
        $phone = asef_setting('iletisim_telefon', '+90 532 054 29 75');
        // Türkçe/uluslararası format → sadece rakamlar
        $phoneDigits = preg_replace('/[^0-9]/', '', $phone);
        $message = $customMessage ?? asef_setting('whatsapp_message', 'Merhaba, Asef Sondaj hakkında bilgi almak istiyorum.');
        return 'https://wa.me/' . $phoneDigits . '?text=' . rawurlencode($message);
    }
}
