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
            'logo' => asset('images/logo.png'),
            'description' => "CADERSA accompagne les communautés rurales et périurbaines à travers des projets agricoles, sociaux et environnementaux.",
            'sameAs' => [
                'https://facebook.com/cadersa',
                'https://twitter.com/cadersa',
                'https://linkedin.com/company/cadersa'
            ]
        ];

        $view->layoutData([
            'seoDescription' => "CADERSA (Cercle d'Actions pour le Développement Économique et Social de la Région) accompagne les communautés rurales et périurbaines à travers des projets agricoles, sociaux et environnementaux.",
            'seoKeywords' => ['CADERSA', 'ASBL', 'RDC', 'développement rural', 'agriculture', 'environnement', 'social', 'Goma'],
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>'
        ]);
    }
};
?>

<div class="bg-white text-zinc-700 antialiased dark:bg-zinc-950 dark:text-zinc-300">

    {{-- ==================== HERO (Accueil) ==================== --}}
    <section x-cloak class="relative flex min-h-[95svh] items-center overflow-hidden" x-data="{
        init() {
            const tl = gsap.timeline({
                scrollTrigger: {
                    trigger: $el,
                    start: 'top 80%',
                    once: true,
                },
            });
    
            // Zoom subtle image de fond
            tl.from($refs.bgImage, { scale: 1.1, duration: 2.5, ease: 'power3.out' }, 0);
    
            const quoteSplit = new SplitText($refs.quote, { type: 'words' });
            
            tl.from($refs.badge, { opacity: 0, y: 20, duration: 0.4, ease: 'power2.out' }, 0)
              .from(quoteSplit.words, { opacity: 0, y: 20, duration: 0.4, stagger: 0.015, ease: 'back.out(1.2)' }, '-=0.2')
              .from($refs.author, { opacity: 0, y: 10, duration: 0.4, ease: 'power2.out' }, '-=0.3')
              .from($refs.subtitle, { opacity: 0, y: 15, duration: 0.4, ease: 'power2.out' }, '-=0.3')
              .from($refs.buttons, { opacity: 0, y: 15, duration: 0.5, ease: 'power2.out' }, '-=0.2');
        }
    }">
        {{-- Image d’arrière‑plan adoucie --}}
        @php
            $heroImage = $this->about->hero_image_url
                ? Storage::url($this->about->hero_image_url)
                : 'https://images.unsplash.com/photo-1595804470216-9d32d0ff05e6?q=80&w=1200&auto=format&fit=crop';
        @endphp

        {{-- Background dynamique --}}
        <div class="absolute inset-0">
            <img x-ref="bgImage" src="{{ $heroImage }}" alt="Paysage rural de la RDC" class="h-full w-full object-cover origin-center" />
            <div class="absolute inset-0 bg-linear-to-br from-zinc-950/90 via-zinc-900/70 to-emerald-950/70"></div>
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,.20),transparent_45%)]">
            </div>
            <div
                class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_right,rgba(255,255,255,.08),transparent_35%)]">
            </div>
        </div>

        {{-- Contenu --}}
        <div class="relative z-10 mx-auto w-full max-w-7xl px-6 py-20 lg:px-12">
            <div class="max-w-4xl text-left">

                {{-- Badge --}}
                <span x-ref="badge"
                    class="inline-flex items-center rounded-full border border-emerald-400/30 bg-emerald-500/20 px-4 py-1.5 text-sm font-medium text-emerald-200 backdrop-blur-sm">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    {{ $this->about->hero_badge ?? 'Depuis 2010' }}
                </span>

                {{-- Citation inspirante --}}
                <h1 x-ref="quote"
                    class="mt-6 text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
                    « Vivre c’est reconnaître ses semblables créés à l’image de Dieu. Les aider à s’organiser pour
                    s’autonomiser »
                </h1>

                {{-- Auteur --}}
                <p x-ref="author" class="mt-4 text-xl font-semibold text-emerald-300">
                    — Prof. Dr Bernard HANGI
                </p>

                {{-- Sous‑titre --}}
                <p x-ref="subtitle" class="mt-6 text-lg leading-relaxed text-zinc-300">
                    {{ $this->about->hero_subtitle ?? 'CADERSA accompagne les communautés rurales pour renforcer leur résilience et leur sécurité alimentaire.' }}
                </p>

                {{-- Boutons CTA --}}
                <div x-ref="buttons" class="mt-10 flex flex-wrap gap-4">
                    {{-- Bouton plein "Découvrir nos projets" --}}
                    <div x-cloak x-data="{
                        init() {
                            this.$nextTick(() => {
                                const btn = $el.querySelector('a');
                                const textWrapper = btn.querySelector('[data-text]');
                                btn.style.width = btn.offsetWidth + 'px';
                                const split = new SplitText(textWrapper, { type: 'chars' });
                                const chars = split.chars;
                                const tl = gsap.timeline({ paused: true });
                                // Animation des lettres : opacité réduite → pleine, et léger soulèvement
                                tl.fromTo(chars, { opacity: 0.7, y: 0 }, { opacity: 1, y: -2, duration: 0.25, ease: 'power2.out', stagger: 0.03 });
                                btn.addEventListener('mouseenter', () => tl.play());
                                btn.addEventListener('mouseleave', () => tl.reverse());
                            });
                        }
                    }">
                        <a href="{{ route('projects.index') }}" wire:navigate
                            class="group relative flex h-14 w-60 items-center justify-center rounded-full bg-emerald-600 px-8 font-semibold text-white shadow-lg shadow-emerald-900/50 transition-all duration-300 hover:bg-emerald-500 hover:shadow-xl hover:shadow-emerald-800/50">
                            <span class="relative z-10 whitespace-nowrap" data-text>Découvrir nos projets</span>
                        </a>
                    </div>

                    {{-- Bouton outline "En savoir plus" --}}
                    <div x-cloak x-data="{
                        init() {
                            this.$nextTick(() => {
                                const btn = $el.querySelector('a');
                                const textWrapper = btn.querySelector('[data-text]');
                                const arrow = btn.querySelector('[data-arrow]');
                                const mailIcon = btn.querySelector('[data-mail-icon]');
                                btn.style.width = btn.offsetWidth + 'px';
                                const split = new SplitText(textWrapper, { type: 'chars' });
                                const chars = split.chars;
                                const tl = gsap.timeline({ paused: true });
                                tl.to(arrow, { x: 50, opacity: 0, duration: 0.2, ease: 'circ.in' }, 0);
                                tl.fromTo(mailIcon, { x: -30, opacity: 0 }, { x: -6, opacity: 1, duration: 0.2, ease: 'circ.out' }, 0.15);
                                tl.to(textWrapper, { x: 26, duration: 0.2, ease: 'sine.out' }, 0.1);
                                tl.to(chars, { keyframes: { opacity: [1, 0.4, 1] }, duration: 0.15, ease: 'sine.inOut', stagger: 0.02 }, 0.1);
                                btn.addEventListener('mouseenter', () => tl.play());
                                btn.addEventListener('mouseleave', () => tl.reverse());
                            });
                        }
                    }">
                        <a href="{{ route('about') }}" wire:navigate
                            class="relative flex h-14 w-52 items-center justify-center gap-2 overflow-hidden rounded-full border border-white/20 bg-white/10 px-5 font-semibold text-white backdrop-blur-md transition-all duration-300 hover:bg-white/20 hover:shadow-lg">
                            <svg data-mail-icon class="absolute left-5 h-4.5 shrink-0 opacity-0"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                            <span class="whitespace-nowrap" data-text>En savoir plus</span>
                            <svg xmlns="http://www.w3.org/2000/svg" data-arrow class="h-3.25 shrink-0"
                                aria-hidden="true" viewBox="0 0 28 22" fill="none">
                                <path class="fill-current"
                                    d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                            </svg>
                        </a>
                    </div>
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
