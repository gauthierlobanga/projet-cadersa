<section class="relative overflow-hidden bg-white px-4 py-10 sm:px-8 sm:py-14 lg:px-12 lg:py-20 dark:bg-zinc-950">
    {{-- Ambiance lumineuse de fond --}}
    <div class="pointer-events-none absolute inset-0 z-0">
        <div
            class="absolute -top-40 right-0 h-150 w-150 rounded-full bg-linear-to-br from-emerald-200/20 to-teal-100/0 blur-3xl dark:from-emerald-500/5 dark:to-transparent">
        </div>
        <div
            class="absolute -bottom-20 -left-20 h-125 w-125 rounded-full bg-linear-to-tr from-zinc-200/40 to-emerald-100/0 blur-3xl dark:from-zinc-900/50 dark:to-transparent">
        </div>
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-size-[14px_24px] mask-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
        </div>
    </div>

    <div class="relative z-10 mx-auto w-full max-w-7xl">
        {{-- En-tête --}}
        <div x-cloak x-data="{ shown: false }" x-intersect="shown = true"
            :class="{ 'opacity-100 translate-y-0': shown, 'opacity-0 translate-y-4': !shown }"
            class="mx-auto max-w-3xl text-center transition-all duration-400 ease-out">
            <span
                class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                {{ $this->about->testimonial_title ?? 'Témoignages' }}
            </span>
            <h2
                class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                {{ $this->about->testimonial_subtitle ?? 'Ce que disent' }}<br />
                <span class="bg-linear-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">nos clients et partenaires</span>
            </h2>
            <div class="mt-6 h-1 w-20 rounded-full bg-linear-to-r from-emerald-500 to-teal-500 mx-auto"></div>
        </div>

        {{-- Grille des Témoignages --}}
        <div class="relative mt-10 sm:mt-12">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
                @forelse($this->testimonials as $testimonial)
                    <article
                        class="group flex flex-col border border-zinc-200 dark:border-zinc-800 transition duration-300 ease-out hover:bg-emerald-50/50 dark:hover:bg-emerald-900/20 p-5 sm:p-6 rounded-sm min-w-0">
                        <header class="flex items-start justify-between gap-4">
                            <div class="flex min-w-0 items-center gap-3">
                                @if ($testimonial->photo_url)
                                    <img loading="eager" decoding="async" src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->name }}" aria-hidden="true"
                                        loading="eager"
                                        class="object-cover size-10 rounded-full sm:size-12 ring-2 ring-zinc-100 dark:ring-zinc-800" />
                                @else
                                    <div
                                        class="flex items-center justify-center size-10 rounded-full bg-emerald-100 text-emerald-700 font-bold text-lg sm:size-12 dark:bg-emerald-900/40 dark:text-emerald-400">
                                        {{ strtoupper(substr($testimonial->name, 0, 2)) }}
                                    </div>
                                @endif

                                <div class="flex flex-col gap-px sm:gap-0.5">
                                    <cite
                                        class="truncate font-outfit font-medium text-zinc-900 not-italic sm:text-lg dark:text-white">
                                        {{ $testimonial->name }}
                                    </cite>
                                    <p class="text-pretty text-sm sm:text-base text-zinc-500 dark:text-zinc-400">
                                        {{ $testimonial->role }} @if($testimonial->company) • {{ $testimonial->company }} @endif
                                    </p>
                                </div>
                            </div>

                            {{-- Guillemets animés --}}
                            <svg aria-hidden="true"
                                class="h-6 shrink-0 text-zinc-300 mix-blend-luminosity sm:h-7.5 dark:text-zinc-600"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35 35" fill="none">
                                <path class="fill-current transition duration-500 ease-out group-hover:translate-x-4"
                                    d="M11.7982 16.9613H4.95865C5.07532 10.1508 6.41697 9.02785 10.6024 6.54868C11.0836 6.25702 11.244 5.64453 10.9524 5.1487C10.6607 4.66745 10.0482 4.50705 9.55234 4.79871C4.62318 7.71538 2.90234 9.49452 2.90234 17.982V25.8425C2.90234 28.3363 4.92947 30.3488 7.40864 30.3488H11.7836C14.3503 30.3488 16.2898 28.4092 16.2898 25.8425V21.4675C16.3044 18.9009 14.3649 16.9613 11.7982 16.9613Z" />
                                <path
                                    class="fill-current opacity-40 transition duration-500 ease-out group-hover:-translate-x-4"
                                    d="M27.5773 16.9613H20.7377C20.8544 10.1508 22.1962 9.02785 26.3816 6.54868C26.8629 6.25702 27.0233 5.64453 26.7316 5.1487C26.44 4.66745 25.8275 4.50705 25.3316 4.79871C20.4025 7.71538 18.6816 9.49452 18.6816 17.982V25.8425C18.6816 28.3363 20.7087 30.3488 23.1879 30.3488H27.5629C30.1296 30.3488 32.0691 28.4092 32.0691 25.8425V21.4675C32.0837 18.9009 30.144 16.9613 27.5773 16.9613Z" />
                            </svg>
                        </header>

                        <blockquote
                            class="text-pretty text-zinc-600 transition duration-500 ease-out will-change-transform group-hover:translate-x-0.5 mt-3 sm:mt-5 sm:text-lg dark:text-zinc-300">
                            {!! $testimonial->content !!}
                        </blockquote>
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-zinc-500 dark:text-zinc-400">Aucun Témoignage pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
