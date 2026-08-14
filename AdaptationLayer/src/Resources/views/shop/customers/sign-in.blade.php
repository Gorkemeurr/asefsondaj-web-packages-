{{--
    Asef Sondaj — Login page override.
    Customer login flow is disabled: middleware redirects /customer/login to home.
    This file is a fallback in case any code renders this view directly.
--}}
<x-shop::layouts>
    <x-slot:title>{{ config('asef.brand.name') }} — Yalnızca Katalog</x-slot>

    <div class="mx-auto max-w-xl px-4 py-24 text-center">
        <h1 class="text-2xl font-semibold text-[#1D1D1F]">Üyelik Sistemi Kullanılmıyor</h1>
        <p class="mt-4 text-[#6E6E73]">
            {{ config('asef.brand.name') }} sitesinde giriş / kayıt zorunlu değildir.
            Ürünleri inceleyin, teklif için WhatsApp veya telefonla ulaşın.
        </p>
        <a href="{{ url('/') }}" class="mt-8 inline-block text-[#0071E3] hover:underline">
            Katalog sayfasına dön →
        </a>
    </div>
</x-shop::layouts>
