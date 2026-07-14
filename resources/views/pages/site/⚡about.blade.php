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

    <!-- Hero Section -->
    <section class="relative isolate overflow-hidden" x-data="{
        init() {
            const tl = gsap.timeline({ defaults: { ease: 'expo.out', duration: 1.2 } });
    
            // Background image slight zoom
            tl.from($refs.bgImage, { scale: 1.1, duration: 2.5, ease: 'power3.out' }, 0);
    
            // Staggered reveal for text elements
            tl.from($refs.badge, { y: 40, opacity: 0 }, 0.3)
                .from($refs.title, { y: 50, opacity: 0 }, 0.5)
                .from($refs.subtitle, { y: 30, opacity: 0 }, 0.7)
                .from($refs.cta, { y: 30, opacity: 0 }, 0.9);
        }
    }">
        {{-- Background dynamique --}}
        <div class="absolute inset-0">
            <img x-ref="bgImage"
                src="{{ $this->about->hero_image_url ? Storage::url($this->about->hero_image_url) : asset('images/hero.png') }}"
                alt="Paysage rural de la RDC" class="h-full w-full object-cover origin-center" />

            <div class="absolute inset-0 bg-linear-to-br from-zinc-950/90 via-zinc-900/70 to-emerald-950/70"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,.20),transparent_45%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,.08),transparent_35%)]">
            </div>
        </div>

        {{-- Decorative --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-0 top-0 h-100 w-152 rounded-full bg-emerald-500/10 blur-[160px] transform-gpu">
            </div>
            <div class="absolute right-0 bottom-0 h-128 w-lg rounded-full bg-teal-500/10 blur-[160px] transform-gpu">
            </div>
        </div>

        <div class="relative mx-auto flex min-h-[90svh] max-w-7xl items-center px-6 pt-26 pb-24 lg:px-8">
            <div class="max-w-4xl">
                {{-- Badge --}}
                <div x-ref="badge"
                    class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 backdrop-blur-xl">
                    <span class="flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                    <span class="text-sm font-medium tracking-wide text-zinc-200">
                        Depuis 2010 • Plus de 15 années d'engagement
                    </span>
                </div>

                {{-- Title --}}
                <h1 x-ref="title"
                    class="mt-8 max-w-4xl text-5xl font-semibold tracking-tight text-white md:text-6xl lg:text-7xl">
                    Construire des
                    <span
                        class="bg-linear-to-r from-emerald-300 via-emerald-400 to-teal-300 bg-clip-text text-transparent">
                        villages durables
                    </span>
                    pour transformer durablement la RDC.
                </h1>

                {{-- Subtitle --}}
                <p x-ref="subtitle" class="mt-8 max-w-2xl text-lg leading-8 text-zinc-300 md:text-xl">
                    Nous accompagnons les communautés rurales et périurbaines
                    grâce à des projets agricoles, sociaux et environnementaux
                    qui améliorent durablement les conditions de vie.
                </p>

                {{-- CTA --}}
                <div x-ref="cta" class="mt-12 flex flex-col gap-4 sm:flex-row">
                    <a href="#services"
                        class="group inline-flex items-center justify-center gap-3 rounded-full bg-emerald-500 px-7 py-4 text-base font-semibold text-white transition duration-300 hover:bg-emerald-400">
                        Découvrir nos actions
                        <svg class="size-5 transition group-hover:translate-x-1" fill="none" stroke="currentColor"
                            stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6" />
                        </svg>
                    </a>
                    <a href="#impact"
                        class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-7 py-4 text-base font-medium text-white backdrop-blur-xl transition hover:bg-white/10">
                        Voir notre impact
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section id="about" class="relative overflow-hidden bg-white py-28 dark:bg-zinc-950">
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute left-0 top-0 h-128 w-lg rounded-full bg-emerald-500/5 blur-[140px] transform-gpu">
            </div>
            <div class="absolute right-0 bottom-0 h-112 w-md rounded-full bg-teal-500/5 blur-[140px] transform-gpu">
            </div>
        </div>
        <div class="relative mx-auto max-w-7xl px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:gap-16 items-center mb-24">
                {{-- En‑tête animé (Texte) --}}
                <div x-cloak class="max-w-3xl" x-data="{ shown: false }" x-intersect="shown = true">
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
                    @if ($this->about->about_text)
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
                            @if(is_array($this->about->about_text) && isset($this->about->about_text['type']))
                                {!! (new \Tiptap\Editor)->setContent($this->about->about_text)->getHTML() !!}
                            @else
                                {!! $this->about->about_text !!}
                            @endif
                        </div>
                    @endif
                </div>

                {{-- Image droite --}}
                <div x-cloak class="relative" x-data="{ shown: false }" x-intersect="shown = true">
                    <div class="relative rounded-3xl overflow-hidden transition-all duration-1000 delay-300 ease-out"
                        :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-8'">
                        <img src="{{ $this->about->about_image_url ? Storage::url($this->about->about_image_url) : 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop' }}"
                            alt="À propos de CADERSA" class="w-full object-cover aspect-4/3 rounded-3xl" />
                        <div class="absolute inset-0 rounded-3xl ring-1 ring-inset ring-zinc-900/10 dark:ring-white/10"></div>
                    </div>
                    
                    {{-- Déco SVG / Pattern --}}
                    <div class="absolute -bottom-6 -left-6 -z-10 transition-all duration-1000 delay-500 ease-out"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        <svg class="w-32 h-32 text-emerald-500/20" fill="currentColor" viewBox="0 0 100 100">
                            <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                <circle cx="2" cy="2" r="2" />
                            </pattern>
                            <rect width="100" height="100" fill="url(#dots)" />
                        </svg>
                    </div>
                    
                    {{-- Floating element --}}
                    <div class="absolute -right-4 top-1/4 rounded-2xl bg-white/90 p-4 shadow-xl backdrop-blur-sm dark:bg-zinc-900/90 transition-all duration-1000 delay-700 ease-out"
                         :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/50">
                                <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-zinc-900 dark:text-white">Impact Local</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400">Communautés engagées</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Vision Section : Image à gauche, Contenu à droite --}}
            @if ($this->about->vision_text)
                <div x-cloak x-data="{ shown: false }" x-intersect="shown = true"
                     class="mt-20 grid gap-12 lg:grid-cols-2 lg:items-center overflow-hidden">

                    {{-- Image Vision --}}
                    <div class="relative order-2 lg:order-1 transition-all duration-1200 ease-out delay-100"
                         :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-16'">
                        <div
                            class="overflow-hidden border border-zinc-200/60 shadow-sm dark:border-white/10 dark:shadow-black/20 rounded-3xl">
                            <img src="{{ $this->about->about_image_url ? Storage::url($this->about->about_image_url) : asset('images/agriculture.png') }}"
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
                            @if (is_array($this->about->vision_text) && isset($this->about->vision_text['type']))
                                {!! new \Tiptap\Editor()->setContent($this->about->vision_text)->getHTML() !!}
                            @else
                                {!! $this->about->vision_text !!}
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{-- Mission Section : Contenu à gauche, Image à droite --}}
            @if ($this->about->mission_text)
                <div x-cloak x-data="{ shown: false }" x-intersect="shown = true"
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
                            @if (is_array($this->about->mission_text) && isset($this->about->mission_text['type']))
                                {!! new \Tiptap\Editor()->setContent($this->about->mission_text)->getHTML() !!}
                            @else
                                {!! $this->about->mission_text !!}
                            @endif
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="flex flex-wrap gap-4 pt-4">
                            <a href="{{ route('about') }}"
                                class="group inline-flex items-center gap-2 rounded-full bg-zinc-900 px-6 py-3 font-medium text-white transition hover:bg-zinc-800 dark:bg-white dark:text-zinc-900">
                                Découvrir notre histoire
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 12h14m-6-6l6 6-6 6" />
                                </svg>
                            </a>
                            <a href="#services"
                                class="group inline-flex items-center rounded-full border border-zinc-300 px-6 py-3 font-medium text-zinc-700 transition hover:border-emerald-500 hover:text-emerald-600 dark:border-white/10 dark:text-zinc-300">
                                Nos domaines d'action
                            </a>
                        </div>
                    </div>

                    {{-- Image Mission --}}
                    <div class="relative order-2 transition-all duration-1200 ease-out delay-300"
                         :class="shown ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-16'">
                        <div
                            class="overflow-hidden border border-zinc-200/60 shadow-sm dark:border-white/10 dark:shadow-black/20 rounded-3xl">
                            <img src="{{ asset('images/reforestation.png') }}" alt="Mission CADERSA"
                                class="aspect-4/3 w-full object-cover">
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
            <div x-cloak class="mb-16 max-w-3xl" x-data="{ shown: false }" x-intersect="shown = true">
                <span
                    class="inline-block rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-300 backdrop-blur-sm transition-all duration-700 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Notre impact
                </span>
                <h2 class="mt-4 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl transition-all duration-700 delay-100 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Des résultats <span
                        class="bg-linear-to-r from-emerald-300 to-teal-300 bg-clip-text text-transparent">concrets</span>
                    sur le terrain
                </h2>
                <p class="mt-6 text-lg leading-8 text-zinc-300 transition-all duration-700 delay-200 ease-out"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    Programme de Résilience au Kasaï Central, avec le soutien du PAM.
                </p>
            </div>

            {{-- Statistiques --}}
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @php
                    $stats = [
                        [
                            'value' => '5 000',
                            'label' => 'Ménages Agricoles Soutenus',
                            'icon' =>
                                'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                        ],
                        [
                            'value' => '1 500',
                            'label' => 'Foyers Améliorés Confectionnés',
                            'icon' =>
                                'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        ],
                        [
                            'value' => '18 ha',
                            'label' => 'Reboisés par la Communauté',
                            'icon' => 'M12 14l9-5-9-5-9 5 9 5z',
                        ],
                        [
                            'value' => '44',
                            'label' => 'Unions Paysannes (UOP) Formées',
                            'icon' => 'M12 14l9-5-9-5-9 5 9 5z',
                        ],
                    ];
                @endphp

                @foreach ($stats as $index => $stat)
                    <div x-cloak x-data="{ shown: false, count: 0 }" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="transition-all duration-700 ease-out" style="transition-delay: {{ $index * 100 }}ms">
                        <div
                            class="gsap-reveal group relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-8 backdrop-blur-md transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500/30 hover:bg-white/10 hover:shadow-2xl hover:shadow-emerald-500/10">
                            <div
                                class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/20 text-emerald-400 transition-transform group-hover:scale-110">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ $stat['icon'] }}" />
                                </svg>
                            </div>
                            <div class="text-4xl font-black text-white">{{ $stat['value'] }}</div>
                            <div class="mt-2 text-sm font-medium text-zinc-300">{{ $stat['label'] }}</div>
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
                            <h3 class="text-2xl font-bold text-white">Renforcement de la chaîne de valeur agricole</h3>
                            <p class="mt-4 leading-relaxed text-zinc-300">
                                Dans les zones de santé de Luiza et Tshikaji, l’insécurité alimentaire conduit les
                                ménages à l’endettement. Notre projet intervient pour restructurer les capacités des
                                producteurs, faciliter l’inclusion financière (distribution de cash, activités
                                génératrices de revenus) et renforcer la cohésion sociale à travers des brigades
                                communautaires.
                            </p>
                            <ul class="mt-6 space-y-3">
                                <li class="flex items-center gap-3 text-zinc-300">
                                    <svg class="h-5 w-5 shrink-0 text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    50 Brigades communautaires créées
                                </li>
                                <li class="flex items-center gap-3 text-zinc-300">
                                    <svg class="h-5 w-5 shrink-0 text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Distribution de pompes (Kickstart) pour l’arrosage
                                </li>
                                <li class="flex items-center gap-3 text-zinc-300">
                                    <svg class="h-5 w-5 shrink-0 text-emerald-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Alphabétisation & Kits AGR distribués
                                </li>
                            </ul>
                        </div>

                        {{-- Colonne de droite --}}
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                            <h4 class="text-xl font-bold text-white">Programme Nutrition Sensible</h4>
                            <p class="mt-3 text-sm leading-relaxed text-zinc-400">
                                Redynamisation des groupes de soutien ANJE, distribution de kits de semences (jardins
                                potagers) et de petits élevages, sensibilisation communautaire contre la VBG et
                                promotion du genre.
                            </p>
                            <a href="#"
                                class="mt-6 inline-flex items-center gap-2 font-semibold text-emerald-400 transition-colors hover:text-emerald-300">
                                Lire le rapport complet
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Smooth scroll behavior script for Safari/older browsers -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</div>
