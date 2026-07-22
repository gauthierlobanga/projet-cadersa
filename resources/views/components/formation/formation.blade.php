{{-- resources/views/livewire/formation-list.blade.php --}}
<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
    <section x-cloak id="scroll-to-reference" aria-label="Recherche et filtres des formations"
        class="scroll-mt-11 px-5 py-8 xs:px-8 md:p-10 mx-auto max-w-7xl lg:px-12">

        {{-- En‑tête --}}
        <div class="mb-8 max-w-3xl" x-data="cspState" x-intersect="shown = true">
            <h2 class="mt-4 text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-zinc-900 dark:text-white transition-all duration-300 delay-100 ease-out"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                {{ $this->about->formation_title ?: 'Plongez au cœur de mes formations' }}
            </h2>
            <p class="mt-4 sm:mt-6 text-base sm:text-lg leading-8 text-zinc-600 dark:text-zinc-400 transition-all duration-300 delay-200 ease-out"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                {{ $this->about->formation_subtitle ?: 'En présentiel ou à distance, je vous accompagne dans la maîtrise du développement web moderne…' }}
            </p>
        </div>

        {{-- Grille des formations --}}
        <div wire:loading.class="opacity-50 pointer-events-none"
            class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start gap-7 transition-opacity duration-300 no-animate"
            aria-label="Liste des formations">
            @forelse ($this->formations as $formation)
                <a href="{{ route('formations.show', $formation) }}" wire:navigate
                    class="group relative flex flex-col border rounded-md border-zinc-200/50 bg-white transition-all duration-500 ease-out
                          hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                          dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20"
                    wire:key="formation-{{ $formation->id }}" aria-label="{{ $formation->title }}">

                    <div
                        class="relative overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                        @if ($formation->hasMedia('cover'))
                            <img decoding="async" src="{{ $formation->getFirstMediaUrl('cover', 'card') }}"
                                alt="{{ $formation->title }}"
                                class="aspect-video w-full object-contain transition duration-300 ease-out group-hover:scale-105"
                                loading="eager" />
                        @else
                            <div
                                class="flex aspect-video w-full items-center justify-center bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div class="flex flex-1 flex-col gap-2 p-4">
                        <div
                            class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                            <div x-data="rotatingBadge" class="absolute top-1/2 -left-4 -translate-y-1/2">
                                <div
                                    class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                    <div data-rotating class="flex items-center gap-0.75">
                                        <div class="flex flex-col gap-1">
                                            <div data-box class="size-0.75 bg-current"></div>
                                            <div data-box class="size-0.75 bg-current"></div>
                                        </div>
                                        <div data-box class="size-0.75 bg-current"></div>
                                    </div>
                                </div>
                            </div>
                            <p
                                class="line-clamp-1 font-outfit font-medium text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                {{ $formation->title }}
                            </p>
                        </div>
                        <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $formation->getPlainTextContent(120) }}
                        </p>
                        <div class="mt-3 flex items-center justify-between gap-3">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                @if ($formation->category)
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full border border-zinc-200/60 bg-white px-2 py-0.5 text-xs font-medium dark:border-zinc-700 dark:bg-zinc-800"
                                        style="color: {{ $formation->category->color }}">
                                        {{ $formation->category->name }}
                                    </span>
                                @endif
                            </span>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $formation->start_date?->translatedFormat('d M Y') }}
                                @if ($formation->end_date)
                                    → {{ $formation->end_date->translatedFormat('d M Y') }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="flex h-11 items-stretch text-sm font-medium">
                        <div
                            class="inline-flex grow items-center justify-between gap-3 px-4 bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                            <span>En savoir plus</span>
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
                    <div x-data="cspState" x-intersect="shown = true"
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
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Aucune formation trouvée</h3>
                            <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                Essayez d'ajuster votre recherche ou vos filtres.
                            </p>
                            @if ($search || $categorySlug)
                                <button wire:click="clearFilters"
                                    class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm shadow-emerald-200 transition-all duration-200 hover:bg-emerald-700 hover:shadow-md dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:shadow-emerald-900/50">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Réinitialiser les filtres
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Bouton vers toutes les formations (si pas déjà sur la page index) --}}
        @if (request()->routeIs('formations.index') === false && $this->formations->isNotEmpty())
            <nav class="mt-14 flex justify-center">
                <div x-data="buttonAnimation" class="rounded-full bg-emerald-200 dark:bg-emerald-900">
                    <a href="{{ route('formations.index') }}" wire:navigate
                        class="group inline-flex w-full items-center justify-between rounded-full font-medium whitespace-nowrap text-stone-900 dark:text-white transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-emerald-200 hover:bg-emerald-100 dark:bg-emerald-900 dark:hover:bg-emerald-800">
                        <span data-text class="grow">Voir toutes les formations</span>
                        <div data-icon
                            class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-white text-stone-900 dark:bg-zinc-800 dark:text-zinc-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25" viewBox="0 0 28 22" fill="none">
                                <path class="fill-current"
                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                            </svg>
                        </div>
                    </a>
                </div>
            </nav>
        @endif

    </section>
</div>
