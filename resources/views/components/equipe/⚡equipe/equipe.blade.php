{{-- resources/views/livewire/team-section.blade.php --}}
<section class="relative overflow-hidden bg-white px-8 py-10 sm:px-10 sm:py-15 lg:px-15 lg:py-20 dark:bg-zinc-950">
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

    <div class="relative z-10 mx-auto max-w-350 px-6 lg:px-8">
        {{-- En-tête --}}
        <div class="mx-auto max-w-3xl text-center" x-data="{ visible: false }" x-intersect="visible = true"
            :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-6': !visible }"
            class="transition-all duration-700">
            <span
                class="inline-block rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                Notre équipe
            </span>
            <h2
                class="mt-4 text-4xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-5xl">
                Ce sont nos collaborateurs<br />
                <span class="bg-linear-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">qui font notre
                    grandeur</span>
            </h2>
            <div class="mt-6 h-1 w-20 rounded-full bg-linear-to-r from-emerald-500 to-teal-500 mx-auto"></div>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto">
                Nous réunissons des talents passionnés, animés par l’envie de créer de la valeur et d’accompagner nos
                clients vers le succès.
            </p>
        </div>

        {{-- Grille des membres avec animation GSAP ScrollTrigger --}}
        <div class="relative mt-12" x-data="{
            init() {
                if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
                const articles = gsap.utils.toArray(this.$el.querySelectorAll('article'));
                articles.forEach((article, index) => {
                    gsap.fromTo(article, { opacity: 0, y: 30 }, {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        ease: 'power2.out',
                        scrollTrigger: {
                            trigger: article,
                            start: 'top bottom-=80',
                            toggleActions: 'play none none none',
                        },
                        delay: index * 0.1
                    });
                });
            }
        }">
            <div class="columns-1 sm:columns-2 lg:columns-3 gap-6">
                @forelse($this->members as $member)
                    <article
                        class="group block break-inside-avoid border border-zinc-200 dark:border-zinc-800 transition duration-500 ease-out not-last:mb-6 odd:hover:bg-emerald-50/50 even:hover:bg-teal-50/50 dark:odd:hover:bg-emerald-900/20 dark:even:hover:bg-teal-900/20 p-6 sm:p-8">
                        <header class="flex items-start justify-between gap-5">
                            <div class="flex items-center gap-2.5 sm:gap-3.5">
                                @if ($member->photo_url)
                                    <img src="{{ $member->photo_url }}" alt="{{ $member->name }}" aria-hidden="true"
                                        loading="lazy"
                                        class="object-cover size-10 rounded-full sm:size-12 ring-2 ring-zinc-100 dark:ring-zinc-800" />
                                @else
                                    <div
                                        class="flex items-center justify-center size-10 rounded-full bg-emerald-100 text-emerald-700 font-bold text-lg sm:size-12 dark:bg-emerald-900/40 dark:text-emerald-400">
                                        {{ $member->initials }}
                                    </div>
                                @endif

                                <div class="flex flex-col gap-px sm:gap-0.5">
                                    <cite
                                        class="truncate font-outfit font-medium text-zinc-900 not-italic sm:text-lg dark:text-white">
                                        {{ $member->name }}
                                    </cite>
                                    <p class="text-pretty text-sm sm:text-base text-zinc-500 dark:text-zinc-400">
                                        {{ $member->role }}
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
                            {!! $member->bio !!}
                        </blockquote>

                        {{-- Liens sociaux --}}
                        @php
                            $socialIcons = [
                                'facebook' =>
                                    'M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z',
                                'linkedin' =>
                                    'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z',
                                'twitter' =>
                                    'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z',
                                'github' =>
                                    'M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z',
                            ];
                            $socialLinks = $member->social_links ?? [];
                        @endphp

                        @if (!empty($socialLinks))
                            <div class="mt-4 flex items-center gap-2">
                                @foreach ($socialLinks as $platform => $url)
                                    @if (isset($socialIcons[$platform]))
                                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                                            class="flex h-8 w-8 items-center justify-center rounded bg-zinc-100 text-zinc-500 transition-colors duration-200 hover:bg-emerald-100 hover:text-emerald-600 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400"
                                            aria-label="{{ ucfirst($platform) }} de {{ $member->name }}">
                                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"
                                                aria-hidden="true">
                                                <path fill-rule="evenodd" d="{{ $socialIcons[$platform] }}"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-zinc-500 dark:text-zinc-400">Aucun membre d'équipe pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
