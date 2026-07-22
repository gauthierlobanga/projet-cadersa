@if ($paginator->hasPages())
    <div class="mt-8 flex flex-col-reverse items-center justify-between gap-4 sm:flex-row">

        <nav class="flex items-center gap-1.5" aria-label="Pagination" role="navigation">

            {{-- Précédent --}}
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex h-9 w-9 shrink-0 cursor-not-allowed items-center justify-center bg-slate-100/50 text-slate-300 dark:bg-slate-800/40 dark:text-slate-600"
                    aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </span>
            @else
                <button type="button" wire:click.preserve-scroll="setPage('{{ $paginator->currentPage() - 1 }}')" rel="prev"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center bg-slate-100 text-slate-500 transition-all duration-300 hover:scale-105 hover:bg-slate-200 hover:text-slate-900 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 active:scale-95 dark:bg-slate-800/50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-100"
                    aria-label="@lang('pagination.previous')">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m15 18-6-6 6-6" />
                    </svg>
                </button>
            @endif

            {{-- Pages numériques --}}
            <div class="flex items-center gap-1.5">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span
                            class="inline-flex h-9 min-w-9 items-center justify-center bg-transparent px-3 text-sm font-medium text-slate-400 dark:text-slate-500">…</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                {{-- Lien actif --}}
                                <span
                                    class="inline-flex h-9 min-w-9 items-center justify-center bg-emerald-50 px-3 text-sm font-bold text-emerald-700 transition-transform duration-300 hover:scale-105 dark:bg-emerald-900/30 dark:text-emerald-300"
                                    aria-current="page">{{ $page }}</span>
                            @else
                                <button type="button" wire:click.preserve-scroll="setPage('{{ $page }}')"
                                    class="inline-flex h-9 min-w-9 items-center justify-center bg-slate-100 px-3 text-sm font-medium text-slate-500 transition-all duration-300 hover:scale-105 hover:bg-slate-200 hover:text-slate-900 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 active:scale-95 dark:bg-slate-800/50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-100"
                                    aria-label="@lang('Go to page :page', ['page' => $page])">{{ $page }}</button>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Suivant --}}
            @if ($paginator->hasMorePages())
                <button type="button" wire:click.preserve-scroll="setPage('{{ $paginator->currentPage() + 1 }}')" rel="next"
                    class="inline-flex h-9 w-9 shrink-0 items-center justify-center bg-slate-100 text-slate-500 transition-all duration-300 hover:scale-105 hover:bg-slate-200 hover:text-slate-900 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 active:scale-95 dark:bg-slate-800/50 dark:text-slate-400 dark:hover:bg-slate-700 dark:hover:text-slate-100"
                    aria-label="@lang('pagination.next')">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </button>
            @else
                <span
                    class="inline-flex h-9 w-9 shrink-0 cursor-not-allowed items-center justify-center bg-slate-100/50 text-slate-300 dark:bg-slate-800/40 dark:text-slate-600"
                    aria-disabled="true" aria-label="@lang('pagination.next')">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6" />
                    </svg>
                </span>
            @endif
        </nav>

    </div>
@endif

@script
<script>
    /**
     * Empêche le scrollTo automatique déclenché par WithPagination::setPage().
     * Le trait dispatche un effet "scroll" via Livewire après chaque changement de page.
     * On l'intercepte ici et on le supprime avant qu'il touche le DOM.
     */
    Livewire.hook('commit', ({ succeed }) => {
        succeed(({ effect }) => {
            if (Array.isArray(effect.dispatches)) {
                effect.dispatches = effect.dispatches.filter(
                    (dispatch) => dispatch.name !== 'scroll'
                )
            }
        })
    })
</script>
@endscript
