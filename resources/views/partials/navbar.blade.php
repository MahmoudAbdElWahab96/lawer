@php($otherLocale = $locale === 'ar' ? 'en' : 'ar')
@php($otherLocaleLabel = $locale === 'ar' ? 'English' : 'العربية')
@php($homeUrl = route('home', ['locale' => $locale]))

<header class="sticky top-0 z-40 border-b border-brand-100 bg-white/95 backdrop-blur">
    <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
        <a href="{{ $homeUrl }}" class="flex items-center gap-3">
            @if($settings->logo_path)
                <img src="{{ Storage::disk('public')->url($settings->logo_path) }}" alt="{{ $settings->t('lawyer_name') }}" class="h-11 w-auto">
            @else
                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-brand-900 text-lg font-bold text-gold-400">⚖</span>
            @endif
            <span class="flex flex-col leading-tight">
                <span class="text-base font-bold text-brand-900">{{ $settings->t('lawyer_name') }}</span>
                <span class="text-xs text-gray-500">{{ $settings->t('lawyer_title') }}</span>
            </span>
        </a>

        <nav class="order-3 flex w-full flex-wrap items-center gap-x-5 gap-y-2 text-sm font-medium text-gray-600 sm:order-2 sm:w-auto lg:gap-x-7">
            <a href="{{ $homeUrl }}#practice-areas" class="transition hover:text-brand-800">{{ __('site.nav.practice_areas') }}</a>
            <a href="{{ $homeUrl }}#about" class="transition hover:text-brand-800">{{ __('site.nav.about') }}</a>
            <a href="{{ $homeUrl }}#testimonials" class="transition hover:text-brand-800">{{ __('site.nav.testimonials') }}</a>
            <a href="{{ $homeUrl }}#faq" class="transition hover:text-brand-800">{{ __('site.nav.faq') }}</a>
            <a href="{{ route('blog.index', ['locale' => $locale]) }}" class="transition hover:text-brand-800">{{ __('site.nav.blog') }}</a>
        </nav>

        <div class="order-2 flex items-center gap-3 sm:order-3">
            <a href="{{ \App\Support\LocalizedUrl::current($otherLocale) }}"
               class="rounded-lg border border-brand-200 px-3 py-1.5 text-sm font-semibold text-brand-800 transition hover:bg-brand-50">
                {{ $otherLocaleLabel }}
            </a>
            @if($settings->phone)
                <a href="tel:{{ preg_replace('/\s+/', '', $settings->phone) }}"
                   class="hidden rounded-lg bg-brand-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-800 sm:block">
                    {{ __('site.contact.call_now') }}
                </a>
            @endif
        </div>
    </div>
</header>
