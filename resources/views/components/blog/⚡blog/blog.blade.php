<section class="border-t border-zinc-200 bg-white py-24 dark:border-zinc-800 dark:bg-zinc-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- En‑tête --}}
        <div class="mx-auto max-w-3xl text-center mb-20" x-data="cspState" x-intersect="shown = true">
            @if ($this->about->blog_hero_badge)
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-emerald-100/80 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300 transition-all duration-500 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    {{ $this->about->blog_hero_badge }}
                </span>
            @endif

            <h2 class="mt-6 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-zinc-900 dark:text-white transition-all duration-500 delay-100 ease-out"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                {{ $this->about->blog_hero_title ?: 'Blog & Actualités' }}
            </h2>
            <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-8 text-zinc-600 dark:text-zinc-400 transition-all duration-500 delay-200 ease-out"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                {{ $this->about->blog_hero_subtitle ?: 'Retrouvez des articles, des nouvelles et des ressources sur le développement web moderne.' }}
            </p>
        </div>

        {{-- Grille des articles --}}
        <div class="mt-5 grid min-h-136 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start gap-7 transition-opacity duration-300 no-animate"
            aria-label="Liste des articles">
            @forelse ($this->posts as $post)
                <a href="{{ route('posts.show', $post) }}" wire:navigate
                    class="group relative flex flex-col overflow-hidden rounded border border-zinc-200 bg-white shadow transition-all duration-500 ease-out hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30 dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20"
                    wire:key="{{ $post->id }}" aria-label="{{ $post->title }}">

                    {{-- Image --}}
                    <div
                        class="relative aspect-video w-full overflow-hidden bg-zinc-100 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:ring-zinc-700 transition duration-500 group-hover:ring-emerald-300 dark:group-hover:ring-emerald-700">
                        @if ($post->hasMedia('featured'))
                            <img loading="eager" decoding="async"
                                src="{{ $post->getFirstMediaUrl('featured', 'card') ?: $post->getFirstMediaUrl('featured') }}"
                                alt="{{ $post->title }}"
                                class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105" />
                        @else
                            <div class="flex h-full w-full items-center justify-center">
                                <svg class="h-12 w-12 text-zinc-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Contenu --}}
                    <div class="flex flex-1 flex-col gap-2 p-5 sm:p-6">
                        <div
                            class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                            <div x-data="rotatingBadge()" class="absolute top-1/2 -left-4 -translate-y-1/2">
                                <div
                                    class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                    <div data-rotating class="flex items-center gap-0.75">
                                        <div class="flex flex-col gap-1">
                                            <div data-box class="size-0.75 bg-emerald-600 dark:bg-emerald-400"></div>
                                            <div data-box class="size-0.75 bg-emerald-600 dark:bg-emerald-400"></div>
                                        </div>
                                        <div data-box class="size-0.75 bg-emerald-600 dark:bg-emerald-400"></div>
                                    </div>
                                </div>
                            </div>
                            <h3
                                class="line-clamp-1 font-outfit font-semibold text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400 text-lg">
                                {{ $post->title }}
                            </h3>
                        </div>

                        <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ $post->getPlainTextContent(120) }}
                        </p>

                        <div class="mt-auto pt-4 flex items-center justify-between gap-3">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                @if ($post->categories->isNotEmpty())
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full border border-zinc-200/60 bg-white px-2 py-0.5 text-xs font-medium dark:border-zinc-700 dark:bg-zinc-800">
                                        {{ $post->categories->first()->nom }}
                                    </span>
                                @endif
                            </span>
                            <time class="text-sm text-zinc-500 dark:text-zinc-400"
                                datetime="{{ $post->published_at?->format('Y-m-d') ?? $post->created_at->format('Y-m-d') }}">
                                {{ $post->published_at?->translatedFormat('d M Y') ?? $post->created_at->translatedFormat('d M Y') }}
                            </time>
                        </div>

                        <div class="mt-3 flex items-center justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-2">
                                <img src="{{ $post->user?->avatar_url ?? asset('images/gauthier-lobanga.jpg') }}"
                                    alt="{{ $post->user?->name ?? 'Gauthier Lobanga' }}"
                                    class="h-6 w-6 rounded-full object-cover" />
                                <span class="max-w-40 truncate text-sm text-zinc-600 dark:text-zinc-400">
                                    <strong>{{ $post->user?->name ?? 'Gauthier Lobanga' }}</strong>
                                </span>
                            </div>
                            <span class="flex items-center gap-1 text-sm text-zinc-500 dark:text-zinc-400">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                {{ $post->views_count ?? 0 }}
                            </span>
                        </div>
                    </div>

                    <div class="flex h-11 items-stretch text-sm font-medium mt-auto">
                        <div
                            class="inline-flex grow items-center justify-between gap-3 px-4 bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                            <span>Lire l'article</span>
                            <span class="transition duration-300 ease-out group-hover:translate-x-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3" viewBox="0 0 28 22"
                                    fill="none">
                                    <path class="fill-current"
                                        d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 lg:py-24">
                    <div x-data="cspState()" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                        class="transition-all duration-300 ease-out">
                        <div
                            class="mx-auto max-w-7xl rounded-3xl border border-dashed border-zinc-300 bg-zinc-50/60 px-8 py-12 text-center dark:border-zinc-700 dark:bg-zinc-900/60">
                            <div
                                class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30">
                                <svg class="h-10 w-10 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Aucun article trouvé</h3>
                            <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                Il n'y a pas encore d'articles publiés pour le moment. Revenez bientôt !
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Bouton "Voir tous les articles" --}}
        @if ($this->posts->isNotEmpty())
            <nav class="mt-14 flex justify-center">
                <div x-data="buttonAnimation"
                    class="rounded-full bg-emerald-600 dark:bg-emerald-500 shadow-lg shadow-emerald-500/20">
                    <a href="{{ route('posts.index') }}" wire:navigate
                        class="group inline-flex w-full items-center justify-between rounded-full font-semibold whitespace-nowrap text-white transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                        <span data-text class="grow">Voir tous les articles</span>
                        <div data-icon
                            class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-white text-emerald-600 dark:bg-zinc-800 dark:text-emerald-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25" viewBox="0 0 28 22" fill="none">
                                <path class="fill-current"
                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                            </svg>
                        </div>
                    </a>
                </div>
            </nav>
        @endif
    </div>
</section>
