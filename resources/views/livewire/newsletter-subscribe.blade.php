<div class="border border-zinc-200 bg-zinc-50/50 p-6 dark:border-zinc-800/50 dark:bg-zinc-900/30">
    <h3 class="mb-2 text-base font-semibold text-zinc-900 dark:text-white">Restez informé</h3>
    <p class="mb-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
        Recevez nos actualités directement dans votre boîte mail.
    </p>

    @if ($subscribed)
        <div class="rounded-3xl border border-emerald-200/70 bg-emerald-50/80 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-500/30 dark:bg-emerald-500/10 dark:text-emerald-200">
            ✅ Merci ! Vérifiez votre boîte mail pour confirmer votre abonnement.
        </div>
    @else
        <form wire:submit.prevent="submit" class="space-y-3">
            <div class="relative">
                <label for="newsletter-email" class="sr-only">Votre adresse e-mail</label>
                <input type="email" id="newsletter-email" wire:model.live="email"
                    placeholder="Entrez votre e-mail..."
                    class="w-full border border-zinc-300 bg-white px-4 py-2.5 text-sm text-zinc-900 placeholder:text-zinc-400 outline-none transition-colors duration-200 focus:border-emerald-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-400">
            </div>
            @error('email')
                <p class="text-sm text-rose-600">{{ $message }}</p>
            @enderror

            <button type="submit"
                class="flex w-full items-center justify-center gap-2 border border-emerald-600 bg-emerald-600 px-4 py-2.5 text-sm font-medium text-white transition-colors duration-200 hover:bg-emerald-700 dark:border-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                S'abonner
            </button>
        </form>
    @endif
</div>
