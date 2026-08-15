@extends('asef-theme::layouts.master')

@section('title', $p['name'] . ' — Asef Sondaj')

@section('content')
    <div style="display:flex;align-items:center;gap:12px;margin:16px 0 8px;">
        <a href="/katalog" style="color:var(--asef-ink);display:inline-flex;align-items:center;text-decoration:none;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        </a>
        <span style="flex:1;text-align:center;font-size:14px;font-weight:600;color:var(--asef-ink);letter-spacing:0.02em;">{{ $p['sku'] }}</span>
        <button type="button" style="background:transparent;border:none;color:var(--asef-ink);cursor:pointer;" aria-label="Favori" onclick="this.classList.toggle('is-active');this.querySelector('svg').style.fill=this.classList.contains('is-active')?'#E11D48':'none';this.querySelector('svg').style.stroke=this.classList.contains('is-active')?'#E11D48':'currentColor';">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
        </button>
    </div>

    <div class="asef-pdetail__hero" style="background-image:url('{{ $p['image'] }}')"></div>

    <div class="asef-pdetail__meta">
        <span class="asef-pdetail__catchip">{{ $p['category'] }}</span>
        <span class="asef-pdetail__support">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Teknik destekli
        </span>
    </div>

    <h1 class="asef-pdetail__title">{{ $p['name'] }}</h1>
    <p class="asef-pdetail__desc">{{ $p['desc'] }}</p>

    <div class="asef-pdetail__sec">
        <h3>Kullanım alanları</h3>
        <div class="asef-pdetail__usage">
            @foreach ($p['applications'] as $app)
                <span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0071E3" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $app }}
                </span>
            @endforeach
        </div>
    </div>

    <div class="asef-pdetail__sec">
        <h3>Teknik özellikler</h3>
        <div class="asef-pdetail__specs">
            @foreach (array_values($p['specs']) as $i => $val)
                @php $key = array_keys($p['specs'])[$i]; @endphp
                <div class="asef-pdetail__spec">
                    <div class="asef-pdetail__spec__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
                    <p class="asef-pdetail__spec__key">{{ $key }}</p>
                    <p class="asef-pdetail__spec__val">{{ $val }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="asef-pdetail__info">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
        Doğru ölçü ve bağlantı seçimi için teknik ekibimiz operasyon bilgilerinizi birlikte değerlendirir.
    </div>

    <div class="asef-pdetail__action">
        <div class="asef-stepper" data-asef-stepper>
            <button type="button" data-asef-qty-dec aria-label="Azalt">−</button>
            <input type="number" min="1" max="99" value="1" id="asef-detail-qty" data-asef-qty data-sku="{{ $p['sku'] }}" style="width:36px;">
            <button type="button" data-asef-qty-inc aria-label="Artır">+</button>
        </div>
        <button type="button" class="asef-btn-primary"
                data-asef-add
                data-sku="{{ $p['sku'] }}"
                data-name="{{ $p['name'] }}"
                data-image="{{ $p['image'] }}"
                onclick="this.dataset.qty = document.getElementById('asef-detail-qty').value">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
            Teklif Listesine Ekle
        </button>
        <a class="asef-btn-whatsapp"
           href="https://wa.me/{{ $asefContact['whatsapp'] }}?text={{ urlencode('Merhaba, ' . $p['name'] . ' (' . $p['sku'] . ') hakkında teklif almak istiyorum.') }}"
           target="_blank" rel="noopener" aria-label="WhatsApp ile Teklif İste">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M20.5 3.5A11.85 11.85 0 0 0 12 0C5.4 0 0 5.4 0 12c0 2.1.5 4.1 1.6 5.9L0 24l6.3-1.6c1.7 1 3.6 1.5 5.7 1.5 6.6 0 12-5.4 12-12 0-3.2-1.2-6.2-3.5-8.4z"/></svg>
        </a>
    </div>
@endsection
