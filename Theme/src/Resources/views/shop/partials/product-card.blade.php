@php $urlSku = urlencode($p['sku']); @endphp
<a href="/katalog/urun/{{ $urlSku }}" class="asef-pcard">
    <div class="asef-pcard__img" style="background-image:url('{{ $p['image'] }}')">
        <button type="button" class="asef-pcard__fav" aria-label="Favorilere ekle"
                onclick="event.preventDefault();this.classList.toggle('is-active');">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </button>
        <span class="asef-pcard__sku">{{ $p['sku'] }}</span>
    </div>
    <div class="asef-pcard__body">
        <h3 class="asef-pcard__name">{{ $p['name'] }}</h3>
        <p class="asef-pcard__short">{{ $p['short'] }}</p>
        <div class="asef-pcard__foot">
            <span class="asef-pcard__hint">Teklif ile</span>
            <button type="button" class="asef-pcard__add"
                    data-asef-add
                    data-sku="{{ $p['sku'] }}"
                    data-name="{{ $p['name'] }}"
                    data-image="{{ $p['image'] }}"
                    aria-label="Teklif Listesine Ekle">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
            </button>
        </div>
    </div>
</a>
