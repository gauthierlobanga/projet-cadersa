@props([
    'title' => null,
    'description' => null,
    'image' => null,
    'url' => null,
    'type' => 'website',
    'keywords' => null,
])

@php
    // Application global name
    try {
        $appName = app(\App\Settings\SettingApp::class)->name;
    } catch (\Throwable) {
        $appName = null;
    }
    $appName = $appName ?: config('app.name', 'CADERSA ASBL');

    // Title processing
    $pageTitle = filled($title) ? $title . ' - ' . $appName : $appName;

    // Description processing
    $defaultDescription = "CADERSA accompagne les communautés rurales et périurbaines à travers des projets agricoles, sociaux et environnementaux.";
    $pageDescription = filled($description) ? strip_tags($description) : $defaultDescription;
    $pageDescription = Str::limit($pageDescription, 160);

    // Image processing
    $defaultImage = asset('images/logo.png');
    $pageImage = filled($image) ? $image : $defaultImage;

    // URL processing
    $pageUrl = filled($url) ? $url : request()->url();
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}">
@if($keywords)
<meta name="keywords" content="{{ is_array($keywords) ? implode(', ', $keywords) : $keywords }}">
@endif
<link rel="canonical" href="{{ $pageUrl }}">

{{-- Advanced SEO & Crawling --}}
<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
<meta name="author" content="{{ $appName }}">
<meta name="publisher" content="{{ $appName }}">
<meta name="theme-color" content="#10b981"> {{-- Emerald 500 pour le thème --}}

{{-- Open Graph / Facebook --}}
<meta property="og:type" content="{{ $type }}">
<meta property="og:url" content="{{ $pageUrl }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $pageDescription }}">
<meta property="og:image" content="{{ $pageImage }}">
<meta property="og:site_name" content="{{ $appName }}">
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $pageUrl }}">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $pageDescription }}">
<meta name="twitter:image" content="{{ $pageImage }}">
@php
    try {
        $twitterHandle = app(\App\Settings\SettingApp::class)->x_url;
        if ($twitterHandle) {
            // Extract handle from URL if possible
            $handle = '@' . basename(parse_url($twitterHandle, PHP_URL_PATH));
            echo '<meta name="twitter:site" content="' . $handle . '">' . PHP_EOL;
            echo '<meta name="twitter:creator" content="' . $handle . '">' . PHP_EOL;
        }
    } catch (\Throwable $e) {}
@endphp

{{-- On injecte n'importe quel code Schema.org JSON-LD additionnel --}}
{{ $slot ?? '' }}
