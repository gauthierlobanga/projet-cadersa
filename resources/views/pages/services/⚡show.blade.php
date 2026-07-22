{{-- resources/views/pages/services/show.blade.php --}}
<?php

use Livewire\Component;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::main')] class extends Component {
    public Service $service;

    public function mount(Service $service)
    {
        $this->service = $service;
    }

    public function rendering(\Illuminate\View\View $view): void
    {
        $view->title($this->service->title);

        $imageUrl = $this->service->getFirstMediaUrl('featured') ?: asset('images/logo-app.svg');
        $description = $this->service->getPlainTextContent(160);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $this->service->title,
            'description' => $description,
            'image' => $imageUrl,
            'url' => route('services.show', $this->service->slug),
            'provider' => [
                '@type' => 'Person',
                'name' => 'Gauthier Lobanga',
                'url' => url('/'),
            ],
        ];

        $view->layoutData([
            'seoDescription' => $description,
            'seoImage' => $imageUrl,
            'seoType' => 'article',
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
        ]);
    }

    #[Computed]
    public function relatedServices()
    {
        return Service::active()->with('media')->where('id', '!=', $this->service->id)->ordered()->limit(3)->get();
    }

    #[Computed]
    public function galleryImages()
    {
        return $this->service->getMedia('gallery')->map(
            fn($media) => [
                'url' => $media->getUrl(),
                'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
            ],
        );
    }

    #[Computed]
    public function pdfs()
    {
        return $this->service->getMedia('documents')->map(
            fn($media) => [
                'url' => $media->getUrl(),
                'name' => $media->name ?? ($media->file_name ?? 'Brochure'),
                'size' => $media->size,
                'file_name' => $media->file_name,
            ],
        );
    }

    #[Computed]
    public function hasPdf()
    {
        return $this->service->getMedia('documents')->isNotEmpty();
    }
};
?>

