@php
    $seoTitle = trim($seoTitle ?? '') ?: ($settings->t('seo_meta_title') ?: $settings->t('lawyer_name'));
    $seoDescription = trim($seoDescription ?? '') ?: $settings->t('seo_meta_description');
    $resolvePublicImageUrl = static function (?string $path): ?string {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, '/images/')) {
            return asset(ltrim($path, '/'));
        }

        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    };
    $ogImage = $resolvePublicImageUrl($settings->seo_og_image_path)
        ?? $resolvePublicImageUrl($settings->hero_image_path)
        ?? asset('images/landing/497c8.png');
    $ogType = ($seoType ?? '') === 'article' ? 'article' : 'website';
    $ogLocale = $locale === 'ar' ? 'ar_EG' : 'en_US';
    $schemaContextKey = '@'.'context';
    $attorneyJsonLd = [
        $schemaContextKey => 'https://schema.org',
        '@type' => 'Attorney',
        'name' => $settings->t('lawyer_name'),
        'description' => $settings->t('lawyer_title'),
        'telephone' => $settings->phone,
        'email' => $settings->email,
        'url' => route('home', ['locale' => $locale]),
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $settings->t('address'),
            'addressCountry' => 'EG',
        ],
        'inLanguage' => $locale === 'ar' ? 'ar' : 'en',
    ];
    $faqJsonLd = (isset($faqs) && $faqs->isNotEmpty()) ? [
        $schemaContextKey => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqs->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq->t('question'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $faq->t('answer'),
            ],
        ])->all(),
    ] : null;
    $articleJsonLd = (isset($article) && $article instanceof \App\Models\Article && request()->routeIs('blog.show')) ? ([
        $schemaContextKey => 'https://schema.org',
        '@type' => 'BlogPosting',
        'headline' => $article->t('title'),
        'description' => $article->t('excerpt'),
        'datePublished' => $article->published_at?->toAtomString(),
        'dateModified' => $article->updated_at?->toAtomString(),
        'inLanguage' => $locale === 'ar' ? 'ar' : 'en',
        'author' => [
            '@type' => 'Attorney',
            'name' => $settings->t('lawyer_name'),
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $settings->t('lawyer_name'),
        ],
        'mainEntityOfPage' => url()->current(),
    ] + ($article->cover_path ? ['image' => [$resolvePublicImageUrl($article->cover_path)]] : [])) : null;
@endphp

<meta name="description" content="{{ $seoDescription }}">

@if($settings->t('seo_keywords'))
    <meta name="keywords" content="{{ $settings->t('seo_keywords') }}">
@endif

<meta name="robots" content="{{ $settings->seo_robots_index ? 'index, follow' : 'noindex, nofollow' }}">

@if($settings->google_verification)
    <meta name="google-site-verification" content="{{ $settings->google_verification }}">
@endif

<link rel="canonical" href="{{ url()->current() }}">
<link rel="alternate" hreflang="ar" href="{{ \App\Support\LocalizedUrl::current('ar') }}">
<link rel="alternate" hreflang="en" href="{{ \App\Support\LocalizedUrl::current('en') }}">
<link rel="alternate" hreflang="x-default" href="{{ \App\Support\LocalizedUrl::current('ar') }}">

<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ $settings->t('lawyer_name') }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:locale" content="{{ $ogLocale }}">
<meta property="og:locale:alternate" content="{{ $locale === 'ar' ? 'en_US' : 'ar_EG' }}">
@if($ogImage)
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
@endif

<meta name="twitter:card" content="{{ $ogImage ? 'summary_large_image' : 'summary' }}">
<meta name="twitter:title" content="{{ $seoTitle }}">
<meta name="twitter:description" content="{{ $seoDescription }}">
@if($ogImage)
    <meta name="twitter:image" content="{{ $ogImage }}">
@endif

{{-- JSON-LD: بيانات المحامي/المكتب — على كل الصفحات --}}
<script type="application/ld+json">
{!! json_encode($attorneyJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

@if($faqJsonLd)
    {{-- JSON-LD: الأسئلة الشائعة --}}
    <script type="application/ld+json">
    {!! json_encode($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif

@if($articleJsonLd)
    {{-- JSON-LD: المقال --}}
    <script type="application/ld+json">
    {!! json_encode($articleJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
