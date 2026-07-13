<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $tenant = function_exists('tenant') ? tenant() : null;
    $appDisplayName = $tenant?->raison_sociale;

    if (blank($appDisplayName)) {
        try {
            $appDisplayName = app(\App\Settings\SettingApp::class)->name;
        } catch (\Throwable) {
            $appDisplayName = null;
        }
    }

    $appDisplayName = $appDisplayName ?: config('app.name', 'Laravel');
    $faviconUrl = \App\Support\Branding\Favicon::currentUrl();
@endphp

<title>
    {{ filled($title ?? null) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

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
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
