@php
    $panelId = filament()->getCurrentPanel()->getId();
    $name = config('app.name');
    $logoUrl = null;

    if ($panelId === 'vendeur') {
        $tenant = tenant();
        if ($tenant) {
            $name = $tenant->raison_sociale ?? $name;
            $logoUrl = $tenant->getFirstMediaUrl('tenant_avatar') ?: null;
        }
    } elseif ($panelId === 'admin') {
        $settings = app(\App\Settings\SettingApp::class);
        $name = $settings->name ?: config('app.name');
        $logoUrl = $settings->logoUrl();
    }
@endphp

<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-6">
            <div class="flex flex-col gap-3">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="{{ $name }}"
                        style="height: 2.5rem; width: 2.5rem; object-fit: cover; border-radius: 50%;">
                @else
                    <div class="flex items-center justify-center rounded-full bg-primary-100 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400"
                        style="height: 2.5rem; width: 2.5rem;">
                        <x-filament::icon icon="heroicon-o-building-office-2" class="h-6 w-6" />
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-4 flex gap-x-4 ">
            <x-filament::link color="gray" href="/" icon="heroicon-m-globe-alt" target="_blank">
                Aller sur le site web
            </x-filament::link>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
