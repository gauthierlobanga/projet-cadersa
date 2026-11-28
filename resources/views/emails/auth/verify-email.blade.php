<x-mail-layout
    :email-message="$message"
    title="Confirmez votre adresse e-mail — CADERSA ASBL"
    preheader="Une dernière étape pour sécuriser et activer votre compte CADERSA."
    eyebrow="Sécurité de votre compte"
    hero-image="community-registration.png"
    hero-alt="Une communauté accueillant de nouveaux membres"
>
    <h1 style="margin:0; color:#173f34; font-size:26px; font-weight:700; line-height:1.35;">Confirmez votre adresse e-mail</h1>
    <p style="margin:14px 0 0; color:#485a53; font-size:15px; line-height:1.75;">Bonjour{{ $user->name ? ' '.$user->name : '' }}, confirmez votre adresse pour protéger votre compte et terminer votre inscription à CADERSA ASBL.</p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin-top:20px;">
        <tr>
            <td style="padding:15px 17px; background-color:#f2f6f3;">
                <p style="margin:0 0 4px; color:#69776f; font-size:10px; font-weight:700; letter-spacing:1.2px; line-height:1.5; text-transform:uppercase;">Adresse à confirmer</p>
                <p style="margin:0; color:#203a31; font-size:14px; font-weight:700; line-height:1.6;">{{ $user->email }}</p>
            </td>
        </tr>
    </table>

    <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:22px 0 0;">
        <tr>
            <td bgcolor="#176f50" style="background-color:#176f50;">
                <a href="{{ $verificationUrl }}" style="display:inline-block; padding:14px 21px; color:#ffffff; font-size:14px; font-weight:700; line-height:1.4; text-decoration:none;">Confirmer mon adresse</a>
            </td>
        </tr>
    </table>

    <p style="margin:20px 0 0; color:#617068; font-size:13px; line-height:1.7;">Ce lien personnel expirera dans {{ $expiresIn }} minutes. Si le bouton ne s’ouvre pas, copiez ce lien dans votre navigateur :</p>
    <p style="margin:9px 0 0; overflow-wrap:anywhere; word-break:break-all;"><a href="{{ $verificationUrl }}" style="color:#126d4d; font-size:12px; line-height:1.6; text-decoration:underline;">{{ $verificationUrl }}</a></p>

    <p style="margin:19px 0 2px; padding:13px 16px; background-color:#f7f5ee; color:#635738; font-size:12px; line-height:1.65;">Si vous n’avez pas créé de compte, ignorez ce message. Votre compte restera inchangé.</p>
</x-mail-layout>
