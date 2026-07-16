<flux:footer class="relative border-t border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 font-outfit">
    {{-- Ambiance lumineuse de fond --}}
    <div class="pointer-events-none absolute inset-0 z-0">
        <div
            class="absolute -top-40 right-0 h-150 w-150 rounded-full bg-linear-to-br from-emerald-200/20 to-teal-100/0 blur-3xl dark:from-emerald-500/5 dark:to-transparent">
        </div>
        <div
            class="absolute -bottom-20 -left-20 h-125 w-125 rounded-full bg-linear-to-tr from-zinc-200/40 to-emerald-100/0 blur-3xl dark:from-zinc-900/50 dark:to-transparent">
        </div>
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-[size:14px_24px] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
        </div>
    </div>

    <div x-data="footerScrollReveal()" x-ref="scrollWrapper" class="relative z-10 border-b border-zinc-200 px-5 pt-4 pb-4 dark:border-zinc-800 sm:px-8 sm:pt-10">

        {{-- Zone Supérieure : Logo + Description & Bouton Retour en haut --}}
        <div class="flex flex-col items-start justify-between gap-8 sm:flex-row">

            {{-- Colonne gauche : Logo + Description --}}
            <div class="flex flex-col items-start max-w-sm">
                {{-- Logo + Nom de l'application --}}
                <div data-animate="enter-from-left">
                    <a href="{{ route('home') }}" aria-label="{{ $this->appName }} - Retour à l'accueil"
                        class="group inline-flex items-center rounded-lg py-1.5 transition duration-300 ease-out
              hover:-translate-x-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50
              focus-visible:ring-offset-2 dark:focus-visible:ring-offset-zinc-900">
                        {{-- Logo transparent, circulaire --}}
                        <div class="h-16 w-46 shrink-0 overflow-hidden">
                            <img src="{{ $this->logoUrl ?? Storage::url('images/cadersa-logo.png') }}"
                                alt="{{ $this->appName }}" class="h-full w-full object-contain" />
                        </div>
                    </a>
                </div>

                {{-- Slogan --}}
                <p data-animate="text-reveal-words"
                    class="mt-4 max-w-xs text-pretty text-base leading-relaxed text-zinc-600 dark:text-zinc-300"
                    role="note">
                    Organisation engagée pour une <strong
                        class="font-semibold text-zinc-900 dark:text-zinc-100">agriculture durable</strong>
                    et la résilience des petits producteurs au <strong
                        class="font-semibold text-zinc-900 dark:text-zinc-100">Kasaï Central</strong>.
                </p>
            </div>

            {{-- Bouton "Retour en haut" --}}
            <div data-animate="enter-from-right" x-data="returnToTopButton()">
                <button data-button-pulse type="button" aria-label="Remonter en haut de la page"
                    x-on:click="scrollToTop()"
                    class="inline-flex h-12 items-center gap-2 rounded-full bg-emerald-50 dark:bg-zinc-800 pr-5 pl-1.5 font-medium text-sm text-zinc-900 dark:text-zinc-100 transition-all duration-300 ease-out will-change-transform hover:scale-105 hover:bg-emerald-100 dark:hover:bg-emerald-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50">
                    <div
                        class="relative isolate grid size-9 place-items-center overflow-hidden rounded-full bg-zinc-900 dark:bg-emerald-600 text-white">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                        </svg>
                    </div>
                    <div class="overflow-hidden whitespace-nowrap text-sm" data-text>
                        Retour en haut
                    </div>
                </button>
            </div>
        </div>

        {{-- Zone Intermédiaire : Réseaux sociaux + Les 3 Colonnes de Navigation --}}
        <div class="mt-8 flex flex-col md:flex-row items-start justify-between gap-6 w-full">

            {{-- Bloc Réseaux Sociaux --}}
            <div data-animate="enter-from-left" class="shrink-0">
                <nav class="inline-flex divide-x divide-zinc-100 dark:divide-white/10 border-zinc-200 md:w-13 md:flex-col md:divide-x-0 md:divide-y border dark:border-white/10 bg-white dark:bg-zinc-800/50"
                    aria-label="Réseaux sociaux">
                    @foreach ($this->socialLinks as $network => $url)
                        <a href="{{ $url }}" target="_blank" rel="external noopener noreferrer"
                            aria-label="{{ ucfirst($network) }}"
                            class="group relative inline-grid place-items-center transition-colors duration-300 size-13 hover:bg-zinc-50 dark:hover:bg-zinc-700/50">
                            {{-- Icônes SVG officielles --}}
                            @switch($network)
                                @case('facebook')
                                    <svg class="size-5.5 fill-current" role="img" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 .955.042 1.468.103a8.68 8.68 0 0 1 1.141.195v3.325a8.623 8.623 0 0 0-.653-.036 26.805 26.805 0 0 0-.733-.009c-.707 0-1.259.096-1.675.309a1.686 1.686 0 0 0-.679.622c-.258.42-.374.995-.374 1.752v1.297h3.919l-.386 2.103-.287 1.564h-3.246v8.245C19.396 23.238 24 18.179 24 12.044c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.628 3.874 10.35 9.101 11.647Z" />
                                    </svg>
                                @break

                                @case('x')
                                    <svg class="size-5.5 fill-current" role="img" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M14.234 10.162 22.977 0h-2.072l-7.591 8.824L7.251 0H.258l9.168 13.343L.258 24H2.33l8.016-9.318L16.749 24h6.993zm-2.837 3.299-.929-1.329L3.076 1.56h3.182l5.965 8.532.929 1.329 7.754 11.09h-3.182z" />
                                    </svg>
                                @break

                                @case('linkedin')
                                    <svg class="size-5.5 fill-current" role="img" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                    </svg>
                                @break

                                @case('instagram')
                                    <svg class="size-5.5 fill-current" role="img" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.0301.084c-1.2768.0602-2.1487.264-2.911.5634-.7888.3075-1.4575.72-2.1228 1.3877-.6652.6677-1.075 1.3368-1.3802 2.127-.2954.7638-.4956 1.6365-.552 2.914-.0564 1.2775-.0689 1.6882-.0626 4.947.0062 3.2586.0206 3.6671.0825 4.9473.061 1.2765.264 2.1482.5635 2.9107.308.7889.72 1.4573 1.388 2.1228.6679.6655 1.3365 1.0743 2.1285 1.38.7632.295 1.6361.4961 2.9134.552 1.2773.056 1.6884.069 4.9462.0627 3.2578-.0062 3.668-.0207 4.9478-.0814 1.28-.0607 2.147-.2652 2.9098-.5633.7889-.3086 1.4578-.72 2.1228-1.3881.665-.6682 1.0745-1.3378 1.3795-2.1284.2957-.7632.4966-1.636.552-2.9124.056-1.2809.0692-1.6898.063-4.948-.0063-3.2583-.021-3.6668-.0817-4.9465-.0607-1.2797-.264-2.1487-.5633-2.9117-.3084-.7889-.72-1.4568-1.3876-2.1228C21.2982 1.33 20.628.9208 19.8378.6165 19.074.321 18.2017.1197 16.9244.0645 15.6471.0093 15.236-.005 11.977.0014 8.718.0076 8.31.0215 7.0301.0839m.1402 21.6932c-1.17-.0509-1.8053-.2453-2.2287-.408-.5606-.216-.96-.4771-1.3819-.895-.422-.4178-.6811-.8186-.9-1.378-.1644-.4234-.3624-1.058-.4171-2.228-.0595-1.2645-.072-1.6442-.079-4.848-.007-3.2037.0053-3.583.0607-4.848.05-1.169.2456-1.805.408-2.2282.216-.5613.4762-.96.895-1.3816.4188-.4217.8184-.6814 1.3783-.9003.423-.1651 1.0575-.3614 2.227-.4171 1.2655-.06 1.6447-.072 4.848-.079 3.2033-.007 3.5835.005 4.8495.0608 1.169.0508 1.8053.2445 2.228.408.5608.216.96.4754 1.3816.895.4217.4194.6816.8176.9005 1.3787.1653.4217.3617 1.056.4169 2.2263.0602 1.2655.0739 1.645.0796 4.848.0058 3.203-.0055 3.5834-.061 4.848-.051 1.17-.245 1.8055-.408 2.2294-.216.5604-.4763.96-.8954 1.3814-.419.4215-.8181.6811-1.3783.9-.4224.1649-1.0577.3617-2.2262.4174-1.2656.0595-1.6448.072-4.8493.079-3.2045.007-3.5825-.006-4.848-.0608M16.953 5.5864A1.44 1.44 0 1 0 18.39 4.144a1.44 1.44 0 0 0-1.437 1.4424M5.8385 12.012c.0067 3.4032 2.7706 6.1557 6.173 6.1493 3.4026-.0065 6.157-2.7701 6.1506-6.1733-.0065-3.4032-2.771-6.1565-6.174-6.1498-3.403.0067-6.156 2.771-6.1496 6.1738M8 12.0077a4 4 0 1 1 4.008 3.9921A3.9996 3.9996 0 0 1 8 12.0077" />
                                    </svg>
                                @break

                                @case('youtube')
                                    <svg class="size-5.5 fill-current" role="img" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                @break

                                @default
                                    <svg class="size-5.5 fill-current" viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                    </svg>
                            @endswitch
                            {{-- Tooltip --}}
                            <div
                                class="pointer-events-none absolute inset-y-0 hidden items-center gap-3 md:flex left-[calc(100%+(--spacing(4)))] flex-row-reverse">
                                <div
                                    class="text-base font-medium text-zinc-400 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:translate-x-0 -translate-x-2">
                                    {{ ucfirst($network) }}
                                </div>
                                <div
                                    class="h-px w-4 scale-x-0 bg-zinc-300 dark:bg-zinc-600 transition-transform duration-300 group-hover:scale-x-100 origin-left">
                                </div>
                            </div>
                        </a>
                    @endforeach
                </nav>
            </div>

            {{-- Les 3 Colonnes de liens --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 w-full md:max-w-3xl flex-1">

                {{-- Navigation --}}
                <div data-animate="enter-from-left-staggered" class="flex flex-col items-start gap-5">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-zinc-900 dark:text-white">Navigation
                    </h3>
                    <nav class="flex flex-col items-start space-y-2.5" aria-label="Liens principaux">
                        @foreach ([['route' => 'home', 'label' => 'Accueil'], ['route' => 'about', 'label' => 'À propos'], ['route' => 'contact', 'label' => 'Contact']] as $link)
                            <a href="{{ route($link['route']) }}" wire:navigate
                                class="group relative flex items-center py-1 text-base text-zinc-600 transition-colors duration-300 hover:text-emerald-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50 dark:text-zinc-400 dark:hover:text-emerald-400 rounded-sm">
                                <span
                                    class="absolute -left-4 opacity-0 scale-50 -rotate-90 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:opacity-100 group-hover:scale-100 group-hover:rotate-0 group-hover:left-0 text-emerald-500">
                                    <svg aria-hidden="true" class="size-2" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 8 8" fill="none">
                                        <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                    </svg>
                                </span>
                                <span
                                    class="transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:translate-x-3">{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>

                {{-- Nos Actions --}}
                <div data-animate="enter-from-left-staggered" class="flex flex-col items-start gap-5">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-zinc-900 dark:text-white">Nos
                        Actions
                    </h3>
                    <nav class="flex flex-col items-start space-y-2.5" aria-label="Liens d'activités">
                        @foreach ([['route' => 'services.index', 'label' => 'Services'], ['route' => 'projects.index', 'label' => 'Projets'], ['route' => 'posts.index', 'label' => 'Actualités']] as $link)
                            <a href="{{ route($link['route']) }}" wire:navigate
                                class="group relative flex items-center py-1 text-base text-zinc-600 transition-colors duration-300 hover:text-emerald-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50 dark:text-zinc-400 dark:hover:text-emerald-400 rounded-sm">
                                <span
                                    class="absolute -left-4 opacity-0 scale-50 -rotate-90 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:opacity-100 group-hover:scale-100 group-hover:rotate-0 group-hover:left-0 text-emerald-500">
                                    <svg aria-hidden="true" class="size-2" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 8 8" fill="none">
                                        <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                    </svg>
                                </span>
                                <span
                                    class="transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:translate-x-3">{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>

                {{-- Informations Légales --}}
                <div data-animate="enter-from-left-staggered" class="flex flex-col items-start gap-5">
                    <h3 class="text-sm font-bold uppercase tracking-widest text-zinc-900 dark:text-white">
                        Informations</h3>
                    <nav class="flex flex-col items-start space-y-2.5" aria-label="Liens légaux">
                        @foreach ([['route' => 'terms', 'label' => 'Conditions générales'], ['route' => 'privacy', 'label' => 'Politique de confidentialité'], ['route' => 'legal', 'label' => 'Mentions légales'], ['route' => 'cookies', 'label' => 'Gestion des cookies']] as $link)
                            <a href="{{ route($link['route']) }}" wire:navigate
                                class="group relative flex items-center py-1 text-base text-zinc-600 transition-colors duration-300 hover:text-emerald-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50 dark:text-zinc-400 dark:hover:text-emerald-400 rounded-sm">
                                <span
                                    class="absolute -left-4 opacity-0 scale-50 -rotate-90 transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:opacity-100 group-hover:scale-100 group-hover:rotate-0 group-hover:left-0 text-emerald-500">
                                    <svg aria-hidden="true" class="size-2" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 8 8" fill="none">
                                        <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                                    </svg>
                                </span>
                                <span
                                    class="transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:translate-x-3">{{ $link['label'] }}</span>
                            </a>
                        @endforeach
                    </nav>
                </div>

            </div>
        </div>

        {{-- Copyright & Crédits --}}
        <div
            class="mt-4 flex flex-col items-center justify-between gap-4 border-t border-zinc-200/60 pt-4 dark:border-zinc-700/60 sm:flex-row">
            {{-- Citation  --}}
            <div x-data="footerCitationReveal()"
                class="relative w-full max-w-xl cursor-default overflow-hidden text-sm text-zinc-500 dark:text-zinc-400"
                style="min-height: 2.75rem;">
                {{-- Copyright original --}}
                <p x-ref="originalText" class="absolute inset-0 m-0 flex items-center">
                    &copy; {{ date('Y') }} {{ $this->appName }}. Tous droits réservés.
                </p>

                {{-- Citation révélée au survol --}}
                <div x-ref="warningText" class="absolute inset-0 m-0 flex items-center" style="opacity: 0;">
                    <blockquote
                        class="border-l-4 border-emerald-500 pl-4 text-sm font-medium italic leading-snug text-emerald-700 dark:text-emerald-300">
                        Vivre c’est reconnaître ses semblables créés à l’image de Dieu.
                        <footer class="text-xs text-zinc-500 not-italic dark:text-zinc-400">— Prof. Dr Bernard
                            HANGI</footer>
                    </blockquote>
                </div>
            </div>

            {{-- Crédits --}}
            <p data-animate="enter-from-right"
                class="flex items-center gap-2 text-sm text-zinc-500 dark:text-zinc-400" role="contentinfo">
                <span class="flex items-center gap-1">
                    <span>Site réalisé </span>
                    <span>par</span>
                </span>
                <a href="{{ $this->developerUrl }}" target="_blank" rel="external noopener noreferrer"
                    aria-label="{{ $this->developerName }}"
                    class="group relative inline-flex items-center transition duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50 rounded-sm">
                    <span class="flex items-center gap-0.5 font-medium">
                        <span
                            class="text-amber-500 transition-transform duration-300 ease-out group-hover:-translate-x-0.5 group-hover:text-emerald-500">{</span>
                        <span
                            class="text-zinc-900 dark:text-zinc-200 transition-colors duration-300 group-hover:text-emerald-600 dark:group-hover:text-emerald-400">
                            {{ $this->developerName }}
                        </span>
                        <span
                            class="text-amber-500 transition-transform duration-300 ease-out group-hover:translate-x-0.5 group-hover:text-emerald-500">}</span>
                    </span>
                    <span
                        class="absolute -bottom-1 left-0 h-[1.5px] w-full origin-right scale-x-0 bg-emerald-500 transition-transform duration-300 ease-out will-change-transform group-hover:origin-left group-hover:scale-x-100"></span>
                </a>
            </p>
        </div>
    </div>
</flux:footer>
