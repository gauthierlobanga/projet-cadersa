@php
    $block = $data['data'] ?? $data;
@endphp

<div class="rounded-3xl border border-zinc-200/10 bg-white/5 p-4 shadow-sm">
    @if (! empty($block['image_url']))
        <div class="overflow-hidden rounded-3xl mb-4">
            <img src="{{ Storage::url($block['image_url']) }}" alt="{{ $block['label'] ?? 'Carte d\'impact' }}" class="h-36 w-full object-cover" />
        </div>
    @endif

    <div class="space-y-3">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-sm font-semibold uppercase tracking-[0.28em] text-emerald-500">
                    {{ $block['label'] ?? 'Nouvelle carte' }}
                </div>
                <div class="text-2xl font-bold text-zinc-900">
                    {{ $block['value'] ?? '—' }}
                </div>
            </div>
            @if (empty($block['image_url']))
                <div class="inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="{{ $block['icon'] ?? 'M12 14l9-5-9-5-9 5 9 5z' }}" />
                    </svg>
                </div>
            @endif
        </div>

        @if (! empty($block['description']))
            <p class="text-sm leading-6 text-zinc-600">{{ $block['description'] }}</p>
        @endif
    </div>
</div>
