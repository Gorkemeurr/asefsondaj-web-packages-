{{--
    Asef Sondaj — Cart page override.
    The Bagisto default cart is disabled: this template ships instead.
    Bagisto core view files are NOT modified.
--}}
<x-shop::layouts>
    <x-slot:title>
        {{ config('asef.brand.name') }} — Teklif İçin İletişime Geçin
    </x-slot>

    @php
        $whatsapp = config('asef.contact.whatsapp');
        $phone    = config('asef.contact.phone');
        $email    = config('asef.contact.email');
        $waHref   = 'https://wa.me/' . $whatsapp . '?text=' . urlencode('Merhaba, sondaj ekipmanları hakkında teklif almak istiyorum.');
    @endphp

    <div class="mx-auto max-w-3xl px-4 py-16 text-center">
        <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-full bg-[#F5F5F7]">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#1D1D1F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-semibold text-[#1D1D1F] tracking-tight">
            Sepet kullanılmıyor
        </h1>

        <p class="mt-4 text-[#6E6E73] leading-relaxed max-w-xl mx-auto">
            {{ config('asef.brand.name') }} kataloğunda gördüğünüz ekipmanlar için teklif ve
            teknik bilgi doğrudan ekibimizden alınır. WhatsApp veya telefonla bize ulaşın —
            hızla dönüş yapıyoruz.
        </p>

        <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ $waHref }}"
               target="_blank"
               rel="noopener"
               class="inline-flex items-center gap-2 rounded-full bg-[#25D366] px-6 py-3 text-white font-semibold hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347"/>
                    <path d="M20.52 3.449C12.831-3.984.106 1.407.101 11.893c0 2.096.549 4.14 1.595 5.945L0 24l6.335-1.652a11.882 11.882 0 0 0 5.688 1.448h.005c9.884 0 16.061-9.756 12.87-17.856a11.897 11.897 0 0 0-4.378-5.491M12.03 21.786h-.004a9.87 9.87 0 0 1-5.03-1.378l-.36-.214-3.762.983 1.005-3.67-.235-.376a9.86 9.86 0 0 1-1.51-5.264c.001-8.788 10.751-13.185 16.965-6.973 6.213 6.202 1.832 16.892-7.069 16.892"/>
                </svg>
                WhatsApp ile İletişim
            </a>

            <a href="tel:+{{ $whatsapp }}"
               class="inline-flex items-center gap-2 rounded-full border border-[#D2D2D7] bg-white px-6 py-3 text-[#1D1D1F] font-semibold hover:bg-[#F5F5F7] transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                Hemen Ara — {{ $phone }}
            </a>
        </div>

        <div class="mt-10 text-sm text-[#6E6E73]">
            <p>E-posta: <a href="mailto:{{ $email }}" class="text-[#0071E3] hover:underline">{{ $email }}</a></p>
            <p class="mt-1">
                <a href="{{ url('/') }}" class="text-[#0071E3] hover:underline">← Katalog sayfasına dön</a>
            </p>
        </div>
    </div>
</x-shop::layouts>
