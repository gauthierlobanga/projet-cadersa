<x-mail-layout
    :email-message="$message"
    title="Votre message est bien reçu — CADERSA ASBL"
    preheader="Votre demande est enregistrée. L’équipe CADERSA reviendra vers vous à l’adresse indiquée."
    eyebrow="Confirmation de réception"
    hero-image="field-team.png"
    hero-alt="L’équipe CADERSA engagée auprès des communautés"
>
    <h1 style="margin:0; color:#173f34; font-size:27px; font-weight:700; line-height:1.3;">Merci{{ $recipientName ? ' '.$recipientName : '' }}.</h1>
    <p style="margin:14px 0 0; color:#485a53; font-size:15px; line-height:1.75;">Votre message a bien été transmis à notre équipe. Nous allons l’examiner et vous répondrons à <strong style="color:#203a31;">{{ $recipientEmail }}</strong>.</p>

    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%; margin-top:21px;">
        <tr>
            <td style="padding:15px 17px; background-color:#edf4ef;">
                <p style="margin:0 0 4px; color:#63756b; font-size:10px; font-weight:700; letter-spacing:1.2px; line-height:1.5; text-transform:uppercase;">Votre référence de suivi</p>
                <p style="margin:0; color:#173f34; font-size:17px; font-weight:700; letter-spacing:0.5px; line-height:1.5;">{{ $reference }}</p>
            </td>
        </tr>
        <tr><td height="8" style="height:8px; font-size:0; line-height:0;">&nbsp;</td></tr>
        <tr>
            <td style="padding:15px 17px; background-color:#f5f7f6;">
                <p style="margin:0 0 4px; color:#63756b; font-size:10px; font-weight:700; letter-spacing:1.2px; line-height:1.5; text-transform:uppercase;">Objet de votre demande</p>
                <p style="margin:0; color:#203a31; font-size:14px; line-height:1.65;">{{ $contactSubject }}</p>
            </td>
        </tr>
    </table>

    <h2 style="margin:23px 0 8px; color:#203a31; font-size:14px; font-weight:700; line-height:1.5;">Copie de votre message</h2>
    <div style="padding:14px 17px; background-color:#f7f8f8; color:#485a53; font-size:13px; line-height:1.75; white-space:pre-line;">{{ $contactMessage }}</div>

    <p style="margin:19px 0 3px; color:#617068; font-size:13px; line-height:1.7;">Pour ajouter une information à votre demande, répondez directement à cet e-mail.</p>
</x-mail-layout>
