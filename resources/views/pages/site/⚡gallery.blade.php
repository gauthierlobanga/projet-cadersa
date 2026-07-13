<?php

use Livewire\Component;
use App\Models\Project;
use Livewire\Attributes\Layout;

new #[Layout('layouts::main')] class extends Component
{
    public function with(): array
    {
        return [
            'projects' => Project::query()
                ->has('media')
                ->active()
                ->latest('start_date')
                ->limit(24)
                ->get(['id', 'title', 'slug']),
        ];
    }
};
?>

<div>
    <!-- Header -->
    <section class="bg-slate-900 py-24 relative overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-r from-emerald-900/50 to-slate-900/50 mix-blend-multiply z-0"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center animate-fade-up">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">Galerie</h1>
            <p class="text-xl text-emerald-100 max-w-2xl mx-auto">Un aperçu visuel de nos réalisations et de notre impact sur le terrain.</p>
        </div>
    </section>

    <!-- Gallery Grid -->
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($projects as $index => $project)
                    <div class="group relative aspect-4/3 overflow-hidden rounded-2xl bg-slate-200 cursor-pointer animate-fade-up" style="animation-delay: {{ ($index % 3) * 0.1 }}s;" x-data="{ hovered: false }" @mouseenter="hovered = true" @mouseleave="hovered = false">

                        @if($project->hasMedia('cover'))
                            <img src="{{ $project->getFirstMediaUrl('cover', 'thumb') }}" alt="{{ $project->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700" :class="{ 'scale-110': hovered }">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-linear-to-t from-slate-900/80 via-slate-900/20 to-transparent opacity-0 transition-opacity duration-300" :class="{ 'opacity-100': hovered }"></div>

                        <!-- Content -->
                        <div class="absolute bottom-0 left-0 right-0 p-6 translate-y-4 transition-transform duration-300 opacity-0" :class="{ 'translate-y-0 opacity-100': hovered }">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $project->title }}</h3>
                            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center text-emerald-400 font-medium hover:text-emerald-300 text-sm">
                                Voir le projet
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($projects->isEmpty())
                <div class="text-center py-20 text-slate-500">
                    <svg class="mx-auto h-12 w-12 text-slate-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-slate-900">Aucun média</h3>
                    <p class="mt-1">Il n'y a pas encore d'images dans la galerie.</p>
                </div>
            @endif
        </div>
    </section>
</div>
