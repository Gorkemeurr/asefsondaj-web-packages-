{{-- Blog Detay — /blog/{slug} --}}
@php
    $waLink = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, blog yazısı hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $slug = $slug ?? 'yazi';
    $displayTitle = ucwords(str_replace('-', ' ', $slug));
@endphp

@push('meta')
    <meta name="title" content="{{ $displayTitle }} — Asef Sondaj Blog" />
    <meta name="robots" content="noindex" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>{{ $displayTitle }} — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">BLOG · {{ mb_strtoupper($slug, 'UTF-8') }}</div>
                <h1>Bu yazı yakında yayınlanacak.</h1>
                <p>Blog içeriğimizi düzenli olarak güncelliyoruz. Öneriniz varsa WhatsApp'tan iletmeniz yeterli.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ route('shop.asef.blog') }}" class="asef-cta-pill primary">Blog'a Dön</a>
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">Öneride Bulun <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">BU ARADA</div>
                    <h2>Kataloğu keşfedin.</h2>
                    <p>Ürünlerimizi, teknik özelliklerini ve kullanım alanlarını inceleyebilirsiniz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $catalogUrl }}" class="asef-cta-pill primary">Ürünleri Keşfet</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">WhatsApp'tan Yaz</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
