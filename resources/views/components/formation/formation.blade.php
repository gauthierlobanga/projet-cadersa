<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
    {{-- ========== HEADER  ========== --}}
    <section x-cloak id="scroll-to-reference" x-data="{
        search: $wire.entangle('search').live,
        showFilters: false,
        category: $wire.entangle('category').live,
        sortBy: $wire.entangle('sort').live,
        sortDropdownOpen: false,
        get activeFilterCount() {
            return this.category ? 1 : 0
        },
        resetFilters() {
            this.category = null
            this.sortBy = 'newest'
            this.search = ''
            this.showFilters = false
            $refs.filtersButton.focus()
            document.querySelector('#scroll-to-reference')?.scrollIntoView({ behavior: 'smooth' })
        },
        listeningMessages: [`Whatcha looking for? 🔍`, `I'm listening... 👀`, `Go ahead, I'm ready 🎯`, `Type away! ⌨️`, `Searching is fun! 🤓`, `What can I find for you? 🕵️‍♂️`],
        listeningIndex: 0,
        get listeningMessage() {
            return this.listeningMessages[this.listeningIndex % this.listeningMessages.length]
        },
        rotateListeningMessage() {
            this.listeningIndex++
        },
    }" aria-label="Plugin search and listing"
        class="scroll-mt-11 px-5 py-8 xs:px-8 md:p-10 mx-auto max-w-7xl lg:px-12">
         <div class="mb-16 max-w-3xl" x-data="{ shown: false }" x-intersect="shown = true">
             <h2 class="mt-4 text-4xl font-semibold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-5xl transition-all duration-700 delay-100 ease-out"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                Plongez au cœur de nos <span class="text-emerald-600 dark:text-emerald-400">formations</span>
            </h2>
            <p class="mt-6 text-lg leading-8 text-zinc-600 dark:text-zinc-400 transition-all duration-700 delay-200 ease-out"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                À travers notre approche <strong class="text-emerald-600 dark:text-emerald-400">4B</strong> (Bonne
                cuisson, Bonne alimentation, Bonne planification familiale pour la Bonne santé), nous développons des
                solutions durables.
            </p>
        </div>
        {{-- Grille des articles --}}
        <div wire:loading.class="opacity-50 pointer-events-none"
            class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start gap-7 transition-opacity duration-300"
            x-init="autoAnimate($el, { duration: 250 })" aria-label="Liste des articles">
            @forelse ($posts as $post)
                <a href="{{ route('posts.show', $post) }}" wire:navigate
                    class="gsap-reveal group relative flex flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
                   hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                   dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20"
                    wire:key="{{ $post->id }}" aria-label="{{ $post->title }}">

                    {{-- Image --}}
                    <div
                        class="relative overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                        @if ($post->hasMedia('featured'))
                            <img src="{{ $post->getFirstMediaUrl('featured', 'card') }}" alt="{{ $post->title }}"
                                class="aspect-video w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                loading="lazy" />
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

                    {{-- Corps de la carte --}}
                    <div class="flex flex-1 flex-col gap-2 p-4">
                        {{-- Titre avec losange animé --}}
                        <div
                            class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                            <div x-data="{
                                init() {
                                    const tweens = [];
                                    let playing = false;
                                    const rotatingEl = $el.querySelector('[data-rotating]');
                                    const rotate = () => {
                                        gsap.to(rotatingEl, {
                                            rotation: '+=60',
                                            duration: 0.5,
                                            ease: 'sine.out',
                                            onComplete: () => { if (playing) gsap.delayedCall(0.5, rotate); },
                                        });
                                    };
                                    const boxes = $el.querySelectorAll('[data-box]');
                                    const delays = [0, 0.2, 0.1];
                                    boxes.forEach((box, i) => {
                                        tweens.push(
                                            gsap.to(box, {
                                                opacity: 0.3,
                                                repeat: -1,
                                                yoyo: true,
                                                duration: 0.4,
                                                delay: delays[i] || 0,
                                                ease: 'power1.inOut',
                                                paused: true,
                                            })
                                        );
                                    });
                                    const group = $el.closest('.group');
                                    if (group) {
                                        group.addEventListener('mouseenter', () => {
                                            playing = true;
                                            tweens.forEach((t) => t.resume());
                                            rotate();
                                        });
                                        group.addEventListener('mouseleave', () => {
                                            playing = false;
                                            tweens.forEach((t) => t.pause());
                                        });
                                    }
                                }
                            }" class="absolute top-1/2 -left-4 -translate-y-1/2">
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
                                class="line-clamp-1 font-outfit font-medium text-zinc-900 transition-colors duration-300
                              group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                {{ $post->title }}
                            </p>
                        </div>

                        {{-- Extrait --}}
                        <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $post->getPlainTextContent(120) }}
                        </p>

                        {{-- Métadonnées : catégorie + date --}}
                        <div class="mt-3 flex items-center justify-between gap-3">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                @if ($post->categories->isNotEmpty())
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full border border-zinc-200/60 bg-white px-2 py-0.5 text-xs font-medium dark:border-zinc-700 dark:bg-zinc-800">
                                        {{ $post->categories->first()->nom }}
                                    </span>
                                @endif
                            </span>
                            <time class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $post->published_at?->translatedFormat('d F Y') ?? $post->created_at->translatedFormat('d F Y') }}
                            </time>
                        </div>
                    </div>

                    {{-- Barre d'action : "Lire l'article" --}}
                    <div class="flex h-11 items-stretch text-sm font-medium">
                        <div
                            class="inline-flex grow items-center justify-between gap-3 px-4
                            bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out
                            group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
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
                    <div x-data="{ shown: false }" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                        class="transition-all duration-700 ease-out">
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
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
                                Aucun article trouvé
                            </h3>
                            <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">
                                Il n'y a pas encore d'article correspondant à cette recherche. Essayez d'ajuster vos
                                filtres ou votre terme de recherche.
                            </p>
                            @if ($search || $category || $sort !== 'newest')
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

        {{-- Bouton "Voir tous les domaines" --}}
        <nav class="mt-14 flex justify-center">
            <div x-data
                class="border border-zinc-200 bg-white hover:border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:hover:border-zinc-600 transition-colors duration-200"
                x-init="function() {
                    if (typeof gsap === 'undefined' || typeof SplitText === 'undefined') return;
                    const button = $el.querySelector('a');
                    if (!button) return;
                    const textWrapper = button.querySelector('[data-text]');
                    const arrow = button.querySelector('[data-icon] svg');
                    if (!textWrapper || !arrow) return;
                    const split = new SplitText(textWrapper, { type: 'chars' });
                    const chars = split.chars;
                    const tl = gsap.timeline({ paused: true });
                    tl.to(chars, {
                        keyframes: [
                            { y: -10, opacity: 0, duration: 0.2, ease: 'power2.in' },
                            { y: 10, opacity: 0, duration: 0 },
                            { y: 0, opacity: 1, duration: 0.2, ease: 'power2.out' }
                        ],
                        stagger: 0.02
                    }, 0);
                    tl.to(arrow, {
                        keyframes: [
                            { y: -30, duration: 0.25, ease: 'power2.in' },
                            { y: 30, duration: 0 },
                            { y: 0, duration: 0.25, ease: 'power2.out' }
                        ]
                    }, 0.1);
                    button.addEventListener('mouseenter', () => tl.play());
                    button.addEventListener('mouseleave', () => tl.reverse());
                }">

                <a href="{{ route('posts.index') }}" wire:navigate
                    aria-label="Voir tous les domaines d'intervention"
                    class="group inline-flex w-auto items-center justify-between gap-3 px-6 py-3 text-sm font-medium text-zinc-900 transition-colors duration-200 hover:text-emerald-600 dark:text-white dark:hover:text-emerald-400">

                    <span data-text>Voir toutes les formations</span>

                    <div data-icon class="flex items-center text-emerald-600 dark:text-emerald-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 28 22" fill="none">
                            <path class="fill-current"
                                d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                        </svg>
                    </div>
                </a>
            </div>
        </nav>

    </section>
</div>
