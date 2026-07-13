@if (isset($data))
    <script>
        window.filamentData = @js($data)
    </script>
@endif

@php
    $filamentFavicon = \App\Support\Branding\Favicon::currentUrl();
@endphp
<link id="filament-favicon" rel="icon" href="{{ $filamentFavicon }}">
<link id="filament-apple-touch-icon" rel="apple-touch-icon" href="{{ $filamentFavicon }}">

@foreach ($assets as $asset)
    @if (! $asset->isLoadedOnRequest())
        {{ $asset->getHtml() }}
    @endif
@endforeach

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }

    @foreach ($customColors ?? [] as $customColorName => $customColorShades) .fi-color-{{ $customColorName }} { @foreach ($customColorShades as $customColorShade) --color-{{ $customColorShade }}:var(--{{ $customColorName }}-{{ $customColorShade }}); @endforeach } @endforeach
</style>
