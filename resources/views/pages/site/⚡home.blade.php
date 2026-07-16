<?php

use Livewire\Component;
use App\Models\Service;
use App\Models\Project;
use App\Models\Post;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Cache;
use App\Settings\AboutSettings;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts::main')] class extends Component {
    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }

    #[Computed]
    public function projects()
    {
        return Cache::remember(
            'home_projects',
            3600,
            fn() => Project::with('media')
                ->active()
                ->whereIn('status', ['ongoing', 'completed'])
                ->latest('start_date')
                ->limit(3)
                ->get(),
        );
    }

    #[Computed]
    public function posts()
    {
        return Cache::remember(
            'home_posts',
            3600,
            fn() => Post::with(['user', 'categories'])
                ->published()
                ->latest('published_at')
                ->limit(3)
                ->get(),
        );
    }

    #[Computed]
    public function testimonials()
    {
        return Cache::remember('home_testimonials', 3600, fn() => Testimonial::active()->latest()->limit(3)->get());
    }

    #[Computed]
    public function stats()
    {
        return Cache::remember(
            'home_stats',
            7200,
            fn() => [
                'projects' => Project::active()->count(),
                'posts' => Post::published()->count(),
                'testimonials' => Testimonial::active()->count(),
                'services' => Service::active()->count(),
            ],
        );
    }

    public function rendering(\Illuminate\View\View $view): void
    {
        $view->title('Accueil');

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NGO',
            'name' => 'CADERSA ASBL',
            'url' => url('/'),
            'logo' => asset('images/cadersa-logo.png'),
            'description' => 'CADERSA accompagne les communautés rurales et périurbaines à travers des projets agricoles, sociaux et environnementaux.',
            'sameAs' => ['https://facebook.com/cadersa', 'https://twitter.com/cadersa', 'https://linkedin.com/company/cadersa'],
        ];

        $view->layoutData([
            'seoDescription' => "CADERSA (Cercle d'Actions pour le Développement Économique et Social de la Région) accompagne les communautés rurales et périurbaines à travers des projets agricoles, sociaux et environnementaux.",
            'seoKeywords' => ['CADERSA', 'ASBL', 'RDC', 'développement rural', 'agriculture', 'environnement', 'social', 'Goma'],
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
        ]);
    }
};
?>

<div class="bg-white text-zinc-700 antialiased dark:bg-zinc-950 dark:text-zinc-300">


    <section x-cloak class="relative isolate overflow-hidden" x-data="{
        init: function() {
            const tl = gsap.timeline({ defaults: { ease: 'expo.out', duration: 1.2 } });

            // Background image slight zoom
            tl.from($refs.bgImage, { scale: 1.1, duration: 2.5, ease: 'power3.out' }, 0);

            // Splits
            const authorSplit = new SplitText($refs.author, { type: 'words' });

            // Staggered reveal for text elements
            tl.from($refs.badge, { y: 40, opacity: 0 }, 0.3)
                .from($refs.buttons, { opacity: 0, y: 15, duration: 0.4, ease: 'power2.out' }, '-=0.15')
                .from(authorSplit.words, { opacity: 0, y: 10, stagger: 0.02, duration: 0.35, ease: 'power2.out' }, '-=0.25')
                .from($refs.title, { y: 50, opacity: 0 }, 0.5)
                .from($refs.subtitle, { y: 30, opacity: 0 }, 0.7)
                .from($refs.cta, { y: 30, opacity: 0 }, 0.9);
        }
    }">
        {{-- Image de fond --}}
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
                        class="group relative inline-flex h-14 items-center justify-center border border-white/20 px-8 font-semibold text-white transition-all duration-300 hover:bg-white/10 hover:border-white/40 active:scale-[0.97]">
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

    {{-- Section service --}}
    <livewire:service.service />

    {{-- Section formations --}}
    <livewire:formation />

    {{-- Section equipe --}}
    <livewire:equipe.equipe />

    {{-- Section partener --}}
    <livewire:partener.partener />

</div>
