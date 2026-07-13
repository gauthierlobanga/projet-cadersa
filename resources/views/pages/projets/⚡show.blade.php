<?php

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::main')] class extends Component
{
    public Project $project;

    public function mount(Project $project)
    {
        $this->project = $project;
        view()->share('title', $project->title);
    }

    #[Computed]
    public function galleryImages()
    {
        return $this->project->getMedia('gallery')->map(fn($media) => [
            'url' => $media->getUrl(),
            'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
        ]);
    }
};
?>

<div class="relative min-h-screen bg-white dark:bg-zinc-950">
    {{-- Decorative Backgrounds --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 right-0 h-[30rem] w-[30rem] rounded-full bg-emerald-500/10 blur-[120px] transform-gpu"></div>
        <div class="absolute -left-40 top-40 h-[25rem] w-[25rem] rounded-full bg-teal-500/10 blur-[120px] transform-gpu"></div>
    </div>

    {{-- Hero Section --}}
    <section x-cloak class="relative flex min-h-[65vh] items-center justify-center overflow-hidden bg-zinc-900 rounded-b-4xl border-b border-zinc-200/20 dark:border-white/10" 
             x-data="{
                init() {
                    const tl = gsap.timeline({ defaults: { ease: 'power3.out' } });
                    const title = new SplitText($refs.title, { type: 'words,chars' });
                    
                    tl.from($refs.bg, { scale: 1.1, opacity: 0, duration: 1.5 })
                      .from($refs.badges, { opacity: 0, y: 20, duration: 0.6 }, '-=1')
                      .from(title.chars, { opacity: 0, y: 40, stagger: 0.02, duration: 0.8, ease: 'back.out(1.2)' }, '-=0.6')
                      .from($refs.meta, { opacity: 0, y: 20, duration: 0.6 }, '-=0.4');
                }
             }">
        
        {{-- Background Image --}}
        <div x-ref="bg" class="absolute inset-0">
            @if($project->hasMedia('cover'))
                <img src="{{ $project->getFirstMediaUrl('cover') }}" alt="{{ $project->title }}" class="h-full w-full object-cover opacity-40 dark:opacity-30">
            @else
                <div class="h-full w-full bg-gradient-to-br from-zinc-800 to-zinc-900"></div>
            @endif
            <div class="absolute inset-0 bg-linear-to-t from-zinc-950 via-zinc-950/60 to-transparent"></div>
        </div>

        {{-- Hero Content --}}
        <div class="relative z-10 mx-auto max-w-5xl px-6 pt-20 pb-16 text-center lg:px-8">
            <div x-ref="badges" class="flex flex-wrap items-center justify-center gap-4 mb-8">
                <span class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/20 px-5 py-2 text-sm font-semibold text-emerald-300 backdrop-blur-md shadow-[0_0_15px_rgba(16,185,129,0.2)]">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    {{ $project->status === 'completed' ? 'Terminé' : ($project->status === 'ongoing' ? 'En cours' : 'Planifié') }}
                </span>
                @if($project->location)
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/10 px-5 py-2 text-sm font-medium text-zinc-200 backdrop-blur-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $project->location }}
                    </span>
                @endif
            </div>

            <h1 x-ref="title" class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-7xl leading-tight">
                {{ $project->title }}
            </h1>

            <div x-ref="meta" class="mt-10 flex flex-wrap items-center justify-center gap-6 text-sm font-medium text-zinc-400">
                @if($project->start_date)
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Début : <span class="text-zinc-200">{{ $project->start_date->translatedFormat('F Y') }}</span></span>
                    </div>
                @endif
                @if($project->end_date)
                    <div class="flex items-center gap-2">
                        <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Fin : <span class="text-zinc-200">{{ $project->end_date->translatedFormat('F Y') }}</span></span>
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
                 class="prose prose-lg md:prose-xl max-w-none dark:prose-invert transition-all duration-1000 ease-out
                        prose-headings:font-bold prose-headings:tracking-tight 
                        prose-h2:mt-12 prose-h2:mb-6 prose-h2:text-3xl
                        prose-h3:mt-8 prose-h3:mb-4 prose-h3:text-2xl
                        prose-p:leading-relaxed prose-p:text-zinc-600 dark:prose-p:text-zinc-300
                        prose-a:text-emerald-600 hover:prose-a:text-emerald-500 hover:prose-a:underline dark:prose-a:text-emerald-400
                        prose-img:rounded-2xl prose-img:shadow-xl prose-img:shadow-zinc-200/20 dark:prose-img:shadow-black/40
                        prose-strong:text-zinc-900 dark:prose-strong:text-white
                        prose-ul:list-disc prose-ul:pl-6 prose-li:my-2
                        bg-white/50 dark:bg-zinc-900/50 backdrop-blur-xl p-8 md:p-12 rounded-3xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                {!! $project->renderRichContent('content') !!}
            </div>

            {{-- Galerie --}}
            @if($this->galleryImages->isNotEmpty())
                <div x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
                     :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                     class="mt-24 transition-all duration-1000 delay-200 ease-out">
                    
                    <div class="mb-10 flex items-center justify-between border-b border-zinc-200 pb-4 dark:border-zinc-800">
                        <h3 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Galerie du projet</h3>
                        <span class="rounded-full bg-zinc-100 px-3 py-1 text-sm font-medium text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                            {{ $this->galleryImages->count() }} media{{ $this->galleryImages->count() > 1 ? 's' : '' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:gap-6" x-data="{ lightbox: false, activeImage: '' }">
                        @foreach($this->galleryImages as $index => $image)
                            <div @click="lightbox = true; activeImage = '{{ $image['url'] }}'" 
                                 class="group relative aspect-square cursor-zoom-in overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800 shadow-sm transition-all duration-300 hover:shadow-xl hover:shadow-emerald-500/10">
                                <img src="{{ $image['thumb'] }}" alt="Galerie" 
                                     class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110" loading="lazy">
                                <div class="absolute inset-0 bg-linear-to-t from-zinc-900/60 via-zinc-900/0 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
                                <div class="absolute bottom-4 left-4 opacity-0 transition-all duration-300 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0">
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 backdrop-blur-md text-white">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    </span>
                                </div>
                            </div>
                        @endforeach

                        {{-- Lightbox Premium --}}
                        <template x-teleport="body">
                            <div x-show="lightbox" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 backdrop-blur-none"
                                 x-transition:enter-end="opacity-100 backdrop-blur-xl"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100 backdrop-blur-xl"
                                 x-transition:leave-end="opacity-0 backdrop-blur-none"
                                 class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/90 p-4 sm:p-6" 
                                 @keydown.escape.window="lightbox = false"
                                 x-cloak>
                                
                                {{-- Overlay click to close --}}
                                <div class="absolute inset-0" @click="lightbox = false"></div>
                                
                                {{-- Close button --}}
                                <button @click="lightbox = false" class="absolute right-6 top-6 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20 hover:scale-110">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                
                                {{-- Image Container --}}
                                <div class="relative z-0 mx-auto max-h-full max-w-7xl"
                                     x-show="lightbox"
                                     x-transition:enter="transition ease-out duration-400 delay-100"
                                     x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-200"
                                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                                    <img :src="activeImage" class="max-h-[85vh] w-auto rounded-3xl shadow-2xl shadow-black/50 object-contain ring-1 ring-white/10" @click.stop="">
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>