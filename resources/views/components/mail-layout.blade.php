@props([
    'title',
    'preheader',
    'eyebrow' => 'CADERSA ASBL',
    'heroImage' => null,
    'heroAlt' => '',
    'emailMessage',
])

@php
    $appName = config('app.name', 'CADERSA ASBL');
    $supportEmail = config('mail.from.address', 'cadersaasbl@gmail.com');
    $aboutSettings = app(\App\Settings\AboutSettings::class);
    $siteSettings = app(\App\Settings\SettingApp::class);
    $resolveConfiguredLogo = function (?string $configuredPath): ?array {
        if (blank($configuredPath)) {
            return null;
        }

        $configuredPath = trim($configuredPath);

        if (filter_var($configuredPath, FILTER_VALIDATE_URL)) {
            $urlPath = parse_url($configuredPath, PHP_URL_PATH);

            if (! is_string($urlPath) || ! str_starts_with($urlPath, '/storage/')) {
                return null;
            }

            $configuredPath = substr($urlPath, strlen('/storage/'));
        }

        $configuredPath = ltrim($configuredPath, '/');

        if (str_starts_with($configuredPath, 'storage/')) {
            $configuredPath = substr($configuredPath, strlen('storage/'));
        }

        $logoDisk = \Illuminate\Support\Facades\Storage::disk('public');

        if (! $logoDisk->exists($configuredPath)) {
            return null;
        }

        return [
            'data' => $logoDisk->get($configuredPath),
            'mimeType' => $logoDisk->mimeType($configuredPath) ?: 'image/png',
            'name' => basename($configuredPath),
        ];
    };
    $emailLogo = $resolveConfiguredLogo($aboutSettings->email_logo_url)
        ?? $resolveConfiguredLogo($siteSettings->logo_url);

    if (! $emailLogo && is_file(public_path('images/cadersa/logo.png'))) {
        $fallbackLogoPath = public_path('images/cadersa/logo.png');
        $emailLogo = [
            'data' => file_get_contents($fallbackLogoPath),
            'mimeType' => 'image/png',
            'name' => 'cadersa-logo.png',
        ];
    }

    $emailLogoSource = $emailLogo
        ? $emailMessage->embedData($emailLogo['data'], $emailLogo['name'], $emailLogo['mimeType'])
        : null;
    $activities = [
        [
            'number' => '01',
            'title' => 'Agriculture durable',
            'description' => 'Soutien aux communautés rurales et aux producteurs pour renforcer leurs moyens d’existence.',
            'url' => route('projects.index'),
        ],
        [
            'number' => '02',
            'title' => 'Sécurité alimentaire',
            'description' => 'Actions en faveur d’une alimentation plus sûre, de la nutrition et de la résilience des ménages.',
            'url' => route('projects.index'),
        ],
        [
            'number' => '03',
            'title' => 'Eau et assainissement',
            'description' => 'Services et initiatives liés à l’accès à l’eau, à l’hygiène et à l’assainissement.',
            'url' => route('services.index'),
        ],
        [
            'number' => '04',
            'title' => 'Formation et accompagnement',
            'description' => 'Ressources et formations pour soutenir les personnes et les organisations locales.',
            'url' => route('formations.index'),
        ],
    ];
@endphp

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title>{{ $title }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f6f5; color:#172b26; font-family:Arial, Helvetica, sans-serif;">
    <div style="display:none; max-height:0; overflow:hidden; opacity:0; color:transparent;">{{ $preheader }}</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%; background-color:#f3f6f5;">
        <tr>
            <td align="center" style="padding:28px 12px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0" style="width:100%; max-width:600px; background-color:#ffffff;">
                    <tr>
                        <td style="padding:25px 32px 22px; background-color:#ffffff;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td width="146" valign="middle" style="width:146px; padding-right:18px;">
                                        @if ($emailLogoSource)
                                            <img src="{{ $emailLogoSource }}" alt="Logo CADERSA ASBL" width="125" style="display:block; width:125px; max-width:100%; height:auto;">
                                        @endif
                                    </td>
                                    <td valign="middle" style="padding-left:18px;">
                                        <p style="margin:0; color:#173f34; font-size:17px; font-weight:700; letter-spacing:0.4px; line-height:1.4;">CADERSA ASBL</p>
                                        <p style="margin:4px 0 0; color:#63716c; font-size:12px; line-height:1.6;">Développement rural · Sécurité alimentaire</p>
                                        <p style="margin:10px 0 0; color:#16815a; font-size:10px; font-weight:700; letter-spacing:1.6px; line-height:1.4; text-transform:uppercase;">{{ $eyebrow }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    @if ($heroImage && is_file(public_path('images/cadersa/'.$heroImage)))
                        <tr>
                            <td style="padding:0; background-color:#e8efeb;">
                                <img src="{{ $emailMessage->embed(public_path('images/cadersa/'.$heroImage)) }}" alt="{{ $heroAlt }}" width="600" style="display:block; width:100%; max-width:600px; height:auto;">
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td style="padding:30px 36px 12px; background-color:#ffffff;">
                            {{ $slot }}
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:16px 36px 30px; background-color:#ffffff;">
                            <h2 style="margin:0 0 7px; color:#173f34; font-size:17px; font-weight:700; line-height:1.4;">Nos domaines d’action</h2>
                            <p style="margin:0 0 18px; color:#63716c; font-size:13px; line-height:1.7;">CADERSA accompagne les communautés par des initiatives locales et des services adaptés aux réalités du terrain.</p>
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="width:100%;">
                                @foreach (array_chunk($activities, 2) as $activityRow)
                                    <tr>
                                        @foreach ($activityRow as $activity)
                                            <td width="50%" valign="top" style="width:50%; padding:15px 13px 16px 0; background-color:#f4f7f5;">
                                                <p style="margin:0 0 6px; color:#16815a; font-size:10px; font-weight:700; letter-spacing:1.2px; line-height:1.4;">{{ $activity['number'] }}</p>
                                                <p style="margin:0 0 5px; color:#1c342d; font-size:13px; font-weight:700; line-height:1.5;">{{ $activity['title'] }}</p>
                                                <p style="margin:0 0 9px; color:#5e6d67; font-size:12px; line-height:1.6;">{{ $activity['description'] }}</p>
                                                <a href="{{ $activity['url'] }}" style="color:#126d4d; font-size:11px; font-weight:700; line-height:1.5; text-decoration:underline;">En savoir plus</a>
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr><td colspan="2" height="8" style="height:8px; font-size:0; line-height:0;">&nbsp;</td></tr>
                                @endforeach
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding:20px 28px 24px; background-color:#eaf0ed;">
                            <p style="margin:0 0 6px; color:#30483f; font-size:12px; line-height:1.6;">Une question ? Notre équipe est à votre écoute.</p>
                            <p style="margin:0; color:#52645c; font-size:12px; line-height:1.6;">
                                <a href="mailto:{{ $supportEmail }}" style="color:#126d4d; font-weight:700; text-decoration:underline;">{{ $supportEmail }}</a>
                                <span>&nbsp;·&nbsp;</span>
                                <a href="{{ route('home') }}" style="color:#126d4d; font-weight:700; text-decoration:underline;">Visiter le site</a>
                            </p>
                            <p style="margin:12px 0 0; color:#738078; font-size:10px; line-height:1.6;">© {{ date('Y') }} {{ $appName }}. Tous droits réservés.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
