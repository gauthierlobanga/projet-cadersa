<x-layouts::main title="Gestion des Cookies">
    <div class="relative min-h-[50vh] overflow-hidden bg-zinc-50 py-24 dark:bg-zinc-900">
        {{-- Décoration d'arrière-plan --}}
        <div class="pointer-events-none absolute inset-0 z-0 flex justify-center">
            <div
                class="absolute -top-[20%] left-1/2 aspect-square w-[800px] -translate-x-1/2 rounded-full bg-linear-to-br from-emerald-100/40 to-teal-50/10 blur-[100px] dark:from-emerald-500/10 dark:to-transparent">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-6 lg:px-8">
            <div class="text-center">
                <flux:badge color="emerald" class="mb-4">Confidentialité</flux:badge>
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 sm:text-5xl dark:text-white">
                    Gestion des Cookies
                </h1>
            </div>
        </div>
    </div>

    <div class="relative z-20 mx-auto -mt-12 max-w-4xl px-6 pb-24 lg:px-8">
        <div class="overflow-hidden rounded-3xl border border-zinc-200/60 bg-white/80 p-8 shadow-xl shadow-zinc-200/20 backdrop-blur-xl sm:p-12 dark:border-zinc-800/60 dark:bg-zinc-900/80">
            <div class="prose prose-lg prose-emerald max-w-none dark:prose-invert">
                <p>Informations sur notre politique de gestion des cookies à venir.</p>
            </div>
        </div>
    </div>
</x-layouts::main>
