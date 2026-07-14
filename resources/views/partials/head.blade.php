<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $faviconUrl = \App\Support\Branding\Favicon::currentUrl();
@endphp
<x-seo
    :title="$title ?? null"
    :description="$seoDescription ?? null"
    :image="$seoImage ?? null"
    :url="$seoUrl ?? null"
    :type="$seoType ?? 'website'"
    :keywords="$seoKeywords ?? null"
>
    {!! $schema ?? '' !!}
</x-seo>

{{-- Google Analytics (ne se chargera que si "Analytiques" est accepté) --}}
<x-cookie-script type="analytics">
    <!-- Remplacez G-XXXXXXX par votre vrai code Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-XXXXXXX');
    </script>
</x-cookie-script>

{{-- Pixel Facebook / Autres trackers publicitaires (ne se chargera que si "Marketing" est accepté) --}}
<x-cookie-script type="marketing">
    <!-- Insérez ici votre code de suivi publicitaire (Pixel FB, LinkedIn Insight, etc.) -->
    <script>
      // Code de suivi marketing...
    </script>
</x-cookie-script>

@include('feed::links')
{{-- Favicon --}}
<link id="favicon" rel="icon" href="{{ $faviconUrl }}" data-favicon-href="{{ $faviconUrl }}">
<link id="apple-touch-icon" rel="apple-touch-icon" href="{{ $faviconUrl }}">
<style>
    body {
        font-family: 'Inter', sans-serif;
    }

    .glass-panel {
        /* background: rgba(255, 255, 255, 0.7); */
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    [x-cloak] {
        display: none !important;
    }

    .no-transition,
    .no-transition * {
        transition: none !important;
    }
</style>

@fonts
@vite('resources/css/app.css')
@fluxAppearance
@filamentStyles
