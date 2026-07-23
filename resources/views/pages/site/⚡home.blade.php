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
use App\Settings\SettingApp;
use Illuminate\Support\Facades\Storage;
use App\Concerns\Traits\HasImageUrl;

new #[Layout('layouts::main')] class extends Component {
    use HasImageUrl;

    public array $socialLinks = [];

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
            fn() => Post::with(['user', 'categories', 'media'])
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

        // Récupération des réseaux sociaux pour le schema
        $settings = $this->settings;
        $sameAs = array_filter([$settings->facebook_url, $settings->instagram_url, $settings->x_url, $settings->linkedin_url, $settings->youtube_url]);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => '',
            'url' => url('/'),
            'image' => $this->about->hero_image_url ? $this->imageUrl($this->about->hero_image_url) : $this->imageUrl('images/cadersa-logo.png'),
            'description' => ' – Développeur Web Full‑Stack spécialisé Laravel, TALL stack (Tailwind CSS, Alpine.js, Livewire, Laravel), React (Starter Kit) et Inertia.js. Architecture moderne avec Filament, API robustes et interfaces performantes. Découvrez mon portfolio, mes projets et mon savoir‑faire.',
            'sameAs' => $sameAs,
        ];

        $view->layoutData([
            'seoDescription' => ' – Développeur Web Full‑Stack spécialisé Laravel, TALL stack (Tailwind CSS, Alpine.js, Livewire, Laravel), React (Starter Kit) et Inertia.js. Bienvenue sur mon portfolio professionnel.',
            'seoKeywords' => ['', 'portfolio', 'développeur web', 'TALL stack', 'Filament', 'Laravel', 'Livewire', 'RDC', 'React', 'Inertia.js', 'développement web', 'projets web', 'services web', 'front-end', 'back-end', 'full-stack', 'web design', 'web development', 'web applications', 'web solutions', 'web services', 'formation web', 'web tutorials', 'web resources', 'web technologies', 'web programming', 'web frameworks', 'web tools', 'web optimization', 'web performance', 'web security', 'web accessibility'],
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
        ]);
    }

    protected function buildSocialLinks(SettingApp $settings): array
    {
        $links = [];
        if ($settings->facebook_url) {
            $links['facebook'] = $settings->facebook_url;
        }
        if ($settings->x_url) {
            $links['x'] = $settings->x_url;
        }
        if ($settings->linkedin_url) {
            $links['linkedin'] = $settings->linkedin_url;
        }
        if ($settings->instagram_url) {
            $links['instagram'] = $settings->instagram_url;
        }
        if ($settings->youtube_url) {
            $links['youtube'] = $settings->youtube_url;
        }

        return $links;
    }

    public function boot(SettingApp $appSettings): void
    {
        $this->socialLinks = $this->buildSocialLinks($appSettings);
    }
};
?>

