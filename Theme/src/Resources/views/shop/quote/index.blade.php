@extends('asef-theme::layouts.master')

@section('title', 'Teklif Listem — Asef Sondaj')

@section('content')
    <div class="asef-quote__head">
        <div>
            <p style="font-size:12px;color:var(--asef-secondary);margin:0 0 4px;" data-asef-quote-count>0 adet ürün</p>
            <h1>Teklif Listem</h1>
        </div>
        <button type="button" class="asef-quote__clear" data-asef-clear>
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
            Temizle
        </button>
    </div>

    {{-- Empty state --}}
    <div data-asef-quote-empty style="display:none;">
        <div class="asef-quote__empty">
            <div class="asef-quote__empty__icon">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            </div>
            <h2>Teklif listeniz henüz boş</h2>
            <p>İhtiyacınız olan ekipmanları seçin, adetleri belirleyin ve tek mesajla teklif isteyin.</p>
            <a href="/katalog">
                Kataloğa Git
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
            </a>
        </div>
    </div>

    {{-- Filled state --}}
    <div data-asef-quote-filled style="display:none;">
        <div class="asef-quote__list" data-asef-quote-list></div>

        <p class="asef-quote__footer">Fiyat ve teslim süresi; ölçü, bağlantı ve adet bilgisine göre netleştirilir.</p>

        <div class="asef-quote__send">
            <button type="button" class="asef-btn-primary" data-asef-send-wa>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.85 11.85 0 0 0 12 0C5.4 0 0 5.4 0 12c0 2.1.5 4.1 1.6 5.9L0 24l6.3-1.6c1.7 1 3.6 1.5 5.7 1.5 6.6 0 12-5.4 12-12 0-3.2-1.2-6.2-3.5-8.4z"/></svg>
                WhatsApp ile Gönder
            </button>
            <a href="#" class="asef-quote__send__mail" data-asef-send-mail aria-label="E-posta ile Gönder">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </a>
        </div>
    </div>

    {{-- Fallback (no JS) --}}
    <noscript>
        <div class="asef-quote__empty">
            <p>JavaScript devre dışı — Teklif Listem için lütfen JavaScript'i etkinleştirin.</p>
        </div>
    </noscript>
@endsection
