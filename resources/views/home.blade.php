@extends('layouts.app')

@section('hide_navbar', 'true')
@section('hide_footer', 'true')
@section('hide_floating_whatsapp', 'true')

@section('content')

@php
    $whatsappUrl = $settings->whatsappLink() ?: 'https://wa.me/201000000000';
    $phoneClean = preg_replace('/\s+/', '', $settings->phone ?: '+201000000000');
    $lawyerName = $settings->t('lawyer_name') ?: ($locale === 'en' ? 'Ali El-Deeb' : 'علي الديب');
    $lawyerTitle = $settings->t('lawyer_title') ?: ($locale === 'en' ? 'Attorney at the High Court of Appeal & State Council' : 'المحامي بالاستئناف العالي ومجلس الدولة');
    $isRtl = ($dir === 'rtl');
    $socialLinks = collect([
        ['url' => $settings->facebook, 'label' => $locale === 'ar' ? 'فيسبوك' : 'Facebook'],
        ['url' => $settings->instagram, 'label' => $locale === 'ar' ? 'إنستجرام' : 'Instagram'],
        ['url' => $settings->youtube, 'label' => $locale === 'ar' ? 'يوتيوب' : 'YouTube'],
        ['url' => $settings->linkedin, 'label' => $locale === 'ar' ? 'لينكدإن' : 'LinkedIn'],
        ['url' => $settings->x_url, 'label' => 'X'],
    ])->filter(fn (array $social): bool => filled($social['url']));
    $bookingIcons = ['d6be1.svg' => 'booking-family.svg', '8ee21.svg' => 'a2123.svg', '3d433.svg' => '1b404.svg', 'fd282.svg' => 'ea50c.svg', '630cd.svg' => 'aded1.svg', '2fdca.svg' => '0abef.svg'];
    $bookingOrder = array_flip(array_keys($bookingIcons));
    $bookingAreas = $practiceAreas->sortBy(fn ($area): int => $bookingOrder[$area->icon] ?? PHP_INT_MAX)->map(fn ($area): array => [
        'id' => $area->id,
        'name' => $area->t('name'),
        'icon' => asset('images/landing/'.($bookingIcons[$area->icon] ?? 'booking-family.svg')),
    ])->values();
    $breakBefore = fn (string $text, string $marker): string => str_replace(' '.$marker, "\n".$marker, $text);
@endphp

