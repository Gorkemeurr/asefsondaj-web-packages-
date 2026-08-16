{{-- Legal sayfa shell (Gizlilik / Çerez / Kullanım Şartları için ortak layout).
     Parent scope: $lpTitle, $lpLede, $lpUpdatedAt, $lpToc (array of [anchor,label]),
                    $lpSections (array of [anchor, title, html]), $lpKind (label). --}}
@php
    $waLink     = 'https://wa.me/905320542975?text=' . rawurlencode('Merhaba, ' . $lpTitle . ' hakkında bilgi almak istiyorum.');
    $catalogUrl = route('shop.search.index');
@endphp

@include('asef-adaptation::partials.v5-styles')
@include('asef-adaptation::partials.v5-cart-js')

@push('meta')
    <meta name="title" content="{{ $lpTitle }} — Asef Sondaj" />
    <meta name="description" content="{{ $lpLede }}" />
@endpush

@push('styles')
<style>
    .lp-hero { max-width: 780px; margin: 0 auto; padding: 60px 20px 24px; text-align: center; }
    @media (min-width: 768px) { .lp-hero { padding: 96px 20px 32px; } }
    .lp-label { font-size: 12px; letter-spacing: 0.16em; color: var(--gray-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 14px; }
    .lp-title { font-size: clamp(30px, 4.5vw, 52px); font-weight: 600; letter-spacing: -0.02em; line-height: 1.1; color: var(--primary); margin-bottom: 18px; }
    .lp-lede { font-size: clamp(16px, 1.6vw, 19px); color: var(--secondary); line-height: 1.55; margin: 0 auto; max-width: 640px; }
    .lp-meta { margin-top: 22px; font-size: 13px; color: var(--gray-secondary); display: inline-flex; gap: 8px; align-items: center; }
    .lp-meta svg { width: 14px; height: 14px; }

    .lp-body-wrap { max-width: 1024px; margin: 40px auto 80px; padding: 0 20px; }
    @media (min-width: 768px) { .lp-body-wrap { margin: 60px auto 100px; } }
    .lp-body-grid { display: grid; grid-template-columns: 1fr; gap: 32px; }
    @media (min-width: 900px) { .lp-body-grid { grid-template-columns: 260px 1fr; gap: 48px; } }

    /* TOC */
    .lp-toc { position: sticky; top: 100px; align-self: start; }
    .lp-toc-title { font-size: 11px; letter-spacing: 0.14em; color: var(--gray-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 14px; }
    .lp-toc ol { list-style: none; padding: 0; margin: 0; counter-reset: toc; }
    .lp-toc li { counter-increment: toc; margin-bottom: 4px; }
    .lp-toc a {
        display: flex; gap: 12px; align-items: flex-start;
        padding: 10px 12px; border-radius: 10px;
        color: var(--secondary); font-size: 14px; line-height: 1.35;
        transition: background .15s, color .15s;
        text-decoration: none;
    }
    .lp-toc a::before { content: counter(toc, decimal-leading-zero); font-family: "SF Mono", ui-monospace, Menlo, monospace; font-size: 11px; color: var(--gray-secondary); flex-shrink: 0; padding-top: 2px; }
    .lp-toc a:hover { background: var(--surface-alt); color: var(--primary); }
    @media (max-width: 900px) {
        .lp-toc { position: static; padding: 20px; background: var(--surface-alt); border-radius: 16px; }
        .lp-toc-title { margin-bottom: 8px; }
    }

    /* Sections */
    .lp-sections { font-size: 16px; line-height: 1.72; color: var(--on-surface); }
    .lp-sections section { margin-bottom: 44px; scroll-margin-top: 100px; }
    .lp-sections h2 { font-size: clamp(22px, 2.6vw, 28px); font-weight: 600; letter-spacing: -0.01em; color: var(--primary); margin-bottom: 14px; line-height: 1.2; }
    .lp-sections p { margin-bottom: 14px; }
    .lp-sections ul, .lp-sections ol { margin: 0 0 16px 20px; padding: 0; }
    .lp-sections li { margin-bottom: 8px; }
    .lp-sections strong { color: var(--primary); font-weight: 600; }
    .lp-sections a { color: var(--link-blue); }
    .lp-sections .lp-note { background: var(--surface-alt); border-left: 3px solid var(--primary); padding: 16px 18px; border-radius: 0 12px 12px 0; margin: 20px 0; font-size: 14px; }
    .lp-sections table { border-collapse: collapse; width: 100%; margin: 16px 0; font-size: 14px; }
    .lp-sections th, .lp-sections td { border-bottom: 1px solid var(--outline); padding: 10px 12px; text-align: left; }
    .lp-sections th { color: var(--gray-secondary); font-weight: 500; font-size: 12px; text-transform: uppercase; letter-spacing: 0.06em; }

    /* Footer cross-links */
    .lp-crosslinks { max-width: 1024px; margin: 0 auto 80px; padding: 0 20px; }
    .lp-crosslinks-head { font-size: 12px; letter-spacing: 0.14em; color: var(--gray-secondary); font-weight: 600; text-transform: uppercase; margin-bottom: 14px; }
    .lp-crosslinks-grid { display: grid; grid-template-columns: 1fr; gap: 14px; }
    @media (min-width: 768px) { .lp-crosslinks-grid { grid-template-columns: repeat(3, 1fr); gap: 18px; } }
    .lp-crosslink { display: flex; justify-content: space-between; align-items: center; padding: 20px 22px; background: var(--surface-alt); border-radius: 16px; transition: background .15s, transform .2s; }
    .lp-crosslink:hover { background: #EEEEF0; transform: translateY(-2px); }
    .lp-crosslink-name { font-size: 15px; font-weight: 500; color: var(--primary); }
    .lp-crosslink-arr { color: var(--gray-secondary); font-size: 16px; }
</style>
@endpush

<x-shop::layouts :has-header="false" :has-feature="false" :has-footer="false">
    <x-slot:title>{{ $lpTitle }} — Asef Sondaj</x-slot>

    <div class="asef-root">
        @include('asef-adaptation::partials.v5-nav')

        <main class="asef-main">

            <section class="lp-hero">
                <div class="lp-label">{{ $lpKind }}</div>
                <h1 class="lp-title">{{ $lpTitle }}</h1>
                <p class="lp-lede">{{ $lpLede }}</p>
                <div class="lp-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                    Son güncelleme: {{ $lpUpdatedAt }}
                </div>
            </section>

            <section class="lp-body-wrap">
                <div class="lp-body-grid">
                    <aside class="lp-toc" aria-label="İçindekiler">
                        <div class="lp-toc-title">İçindekiler</div>
                        <ol>
                            @foreach ($lpToc as [$anchor, $label])
                                <li><a href="#{{ $anchor }}">{{ $label }}</a></li>
                            @endforeach
                        </ol>
                    </aside>
                    <div class="lp-sections">
                        @foreach ($lpSections as [$anchor, $title, $html])
                            <section id="{{ $anchor }}">
                                <h2>{{ $title }}</h2>
                                {!! $html !!}
                            </section>
                        @endforeach
                    </div>
                </div>
            </section>

            {{-- CROSS-LINKS to sibling legal pages --}}
            <section class="lp-crosslinks">
                <div class="lp-crosslinks-head">İlgili sayfalar</div>
                <div class="lp-crosslinks-grid">
                    @php
                        $crossLinks = [
                            ['url' => url('gizlilik-politikasi'), 'name' => 'Gizlilik Politikası'],
                            ['url' => url('cerez-politikasi'),    'name' => 'Çerez Politikası'],
                            ['url' => url('kullanim-sartlari'),   'name' => 'Kullanım Şartları'],
                            ['url' => url('kvkk'),                 'name' => 'KVKK Aydınlatma Metni'],
                        ];
                        $currentPath = trim(request()->path(), '/');
                    @endphp
                    @foreach ($crossLinks as $cl)
                        @php $slug = last(explode('/', parse_url($cl['url'], PHP_URL_PATH))); @endphp
                        @if ($slug !== $currentPath)
                            <a href="{{ $cl['url'] }}" class="lp-crosslink">
                                <span class="lp-crosslink-name">{{ $cl['name'] }}</span>
                                <span class="lp-crosslink-arr">›</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            </section>

            {{-- CTA --}}
            <section class="asef-section">
                <div class="asef-cta-band">
                    <div class="asef-label-caps">SORUNUZ MU VAR</div>
                    <h2>Metinde yer almayan bir konuda soru sormak istiyorsanız</h2>
                    <p>Kişisel veri, çerez veya kullanım şartları hakkında sorularınızı destek ekibimize iletebilirsiniz.</p>
                    <div class="asef-cta-band-actions">
                        <a href="mailto:destek@asefsondaj.com" class="asef-cta-pill primary">destek@asefsondaj.com</a>
                        <a href="{{ $waLink }}" target="_blank" rel="noopener" class="asef-cta-pill ghost">WhatsApp'tan Yaz</a>
                    </div>
                </div>
            </section>
        </main>

        @include('asef-adaptation::partials.v5-footer')
    </div>
</x-shop::layouts>
