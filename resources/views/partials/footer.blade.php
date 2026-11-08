@php($homeUrl = route('home', ['locale' => $locale]))

<footer class="mt-16 bg-brand-950 text-brand-100">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 md:grid-cols-3 lg:px-8">
        <div>
            <div class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-900 text-gold-400">⚖</span>
                <span class="text-lg font-bold text-white">{{ $settings->t('lawyer_name') }}</span>
            </div>
            <p class="mt-4 max-w-sm text-sm leading-7 text-brand-200">{{ $settings->t('lawyer_title') }}</p>
        </div>

        <div>
            <h3 class="mb-4 font-semibold text-white">{{ __('site.footer.quick_links') }}</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ $homeUrl }}#practice-areas" class="transition hover:text-gold-300">{{ __('site.nav.practice_areas') }}</a></li>
                <li><a href="{{ $homeUrl }}#about" class="transition hover:text-gold-300">{{ __('site.nav.about') }}</a></li>
                <li><a href="{{ $homeUrl }}#testimonials" class="transition hover:text-gold-300">{{ __('site.nav.testimonials') }}</a></li>
                <li><a href="{{ route('blog.index', ['locale' => $locale]) }}" class="transition hover:text-gold-300">{{ __('site.nav.blog') }}</a></li>
                <li><a href="{{ $homeUrl }}#contact" class="transition hover:text-gold-300">{{ __('site.nav.contact') }}</a></li>
            </ul>
        </div>

        <div>
            <h3 class="mb-4 font-semibold text-white">{{ __('site.nav.contact') }}</h3>
            <ul class="space-y-3 text-sm">
                @if($settings->t('address'))
                    <li class="flex items-start gap-2">
                        <span class="text-gold-400">📍</span>
                        <span>{{ $settings->t('address') }}</span>
                    </li>
                @endif
                @if($settings->phone)
                    <li class="flex items-center gap-2">
                        <span class="text-gold-400">📞</span>
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->phone) }}" class="transition hover:text-gold-300" dir="ltr">{{ $settings->phone }}</a>
                    </li>
                @endif
                @if($settings->email)
                    <li class="flex items-center gap-2">
                        <span class="text-gold-400">✉️</span>
                        <a href="mailto:{{ $settings->email }}" class="transition hover:text-gold-300" dir="ltr">{{ $settings->email }}</a>
                    </li>
                @endif
                @if($settings->t('working_hours'))
                    <li class="flex items-center gap-2">
                        <span class="text-gold-400">🕐</span>
                        <span>{{ $settings->t('working_hours') }}</span>
                    </li>
                @endif
            </ul>

            @if($settings->socialLinks())
                <div class="mt-5 flex items-center gap-3">
                    @foreach($settings->socialLinks() as $key => $url)
                        <a href="{{ $url }}" target="_blank" rel="noopener"
                           class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-900 text-sm font-bold text-brand-100 transition hover:bg-gold-500 hover:text-brand-950">
                            {{ strtoupper(substr($key, 0, 1)) }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="border-t border-brand-900">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-2 px-4 py-5 text-xs text-brand-300 sm:flex-row sm:px-6 lg:px-8">
            <p>© {{ date('Y') }} {{ $settings->t('lawyer_name') }} · {{ __('site.footer.rights') }}</p>
            <p>{{ __('site.hero.free_consultation') }}</p>
        </div>
    </div>
</footer>