<div class="bg-[#f7f3ea] text-text-primary overflow-x-hidden selection:bg-gold/30 selection:text-dark-black" dir="{{ $dir }}">

    {{-- ============================================================== --}}
    {{-- 1. HERO SECTION                                                --}}
    {{-- ============================================================== --}}
    <section id="hero" class="p-2 sm:p-4 lg:p-4 max-w-[1440px] mx-auto">
        <div class="relative bg-dark-card rounded-[28px] overflow-hidden min-h-[900px] lg:h-[948px] text-paper flex flex-col justify-between p-6 sm:p-8 lg:p-12 xl:px-11 xl:pt-3 xl:pb-0">

            @php
                $heroImgSrc = asset('images/landing/497c8.png');
                if ($settings->hero_image_path) {
                    $heroImgSrc = (str_starts_with($settings->hero_image_path, 'images/') || str_starts_with($settings->hero_image_path, '/images/'))
                        ? asset(ltrim($settings->hero_image_path, '/'))
                        : Storage::disk('public')->url($settings->hero_image_path);
                }
                $heroHeadline = $settings->t('hero_headline') ?: ($locale === 'en' ? 'Your case deserves someone who reads it with care' : 'قضيتك تستحق من يقرأها بعناية');
                $heroHeadlineHtml = preg_replace('/(بعناية|with care)/iu', '<span class="text-gold">$1</span>', str_replace(' من يقرأها', '<br>من يقرأها', e($heroHeadline)));
                $lawyerShortTitle = \Illuminate\Support\Str::before($lawyerTitle, ' · ');
                $heroTicks = [
                    ['text' => __('site.hero.guarantee_3'), 'icon' => '28418.svg', 'rotation' => 'rotate-6'],
                    ['text' => __('site.hero.guarantee_2'), 'icon' => 'a0fa9.svg', 'rotation' => '-rotate-4'],
                    ['text' => __('site.hero.guarantee_1'), 'icon' => '776ff.svg', 'rotation' => 'rotate-6'],
                ];
                $heroStats = [
                    ['value' => $settings->years_experience ?: 15, 'label' => __('site.hero.years_exp')],
                    ['value' => $settings->clients_count ?: 2000, 'label' => __('site.hero.clients_trusted')],
                    ['value' => $settings->lawyers_count ?: 20, 'label' => __('site.hero.lawyers_team')],
                ];
            @endphp
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <img src="{{ $heroImgSrc }}"
                     alt="{{ $lawyerName }}"
                     class="hidden md:block absolute {{ $isRtl ? 'left-2 xl:left-[78px]' : 'right-2 xl:right-[78px] -scale-x-100' }} top-10 xl:top-[41px] h-[680px] lg:h-[764px] xl:w-[509px] object-contain xl:object-cover object-bottom">

                <div class="absolute inset-y-0 {{ $isRtl ? 'left-0' : 'right-0' }} w-[56%] bg-dark-card opacity-28 mix-blend-color"></div>
                <div class="hidden md:block absolute inset-y-0 {{ $isRtl ? 'left-0 bg-[linear-gradient(to_right,rgba(43,39,36,0)_45%,rgba(43,39,36,0.52)_75%,rgba(43,39,36,0.75))]' : 'right-0 bg-[linear-gradient(to_left,rgba(43,39,36,0)_45%,rgba(43,39,36,0.52)_75%,rgba(43,39,36,0.75))]' }} w-[56%]"></div>
                <div class="hidden md:block absolute inset-y-0 {{ $isRtl ? 'left-0 bg-[linear-gradient(to_right,rgba(43,39,36,0.64),rgba(43,39,36,0.26)_45%,rgba(43,39,36,0))]' : 'right-0 bg-[linear-gradient(to_left,rgba(43,39,36,0.64),rgba(43,39,36,0.26)_45%,rgba(43,39,36,0))]' }} w-[22.4%]"></div>
                <div class="absolute inset-y-0 {{ $isRtl ? 'left-0' : 'right-0' }} w-full md:w-[56%] bg-[linear-gradient(to_bottom,rgba(43,39,36,0)_66%,rgba(43,39,36,0.75)_84%)]"></div>
            </div>

            <header class="relative z-30 flex items-center justify-between gap-4 w-full xl:h-16">
                <div class="flex items-baseline gap-3 text-start">
                    <span class="{{ $isRtl ? 'font-ruqaa text-[32px]' : 'font-serif font-bold text-2xl sm:text-3xl' }} text-gold leading-[1.5]">{{ $lawyerName }}</span>
                    <span class="hidden sm:inline-block text-[13px] text-text-on-dark font-medium">{{ __('site.nav.badge') }}</span>
                </div>

                <nav class="hidden lg:flex items-center gap-1 backdrop-blur-[8px] bg-dark-surface border border-paper rounded-full px-2 py-1 text-[15px] leading-[1.7]">
                    <a href="#hero" class="bg-paper text-dark-black font-bold rounded-full px-3 py-2">{{ __('site.nav.home') }}</a>
                    <a href="#about" class="px-3 pt-2 pb-1 text-text-on-dark hover:text-white transition">{{ __('site.nav.about') }}</a>
                    <a href="#practice" class="px-3 pt-2 pb-1 text-text-on-dark hover:text-white transition">{{ __('site.nav.services') }}</a>
                    <a href="#route" class="px-3 pt-2 pb-1 text-text-on-dark hover:text-white transition">{{ __('site.nav.route') }}</a>
                    <a href="#faq" class="px-3 pt-2 pb-1 text-text-on-dark hover:text-white transition">{{ __('site.nav.faq') }}</a>
                    <a href="#contact" class="px-3 pt-2 pb-1 text-text-on-dark hover:text-white transition">{{ __('site.nav.contact') }}</a>
                    <a href="{{ \App\Support\LocalizedUrl::current($locale === 'ar' ? 'en' : 'ar') }}"
                       class="ms-1 px-3 py-1 rounded-full border border-paper/30 text-xs font-semibold hover:bg-paper/10 text-paper transition">{{ __('site.nav.switch_lang') }}</a>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="{{ \App\Support\LocalizedUrl::current($locale === 'ar' ? 'en' : 'ar') }}"
                       class="lg:hidden px-3 py-1.5 rounded-full border border-paper/30 text-xs font-semibold hover:bg-paper/10 text-paper transition">{{ $locale === 'ar' ? 'EN' : 'عربي' }}</a>
                    <a href="#booking" class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition-all">
                        <span>{{ __('site.nav.book') }}</span>
                        <span class="bg-dark-surface size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                            <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                        </span>
                    </a>
                </div>
            </header>

            <div class="relative z-20 my-auto pt-10 pb-6 lg:py-0 flex flex-col items-start text-start gap-6 max-w-2xl xl:max-w-none xl:absolute xl:my-0 xl:top-[208px] xl:start-[152px]">

                <div class="relative size-24 sm:size-[104px] opacity-92 -rotate-10 xl:absolute xl:-top-[118px] xl:-start-[26px]">
                    <img src="{{ asset('images/landing/88760.svg') }}" alt="" class="absolute inset-[4%] size-[92%]">
                    <img src="{{ asset('images/landing/1823c.svg') }}" alt="" class="absolute inset-[8%] size-[84%]">
                    <img src="{{ asset('images/landing/db849.svg') }}" alt="" class="absolute inset-[23.33%] size-[53.33%]">
                    <svg viewBox="0 0 104 104" class="absolute inset-0 size-full" aria-hidden="true">
                        <defs><path id="hero-seal-curve" d="M52 52m-33.5 0a33.5 33.5 0 1 1 67 0a33.5 33.5 0 1 1-67 0"/></defs>
                        <text class="fill-gold font-sans" font-size="7.2" text-anchor="middle" direction="{{ $dir }}"><textPath href="#hero-seal-curve" startOffset="25%">{{ __('site.hero.stamp_ring') }}</textPath></text>
                    </svg>
                    <span class="absolute inset-x-0 top-[30px] text-center {{ $isRtl ? 'font-ruqaa text-[20.8px]' : 'font-serif font-bold text-lg' }} leading-[1.5] text-gold">{{ __('site.hero.stamp_abbr') }}</span>
                    <span class="absolute inset-x-0 top-[59px] text-center font-medium text-[7.6px] leading-[1.5] text-gold">{{ __('site.hero.stamp_year') }}</span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl {{ $isRtl ? 'lg:text-[76px]' : 'lg:text-[64px] xl:max-w-[680px]' }} font-bold text-paper leading-[1.28]">{!! $heroHeadlineHtml !!}</h1>

                <p class="text-base sm:text-lg lg:text-[19px] text-text-on-dark leading-[1.8] max-w-[520px]">
                    {{ $settings->t('hero_subheadline') ?: ($locale === 'en' ? 'We listen to you first, then establish a written roadmap for your case in family, civil, commercial, and criminal law with full confidentiality.' : 'نستمع لك أولًا، ثم نضع لقضيتك خطة مكتوبة في الأسرة والمدني والتجاري والجنائي، وبسرية تامة حتى صدور الحكم.') }}
                </p>

                <div class="flex flex-wrap items-center gap-y-3 text-[15px] leading-[1.7] text-paper">
                    @foreach($heroTicks as $tick)
                        @if(! $loop->first)
                            <span class="hidden sm:block h-6 w-px bg-paper opacity-35"></span>
                        @endif
                        <div class="flex items-center gap-3 {{ $loop->first ? 'pe-4' : ($loop->last ? 'ps-4' : 'px-4') }}">
                            <span class="size-12 flex items-center justify-center shrink-0">
                                <img src="{{ asset('images/landing/'.$tick['icon']) }}" alt="" class="size-[53px] max-w-none {{ $tick['rotation'] }}">
                            </span>
                            <span>{{ $tick['text'] }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <a href="#booking" class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition-all">
                        <span>{{ __('site.hero.cta_book') }}</span>
                        <span class="bg-dark-surface size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                            <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                        </span>
                    </a>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                       class="h-[58px] rounded-full border border-gold bg-gold/8 hover:bg-gold/20 text-paper px-6 text-[17px] leading-[1.8] transition flex items-center">{{ __('site.hero.cta_whatsapp') }}</a>
                </div>
            </div>

            <div class="relative z-20 -mx-6 -mb-6 sm:-mx-8 sm:-mb-8 lg:-mx-12 lg:-mb-12 xl:-mx-11 xl:mb-0 mt-12 xl:mt-0 xl:h-[140px] bg-dark-surface border-t border-paper px-6 sm:px-10 xl:ps-[138px] xl:pe-[100px] py-6 xl:py-0 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4 text-start">
                    <div class="relative size-14 shrink-0">
                        <img src="{{ asset('images/landing/77912.svg') }}" alt="" class="absolute inset-0.5 size-[52px]">
                        <img src="{{ asset('images/landing/e70d5.svg') }}" alt="" class="absolute inset-1.5 size-11">
                        <span class="absolute inset-0 flex items-center justify-center {{ $isRtl ? 'font-ruqaa text-lg' : 'font-serif font-bold text-sm' }} text-gold">{{ __('site.hero.stamp_abbr') }}</span>
                    </div>
                    <div class="flex flex-col gap-1 leading-[1.7]">
                        <p class="text-base lg:text-[17px] font-semibold text-paper">{{ $lawyerShortTitle }}</p>
                        <p class="text-sm lg:text-base text-text-on-dark">{{ __('site.hero.bar_association') }}</p>
                    </div>
                </div>

                <div class="flex items-center justify-around w-full md:w-auto text-center">
                    @foreach($heroStats as $stat)
                        @if(! $loop->first)
                            <div class="h-[84px] w-px bg-[linear-gradient(to_bottom,rgba(255,255,255,0),rgba(247,242,235,0.3),rgba(255,255,255,0))]"></div>
                        @endif
                        <div class="flex flex-col items-center gap-0.5 px-3 sm:px-8 whitespace-nowrap">
                            <div class="font-serif text-3xl sm:text-5xl lg:text-[60px] font-bold leading-[1.2] text-paper flex items-center justify-center">
                                @if($isRtl)
                                    <span>{{ \App\Models\Setting::formatNumber($stat['value'], 'ar') }}</span><span class="text-gold">+</span>
                                @else
                                    <span class="text-gold">+</span><span>{{ $stat['value'] }}</span>
                                @endif
                            </div>
                            <p class="text-xs sm:text-base leading-[1.7] text-text-on-dark">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 2. ABOUT SECTION ("نبدأ بالاستماع قبل المرافعة")              --}}
    {{-- ============================================================== --}}
    <section id="about" class="py-20 xl:py-0 xl:h-[900px] max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-32 flex flex-col xl:flex-row items-center xl:justify-between gap-12">

        <div class="relative w-full max-w-[460px] xl:w-[460px] shrink-0">
            <div class="rounded-[24px] overflow-hidden aspect-[460/575]">
                <img src="{{ asset('images/landing/41ab2.png') }}" alt="{{ $lawyerName }}" class="w-full h-full object-cover">
            </div>
            <div class="absolute bottom-[39px] {{ $isRtl ? 'left-2 xl:-left-7' : 'right-2 xl:-right-7' }} bg-dark-deep text-paper rounded-[18px] px-6 py-4 shadow-[0px_18px_40px_0px_rgba(15,14,12,0.25)] flex items-center gap-3 whitespace-nowrap">
                <span class="font-serif text-[30px] leading-[1.2] text-gold">{{ \App\Models\Setting::formatNumber($settings->bar_admission_year ?: 2009, $locale) }}</span>
                <p class="text-start text-sm font-medium leading-[1.5] max-w-[100px] whitespace-normal">{{ __('site.about.admitted_since') }}</p>
            </div>
        </div>

        <div class="w-full xl:w-[640px] flex flex-col items-start text-start gap-6">
            <h2 class="font-serif text-3xl sm:text-4xl lg:text-[50px] font-bold text-dark-deep leading-[1.3] whitespace-pre-line">{{ $breakBefore($settings->t('about_title') ?: ($locale === 'en' ? 'We start by listening before pleading' : 'نبدأ بالاستماع قبل المرافعة'), 'قبل المرافعة') }}</h2>

            @if($settings->t('about_text'))
                <div class="text-base sm:text-lg text-text-muted leading-[1.8] max-w-[560px] space-y-6">{!! $settings->t('about_text') !!}</div>
            @else
                <p class="text-base sm:text-lg text-text-muted leading-[1.8] max-w-[560px]">{{ $locale === 'en' ? 'I practice law across family, civil, commercial, and criminal matters. I have learned that a substantial part of any case is resolved before the hearing: in deep listening and meticulous review of every document.' : 'أعمل في المحاماة في قضايا الأسرة والمدني والتجاري والجنائي. وتعلّمت أن جزءًا كبيرًا من القضية يُحسم قبل الجلسة: في الاستماع الجيد، وفي قراءة كل ورقة.' }}</p>
                <p class="text-base sm:text-lg text-text-muted leading-[1.8] max-w-[560px]">{{ $locale === 'en' ? 'That is why every file begins with a full listening session, followed by a written action plan detailing your steps and costs before we commence.' : 'لهذا يبدأ كل ملف عندنا بجلسة استماع كاملة، ثم خطة مكتوبة تعرف فيها خطواتك وتكلفتك قبل أن نبدأ.' }}</p>
            @endif

            <div class="pt-6 border-t border-paper-border w-full flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex flex-col gap-1 text-start">
                    <p class="{{ $isRtl ? 'font-ruqaa text-[46px]' : 'font-serif font-bold text-3xl' }} leading-[1.2] text-dark-deep">{{ $lawyerName }}</p>
                    <p class="text-sm font-medium leading-[1.5] text-text-muted">{{ $lawyerShortTitle }}</p>
                </div>
                <a href="#booking" class="rounded-full border border-dark-deep ps-6 pe-1 py-1 font-semibold text-base leading-[1.5] text-dark-deep hover:bg-dark-deep hover:text-paper transition inline-flex items-center gap-3">
                    <span>{{ __('site.about.cta_listen') }}</span>
                    <img src="{{ asset('images/landing/ac308.svg') }}" alt="" class="size-10 {{ $isRtl ? '' : '-scale-x-100' }}">
                </a>
            </div>
        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 3. PRACTICE AREAS ("ملفات نحملها عنك")                         --}}
    {{-- ============================================================== --}}
    <section id="practice" class="py-20 lg:py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-[120px]">
            
            {{-- Section Heading --}}
            <div class="border-b border-dark-deep/15 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <h2 class="font-serif text-3xl sm:text-5xl lg:text-[60px] font-bold leading-[1.15] text-dark-deep">
                    {{ $settings->t('practice_title') ?: ($locale === 'en' ? 'Cases We Handle for You' : 'ملفات نحملها عنك') }}
                </h2>
                <div class="text-base lg:text-[19px] text-text-primary/72 max-w-[500px] leading-[1.75] text-start">
                    <p>{{ $settings->t('practice_subtitle') ?: ($locale === 'en' ? 'Every case has a dedicated file handled by an attorney who knows you by name, not by number. Choose the practice area closest to your case.' : 'لكل قضية ملف مستقل، يتابعه محامٍ يعرفك باسمك لا برقمك. اختر المجال الأقرب لقضيتك.') }}</p>
                </div>
            </div>

            {{-- 6 Cards Grid --}}
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($practiceAreas as $area)
                    <div class="group practice-card bg-paper border border-paper-border hover:border-dark-deep rounded-[16px] pt-8 px-8 pb-6 flex flex-col justify-between self-stretch transition-all duration-300 hover:-translate-y-1 hover:shadow-[0px_24px_44px_0px_rgba(28,26,23,0.12)]">
                        <div>
                            {{-- Stamp Icon (Top Start): Default = light circle, dark line; Hover = solid #1C1A17, gold #E3C280 --}}
                            <div class="relative size-[66px] shrink-0 self-start mb-8">
                                <img src="{{ asset('images/landing/' . $area->icon) }}" alt="" class="size-[70px] max-w-none absolute -inset-0.5 rotate-6 transition-opacity duration-300 group-hover:opacity-0 pointer-events-none">
                                <img src="{{ asset('images/landing/' . str_replace('.svg', '-hover.svg', $area->icon)) }}" alt="" class="size-[70px] max-w-none absolute -inset-0.5 rotate-6 transition-opacity duration-300 opacity-0 group-hover:opacity-100 pointer-events-none">
                            </div>

                            {{-- Title --}}
                            <h3 class="font-serif text-[26px] font-bold text-dark-deep leading-[1.4] text-start mb-2">
                                {{ $area->t('name') }}
                            </h3>

                            {{-- Bullet points --}}
                            <div class="{{ $isRtl ? 'font-ruqaa text-[21px]' : 'font-sans text-[15px]' }} text-gold-ink leading-[1.8] text-start space-y-0.5">
                                @foreach(explode("\n", $area->t('description')) as $point)
                                    @if(trim($point))
                                        <p class="leading-[1.8]">{{ trim($point) }}</p>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        {{-- Arrow Bar (Bottom End): Default = dark outline, transparent; Hover = solid gold #cfaa62 --}}
                        <div class="pt-8 flex justify-end w-full">
                            <a href="#booking" 
                               class="card-arrow size-11 rounded-full border border-dark-deep bg-transparent group-hover:bg-gold group-hover:border-gold flex items-center justify-center transition-all duration-300 {{ $isRtl ? '' : '-scale-x-100' }}"
                               aria-label="{{ __('site.practice.request_consultation') }} {{ $area->t('name') }}">
                                <div class="relative size-4">
                                    <img src="{{ asset('images/landing/517e8.svg') }}" alt="" class="size-full absolute inset-0 transition-opacity duration-300 group-hover:opacity-0">
                                    <img src="{{ asset('images/landing/ba882.svg') }}" alt="" class="size-full absolute inset-0 transition-opacity duration-300 opacity-0 group-hover:opacity-100">
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- "Not sure?" Bottom Banner --}}
            <div class="mt-12 bg-dark-deep text-paper rounded-[16px] p-6 sm:px-12 sm:py-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="text-start">
                    <p class="font-serif text-2xl leading-[1.4] font-bold text-paper">
                        {{ $settings->t('practice_banner_title') ?: ($locale === 'en' ? 'Not sure where to start?' : 'لا تعرف من أين تبدأ؟') }}
                    </p>
                    <p class="text-text-on-dark text-sm sm:text-base leading-[1.7] mt-1">
                        {{ $settings->t('practice_banner_text') ?: ($locale === 'en' ? 'Send us a brief message about your situation, and we will tell you the right practice area and next step. Without any obligation.' : 'اكتب لنا موقفك في رسالة قصيرة، وسنخبرك بالمجال المناسب وخطوتك التالية. دون أي التزام.') }}
                    </p>
                </div>

                <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                   class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition shrink-0">
                    <span>{{ __('site.practice.banner_ask') }}</span>
                    <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                        <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                    </span>
                </a>
            </div>

        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 4. PLEDGE SECTION ("أربعة بنود نلتزم بها في كل ملف")           --}}
    {{-- ============================================================== --}}
    <section id="pledge" class="py-20 lg:py-32 bg-[#ece6da]">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-[120px]">
            <div class="border-b border-dark-deep/18 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <h2 class="font-serif font-bold text-3xl sm:text-5xl lg:text-[60px] text-dark-deep leading-[1.15] text-start whitespace-pre-line">{{ $settings->t('pledge_title') ?: ($locale === 'en' ? "Four Commitments\nWe Uphold in Every Case" : "أربعة بنود\nنلتزم بها في كل ملف") }}</h2>
                <p class="text-base lg:text-[19px] text-dark-deep/70 leading-[1.75] text-start whitespace-pre-line">{{ $settings->t('pledge_subtitle') ?: ($locale === 'en' ? "Whether your case is large or small,\nthese are our commitments to you." : "كبيرًا كان الملف أو صغيرًا،\nهذه التزاماتنا معك.") }}</p>
            </div>

            {{-- 4 Clauses List --}}
            @php
                $pledgeClauses = $settings->pledge_clauses ?: [
                    [
                        'ordinal' => ['ar' => 'أولًا', 'en' => 'First'],
                        'title' => ['ar' => 'نستمع أولًا', 'en' => 'We Listen First'],
                        'text' => [
                            'ar' => "جلسة استماع كاملة قبل أي رأي قانوني،\nلأن التفاصيل الصغيرة تغيّر القضية.",
                            'en' => "A full listening session before any legal opinion,\nbecause small details can change the entire case.",
                        ],
                    ],
                    [
                        'ordinal' => ['ar' => 'ثانيًا', 'en' => 'Second'],
                        'title' => ['ar' => 'خطة مكتوبة', 'en' => 'A Written Plan'],
                        'text' => [
                            'ar' => "مسار واضح وتكلفة واضحة،\nمكتوبان ومتفق عليهما قبل أن نبدأ.",
                            'en' => "A clear roadmap and transparent costs,\nwritten and agreed upon before we begin.",
                        ],
                    ],
                    [
                        'ordinal' => ['ar' => 'ثالثًا', 'en' => 'Third'],
                        'title' => ['ar' => 'سرية تامة', 'en' => 'Full Confidentiality'],
                        'text' => [
                            'ar' => 'ما تقوله لنا يبقى بيننا، من أول مكالمة حتى بعد صدور الحكم.',
                            'en' => 'What you tell us stays strictly between us, from the very first call until after judgment.',
                        ],
                    ],
                    [
                        'ordinal' => ['ar' => 'رابعًا', 'en' => 'Fourth'],
                        'title' => ['ar' => 'متابعة مستمرة', 'en' => 'Continuous Follow-up'],
                        'text' => [
                            'ar' => "نطلعك على كل تطور في ملفك\nأولاً بأول، دون أن تضطر للسؤال.",
                            'en' => "We proactively update you on every development in your file,\nwithout you having to ask.",
                        ],
                    ],
                ];
            @endphp

            <div class="mt-12">
                @foreach($pledgeClauses as $clause)
                    @php
                        $ord = is_array($clause['ordinal'] ?? null) ? ($clause['ordinal'][$locale] ?? $clause['ordinal']['ar'] ?? '') : ($clause['ordinal'] ?? '');
                        $tit = is_array($clause['title'] ?? null) ? ($clause['title'][$locale] ?? $clause['title']['ar'] ?? '') : ($clause['title'] ?? '');
                        $txt = is_array($clause['text'] ?? null) ? ($clause['text'][$locale] ?? $clause['text']['ar'] ?? '') : ($clause['text'] ?? '');
                    @endphp
                    <div class="py-8 border-b border-dark-deep/14 flex flex-col md:flex-row md:items-baseline gap-4 md:gap-8 text-start">
                        <div class="md:w-[150px] shrink-0 font-serif text-4xl sm:text-5xl lg:text-[56px] leading-none text-gold">{{ $ord }}</div>
                        <div class="md:w-[300px] shrink-0 font-serif text-2xl lg:text-[28px] leading-[1.3] font-bold text-dark-deep">{{ $tit }}</div>
                        <div class="md:w-[440px] text-base lg:text-lg leading-[1.75] text-dark-deep/72 whitespace-pre-line">{{ $txt }}</div>
                    </div>
                @endforeach
            </div>

            <div class="relative w-fit flex items-end pt-[200px]">
                <div class="absolute top-[5px] {{ $isRtl ? 'left-[-14px]' : 'right-[-14px] -scale-x-100' }} w-[152px] h-[240px] pointer-events-none drop-shadow-[-12px_16px_20px_rgba(0,0,0,0.45)]">
                    <div class="absolute inset-0 overflow-hidden">
                        <img src="{{ asset('images/landing/23f8d.png') }}" alt="" class="absolute h-[184.23%] left-[-86.11%] max-w-none top-[-44.8%] w-[291.72%]">
                    </div>
                </div>
                <p class="{{ $isRtl ? 'font-ruqaa' : 'font-serif italic' }} text-[30px] leading-[1.4] text-gold whitespace-nowrap">{{ $settings->t('pledge_sign_text') ?: __('site.pledge.sign_text') }}</p>
                <div class="w-6 h-px"></div>
                <div class="w-[120px] sm:w-[200px] h-px bg-gold/55"></div>
            </div>

        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 5. ROUTE TRACKER ("من أول مكالمة حتى إغلاق الملف")            --}}
    {{-- ============================================================== --}}
    <section id="route" class="py-20 lg:py-32 max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-[120px]"
             x-data="{
                step: 1,
                autoPlay: true,
                timer: null,
                init() {
                    this.timer = setInterval(() => {
                        if (this.autoPlay) {
                            this.step = this.step >= 4 ? 1 : this.step + 1;
                        }
                    }, 2400);
                }
             }"
             @mouseenter="autoPlay = false"
             @mouseleave="autoPlay = true">

        <div class="border-b border-dark-deep/15 pb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
            <h2 class="font-serif text-3xl sm:text-5xl lg:text-[60px] font-bold text-dark-deep leading-[1.15] text-start whitespace-pre-line">{{ $breakBefore($settings->t('route_title') ?: ($locale === 'en' ? 'From First Call to Case Closure' : 'من أول مكالمة حتى إغلاق الملف'), 'حتى إغلاق') }}</h2>
            <p class="text-base lg:text-[19px] leading-[1.75] text-[#3b362f]/85 text-start whitespace-pre-line">{{ str_replace('، ', "،\n", $settings->t('route_subtitle') ?: ($locale === 'en' ? 'Four clear stages so you always know where your file stands.' : 'أربع مراحل واضحة، تعرف في كل لحظة أين وصل ملفك.')) }}</p>
        </div>

        <div class="mt-12 flex flex-col xl:flex-row justify-between gap-12">
            @php
                $stepDigits = $isRtl ? [1 => '١', 2 => '٢', 3 => '٣', 4 => '٤'] : [1 => '1', 2 => '2', 3 => '3', 4 => '4'];
            @endphp

            <div class="w-full xl:w-[510px] flex flex-col items-start">
                <div class="relative w-full">
                    <div class="absolute top-12 bottom-[63px] {{ $isRtl ? 'right-[47px]' : 'left-[47px]' }} w-0.5 bg-gold/35">
                        <div class="w-full bg-dark-deep transition-all duration-500" :style="`height: ${(step - 1) / 3 * 100}%`"></div>
                    </div>
                    @foreach([1, 2, 3, 4] as $num)
                        <button type="button" @click="step = {{ $num }}"
                                :class="step === {{ $num }} ? 'bg-white shadow-[0px_12px_32px_0px_rgba(28,26,23,0.08)]' : ''"
                                class="relative w-full cursor-pointer rounded-[16px] p-6 flex items-start gap-6 text-start transition-all duration-300">
                            <span :class="step === {{ $num }} ? 'bg-dark-deep text-gold-light' : 'bg-paper text-[#9c8456] border-[1.5px] border-[rgba(138,106,46,0.6)]'"
                                  class="size-12 rounded-full flex items-center justify-center font-serif text-[22px] leading-none shrink-0 transition-all">{{ $stepDigits[$num] }}</span>
                            <span class="flex flex-col gap-1">
                                <span class="font-serif text-2xl leading-[1.3] text-dark-deep">{{ __("site.route.stages.$num.name") }}</span>
                                <span class="text-base leading-[1.75] text-[#504a41]">{{ __("site.route.stages.$num.desc") }}</span>
                            </span>
                        </button>
                    @endforeach
                </div>

                <div class="ps-6 pt-6">
                    <a href="#booking" class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition">
                        <span>{{ __('site.route.first_step_cta') }}</span>
                        <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                            <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                        </span>
                    </a>
                </div>
            </div>

            <div class="relative w-full xl:w-[560px] xl:h-[434px] flex justify-center pt-8 xl:pt-0">
                <div class="relative w-[360px] max-w-full h-[326px] xl:absolute xl:left-[108px] xl:top-[30px] bg-[#e9ddc2] rounded-[8px] drop-shadow-[0px_30px_30px_rgba(28,26,23,0.18)] {{ $isRtl ? '-rotate-3' : 'rotate-3' }}">
                    <div class="absolute -top-7 {{ $isRtl ? 'right-6' : 'left-6' }} w-[150px] h-[34px] bg-[#e9ddc2] rounded-t-[8px] text-center pt-1.5">
                        <span class="font-serif text-[15px] leading-[1.2] text-gold-ink">{{ __('site.route.file_no') }}</span>
                    </div>

                    <div class="absolute inset-x-7 top-7 bg-[#fffdf7] rounded-[4px] pt-8 pb-6 px-7 flex flex-col gap-[18px] text-start">
                        <h4 class="font-serif text-[22px] leading-[1.3] font-bold text-dark-deep">{{ __('site.route.opening_note') }}</h4>
                        <div class="h-px bg-[#e4dccb]"></div>

                        @php($routeValueClass = ($isRtl ? 'font-ruqaa text-[18px]' : 'font-serif font-bold text-sm').' leading-[1.1] text-dark-deep')
                        @foreach([
                            ['label' => __('site.route.opened_date'), 'text' => __('site.route.opened_today')],
                            ['label' => __('site.route.case_type'), 'expression' => "step >= 2 ? '".__('site.route.under_study')."' : ''"],
                            ['label' => __('site.route.plan_and_cost'), 'expression' => "step >= 3 ? '".__('site.route.approved')."' : ''"],
                            ['label' => __('site.route.lawyer_in_charge'), 'text' => $lawyerName],
                        ] as $field)
                            <div class="flex items-end gap-3">
                                <span class="text-sm leading-[1.2] text-[#776f63] whitespace-nowrap">{{ $field['label'] }}</span>
                                <span class="flex-1 min-h-[24px] border-b border-dashed border-[#b9ae96] pb-0.5 {{ $routeValueClass }}" @isset($field['expression']) x-text="{{ $field['expression'] }}" @endisset>{{ $field['text'] ?? '' }}</span>
                            </div>
                        @endforeach

                        <div x-show="step === 4"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-50"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute -bottom-4 {{ $isRtl ? '-left-6 rotate-6' : '-right-6 -rotate-6' }} bg-[#fffcf7] border-2 border-gold-ink rounded-lg px-4 py-2 text-center text-gold-ink shadow-lg pointer-events-none">
                            <p class="font-serif font-bold text-lg leading-tight">{{ __('site.route.file_closed') }}</p>
                            <p class="text-[10px] opacity-80">{{ __('site.route.stage_prefix') }} {{ $stepDigits[4] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 6. WHATSAPP TESTIMONIALS ("رسائل موكلينا")                      --}}
    {{-- ============================================================== --}}
    <section id="messages" class="py-20 lg:py-[116px] bg-white relative overflow-hidden"
             x-data="{
                step: 0,
                timer: null,
                init() {
                    this.timer = setInterval(() => {
                        this.step = this.step >= 4 ? 0 : this.step + 1;
                    }, 1500);
                }
             }">
        
        <div class="absolute inset-0 opacity-35 bg-repeat pointer-events-none"
             style="background-image: url('{{ asset('images/landing/1a5c4.png') }}'); background-size: 100px 100px;"></div>
        <div class="absolute inset-0 pointer-events-none {{ $isRtl ? 'bg-[linear-gradient(90deg,#fff_0%,rgba(255,255,255,0.9)_35%,rgba(255,255,255,0)_62%,rgba(255,255,255,0.3)_100%)]' : 'bg-[linear-gradient(270deg,#fff_0%,rgba(255,255,255,0.9)_35%,rgba(255,255,255,0)_62%,rgba(255,255,255,0.3)_100%)]' }}"></div>

        <div class="relative z-10 max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-[120px]">
            <div class="flex flex-col-reverse xl:flex-row-reverse items-center justify-between gap-12">
                <div class="flex flex-col items-start text-start gap-6">
                    <h2 class="font-serif text-3xl sm:text-5xl lg:text-[60px] text-dark-deep leading-[1.15] whitespace-pre-line">{{ $settings->t('messages_title') ?: ($locale === 'en' ? "Client Messages\nAfter Case Closure" : "رسائل وصلتنا\nبعد إغلاق الملف") }}</h2>
                    <p class="text-base lg:text-[19px] text-[#3b362f] leading-[1.8] whitespace-pre-line">{{ $settings->t('messages_subtitle') ?: ($locale === 'en' ? "We do not write testimonials about ourselves.\nThese are real messages from our clients, published with their permission." : "لا نكتب شهادات عن أنفسنا.\nهذه رسائل موكلينا كما أرسلوها، ننشرها بموافقتهم.") }}</p>
                    <a href="#booking" class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition">
                        <span>{{ __('site.hero.cta_book') }}</span>
                        <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                            <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                        </span>
                    </a>
                </div>

                <div class="flex justify-center xl:-ms-3">
                    <div class="w-[340px] sm:w-[384px] h-[764px] bg-[#efeae2] border-[12px] border-[#121110] rounded-[52px] shadow-[0px_40px_80px_0px_rgba(28,26,23,0.25)] flex flex-col overflow-hidden relative">
                        
                        {{-- Top Header / Status bar --}}
                        <div class="bg-dark-deep text-white">
                            <div class="flex items-center justify-between px-7 pt-3.5 pb-1.5">
                                <span class="font-semibold text-sm">{{ $isRtl ? '٩:٤١' : '9:41' }}</span>
                                <div class="bg-black w-[104px] h-[30px] rounded-[20px]"></div>
                                <img src="{{ asset('images/landing/d6665.svg') }}" alt="" class="w-[46px] h-[11px]">
                            </div>

                            <div class="flex items-center justify-between gap-2.5 px-3.5 pt-2 pb-3">
                                <div class="flex items-center gap-2">
                                    <img src="{{ asset('images/landing/2fc33.svg') }}" alt="" class="size-[22px]">
                                    <div class="size-10 rounded-full bg-gold text-dark-black font-serif text-xl leading-none flex items-center justify-center">
                                        {{ $locale === 'en' ? 'A' : 'ع' }}
                                    </div>
                                    <div class="text-start">
                                        <p class="font-semibold text-base leading-[1.3]">{{ __('site.messages.header_title') }}</p>
                                        <p class="text-xs leading-[1.3] text-white/80" x-text="step === 4 ? '{{ __('site.messages.status_online') }}' : '{{ __('site.messages.typing_indicator') }}'"></p>
                                    </div>
                                </div>
                                <img src="{{ asset('images/landing/3e871.svg') }}" alt="" class="w-[74px] h-[22px]">
                            </div>
                        </div>

                        {{-- Chat Messages Area --}}
                        <div class="flex-1 min-h-0 px-3.5 pt-3 pb-3.5 flex flex-col justify-end gap-1.5 overflow-hidden text-xs sm:text-sm">
                            <div class="self-start shrink-0 bg-white text-[#54656f] px-2.5 py-[5px] rounded-lg text-[11.5px] leading-[1.4]">
                                {{ __('site.messages.today') }}
                            </div>
                            
                            <div class="self-start shrink-0 bg-[#ffeecd] text-[#54656f] px-2.5 py-[5px] rounded-lg text-[11.5px] leading-[1.4] text-start sm:whitespace-nowrap">
                                {{ __('site.messages.privacy_note') }}
                            </div>

                            <p class="self-start shrink-0 text-[10.5px] leading-[1.4] text-[#8696a0]">
                                {{ __('site.messages.demo_note') }}
                            </p>

                            {{-- Message 1 (Step 1+) --}}
                            <div x-show="step >= 1" 
                                 x-transition
                                 class="self-start max-w-[85%] bg-white rounded-bl-lg rounded-br-lg {{ $isRtl ? 'rounded-tl-lg text-right' : 'rounded-tr-lg text-left' }} p-2.5 shadow-sm text-gray-800 leading-relaxed">
                                <p class="font-semibold text-xs text-[#c47a12]">{{ __('site.messages.m1_author') }}</p>
                                <p class="text-[13px] text-[#111b21] mt-0.5">{{ __('site.messages.m1_text') }}</p>
                                <span class="block {{ $isRtl ? 'text-left' : 'text-right' }} text-[10px] text-gray-400 mt-1">{{ __('site.messages.m1_time') }}</span>
                            </div>

                            {{-- Message 2 (Step 2+) --}}
                            <div x-show="step >= 2" 
                                 x-transition
                                 class="self-start max-w-[85%] bg-white rounded-bl-lg rounded-br-lg {{ $isRtl ? 'rounded-tl-lg text-right' : 'rounded-tr-lg text-left' }} p-2.5 shadow-sm text-gray-800 leading-relaxed">
                                <p class="font-semibold text-xs text-[#c47a12]">{{ __('site.messages.m2_author') }}</p>
                                <p class="text-[13px] text-[#111b21] mt-0.5">{{ __('site.messages.m2_text') }}</p>
                                <span class="block {{ $isRtl ? 'text-left' : 'text-right' }} text-[10px] text-gray-400 mt-1">{{ __('site.messages.m2_time') }}</span>
                            </div>

                            {{-- Lawyer Outgoing Reply (Step 3+) --}}
                            <div x-show="step >= 3" 
                                 x-transition
                                 class="self-end max-w-[70%] bg-[#d9fdd3] rounded-bl-lg rounded-br-lg {{ $isRtl ? 'rounded-tr-lg text-right' : 'rounded-tl-lg text-left' }} p-2.5 shadow-sm leading-relaxed">
                                <p class="text-[13px] text-[#111b21]">{{ __('site.messages.reply_text') }}</p>
                                <span class="block {{ $isRtl ? 'text-left' : 'text-right' }} text-[10px] text-[#53bdeb] mt-1">{{ __('site.messages.reply_time') }}</span>
                            </div>

                            {{-- Message 3 (Step 4) --}}
                            <div x-show="step === 4" 
                                 x-transition
                                 class="self-start max-w-[85%] bg-white rounded-bl-lg rounded-br-lg {{ $isRtl ? 'rounded-tl-lg text-right' : 'rounded-tr-lg text-left' }} p-2.5 shadow-sm text-gray-800 leading-relaxed">
                                <p class="font-semibold text-xs text-[#c47a12]">{{ __('site.messages.m3_author') }}</p>
                                <p class="text-[13px] text-[#111b21] mt-0.5">{{ __('site.messages.m3_text') }}</p>
                                <span class="block {{ $isRtl ? 'text-left' : 'text-right' }} text-[10px] text-gray-400 mt-1">{{ __('site.messages.m3_time') }}</span>
                            </div>

                            {{-- Typing Indicator --}}
                            <div x-show="step < 4" class="self-start">
                                <img src="{{ asset('images/landing/af05c.svg') }}" alt="" class="w-[57px] h-[27px]">
                            </div>
                        </div>

                        {{-- Chat Composer Input Bar --}}
                        <div class="px-2.5 pt-2 pb-[22px] flex items-center gap-2">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                               class="flex-1 bg-white rounded-[24px] px-3.5 py-2.5 text-start text-[15px] leading-[1.3] font-semibold text-[#111b21]">
                                {{ __('site.messages.composer_placeholder') }}
                            </a>
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                               class="size-[46px] rounded-full bg-[#00a884] flex items-center justify-center shrink-0 {{ $isRtl ? '' : '-scale-x-100' }}">
                                <img src="{{ asset('images/landing/09c3d.svg') }}" alt="" class="size-5">
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 7. FAQ ACCORDION ("الأسئلة الشائعة")                          --}}
    {{-- ============================================================== --}}
    <section id="faq" class="py-20 lg:py-32 max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-[120px]"
             x-data="{ active: 1 }">
        <div class="flex flex-col xl:flex-row justify-between gap-12 items-start">
            {{-- Side Card (Start Column) --}}
            <div class="w-full xl:w-[440px] flex flex-col items-start text-start">
                <h2 class="font-serif text-3xl sm:text-5xl lg:text-[60px] leading-[1.15] text-dark-deep">
                    {{ $settings->t('faq_title') ?: ($locale === 'en' ? 'Frequently Asked Questions' : 'قبل أن تسأل') }}
                </h2>
                <p class="mt-4 text-base lg:text-[19px] text-[#3b362f] leading-[1.7]">
                    {{ $settings->t('faq_subtitle') ?: ($locale === 'en' ? 'Clear answers to what our clients ask most in the first call.' : 'أكثر ما يسألنا عنه الموكلون في أول مكالمة.') }}
                </p>

                {{-- Ask on WhatsApp Card --}}
                <div class="mt-4 bg-dark-deep text-paper rounded-[24px] p-7 w-full text-start">
                    <h3 class="font-serif text-2xl font-bold text-paper mb-1.5">
                        {{ __('site.faq.not_found_title') }}
                    </h3>
                    <p class="text-text-on-dark text-[15px] leading-[1.7] mb-3">
                        {{ __('site.faq.not_found_desc') }}
                    </p>
                    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
                       class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition">
                        <span>{{ __('site.faq.ask_whatsapp') }}</span>
                        <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                            <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                        </span>
                    </a>
                </div>
            </div>

            {{-- Questions Accordion (End Column) --}}
            <div class="w-full xl:w-[680px] divide-y divide-dark-deep/15 border-y border-dark-deep/15">
                @foreach($faqs as $index => $faq)
                    @php($faqNum = $index + 1)
                    <div class="py-7 transition-all duration-300">
                        <button type="button" 
                                @click="active = (active === {{ $faqNum }} ? null : {{ $faqNum }})"
                                class="w-full flex items-center justify-between gap-4 text-start cursor-pointer group">
                            
                            {{-- Question Text --}}
                            <span class="font-serif text-xl sm:text-[26px] leading-[1.4] text-dark-deep group-hover:text-gold-ink transition">
                                {{ $faq->t('question') }}
                            </span>

                            {{-- Circular +/- Toggle --}}
                            <span :class="active === {{ $faqNum }} ? 'bg-gold border-gold text-dark-black rotate-45' : 'border-gold text-gold-ink bg-transparent'"
                                  class="size-10 rounded-full border-[1.5px] flex items-center justify-center font-bold text-xl shrink-0 transition-all duration-300">
                                +
                            </span>
                        </button>

                        <div x-show="active === {{ $faqNum }}" 
                             x-collapse 
                             class="mt-4 text-sm sm:text-base text-text-muted leading-[1.7] text-start">
                            {!! nl2br(e($faq->t('answer'))) !!}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 8. BOOKING FORM ("افتح ملفك معنا اليوم")                       --}}
    {{-- ============================================================== --}}
    <section id="booking" class="pb-16 max-w-[1440px] mx-auto px-2 sm:px-4">
        <div class="bg-dark-deep text-paper rounded-[32px] p-6 sm:p-10 xl:px-[104px] xl:py-28">
            <div class="flex flex-col xl:flex-row items-start justify-between gap-12">
                
                {{-- Start Column: Copy, Contact Badges & Trust --}}
                <div class="w-full xl:w-[460px] flex flex-col items-start text-start gap-6">
                    <h2 class="font-serif text-3xl sm:text-5xl lg:text-[60px] font-bold text-paper leading-[1.15] whitespace-pre-line">{{ $breakBefore($settings->t('booking_title') ?: ($locale === 'en' ? "Open Your Case File\nWith Us Today" : 'افتح ملفك معنا اليوم'), 'معنا اليوم') }}</h2>

                    <p class="text-base lg:text-lg text-[#d6cfc2] leading-[1.8]">{{ $settings->t('booking_subtitle') ?: ($locale === 'en' ? 'Just two steps: choose your case area, enter your phone number, and we will contact you to schedule your consultation.' : 'خطوتان فقط: اختر مجال قضيتك، واترك رقمك، ونتواصل معك لتحديد موعد الاستشارة.') }}</p>

                    <div class="w-full flex justify-center pt-6">
                        <span class="bg-[#262320] border border-white/9 rounded-full px-4 py-1.5 text-[15px] leading-[1.2] text-paper/75">{{ __('site.booking.direct_speak') }}</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                        <a href="tel:{{ $phoneClean }}" class="bg-[#262320] border border-white/10 rounded-[18px] p-4 flex items-center gap-3.5 hover:bg-white/10 transition">
                            <span class="size-12 rounded-full bg-paper flex items-center justify-center shrink-0">
                                <img src="{{ asset('images/landing/81cb2.svg') }}" alt="" class="size-5">
                            </span>
                            <span class="text-start">
                                <span class="text-xs text-text-on-dark block">{{ __('site.booking.call_us') }}</span>
                                <span class="font-semibold text-paper text-base inline-block" dir="ltr">{{ $settings->phone ?: '+20 100 000 0000' }}</span>
                            </span>
                        </a>
                        <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="bg-gold/15 border border-gold rounded-[18px] p-4 flex items-center gap-3.5 hover:bg-gold/25 transition">
                            <span class="size-12 rounded-full bg-gold flex items-center justify-center shrink-0">
                                <img src="{{ asset('images/landing/6d797.svg') }}" alt="" class="size-5">
                            </span>
                            <span class="text-start">
                                <span class="text-xs text-text-on-dark block">{{ __('site.booking.whatsapp_chat') }}</span>
                                <span class="font-semibold text-paper text-base inline-block" dir="ltr">{{ $settings->whatsapp ?: '+20 100 000 0000' }}</span>
                            </span>
                        </a>
                    </div>

                    <div class="pt-6 border-t border-paper/15 w-full space-y-3 text-base text-text-on-dark text-start px-0">
                        @foreach([1, 2, 3] as $trustIndex)
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/landing/82710.svg') }}" alt="" class="size-2">
                                <span>{{ __("site.booking.trust_$trustIndex") }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- End Column: 2-Step Form Box --}}
                <div class="w-full xl:w-[624px] shrink-0"
                     x-data="{ 
                        tab: 1, 
                        selectedAreaId: @js($bookingAreas->first()['id'] ?? null),
                        selectedAreaName: @js($bookingAreas->first()['name'] ?? __('site.booking.not_sure')),
                        selectedType: '{{ __('site.booking.types.office') }}',
                        notSureName: @js(__('site.booking.not_sure')),
                        areas: @js($bookingAreas),
                        types: {{ json_encode(array_values(__('site.booking.types'))) }}
                     }">
                    
                    <div class="bg-paper text-dark-deep rounded-[24px] p-6 sm:p-12">
                        
                        @if(session('contact_success'))
                            <div class="bg-green-100 border border-green-300 text-green-900 rounded-2xl p-6 text-center">
                                <span class="text-4xl block mb-2">✓</span>
                                <h4 class="font-serif text-2xl font-bold mb-1">{{ __('site.booking.success_title') }}</h4>
                                <p class="text-sm">{{ __('site.booking.success_desc') }}</p>
                            </div>
                        @else
                            {{-- Step Tabs --}}
                            <div class="bg-[#ede5d3] p-[5px] rounded-full flex items-center gap-1 mb-6">
                                <button type="button" @click="tab = 1" 
                                        :class="tab === 1 ? 'bg-white shadow-[0px_4px_14px_0px_rgba(28,26,23,0.1)] text-dark-deep font-semibold' : 'text-[#857d71]'"
                                        class="flex-1 py-2.5 rounded-full text-sm leading-[1.2] text-center flex items-center justify-center gap-2.5 transition">
                                    <span class="size-6 rounded-full bg-dark-deep text-gold-light flex items-center justify-center text-[13px] font-semibold leading-none">{{ $stepDigits[1] }}</span>
                                    <span>{{ __('site.booking.step_1') }}</span>
                                </button>
                                <button type="button" @click="tab = 2" 
                                        :class="tab === 2 ? 'bg-white shadow-[0px_4px_14px_0px_rgba(28,26,23,0.1)] text-dark-deep font-semibold' : 'text-[#857d71]'"
                                        class="flex-1 py-2.5 rounded-full text-sm leading-[1.2] text-center flex items-center justify-center gap-2.5 transition">
                                    <span class="size-6 rounded-full bg-dark-deep/8 flex items-center justify-center text-[13px] font-semibold leading-none">{{ $stepDigits[2] }}</span>
                                    <span>{{ __('site.booking.step_2') }}</span>
                                </button>
                            </div>

                            <form action="{{ route('contact.store', ['locale' => $locale]) }}" method="POST">
                                @csrf

                                {{-- Tab 1: Pick Area & Type --}}
                                <div x-show="tab === 1" x-transition>
                                    <h3 class="font-serif text-[28px] leading-[1.3] font-bold text-dark-deep text-start mb-6">
                                        {{ __('site.booking.which_area') }}
                                    </h3>
                                    
                                    {{-- Areas Grid --}}
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 mb-2.5">
                                        <template x-for="area in areas" :key="area.id">
                                            <button type="button"
                                                    @click="selectedAreaId = area.id; selectedAreaName = area.name"
                                                    :class="selectedAreaId === area.id ? 'bg-dark-deep text-paper border-dark-deep' : 'bg-transparent text-dark-deep border-[#e4dccb] hover:border-gold'"
                                                    class="border-[1.5px] rounded-[14px] py-4 px-2 text-center transition flex flex-col items-center gap-2">
                                                <span :class="selectedAreaId === area.id ? 'bg-gold-light' : 'bg-dark-deep'"
                                                      class="size-[25.2px] [mask-size:contain] [mask-repeat:no-repeat] [-webkit-mask-size:contain] [-webkit-mask-repeat:no-repeat]"
                                                      :style="`mask-image: url('${area.icon}'); -webkit-mask-image: url('${area.icon}');`"></span>
                                                <span class="font-semibold text-sm leading-[1.2]" x-text="area.name"></span>
                                            </button>
                                        </template>
                                    </div>
                                    <button type="button" @click="selectedAreaId = null; selectedAreaName = notSureName"
                                            :class="selectedAreaId === null ? 'bg-dark-deep text-paper border-dark-deep' : 'text-dark-deep border-[#e4dccb] hover:border-gold'"
                                            class="w-full mb-6 border-[1.5px] border-dashed rounded-[14px] py-3 text-center font-semibold text-sm leading-[1.2] transition"><span class="ms-0">؟&nbsp;&nbsp;</span><span x-text="notSureName"></span></button>

                                    {{-- Consult Type Chips --}}
                                    <div class="text-start mb-6">
                                        <label class="block text-sm leading-[1.3] font-semibold text-text-primary mb-2.5">
                                            {{ __('site.booking.consult_type') }}
                                        </label>
                                        <div class="flex flex-wrap gap-2.5">
                                            <template x-for="type in types" :key="type">
                                                <button type="button" 
                                                        @click="selectedType = type"
                                                        :class="selectedType === type ? 'bg-dark-deep text-paper border border-dark-deep' : 'bg-white text-dark-deep border border-[#e4dccb] hover:border-gold'"
                                                        class="rounded-full px-4 py-2.5 text-sm leading-[1.2] font-semibold transition">
                                                    <span x-text="type"></span>
                                                </button>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- Next Button --}}
                                    <button type="button" @click="tab = 2"
                                            class="w-full bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] flex items-center justify-end gap-3 pill-btn transition">
                                        <span>{{ __('site.booking.next') }}</span>
                                        <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                                            <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                                        </span>
                                    </button>
                                </div>

                                {{-- Tab 2: User Details --}}
                                <div x-show="tab === 2" x-transition style="display: none;">
                                    <h3 class="font-serif text-2xl font-bold text-dark-deep text-start mb-4">
                                        {{ __('site.booking.step_2') }}
                                    </h3>
                                    
                                    {{-- Selected Summary Tag (Info on the right, Change on the left in RTL) --}}
                                    <div class="bg-paper-dark/60 rounded-xl p-3 mb-4 text-xs flex items-center justify-between text-dark-deep">
                                        <div>
                                            {{ __('site.booking.field_area') }} <strong x-text="selectedAreaName"></strong> | {{ __('site.booking.field_type') }} <strong x-text="selectedType"></strong>
                                        </div>
                                        <button type="button" @click="tab = 1" class="text-gold-ink underline font-bold">
                                            {{ __('site.booking.change') }}
                                        </button>
                                    </div>

                                    <input type="hidden" name="practice_area_id" :value="selectedAreaId">
                                    <input type="hidden" name="message_prefix" :value="'Area: ' + selectedAreaName + ' | Type: ' + selectedType">

                                    <div class="space-y-4 text-start mb-6">
                                        <div>
                                            <label class="block text-xs sm:text-sm font-semibold text-dark-deep mb-1">
                                                {{ __('site.booking.name_label') }}
                                            </label>
                                            <input type="text" name="name" required
                                                   placeholder="{{ __('site.booking.name_placeholder') }}"
                                                   class="w-full rounded-xl border border-paper-border bg-white px-4 py-2.5 text-sm focus:border-gold focus:outline-none focus:ring-1 focus:ring-gold text-start">
                                        </div>

                                        <div>
                                            <label class="block text-xs sm:text-sm font-semibold text-dark-deep mb-1">
                                                {{ __('site.booking.phone_label') }}
                                            </label>
                                            <input type="tel" name="phone" required
                                                   placeholder="{{ __('site.booking.phone_placeholder') }}"
                                                   class="w-full rounded-xl border border-paper-border bg-white px-4 py-2.5 text-sm focus:border-gold focus:outline-none focus:ring-1 focus:ring-gold text-start dir-ltr">
                                        </div>

                                        <div>
                                            <label class="block text-xs sm:text-sm font-semibold text-dark-deep mb-1">
                                                {{ __('site.booking.notes_label') }}
                                            </label>
                                            <textarea name="message" rows="3" required
                                                      placeholder="{{ __('site.booking.notes_placeholder') }}"
                                                      class="w-full rounded-xl border border-paper-border bg-white px-4 py-2.5 text-sm focus:border-gold focus:outline-none focus:ring-1 focus:ring-gold text-start"></textarea>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <button type="button" @click="tab = 1"
                                                class="rounded-full border border-dark-deep px-5 py-2.5 text-sm font-medium hover:bg-dark-deep hover:text-paper transition">
                                            {{ __('site.booking.prev') }}
                                        </button>

                                        <button type="submit"
                                                class="flex-1 bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] flex items-center justify-end gap-3 pill-btn transition">
                                            <span>{{ __('site.booking.submit') }}</span>
                                            <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                                                <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                                            </span>
                                        </button>
                                    </div>
                                </div>

                            </form>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 9. OFFICE LOCATION ("زورنا في المكتب")                         --}}
    {{-- ============================================================== --}}
    <section id="contact" class="py-20 lg:py-32 bg-white">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-12 xl:px-[120px]">
            <div class="flex flex-col xl:flex-row xl:justify-between gap-12 items-center">
                
                {{-- Start Column: Info, Address & Working Hours --}}
                <div class="w-full xl:w-[500px] flex flex-col items-start text-start">
                    <h2 class="font-serif text-3xl sm:text-5xl lg:text-[60px] leading-[1.15] text-dark-deep">
                        {{ $settings->t('contact_title') ?: ($locale === 'en' ? 'Visit Us at the Office' : 'زورنا في المكتب') }}
                    </h2>

                    <p class="mt-4 text-base lg:text-lg text-[#3b362f] leading-[1.8]">
                        {{ $settings->t('contact_subtitle') ?: ($locale === 'en' ? 'If you prefer speaking face-to-face, our office is open by prior appointment.' : 'لو تفضّل الكلام وجهًا لوجه، مكتبنا مفتوح لك بموعد مسبق.') }}
                    </p>

                    <div class="mt-8 border-y border-dark-deep/15 w-full divide-y divide-dark-deep/15">
                        {{-- Address Row --}}
                        <div class="py-5 flex items-center justify-start gap-4">
                            <span class="size-12 rounded-full bg-paper border border-[#e4dccb] flex items-center justify-center shrink-0">
                                <img src="{{ asset('images/landing/0aabd.svg') }}" alt="" class="size-6">
                            </span>
                            <div class="text-start">
                                <span class="text-xs text-gold-ink font-semibold block">{{ __('site.contact.address_label') }}</span>
                                <span class="text-base sm:text-lg font-semibold text-dark-deep">
                                    {{ $settings->t('address') ?: ($locale === 'en' ? '27 S Street, Hadayek Al Ahram, Cairo, Egypt' : 'طنطا، محافظة الغربية، مصر') }}
                                </span>
                            </div>
                        </div>

                        {{-- Working Hours Row --}}
                        <div class="py-5 flex items-center justify-start gap-4">
                            <span class="size-12 rounded-full bg-paper border border-[#e4dccb] flex items-center justify-center shrink-0">
                                <img src="{{ asset('images/landing/71358.svg') }}" alt="" class="size-6">
                            </span>
                            <div class="text-start">
                                <span class="text-xs text-gold-ink font-semibold block">{{ __('site.contact.hours_label') }}</span>
                                <span class="text-base sm:text-lg font-semibold text-dark-deep">
                                    {{ $settings->t('working_hours') ?: ($locale === 'en' ? 'Saturday to Thursday from 5 PM to 10 PM' : 'السبت إلى الخميس من ٥ مساءً حتى ١٠ مساءً') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex flex-wrap items-center gap-6">
                        <a href="{{ $settings->mapOpenUrl() }}" target="_blank" rel="noopener"
                           class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition">
                            <span>{{ __('site.contact.open_maps') }}</span>
                            <span class="bg-dark-black size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                                <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                            </span>
                        </a>

                        <a href="#booking" class="font-semibold text-dark-deep underline text-base hover:text-gold-ink transition">
                            {{ __('site.contact.book_visit') }}
                        </a>
                    </div>

                    {{-- Social Links --}}
                    <div class="mt-6 flex flex-wrap items-center gap-5 font-semibold text-base text-gold-ink">
                        @foreach($socialLinks as $social)
                            <a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="hover:underline">{{ $social['label'] }}</a>
                        @endforeach
                    </div>

                </div>

                {{-- End Column: Live Google Map Card --}}
                <div class="w-full xl:w-[600px] shrink-0">
                    <div class="relative bg-paper rounded-[28px] overflow-hidden border border-[#e4dccb] h-[360px] sm:h-[460px] group">
                        @php($usesFallbackMap = $settings->usesFallbackMap())
                        <iframe src="{{ $settings->mapEmbedSrc() }}"
                                @class([
                                    'absolute border-0 w-full',
                                    'inset-0 h-full' => ! $usesFallbackMap,
                                    '-top-[70px] inset-x-0 h-[calc(100%+70px)] pointer-events-none [filter:sepia(0.5)_saturate(0.55)_contrast(0.92)_brightness(1.04)]' => $usesFallbackMap,
                                ])
                                allowfullscreen=""
                                loading="eager"
                                referrerpolicy="no-referrer-when-downgrade"
                                @if($usesFallbackMap) tabindex="-1" @endif
                                title="{{ $lawyerName }}"></iframe>

                        @if($usesFallbackMap)
                            <a href="{{ $settings->mapOpenUrl() }}" target="_blank" rel="noopener" aria-label="{{ __('site.contact.open_maps') }}" class="absolute inset-0">
                                <span class="absolute left-1/2 top-[calc(50%-105px)] -translate-x-1/2 size-[110px] flex justify-center">
                                    <img src="{{ asset('images/landing/3e53f.svg') }}" alt="" class="absolute inset-0 size-full">
                                    <img src="{{ asset('images/landing/map-pin.svg') }}" alt="" class="relative w-14 h-[70px]">
                                </span>
                            </a>
                        @endif

                        {{-- Floating Location Pill --}}
                        <a href="{{ $settings->mapOpenUrl() }}" target="_blank" rel="noopener"
                           class="absolute bottom-4 {{ $isRtl ? 'right-4' : 'left-4' }} bg-white/95 hover:bg-white text-dark-deep backdrop-blur px-4 py-2 rounded-full shadow-md text-xs sm:text-sm font-semibold flex items-center gap-2 transition hover:scale-105">
                            <span class="size-2 rounded-full bg-gold animate-pulse"></span>
                            <span>{{ $settings->t('address') ?: $lawyerName }}</span>
                            <span class="text-gold text-xs">↗</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- 10. FOOTER                                                     --}}
    {{-- ============================================================== --}}
    <footer class="bg-dark-black text-paper pt-20 xl:pt-28 pb-8 px-6 sm:px-12 xl:px-[120px]">
        <div class="max-w-[1440px] mx-auto">
            
            {{-- Top CTA Bar --}}
            <div class="border-b border-paper/15 pb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="font-serif text-3xl sm:text-5xl lg:text-[60px] font-bold leading-[1.28] text-start text-paper">{!! $heroHeadlineHtml !!}</div>

                <a href="#booking" class="bg-gold hover:bg-gold-hover text-dark-black rounded-full ps-6 pe-1.5 py-1.5 font-semibold text-[15px] inline-flex items-center gap-3 pill-btn transition">
                    <span>{{ __('site.hero.cta_book') }}</span>
                    <span class="bg-dark-surface size-10 rounded-full flex items-center justify-center pill-arrow transition-transform duration-300 {{ $isRtl ? '' : '-scale-x-100' }}">
                        <img src="{{ asset('images/landing/8a63c.svg') }}" alt="" class="size-4">
                    </span>
                </a>
            </div>

            {{-- 4 Columns --}}
            <div class="py-16 grid grid-cols-1 sm:grid-cols-2 lg:flex lg:justify-between gap-12 text-start">
                
                {{-- Col 1: Brand --}}
                <div class="space-y-3 lg:max-w-[320px]">
                    <p class="{{ $isRtl ? 'font-ruqaa text-[32px]' : 'font-serif font-bold text-3xl' }} text-gold">{{ $lawyerName }}</p>
                    <p class="text-text-muted-dark text-base leading-[1.8]">
                        {{ $settings->t('footer_text') ?: ($locale === 'en' ? 'Law office in Gharbia. Family, civil, commercial, and criminal litigation.' : 'مكتب محاماة في الغربية. قضايا الأسرة والمدني والتجاري والجنائي.') }}
                    </p>
                </div>

                {{-- Col 2: Navigation --}}
                <div class="space-y-3">
                    <p class="font-semibold text-sm text-gold">{{ __('site.footer.col_site') }}</p>
                    <ul class="space-y-2 text-text-on-dark text-base">
                        <li><a href="#about" class="hover:text-white transition">{{ __('site.nav.about') }}</a></li>
                        <li><a href="#practice" class="hover:text-white transition">{{ __('site.nav.services') }}</a></li>
                        <li><a href="#route" class="hover:text-white transition">{{ __('site.nav.route') }}</a></li>
                        <li><a href="#faq" class="hover:text-white transition">{{ __('site.nav.faq') }}</a></li>
                    </ul>
                </div>

                {{-- Col 3: Contact --}}
                <div class="space-y-3">
                    <p class="font-semibold text-sm text-gold">{{ __('site.footer.col_contact') }}</p>
                    <ul class="space-y-2 text-text-on-dark text-base">
                        <li><a href="tel:{{ $phoneClean }}" class="hover:text-white transition dir-ltr inline-block">{{ $settings->phone ?: '+20 100 000 0000' }}</a></li>
                        <li><a href="{{ $whatsappUrl }}" target="_blank" rel="noopener" class="hover:text-white transition dir-ltr inline-block">{{ $settings->whatsapp ?: '+20 100 000 0000' }}</a></li>
                        <li><span>{{ $settings->t('address') ?: 'طنطا، مصر' }}</span></li>
                    </ul>
                </div>

                {{-- Col 4: Social --}}
                <div class="space-y-3">
                    <p class="font-semibold text-sm text-gold">{{ __('site.footer.col_social') }}</p>
                    <ul class="space-y-2 text-text-on-dark text-base">
                        @foreach($socialLinks as $social)
                            <li><a href="{{ $social['url'] }}" target="_blank" rel="noopener" class="hover:text-white transition">{{ $social['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>

            {{-- Bottom Bar --}}
            <div class="pt-8 border-t border-paper/15 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-text-dim-dark">
                <p>© {{ $locale === 'ar' ? '٢٠٢٦' : '2026' }} {{ $lawyerName }} · {{ __('site.footer.rights') }}</p>
                <a href="#hero" class="text-text-on-dark hover:text-white transition">{{ __('site.footer.back_to_top') }}</a>
            </div>

        </div>
    </footer>

    {{-- Floating WhatsApp FAB --}}
    <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener"
       aria-label="{{ __('site.contact.whatsapp') }}"
       class="fixed bottom-6 {{ $isRtl ? 'left-6' : 'right-6' }} z-50 size-14 rounded-full bg-dark-deep border border-gold shadow-[0px_10px_24px_0px_rgba(15,14,12,0.28)] flex items-center justify-center transition-transform duration-300 hover:scale-110">
        <img src="{{ asset('images/landing/3493a.svg') }}" alt="WhatsApp" class="size-6">
    </a>

</div>

@endsection
