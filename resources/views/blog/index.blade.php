@extends('layouts.app')

@section('title', __('site.blog.title') . ' | ' . $settings->t('lawyer_name'))

@section('content')

    <section class="border-b border-brand-100 bg-brand-50/60 py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-brand-900 sm:text-4xl">{{ __('site.blog.title') }}</h1>
            <p class="mt-3 text-gray-500">{{ __('site.blog.subtitle') }}</p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        @if($articles->isEmpty())
            <p class="py-20 text-center text-gray-400">{{ __('site.blog.empty') }}</p>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
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
                            <p class="text-xs font-medium text-gray-400">
                                {{ __('site.blog.published_on') }} {{ $article->published_at->format('Y/m/d') }}
                            </p>
                            <h2 class="mt-2 text-lg font-bold leading-8 text-brand-900 group-hover:text-gold-700">{{ $article->t('title') }}</h2>
                            @if($article->t('excerpt'))
                                <p class="mt-3 line-clamp-3 text-sm leading-7 text-gray-500">{{ $article->t('excerpt') }}</p>
                            @endif
                            <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-gold-600 transition group-hover:text-gold-500">
                                {{ __('site.blog.read_more') }} <span class="rtl:rotate-180">→</span>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @endif
    </section>

@endsection
