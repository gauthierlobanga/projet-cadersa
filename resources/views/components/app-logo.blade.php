@props([
    'sidebar' => false,
])

@php
    $settings = app(\App\Settings\SettingApp::class);
    $logoUrl = $settings->logoUrl();
    $appName = $settings->name;
@endphp

<div {{ $attributes->merge(['class' => 'inline-flex items-center gap-2 sm:gap-3']) }}>
    <img src="{{ $logoUrl ?? Storage::url('images/cadersa-logo.png') }}" alt="{{ $appName }}"
        class="h-14 sm:h-12 w-auto object-contain rounded transition-all duration-300 ease-out hover:scale-105" />
</div>