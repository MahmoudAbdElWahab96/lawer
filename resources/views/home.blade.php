@extends('layouts.app')

@section('content')

    @php
        $icons = [
            'users' => '👨‍👩‍👧', 'gavel' => '⚖️', 'briefcase' => '💼', 'building' => '🏢',
            'hard-hat' => '🦺', 'scroll' => '📜', 'scale' => '⚖️', 'shield' => '🛡️',
            'document' => '📄', 'globe' => '🌐',
        ];
    @endphp

    {{-- ===== Hero ===== --}}
    <section class="relative overflow-hidden bg-brand-950 text-white">
        <div class="pointer-events-none absolute inset-0 opacity-20"
             style="background-image: radial-gradient(circle at 20% 20%, #c9a227 0, transparent 45%), radial-gradient(circle at 85% 75%, #1d3a6b 0, transparent 50%);"></div>

        <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-4 py-20 sm:px-6 md:grid-cols-2 md:py-28 lg:px-8">
            <div>
                @if($settings->t('hero_headline'))
                    <h1 class="text-3xl font-bold leading-[1.35] sm:text-4xl lg:text-5xl lg:leading-[1.3]">
                        {{ $settings->t('hero_headline') }}
                    </h1>
                @endif

                @if($settings->t('hero_subheadline'))
                    <p class="mt-6 max-w-xl text-base leading-8 text-brand-100 sm:text-lg sm:leading-9">
                        {{ $settings->t('hero_subheadline') }}
                    </p>
                @endif

                <p class="mt-5 inline-flex items-center gap-2 rounded-full border border-gold-500/40 bg-gold-500/10 px-4 py-1.5 text-sm font-medium text-gold-300">
                    <span>✓</span> {{ __('site.hero.free_consultation') }}
                </p>

                <div class="mt-9 flex flex-wrap items-center gap-4">
                    <a href="#contact"
                       class="rounded-xl bg-gold-500 px-7 py-3.5 text-base font-bold text-brand-950 shadow-lg shadow-gold-500/25 transition hover:bg-gold-400">
                        {{ __('site.hero.cta_primary') }}
                    </a>
                    <a href="#practice-areas"
                       class="rounded-xl border border-white/25 px-7 py-3.5 text-base font-semibold text-white transition hover:bg-white/10">
                        {{ __('site.hero.cta_secondary') }}
                    </a>
                </div>
            </div>

            <div class="relative hidden md:block">
                @if($settings->hero_image_path)
                    <img src="{{ Storage::disk('public')->url($settings->hero_image_path) }}"
                         alt="{{ $settings->t('lawyer_name') }}"
                         class="mx-auto aspect-[4/5] w-full max-w-md rounded-3xl object-cover shadow-2xl ring-1 ring-white/20">
                @else
                    <div class="mx-auto flex aspect-[4/5] w-full max-w-md items-center justify-center rounded-3xl bg-gradient-to-b from-brand-800/60 to-brand-900/30 text-8xl ring-1 ring-white/10">
                        ⚖️
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ===== Stats ===== --}}
    @if($settings->years_experience || $settings->cases_count || $settings->clients_count || $settings->success_rate || $settings->lawyers_count)
        <section class="border-b border-brand-100 bg-brand-50">
            <div class="mx-auto grid max-w-7xl grid-cols-1 divide-y divide-brand-100 px-4 py-10 text-center sm:grid-cols-3 sm:divide-x sm:divide-y-0 sm:px-6 rtl:sm:divide-x-reverse lg:grid-cols-5 lg:px-8">
                @if($settings->clients_count)
                    <div class="py-4 sm:py-0">
                        <p class="text-4xl font-extrabold text-brand-900">{{ number_format($settings->clients_count) }}+</p>
                        <p class="mt-1 text-sm font-medium text-gray-500">{{ __('site.stats.clients') }}</p>
                    </div>
                @endif
                @if($settings->success_rate)
                    <div class="py-4 sm:py-0">
                        <p class="text-4xl font-extrabold text-brand-900">{{ $settings->success_rate }}%</p>
                        <p class="mt-1 text-sm font-medium text-gray-500">{{ __('site.stats.success') }}</p>
                    </div>
                @endif
                @if($settings->lawyers_count)
                    <div class="py-4 sm:py-0">
                        <p class="text-4xl font-extrabold text-brand-900">{{ number_format($settings->lawyers_count) }}+</p>
                        <p class="mt-1 text-sm font-medium text-gray-500">{{ __('site.stats.lawyers') }}</p>
                    </div>
                @endif
                @if($settings->years_experience)
                    <div class="py-4 sm:py-0">
                        <p class="text-4xl font-extrabold text-brand-900">{{ number_format($settings->years_experience) }}+</p>
                        <p class="mt-1 text-sm font-medium text-gray-500">{{ __('site.stats.years') }}</p>
                    </div>
                @endif
                @if($settings->cases_count)
                    <div class="py-4 sm:py-0">
                        <p class="text-4xl font-extrabold text-brand-900">{{ number_format($settings->cases_count) }}+</p>
                        <p class="mt-1 text-sm font-medium text-gray-500">{{ __('site.stats.cases') }}</p>
                    </div>
                @endif
            </div>
        </section>
    @endif

    {{-- ===== Practice Areas ===== --}}
    @if($practiceAreas->isNotEmpty())
        <section id="practice-areas" class="mx-auto max-w-7xl scroll-mt-24 px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-brand-900">{{ __('site.practice_areas.title') }}</h2>
                <p class="mt-3 text-gray-500">{{ __('site.practice_areas.subtitle') }}</p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($practiceAreas as $area)
                    <div class="group rounded-2xl border border-brand-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-gold-300 hover:shadow-lg">
                        <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-brand-50 text-3xl transition group-hover:bg-gold-100">
                            {{ $icons[$area->icon] ?? '⚖️' }}
                        </div>
                        <h3 class="mt-5 text-lg font-bold text-brand-900">{{ $area->t('name') }}</h3>
                        @if($area->t('description'))
                            <p class="mt-2 text-sm leading-7 text-gray-500">{{ $area->t('description') }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Features / Why us ===== --}}
    @if($features->isNotEmpty())
        <section id="features" class="border-y border-brand-100 bg-brand-50/60 py-20">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl text-center">
                    <h2 class="text-3xl font-bold text-brand-900">{{ __('site.features.title') }}</h2>
                    <p class="mt-3 text-gray-500">{{ __('site.features.subtitle') }}</p>
                </div>

                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    @foreach($features as $feature)
                        <div class="rounded-2xl border border-brand-100 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-gold-100 text-3xl">
                                {{ ['experience' => '🏆', 'strategy' => '♟️', 'trophy' => '🥇', 'shield' => '🛡️', 'clock' => '⏱️', 'users' => '👥'][$feature->icon] ?? '⭐' }}
                            </div>
                            <h3 class="mt-5 text-lg font-bold leading-8 text-brand-900">{{ $feature->t('title') }}</h3>
                            @if($feature->t('text'))
                                <p class="mt-2 text-sm leading-7 text-gray-500">{{ $feature->t('text') }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===== About ===== --}}
    <section id="about" class="scroll-mt-24 border-y border-brand-100 bg-brand-50/60 py-20">
        <div class="mx-auto grid max-w-7xl items-start gap-12 px-4 sm:px-6 md:grid-cols-5 lg:px-8">
            <div class="md:col-span-2">
                <div class="flex aspect-square items-center justify-center rounded-3xl bg-brand-900 text-8xl shadow-xl">⚖️</div>
            </div>
            <div class="md:col-span-3">
                <h2 class="text-3xl font-bold text-brand-900">{{ $settings->t('about_title') ?: __('site.nav.about') }}</h2>
                <div class="prose-legal mt-6 max-w-none">
                    {!! $settings->t('about_text') !!}
                </div>
                <a href="#contact" class="mt-6 inline-flex items-center gap-2 font-semibold text-gold-600 transition hover:text-gold-500">
                    {{ __('site.hero.cta_primary') }} <span class="rtl:rotate-180">→</span>
                </a>
            </div>
        </div>
    </section>

    {{-- ===== Testimonials ===== --}}
    @if($testimonials->isNotEmpty())
        <section id="testimonials" class="mx-auto max-w-7xl scroll-mt-24 px-4 py-20 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold text-brand-900">{{ __('site.testimonials.title') }}</h2>
                <p class="mt-3 text-gray-500">{{ __('site.testimonials.subtitle') }}</p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-2">
                @foreach($testimonials as $testimonial)
                    <figure class="flex flex-col justify-between rounded-2xl border border-brand-100 bg-white p-7 shadow-sm">
                        <blockquote class="text-[15px] leading-8 text-gray-600">
                            {{ $testimonial->t('content') }}
                        </blockquote>
                        <figcaption class="mt-6 flex items-center justify-between border-t border-brand-50 pt-5">
                            <div>
                                <p class="font-bold text-brand-900">{{ $testimonial->client_name }}</p>
                                @if($testimonial->t('client_role'))
                                    <p class="mt-0.5 text-xs text-gray-400">{{ $testimonial->t('client_role') }}</p>
                                @endif
                            </div>
                            <div class="text-lg text-gold-500" aria-label="{{ $testimonial->rating }}/5">
                                {{ str_repeat('★', $testimonial->rating) . str_repeat('☆', 5 - $testimonial->rating) }}
                            </div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== FAQ ===== --}}
    @if($faqs->isNotEmpty())
        <section id="faq" class="scroll-mt-24 border-y border-brand-100 bg-brand-50/60 py-20">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-brand-900">{{ __('site.faq.title') }}</h2>
                    <p class="mt-3 text-gray-500">{{ __('site.faq.subtitle') }}</p>
                </div>

                <div class="mt-10 space-y-4">
                    @foreach($faqs as $faq)
                        <details class="group rounded-2xl border border-brand-100 bg-white p-5 shadow-sm open:border-gold-300">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 font-semibold text-brand-900 [&::-webkit-details-marker]:hidden">
                                <span>{{ $faq->t('question') }}</span>
                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700 transition group-open:bg-gold-500 group-open:text-brand-950">+</span>
                            </summary>
                            <p class="mt-4 border-t border-brand-50 pt-4 text-sm leading-8 text-gray-600">{{ $faq->t('answer') }}</p>
                        </details>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ===== Latest Articles ===== --}}
    @if($articles->isNotEmpty())
        <section id="blog" class="mx-auto max-w-7xl scroll-mt-24 px-4 py-20 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-brand-900">{{ __('site.blog.title') }}</h2>
                    <p class="mt-3 text-gray-500">{{ __('site.blog.subtitle') }}</p>
                </div>
                <a href="{{ route('blog.index', ['locale' => $locale]) }}"
                   class="font-semibold text-gold-600 transition hover:text-gold-500">
                    {{ __('site.blog.back') }} →
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-3">
                @foreach($articles as $article)
                    <a href="{{ route('blog.show', ['locale' => $locale, 'article' => $article->slug]) }}"
                       class="group flex flex-col overflow-hidden rounded-2xl border border-brand-100 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        @if($article->cover_path)
                            <img src="{{ Storage::disk('public')->url($article->cover_path) }}"
                                 alt="{{ $article->t('title') }}" class="aspect-video w-full object-cover">
                        @else
                            <div class="flex aspect-video w-full items-center justify-center bg-brand-50 text-5xl">📰</div>
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            <p class="text-xs font-medium text-gray-400">{{ $article->published_at->format('Y/m/d') }}</p>
                            <h3 class="mt-2 font-bold leading-7 text-brand-900 group-hover:text-gold-700">{{ $article->t('title') }}</h3>
                            @if($article->t('excerpt'))
                                <p class="mt-3 line-clamp-3 text-sm leading-7 text-gray-500">{{ $article->t('excerpt') }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Contact ===== --}}
    <section id="contact" class="scroll-mt-24 bg-brand-950 py-20 text-white">
        <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
            <div>
                <h2 class="text-3xl font-bold">{{ __('site.contact.title') }}</h2>
                <p class="mt-4 max-w-md leading-8 text-brand-200">{{ __('site.contact.subtitle') }}</p>

                <div class="mt-10 space-y-5 text-sm">
                    @if($settings->t('address'))
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-900 text-gold-400">📍</span>
                            <div>
                                <p class="font-bold">{{ __('site.contact.address') }}</p>
                                <p class="mt-1 leading-7 text-brand-200">{{ $settings->t('address') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($settings->phone)
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-900 text-gold-400">📞</span>
                            <div>
                                <p class="font-bold">{{ __('site.contact.call_now') }}</p>
                                <a href="tel:{{ preg_replace('/\s+/', '', $settings->phone) }}" class="mt-1 block text-brand-200 transition hover:text-gold-300" dir="ltr">{{ $settings->phone }}</a>
                            </div>
                        </div>
                    @endif
                    @if($settings->t('working_hours'))
                        <div class="flex items-start gap-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-brand-900 text-gold-400">🕐</span>
                            <div>
                                <p class="font-bold">{{ __('site.contact.working_hours') }}</p>
                                <p class="mt-1 text-brand-200">{{ $settings->t('working_hours') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="rounded-3xl bg-white p-8 text-gray-800 shadow-2xl">
                @if(session('contact_success'))
                    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-700">
                        {{ __('site.contact.success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store', ['locale' => $locale]) }}" method="POST" class="space-y-5">
                    @csrf

                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-brand-900">{{ __('site.contact.name') }} *</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required
                               class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 @error('name') border-red-400 @enderror">
                        @error('name')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-semibold text-brand-900">{{ __('site.contact.phone') }} *</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required dir="ltr"
                                   class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 @error('phone') border-red-400 @enderror">
                            @error('phone')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="email" class="mb-1.5 block text-sm font-semibold text-brand-900">{{ __('site.contact.email') }}</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" dir="ltr"
                                   class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 @error('email') border-red-400 @enderror">
                            @error('email')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="practice_area_id" class="mb-1.5 block text-sm font-semibold text-brand-900">{{ __('site.contact.consultation_type') }}</label>
                        <select id="practice_area_id" name="practice_area_id"
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100">
                            <option value="">{{ __('site.contact.choose_type') }}</option>
                            @foreach($practiceAreas as $area)
                                <option value="{{ $area->id }}" @selected(old('practice_area_id') == $area->id)>{{ $area->t('name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="message" class="mb-1.5 block text-sm font-semibold text-brand-900">{{ __('site.contact.message') }} *</label>
                        <textarea id="message" name="message" rows="4" required
                                  class="w-full rounded-xl border border-gray-200 px-4 py-3 text-sm outline-none transition focus:border-brand-500 focus:ring-2 focus:ring-brand-100 @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                        @error('message')<p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <button type="submit"
                            class="w-full rounded-xl bg-brand-900 py-3.5 text-sm font-bold text-white transition hover:bg-brand-800">
                        {{ __('site.contact.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </section>

@endsection
