<div
    x-data="scrollToTop()"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8 scale-90"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-8 scale-90"
    class="fixed bottom-6 right-6 z-50 sm:bottom-8 sm:right-8"
    style="display: none;"
>
    <button x-on:click="scrollToTop()" data-button-pulse type="button" aria-label="Remonter en haut de la page"
        class="inline-flex h-12 items-center gap-2 rounded-full bg-emerald-50 dark:bg-zinc-800 pr-5 pl-1.5 font-medium text-sm text-zinc-900 dark:text-zinc-100 shadow-xl shadow-emerald-500/10 transition-all duration-300 ease-out will-change-transform hover:scale-105 hover:bg-emerald-100 dark:hover:bg-emerald-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50">
        <div class="relative isolate grid size-9 place-items-center overflow-hidden rounded-full bg-emerald-800 dark:bg-emerald-700 text-white">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
        </div>
        <div class="overflow-hidden whitespace-nowrap text-sm" data-text>
            Retour en haut
        </div>
    </button>
</div>
