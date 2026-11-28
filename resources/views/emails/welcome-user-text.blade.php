Bonjour{{ $userName ? ' '.$userName : '' }},

Bienvenue chez CADERSA ASBL. Votre compte a été créé avec l’adresse {{ $userEmail }}.

@if ($emailVerified)
Votre adresse e-mail est déjà vérifiée. Connectez-vous pour compléter votre profil : {{ $loginUrl }}
@else
Un e-mail distinct vous a été envoyé pour confirmer votre adresse et sécuriser votre compte. Une fois votre adresse vérifiée, connectez-vous ici : {{ $loginUrl }}
@endif

CADERSA agit avec les communautés dans les domaines suivants :
- Agriculture durable et développement rural
- Sécurité alimentaire et nutrition
- Eau, hygiène et assainissement
- Formation et accompagnement

Découvrez nos projets : {{ route('projects.index') }}
Découvrez nos services : {{ route('services.index') }}
Consultez les formations : {{ route('formations.index') }}

{{ $appName }}
