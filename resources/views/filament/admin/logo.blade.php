@php
    $logoUrl ??= null;
    $name ??= config('app.name');
@endphp

<a href="{{ filament()->getUrl() }}" class="flex items-center gap-3 outline-none">
    @if ($logoUrl)
        <img src="{{ $logoUrl }}" alt="{{ $name }}" class="h-12 w-auto" loading="eager">
    @else
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-600 text-white font-bold">
            {{ strtoupper(substr($name, 0, 2)) }}
        </div>
    @endif
</a>
