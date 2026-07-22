@php
    $logoUrl ??= null;
@endphp

<a href="{{ filament()->getUrl() }}" class="flex items-center gap-3 outline-none">
    @if ($logoUrl)
        <img loading="eager" decoding="async" src="{{ $logoUrl }}" alt=""  style="height: 2.5rem; width: 2.5rem; object-fit: cover; border-radius: 50%;" loading="eager">
    @endif
</a>
