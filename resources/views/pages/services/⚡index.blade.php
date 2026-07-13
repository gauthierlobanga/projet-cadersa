<?php

use Livewire\Component;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

new #[Layout('layouts::main')] class extends Component {
    #[Computed]
    public function services()
    {
        return Service::query()->where('is_active', true)->orderBy('sort_order')->get();
    }

    #[Computed]
    public function stats()
    {
        return [
            'services' => Service::active()->count(),
            'categories' => 7, // à adapter selon votre contexte
            'projets' => \App\Models\Project::active()->count(),
        ];
    }
};
?>

<div class="min-h-screen bg-zinc-50 dark:bg-zinc-950">
    {{-- Header (même style que Blog) --}}
    <section x-cloak class="relative overflow-hidden bg-[#fafaf9] py-18 sm:py-24 lg:py-28 dark:bg-zinc-950"
        x-data="{ shown: false }" x-intersect.once="shown = true">
        <div class="pointer-events-none absolute inset-0 z-0">
            <div
                class="absolute -top-40 right-0 h-150 w-150 rounded-full bg-linear-to-br from-emerald-200/20 to-teal-100/0 blur-3xl dark:from-emerald-500/5 dark:to-transparent">
            </div>
            <div
                class="absolute -bottom-20 -left-20 h-125 w-125 rounded-full bg-linear-to-tr from-zinc-200/40 to-emerald-100/0 blur-3xl dark:from-zinc-900/50 dark:to-transparent">
            </div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-size-[14px_24px] mask-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
            </div>
        </div>

        <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 items-start gap-16 lg:grid-cols-12 lg:gap-24">
                <div class="flex flex-col items-start gap-6 lg:col-span-7">
                    <div class="inline-flex items-center gap-2.5 rounded-full border border-zinc-200 bg-white/80 px-3.5 py-1 text-[11px] font-medium uppercase tracking-[0.15em] text-zinc-500 backdrop-blur-md transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] dark:border-zinc-800 dark:bg-zinc-900/80 dark:text-zinc-400"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                        <span class="relative flex h-1.5 w-1.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                            <span
                                class="relative inline-flex h-1.5 w-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span>
                        </span>
                        Services
                    </div>
                    <h1 class="text-pretty text-4xl font-bold tracking-tight text-zinc-950 sm:text-6xl xl:text-7xl font-serif dark:text-zinc-50 transition-all duration-1000 delay-100 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Nos <span
                            class="relative inline-block bg-linear-to-r from-emerald-600 via-emerald-500 to-teal-600 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-400">services</span>
                    </h1>
                    <p class="max-w-xl text-lg leading-relaxed text-zinc-600/90 dark:text-zinc-400 font-sans transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Des solutions concrètes pour le développement rural et la sécurité alimentaire.
                    </p>
                </div>
                <div class="w-full lg:col-span-5 lg:pt-4 transition-all duration-1000 delay-300 ease-[cubic-bezier(0.16,1,0.3,1)]"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                    <div
                        class="group relative overflow-hidden bg-white/40 p-8 transition-all duration-500 dark:border-zinc-800 dark:bg-zinc-900/40">
                        <div class="relative z-10 flex flex-col gap-8">
                            <div class="grid grid-cols-2 gap-x-8 gap-y-10 sm:grid-cols-3 lg:grid-cols-2">
                                @foreach ($this->stats as $label => $value)
                                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                                        class="group relative min-w-24 px-4 py-3 text-center xs:min-w-27 transition-all duration-700 delay-{{ 300 + $loop->index * 100 }}"
                                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                        <div class="absolute inset-0 rounded-xl bg-emerald-50/80 transition duration-300 ease-out group-hover:bg-emerald-100 dark:bg-white/5 dark:group-hover:bg-emerald-500/10"
                                            aria-hidden="true"></div>
                                        <div class="relative z-10 flex flex-col items-center">
                                            <span
                                                class="text-xs font-semibold uppercase tracking-widest text-zinc-500 group-hover:text-emerald-700 transition-colors duration-300 dark:text-zinc-400 dark:group-hover:text-emerald-300">{{ $label }}</span>
                                            <span
                                                class="text-2xl font-bold text-zinc-900 dark:text-white">{{ $value }}</span>
                                        </div>
                                        {{-- Coins décoratifs --}}
                                        <svg class="absolute top-0 left-0 h-2.5 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ '-translate-x-1 -translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute bottom-0 left-0 h-2.5 -scale-y-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ '-translate-x-1 translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute top-0 right-0 h-2.5 -scale-x-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ 'translate-x-1 -translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                        <svg class="absolute bottom-0 right-0 h-2.5 -scale-x-100 -scale-y-100 text-emerald-400 transition-transform duration-300 ease-out"
                                            :class="{ 'translate-x-1 translate-y-1': hover }" viewBox="0 0 11 11"
                                            fill="none">
                                            <path d="M9.5 0.5H0.5V9.5" stroke="currentColor" stroke-linecap="round" />
                                        </svg>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{-- Coins graphiques --}}
                        <div
                            class="absolute top-3 left-3 size-1.5 border-t border-l border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute top-3 right-3 size-1.5 border-t border-r border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute bottom-3 left-3 size-1.5 border-b border-l border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                        <div
                            class="absolute bottom-3 right-3 size-1.5 border-b border-r border-zinc-300 opacity-40 dark:border-zinc-700">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Grille des services (style carte inspiré du blog) --}}
    <section class="px-5 py-8 xs:px-8 md:p-10 mx-auto max-w-7xl lg:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
            @forelse ($this->services as $service)
                <a href="{{ route('services.show', $service) }}" wire:navigate
                    class="group relative flex flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
                           hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                           dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20">
                    {{-- Image --}}
                    @if ($service->hasMedia('image'))
                        <div
                            class="overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                            <img src="{{ $service->getFirstMediaUrl('image', 'card') }}" alt="{{ $service->title }}"
                                class="aspect-video w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                loading="lazy" />
                        </div>
                    @else
                        <div
                            class="flex aspect-video w-full items-center justify-center bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                    <div class="flex flex-1 flex-col gap-2 p-4">
                        <p
                            class="line-clamp-1 font-outfit font-medium text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                            {{ $service->title }}
                        </p>
                        <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $service->short_excerpt ?? $service->getPlainTextContent(120) }}</p>
                        <div class="mt-5 flex items-center justify-between gap-3">
                            <div
                                class="flex shrink-0 items-center gap-1 text-sm font-medium text-emerald-600 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:gap-2 dark:text-emerald-400">
                                Découvrir
                                <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-16 text-center text-zinc-500">Aucun service disponible pour le moment.
                </div>
            @endforelse
        </div>
    </section>
</div>
