<?php

use Livewire\Component;
use App\Models\Post;
use App\Models\PostCategory;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

new #[Layout('layouts::main')] class extends Component {
    use WithPagination;

    protected $scrollToTop = false;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'cat')]
    public ?string $category = null;

    #[Url(as: 'sort')]
    public string $sort = 'newest';

    public function with(): array
    {
        $query = Post::query()
            ->with(['user', 'categories', 'media'])
            ->published();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('content', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('excerpt', 'LIKE', '%' . $this->search . '%');
            });
        }

        if ($this->category) {
            $query->whereHas('categories', fn($q) => $q->where('slug', $this->category));
        }

        $query
            ->when($this->sort === 'oldest', fn($q) => $q->oldest('published_at'))
            ->when($this->sort === 'popular', fn($q) => $q->orderBy('views_count', 'desc'))
            ->when($this->sort === 'name-asc', fn($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'name-desc', fn($q) => $q->orderBy('title', 'desc'))
            ->when(!in_array($this->sort, ['oldest', 'popular', 'name-asc', 'name-desc']), fn($q) => $q->latest('published_at'));

        return [
            'posts' => $query->paginate(9),
            'categories' => PostCategory::actifs()->get(),
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'category', 'sort']);
        $this->resetPage();
    }

    public function getStatsProperty()
    {
        return [
            'articles' => Post::published()->count(),
            'authors' => Post::published()->distinct('user_id')->count('user_id'),
            'categories' => PostCategory::whereHas('posts', fn($q) => $q->published())->count(),
            'views' => Post::published()->sum('views_count'),
        ];
    }
};
?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
    {{-- ========== HEADER  ========== --}}
    <section x-cloak class="relative overflow-hidden bg-[#fafaf9] py-18 sm:py-24 lg:py-28 dark:bg-zinc-950"
        x-data="cspState()" x-intersect.once="shown = true">

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

        <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
            {{-- Grille Asymétrique Premium (Ratio 7:5 sur écrans larges) --}}
            <div class="grid grid-cols-1 items-start gap-16 lg:grid-cols-12 lg:gap-24">

                {{-- BLOC TEXTE PRINCIPAL (7 colonnes) --}}
                <div class="flex flex-col items-start gap-6 lg:col-span-7">
                    {{-- Badge Minimaliste Micro-Interactions --}}
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-zinc-200 bg-white/80 px-3.5 py-1 text-[11px] font-medium uppercase tracking-[0.15em] text-zinc-500 shadow-[0_1px_2px_rgba(0,0,0,0.02)] backdrop-blur-md transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] dark:border-zinc-800 dark:bg-zinc-900/80 dark:text-zinc-400"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                        <span class="relative flex h-1.5 w-1.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span
                                class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                        </span>
                        Blog & Actualités
                    </div>

                    {{-- Titre : Hiérarchie Ultra-Marquée --}}
                    <h1 class="text-pretty text-4xl font-bold tracking-tight text-zinc-950 sm:text-6xl xl:text-7xl font-serif dark:text-zinc-50 transition-all duration-1000 delay-100 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Le pouls de <span
                            class="relative inline-block bg-linear-to-r from-emerald-600 via-emerald-500 to-teal-600 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-400">CADERSA</span>
                    </h1>

                    {{-- Description : Espace Négatif & Confort de Lecture --}}
                    <p class="max-w-xl text-lg leading-relaxed text-zinc-600/90 dark:text-zinc-400 font-sans transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Plongez au cœur de nos actions : <span
                            class="font-medium text-zinc-950 dark:text-zinc-100">formations, résultats terrain et
                            innovations</span> qui façonnent un impact durable sur l'agriculture locale.
                    </p>
                </div>

                {{-- PANNEAU D'INFORMATION ET STATISTIQUES (5 colonnes) --}}
                <div class="w-full lg:col-span-5 lg:pt-4 transition-all duration-1000 delay-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">

                    {{-- Carte Unique Style Bento Box / Glassmorphism --}}
                    <div
                        class="group relative overflow-hidden bg-white/40 p-8 transition-all duration-500 dark:border-zinc-800 dark:bg-zinc-900/40">

                        <div class="relative z-10 flex flex-col gap-8">
                            {{-- Grille Interne des Stats --}}
                            <div class="grid grid-cols-2 gap-x-8 gap-y-10 sm:grid-cols-3 lg:grid-cols-2">

                                @foreach ($this->stats as $label => $value)
                                    <div x-data="cspState()" @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="group relative min-w-24 px-4 py-3 text-center xs:min-w-27 transition-all duration-700 delay-{{ 300 + $loop->index * 100 }}"
                                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                        <div class="absolute inset-0 rounded-xl bg-emerald-50/80 transition duration-300 ease-out group-hover:bg-emerald-100 dark:bg-white/5 dark:group-hover:bg-emerald-500/10"
                                            aria-hidden="true"></div>
                                        <div class="relative z-10 flex flex-col items-center">
                                            <span
                                                class="text-xs font-semibold uppercase tracking-widest text-zinc-500 group-hover:text-emerald-700 transition-colors duration-300 dark:text-zinc-400 dark:group-hover:text-emerald-300">{{ $label }}</span>
                                            <span
                                                class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</span>
                                        </div>
                                        {{-- Coins décoratifs animés --}}
                                        <svg class="absolute top-0 left-0 h-2.5 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ '-translate-x-1 -translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute bottom-0 left-0 h-2.5 -scale-y-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ '-translate-x-1 translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute top-0 right-0 h-2.5 -scale-x-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ 'translate-x-1 -translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute bottom-0 right-0 h-2.5 -scale-x-100 -scale-y-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ 'translate-x-1 translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Coins graphiques ultra-discrets (Signature Tech/Pro) --}}
                        <div
                            class="absolute top-3 left-3 size-1.5 border-t border-l border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute top-3 right-3 size-1.5 border-t border-r border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute bottom-3 left-3 size-1.5 border-b border-l border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute bottom-3 right-3 size-1.5 border-b border-r border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>


    {{-- ========== SECTION FILTRES + LISTE ========== --}}
    <section x-cloak id="scroll-to-reference" x-data="postSearchFilters()"
        aria-label="Plugin search and listing"
        class="scroll-mt-11 px-5 py-8 xs:px-8 md:p-10 mx-auto max-w-7xl lg:px-12">
        <div class="mb-5">
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Tous les articles</h2>
            <p class="text-sm text-zinc-500 dark:text-zinc-400">Parcourez les actualités et publications de CADERSA</p>
        </div>

        {{-- Barre de recherche + bouton filtres --}}
        <section class="flex w-full flex-col-reverse gap-3 sm:flex-row sm:items-center" role="search">
            {{-- Groupe de boutons Filtres / Reset --}}
            <div class="flex items-center">
                {{-- Bouton Filtres --}}
                <button x-cloak type="button" x-ref="filtersButton" @click="showFilters = !showFilters"
                    :aria-expanded="showFilters" aria-controls="filters-panel"
                    class="group inline-flex h-10 items-center cursor-pointer gap-2 border border-zinc-200 bg-white px-4 text-sm font-medium
           text-zinc-600 transition-all duration-300 ease-out
           hover:border-zinc-300 hover:bg-zinc-50 hover:text-zinc-800
           dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-zinc-600 dark:hover:bg-zinc-700 dark:hover:text-zinc-100
           focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50 focus-visible:ring-offset-2
           active:scale-[0.97]"
                    :class="showFilters
                        ?
                        'border-emerald-500! bg-emerald-50! text-emerald-700! shadow-emerald-100 hover:bg-emerald-100! dark:border-emerald-400! dark:bg-emerald-900/20! dark:text-emerald-300! dark:hover:bg-emerald-900/30!' :
                        ''">

                    {{-- Icône filtre animée path par path --}}
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
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

                {{-- Bouton Reset (apparaît si des filtres sont actifs) --}}
                <div class="grid transition-[grid-template-columns] duration-500 ease-out"
                    style="grid-template-columns: 0fr"
                    :style="`grid-template-columns: ${activeFilterCount > 0 ? '1fr' : '0fr'}; transition-delay: ${activeFilterCount > 0 ? '0ms' : '400ms'}`">
                    <div class="flex items-center overflow-hidden">
                        <div class="px-1 transition-opacity duration-500 ease-out"
                            :style="`opacity: ${activeFilterCount > 0 ? '1' : '0'}; transition-delay: ${activeFilterCount > 0 ? '0ms' : '400ms'}`">
                            <svg class="h-px w-5 text-zinc-300 dark:text-zinc-600" viewBox="0 0 20 1" fill="none">
                                <line stroke="currentColor" y1="0.5" x2="20" y2="0.5"
                                    stroke-dasharray="4 4" />
                            </svg>
                        </div>
                        <button type="button" @click="resetFilters()" :inert="activeFilterCount === 0"
                            :aria-hidden="activeFilterCount === 0"
                            class="group inline-flex h-10 items-center justify-center gap-1.5 border border-zinc-200 bg-white px-3 text-sm font-medium
                           text-zinc-600 shadow-sm transition-all duration-300 ease-out
                           hover:border-red-300 hover:bg-red-50 hover:text-red-600
                           dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:border-red-800 dark:hover:bg-red-900/20 dark:hover:text-red-400
                           active:scale-[0.97]"
                            :style="`opacity: ${activeFilterCount > 0 ? '1' : '0'}; visibility: ${activeFilterCount > 0 ? 'visible' : 'hidden'}; pointer-events: ${activeFilterCount > 0 ? 'auto' : 'none'}; transition-delay: ${activeFilterCount > 0 ? '0ms' : '400ms'}`">
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

            {{-- Champ de recherche (un seul bouton clear) --}}
            <div class="grow">
                <div
                    class="group relative flex h-10 items-center border border-zinc-200 bg-white transition-all duration-300 focus-within:border-emerald-500 focus-within:ring-2 focus-within:ring-emerald-500/20 dark:border-zinc-700 dark:bg-zinc-800">
                    {{-- Icône de recherche --}}
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-zinc-400 transition-colors duration-300 group-focus-within:text-emerald-500 dark:text-zinc-500 dark:group-focus-within:text-emerald-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    {{-- Champ de saisie --}}
                    <input autocomplete="off"
                        class="h-full w-full border-0 bg-transparent pl-10 pr-12 text-sm font-medium text-zinc-900 placeholder:text-zinc-400 focus:outline-none focus:ring-0 dark:text-zinc-100 dark:placeholder:text-zinc-500"
                        x-model.debounce.250ms="search" x-ref="searchInput" placeholder="Rechercher un article...">

                    {{-- Bouton d'effacement --}}
                    <button x-cloak x-show="search.length > 0" @click="search = ''; $refs.searchInput.focus()"
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

        {{-- Panneau de filtre (catégories) --}}
        <div x-cloak id="filters-panel" x-show="showFilters" x-collapse style="display: none">
            <div class="mt-5 flex flex-col gap-4">
                <fieldset>
                    <legend class="mb-2 text-sm font-medium text-zinc-700 dark:text-zinc-300">
                        Catégorie :
                    </legend>
                    <div class="flex flex-wrap gap-2">
                        {{-- Bouton "Toutes" --}}
                        <label for="cat-all"
                            class="cursor-pointer select-none px-4 py-2 text-sm font-medium
                           transition-all duration-300 ease-out
                           transform hover:scale-101 active:scale-95
                           bg-zinc-50 text-zinc-600 hover:bg-zinc-100 hover:text-zinc-800
                           dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-zinc-200
                           "
                            :class="{
                                'bg-emerald-500! text-white! hover:bg-emerald-500! dark:bg-emerald-500! dark:hover:bg-emerald-400! shadow-emerald-500/20':
                                    !category
                            }">
                            Toutes
                        </label>
                        <input type="radio" id="cat-all" name="category-filter" value=""
                            class="sr-only peer" x-model="category" />

                        @foreach ($categories as $cat)
                            <label for="cat-{{ $cat->slug }}"
                                class="cursor-pointer select-none px-4 py-2 text-sm font-medium
                               transition-all duration-300 ease-out
                               transform hover:scale-105 active:scale-95
                               bg-zinc-100 text-zinc-600 hover:bg-zinc-200 hover:text-zinc-800
                               dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700 dark:hover:text-zinc-200
                               shadow-sm hover:shadow-md"
                                :class="{ 'bg-emerald-500! text-white! hover:bg-emerald-600! dark:bg-emerald-500! dark:hover:bg-emerald-400! shadow-emerald-500/20': category === '{{ $cat->slug }}' }">
                                {{ $cat->nom }}
                            </label>
                            <input type="radio" id="cat-{{ $cat->slug }}" name="category-filter"
                                value="{{ $cat->slug }}" class="sr-only peer" x-model="category" />
                        @endforeach
                    </div>
                </fieldset>
            </div>
        </div>

        {{-- Zone de tri --}}
        <div class="custom-top-dashed-border mt-5 flex flex-wrap items-center justify-between gap-4 pt-5">
            <div class="flex flex-wrap items-center gap-4">
                {{-- Tri --}}
                <div x-cloak class="relative flex items-center gap-1.5 text-xs" x-data="cspState()"
                    @click.outside="open = false" @keydown.escape.window="open = false">
                    <span class="text-zinc-500 dark:text-zinc-400">Trier par</span>
                    <button type="button" @click="open = !open" :aria-expanded="open"
                        class="group inline-flex cursor-pointer h-8 items-center gap-1.5 bg-zinc-100 px-3 text-sm font-medium text-zinc-700 transition-all duration-300 ease-out hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50">
                        <span
                            x-text="{
                    'newest': 'Plus récents',
                    'oldest': 'Plus anciens',
                    'popular': 'Plus vus',
                    'name-asc': 'Titre AZ',
                    'name-desc': 'Titre ZA'
                }[sortBy] || 'Plus récents'"></span>
                        <svg class="size-3.5 transition-transform duration-300 ease-out" :class="open && 'rotate-180'"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-1 scale-95"
                        class="absolute top-full left-0 z-20 mt-1 w-40 overflow-hidden border border-zinc-200/60 bg-white shadow-md shadow-zinc-200/20 backdrop-blur-sm dark:border-zinc-700/60 dark:bg-zinc-900 dark:shadow-zinc-950/50"
                        role="listbox">
                        <div class="py-1">
                            @foreach (['newest' => 'Plus récents', 'oldest' => 'Plus anciens', 'popular' => 'Plus vus', 'name-asc' => 'Titre A→Z', 'name-desc' => 'Titre Z→A'] as $value => $label)
                                <button type="button" role="option"
                                    :aria-selected="sortBy === '{{ $value }}'"
                                    @click="sortBy = '{{ $value }}'; open = false"
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

                {{-- Compteur --}}
                <div class="flex items-center gap-1.5 text-xs">
                    <span class="text-zinc-500 dark:text-zinc-400">Articles trouvés :</span>
                    <span
                        class="inline-grid h-7 min-w-8 place-items-center rounded-full bg-emerald-100 px-2 text-xs font-bold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                        {{ $posts->total() }}
                    </span>
                </div>
            </div>
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
                            <div x-data="rotatingBadge()" class="absolute top-1/2 -left-4 -translate-y-1/2">
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

                        {{-- Auteur + vues --}}
                        <div class="mt-2 flex items-center justify-between gap-3">
                            <div class="flex min-w-0 items-center gap-2">
                                <flux:avatar size="md" circle src="{{ $post->user?->avatar_url }}"
                                    alt="{{ $post->user?->name }}" />
                                <span class="max-w-40 truncate text-sm text-zinc-600 dark:text-zinc-400">
                                    <strong>{{ $post->user?->name ?? 'CADERSA' }}</strong>
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
                    <div x-data="cspState()" x-intersect="shown = true"
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

        <!--Pagination-->
        <div class="mt-5 flex flex-wrap items-center justify-between gap-4">
            <nav class="flex items-center gap-1">
                {{ $posts->links('pagination::custom') }}
            </nav>
        </div>

    </section>
</div>

