@extends('layouts.app')

@section('title', $article->t('title') . ' | ' . $settings->t('lawyer_name'))

@section('content')

    <article class="mx-auto max-w-3xl px-4 py-14 sm:px-6 lg:px-8">
        <a href="{{ route('blog.index', ['locale' => $locale]) }}"
           class="inline-flex items-center gap-2 text-sm font-semibold text-gray-400 transition hover:text-brand-800">
            <span class="rtl:rotate-180">←</span> {{ __('site.blog.back') }}
        </a>

        <p class="mt-8 text-sm font-medium text-gray-400">
            {{ __('site.blog.published_on') }} {{ $article->published_at->format('Y/m/d') }}
        </p>

        <h1 class="mt-3 text-2xl font-bold leading-[1.5] text-brand-900 sm:text-3xl sm:leading-[1.5]">
            {{ $article->t('title') }}
        </h1>

        @if($article->cover_path)
            <img src="{{ Storage::disk('public')->url($article->cover_path) }}"
                 alt="{{ $article->t('title') }}"
                 class="mt-8 aspect-video w-full rounded-2xl object-cover shadow-lg">
        @endif

        @if($article->t('excerpt'))
            <p class="mt-8 rounded-2xl border-s-4 border-gold-400 bg-brand-50/70 p-5 text-[15px] font-medium leading-8 text-brand-900">
                {{ $article->t('excerpt') }}
            </p>
        @endif

        <div class="prose-legal mt-8 max-w-none">
            {!! $article->t('body') !!}
        </div>

        <div class="mt-14 rounded-2xl bg-brand-950 p-8 text-center text-white">
            <p class="text-lg font-bold">{{ $settings->t('lawyer_name') }}</p>
            <p class="mt-2 text-sm text-brand-200">{{ $settings->t('lawyer_title') }}</p>
            <a href="{{ route('home', ['locale' => $locale]) }}#contact"
               class="mt-6 inline-block rounded-xl bg-gold-500 px-7 py-3 text-sm font-bold text-brand-950 transition hover:bg-gold-400">
                {{ __('site.hero.cta_primary') }}
            </a>
        </div>
    </article>

@endsection
