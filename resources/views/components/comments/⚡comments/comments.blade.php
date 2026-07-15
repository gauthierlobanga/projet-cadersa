<div class="space-y-6">
    {{-- Formulaire principal --}}
    <form wire:submit.prevent="addComment" class="mb-6">
        <div>
            <label for="comment" class="sr-only">Votre commentaire</label>
            <flux:textarea id="comment" wire:model.live="newComment" rows="3"
                class="w-full border border-accent bg-transparent rounded-none px-4 text-sm text-zinc-900 focus:outline-none focus:ring-0 dark:text-white dark:placeholder:text-zinc-400 dark:bg-zinc-800"
                placeholder="Écrivez un commentaire...">
            </flux:textarea>
            @error('newComment')
                <p class="mt-2 text-xs text-rose-600">{{ $message }}</p>
            @enderror
        </div>
        <flux:button variant="outline" type="submit"
            class="mt-2 inline-flex items-center bg-emerald-600 px-4 py-2 text-xs rounded-none text-white transition hover:bg-emerald-700">
            Publier
        </flux:button>
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
