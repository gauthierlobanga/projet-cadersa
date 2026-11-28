{{ $headline }}

Une nouvelle activité a été enregistrée sur le site de CADERSA ASBL.

@foreach ($details as $label => $value)
{{ $label }} : {{ $value }}
@endforeach

@if ($actionUrl)
Ouvrir et traiter cette activité : {{ $actionUrl }}
@endif

{{ $appName }}
