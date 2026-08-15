# AsefSondaj\Theme

Asef Sondaj web theme — replaces Bagisto storefront look with app-parity design.

## What this ships

- `AsefThemeServiceProvider` — registers views, routes, shared config
- Blade layouts: master, header, bottom pill nav
- Storefront pages: home, catalog, product detail, teklif listem, iletişim
- CSS + JS assets (Inter font, palette #F5F5F7 / #0071E3 / #25D366)
- Static product catalog (mirrors Flutter `asef_catalog.dart`)
- Optional Bagisto seeder to insert products into DB (`AsefCatalogSeeder`)

## Bagisto core is NOT modified.

Views are prepended into the `shop::` namespace. Routes are registered under `web` middleware. `packages/Webkul/*` untouched.

## Deploy

Handled by `packages/AsefSondaj/install.sh` (updated to publish theme assets, register the Theme provider, and run the catalog seeder).
