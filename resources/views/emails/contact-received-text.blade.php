Bonjour{{ $recipientName ? ' '.$recipientName : '' }},

Nous avons bien reçu votre message. Notre équipe va l’examiner et vous répondra à {{ $recipientEmail }}.

Référence : {{ $reference }}
Objet : {{ $contactSubject }}

Copie de votre message :
{{ $contactMessage }}

Pour ajouter une information, répondez directement à cet e-mail.

CADERSA accompagne les communautés dans le développement rural, la sécurité alimentaire, l’accès à l’eau et l’assainissement, ainsi que la formation.
Découvrez nos projets : {{ route('projects.index') }}
Découvrez nos services : {{ route('services.index') }}

{{ $appName }}
