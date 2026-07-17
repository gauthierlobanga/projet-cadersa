<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Settings\AboutSettings;

new #[Layout('layouts::main')] class extends Component {
    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }
};
?>

<div>

    <section x-cloak class="relative isolate overflow-hidden" x-data="homeHeroReveal"> {{-- Image de fond --}}
        @php
            $heroImage = $this->about->hero_image_url
                ? Storage::url($this->about->hero_image_url)
                : 'https://images.unsplash.com/photo-1595804470216-9d32d0ff05e6?q=80&w=1200&auto=format&fit=crop';
        @endphp

        <div class="absolute inset-0">
            <img x-ref="bgImage" src="{{ $heroImage }}" alt="Paysage rural de la RDC"
                class="h-full w-full object-cover origin-center" />
            <div class="absolute inset-0 bg-linear-to-br from-zinc-950/80 via-zinc-900/60 to-emerald-950/60"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_40%_20%,rgba(16,185,129,.12),transparent_50%)]">
            </div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_80%_80%,rgba(255,255,255,.06),transparent_40%)]">
            </div>
            <div x-ref="decoLine"
                class="absolute bottom-0 left-0 h-0.5 w-0 bg-linear-to-r from-emerald-500 via-teal-400 to-transparent origin-left">
            </div>
        </div>

        <div class="relative mx-auto flex min-h-[90svh] max-w-7xl items-center px-6 pt-26 pb-24 lg:px-8">
            <div class="max-w-4xl">
                {{-- Badge --}}
                <div x-ref="badge"
                    class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 backdrop-blur-xl">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                    <span class="text-sm font-medium tracking-wide text-zinc-200">
                        {{ $this->about->hero_badge }}
                    </span>
                </div>

                {{-- Title --}}
                <h1 x-ref="title"
                    class="mt-8 max-w-4xl text-4xl font-semibold tracking-tight text-white md:text-5xl lg:text-6xl">
                    {{ $this->about->hero_title }}
                </h1>

                {{-- Auteur avec icône --}}
                <div x-ref="author" class="mt-4 flex items-center gap-2">
                    <div class="h-px w-14 bg-emerald-400/70"></div>
                    <p class="text-lg font-semibold text-emerald-300 lg:text-xl">
                        Prof. Dr Bernard HANGI
                    </p>
                    <div class="h-px w-14 bg-emerald-400/70 hidden sm:block"></div>
                </div>

                {{-- Subtitle --}}
                <p x-ref="subtitle" class="mt-8 max-w-2xl text-lg leading-8 text-zinc-300 md:text-xl">
                    {{ $this->about->hero_subtitle }}
                </p>

                {{-- Boutons CTA --}}
                <div x-ref="buttons" class="mt-10 flex flex-col sm:flex-row items-center gap-5">
                    <a href="{{ route('projects.index') }}" wire:navigate
                        class="group relative inline-flex h-14 items-center justify-center border-2 border-emerald-500 bg-emerald-500 px-8 font-semibold text-white transition-all duration-300 hover:bg-emerald-600 hover:border-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 active:scale-[0.97]">
                        <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                            Découvrir nos projets
                            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>

                    <a href="{{ route('about') }}" wire:navigate
                        class="group relative inline-flex h-14 items-center justify-center border border-white/20 px-8 font-semibold text-white transition-all duration-300 active:scale-[0.97] hover:border-emerald-300/50 hover:bg-emerald-50/30">
                        <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                            En savoir plus
                            <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section id="about" x-cloak class="relative overflow-hidden bg-white py-28 dark:bg-zinc-950">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-0 top-0 h-128 w-lg rounded-full bg-emerald-500/5 blur-[140px] transform-gpu">
            </div>
            <div class="absolute right-0 bottom-0 h-112 w-md rounded-full bg-teal-500/5 blur-[140px] transform-gpu">
            </div>
        </div>
        <div x-data="aboutQuoteReveal" class="relative mx-auto max-w-7xl px-6 lg:px-8">
            {{-- About Section : Image à gauche, Contenu à droite --}}
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16 items-center mb-24">
                {{-- En‑tête animé (Texte) --}}
                <div x-cloak class="max-w-3xl" x-data="cspState" x-intersect="shown = true">
                    {{-- Badge --}}
                    <span
                        class="inline-flex items-center rounded-full border border-emerald-500/20 bg-emerald-500/10 px-4 py-2 text-sm font-medium text-emerald-700 dark:text-emerald-400 backdrop-blur-sm transition-all duration-700 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        {{ $this->about->hero_badge }}
                    </span>

                    {{-- Titre --}}
                    <h2 class="mt-6 text-4xl font-semibold tracking-tight text-zinc-900 dark:text-white lg:text-5xl transition-all duration-700 delay-100 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        {{ $this->about->hero_title }}
                    </h2>

                    {{-- Description --}}
                    @php $aboutBlocks = $this->about->aboutBlocks(); @endphp
                    @if (!empty($aboutBlocks))
                        <div class="w-full max-w-none mt-8
                            text-zinc-700 dark:text-zinc-300 text-base leading-relaxed
                            [&>p]:mb-5 [&>p]:leading-relaxed
                            [&>h1]:text-4xl [&>h1]:font-extrabold [&>h1]:tracking-tight [&>h1]:text-zinc-900 dark:[&>h1]:text-white [&>h1]:mb-8
                            [&>h2]:text-3xl [&>h2]:font-extrabold [&>h2]:tracking-tight [&>h2]:text-zinc-900 dark:[&>h2]:text-white [&>h2]:mt-12 [&>h2]:mb-6 [&>h2]:border-b [&>h2]:border-emerald-100 dark:[&>h2]:border-emerald-900/30 [&>h2]:pb-4
                            [&>h3]:text-2xl [&>h3]:font-bold [&>h3]:text-zinc-800 dark:[&>h3]:text-zinc-100 [&>h3]:mt-10 [&>h3]:mb-4
                            [&_a]:font-medium [&_a]:text-emerald-600 dark:[&_a]:text-emerald-400 [&_a]:underline [&_a]:underline-offset-4 [&_a]:decoration-emerald-200 dark:[&_a]:decoration-emerald-900 hover:[&_a]:decoration-emerald-600 dark:hover:[&_a]:decoration-emerald-400 [&_a]:transition-colors
                            [&>blockquote]:pl-6 [&>blockquote]:py-4 [&>blockquote]:my-8 [&>blockquote]:border-l-4 [&>blockquote]:border-emerald-500 [&>blockquote]:bg-linear-to-r [&>blockquote]:from-emerald-50 [&>blockquote]:to-transparent dark:[&>blockquote]:from-emerald-900/20 [&>blockquote]:rounded-r-2xl [&>blockquote]:text-xl [&>blockquote]:italic [&>blockquote]:text-emerald-900 dark:[&>blockquote]:text-emerald-100 [&>blockquote]:font-serif
                            [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-6 [&>ul]:space-y-3 [&>ul>li]:pl-2 [&>ul>li::marker]:text-emerald-500
                            [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mb-6 [&>ol]:space-y-3 [&>ol>li]:pl-2 [&>ol>li::marker]:text-emerald-500
                            [&_table]:w-full [&_table]:my-8 [&_table]:border-collapse [&_table]:rounded-xl [&_table]:overflow-hidden
                            [&_thead]:bg-emerald-50 dark:[&_thead]:bg-emerald-900/20
                            [&_th]:px-4 [&_th]:py-3 [&_th]:text-left [&_th]:text-sm [&_th]:font-semibold [&_th]:text-emerald-900 dark:[&_th]:text-emerald-200 [&_th]:border-b [&_th]:border-emerald-200 dark:[&_th]:border-emerald-800
                            [&_td]:px-4 [&_td]:py-3 [&_td]:text-sm [&_td]:border-b [&_td]:border-zinc-100 dark:[&_td]:border-zinc-800
                            [&_img]:rounded-3xl [&_img]:shadow-2xl [&_img]:my-10 [&_img]:border [&_img]:border-zinc-100 dark:[&_img]:border-zinc-800 [&_img]:mx-auto
                            [&_strong]:font-semibold [&_strong]:text-zinc-900 dark:[&_strong]:text-white transition-all duration-700 delay-200 ease-out"
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                            @foreach ($aboutBlocks as $block)
                                @if (!empty($block['title']))
                                    <h3 class="text-2xl font-semibold mt-4">{{ $block['title'] }}</h3>
                                @endif

                                @if (!empty($block['description']))
                                    @if (is_array($block['description']) && isset($block['description']['type']))
                                        {!! new \Tiptap\Editor()->setContent($block['description'])->getHTML() !!}
                                    @else
                                        {!! $block['description'] !!}
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Image droite --}}
                <div x-cloak class="relative" x-data="{ shown: false }" x-intersect="shown = true">
                    <div class="relative overflow-hidden transition-all duration-1000 delay-300 ease-out"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                        @php $aboutImage = $aboutBlocks[0]['image_url'] ?? $this->about->about_image_url ?? null; @endphp
                        <img src="{{ $aboutImage ? Storage::url($aboutImage) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop' }}"
                            alt="À propos de CADERSA" class="w-full object-cover aspect-4/3" />
                        <div class="absolute inset-0 ring-1 ring-inset ring-zinc-900/10 dark:ring-white/10">
                        </div>
                    </div>

                    {{-- Déco SVG / Pattern --}}
                    <div class="absolute -bottom-6 -left-6 -z-10 transition-all duration-1000 delay-500 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        <svg class="w-32 h-32 text-emerald-500/20" fill="currentColor" viewBox="0 0 100 100">
                            <pattern id="dots" x="0" y="0" width="20" height="20"
                                patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="2" />
                            </pattern>
                            <rect width="100" height="100" fill="url(#dots)" />
                        </svg>
                    </div>

                </div>
            </div>

            {{-- Vision Section : Image à gauche, Contenu à droite --}}
            @php $visionBlocks = $this->about->visionBlocks(); @endphp
            @if (!empty($visionBlocks))
                <div x-cloak x-data="cspState" x-intersect="shown = true"
                    class="mt-20 grid gap-12 lg:grid-cols-2 lg:items-center overflow-hidden">

                    {{-- Image Vision --}}
                    <div class="relative order-2 lg:order-1 transition-all duration-1200 ease-out delay-100"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-16'">
                        <div class="overflow-hidden border border-zinc-200/60 dark:border-white/10">
                            @php $visionImage = $visionBlocks[0]['image_url'] ?? $this->about->about_image_url ?? null; @endphp
                            <img src="{{ $visionImage ? Storage::url($visionImage) : asset('images/agriculture.png') }}"
                                alt="Vision CADERSA" class="aspect-4/3 w-full object-cover">
                        </div>
                    </div>

                    {{-- Contenu Vision --}}
                    <div class="order-1 lg:order-2 space-y-6 lg:pl-10 transition-all duration-1200 ease-out delay-300"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-16'">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Notre vision
                            </h3>
                        </div>
                        <div
                            class="w-full max-w-none
                        text-zinc-700 dark:text-zinc-300 text-base leading-relaxed
                        [&>p]:mb-5 [&>p]:leading-relaxed
                        [&>h1]:text-4xl [&>h1]:font-extrabold [&>h1]:tracking-tight [&>h1]:text-zinc-900 dark:[&>h1]:text-white [&>h1]:mb-8
                        [&>h2]:text-3xl [&>h2]:font-extrabold [&>h2]:tracking-tight [&>h2]:text-zinc-900 dark:[&>h2]:text-white [&>h2]:mt-12 [&>h2]:mb-6 [&>h2]:border-b [&>h2]:border-emerald-100 dark:[&>h2]:border-emerald-900/30 [&>h2]:pb-4
                        [&>h3]:text-2xl [&>h3]:font-bold [&>h3]:text-zinc-800 dark:[&>h3]:text-zinc-100 [&>h3]:mt-10 [&>h3]:mb-4
                        [&_a]:font-medium [&_a]:text-emerald-600 dark:[&_a]:text-emerald-400 [&_a]:underline [&_a]:underline-offset-4 [&_a]:decoration-emerald-200 dark:[&_a]:decoration-emerald-900 hover:[&_a]:decoration-emerald-600 dark:hover:[&_a]:decoration-emerald-400 [&_a]:transition-colors
                        [&>blockquote]:pl-6 [&>blockquote]:py-4 [&>blockquote]:my-8 [&>blockquote]:border-l-4 [&>blockquote]:border-emerald-500 [&>blockquote]:bg-linear-to-r [&>blockquote]:from-emerald-50 [&>blockquote]:to-transparent dark:[&>blockquote]:from-emerald-900/20 [&>blockquote]:rounded-r-2xl [&>blockquote]:text-xl [&>blockquote]:italic [&>blockquote]:text-emerald-900 dark:[&>blockquote]:text-emerald-100 [&>blockquote]:font-serif
                        [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-6 [&>ul]:space-y-3 [&>ul>li]:pl-2 [&>ul>li::marker]:text-emerald-500
                        [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mb-6 [&>ol]:space-y-3 [&>ol>li]:pl-2 [&>ol>li::marker]:text-emerald-500
                        [&_table]:w-full [&_table]:my-8 [&_table]:border-collapse [&_table]:rounded-xl [&_table]:overflow-hidden
                        [&_thead]:bg-emerald-50 dark:[&_thead]:bg-emerald-900/20
                        [&_th]:px-4 [&_th]:py-3 [&_th]:text-left [&_th]:text-sm [&_th]:font-semibold [&_th]:text-emerald-900 dark:[&_th]:text-emerald-200 [&_th]:border-b [&_th]:border-emerald-200 dark:[&_th]:border-emerald-800
                        [&_td]:px-4 [&_td]:py-3 [&_td]:text-sm [&_td]:border-b [&_td]:border-zinc-100 dark:[&_td]:border-zinc-800
                        [&_img]:rounded-3xl [&_img]:shadow-2xl [&_img]:my-10 [&_img]:border [&_img]:border-zinc-100 dark:[&_img]:border-zinc-800 [&_img]:mx-auto
                        [&_strong]:font-semibold [&_strong]:text-zinc-900 dark:[&_strong]:text-white">
                            @foreach ($visionBlocks as $block)
                                @if (!empty($block['title']))
                                    <h4 class="text-xl font-semibold">{{ $block['title'] }}</h4>
                                @endif

                                @if (!empty($block['description']))
                                    @if (is_array($block['description']) && isset($block['description']['type']))
                                        {!! new \Tiptap\Editor()->setContent($block['description'])->getHTML() !!}
                                    @else
                                        {!! $block['description'] !!}
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Mission Section : Contenu à gauche, Image à droite --}}
            @php $missionBlocks = $this->about->missionBlocks(); @endphp
            @if (!empty($missionBlocks))
                <div x-cloak x-data="cspState" x-intersect="shown = true"
                    class="mt-32 grid gap-12 lg:grid-cols-2 lg:items-center overflow-hidden">

                    {{-- Contenu Mission --}}
                    <div class="order-1 space-y-6 lg:pr-10 transition-all duration-1200 ease-out delay-100"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-16'">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-2xl bg-teal-500/10 text-teal-600">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Notre mission
                            </h3>
                        </div>
                        <div
                            class="w-full max-w-none
                        text-zinc-700 dark:text-zinc-300 text-base leading-relaxed
                        [&>p]:mb-5 [&>p]:leading-relaxed
                        [&>h1]:text-4xl [&>h1]:font-extrabold [&>h1]:tracking-tight [&>h1]:text-zinc-900 dark:[&>h1]:text-white [&>h1]:mb-8
                        [&>h2]:text-3xl [&>h2]:font-extrabold [&>h2]:tracking-tight [&>h2]:text-zinc-900 dark:[&>h2]:text-white [&>h2]:mt-12 [&>h2]:mb-6 [&>h2]:border-b [&>h2]:border-emerald-100 dark:[&>h2]:border-emerald-900/30 [&>h2]:pb-4
                        [&>h3]:text-2xl [&>h3]:font-bold [&>h3]:text-zinc-800 dark:[&>h3]:text-zinc-100 [&>h3]:mt-10 [&>h3]:mb-4
                        [&_a]:font-medium [&_a]:text-emerald-600 dark:[&_a]:text-emerald-400 [&_a]:underline [&_a]:underline-offset-4 [&_a]:decoration-emerald-200 dark:[&_a]:decoration-emerald-900 hover:[&_a]:decoration-emerald-600 dark:hover:[&_a]:decoration-emerald-400 [&_a]:transition-colors
                        [&>blockquote]:pl-6 [&>blockquote]:py-4 [&>blockquote]:my-8 [&>blockquote]:border-l-4 [&>blockquote]:border-emerald-500 [&>blockquote]:bg-linear-to-r [&>blockquote]:from-emerald-50 [&>blockquote]:to-transparent dark:[&>blockquote]:from-emerald-900/20 [&>blockquote]:rounded-r-2xl [&>blockquote]:text-xl [&>blockquote]:italic [&>blockquote]:text-emerald-900 dark:[&>blockquote]:text-emerald-100 [&>blockquote]:font-serif
                        [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-6 [&>ul]:space-y-3 [&>ul>li]:pl-2 [&>ul>li::marker]:text-emerald-500
                        [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mb-6 [&>ol]:space-y-3 [&>ol>li]:pl-2 [&>ol>li::marker]:text-emerald-500
                        [&_table]:w-full [&_table]:my-8 [&_table]:border-collapse [&_table]:rounded-xl [&_table]:overflow-hidden
                        [&_thead]:bg-emerald-50 dark:[&_thead]:bg-emerald-900/20
                        [&_th]:px-4 [&_th]:py-3 [&_th]:text-left [&_th]:text-sm [&_th]:font-semibold [&_th]:text-emerald-900 dark:[&_th]:text-emerald-200 [&_th]:border-b [&_th]:border-emerald-200 dark:[&_th]:border-emerald-800
                        [&_td]:px-4 [&_td]:py-3 [&_td]:text-sm [&_td]:border-b [&_td]:border-zinc-100 dark:[&_td]:border-zinc-800
                        [&_img]:rounded-3xl [&_img]:shadow-2xl [&_img]:my-10 [&_img]:border [&_img]:border-zinc-100 dark:[&_img]:border-zinc-800 [&_img]:mx-auto
                        [&_strong]:font-semibold [&_strong]:text-zinc-900 dark:[&_strong]:text-white">
                            @foreach ($missionBlocks as $block)
                                @if (!empty($block['title']))
                                    <h4 class="text-xl font-semibold">{{ $block['title'] }}</h4>
                                @endif

                                @if (!empty($block['description']))
                                    @if (is_array($block['description']) && isset($block['description']['type']))
                                        {!! new \Tiptap\Editor()->setContent($block['description'])->getHTML() !!}
                                    @else
                                        {!! $block['description'] !!}
                                    @endif
                                @endif
                            @endforeach
                        </div>

                        {{-- Boutons d'action --}}
                        <div x-ref="buttons" class="mt-10 flex flex-col gap-4 sm:flex-row">
                            <a href="{{ route('about') }}" wire:navigate
                                class="group relative inline-flex h-14 items-center justify-center border-2 border-emerald-500 bg-emerald-500 px-8 font-semibold text-white transition-all duration-300 hover:bg-emerald-600 hover:border-emerald-600 hover:shadow-lg hover:shadow-emerald-500/30 active:scale-[0.97]">
                                <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                                    Découvrir notre histoire
                                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </a>

                            <a href="{{ route('services.index') }}" wire:navigate
                                class="group relative inline-flex h-14 items-center justify-center border border-emerald-300/50 px-8 font-semibold text-zinc-400 transition-all duration-300 active:scale-[0.97]">
                                <span class="relative z-10 flex items-center gap-2 whitespace-nowrap">
                                    Nos domaines d'action
                                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>

                    {{-- Image Mission --}}
                    <div class="relative order-2 transition-all duration-1200 ease-out delay-300"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-16'">
                        <div class="overflow-hidden border border-zinc-200/60 dark:border-white/10">
                            @php $missionImage = $missionBlocks[0]['image_url'] ?? asset('images/reforestation.png'); @endphp
                            <img src="{{ $missionImage ? Storage::url($missionImage) : asset('images/reforestation.png') }}"
                                alt="Mission CADERSA" class="aspect-4/3 w-full object-cover">
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Impact Section -->
    <section id="impact" class="relative overflow-hidden py-24">
        {{-- Fond avec overlay --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/reforestation.png') }}" alt="Reboisement communautaire"
                class="h-full w-full object-cover" />
            <div class="absolute inset-0 bg-zinc-900/80 dark:bg-zinc-950/90"></div>
            <div class="absolute inset-0 bg-linear-to-t from-emerald-900/30 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 mx-auto max-w-350 px-6 lg:px-8">
            {{-- En‑tête --}}
            <div x-cloak class="mb-16 max-w-3xl" x-data="cspState" x-intersect="shown = true">
                <span
                    class="inline-block rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-300 backdrop-blur-sm transition-all duration-700 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Notre impact
                </span>
                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl transition-all duration-700 delay-100 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    {{ $this->about->impactHeading() }}
                </h2>
                @if ($this->about->impact_subtitle)
                    <p class="mt-6 text-lg leading-8 text-zinc-300 transition-all duration-700 delay-200 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        {{ $this->about->impactSubtitle() }}
                    </p>
                @endif
            </div>

            @if ($this->about->impactDescription())
                <div class="prose prose-invert max-w-4xl text-zinc-200 mb-14 text-base leading-relaxed">
                    @if (is_array($this->about->impactDescription()) && isset($this->about->impactDescription()['type']))
                        {!! new \Tiptap\Editor()->setContent($this->about->impactDescription())->getHTML() !!}
                    @else
                        {!! $this->about->impactDescription() !!}
                    @endif
                </div>
            @endif

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $stats = collect($this->about->getImpactStats())
                        ->map(function ($stat) {
                            $stat = is_array($stat) ? $stat : [];

                            return array_merge(
                                [
                                    'value' => $stat['value'] ?? '',
                                    'label' => $stat['label'] ?? '',
                                    'icon' => $stat['icon'] ?? 'M12 14l9-5-9-5-9 5 9 5z',
                                ],
                                $stat,
                            );
                        })
                        ->toArray();
                @endphp

                @foreach ($stats as $index => $stat)
                    <div x-cloak x-data="animatedStat('{{ addslashes($stat['value']) }}')" x-intersect.once="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="transition-all duration-700 ease-out" style="transition-delay: {{ $index * 100 }}ms">

                        <div
                            class="group relative border bg-transparent p-6 transition-all duration-300 hover:-translate-y-0.5 border-zinc-400/20 dark:border-zinc-800/50 dark:bg-zinc-900/30 hover:border-emerald-700/40 hover:bg-emerald-900/10">

                            {{-- Image ou icône --}}
                            @if ($stat['image_url'])
                                <div class="mb-4 overflow-hidden">
                                    <img src="{{ Storage::url($stat['image_url']) }}" alt="{{ $stat['label'] }}"
                                        class="h-32 w-full object-cover transition duration-700 group-hover:scale-105" />
                                </div>
                            @else
                                <div
                                    class="mb-4 flex h-11 w-11 items-center justify-center border border-zinc-200/50 bg-zinc-50/50 text-emerald-600 transition duration-300 group-hover:border-emerald-300/50 group-hover:bg-emerald-50/50 dark:border-zinc-700/50 dark:bg-zinc-900/50 dark:text-emerald-400 dark:group-hover:border-emerald-700/40 dark:group-hover:bg-emerald-900/20">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="{{ $stat['icon'] }}" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Valeur --}}
                            <div class="text-3xl font-bold tracking-tight text-white"
                                x-text="shown ? formatValue(count) : targetRaw"></div>

                            {{-- Label --}}
                            <div class="mt-2 text-sm font-medium text-zinc-300">
                                {{ $stat['label'] }}</div>

                            {{-- Description (optionnelle) --}}
                            @if ($stat['description'])
                                <p class="mt-2 text-sm leading-relaxed text-zinc-400 dark:text-zinc-400">
                                    {{ $stat['description'] }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Bloc principal --}}
            <div x-cloak class="mt-16" x-data="{ shown: false }" x-intersect="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'"
                class="transition-all duration-700 ease-out">
                <div class="overflow-hidden rounded-3xl border border-white/10 bg-white/5 backdrop-blur-md">
                    <div class="grid gap-8 p-8 md:grid-cols-2 md:p-12">
                        {{-- Colonne de gauche --}}
                        <div>
                            <h3 class="text-2xl font-bold text-white">{{ $this->about->impactHighlightHeading() }}
                            </h3>
                            <div
                                class="mt-4 text-zinc-300 text-base leading-relaxed prose prose-invert prose-a:text-emerald-300 prose-a:underline prose-a:underline-offset-4 prose-a:decoration-emerald-500">
                                @if ($this->about->impactHighlightText())
                                    @if (is_array($this->about->impactHighlightText()) && isset($this->about->impactHighlightText()['type']))
                                        {!! new \Tiptap\Editor()->setContent($this->about->impactHighlightText())->getHTML() !!}
                                    @else
                                        {!! $this->about->impactHighlightText() !!}
                                    @endif
                                @endif
                            </div>
                        </div>

                        {{-- Colonne de droite --}}
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                            <div class="flex h-full flex-col justify-between gap-6">
                                <div>
                                    <p class="text-sm uppercase tracking-[0.32em] text-emerald-300">
                                        Focus
                                    </p>
                                    <p class="mt-4 text-sm leading-7 text-zinc-300">
                                        {{ $this->about->impactSubtitle() ?: 'Un projet conçu pour générer un impact durable et mesurable.' }}
                                    </p>
                                </div>

                                @if ($this->about->impactHighlightCtaLabel() && $this->about->impactHighlightCtaUrl())
                                    <a href="{{ $this->about->impactHighlightCtaUrl() }}"
                                        class="inline-flex items-center justify-center rounded-full bg-emerald-500 px-6 py-3 text-sm font-semibold text-white transition hover:bg-emerald-400">
                                        {{ $this->about->impactHighlightCtaLabel() }}
                                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
