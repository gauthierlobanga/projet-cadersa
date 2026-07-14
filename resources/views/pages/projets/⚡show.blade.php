<?php

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::main')] class extends Component {
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
    }

    public function rendering(\Illuminate\View\View $view): void
    {
        $view->title($this->project->title);

        $imageUrl = $this->project->getFirstMediaUrl('featured') ?: asset('images/cadersa-logo.png');
        $description = $this->project->getPlainTextContent(160);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Project',
            'name' => $this->project->title,
            'description' => $description,
            'image' => [$imageUrl],
            'url' => route('projects.show', $this->project->slug),
            'foundingDate' => $this->project->start_date?->format('Y-m-d'),
        ];

        $view->layoutData([
            'seoDescription' => $description,
            'seoImage' => $imageUrl,
            'seoType' => 'article',
            'seoKeywords' => $this->project->tags->pluck('name')->toArray(),
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
        ]);
    }

    #[Computed]
    public function galleryImages()
    {
        return $this->project->getMedia('gallery')->map(
            fn($media) => [
                'url' => $media->getUrl(),
                'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
            ],
        );
    }

    // ===== MÉTHODE POUR LES PDF =====
    #[Computed]
    public function pdfs()
    {
        return $this->project->getMedia('documents')->map(
            fn($media) => [
                'url' => $media->getUrl(),
                'name' => $media->name ?? ($media->file_name ?? 'Document'),
                'size' => $media->size,
                'file_name' => $media->file_name,
            ],
        );
    }

    #[Computed]
    public function hasPdf()
    {
        return $this->project->getMedia('documents')->isNotEmpty();
    }
};
?>