<div class="bg-white text-zinc-700 antialiased dark:bg-zinc-950 dark:text-zinc-300">

    {{-- ========== HERO ACCUEIL UNIFIÉ – Image en arrière-plan moderne ========== --}}
    <section x-cloak class="relative overflow-hidden bg-slate-900 dark:bg-zinc-950 min-h-[80svh] flex items-center"
        x-data="homeHeroReveal">
        @php
            $heroImage = $this->about->hero_image_url
                ? $this->imageUrl($this->about->hero_image_url)
                : $this->imageUrl('images/cadersa-logo.png');
            $settings = $this->settings;
        @endphp

        {{-- Image en arrière-plan avec overlay --}}
        <div class="absolute inset-0 z-0">
            <img x-ref="bgImage" src="{{ $heroImage }}" alt=""
                class="absolute inset-0 w-full h-full object-cover object-center" loading="eager" fetchpriority="high" />
            {{-- Overlay : dégradé sombre pour la lisibilité --}}
            <div
                class="absolute inset-0 bg-linear-to-r from-slate-900/90 via-slate-900/70 to-slate-900/40 dark:from-zinc-950 dark:via-zinc-950/95 dark:to-zinc-950/80">
            </div>
            {{-- Effet supplémentaire de halo lumineux autour de l'image --}}
            <div class="absolute inset-0 bg-emerald-500/10 dark:bg-emerald-400/10 blur-3xl"></div>
        </div>

        {{-- Contenu texte (par-dessus l'image) --}}
        <div x-data="{ shown: false }" x-intersect="shown = true"
            :class="{ 'opacity-100 translate-y-0': shown, 'opacity-0 translate-y-6': !shown }"
            class="relative z-10 w-full max-w-7xl mx-auto px-6 py-12 lg:py-16 lg:px-12 transition duration-500 ease-out opacity-0 translate-y-6">
            <div class="w-full max-w-3xl">
                <h1 x-ref="title"
                    class="text-4xl sm:text-5xl lg:text-6xl font-extrabold font-['Plus_Jakarta_Sans'] tracking-tight text-white leading-tight">
                    {{ $this->about->hero_title }}
                </h1>

                <div x-ref="author" class="mt-4 flex items-center gap-3">
                    <div class="h-px w-16 bg-emerald-500/80"></div>
                    <p
                        class="text-2xl font-extrabold font-['Plus_Jakarta_Sans'] tracking-tight text-emerald-300 lg:text-3xl">
                        {{ $this->about->author_home ?: '' }}
                    </p>
                    <div class="h-px w-16 bg-emerald-500/80 hidden sm:block"></div>
                </div>

                <p x-ref="subtitle" class="mt-8 text-xl leading-relaxed text-zinc-300 md:text-2xl font-medium">
                    {{ $this->about->hero_subtitle }}
                </p>

                {{-- Boutons CTA --}}
                <div x-ref="buttons" class="mt-5 flex flex-col sm:flex-row items-start gap-5">
                    <div x-data="buttonAnimation"
                        class="rounded-full bg-emerald-600 dark:bg-emerald-500 shadow-lg shadow-emerald-500/20">
                        <a href="{{ route('projects.index') }}" wire:navigate
                            class="group inline-flex w-full items-center justify-between rounded-full font-semibold whitespace-nowrap text-white transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                            <span data-text class="grow">Découvrir mes projets</span>
                            <div data-icon
                                class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-white text-emerald-600 dark:bg-zinc-800 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25" viewBox="0 0 28 22"
                                    fill="none">
                                    <path class="fill-current"
                                        d="M1 10H5.96e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                </svg>
                            </div>
                        </a>
                    </div>

                    <div x-data="buttonAnimation"
                        class="rounded-full border-2 border-white/30 bg-white/20 backdrop-blur-sm hover:border-emerald-400 dark:border-white/20 dark:bg-black/20 dark:hover:border-emerald-600 transition-colors">
                        <a href="{{ route('about') }}" wire:navigate
                            class="group inline-flex w-full items-center justify-between rounded-full font-semibold whitespace-nowrap text-white transition duration-300 ease-out will-change-transform hover:scale-y-102 focus:outline-none focus-visible:ring focus-visible:ring-emerald-500/50 focus-visible:ring-inset h-13 gap-2.5 pr-1.25 pl-5 bg-transparent">
                            <span data-text class="grow">En savoir plus</span>
                            <div data-icon
                                class="relative isolate grid shrink-0 place-items-center overflow-hidden rounded-full size-11 bg-white/20 text-white dark:bg-zinc-800 dark:text-zinc-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.25" viewBox="0 0 28 22"
                                    fill="none">
                                    <path class="fill-current"
                                        d="M1 10H5.96e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                </svg>
                            </div>
                        </a>
                    </div>
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
                            @if ($this->settings->email)
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
                            @endif
                        </ul>
                    </div>
                </div>

                <div x-ref="decoLine" class="mt-6 h-0.5 w-0 bg-linear-to-r from-emerald-500 to-transparent"></div>
            </div>
        </div>
    </section>

    {{-- ========== SERVICES ========== --}}
    @if ($this->stats['services'] > 0)
        <livewire:service.service />
    @endif

    {{-- ========== PROJECTS ========== --}}
    @if ($this->stats['projects'] > 0)
        <livewire:projects.projects />
    @endif

    {{-- ========== FORMATIONS ========== --}}
    @php $formationCount = \App\Models\Formation::where('is_active', true)->count(); @endphp
    @if ($formationCount > 0)
        <livewire:formation />
    @endif

    {{-- ========== TESTIMONIALS ========== --}}
    @if ($this->stats['testimonials'] > 0)
        <livewire:testimonials.testimonials />
    @endif

    {{-- ========== Blog ========== --}}
    @if ($this->stats['posts'] > 0)
        <livewire:blog.blog />
    @endif

    {{-- ========== PARTENAIRES ========== --}}
    @php $partnerCount = \App\Models\Partner::active()->count(); @endphp
    @if ($partnerCount > 0)
        <livewire:partener.partener />
    @endif


    {{-- ========== STATISTIQUES et CONTACT ========== --}}
    <livewire:stats.stats />
</div>
