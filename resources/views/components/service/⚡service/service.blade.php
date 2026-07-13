    <!-- Services Section -->
    <section id="services" class="relative overflow-hidden bg-white py-24 dark:bg-zinc-950">
        {{-- Ambiance lumineuse de fond (Gradients Radiaux Vercel/Stripe) --}}
        <div class="pointer-events-none absolute inset-0 z-0">
            {{-- En-haut à droite --}}
            <div
                class="absolute -top-40 right-0 h-150 w-150 rounded-full bg-linear-to-br from-emerald-200/20 to-teal-100/0 blur-3xl dark:from-emerald-500/5 dark:to-transparent">
            </div>
            {{-- En-bas à gauche --}}
            <div
                class="absolute -bottom-20 -left-20 h-125 w-125 rounded-full bg-linear-to-tr from-zinc-200/40 to-emerald-100/0 blur-3xl dark:from-zinc-900/50 dark:to-transparent">
            </div>
            {{-- Subtile grille de fond pixel-perfect optionnelle --}}
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-size-[14px_24px] mask-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
            </div>
        </div>

        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            {{-- En-tête animé --}}
            <div class="mb-20 max-w-3xl" x-data="{ shown: false }" x-intersect="shown = true">
                <span
                    class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 transition-all duration-700 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Nos domaines d’action
                </span>
                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-6xl transition-all duration-700 delay-100 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Des solutions <span
                        class="bg-linear-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">durables</span>
                    pour chaque besoin
                </h2>
                <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400 transition-all duration-700 delay-200 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    À travers notre approche 4B (Bonne cuisson, Bonne alimentation, Bonne planification familiale pour
                    la Bonne santé), nous développons des solutions durables.
                </p>
            </div>

            {{-- Grille des services --}}
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @php
                    $services = [
                        [
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>',
                            'color' => 'orange',
                            'title' => 'Sécurité Alimentaire & Nutrition',
                            'desc' =>
                                'Agriculture, pêche et élevage. Protection de l\'enfance vulnérable et nutrition directe et sensible à la résilience.',
                        ],
                        [
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
                            'color' => 'emerald',
                            'title' => 'Développement Rural',
                            'desc' => 'Création de villages durables, gouvernance locale et sécurisation foncière.',
                        ],
                        [
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                            'color' => 'blue',
                            'title' => 'Entrepreneuriat & Économie',
                            'desc' =>
                                'Autonomisation de la femme, inclusion financière, et renforcement des capacités économiques.',
                        ],
                        [
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>',
                            'color' => 'purple',
                            'title' => 'Éducation & Formations',
                            'desc' =>
                                'Recherches appliquées, formations et renforcement des capacités des organisations paysannes (OP).',
                        ],
                        [
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                            'color' => 'rose',
                            'title' => 'Droits de l\'Homme & Santé',
                            'desc' =>
                                'Protection, cohésion sociale, santé publique, accès à l\'eau, hygiène et assainissement.',
                        ],
                        [
                            'icon' =>
                                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                            'color' => 'teal',
                            'title' => 'Environnement & Forêt',
                            'desc' =>
                                'Réduction des risques de catastrophes, lutte antiérosive, reboisement et aide humanitaire.',
                        ],
                    ];
                @endphp

                @foreach ($services as $index => $service)
                    <div x-data="{ shown: false }" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="transition-all duration-700 ease-out" style="transition-delay: {{ $index * 75 }}ms">
                        <a href="{{ route('services.show', ['service' => Str::slug($service['title'])]) }}"
                            class="group relative flex h-full flex-col rounded-3xl border border-zinc-200/60 bg-white/80 p-8 shadow-sm backdrop-blur-sm transition-all duration-300
                              hover:-translate-y-2 hover:border-{{ $service['color'] }}-300 hover:shadow-xl hover:shadow-{{ $service['color'] }}-100/50
                              dark:border-zinc-700/60 dark:bg-zinc-900/80 dark:hover:border-{{ $service['color'] }}-700 dark:hover:shadow-{{ $service['color'] }}-900/30">

                            {{-- Icône --}}
                            <div
                                class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-{{ $service['color'] }}-100 text-{{ $service['color'] }}-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-{{ $service['color'] }}-200 dark:bg-{{ $service['color'] }}-900/30 dark:text-{{ $service['color'] }}-400 dark:group-hover:bg-{{ $service['color'] }}-900/50">
                                <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $service['icon'] !!}
                                </svg>
                            </div>

                            {{-- Contenu --}}
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $service['title'] }}</h3>
                            <p class="mt-3 flex-1 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                {{ $service['desc'] }}</p>

                            {{-- Lien "En savoir plus" (apparaît au survol) --}}
                            <div
                                class="mt-6 flex items-center gap-1 text-sm font-semibold text-{{ $service['color'] }}-600 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:gap-2 dark:text-{{ $service['color'] }}-400">
                                En savoir plus
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
