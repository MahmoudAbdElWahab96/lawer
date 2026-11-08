<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $settings->t('seo_meta_title') ?: $settings->t('lawyer_name'))</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" sizes="any">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32.png') }}?v=2">
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Aref+Ruqaa:wght@400;700&family=Noto+Sans+Arabic:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @include('partials.seo')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-[#f7f3ea] font-sans text-gray-800 antialiased selection:bg-gold/30 selection:text-dark-black">

    @unless(View::hasSection('hide_navbar'))
        @include('partials.navbar')
    @endunless

    <main class="flex-1">
        @yield('content')
    </main>

    @unless(View::hasSection('hide_footer'))
        @include('partials.footer')
    @endunless

    @unless(View::hasSection('hide_floating_whatsapp'))
        @if($settings->whatsappLink())
            <a href="{{ $settings->whatsappLink() }}" target="_blank" rel="noopener"
               aria-label="{{ __('site.contact.whatsapp') }}"
               class="fixed bottom-6 start-6 z-50 flex h-14 w-14 items-center justify-center rounded-full bg-[#1c1a17] text-gold border border-gold shadow-[0px_10px_24px_0px_rgba(15,14,12,0.28)] transition-transform duration-300 hover:scale-110">
                <img src="{{ asset('images/landing/3493a.svg') }}" alt="WhatsApp" class="size-6">
            </a>
        @endif
    @endunless

</body>
</html>
