<x-layouts::app.sidebar :title="$title ?? null">
    <flux:main inset>
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
