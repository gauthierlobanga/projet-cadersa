@php
    use App\Settings\AboutSettings;

    $about = app(AboutSettings::class);

    // Flexible fallbacks: try AboutSettings properties if present, otherwise fall back to config values
    $company = method_exists($about, 'aboutTitle') && $about->aboutTitle() ? $about->aboutTitle() : (config('app.name', 'CADERSA ASBL'));
    $email = $about->contact_email ?? config('app.contact_email', 'contact@cadersa.org');
    $phone = $about->contact_phone ?? config('app.contact_phone', '+243 812 345 678');
    $address = $about->address ?? config('app.address', 'Goma, République Démocratique du Congo');
@endphp

<div class="mt-6 pt-4 border-t border-zinc-100 text-center dark:border-zinc-800">
    <div class="text-xs text-zinc-500 dark:text-zinc-400">
        <div class="font-medium text-zinc-900 dark:text-white">{{ $company }}</div>
        @if($address)
            <div class="mt-1">{{ $address }}</div>
        @endif
        <div class="mt-1">{{ __('Contact') }}:
            @if($email)
                <a href="mailto:{{ $email }}" class="underline">{{ $email }}</a>
            @endif
            @if($phone)
                • <span>{{ $phone }}</span>
            @endif
        </div>
        <div class="mt-2 text-[11px]">© {{ date('Y') }} {{ $company }}. {{ __('Tous droits réservés') }}.</div>
        <div class="mt-2">
            <flux:link :href="route('about')" wire:navigate class="text-xs">{{ __('En savoir plus sur nous') }}</flux:link>
        </div>
    </div>
</div>