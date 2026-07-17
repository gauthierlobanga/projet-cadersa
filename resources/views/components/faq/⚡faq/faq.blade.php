<section class="border-t border-slate-200 bg-slate-50 px-4 py-16 lg:py-20 dark:border-slate-800 dark:bg-slate-900/50">
    <div class="mx-auto max-w-6xl">

        {{-- Header --}}
        <div class="mb-10 text-center"
             x-data="cspState"
             x-intersect="visible = true"
             :class="{ 'opacity-100 translate-y-0': visible, 'opacity-0 translate-y-4': !visible }"
             class="transition-all duration-700">
            <flux:badge
                class="mb-4 border-emerald-200 bg-emerald-50 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300">
                FAQ
            </flux:badge>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Questions fréquentes</h2>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Tout ce que vous devez savoir avant de nous contacter.</p>
        </div>

        {{-- Accordéon --}}
        <div class="space-y-3">
            @forelse ($this->faqs as $faq)
                <div x-data="cspState"
                     x-intersect="$el.classList.add('opacity-100', 'translate-y-0')"
                     class="opacity-0 translate-y-4 transition-all duration-500 rounded border border-slate-100 bg-white dark:border-slate-800 dark:bg-slate-900 overflow-hidden">

                    {{-- Bouton --}}
                    <button @click="open = !open"
                            class="flex w-full items-center cursor-pointer justify-between gap-4 px-6 py-5 text-left font-medium text-slate-900 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors duration-200"
                            :aria-expanded="open"
                            aria-controls="faq-{{ $faq->id }}">
                        <span class="text-base sm:text-lg">{{ $faq->question }}</span>
                        <svg class="h-5 w-5 shrink-0 text-slate-400 dark:text-slate-500 transition-transform duration-300 ease-out"
                             :class="{ 'rotate-180': open }"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19 9-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Contenu --}}
                    <div id="faq-{{ $faq->id }}"
                         x-show="open"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-2"
                         class="border-t border-slate-100 dark:border-slate-700 px-6 py-5"
                         x-cloak>
                        <div class="prose prose-sm prose-slate dark:prose-invert max-w-none text-slate-600 dark:text-slate-400">
                            {!! $faq->formatted_answer !!}
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-500 dark:text-slate-400">
                    Aucune question disponible pour le moment.
                </div>
            @endforelse
        </div>

    </div>
</section>
