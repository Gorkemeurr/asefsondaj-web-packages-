@extends('asef-theme::layouts.master')

@section('title', 'İletişim — Asef Sondaj')

@section('content')
    <div style="margin:24px 0 12px;">
        <h1 style="font-size:26px;font-weight:700;margin:0 0 8px;color:var(--asef-ink);letter-spacing:-0.01em;">Bize ulaşın</h1>
        <p style="font-size:14px;color:var(--asef-secondary);margin:0;line-height:1.5;">Ürün seçimi, teknik uygunluk ve teklif süreci için ekibimizle doğrudan iletişime geçin.</p>
    </div>

    <div class="asef-contact__list">
        <a href="https://wa.me/{{ $asefContact['whatsapp'] }}" target="_blank" rel="noopener" class="asef-contact__item">
            <span class="asef-contact__item__icon is-whatsapp">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.85 11.85 0 0 0 12 0C5.4 0 0 5.4 0 12c0 2.1.5 4.1 1.6 5.9L0 24l6.3-1.6c1.7 1 3.6 1.5 5.7 1.5 6.6 0 12-5.4 12-12 0-3.2-1.2-6.2-3.5-8.4z"/></svg>
            </span>
            <div>
                <p class="asef-contact__item__label">WhatsApp</p>
                <p class="asef-contact__item__value">{{ $asefContact['phone'] }}</p>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--asef-tertiary);"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <a href="tel:{{ $asefContact['phone'] }}" class="asef-contact__item">
            <span class="asef-contact__item__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.94.36 1.86.7 2.74a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.88.34 1.8.57 2.74.7A2 2 0 0 1 22 16.92z"/></svg>
            </span>
            <div>
                <p class="asef-contact__item__label">Telefon</p>
                <p class="asef-contact__item__value">{{ $asefContact['phone'] }}</p>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--asef-tertiary);"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <a href="mailto:{{ $asefContact['email'] }}" class="asef-contact__item">
            <span class="asef-contact__item__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </span>
            <div>
                <p class="asef-contact__item__label">Kurumsal e-posta</p>
                <p class="asef-contact__item__value">{{ $asefContact['email'] }}</p>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--asef-tertiary);"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <a href="mailto:{{ $asefContact['support_email'] }}" class="asef-contact__item">
            <span class="asef-contact__item__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1v-6h3v4z"/><path d="M3 19a2 2 0 0 0 2 2h1v-6H3v4z"/></svg>
            </span>
            <div>
                <p class="asef-contact__item__label">Teknik destek</p>
                <p class="asef-contact__item__value">{{ $asefContact['support_email'] }}</p>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--asef-tertiary);"><polyline points="9 18 15 12 9 6"/></svg>
        </a>

        <a href="{{ $asefBrand['url'] }}" target="_blank" rel="noopener" class="asef-contact__item">
            <span class="asef-contact__item__icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
            </span>
            <div>
                <p class="asef-contact__item__label">Web sitesi</p>
                <p class="asef-contact__item__value">www.asefsondaj.com</p>
            </div>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--asef-tertiary);"><polyline points="9 18 15 12 9 6"/></svg>
        </a>
    </div>

    <div class="asef-contact__promo">
        <span class="asef-contact__promo__icon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7h-3V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v3H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/></svg>
        </span>
        <h3>Projenizi birlikte planlayalım</h3>
        <p>Doğru ekipman, zamanında teslimat ve teknik destekle işiniz kolaylaşır. Bize ulaşın, çözüm ortağınız olalım.</p>
    </div>
@endsection
