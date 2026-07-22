@php
    $statusCode = trim($__env->yieldContent('code', '500'));
    $statusTitle = trim($__env->yieldContent('title', __('Erreur')));
    $statusMessage = trim($__env->yieldContent('message', __('Une erreur est survenue')));
    $statusDescription = trim(
        $__env->yieldContent('description', __('La requête n’a pas pu être traitée correctement.')),
    );
    try {
        $appSettings = app(\App\Settings\SettingApp::class);
        $appName = $appSettings->name;
        $appLogo = $appSettings->logoUrl();
    } catch (\Throwable) {
        $appName = null;
        $appLogo = null;
    }
    $appName = $appName ?: config('app.name', 'Gaudev');
    $appLogo = $appLogo ?: asset('images/cadersa-logo.png');
    $homeUrl = url('/');
    $refreshUrl = request()->fullUrl();
    $previousUrl = url()->previous();
    $canGoBack = $previousUrl && $previousUrl !== $refreshUrl;
    $supportEmail = 'gauthierlobanga914@gmail.com';

    // --- Dynamic settings from Spatie (with graceful fallback) ---
    $errorPageConfig = [];
    $svgCode = '';
    try {
        $errorSettings = app(\App\Settings\ErrorPagesSettings::class);
        $errorPageConfig = $errorSettings->pages[$statusCode] ?? [];
        $svgCode = $errorPageConfig['svg_code'] ?? '';
    } catch (\Throwable) {
        $errorPageConfig = [];
    }

    // Use settings values when available, otherwise keep blade section values
    if (!empty($errorPageConfig['message'])) {
        $statusMessage = $errorPageConfig['message'];
    }
    if (!empty($errorPageConfig['description'])) {
        $statusDescription = $errorPageConfig['description'];
    }

    $defaultLabels = [
        '401' => __('Accès sécurisé'),
        '402' => __('Paiement à finaliser'),
        '403' => __('Autorisation requise'),
        '404' => __('Chemin introuvable'),
        '419' => __('Session expirée'),
        '429' => __('Rythme limité'),
        '500' => __('Incident serveur'),
        '503' => __('Maintenance active'),
    ];
    $statusLabel = !empty($errorPageConfig['title'])
        ? $errorPageConfig['title']
        : ($defaultLabels[$statusCode] ?? __('État inattendu'));

    $defaultNextSteps = match ($statusCode) {
        '401' => [
            __('Retournez à l’accueil pour relancer la connexion.'),
            __('Vérifiez le compte utilisé si cette page est privée.'),
            __('Contactez le support si l’accès devrait déjà être ouvert.'),
        ],
        '402' => [
            __('Finalisez le paiement ou vérifiez votre abonnement.'),
            __('Revenez ensuite sur cette page pour continuer.'),
            __('Le support peut vous aider si le paiement est déjà passé.'),
        ],
        '403' => [
            __('Revenez à une zone autorisée de votre espace.'),
            __('Demandez une autorisation si votre rôle a changé.'),
            __('Gardez ce lien sous la main pour le support.'),
        ],
        '404' => [
            __('Vérifiez l’adresse ou le lien utilisé.'),
            __('Retournez à l’accueil pour reprendre votre navigation.'),
            __('Si le lien vient d’un message, il a peut-être expiré.'),
        ],
        '419' => [
            __('Actualisez la page pour obtenir une nouvelle session.'),
            __('Renvoyez le formulaire si votre action n’a pas été enregistrée.'),
            __('Reconnectez-vous si l’erreur revient.'),
        ],
        '429' => [
            __('Patientez un court instant avant de réessayer.'),
            __('Évitez de relancer plusieurs actions en même temps.'),
            __('Le support peut vérifier un blocage inhabituel.'),
        ],
        '500' => [
            __('Réessayez dans quelques instants.'),
            __('Votre demande n’a pas besoin d’être répétée plusieurs fois.'),
            __('Contactez le support si l’erreur persiste.'),
        ],
        '503' => [
            __('Le service revient dès la fin de l’intervention.'),
            __('Actualisez la page dans quelques minutes.'),
            __('Le support peut confirmer l’état de la plateforme.'),
        ],
        default => [
            __('Retournez à l’accueil et réessayez.'),
            __('Actualisez la page si le problème est temporaire.'),
            __('Contactez le support si le blocage persiste.'),
        ],
    };
    $nextSteps = !empty($errorPageConfig['next_steps'])
        ? $errorPageConfig['next_steps']
        : $defaultNextSteps;

    $primaryLabel = $statusCode === '419' ? __('Actualiser') : __('Accueil');
    $primaryUrl = $statusCode === '419' ? $refreshUrl : $homeUrl;
    $primaryIcon = $statusCode === '419' ? 'refresh' : 'home';

    // Thèmes dynamiques Tailwind selon le code (Subtils)
    $accentColor = match ($statusCode) {
        '401', '403', '419', '429' => 'amber',
        '402' => 'sky',
        '500', '503' => 'rose',
        default => 'emerald',
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
</head>

<body class="bg-zinc-50 dark:bg-zinc-950 min-h-dvh flex antialiased selection:bg-zinc-200 selection:text-zinc-900 dark:selection:bg-zinc-800 dark:selection:text-white font-sans overflow-hidden">

    <!-- Split Layout (No shadows, modern minimalist Figma pro) -->
    <div class="flex flex-col md:flex-row w-full h-dvh">

        <!-- Left Panel: Graphic & Code -->
        <div class="relative w-full md:w-1/2 h-[40vh] md:h-full bg-zinc-100 dark:bg-zinc-900 flex items-center justify-center overflow-hidden border-b md:border-b-0 md:border-r border-zinc-200 dark:border-zinc-800" data-panel-left>
            <!-- Minimal grain overlay -->
            {{-- <div class="absolute inset-0 opacity-[0.03] dark:opacity-[0.02]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.65%22 numOctaves=%223%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div> --}}

            <!-- Animated shapes (very subtle) -->
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none opacity-20 dark:opacity-10 mix-blend-multiply dark:mix-blend-lighten" data-shapes>
                <div class="absolute w-[60vh] h-[60vh] bg-{{ $accentColor }}-300 rounded-full blur-[80px] top-[-10%] left-[-10%]"></div>
                <div class="absolute w-[50vh] h-[50vh] bg-{{ $accentColor }}-400 rounded-full blur-[100px] bottom-[10%] right-[10%]"></div>
            </div>

            <div class="relative z-10 flex flex-col items-center justify-center">
                <!-- Code (Editorial Serif) -->
                <h1 class="text-[8rem] md:text-[12rem] lg:text-[15rem] leading-none font-serif font-black text-zinc-900 dark:text-white tracking-tighter" data-code>
                    <span class="inline-block overflow-hidden"><span class="inline-block" data-code-char>{{ $statusCode[0] ?? '4' }}</span></span>
                    <span class="inline-block overflow-hidden"><span class="inline-block" data-code-char>{{ $statusCode[1] ?? '0' }}</span></span>
                    <span class="inline-block overflow-hidden"><span class="inline-block" data-code-char>{{ $statusCode[2] ?? '4' }}</span></span>
                </h1>

                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" data-svg>
                    @if($svgCode)
                        {{-- Dynamic SVG from Spatie settings --}}
                        <div class="w-[35vw] h-[35vw] max-w-xs md:max-w-sm lg:max-w-md opacity-90">
                            {!! $svgCode !!}
                        </div>
                    @else
                        {{-- Fallback: subtle monochrome icon --}}
                        <div class="text-zinc-900 dark:text-white opacity-5 mix-blend-overlay">
                            @if($statusCode === '404')
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5" class="w-[30vw] h-[30vw]"><circle cx="12" cy="12" r="10"></circle><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path><path d="M2 12h20"></path><path d="M12 2v20"></path></svg>
                            @elseif(in_array($statusCode, ['500', '503']))
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5" class="w-[30vw] h-[30vw]"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                            @else
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="0.5" class="w-[30vw] h-[30vw]"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="mt-4 px-4 py-1.5 rounded-full border border-zinc-300 dark:border-zinc-700 bg-white/50 dark:bg-zinc-800/50 backdrop-blur-md flex items-center gap-2" data-badge>
                    <span class="w-1.5 h-1.5 rounded-full bg-{{ $accentColor }}-500 animate-pulse"></span>
                    <span class="text-xs font-semibold uppercase tracking-widest text-zinc-600 dark:text-zinc-300">{{ $statusLabel }}</span>
                </div>
            </div>
        </div>

        <!-- Right Panel: Content -->
        <div class="relative w-full md:w-1/2 h-[60vh] md:h-full bg-white dark:bg-zinc-950 flex flex-col justify-between overflow-y-auto" data-panel-right>

            <!-- Logo Header -->
            <div class="p-8 md:p-12 lg:p-16 pb-0" data-stagger>
                <a href="{{ $homeUrl }}" wire:navigate class="inline-block hover:opacity-80 transition-opacity">
                    <img src="{{ $appLogo }}" alt="{{ $appName }}" class="h-10 w-auto object-contain grayscale opacity-80 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                </a>
            </div>

            <!-- Main Copy -->
            <div class="p-8 md:p-12 lg:p-16 grow flex flex-col justify-center">
                <h2 class="text-3xl md:text-5xl font-bold font-serif text-zinc-900 dark:text-zinc-50 tracking-tight leading-tight mb-4" data-stagger>
                    {{ $statusMessage }}
                </h2>

                <p class="text-lg md:text-xl text-zinc-500 dark:text-zinc-400 font-light leading-relaxed max-w-lg mb-10" data-stagger>
                    {{ $statusDescription }}
                </p>

                @if (count($nextSteps) > 0)
                    <div class="mb-10 space-y-4" data-stagger>
                        <h3 class="text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">Pistes de solution</h3>
                        <ul class="space-y-3">
                            @foreach ($nextSteps as $step)
                                <li class="flex items-start text-zinc-600 dark:text-zinc-400">
                                    <svg class="w-5 h-5 text-zinc-300 dark:text-zinc-600 mr-3 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    <span class="text-[15px]">{{ $step }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Actions (No shadow, border + minimal) -->
                <div class="flex flex-col sm:flex-row items-center gap-4 mt-2" data-stagger>
                    <a href="{{ $primaryUrl }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-md bg-zinc-900 dark:bg-zinc-50 text-white dark:text-zinc-900 font-medium text-sm transition-transform hover:scale-[1.02] active:scale-[0.98] focus:outline-none">
                        @if ($primaryIcon === 'refresh')
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                        @endif
                        {{ $primaryLabel }}
                    </a>

                    <a href="{{ $canGoBack ? $previousUrl : $homeUrl }}"
                        class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-md bg-transparent border border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 font-medium text-sm transition-all hover:bg-zinc-50 dark:hover:bg-zinc-900 hover:text-zinc-900 dark:hover:text-zinc-100 active:scale-[0.98] focus:outline-none">
                        {{ __('Retour') }}
                    </a>
                </div>
            </div>

            <!-- Footer Link -->
            <div class="p-8 md:p-12 lg:p-16 pt-0 mt-auto" data-stagger>
                <a href="mailto:{{ $supportEmail }}" class="inline-flex items-center text-sm font-medium text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" /></svg>
                    Support technique
                </a>
            </div>
        </div>
    </div>

    <!-- GSAP Animation Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            gsap.config({ nullTargetWarn: false });

            const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });

            // 1. Initial State Setup
            gsap.set('[data-code-char]', { yPercent: 100 });
            gsap.set('[data-badge], [data-svg], [data-shapes]', { autoAlpha: 0, scale: 0.95 });
            gsap.set('[data-stagger]', { autoAlpha: 0, y: 20 });
            gsap.set('[data-panel-left]', { xPercent: -5 });
            gsap.set('[data-panel-right]', { xPercent: 5 });

            // 2. Play Animation
            tl.to(['[data-panel-left]', '[data-panel-right]'], {
                xPercent: 0,
                duration: 1.2,
                ease: 'power4.out'
            })
            .to('[data-code-char]', {
                yPercent: 0,
                duration: 0.8,
                stagger: 0.1,
                ease: 'back.out(1.2)'
            }, "-=0.8")
            .to('[data-svg]', {
                autoAlpha: 1,
                scale: 1,
                duration: 1.5,
                ease: 'power2.out'
            }, "-=0.6")
            .to('[data-shapes]', {
                autoAlpha: 1,
                scale: 1,
                duration: 2
            }, "-=1.5")
            .to('[data-badge]', {
                autoAlpha: 1,
                scale: 1,
                duration: 0.6,
                ease: 'back.out(1.5)'
            }, "-=1.2")
            .to('[data-stagger]', {
                autoAlpha: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.1
            }, "-=1.2");

            // 3. Continuous floating animation for the SVG background
            gsap.to('[data-svg]', {
                rotation: 5,
                y: -15,
                duration: 6,
                repeat: -1,
                yoyo: true,
                ease: 'sine.inOut'
            });

            // Continuous subtle shape movement
            gsap.to('[data-shapes] div:first-child', {
                x: 30, y: 30, duration: 8, repeat: -1, yoyo: true, ease: 'sine.inOut'
            });
            gsap.to('[data-shapes] div:last-child', {
                x: -30, y: -30, duration: 10, repeat: -1, yoyo: true, ease: 'sine.inOut'
            });
        });
    </script>
</body>

</html>
