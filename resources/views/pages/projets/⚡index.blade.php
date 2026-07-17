<?php

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Settings\SettingApp;

new #[Layout('layouts::main')] class extends Component {
    use WithPagination;
    protected $scrollToTop = false;

    #[Url(as: 'status')]
    public string $filter = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'sort')]
    public string $sort = 'newest';

    public function with(): array
    {
        $query = Project::query()
            ->with(['media', 'tags'])
            ->active();

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->search . '%')->orWhere('location', 'LIKE', '%' . $this->search . '%');
            });
        }

        $query
            ->when($this->sort === 'oldest', fn($q) => $q->oldest('start_date'))
            ->when($this->sort === 'name-asc', fn($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'name-desc', fn($q) => $q->orderBy('title', 'desc'))
            ->when(!in_array($this->sort, ['oldest', 'name-asc', 'name-desc']), fn($q) => $q->latest('start_date'));

        return [
            'projects' => $query->paginate(9),
            'statuses' => ['all' => 'Tous', 'planned' => 'Planifiés', 'ongoing' => 'En cours', 'completed' => 'Terminés'],
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['filter', 'search', 'sort']);
        $this->resetPage();
    }

    public function getStatsProperty()
    {
        return [
            'projets' => Project::active()->count(),
            'en_cours' => Project::active()->where('status', 'ongoing')->count(),
            'termines' => Project::active()->where('status', 'completed')->count(),
        ];
    }

    public function getHeroImageProperty(): string
    {
        $settings = app(SettingApp::class);
        return $settings->logoUrl() ?? asset('images/cadersa-logo.png');
    }
};
?>

<?php

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use App\Settings\SettingApp;

