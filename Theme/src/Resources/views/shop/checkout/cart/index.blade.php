@extends('asef-theme::layouts.master')

@section('title', 'Teklif Listem — Asef Sondaj')

@section('content')
    <div class="asef-quote__empty" style="margin-top:32px;">
        <div class="asef-quote__empty__icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
        </div>
        <h2>Sepet kullanılmıyor</h2>
        <p>Asef Sondaj web sitesinde sipariş yerine <strong>Teklif Listem</strong> kullanılır — ürün seçin, tek mesajla iletişime geçin.</p>
        <a href="/teklif" style="background:var(--asef-blue);">Teklif Listem'e Git →</a>
    </div>
@endsection

@push('scripts')
<script>setTimeout(() => location.href = '/teklif', 100);</script>
@endpush
