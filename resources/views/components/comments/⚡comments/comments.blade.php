<div class="space-y-6">
    {{-- Formulaire principal --}}
    <form wire:submit.prevent="addComment" class="mb-6">
        <div
            class="rounded-lg rounded-t-lg border border-zinc-200 bg-white px-4 py-2 dark:border-zinc-700 dark:bg-zinc-800">
            <label for="comment" class="sr-only">Votre commentaire</label>
            <flux:textarea id="comment" wire:model="newComment" rows="3"
                class="w-full border-0 bg-transparent px-0 text-sm text-zinc-900 focus:outline-none focus:ring-0 dark:text-white dark:placeholder:text-zinc-400 dark:bg-zinc-800"
                placeholder="Écrivez un commentaire..." required>
            </flux:textarea>
        </div>
        <button type="submit"
            class="mt-2 inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-xs font-medium text-white transition hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-200 dark:bg-emerald-500 dark:hover:bg-emerald-600 dark:focus:ring-emerald-900">
            Publier
        </button>
    </form>

    {{-- Liste des commentaires --}}
    @if ($comments->isEmpty())
        <p class="text-center text-sm text-zinc-500 dark:text-zinc-400">Aucun commentaire pour le moment.</p>
    @else
        @foreach ($comments as $comment)
            <livewire:comments.comment-item :comment="$comment" :commentableType="$commentableType" :commentableId="$commentableId" :key="$comment->id" />
        @endforeach
    @endif
</div>
