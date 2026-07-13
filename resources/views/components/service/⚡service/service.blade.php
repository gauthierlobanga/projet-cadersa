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
                    $colors = ['orange', 'emerald', 'blue', 'purple', 'rose', 'teal'];
                @endphp
                {{-- Tailwind Safelist for dynamic colors: 
                  hover:border-orange-300 hover:shadow-orange-100/50 dark:hover:border-orange-700 dark:hover:shadow-orange-900/30 bg-orange-100 text-orange-600 group-hover:bg-orange-200 dark:bg-orange-900/30 dark:text-orange-400 dark:group-hover:bg-orange-900/50
                  hover:border-emerald-300 hover:shadow-emerald-100/50 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/30 bg-emerald-100 text-emerald-600 group-hover:bg-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:group-hover:bg-emerald-900/50
                  hover:border-blue-300 hover:shadow-blue-100/50 dark:hover:border-blue-700 dark:hover:shadow-blue-900/30 bg-blue-100 text-blue-600 group-hover:bg-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:group-hover:bg-blue-900/50
                  hover:border-purple-300 hover:shadow-purple-100/50 dark:hover:border-purple-700 dark:hover:shadow-purple-900/30 bg-purple-100 text-purple-600 group-hover:bg-purple-200 dark:bg-purple-900/30 dark:text-purple-400 dark:group-hover:bg-purple-900/50
                  hover:border-rose-300 hover:shadow-rose-100/50 dark:hover:border-rose-700 dark:hover:shadow-rose-900/30 bg-rose-100 text-rose-600 group-hover:bg-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:group-hover:bg-rose-900/50
                  hover:border-teal-300 hover:shadow-teal-100/50 dark:hover:border-teal-700 dark:hover:shadow-teal-900/30 bg-teal-100 text-teal-600 group-hover:bg-teal-200 dark:bg-teal-900/30 dark:text-teal-400 dark:group-hover:bg-teal-900/50
                --}}

                @foreach ($this->services as $service)
                    @php
                        $color = $colors[$loop->index % count($colors)];
                    @endphp
                    <div x-cloak x-data="{ shown: false }" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="transition-all duration-700 ease-out" style="transition-delay: {{ $loop->index * 75 }}ms">
                        <a href="{{ $service->url }}"
                            class="group relative flex h-full flex-col rounded-3xl border border-zinc-200/60 bg-white/80 p-8 shadow-sm backdrop-blur-sm transition-all duration-300
                              hover:-translate-y-2 hover:border-{{ $color }}-300 hover:shadow-xl hover:shadow-{{ $color }}-100/50
                              dark:border-zinc-700/60 dark:bg-zinc-900/80 dark:hover:border-{{ $color }}-700 dark:hover:shadow-{{ $color }}-900/30">

                            {{-- Icône --}}
                            <div
                                class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-{{ $color }}-100 text-{{ $color }}-600 transition-all duration-300 group-hover:scale-110 group-hover:bg-{{ $color }}-200 dark:bg-{{ $color }}-900/30 dark:text-{{ $color }}-400 dark:group-hover:bg-{{ $color }}-900/50">
                                @if(Str::startsWith($service->icon, '<svg') || Str::startsWith($service->icon, '<path'))
                                    @if(Str::startsWith($service->icon, '<path'))
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            {!! $service->icon !!}
                                        </svg>
                                    @else
                                        {!! $service->icon !!}
                                    @endif
                                @else
                                    <i class="{{ $service->icon ?: 'fas fa-leaf' }} text-2xl"></i>
                                @endif
                            </div>

                            {{-- Contenu --}}
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">{{ $service->title }}</h3>
                            <p class="mt-3 flex-1 text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                {{ $service->short_excerpt }}</p>

                            {{-- Lien "En savoir plus" (apparaît au survol) --}}
                            <div
                                class="mt-6 flex items-center gap-1 text-sm font-semibold text-{{ $color }}-600 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:gap-2 dark:text-{{ $color }}-400">
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
