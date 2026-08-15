<!doctype html>
<html lang="tr" data-asef-whatsapp="{{ $asefContact['whatsapp'] ?? '905320542975' }}" data-asef-email="{{ $asefContact['email'] ?? 'iletisim@asefsondaj.com' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#F5F5F7">
    <title>@yield('title', $asefBrand['name']) — {{ $asefBrand['tagline'] }}</title>
    <meta name="description" content="{{ $asefBrand['tagline'] }}">
    <link rel="icon" type="image/x-icon" href="/asef-theme/images/favicon.ico">
    <link rel="apple-touch-icon" href="/asef-theme/images/logo.png">
    <link rel="stylesheet" href="/asef-theme/css/asef-theme.css?v={{ filemtime(public_path('asef-theme/css/asef-theme.css')) ?? '1' }}">
    @stack('head')
</head>
<body class="asef-body">
    @include('asef-theme::layouts.header')

    <main class="asef-container">
        @yield('content')
    </main>

    @include('asef-theme::layouts.bottom-nav')

    <script src="/asef-theme/js/asef-quote.js?v={{ filemtime(public_path('asef-theme/js/asef-quote.js')) ?? '1' }}"></script>
    @stack('scripts')
</body>
</html>