new #[Layout('layouts::main')] class extends Component {
    use WithPagination;
    protected $scrollToTop = false;

    #[Url(as: 'status')]
    public string $filter = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'sort')]
    public string $sort = 'newest';

    public function with(): array
    {
        $query = Project::query()
            ->with(['media', 'tags'])
            ->active();

        if ($this->filter !== 'all') {
            $query->where('status', $this->filter);
        }
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->search . '%')->orWhere('location', 'LIKE', '%' . $this->search . '%');
            });
        }

        $query
            ->when($this->sort === 'oldest', fn($q) => $q->oldest('start_date'))
            ->when($this->sort === 'name-asc', fn($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'name-desc', fn($q) => $q->orderBy('title', 'desc'))
            ->when(!in_array($this->sort, ['oldest', 'name-asc', 'name-desc']), fn($q) => $q->latest('start_date'));

        return [
            'projects' => $query->paginate(9),
            'statuses' => ['all' => 'Tous', 'planned' => 'Planifiés', 'ongoing' => 'En cours', 'completed' => 'Terminés'],
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['filter', 'search', 'sort']);
        $this->resetPage();
    }

    public function getStatsProperty()
    {
        return [
            'projets' => Project::active()->count(),
            'en_cours' => Project::active()->where('status', 'ongoing')->count(),
            'termines' => Project::active()->where('status', 'completed')->count(),
        ];
    }

    public function getHeroImageProperty(): string
    {
        $settings = app(SettingApp::class);
        return $settings->logoUrl() ?? asset('images/cadersa-logo.png');
    }
};
?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">

    {{-- ==================== HERO ==================== --}}
    <section
        class="relative flex flex-col items-center gap-x-10 gap-y-5 border-b border-zinc-200 px-5 py-10 xs:px-8 sm:py-15 lg:flex-row lg:px-15 lg:gap-x-16 dark:border-zinc-800 max-w-7xl mx-auto"
        x-cloak x-data="cspState" x-intersect.once="shown = true">

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

        {{-- Image (logo) --}}
        <div class="shrink-0 lg:mt-7 transition-all duration-700 ease-out"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
            <img src="{{ $this->heroImage }}" width="400" height="271" fetchpriority="high"
                alt="{{ config('app.name') }}" class="w-72 sm:w-96 lg:w-md xl:w-136 h-auto object-contain" />
        </div>

        {{-- Texte + statistiques --}}
        <div class="flex flex-col items-start gap-4 w-full lg:w-auto">
            {{-- Bloc texte --}}
            <div class="flex flex-col items-start gap-6 w-full">
                <div class="inline-flex items-center gap-2.5 rounded-full border border-zinc-200 bg-white/80 px-3.5 py-1 text-[11px] font-medium uppercase tracking-[0.15em] text-zinc-500 shadow-[0_1px_2px_rgba(0,0,0,0.02)] backdrop-blur-md transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] dark:border-zinc-800 dark:bg-zinc-900/80 dark:text-zinc-400"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                    <span class="relative flex h-1.5 w-1.5">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span
                            class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                    </span>
                    Projets
                </div>

                <h1 class="text-pretty text-4xl font-bold tracking-tight text-zinc-950 sm:text-6xl xl:text-7xl font-serif dark:text-zinc-50 transition-all duration-1000 delay-100 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Nos <span
                        class="relative inline-block bg-linear-to-r from-emerald-600 via-emerald-500 to-teal-600 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-400">projets</span>
                </h1>

                <p class="max-w-xl text-lg leading-relaxed text-zinc-600/90 dark:text-zinc-400 font-sans transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Découvrez l'impact de nos actions sur le terrain au profit des communautés agricoles.
                </p>
            </div>

            {{-- Séparateur --}}
            <hr aria-hidden="true"
                class="my-2 h-0.5 w-full border-0 bg-zinc-200 mask-x-from-50% lg:mask-r-from-0% lg:mask-l-from-100% dark:bg-zinc-700" />

            {{-- Statistiques alignées à gauche --}}
            <div class="w-full transition-all duration-1000 delay-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                <div class="flex flex-wrap justify-start gap-5" aria-label="Statistiques des projets">
                    @foreach ($this->stats as $label => $value)
                        <div x-data="hoverStatsCard" class="group relative min-w-24 px-4 text-center xs:min-w-27 py-3">

                            <div x-ref="background"
                                class="absolute inset-0 rounded-lg bg-zinc-100 transition duration-300 ease-out group-hover:bg-emerald-100/50 dark:bg-zinc-800 dark:group-hover:bg-emerald-900/20"
                                aria-hidden="true"></div>

                            <div class="relative z-10 flex flex-col items-center gap-0.5">
                                <span
                                    class="text-xs font-semibold uppercase tracking-widest text-zinc-500 mix-blend-luminosity dark:text-zinc-400">{{ $label }}</span>
                                <span class="text-xl font-bold text-zinc-900 dark:text-white">{{ $value }}</span>
                            </div>

                            <div x-ref="topLeftCorner" class="absolute top-0 left-0" aria-hidden="true">
                                <svg class="h-2.5 text-emerald-500" viewBox="0 0 11 11" fill="none">
                                    <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div x-ref="bottomLeftCorner" class="absolute bottom-0 left-0" aria-hidden="true">
                                <svg class="h-2.5 -scale-y-100 text-emerald-500" viewBox="0 0 11 11" fill="none">
                                    <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div x-ref="topRightCorner" class="absolute top-0 right-0" aria-hidden="true">
                                <svg class="h-2.5 -scale-x-100 text-emerald-500" viewBox="0 0 11 11" fill="none">
                                    <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                </svg>
                            </div>
                            <div x-ref="bottomRightCorner" class="absolute right-0 bottom-0" aria-hidden="true">
                                <svg class="h-2.5 -scale-x-100 -scale-y-100 text-emerald-500" viewBox="0 0 11 11"
                                    fill="none">
                                    <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ========== SECTION FILTRES + LISTE ========== --}}
    <section x-cloak id="scroll-to-reference" x-data="{
        search: $wire.entangle('search').live,
        filter: $wire.entangle('filter').live,
        sortBy: $wire.entangle('sort').live,
        showFilters: false,
        sortOpen: false,
        activeFilterCount: 0,
        init() {
            this.activeFilterCount = this.filter !== 'all' ? 1 : 0;
            this.$watch('filter', val => this.activeFilterCount = val !== 'all' ? 1 : 0);
        },
        resetFilters() {
            this.filter = 'all';
            this.sortBy = 'newest';
            this.search = '';
            this.showFilters = false;
            this.$refs.filtersButton.focus();
        },
        clearSearch() {
            this.search = '';
            this.$nextTick(() => { if (this.$refs.searchInput) this.$refs.searchInput.focus(); });
        }
    }" aria-label="Recherche et filtres des projets"
        class="scroll-mt-11 px-5 py-8 xs:px-8 md:p-10 mx-auto max-w-7xl lg:px-12">

        <div class="mb-5">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Tous les projets</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Parcourez les projets de CADERSA</p>
        </div>

        {{-- Bandeau informatif --}}
        <div class="mb-8 border border-zinc-200/70 bg-white px-6 py-5 dark:border-zinc-800/70 dark:bg-zinc-900/50">
            <div class="flex flex-col items-start gap-5 sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center border border-zinc-200/60 bg-zinc-50/80 text-emerald-600 dark:border-zinc-800/60 dark:bg-zinc-900/50 dark:text-emerald-400">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-zinc-900 dark:text-white">Vous avez un projet en tête ?
                        </h3>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Nous sommes à l'écoute de vos idées pour le
                            développement rural.</p>
                    </div>
                </div>
                <div x-data="buttonTextReveal">
                    <a href="{{ route('contact') }}"
                        class="relative inline-flex h-11 items-center justify-center border border-zinc-200 bg-white px-5 text-sm font-medium text-zinc-700 transition-colors duration-200 hover:border-emerald-300 hover:bg-emerald-50/50 hover:text-emerald-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-emerald-700 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-300">
                        <svg data-icon class="absolute left-4 h-4 w-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <span data-text class="relative z-10 whitespace-nowrap" style="padding-left: 0;">Proposer un
                            projet</span>
                        <svg data-arrow
                            class="relative z-10 ml-1.5 h-3.5 shrink-0 transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- Barre de recherche + bouton filtres --}}
        <section class="flex w-full flex-col-reverse gap-3 sm:flex-row sm:items-center" role="search">
            <div class="flex items-center">
                {{-- Bouton Filtres --}}
                <button x-cloak type="button" x-ref="filtersButton" @click="showFilters = !showFilters"
                    :aria-expanded="showFilters" aria-controls="filters-panel"
                    class="group inline-flex h-10 items-center cursor-pointer gap-2 border border-zinc-200 bg-white px-4 text-sm font-medium text-zinc-600 transition-all duration-300 ease-out hover:border-zinc-300 hover:bg-zinc-50 hover:text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-zinc-600 dark:hover:bg-zinc-700 dark:hover:text-zinc-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50 focus-visible:ring-offset-2 active:scale-[0.97]"
                    :class="showFilters ?
                        '!border-emerald-500 !bg-emerald-50 !text-emerald-700 !shadow-emerald-100 hover:!bg-emerald-100 dark:!border-emerald-400 dark:!bg-emerald-900/20 dark:!text-emerald-300 dark:hover:!bg-emerald-900/30' :
                        ''">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10 5H3"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 0ms;" />
                        <path d="M12 19H3"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 30ms;" />
                        <path d="M14 3v4"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 60ms;" />
                        <path d="M16 17v4"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 90ms;" />
                        <path d="M21 12h-9"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 120ms;" />
                        <path d="M21 19h-5"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 150ms;" />
                        <path d="M21 5h-7"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 180ms;" />
                        <path d="M8 10v4"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 210ms;" />
                        <path d="M8 12H3"
                            class="transition-all duration-200 ease-out opacity-40 group-hover:opacity-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"
                            style="transition-delay: 240ms;" />
                    </svg>
                    <span>Filtres</span>
                </button>

                {{-- Bouton Reset --}}
                <div x-show="activeFilterCount > 0" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="grid transition-all duration-500 ease-out">
                    <div class="flex items-center overflow-hidden">
                        <div class="px-1 transition-opacity duration-500 ease-out opacity-100">
                            <svg class="h-px w-5 text-zinc-300 dark:text-zinc-600" viewBox="0 0 20 1" fill="none">
                                <line stroke="currentColor" y1="0.5" x2="20" y2="0.5"
                                    stroke-dasharray="4 4" />
                            </svg>
                        </div>
                        <button type="button" @click="resetFilters()" :inert="activeFilterCount === 0"
                            :aria-hidden="activeFilterCount === 0"
                            class="group inline-flex h-10 items-center justify-center gap-1.5 border border-zinc-200 bg-white px-3 text-sm font-medium text-zinc-600 shadow-sm transition-all duration-300 ease-out hover:border-red-300 hover:bg-red-50 hover:text-red-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-red-800 dark:hover:bg-red-900/20 dark:hover:text-red-400 active:scale-[0.97]">
                            <svg class="size-4 transition-transform duration-300 group-hover:rotate-180"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span>Réinitialiser</span>
                            <span
                                class="inline-grid h-5 min-w-5 place-items-center rounded-full bg-emerald-500 px-1 text-xs font-bold text-white"
                                x-text="activeFilterCount"></span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Champ de recherche --}}
            <div class="grow">
                <div
                    class="group relative flex h-10 items-center border border-zinc-200 bg-white transition-all duration-300 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-zinc-400 transition-colors duration-300 group-focus-within:text-emerald-500 dark:text-zinc-500 dark:group-focus-within:text-emerald-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input autocomplete="off"
                        class="h-full w-full border-0 bg-transparent pl-10 pr-12 text-sm font-medium text-zinc-900 placeholder:text-zinc-400 focus:outline-none focus:ring-0 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                        x-model.debounce.250ms="search" x-ref="searchInput" placeholder="Rechercher un projet...">
                    <button x-cloak x-show="search.length > 0" @click="clearSearch()"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-75" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-75"
                        class="absolute inset-y-0 right-0 flex items-center pr-3 text-zinc-400 transition-colors hover:text-zinc-600 dark:hover:text-zinc-300"
                        aria-label="Effacer la recherche">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>

        {{-- Panneau de filtre (statuts) --}}
        <div x-cloak id="filters-panel" x-show="showFilters" x-collapse style="display: none">
            <div class="mt-5 flex flex-col gap-4">
                <fieldset>
                    <legend class="mb-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">Statut :</legend>
                    <div class="flex flex-wrap gap-2">
                        <label for="status-all"
                            class="cursor-pointer select-none px-4 py-2 text-sm font-medium transition-all duration-300 ease-out transform hover:scale-101 active:scale-95 bg-zinc-50 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-zinc-200"
                            :class="{ '!bg-emerald-500 !text-white hover:!bg-emerald-500 dark:!bg-emerald-500 dark:hover:!bg-emerald-400 !shadow-emerald-500/20': filter === 'all' }">
                            Tous
                        </label>
                        <input type="radio" id="status-all" name="status-filter" value="all"
                            class="sr-only peer" x-model="filter" />

                        @foreach ($statuses as $key => $label)
                            @if ($key !== 'all')
                                <label for="status-{{ $key }}"
                                    class="cursor-pointer select-none px-4 py-2 text-sm font-medium transition-all duration-300 ease-out transform hover:scale-105 active:scale-95 bg-zinc-100 text-zinc-600 hover:bg-zinc-200 hover:text-zinc-800 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-zinc-200 shadow-sm hover:shadow-md"
                                    :class="{ '!bg-emerald-500 !text-white hover:!bg-emerald-600 dark:!bg-emerald-500 dark:hover:!bg-emerald-400 !shadow-emerald-500/20': filter === '{{ $key }}' }">
                                    {{ $label }}
                                </label>
                                <input type="radio" id="status-{{ $key }}" name="status-filter"
                                    value="{{ $key }}" class="sr-only peer" x-model="filter" />
                            @endif
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </div>

        {{-- Zone de tri (intégrée dans le même x-data) --}}
        <div class="custom-top-dashed-border mt-5 flex flex-wrap items-center justify-between gap-4 pt-5">
            <div class="flex flex-wrap items-center gap-4">
                <div x-cloak class="relative flex items-center gap-1.5 text-xs" @click.outside="sortOpen = false"
                    @keydown.escape.window="sortOpen = false">
                    <span class="text-zinc-500 dark:text-zinc-400">Trier par</span>
                    <button type="button" @click="sortOpen = !sortOpen" :aria-expanded="sortOpen"
                        class="group inline-flex cursor-pointer h-8 items-center gap-1.5 bg-zinc-100 px-3 text-sm font-medium text-zinc-700 transition-all duration-300 ease-out hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50">
                        <span
                            x-text="{
                            'newest': 'Plus récents',
                            'oldest': 'Plus anciens',
                            'name-asc': 'Titre A→Z',
                            'name-desc': 'Titre Z→A'
                        }[sortBy] || 'Plus récents'"></span>
                        <svg class="size-3.5 transition-transform duration-300 ease-out"
                            :class="sortOpen && 'rotate-180'" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>
                    <div x-show="sortOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-1 scale-95"
                        class="absolute top-full left-0 z-20 mt-1 w-40 overflow-hidden border border-zinc-200/60 bg-white shadow-md shadow-zinc-200/20 backdrop-blur-sm dark:border-zinc-700/60 dark:bg-zinc-900 dark:shadow-zinc-950/50"
                        role="listbox">
                        <div class="py-1">
                            @foreach (['newest' => 'Plus récents', 'oldest' => 'Plus anciens', 'name-asc' => 'Titre A→Z', 'name-desc' => 'Titre Z→A'] as $value => $label)
                                <button type="button" role="option"
                                    :aria-selected="sortBy === '{{ $value }}'"
                                    @click="sortBy = '{{ $value }}'; sortOpen = false"
                                    class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm transition-colors duration-150 hover:bg-emerald-50 dark:hover:bg-emerald-900/20"
                                    :class="sortBy === '{{ $value }}' ?
                                        'bg-emerald-50 font-semibold text-emerald-700 dark:bg-emerald-900/20 dark:text-emerald-400' :
                                        'text-zinc-600 dark:text-zinc-400'">
                                    <span class="size-4 flex items-center justify-center">
                                        <svg class="size-4 transition-opacity"
                                            :class="sortBy === '{{ $value }}' ? 'opacity-100' : 'opacity-0'"
                                            fill="none" stroke="currentColor" stroke-width="2.5"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    {{ $label }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-1.5 text-xs">
                    <span class="text-zinc-500 dark:text-zinc-400">Projets trouvés :</span>
                    <span
                        class="inline-grid h-7 min-w-8 place-items-center rounded-full bg-emerald-100 px-2 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                        {{ $projects->total() }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Grille des projets --}}
        <div wire:loading.class="opacity-50 pointer-events-none"
            class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 items-start gap-7 transition-opacity duration-300"
            x-data="autoAnimateGrid" aria-label="Liste des projets">
            @forelse($projects as $project)
                <a wire:navigate href="{{ route('projects.show', $project) }}"
                    class="gsap-reveal group relative flex flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
          hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
          dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20"
                    wire:key="project-{{ $project->id }}" aria-label="{{ $project->title }}">

                    {{-- Image + badge statut --}}
                    <div
                        class="relative overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                        @if ($project->hasMedia('cover'))
                            <img src="{{ $project->getFirstMediaUrl('cover', 'card') }}" alt="{{ $project->title }}"
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
                        {{-- Titre avec animation de losanges --}}
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
                                class="line-clamp-1 font-outfit font-medium text-zinc-900 transition-colors duration-300
                      group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                {{ $project->title }}
                            </p>
                        </div>

                        {{-- Extrait du contenu --}}
                        <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $project->getPlainTextContent(120) }}
                        </p>

                        {{-- Localisation --}}
                        <div class="mt-5 flex items-center justify-between gap-3">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $project->location ?? 'Kasaï Central' }}
                            </span>
                        </div>
                    </div>

                    {{-- Barre d'action : statut + détails --}}
                    @php
                        $statusColors = [
                            'completed' =>
                                'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
                            'ongoing' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                            'planned' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300',
                        ];
                        $statusLabels = [
                            'completed' => 'Terminé',
                            'ongoing' => 'En cours',
                            'planned' => 'Planifié',
                        ];
                        $colorClass = $statusColors[$project->status] ?? $statusColors['planned'];
                        $label = $statusLabels[$project->status] ?? 'Planifié';
                    @endphp

                    <div class="flex h-11 items-stretch text-sm font-medium">
                        {{-- Bloc statut avec son propre fond coloré --}}
                        <div
                            class="inline-flex min-w-25 items-center justify-center border-r border-r-white/20 dark:border-r-zinc-700/30 px-3 {{ $colorClass }}">
                            <span
                                class="inline-flex items-center gap-1.5 bg-transparent dark:bg-transparent px-2.5 py-0.5 text-xs font-semibold
                         {{ $colorClass }}">
                                {{ $label }}
                            </span>
                        </div>

                        {{-- Bloc "Détails" avec fond émeraude indépendant --}}
                        <div
                            class="inline-flex grow items-center justify-between gap-3 px-4
                    bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out
                    group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                            <span>Détails</span>
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
                            <h3 class="text-xl font-bold text-zinc-900 dark:text-white">Aucun projet trouvé</h3>
                            <p class="mt-2 text-sm leading-relaxed text-zinc-500 dark:text-zinc-400">Essayez d'ajuster
                                vos filtres ou votre terme de recherche.</p>
                            @if ($filter !== 'all' || $search || $sort !== 'newest')
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

        <div class="mt-10">
            {{ $projects->links('pagination::custom') }}
        </div>
    </section>
</div>
