@php
    $statusCode = trim($__env->yieldContent('code', '500'));
    $statusTitle = trim($__env->yieldContent('title', __('Erreur')));
    $statusMessage = trim($__env->yieldContent('message', __('Une erreur est survenue')));
    $statusDescription = trim(
        $__env->yieldContent('description', __('La requête n’a pas pu être traitée correctement.')),
    );
    $tenant = function_exists('tenant') ? tenant() : null;
    $appName = $tenant ? $tenant->raison_sociale : config('app.name', 'Yetu');
    $homeUrl = url('/');
    $refreshUrl = request()->fullUrl();
    $previousUrl = url()->previous();
    $canGoBack = $previousUrl && $previousUrl !== $refreshUrl;
    $supportEmail = 'support@yetu.cd';

    $statusLabel = match ($statusCode) {
        '401' => __('Accès sécurisé'),
        '402' => __('Paiement à finaliser'),
        '403' => __('Autorisation requise'),
        '404' => __('Chemin introuvable'),
        '419' => __('Session expirée'),
        '429' => __('Rythme limité'),
        '500' => __('Incident serveur'),
        '503' => __('Maintenance active'),
        default => __('État inattendu'),
    };

    $nextSteps = match ($statusCode) {
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

    $primaryLabel = $statusCode === '419' ? __('Actualiser') : __('Accueil');
    $primaryUrl = $statusCode === '419' ? $refreshUrl : $homeUrl;
    $primaryIcon = $statusCode === '419' ? 'refresh' : 'home';

    // Thèmes dynamiques Tailwind selon le code
    $gradientClass = match ($statusCode) {
        '401', '403', '419', '429' => 'from-amber-50 to-orange-100 text-amber-600',
        '402' => 'from-sky-50 to-blue-100 text-sky-600',
        '500', '503' => 'from-rose-50 to-red-100 text-rose-600',
        default => 'from-emerald-50 to-teal-100 text-emerald-600',
    };

    $btnPrimaryClass = match ($statusCode) {
        '401', '403', '419', '429' => 'bg-amber-600 hover:bg-amber-700 focus:ring-amber-200',
        '402' => 'bg-sky-600 hover:bg-sky-700 focus:ring-sky-200',
        '500', '503' => 'bg-rose-600 hover:bg-rose-700 focus:ring-rose-200',
        default => 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-200',
    };

    $badgeClass = match ($statusCode) {
        '401', '403', '419', '429' => 'bg-amber-100 text-amber-700 border-amber-200',
        '402' => 'bg-sky-100 text-sky-700 border-sky-200',
        '500', '503' => 'bg-rose-100 text-rose-700 border-rose-200',
        default => 'bg-emerald-100 text-emerald-700 border-emerald-200',
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
 
 @include('partials.head')
</head>

<body
    class="bg-slate-50 min-h-screen flex items-center justify-center p-4 sm:p-8 antialiased selection:bg-slate-800 selection:text-white">

    <!-- Arrière-plan décoratif subtil -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute top-[-25%] left-[-10%] w-[50%] h-[50%] rounded-full mix-blend-multiply filter blur-3xl opacity-20 {{ explode(' ', $gradientClass)[0] }}">
        </div>
        <div
            class="absolute top-[20%] right-[-10%] w-[40%] h-[60%] rounded-full mix-blend-multiply filter blur-3xl opacity-20 {{ explode(' ', $gradientClass)[1] }}">
        </div>
    </div>

    <!-- Conteneur principal (Design Figma Split Card) -->
    <div
        class="relative z-10 max-w-5xl w-full glass-panel rounded-[2rem] shadow-[0_3px_10px_rgb(0,0,0,0.04)] border border-white overflow-hidden flex flex-col md:flex-row">

        <!-- Colonne Gauche : Code d'erreur et Visuel -->
        <div
            class="md:w-5/12 bg-linear-to-br {{ $gradientClass }} p-12 flex flex-col items-center justify-center text-center relative overflow-hidden">
            <!-- Cercles décoratifs -->
            <div
                class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMjU1LCAyNTUsIDI1NSwgMC4xNSkiLz48L3N2Zz4=')] opacity-50 mask-image:linear-gradient(to_bottom,white,transparent)">
            </div>

            <div class="relative z-10 w-full">
                <span
                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest border {{ $badgeClass }} mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-current mr-2"></span>
                    {{ $statusLabel }}
                </span>

                <h1 class="text-8xl lg:text-9xl font-black tracking-tighter mb-4">
                    {{ $statusCode }}
                </h1>

                <p class="font-medium text-lg opacity-80 max-w-62.5 mx-auto leading-tight">
                    {{ $statusTitle }}
                </p>
            </div>
        </div>

        <!-- Colonne Droite : Message et Actions -->
        <div class="md:w-7/12 p-8 sm:p-12 lg:p-16 flex flex-col bg-white/60">
            <!-- En-tête marque -->
            <div class="mb-12">
                <a href="{{ $homeUrl }}" wire:navigate
                    class="inline-flex items-center gap-3 text-slate-800 hover:opacity-80 transition-opacity">
                    <div
                        class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-bold text-lg">
                        {{ mb_substr($appName, 0, 1) }}
                    </div>
                    <span class="font-bold text-xl tracking-tight">{{ $appName }}</span>
                </a>
            </div>

            <!-- Contenu d'erreur -->
            <div class="grow">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-4 tracking-tight leading-tight">
                    {{ $statusMessage }}
                </h2>
                <p class="text-slate-500 text-base sm:text-lg mb-10 leading-relaxed max-w-lg">
                    {{ $statusDescription }}
                </p>

                <!-- Prochaines étapes (si présentes) -->
                @if (count($nextSteps) > 0)
                    <div class="mb-10 bg-slate-50 border border-slate-100 rounded-2xl p-6">
                        <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-4">Prochaines actions
                            possibles</h3>
                        <ul class="space-y-3">
                            @foreach ($nextSteps as $step)
                                <li class="flex items-start text-sm text-slate-600">
                                    <svg class="w-5 h-5 text-slate-400 mr-3 mt-0.5 shrink-0" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>{{ $step }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-4 mt-8">
                <a href="{{ $primaryUrl }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-xl text-white font-semibold text-sm transition-all duration-200 shadow-lg shadow-current/20 hover:-translate-y-0.5 focus:outline-none focus:ring-4 {{ $btnPrimaryClass }}">
                    @if ($primaryIcon === 'refresh')
                        <svg class="w-5 h-5 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    @else
                        <svg class="w-5 h-5 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    @endif
                    {{ $primaryLabel }}
                </a>

                <a href="{{ $canGoBack ? $previousUrl : $homeUrl }}"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 rounded-xl bg-white border border-slate-200 text-slate-700 font-semibold text-sm transition-all duration-200 hover:bg-slate-50 hover:border-slate-300 focus:outline-none focus:ring-4 focus:ring-slate-100">
                    <svg class="w-5 h-5 mr-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Retour') }}
                </a>

                <a href="mailto:{{ $supportEmail }}"
                    class="hidden sm:inline-flex ml-auto items-center justify-center p-3.5 rounded-xl text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors"
                    aria-label="Support">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </a>
            </div>

            <div class="mt-8 sm:hidden text-center">
                <a href="mailto:{{ $supportEmail }}"
                    class="text-sm font-medium text-slate-500 hover:text-slate-800">Contacter le support</a>
            </div>
        </div>
    </div>
</body>

</html>
