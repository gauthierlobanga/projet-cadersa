<section class="border-b border-zinc-200 px-8 py-10 sm:px-10 sm:py-15 lg:px-15 lg:py-20 dark:border-zinc-800">
    <header class="flex flex-col items-center justify-center text-center">
        {{-- Icône décorative --}}
        <div x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'" class="transition-all duration-700 ease-out">
            <svg aria-hidden="true" class="h-6 w-auto text-emerald-600 dark:text-emerald-400"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" fill="none">
                <path class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    d="M32 18c0-3.314-2.686-6-6-6s-6 2.686-6 6c0 3.314 2.686 6 6 6s6-2.686 6-6Z" />
                <path class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    d="M20 30c0-3.314-2.686-6-6-6s-6 2.686-6 6c0 3.314 2.686 6 6 6s6-2.686 6-6Z" />
                <path class="stroke-current" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                    d="M40 30c0-3.314-2.686-6-6-6s-6 2.686-6 6c0 3.314 2.686 6 6 6s6-2.686 6-6Z" />
                <path class="stroke-current" stroke-width="2.5" stroke-linecap="round"
                    d="M26 24v1.5c0 1.933-1.567 3.5-3.5 3.5h-3M22 30v1.5c0 1.933 1.567 3.5 3.5 3.5h3" />
                <path class="stroke-current" stroke-width="2.5" stroke-linecap="round"
                    d="M34 30v1.5c0 1.933-1.567 3.5-3.5 3.5h-3" />
            </svg>
        </div>

        <p class="mt-3 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-4 py-1 text-sm font-medium uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300"
            x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            class="transition-all duration-700 delay-100 ease-out">
            Partenaires
        </p>

        <h1 class="mt-4 max-w-3xl text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-6xl"
            x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            class="transition-all duration-700 delay-200 ease-out">
            Ensemble pour un <span
                class="relative inline-block bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-400">impact
                durable</span>
        </h1>

        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-zinc-600 dark:text-zinc-300"
            x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            class="transition-all duration-700 delay-300 ease-out">
            C’est grâce à leur confiance et à leur engagement à nos côtés que le CADERSA peut concrétiser sa mission
            de développement rural et de sécurité alimentaire au cœur des communautés.
        </p>
    </header>

    {{-- Partenaires groupés par niveau --}}
    @foreach ($this->partners as $group)
        <div class="mt-12 mx-auto max-w-7xl">
            <h3 class="mb-4 text-center text-xl font-bold text-zinc-800 dark:text-white">
                {{ $group['tier'] }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach ($group['items'] as $item)
                    <div x-data="{ shown: false }" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                        class="transition-all duration-700 ease-out"
                        style="transition-delay: {{ $loop->index * 80 }}ms">
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"
                            class="group relative flex h-36 w-full flex-col items-center justify-center overflow-hidden rounded-md border border-zinc-200 bg-white transition-colors duration-200 ease-out hover:border-zinc-300 hover:bg-zinc-50 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-zinc-700 dark:hover:bg-zinc-800/80"
                            x-data="{
                                init() {
                                    const card = $el;
                                    const image = $refs.sponsorImage;
                                    const tier = $refs.sponsorTier;
                                    gsap.set(tier, { opacity: 0, y: -10, x: -5 });
                                    const tl = gsap.timeline({ paused: true });
                                    tl.to(image, { scale: 0.95, rotation: 0.01, duration: 0.3, ease: 'sine.out' }, 0);
                                    tl.to(tier, { opacity: 1, y: 0, x: 0, duration: 0.3, ease: 'sine.out' }, 0.1);
                                    card.addEventListener('mouseenter', () => tl.play());
                                    card.addEventListener('mouseleave', () => tl.reverse());
                                }
                            }">
                            {{-- Badge de niveau (optionnel, car déjà dans le titre) --}}
                            <span x-ref="sponsorTier"
                                class="absolute top-2 left-2 z-10 rounded-full bg-emerald-600 px-2.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-white">
                                {{ $group['tier'] }}
                            </span>
                            <img x-ref="sponsorImage" src="{{ $item['logo'] }}" alt="{{ $item['name'] }}" loading="lazy"
                                class="h-12 w-auto object-contain transition duration-500 ease-out group-hover:scale-105 dark:brightness-90" />
                            <div
                                class="pointer-events-none absolute inset-0 z-0 bg-[radial-gradient(circle_at_50%_120%,rgba(16,185,129,0.05),transparent_70%)]">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</section>
