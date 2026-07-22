<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

@php
    $faviconUrl = \App\Support\Branding\Favicon::currentUrl();

    // Paramètres de l'application
$appSettings = app(\App\Settings\SettingApp::class);
$aboutSettings = app(\App\Settings\AboutSettings::class);

// Logo de l'application (dynamique)
    $appLogo = $appSettings->logoUrl() ?: asset('images/cadersa-logo.png');

    // Image SEO (utilisée à la fois pour Open Graph et le schéma)
    $seoImage = $seoImage ?? $appLogo;

    // Adresses : utiliser le tableau $addresses de SettingApp
    $addresses = $appSettings->addresses ?? [];
    if (!empty($addresses) && is_array($addresses)) {
        $firstAddress = reset($addresses);
        $street = $firstAddress['address'] ?? ($firstAddress['street'] ?? '');
        $locality = $firstAddress['city'] ?? ($firstAddress['locality'] ?? 'Bukavu');
        $region = $firstAddress['state'] ?? ($firstAddress['region'] ?? 'Sud-Kivu');
        $country = $firstAddress['country'] ?? 'CD';
    } else {
        // Fallback sur l'adresse de AboutSettings
    $street = $aboutSettings->address ?? 'Av. Mbaki N° 041, Q. Ndedere';
    $locality = 'Bukavu';
    $region = 'Sud-Kivu';
    $country = 'CD';
}

// Construction du schéma Organization
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'Organization',
    'name' => $appSettings->name ?? config('app.name', 'CADERSA ASBL'),
    'url' => url('/'),
    'logo' => $appLogo,
    'description' =>
        'Centre d’Appui au Développement Rural et à la Sécurité Alimentaire. CADERSA accompagne les communautés congolaises à travers des projets agricoles, sociaux et environnementaux.',
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $street,
        'addressLocality' => $locality,
        'addressRegion' => $region,
        'addressCountry' => $country,
    ],
    'contactPoint' => [
        '@type' => 'ContactPoint',
        'telephone' => $appSettings->phone,
        'contactType' => 'customer service',
        'email' => $appSettings->email,
    ],
    'sameAs' => array_values(
            array_filter([
                $appSettings->facebook_url,
                $appSettings->x_url,
                $appSettings->linkedin_url,
                $appSettings->youtube_url,
            ]),
        ),
    ];
@endphp

<x-seo :title="$title ?? null" :description="$seoDescription ?? null" :image="$seoImage" :url="$seoUrl ?? null" :type="$seoType ?? 'website'" :keywords="$seoKeywords ?? null">
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
</x-seo>

@include('feed::links')

@if(app()->environment('production'))
    <script defer data-domain="{{ parse_url(config('app.url'), PHP_URL_HOST) }}" src="https://plausible.io/js/script.js"></script>
@endif

{{-- Favicon --}}
<link id="favicon" rel="icon" href="{{ $faviconUrl }}" data-favicon-href="{{ $faviconUrl }}">
<link id="apple-touch-icon" rel="apple-touch-icon" href="{{ $faviconUrl }}">
<link rel="preconnect" href="https://fonts.bunny.net">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300..700;1,14..32,300..500&family=Playfair+Display:wght@600;700;800&display=swap">
<style>
    html, body {
        overflow-x: hidden;
    }


    .glass-panel {
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
    }

    [x-cloak] {
        display: none !important;
    }

    .no-transition,
    .no-transition * {
        transition: none !important;
    }
</style>

@fonts
@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
@livewireStyles

<script>
    // Désactiver les transitions lors du changement de thème pour éviter les effets de "flash" blanc
    document.addEventListener('DOMContentLoaded', () => {
        let isTransitioning = false;
        const observer = new MutationObserver((mutations) => {
            for (let mutation of mutations) {
                if (mutation.attributeName === 'class' && !isTransitioning) {
                    const oldDark = mutation.oldValue ? mutation.oldValue.includes('dark') : false;
                    const newDark = document.documentElement.classList.contains('dark');

                    // Si la classe 'dark' a été ajoutée ou retirée
                    if (oldDark !== newDark) {
                        isTransitioning = true;
                        document.documentElement.classList.add('no-transition');

                        // Attendre un peu que le navigateur applique les nouvelles couleurs sans animation
                        setTimeout(() => {
                            document.documentElement.classList.remove('no-transition');
                            // Petite pause pour éviter de re-déclencher
                            setTimeout(() => { isTransitioning = false; }, 10);
                        }, 50);
                    }
                }
            }
        });
        observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'], attributeOldValue: true });
    });
</script>
