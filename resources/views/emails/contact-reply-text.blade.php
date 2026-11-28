Bonjour{{ $recipientName ? ' '.$recipientName : '' }},

Notre équipe vous répond au sujet de votre message « {{ $originalSubject }} ».

{{ $response }}

@if ($includeOriginal)
Votre message initial :
{{ $originalMessage }}
@endif

Vous pouvez répondre directement à cet e-mail pour poursuivre l’échange.

CADERSA agit dans les domaines du développement rural, de la sécurité alimentaire, de l’eau et de l’assainissement, ainsi que de la formation et de l’accompagnement.
Découvrez nos services : {{ route('services.index') }}

{{ $appName }}
