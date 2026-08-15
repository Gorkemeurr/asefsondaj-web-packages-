@extends('asef-theme::layouts.master')

@section('title', 'Asef Sondaj — Sondaj ekipmanları ve teknik çözümler')

@section('content')
    {{-- Hero --}}
    <section class="asef-hero" aria-label="Sondaj hero">
        <div class="asef-hero__body">
            <span class="asef-hero__tag">Sahaya Hazır Ekipman</span>
            <h2 class="asef-hero__title">Sondaj operasyonunuz için doğru çözüm</h2>
            <p class="asef-hero__subtitle">Delici ekipmandan pompa sistemlerine, teknik destekle yanınızdayız.</p>
            <a href="/katalog" class="asef-hero__cta">
                Kataloğu İncele
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- Quick pills --}}
    <div class="asef-quick">
        <a href="https://wa.me/{{ $asefContact['whatsapp'] }}" target="_blank" rel="noopener">
            <svg viewBox="0 0 24 24" fill="currentColor" style="color:#25D366"><path d="M20.5 3.5A11.85 11.85 0 0 0 12 0C5.4 0 0 5.4 0 12c0 2.1.5 4.1 1.6 5.9L0 24l6.3-1.6c1.7 1 3.6 1.5 5.7 1.5 6.6 0 12-5.4 12-12 0-3.2-1.2-6.2-3.5-8.4z"/></svg>
            WhatsApp
        </a>
        <a href="tel:{{ $asefContact['phone'] }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.94.36 1.86.7 2.74a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.88.34 1.8.57 2.74.7A2 2 0 0 1 22 16.92z"/>
            </svg>
            Hemen Ara
        </a>
    </div>

    {{-- Ürün grupları --}}
    <section class="asef-section">
        <div class="asef-section__head">
            <h2 class="asef-section__title">Ürün grupları</h2>
            <a href="/katalog" class="asef-section__link">Tümünü gör →</a>
        </div>
        <div class="asef-catgrid" role="list">
            @foreach ($categories as $cat)
                <a href="/katalog?kategori={{ urlencode($cat['name']) }}" class="asef-catcard" role="listitem">
                    <div class="asef-catcard__img" style="background-image:url('{{ $cat['image'] }}')"></div>
                    <div class="asef-catcard__body">
                        <div>
                            <h3>{{ $cat['name'] }}</h3>
                            <span>{{ $cat['count'] }} ürün</span>
                        </div>
                        <div class="asef-catcard__arrow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- Öne çıkan ekipmanlar --}}
    <section class="asef-section">
        <div class="asef-section__head">
            <h2 class="asef-section__title">Öne çıkan ekipmanlar</h2>
            <a href="/katalog" class="asef-section__link">Tümünü gör →</a>
        </div>
        <div class="asef-pgrid">
            @foreach ($featured as $p)
                @include('asef-theme::shop.partials.product-card', ['p' => $p])
            @endforeach
        </div>
    </section>
@endsection
