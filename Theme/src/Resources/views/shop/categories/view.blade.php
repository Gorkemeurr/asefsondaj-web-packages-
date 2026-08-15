@extends('asef-theme::layouts.master')

@section('title', 'Katalog — Asef Sondaj')

@section('content')
    <div class="asef-section" style="margin-top:16px;">
        <p style="font-size:13px;color:var(--asef-secondary);margin:0 0 4px;">{{ $total }} ekipman listeleniyor</p>
        <h1 style="font-size:24px;font-weight:700;margin:0;color:var(--asef-ink);">Katalog</h1>
    </div>

    <form method="get" action="/katalog" class="asef-search">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--asef-tertiary)">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="search" name="q" placeholder="Ürün adı veya stok kodu ara" value="{{ $search }}">
        @if ($selected !== 'Tümü')
            <input type="hidden" name="kategori" value="{{ $selected }}">
        @endif
    </form>

    <div class="asef-chips">
        @foreach ($categories as $cat)
            <a href="/katalog?kategori={{ urlencode($cat) }}"
               class="asef-chip {{ $selected === $cat ? 'is-active' : '' }}">
                {{ $cat }}
            </a>
        @endforeach
    </div>

    @if (count($products) === 0)
        <div style="text-align:center;padding:48px 16px;color:var(--asef-secondary);">
            <p>Sonuç bulunamadı.</p>
        </div>
    @else
        <div class="asef-pgrid">
            @foreach ($products as $p)
                @include('asef-theme::shop.partials.product-card', ['p' => $p])
            @endforeach
        </div>
    @endif
@endsection