<div class="relative min-h-screen bg-white dark:bg-zinc-950">
    {{-- Decorative Backgrounds --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 left-0 h-120 w-120 rounded-full bg-emerald-500/10 blur-[120px] transform-gpu"></div>
        <div class="absolute top-80 right-0 h-100 w-100 rounded-full bg-teal-500/10 blur-[120px] transform-gpu"></div>
    </div>

    {{-- Hero Section Service --}}
    <section x-cloak class="relative flex min-h-[60vh] items-center overflow-hidden" x-data="serviceHeroReveal()">
        <div x-ref="bg" class="absolute inset-0">
            @if ($service->hasMedia('image'))
                <img loading="eager" fetchpriority="high" src="{{ $service->getFirstMediaUrl('image') }}"
                    alt="{{ $service->title }}" class="h-full w-full object-cover origin-center">
            @else
                <div class="h-full w-full bg-linear-to-br from-zinc-800 to-zinc-900"></div>
            @endif
            <div class="absolute inset-0 bg-linear-to-br from-zinc-950/90 via-zinc-900/70 to-emerald-950/70"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,.20),transparent_45%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,.08),transparent_35%)]">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-4xl px-6 pt-20 pb-16 text-center lg:px-8">
            <h1
                class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-extrabold tracking-tight text-white leading-tighter">
                {{ $service->title }}
            </h1>
            @if ($service->excerpt)
                <div x-ref="excerpt" class="mt-8 mx-auto max-w-2xl">
                    <div
                        class="prose mt-6 text-lg leading-relaxed text-zinc-300 prose-lg prose-invert prose-headings:font-light prose-p:leading-relaxed prose-p:text-zinc-300 prose-strong:text-white prose-a:text-emerald-400 hover:prose-a:text-emerald-300 text-left mx-auto">
                        {!! $service->renderRichContent('excerpt') !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Contenu & Galerie --}}
    <section class="relative py-20 lg:py-32">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <div x-cloak x-data="cspState()" x-intersect.once="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="fi-prose max-w-none transition-all duration-500 ease-out
                    bg-white/50 dark:bg-zinc-900/50 backdrop-blur-xl p-8 md:p-12 w-full">
                {!! $service->renderRichContent('content') !!}
            </div>

            @if ($this->galleryImages->isNotEmpty())
                <div x-cloak x-data="cspState()" x-intersect.once="shown = true"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    class="mt-24 transition-all duration-500 delay-200 ease-out">
                    <div
                        class="mb-10 flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                        <h3 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Galerie</h3>
                    </div>
                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6" x-data="cspState()">
                        @foreach ($this->galleryImages as $index => $image)
                            <div @click="lightbox = true; activeImage = '{{ $image['url'] }}'"
                                class="group relative aspect-square cursor-zoom-in overflow-hidden bg-zinc-100 dark:bg-zinc-800 shadow-sm transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/10">
                                <img loading="eager" decoding="async" src="{{ $image['thumb'] }}" alt="Galerie"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-linear-to-t from-zinc-900/60 via-zinc-900/0 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                </div>
                                <div
                                    class="absolute bottom-4 left-4 opacity-0 transition-all duration-300 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0">
                                    <span class="flex h-8 w-8 items-center justify-center bg-white/20 text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                                x-transition:enter-start="opacity-0 backdrop-blur-none"
                                x-transition:enter-end="opacity-100 backdrop-blur-xl"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 backdrop-blur-xl"
                                x-transition:leave-end="opacity-0 backdrop-blur-none"
                                class="fixed inset-0 z-100 flex items-center justify-center bg-zinc-950/90 p-4 sm:p-6"
                                @keydown.escape.window="lightbox = false" x-cloak>
                                <div class="absolute inset-0" @click="lightbox = false"></div>
                                <button @click="lightbox = false"
                                    class="absolute right-6 top-6 z-10 flex h-12 w-12 items-center justify-center bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20 hover:scale-110">
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
                                    <img :src="activeImage"
                                        class="max-h-[85vh] w-auto shadow-2xl shadow-black/50 object-contain ring-1 ring-white/10"
                                        @click.stop="">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @endif

            {{-- Documents PDF --}}
            @if ($this->hasPdf)
                <div x-cloak x-data="cspState()" x-intersect.once="shown = true"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    class="mt-24 transition-all duration-500 delay-300 ease-out">
                    <div
                        class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                        <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                            <span class="inline-flex items-center gap-2.5">
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Documents
                            </span>
                        </h3>
                        <span class="text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $this->pdfs->count() }} PDF
                        </span>
                    </div>
                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($this->pdfs as $pdf)
                            <x-pdf-viewer :pdfUrl="$pdf['url']" label="{{ $pdf['name'] }}" modalTitle="{{ $pdf['name'] }}"
                                buttonClass="group flex items-center gap-3 border border-zinc-200/50 bg-white/30 p-3 transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-50/30 dark:border-zinc-800/50 dark:bg-zinc-900/30 dark:hover:border-emerald-700/50 dark:hover:bg-emerald-900/10">
                                <template x-slot:icon>
                                    <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <span
                                    class="flex-1 text-sm font-medium text-zinc-800 dark:text-zinc-200 truncate">{{ $pdf['name'] }}</span>
                                <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ round($pdf['size'] / 1024) }}
                                    KB</span>
                            </x-pdf-viewer>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Services similaires --}}
    @if ($this->relatedServices->isNotEmpty())
        <div class="border-t border-zinc-200 bg-zinc-50/40 py-16 dark:border-zinc-800 dark:bg-zinc-950/50">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div x-cloak x-data="cspState()" x-intersect.once="shown = true"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    class="mb-12 flex flex-col items-center justify-between gap-6 sm:flex-row transition-all duration-300 ease-out">
                    <h2 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Découvrez aussi</h2>
                    <a href="{{ route('services.index') }}" wire:navigate
                        class="group inline-flex items-center gap-2 border border-zinc-200 bg-white px-4 py-2 text-sm font-medium text-zinc-700 transition-colors hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-emerald-700 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-300">
                        Tous les services
                        <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-7 md:grid-cols-3">
                    @foreach ($this->relatedServices as $index => $related)
                        <div x-cloak x-data="cspState()" x-intersect.once="shown = true"
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                            class="transition-all duration-300 ease-out"
                            style="transition-delay: {{ $index * 150 }}ms">
                            <a href="{{ route('services.show', $related) }}" wire:navigate
                                class="group relative flex h-full flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
                                   hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                                   dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20">
                                @if ($related->hasMedia('image'))
                                    <div
                                        class="relative overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                                        <img loading="eager" decoding="async"
                                            src="{{ $related->getFirstMediaUrl('image', 'card') }}"
                                            alt="{{ $related->title }}"
                                            class="aspect-video w-full object-cover transition duration-300 ease-out group-hover:scale-105">
                                    </div>
                                @endif
                                <div class="flex flex-1 flex-col gap-2 p-4">
                                    <div
                                        class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                                        <div x-data="rotatingBadge()"
                                            class="absolute top-1/2 -left-4 -translate-y-1/2">
                                            <div
                                                class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                                <div data-rotating class="flex items-center gap-0.75">
                                                    <div class="flex flex-col gap-1">
                                                        <div data-box class="size-0.75 bg-current"></div>
                                                        <div data-box class="size-0.75 bg-current"></div>
                                                    </div>
                                                    <div data-box class="size-0.75 bg-current"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <h3
                                            class="line-clamp-1 font-medium text-zinc-900 transition-colors duration-300
                                               group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                            {{ $related->title }}
                                        </h3>
                                    </div>
                                    <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $related->short_excerpt ?? $related->getPlainTextContent(120) }}
                                    </p>
                                </div>
                                <div class="flex h-11 items-stretch text-sm font-medium">
                                    <div
                                        class="inline-flex grow items-center justify-between gap-3 px-4
                                            bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out
                                            group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                                        <span>Découvrir</span>
                                        <span class="transition duration-300 ease-out group-hover:translate-x-1">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3"
                                                viewBox="0 0 28 22" fill="none">
                                                <path class="fill-current"
                                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
