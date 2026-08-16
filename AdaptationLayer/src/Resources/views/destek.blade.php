{{-- Destek Merkezi — /destek --}}
@php
    $waLink = asef_wa_link('Merhaba, destek almak istiyorum.');
    $catalogUrl = route('shop.search.index');
    $asefUrl = static fn (string $rel): string => url('asef/' . ltrim($rel, '/'));

    $panels = [
        ['icon' => 'help', 'label' => 'YARDIM',       'title' => 'Sıkça Sorulan Sorular', 'desc' => 'Fiyat, sipariş, teslimat ve teknik danışmanlık hakkında hızlı cevaplar.', 'url' => route('shop.asef.faq')],
        ['icon' => 'chat', 'label' => 'İLETİŞİM',    'title' => 'Bize Ulaşın',            'desc' => 'WhatsApp, telefon, e-posta ve ofis adresimiz — hepsi tek sayfada.',     'url' => route('shop.asef.contact')],
        ['icon' => 'lock', 'label' => 'GİZLİLİK',    'title' => 'KVKK ve Politikalar',    'desc' => 'Kişisel verilerin korunması, gizlilik ve çerez politikamız.',           'url' => route('shop.asef.kvkk')],
    ];
@endphp

@push('meta')
    <meta name="title" content="Destek Merkezi — SSS, Teknik Yardım, Yasal | Asef Sondaj" />
    <meta name="description" content="Asef Sondaj destek merkezi: sıkça sorulan sorular, sondaj sözlüğü, WhatsApp iletişim, KVKK ve yasal politikalar. Teknik danışmanlık ve satış sonrası destek kaynakları tek noktada." />
    <meta name="keywords" content="Asef Sondaj destek, sondaj SSS, sondaj teknik yardım, sondaj sözlüğü, sondaj müşteri hizmetleri" />
    <link rel="canonical" href="{{ url('destek') }}" />
@endpush

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('styles')
<style>
    .ds-grid { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; display: grid; grid-template-columns: 1fr; gap: 16px; }
    @media (min-width: 768px) { .ds-grid { grid-template-columns: repeat(3, 1fr); margin-bottom: 120px; } }
    .ds-card {
        background: var(--surface-alt); border-radius: 22px; padding: 32px 28px 30px;
        display: flex; flex-direction: column; gap: 14px;
        transition: transform .28s cubic-bezier(0.16,1,0.3,1), background .2s;
        box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 12px rgba(0,0,0,0.03);
        color: var(--primary);
    }
    .ds-card:hover { transform: translateY(-3px); background: #EEEEF0; box-shadow: 0 1px 0 rgba(255,255,255,1) inset, 0 12px 32px rgba(0,0,0,0.08); }
    .ds-icon { width: 48px; height: 48px; border-radius: 14px; background: white; display: grid; place-items: center; color: var(--link-blue); box-shadow: 0 1px 0 rgba(255,255,255,0.9) inset, 0 4px 10px rgba(0,102,204,0.08); }
    .ds-icon svg { width: 24px; height: 24px; }
    .ds-label { font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; color: var(--gray-secondary); }
    .ds-title { font-size: 20px; font-weight: 600; color: var(--primary); letter-spacing: -0.01em; }
    .ds-desc { font-size: 14px; color: var(--secondary); line-height: 1.5; flex: 1; }
    .ds-link { font-size: 13px; color: var(--link-blue); font-weight: 500; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>Destek Merkezi — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">
            <section class="asef-hero">
                <div class="asef-label-caps">DESTEK MERKEZİ</div>
                <h1>Yanıtlar burada.</h1>
                <p>Sorularınız, iletişim kanallarımız ve yasal politikalarımız — hepsi tek merkezden.</p>
                <div class="asef-hero-ctas">
                    <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                    <a href="{{ route('shop.asef.faq') }}" class="asef-cta-pill ghost">SSS'ye Git <span class="asef-cta-arrow">›</span></a>
                </div>
            </section>

            <section class="ds-grid">
                @foreach ($panels as $p)
                    <a href="{{ $p['url'] }}" class="ds-card">
                        <div class="ds-icon">
                            @if ($p['icon'] === 'help')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                            @elseif ($p['icon'] === 'chat')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            @endif
                        </div>
                        <div class="ds-label">{{ $p['label'] }}</div>
                        <div class="ds-title">{{ $p['title'] }}</div>
                        <div class="ds-desc">{{ $p['desc'] }}</div>
                        <span class="ds-link">Aç ›</span>
                    </a>
                @endforeach
            </section>

            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">TEKNİK EKİP</div>
                    <h2>Sorularınıza en hızlı yol.</h2>
                    <p>Cevaplarımızda bulamadığınız her şey için ekibimize WhatsApp veya telefondan ulaşabilirsiniz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill primary">WhatsApp'tan Yaz</a>
                        <a href="tel:+905320542975" class="asef-cta-pill ghost">+90 532 054 29 75</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
