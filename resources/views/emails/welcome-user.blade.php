<x-mail-layout
    :email-message="$message"
    title="Bienvenue chez CADERSA ASBL"
    preheader="Votre compte CADERSA est prêt. Découvrez nos actions en faveur des communautés rurales."
    eyebrow="Bienvenue dans la communauté"
    hero-image="hero-community.png"
    hero-alt="Membres d’une communauté réunis autour d’une initiative locale"
>
    <h1 style="margin:0; color:#173f34; font-size:27px; font-weight:700; line-height:1.3;">Bonjour{{ $userName ? ' '.$userName : '' }}, bienvenue.</h1>
    <p style="margin:14px 0 0; color:#485a53; font-size:15px; line-height:1.75;">Votre compte CADERSA ASBL a été créé. Vous pouvez maintenant suivre nos initiatives, consulter les formations et accéder à votre espace personnel.</p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin-top:21px;">
        <tr>
            <td style="padding:16px 18px; background-color:#f2f6f3;">
                <p style="margin:0 0 4px; color:#69776f; font-size:10px; font-weight:700; letter-spacing:1.2px; line-height:1.5; text-transform:uppercase;">Compte créé avec</p>
                <p style="margin:0; color:#203a31; font-size:14px; font-weight:700; line-height:1.6;">{{ $userEmail }}</p>
                <p style="margin:7px 0 0; color:{{ $emailVerified ? '#13734f' : '#865e16' }}; font-size:12px; line-height:1.6;">{{ $emailVerified ? 'Adresse e-mail vérifiée' : 'Il reste à confirmer votre adresse e-mail' }}</p>
            </td>
        </tr>
    </table>

    @if ($emailVerified)
        <p style="margin:19px 0 0; color:#485a53; font-size:14px; line-height:1.75;">Votre adresse est confirmée. Connectez-vous pour compléter votre profil et retrouver les informations qui vous intéressent.</p>
    @else
        <p style="margin:19px 0 0; color:#485a53; font-size:14px; line-height:1.75;">Un message de vérification vous a également été envoyé. Confirmez votre adresse pour sécuriser votre compte et accéder à l’ensemble des fonctionnalités.</p>
    @endif

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:23px 0 4px;">
        <tr>
            <td bgcolor="#176f50" style="background-color:#176f50;">
                <a href="{{ $loginUrl }}" style="display:inline-block; padding:14px 21px; color:#ffffff; font-size:14px; font-weight:700; line-height:1.4; text-decoration:none;">Accéder à mon espace</a>
            </td>
        </tr>
    </table>
</x-mail-layout>
