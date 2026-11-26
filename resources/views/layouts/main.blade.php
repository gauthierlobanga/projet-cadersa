<x-layouts::app.header
    :title="$title ?? null"
    :seoDescription="$seoDescription ?? null"
    :seoImage="$seoImage ?? null"
    :seoUrl="$seoUrl ?? null"
    :seoType="$seoType ?? 'website'"
    :seoKeywords="$seoKeywords ?? null"
    :seoRobots="$seoRobots ?? null"
>
    <flux:main>
        {{ $slot }}
    </flux:main>
</x-layouts::app.header>
