<x-admin::layouts>
    <x-slot:title>
        Yardım ve Destek
    </x-slot>

    @php
        $services = [
            [
                'title' => 'WhatsApp Hattı',
                'info'  => '7/24 hızlı iletişim için WhatsApp üzerinden bize ulaşın. Ürün, teklif, teknik destek ve sipariş konularında yardımcı olalım.',
                'url'   => 'https://wa.me/905320542975',
                'host'  => '0532 054 29 75',
                'icon'  => 'M12 3a9 9 0 0 0-9 9v4a2 2 0 0 0 2 2h1a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1H5a7 7 0 0 1 14 0h-1a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h1a2 2 0 0 0 2-2v-4a9 9 0 0 0-9-9Z',
            ],
            [
                'title' => 'Genel İletişim',
                'info'  => 'Kurumsal talepler, satış ve iş birlikleri için e-posta ile bize yazın. Aynı iş günü içinde dönüş sağlıyoruz.',
                'url'   => 'mailto:iletisim@asefsondaj.com',
                'host'  => 'iletisim@asefsondaj.com',
                'icon'  => 'M4 6h16v12H4V6Zm0 0 8 7 8-7',
            ],
            [
                'title' => 'Teknik Destek',
                'info'  => 'Sondaj makinesi, ekipman, karotiyer ve yedek parçalar için teknik destek talebiniz varsa doğrudan destek ekibimize yazın.',
                'url'   => 'mailto:destek@asefsondaj.com',
                'host'  => 'destek@asefsondaj.com',
                'icon'  => 'M14.7 6.3a3 3 0 0 0-4 4l-7 7L5 19l7-7a3 3 0 0 0 4-4l-2 2-1.4-1.4 2-2ZM5.5 18a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1Z',
            ],
        ];

        $resources = [
            [
                'title' => 'Ürün Kataloğu',
                'info'  => 'Sondaj makineleri, karotiyer, DTH çekiç, sondaj tijleri ve yedek parça ürünlerimizin tamamı için web sitemizi ziyaret edin.',
                'url'   => 'https://www.asefsondaj.com/urunler',
                'host'  => 'www.asefsondaj.com/urunler',
                'icon'  => 'M10 3h4v2a2 2 0 0 0 4 0V3h2a1 1 0 0 1 1 1v3h-2a2 2 0 0 0 0 4h2v6a1 1 0 0 1-1 1h-6v-2a2 2 0 0 0-4 0v2H4a1 1 0 0 1-1-1v-6h2a2 2 0 0 0 0-4H3V4a1 1 0 0 1 1-1h6Z',
            ],
            [
                'title' => 'Kurumsal',
                'info'  => '20+ yıllık saha tecrübemiz, hizmetlerimiz, referanslarımız ve şirket bilgilerimiz hakkında detaylı içerikler.',
                'url'   => 'https://www.asefsondaj.com/kurumsal',
                'host'  => 'www.asefsondaj.com/kurumsal',
                'icon'  => 'M4 4a2 2 0 0 1 2-2h7l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4Zm9 0v4h4M8 13h8M8 17h5',
            ],
            [
                'title' => 'Sondaj Sözlüğü',
                'info'  => '60+ sondaj sektörü teknik terimi ve açıklamaları — ekipman, yöntem ve bakım terminolojisi tek sayfada.',
                'url'   => 'https://www.asefsondaj.com/sondaj-sozlugu',
                'host'  => 'www.asefsondaj.com/sondaj-sozlugu',
                'icon'  => 'm9 8-4 4 4 4m6-8 4 4-4 4M14 5l-4 14',
            ],
        ];
    @endphp

    <!-- Page Header -->
    <div class="grid gap-1.5 mb-8 max-w-3xl">
        <p class="text-2xl font-bold !leading-snug text-gray-800 dark:text-white">
            Yardım ve Destek
        </p>

        <p class="!leading-relaxed text-gray-600 dark:text-gray-300">
            Asef Sondaj yönetim paneli hakkında bilgi almak, sipariş/teklif konularında destek istemek veya
            teknik konularda ekibimize ulaşmak için aşağıdaki kanalları kullanabilirsiniz.
        </p>
    </div>

    <!-- İletişim Kanalları -->
    <div class="mb-10">
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400 mb-4">
            İletişim Kanalları
        </p>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($services as $card)
                @include('admin::help.card', ['card' => $card])
            @endforeach
        </div>
    </div>

    <!-- Kaynaklar -->
    <div class="mb-10">
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-400 mb-4">
            Kaynaklar ve Belgeler
        </p>

        <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($resources as $card)
                @include('admin::help.card', ['card' => $card])
            @endforeach
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="flex flex-wrap items-center justify-between gap-5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-800 px-7 py-6 shadow-lg">
        <div class="flex items-center gap-4">
            <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-white/20 text-white">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 11.5a8.38 8.38 0 0 1-8.5 8.5 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8A8.38 8.38 0 0 1 12.5 3a8.38 8.38 0 0 1 8.5 8.5Z"></path>
                </svg>
            </span>

            <div class="grid gap-0.5">
                <p class="text-lg font-bold !leading-snug text-white">
                    Hâlâ yardıma mı ihtiyacınız var?
                </p>

                <p class="!leading-snug text-white/80">
                    Herhangi bir konuda Asef Sondaj ekibiyle doğrudan iletişime geçin — WhatsApp veya e-posta ile size en kısa sürede dönelim.
                </p>
            </div>
        </div>

        <a
            href="https://wa.me/905320542975"
            target="_blank"
            rel="noopener noreferrer"
            class="inline-flex items-center gap-2 rounded-lg bg-white px-5 py-2.5 font-semibold text-blue-700 transition-all hover:bg-blue-50"
        >
            Bize Ulaşın

            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M13 6l6 6-6 6"></path>
            </svg>
        </a>
    </div>
</x-admin::layouts>
