<x-mail-layout
    :email-message="$message"
    :title="$headline.' — CADERSA ASBL'"
    preheader="Nouvelle activité enregistrée sur le site de CADERSA ASBL."
    eyebrow="Notification de l’équipe"
    hero-image="field-team.png"
    hero-alt="L’équipe CADERSA sur le terrain"
>
    <h1 style="margin:0; color:#173f34; font-size:25px; font-weight:700; line-height:1.35;">{{ $headline }}</h1>
    <p style="margin:11px 0 19px; color:#586960; font-size:14px; line-height:1.7;">Une nouvelle activité vient d’être enregistrée sur votre site. Voici les informations à consulter.</p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
        @foreach ($details as $label => $value)
            <tr>
                <td valign="top" width="145" style="width:145px; padding:10px 14px 10px 0; background-color:{{ $loop->even ? '#f5f7f6' : '#edf3ef' }}; color:#485a53; font-size:12px; font-weight:700; line-height:1.6;">{{ $label }}</td>
                <td valign="top" style="padding:10px 14px; background-color:{{ $loop->even ? '#f5f7f6' : '#edf3ef' }}; color:#203a31; font-size:13px; line-height:1.7; white-space:pre-line;">{{ $value }}</td>
            </tr>
            <tr><td colspan="2" height="5" style="height:5px; font-size:0; line-height:0;">&nbsp;</td></tr>
        @endforeach
    </table>

    @if ($actionUrl)
        <table role="presentation" cellspacing="0" cellpadding="0" border="0" style="margin:21px 0 2px;">
            <tr>
                <td bgcolor="#176f50" style="background-color:#176f50;">
                    <a href="{{ $actionUrl }}" style="display:inline-block; padding:13px 19px; color:#ffffff; font-size:13px; font-weight:700; line-height:1.4; text-decoration:none;">Ouvrir et traiter cette activité</a>
                </td>
            </tr>
        </table>
    @endif
</x-mail-layout>
