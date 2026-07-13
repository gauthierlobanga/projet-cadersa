<article
    class="rounded-lg bg-white p-6 text-base dark:bg-zinc-900 @if ($comment->parent_id) ml-6 border-l-2 border-emerald-200 pl-4 lg:ml-12 dark:border-emerald-800 @endif">
    <footer class="mb-2 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 sm:gap-4">
                <flux:avatar circle alt="{{ $comment->user?->name ?? 'Anonyme' }}"
                    src="{{ $comment->user?->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user?->name ?? 'Anonyme') . '&background=random' }}" />

                <div class="flex flex-col">
                    <div class="flex items-center gap-1.5">
                        <span class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $comment->user?->name ?? 'Anonyme' }}
                        </span>
                        @if ($isAuthor)
                            <flux:badge size="sm" color="blue">You</flux:badge>
                        @endif
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        <time pubdate datetime="{{ $comment->created_at?->toIso8601String() }}"
                            title="{{ $comment->created_at?->format('d M Y, H:i') }}">
                            {{ $comment->time_ago }}
                        </time>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <p class="text-zinc-500 dark:text-zinc-400">{{ $comment->content_html }}</p>

    <div class="mt-4 flex items-center space-x-4">
        <button wire:click="like"
            class="flex items-center text-sm font-medium text-zinc-500 hover:underline dark:text-zinc-400">
            <svg class="mr-1.5 h-3.5 w-3.5" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 20 18">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
            @if ($comment->likes_count > 0)
                <span class="ml-1">{{ $comment->likes_count }}</span>
            @endif
        </button>
        <button @click="$wire.showReplyForm = !$wire.showReplyForm"
            class="flex items-center text-sm font-medium text-zinc-500 hover:underline dark:text-zinc-400">
            <svg class="mr-1.5 h-3.5 w-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 18">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z" />
            </svg>
            Répondre
        </button>
    </div>

    {{-- Formulaire de réponse --}}
    <div x-show="$wire.showReplyForm" x-transition.opacity.duration.200ms class="mt-4">
        <div class="flex items-start space-x-3">
            <flux:avatar circle
                src="{{ auth()->user()?->avatar_url ?? 'https://ui-avatars.com/api/?name=Anonyme&background=random' }}" />
            <div class="min-w-0 flex-1">
                <textarea wire:model="replyContent"
                    class="w-full rounded-lg border border-zinc-200 bg-white p-2 text-sm focus:border-emerald-400 focus:ring-4 focus:ring-emerald-500/10 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:focus:border-emerald-500 dark:focus:ring-emerald-500/20"
                    rows="2" placeholder="Écrivez une réponse..."></textarea>
                <button wire:click="addReply" wire:loading.attr="disabled"
                    class="mt-2 inline-flex items-center rounded-lg bg-emerald-600 px-4 py-1.5 text-xs font-medium text-white transition hover:bg-emerald-700 disabled:opacity-50 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                    Répondre
                </button>
            </div>
        </div>
    </div>

    {{-- Réponses --}}
    @if ($comment->replies->isNotEmpty())
        <div class="mt-4 space-y-4">
            @foreach ($comment->replies as $reply)
                <livewire:comments.comment-item :comment="$reply" :commentableType="$commentableType" :commentableId="$commentableId"
                    :key="$reply->id" />
            @endforeach
        </div>
    @endif
</article>
