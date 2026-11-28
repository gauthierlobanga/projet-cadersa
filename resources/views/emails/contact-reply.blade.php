<x-mail-layout
    :email-message="$message"
    :title="$replySubject"
    preheader="L’équipe CADERSA vous a répondu au sujet de votre demande."
    eyebrow="Réponse de l’équipe CADERSA"
    hero-image="women-resilience.png"
    hero-alt="Des femmes engagées pour la résilience de leur communauté"
>
    <h1 style="margin:0; color:#173f34; font-size:26px; font-weight:700; line-height:1.35;">Bonjour{{ $recipientName ? ' '.$recipientName : '' }},</h1>
    <p style="margin:13px 0 0; color:#485a53; font-size:14px; line-height:1.75;">Nous faisons suite à votre message : <strong style="color:#203a31;">{{ $originalSubject }}</strong>.</p>

    <div style="margin-top:20px; padding:19px 20px; background-color:#f2f6f3; color:#30443b; font-size:15px; line-height:1.8; white-space:pre-line;">{{ $response }}</div>

    @if ($includeOriginal)
        <h2 style="margin:22px 0 8px; color:#203a31; font-size:13px; font-weight:700; line-height:1.5;">Votre message initial</h2>
        <div style="padding:13px 16px; background-color:#f7f8f8; color:#627168; font-size:13px; line-height:1.7; white-space:pre-line;">{{ $originalMessage }}</div>
    @endif

    <p style="margin:20px 0 3px; color:#617068; font-size:13px; line-height:1.7;">Vous pouvez répondre directement à cet e-mail si vous souhaitez poursuivre l’échange.</p>
</x-mail-layout>
