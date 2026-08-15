@php
    $path = '/' . ltrim(request()->path(), '/');
    $activeKey = 'home';
    if     (str_starts_with($path, '/katalog'))  $activeKey = 'catalog';
    elseif (str_starts_with($path, '/teklif'))   $activeKey = 'quote';
    elseif (str_starts_with($path, '/iletisim')) $activeKey = 'contact';
    elseif ($path !== '/')                       $activeKey = '';
@endphp
<nav class="asef-nav" aria-label="Ana Menü">
    @foreach ($asefNav as $item)
        <a href="{{ $item['url'] }}" class="asef-nav__item {{ $activeKey === $item['key'] ? 'is-active' : '' }}" aria-label="{{ $item['label'] }}">
            @switch($item['icon'])
                @case('home')
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9.5L12 2l9 7.5V21a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1V9.5z"/>
                    </svg>
                    @break
                @case('grid')
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
                    </svg>
                    @break
                @case('cart')
                    <span style="position:relative;display:inline-flex;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
                        </svg>
                        <span class="asef-nav__badge" data-asef-quote-badge>0</span>
                    </span>
                    @break
                @case('chat')
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    @break
            @endswitch
            <span>{{ $item['label'] }}</span>
        </a>
    @endforeach
</nav>
