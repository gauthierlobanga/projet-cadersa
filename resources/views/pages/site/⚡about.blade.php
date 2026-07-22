<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Settings\AboutSettings;
use App\Concerns\Traits\HasImageUrl;
use App\Settings\SettingApp;

new #[Layout('layouts::main')] class extends Component {
    use HasImageUrl;

    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }

    #[Computed]
    public function settings(): SettingApp
    {
        return app(SettingApp::class);
    }
};
?>

<div>

    {{-- ========== HERO ABOUT – Image en arrière-plan moderne ========== --}}
    <section x-cloak class="relative overflow-hidden bg-slate-900 dark:bg-zinc-950 min-h-[80svh] flex items-center"
        x-data="aboutHeroReveal">
        @php
            $heroImage = $this->imageUrl($this->about->hero_image_url) ?: $this->imageUrl('images/gaudev-hero.png');
        @endphp

        {{-- Image en arrière-plan avec overlay --}}
        <div class="absolute inset-0 z-0">
            <img x-ref="bgImage" src="{{ $heroImage }}" alt="" class="absolute inset-0 w-full h-full object-cover object-center"
                loading="eager" fetchpriority="high" />
            {{-- Overlay : dégradé sombre pour lisibilité --}}
            <div
                class="absolute inset-0 bg-linear-to-r from-slate-900/90 via-slate-900/70 to-slate-900/40 dark:from-zinc-950/90 dark:via-zinc-950/70 dark:to-zinc-950/40">
            </div>
            {{-- Halo lumineux --}}
            <div class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-400/10 blur-3xl"></div>
        </div>

        {{-- Contenu texte (par-dessus l'image) --}}
        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12 lg:py-16 lg:px-12">
            <div class="w-full max-w-2xl">
                <h1 x-ref="title"
                    class="mt-8 text-4xl sm:text-5xl md:text-6xl lg:text-6xl font-extrabold tracking-tight text-white leading-tight">
                    {{ $this->about->hero_title ?: 'À propos de moi' }}
                </h1>

                <div x-ref="author" class="mt-4 flex items-center gap-3">
                    <div class="h-px w-16 bg-emerald-500/80"></div>
                    <p class="text-2xl font-extrabold tracking-tight text-emerald-300 lg:text-3xl">
                        {{ $this->about->auteur_about ?: 'Gauthier Lobanga' }}
                    </p>
                    <div class="h-px w-16 bg-emerald-500/80 hidden sm:block"></div>
                </div>

                <p x-ref="subtitle" class="mt-8 text-xl leading-7 text-zinc-300 md:text-2xl">
                    {{ $this->about->hero_subtitle ?: 'Développeur web passionné, spécialisé TALL stack, React, Inertia.js et Filament.' }}
                </p>

                <div x-ref="buttons" class="mt-10 flex flex-col sm:flex-row items-center gap-5">
                    <a href="{{ route('projects.index') }}" wire:navigate
                        class="group relative inline-flex h-14 items-center justify-center border border-emerald-600 bg-emerald-600 px-8 font-semibold text-white transition-all duration-300 hover:bg-emerald-700 hover:border-emerald-700 active:scale-[0.97] text-lg">
                        <span class="flex items-center gap-2.5">
                            Découvrir mes projets
                            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>
                    <a href="{{ route('contact') }}" wire:navigate
                        class="group relative inline-flex h-14 items-center justify-center border border-white/30 bg-white/10 backdrop-blur-sm px-8 font-semibold text-white transition-all duration-300 hover:bg-white/20 active:scale-[0.97] text-lg">
                        <span class="flex items-center gap-2.5">
                            Me contacter
                            <svg class="h-5 w-5 transition-transform group-hover:translate-x-1.5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </span>
                    </a>
                </div>

                {{-- Liens sociaux – Version claire et lisible --}}
                <div wire:cloak x-data="{}" class="block">
                    <div x-data="{}" x-init="$nextTick(() => {
                        if (!$refs.socialHeader) return;
                        const tl = gsap.timeline({
                            scrollTrigger: {
                                trigger: $refs.socialHeader,
                                start: 'top bottom-=150px',
                            },
                        });
                        if ($refs.social_1) tl.fromTo($refs.social_1, { autoAlpha: 0, y: -20 }, { autoAlpha: 1, y: 0, duration: 0.6, ease: 'circ.out' });
                        if ($refs.social_2) tl.fromTo($refs.social_2, { autoAlpha: 0, x: -20, y: 20 }, { autoAlpha: 1, x: 0, y: 0, duration: 0.6, ease: 'circ.out' }, '>-0.5');
                        if ($refs.social_3) tl.fromTo($refs.social_3, { autoAlpha: 0, y: 20 }, { autoAlpha: 1, y: 0, duration: 0.6, ease: 'circ.out' }, '>-0.5');
                        if ($refs.social_4) tl.fromTo($refs.social_4, { autoAlpha: 0, x: 20, y: 20 }, { autoAlpha: 1, x: 0, y: 0, duration: 0.6, ease: 'circ.out' }, '>-0.5');
                        if ($refs.social_5) tl.fromTo($refs.social_5, { autoAlpha: 0, y: 20 }, { autoAlpha: 1, y: 0, duration: 0.6, ease: 'circ.out' }, '>-0.5');
                    })">
                        <ul x-ref="socialHeader"
                            class="flex items-center my-8 space-x-2 sm:space-x-2 justify-center lg:justify-start">

                            {{-- Facebook --}}
                            @if ($this->settings->facebook_url)
                                <li x-ref="social_1" class="group relative flex flex-col items-center">
                                    <a href="{{ $this->settings->facebook_url }}" target="_blank" rel="noopener"
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-600/25 dark:bg-white/5 dark:hover:bg-blue-600"
                                        aria-label="Facebook">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
                                            <path
                                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                        </svg>
                                    </a>
                                    <div
                                        class="absolute top-full mt-2 flex flex-col items-center opacity-0 translate-y-1 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none">
                                        <svg class="h-3 w-3 text-emerald-400/70 rotate-180" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span class="mt-0.5 text-xs font-medium text-white/70">Facebook</span>
                                    </div>
                                </li>
                            @endif

                            {{-- Instagram --}}
                            @if ($this->settings->instagram_url)
                                <li x-ref="social_2" class="group relative flex flex-col items-center">
                                    <a href="{{ $this->settings->instagram_url }}" target="_blank" rel="noopener"
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-pink-600 hover:text-white hover:shadow-lg hover:shadow-pink-600/25 dark:bg-white/5 dark:hover:bg-pink-600"
                                        aria-label="Instagram">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
                                            <path
                                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                                        </svg>
                                    </a>
                                    <div
                                        class="absolute top-full mt-2 flex flex-col items-center opacity-0 translate-y-1 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none">
                                        <svg class="h-3 w-3 text-emerald-400/70 rotate-180" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span class="mt-0.5 text-xs font-medium text-white/70">Instagram</span>
                                    </div>
                                </li>
                            @endif

                            {{-- X (Twitter) --}}
                            @if ($this->settings->x_url)
                                <li x-ref="social_3" class="group relative flex flex-col items-center">
                                    <a href="{{ $this->settings->x_url }}" target="_blank" rel="noopener"
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-black hover:text-white hover:shadow-lg hover:shadow-black/25 dark:bg-white/5 dark:hover:bg-white dark:hover:text-black"
                                        aria-label="X (Twitter)">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
                                            <path
                                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                        </svg>
                                    </a>
                                    <div
                                        class="absolute top-full mt-2 flex flex-col items-center opacity-0 translate-y-1 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none">
                                        <svg class="h-3 w-3 text-emerald-400/70 rotate-180" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span class="mt-0.5 text-xs font-medium text-white/70">X (Twitter)</span>
                                    </div>
                                </li>
                            @endif

                            {{-- LinkedIn --}}
                            @if ($this->settings->linkedin_url)
                                <li x-ref="social_4" class="group relative flex flex-col items-center">
                                    <a href="{{ $this->settings->linkedin_url }}" target="_blank" rel="noopener"
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-blue-700 hover:text-white hover:shadow-lg hover:shadow-blue-700/25 dark:bg-white/5 dark:hover:bg-blue-700"
                                        aria-label="LinkedIn">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
                                            <path
                                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                        </svg>
                                    </a>
                                    <div
                                        class="absolute top-full mt-2 flex flex-col items-center opacity-0 translate-y-1 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none">
                                        <svg class="h-3 w-3 text-emerald-400/70 rotate-180" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span class="mt-0.5 text-xs font-medium text-white/70">LinkedIn</span>
                                    </div>
                                </li>
                            @endif

                            {{-- YouTube --}}
                            @if ($this->settings->youtube_url)
                                <li x-ref="social_5" class="group relative flex flex-col items-center">
                                    <a href="{{ $this->settings->youtube_url }}" target="_blank" rel="noopener"
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-600/25 dark:bg-white/5 dark:hover:bg-red-600"
                                        aria-label="YouTube">
                                        <svg fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
                                            <path
                                                d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                        </svg>
                                    </a>
                                    <div
                                        class="absolute top-full mt-2 flex flex-col items-center opacity-0 translate-y-1 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none">
                                        <svg class="h-3 w-3 text-emerald-400/70 rotate-180" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        <span class="mt-0.5 text-xs font-medium text-white/70">YouTube</span>
                                    </div>
                                </li>
                            @endif

                            {{-- Email --}}
                            <li x-ref="social_6" class="group relative flex flex-col items-center">
                                <a href="mailto:{{ $this->settings->email }}"
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white/80 backdrop-blur-sm transition-all duration-300 hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-500/25 dark:bg-white/5 dark:hover:bg-red-500"
                                    aria-label="Email">
                                    <svg fill="currentColor" viewBox="0 0 24 24" class="h-5 w-5">
                                        <path
                                            d="M12 12.713l-11.985-9.713h23.971l-11.986 9.713zm-5.425-1.822l-6.575-5.329v12.501l6.575-7.172zm10.85 0l6.575 7.172v-12.501l-6.575 5.329zm-1.557 1.261l-3.868 3.135-3.868-3.135-8.11 8.848h23.956l-8.11-8.848z" />
                                    </svg>
                                </a>
                                <div
                                    class="absolute top-full mt-2 flex flex-col items-center opacity-0 translate-y-1 transition-all duration-300 group-hover:opacity-100 group-hover:translate-y-0 pointer-events-none">
                                    <svg class="h-3 w-3 text-emerald-400/70 rotate-180" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                    </svg>
                                    <span class="mt-0.5 text-xs font-medium text-white/70">Email</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div x-ref="decoLine" class="mt-12 h-0.5 w-0 bg-linear-to-r from-emerald-500 to-transparent"></div>
            </div>
        </div>
    </section>
    {{-- ========== À PROPOS ========== --}}
    <section id="about" x-cloak class="relative overflow-hidden bg-white dark:bg-zinc-950 py-24">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-0 top-0 h-128 w-lg rounded-full bg-emerald-500/5 blur-[140px] transform-gpu">
            </div>
            <div class="absolute right-0 bottom-0 h-112 w-md rounded-full bg-teal-500/5 blur-[140px] transform-gpu">
            </div>
        </div>

        <div x-data="aboutQuoteReveal" class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Bloc principal --}}
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16 items-center mb-24">
                {{-- Texte --}}
                <div x-cloak class="max-w-5xl" x-data="cspState" x-intersect="shown = true">
                    <h2 class="mt-6 text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-zinc-900 dark:text-white transition-all duration-300 delay-100 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        {{ $this->about->hero_title }}
                    </h2>

                    <div class="mt-5 prose prose-lg prose-zinc dark:prose-invert max-w-none transition-all duration-300 delay-200 ease-out"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        @php $aboutBlocks = $this->about->aboutBlocks(); @endphp
                        @if (!empty($aboutBlocks))
                            @foreach ($aboutBlocks as $block)
                                @if (!empty($block['title']))
                                    {{-- <h3>{{ $block['title'] }}</h3> --}}
                                    <h2 class="mt-6 text-3xl sm:text-4xl lg:text-5xl font-semibold tracking-tight text-zinc-900 dark:text-white transition-all duration-300 delay-100 ease-out"
                                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                        {{ $block['title'] }}
                                    </h2>
                                @endif
                                @if (!empty($block['description']))
                                    @if (is_array($block['description']) && isset($block['description']['type']))
                                        {!! new \Tiptap\Editor()->setContent($block['description'])->getHTML() !!}
                                    @else
                                        {!! $block['description'] !!}
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- Image --}}
                <div x-cloak class="relative" x-data="{ shown: false }" x-intersect="shown = true">
                    <div class="relative overflow-hidden transition-all duration-500 delay-300 ease-out"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                        @php $aboutImage = $aboutBlocks[0]['image_url'] ?? $this->about->about_image_url ?? null; @endphp
                        <img loading="eager" decoding="async"
                            src="{{ $aboutImage ? $this->imageUrl($aboutImage) : $this->imageUrl('images/gaudev-logo.png') }}"
                            alt="Gauthier Lobanga" class="w-full h-full object-contain aspect-4/3" />
                    </div>
                    <div class="absolute -bottom-6 -left-6 -z-10 transition-all duration-500 delay-500 ease-out"
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

            {{-- Vision --}}
            @php $visionBlocks = $this->about->visionBlocks(); @endphp
            <div x-cloak x-data="cspState" x-intersect="shown = true"
                class="mt-20 grid gap-12 lg:grid-cols-2 lg:items-center overflow-hidden">
                <div class="relative order-2 lg:order-1 transition-all duration-1200 ease-out delay-100"
                    :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-16'">
                    <div class="overflow-hidden">
                        @php $visionImage = $visionBlocks[0]['image_url'] ?? $this->about->about_image_url ?? null; @endphp
                        <img loading="eager" decoding="async"
                            src="{{ $visionImage ? $this->imageUrl($visionImage) : $this->imageUrl('images/gauthier-lobanga.jpg') }}"
                            alt="Vision" class="aspect-4/3 w-full object-cover">
                    </div>
                </div>
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
                        <h3 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Ma vision</h3>
                    </div>
                    <div class="prose prose-lg prose-zinc dark:prose-invert max-w-none">
                        @if (!empty($visionBlocks))
                            @foreach ($visionBlocks as $block)
                                @if (!empty($block['title']))
                                    <h4>{{ $block['title'] }}</h4>
                                @endif
                                @if (!empty($block['description']))
                                    @if (is_array($block['description']) && isset($block['description']['type']))
                                        {!! new \Tiptap\Editor()->setContent($block['description'])->getHTML() !!}
                                    @else
                                        {!! $block['description'] !!}
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <p>Je crois fermement que le code bien écrit est un levier puissant pour résoudre des
                                problèmes réels. Mon ambition est de rendre la technologie accessible à tous, en
                                proposant des solutions sur mesure, durables et évolutives, quel que soit le budget ou
                                le secteur d’activité.</p>
                            <p>Je m’engage à rester à l’écoute, à communiquer de manière transparente et à livrer un
                                travail de qualité qui dépasse les attentes.</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Mission --}}
            @php $missionBlocks = $this->about->missionBlocks(); @endphp
            <div x-cloak x-data="cspState" x-intersect="shown = true"
                class="mt-32 grid gap-12 lg:grid-cols-2 lg:items-center overflow-hidden">
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
                        <h3 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">Ma mission</h3>
                    </div>
                    <div class="prose prose-lg prose-zinc dark:prose-invert max-w-none">
                        @if (!empty($missionBlocks))
                            @foreach ($missionBlocks as $block)
                                @if (!empty($block['title']))
                                    <h4>{{ $block['title'] }}</h4>
                                @endif
                                @if (!empty($block['description']))
                                    @if (is_array($block['description']) && isset($block['description']['type']))
                                        {!! new \Tiptap\Editor()->setContent($block['description'])->getHTML() !!}
                                    @else
                                        {!! $block['description'] !!}
                                    @endif
                                @endif
                            @endforeach
                        @else
                            <p>Ma mission est d’aider les entrepreneurs, les PME et les ONG à se digitaliser
                                efficacement. Je mets mes compétences en développement web au service de projets qui ont
                                du sens, en apportant des solutions pragmatiques, sécurisées et esthétiques.</p>
                            <p>À travers mes formations et mes articles de blog, je partage mes connaissances pour
                                contribuer à l’émergence d’une nouvelle génération de développeurs en Afrique et
                                au‑delà.</p>
                        @endif
                    </div>
                    <div class="mt-10 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('projects.index') }}" wire:navigate
                            class="inline-flex h-14 items-center justify-center border-2 border-emerald-500 bg-emerald-500 px-8 font-semibold text-white transition hover:bg-emerald-600 active:scale-[0.97]">
                            Voir mes projets
                        </a>
                        <a href="{{ route('contact') }}" wire:navigate
                            class="inline-flex h-14 items-center justify-center border border-zinc-300 dark:border-zinc-600 px-8 font-semibold text-zinc-900 dark:text-white transition hover:bg-zinc-100 dark:hover:bg-zinc-800 active:scale-[0.97]">
                            Me contacter
                        </a>
                    </div>
                </div>
                <div class="relative order-2 transition-all duration-1200 ease-out delay-300"
                    :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-16'">
                    <div class="overflow-hidden">
                        @php $missionImage = $missionBlocks[0]['image_url'] ?? $this->about->about_image_url ?? null; @endphp
                        <img loading="eager" decoding="async"
                            src="{{ $missionImage ? $this->imageUrl($missionImage) : $this->imageUrl('images/gauthier-lobanga.jpg') }}"
                            alt="Mission" class="aspect-4/3 w-full object-cover">
                    </div>
                </div>
            </div>
        </div>

        <livewire:stats.stats />
    </section>
</div>
