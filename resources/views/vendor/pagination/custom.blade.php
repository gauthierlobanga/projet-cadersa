@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="flex items-center justify-between">
        {{-- Informations --}}
        <div class="hidden sm:block text-sm text-zinc-500 dark:text-zinc-400">
            Affichage de <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $paginator->firstItem() }}</span> à <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $paginator->lastItem() }}</span> sur <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $paginator->total() }}</span> résultats
        </div>

        {{-- Boutons --}}
        <div class="flex items-center gap-1">
            {{-- Précédent --}}
            @if ($paginator->onFirstPage())
                <span class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center text-zinc-300 dark:text-zinc-600" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" wire:click.prevent="setPage('{{ $paginator->currentPage() - 1 }}')" rel="prev" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-zinc-100 text-zinc-600 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-600 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400" aria-label="@lang('pagination.previous')">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
            @endif

            {{-- Pages numériques --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="inline-flex h-9 w-9 items-center justify-center text-sm text-zinc-400 dark:text-zinc-500">…</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex h-9 w-9 items-center justify-center bg-emerald-500 text-sm font-semibold text-white shadow dark:bg-emerald-400 dark:text-zinc-900" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" wire:click.prevent="setPage('{{ $page }}')" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-sm text-zinc-600 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-600 dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400" aria-label="@lang('Go to page :page', ['page' => $page])">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Suivant --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" wire:click.prevent="setPage('{{ $paginator->currentPage() + 1 }}')" rel="next" class="inline-flex h-9 w-9 items-center justify-center bg-zinc-100 text-zinc-600 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-600 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400" aria-label="@lang('pagination.next')">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center text-zinc-300 dark:text-zinc-600" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </div>
    </nav>
@endif