<div class="relative min-h-screen bg-white dark:bg-zinc-950">
    {{-- Decorative Backgrounds --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 right-0 h-120 w-120 rounded-full bg-emerald-500/10 blur-[120px] transform-gpu">
        </div>
        <div class="absolute -left-40 top-40 h-100 w-100 rounded-full bg-teal-500/10 blur-[120px] transform-gpu"></div>
    </div>

    {{-- Hero Section Projet --}}
    <section x-cloak class="relative flex min-h-[70vh] items-center overflow-hidden" x-data="{
        init() {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: $el,
                    start: 'top 80%',
                    once: true,
                },
            });
    
            tl.from($refs.bg, { scale: 1.1, duration: 2.5, ease: 'power3.out' }, 0);
    
            const title = new SplitText($refs.title, { type: 'words,chars' });
            const subtitle = new SplitText($refs.subtitle, { type: 'words' });
    
            tl.from($refs.badges, { opacity: 0, y: 20, duration: 0.4, ease: 'power2.out' }, 0)
                .from(title.chars, { opacity: 0, y: 60, rotateX: -15, stagger: 0.025, duration: 0.9, ease: 'back.out(1.6)' }, '-=0.4')
                .from(subtitle.words, { opacity: 0, y: 20, stagger: 0.04, duration: 0.6, ease: 'power3.out' }, '-=0.5')
                .from($refs.meta, { opacity: 0, y: 30, duration: 0.6, ease: 'power3.out' }, '-=0.3');
        }
    }">

        {{-- Background Image --}}
        <div x-ref="bg" class="absolute inset-0">
            @if ($project->hasMedia('cover'))
                <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="{{ $project->title }}"
                    class="h-full w-full object-cover origin-center" loading="eager">
            @else
                <div class="h-full w-full bg-linear-to-br from-zinc-800 to-zinc-900"></div>
            @endif

            {{-- Overlays identiques à l'accueil --}}
            <div class="absolute inset-0 bg-linear-to-br from-zinc-950/90 via-zinc-900/70 to-emerald-950/70"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,.20),transparent_45%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,.08),transparent_35%)]">
            </div>
        </div>

        {{-- Contenu --}}
        <div class="relative z-10 mx-auto max-w-5xl px-6 pt-20 pb-16 text-center lg:px-8">
            {{-- Badges --}}
            <div x-ref="badges" class="mb-8 flex flex-wrap items-center justify-center gap-3">
                <span
                    class="inline-flex items-center gap-2 rounded-full border border-emerald-400/30 bg-emerald-500/20 px-4 py-1.5 text-sm font-medium text-emerald-200 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    {{ $project->status === 'completed' ? 'Terminé' : ($project->status === 'ongoing' ? 'En cours' : 'Planifié') }}
                </span>

                @if ($project->location)
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-4 py-1.5 text-sm font-medium text-zinc-200 backdrop-blur-sm">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        {{ $project->location }}
                    </span>
                @endif

                @if ($project->category)
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-4 py-1.5 text-sm font-medium text-zinc-200 backdrop-blur-sm">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $project->category }}
                    </span>
                @endif
            </div>

            {{-- Titre --}}
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-7xl leading-[1.1]">
                {{ $project->title }}
            </h1>

            {{-- Sous-titre --}}
            @if ($project->excerpt)
                <p x-ref="subtitle"
                    class="mx-auto max-w-2xl  font-light mt-6 text-lg leading-relaxed text-zinc-300 sm:text-lg lg:text-xl">
                    {!! $project->renderRichContent('excerpt') !!}
                </p>
            @endif

            {{-- Meta --}}
            <div x-ref="meta"
                class="mt-10 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-sm font-medium text-zinc-400">
                @if ($project->start_date)
                    <div
                        class="flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-2 backdrop-blur-sm">
                        <svg class="h-4.5 w-4.5 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-zinc-300">Début : <span
                                class="font-semibold text-white">{{ $project->start_date->translatedFormat('F Y') }}</span></span>
                    </div>
                @endif
                @if ($project->end_date)
                    <div
                        class="flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-2 backdrop-blur-sm">
                        <svg class="h-4.5 w-4.5 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-zinc-300">Fin : <span
                                class="font-semibold text-white">{{ $project->end_date->translatedFormat('F Y') }}</span></span>
                    </div>
                @endif
                @if ($project->budget)
                    <div
                        class="flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-2 backdrop-blur-sm">
                        <svg class="h-4.5 w-4.5 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v1m0 11c-4.418 0-8-3.582-8-8s3.582-8 8-8 8 3.582 8 8-3.582 8-8 8z" />
                        </svg>
                        <span class="text-zinc-300">Budget : <span
                                class="font-semibold text-white">{{ number_format($project->budget) }} USD</span></span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    {{-- Contenu & Galerie --}}
    <section class="relative py-20 lg:py-32">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            {{-- Contenu Prose --}}
            <div x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="fi-prose max-w-none transition-all duration-1000 ease-out
                        bg-white/50 dark:bg-zinc-900/50 backdrop-blur-xl p-8 md:p-12 w-full">
                {!! $project->renderRichContent('content') !!}
            </div>

            {{-- Galerie --}}
            @if ($this->galleryImages->isNotEmpty())
                <div x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    class="mt-16 transition-all duration-700 ease-out">

                    <div
                        class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                        <h3 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Galerie</h3>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $this->galleryImages->count() }}
                            {{ $this->galleryImages->count() > 1 ? 'médias' : 'média' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-5" x-data="{ lightbox: false, activeImage: '' }">
                        @foreach ($this->galleryImages as $index => $image)
                            <div @click="lightbox = true; activeImage = '{{ $image['url'] }}'"
                                class="group relative aspect-square cursor-zoom-in overflow-hidden border border-zinc-200/50 bg-zinc-100 transition-all duration-300 hover:border-emerald-300 dark:border-zinc-700/50 dark:bg-zinc-800 dark:hover:border-emerald-700">
                                <img src="{{ $image['thumb'] }}" alt="Galerie"
                                    class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                    loading="lazy">
                                <div
                                    class="absolute inset-0 bg-linear-to-t from-zinc-900/40 via-zinc-900/0 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                </div>
                                <div
                                    class="absolute bottom-3 left-3 opacity-0 transition-all duration-300 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0">
                                    <span class="flex h-8 w-8 items-center justify-center bg-white/20 text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        @endforeach

                        {{-- Lightbox --}}
                        <template x-teleport="body">
                            <div x-show="lightbox" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="fixed inset-0 z-100 flex items-center justify-center bg-zinc-950/90 p-4 sm:p-6"
                                @keydown.escape.window="lightbox = false" x-cloak>

                                <div class="absolute inset-0" @click="lightbox = false"></div>

                                <button @click="lightbox = false"
                                    class="absolute right-6 top-6 z-10 flex h-12 w-12 items-center justify-center bg-white/10 text-white transition hover:bg-white/20 hover:scale-105">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                <div class="relative z-0 mx-auto max-h-full max-w-7xl" x-show="lightbox"
                                    x-transition:enter="transition ease-out duration-400 delay-100"
                                    x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                                    <img :src="activeImage" class="max-h-[85vh] w-auto object-contain"
                                        @click.stop="">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- ==================== DOCUMENTS PDF ==================== --}}
    @if ($project->hasPdf())
        <div x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="mt-24 transition-all duration-1000 delay-300 ease-out">

            <div class="mb-8 flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                <h3 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    <span class="inline-flex items-center gap-3">
                        <svg class="h-7 w-7 text-emerald-600 dark:text-emerald-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Documents du projet
                    </span>
                </h3>
                <span
                    class="rounded-full bg-zinc-100 px-3 py-1 text-sm font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                    {{ $project->getMedia('documents')->count() }} PDF
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($project->getMedia('documents') as $pdf)
                    <x-pdf-viewer :pdfUrl="$pdf->getUrl()"
                        label="{{ $pdf->name ?? ($pdf->file_name ?? 'Lire le document') }}"
                        modalTitle="{{ $pdf->name ?? ($pdf->file_name ?? 'Document PDF') }}"
                        buttonClass="group flex items-center gap-3 rounded-xl border border-zinc-200/60 bg-white/50 p-4 transition-all duration-300 hover:-translate-y-1 hover:border-emerald-300 hover:bg-emerald-50/50 hover:shadow-lg hover:shadow-emerald-500/10 dark:border-zinc-800/60 dark:bg-zinc-900/50 dark:hover:border-emerald-700 dark:hover:bg-emerald-900/20">
                        <template x-slot:icon>
                            <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </template>
                        <span
                            class="flex-1 text-sm font-medium text-zinc-900 dark:text-white truncate">{{ $pdf->name ?? ($pdf->file_name ?? 'Document') }}</span>
                        <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ round($pdf->size / 1024) }}
                            KB</span>
                    </x-pdf-viewer>
                @endforeach
            </div>
        </div>
    @endif
</div>
