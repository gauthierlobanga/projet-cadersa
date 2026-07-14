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

    {{-- ==================== HERO (Accueil) ==================== --}}
    <section x-cloak class="relative flex min-h-[95svh] items-center overflow-hidden" x-data="{
        init() {
            const tl = gsap.timeline({
                defaults: { ease: 'power2.out' },
                scrollTrigger: {
                    trigger: $el,
                    start: 'top 80%',
                    once: true,
                },
            });
    
            // Zoom image (plus rapide)
            tl.from($refs.bgImage, { scale: 1.08, duration: 1.6, ease: 'power2.out' }, 0);
    
            // Splits
            const quoteSplit = new SplitText($refs.quote, { type: 'chars' });
            const authorSplit = new SplitText($refs.author, { type: 'words' });
            const subtitleSplit = new SplitText($refs.subtitle, { type: 'lines' });
    
            // Séquence accélérée
            tl.from($refs.badge, { opacity: 0, y: 12, duration: 0.35, ease: 'power1.out' }, 0)
                .from(quoteSplit.chars, { opacity: 0, y: 25, rotateX: -10, stagger: 0.012, duration: 0.5, ease: 'back.out(1.2)' }, '-=0.15')
                .from(authorSplit.words, { opacity: 0, y: 10, stagger: 0.02, duration: 0.35, ease: 'power2.out' }, '-=0.25')
                .from(subtitleSplit.lines, { opacity: 0, y: 12, stagger: 0.04, duration: 0.4, ease: 'power2.out' }, '-=0.2')
                .from($refs.buttons, { opacity: 0, y: 15, duration: 0.4, ease: 'power2.out' }, '-=0.15')
                .from($refs.decoLine, { scaleX: 0, duration: 0.5, ease: 'power1.out' }, '-=0.1');
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

        {{-- Contenu --}}
        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 py-20 lg:px-12">
            <div class="max-w-4xl text-left">

                {{-- Badge modernisé --}}
                <span x-ref="badge"
                    class="inline-flex items-center gap-2.5 border border-emerald-400/20 bg-emerald-500/15 px-4 py-1.5 text-sm font-medium text-emerald-200 backdrop-blur-sm transition-all hover:bg-emerald-500/25">
                    <span class="relative flex h-2 w-2">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    {{ $this->about->hero_badge ?? 'Depuis 2010' }}
                </span>

                {{-- Titre avec guillemets décoratifs --}}
                <h1 x-ref="quote"
                    class="mt-6 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl leading-[1.1]">
                    <span class="block text-emerald-300 text-3xl lg:text-4xl font-serif leading-none mb-1">“</span>
                    <span class="drop-shadow-[0_2px_20px_rgba(0,0,0,0.3)]">
                        Vivre c’est reconnaître ses semblables créés à l’image de Dieu.
                    </span>
                    <span
                        class="block text-emerald-300/60 text-3xl lg:text-4xl font-serif leading-none mt-1 text-right">”</span>
                </h1>

                {{-- Auteur avec icône --}}
                <div x-ref="author" class="mt-4 flex items-center gap-3">
                    <div class="h-px w-12 bg-emerald-400/50"></div>
                    <p class="text-lg font-semibold text-emerald-300 lg:text-xl">
                        — Prof. Dr Bernard HANGI
                    </p>
                    <div class="h-px w-12 bg-emerald-400/30 hidden sm:block"></div>
                </div>

                {{-- Sous-titre --}}
                <p x-ref="subtitle"
                    class="mt-6 max-w-2xl text-base leading-relaxed text-zinc-300/90 sm:text-lg lg:text-xl drop-shadow-[0_2px_10px_rgba(0,0,0,0.2)]">
                    {{ $this->about->hero_subtitle ?? 'CADERSA accompagne les communautés rurales pour renforcer leur résilience et leur sécurité alimentaire.' }}
                </p>

                {{-- Boutons CTA --}}
                <div x-ref="buttons" class="mt-10 flex flex-wrap items-center gap-5">
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

    {{-- Section equipe --}}
    <livewire:equipe.equipe />

    {{-- Section partener --}}
    <livewire:partener.partener />

</div>
