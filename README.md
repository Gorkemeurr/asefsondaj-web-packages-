# Asef Sondaj — Bagisto Web Packages

Bu repo, Asef Sondaj web sitesinin (asefsondaj.com) Bagisto üzerine kurulan özelleştirme paketlerini içerir.

## İçindeki paketler

### AdaptationLayer (Faz 2A)
Bagisto varsayılan e-ticaret akışlarını (checkout/cart/customer/orders/wishlist) devre dışı bırakır, Asef Sondaj'ın "katalog + WhatsApp teklif" akışına uyarlar.

**Ne yapar:**
- Bloklanan route'lar: `/checkout`, `/cart`, `/customer/*`, `/orders`, `/wishlist`, `/account`, `/compare` → 302 to `/`
- Sepet sayfası → "Sepet kullanılmıyor" + WhatsApp CTA
- Login sayfası → placeholder mesaj
- Admin panel etkilenmez
- Bagisto core dokunulmaz (packages/Webkul/*)

## Deployment (cPanel)

Bu repo `~/bagisto/packages/AsefSondaj/` olarak klonlanır. cPanel Git Version Control ile otomatik pull yapılır.

### İlk kurulum
```bash
cd ~/bagisto/packages
rm -rf AsefSondaj  # varsa
git clone https://github.com/Gorkemeurr/asefsondaj-web-packages-.git AsefSondaj
cd ~/bagisto
composer dump-autoload -o
php artisan optimize:clear
php artisan config:cache
```

### Update
```bash
cd ~/bagisto/packages/AsefSondaj && git pull
cd ~/bagisto && composer dump-autoload -o && php artisan optimize:clear
```

Ya da cPanel'de "Deploy HEAD Commit" butonu tıkla (auto-deploy açıksa).

## Ana Bagisto composer.json'a eklenmesi gereken

```json
"autoload": {
    "psr-4": {
        "AsefSondaj\\AdaptationLayer\\": "packages/AsefSondaj/AdaptationLayer/src/",
        ...
    }
}
```

## Ana Bagisto bootstrap/providers.php'ye eklenmesi gereken

```php
use AsefSondaj\AdaptationLayer\Providers\AdaptationServiceProvider;

return [
    ...
    AdaptationServiceProvider::class,
    ...
];
```

## Config override

`config/asef.php` içindeki değerler `.env` veya doğrudan admin config panel ile override edilebilir (gelecek Faz 2B).

## Roadmap

- [x] Faz 2A: AdaptationLayer (route bloklama + minimal view override)
- [ ] Faz 2B: QuoteList module (session-based teklif sepeti)
- [ ] Faz 3: Asef Theme (Apple stili Asef branding)
- [ ] Faz 5: App-Web GraphQL sync

## Katmanlı mimari

```
Bagisto Core (packages/Webkul/*) — IMMUTABLE
    ↓
Asef Adaptation Layer (packages/AsefSondaj/AdaptationLayer/) — bu repo
    ↓
Storefront kullanıcı deneyimi (App ile birebir)
```

Bagisto'nun tam feature seti gelecek genişleme için korunur; Asef'e özel her şey bu katmanda kalır.

<!-- webhook test 20260814T235347Z -->
<!-- webhook retest 235843 -->
