<?php

use Livewire\Component;
use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

new #[Layout('layouts::main')] class extends Component {
    public Post $post;
    public $likesCount = 0;
    public $isLiked = false;
    public $bookmarksCount = 0;
    public $isBookmarked = false;

    public function mount(Post $post)
    {
        $this->post = $post->load(['categories', 'media', 'user', 'tags']);

        // Système "Pro" de comptage de vues (protection par session)
        $sessionKey = 'viewed_post_' . $post->id;
        if (!session()->has($sessionKey)) {
            $this->post->increment('views_count');
            session()->put($sessionKey, true);
        }

        $this->likesCount = $post->likes()->count();
        $this->bookmarksCount = $post->bookmarkedBy()->count();

        if ($user = Auth::user()) {
            $this->isLiked = $post->isLikedBy($user);
            $this->isBookmarked = $post->isBookmarkedBy($user);
        }
    }
    // ===== MÉTHODE POUR LES PDF =====
    #[Computed]
    public function pdfs()
    {
        return $this->post->getMedia('attachments', ['mime_type' => 'application/pdf'])->map(
            fn($media) => [
                'url' => $media->getUrl(),
                'name' => $media->name ?? ($media->file_name ?? 'Document'),
                'size' => $media->size,
                'file_name' => $media->file_name,
            ],
        );
    }

    #[Computed]
    public function hasPdf()
    {
        return $this->post->getFirstMedia('attachments', ['mime_type' => 'application/pdf']) !== null;
    }

    public function rendering(\Illuminate\View\View $view): void
    {
        $view->title($this->post->title);

        $imageUrl = $this->post->getFirstMediaUrl('featured') ?: asset('images/cadersa-logo.png');
        $description = $this->post->getPlainTextContent(160);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $this->post->title,
            'image' => [$imageUrl],
            'datePublished' => $this->post->published_at?->toIso8601String() ?? $this->post->created_at->toIso8601String(),
            'dateModified' => $this->post->updated_at->toIso8601String(),
            'author' => [
                [
                    '@type' => 'Person',
                    'name' => $this->post->user?->name ?? 'CADERSA',
                ],
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'CADERSA ASBL',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/cadersa-logo.png'),
                ],
            ],
        ];

        $view->layoutData([
            'seoDescription' => $description,
            'seoImage' => $imageUrl,
            'seoType' => 'article',
            'seoKeywords' => $this->post->tags->pluck('name')->toArray(),
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
        ]);
    }

    #[Computed]
    public function previousPost()
    {
        return $this->post->getPreviousPublished();
    }

    #[Computed]
    public function nextPost()
    {
        return $this->post->getNextPublished();
    }

    #[Computed]
    public function relatedPosts()
    {
        return $this->post->getRelatedPosts(3);
    }

    #[Computed]
    public function galleryImages()
    {
        // Vider le cache pour cet article spécifique à chaque chargement
        Cache::forget("post_{$this->post->id}_gallery_images");

        return $this->post->gallery_images ?? [];
    }

    #[Computed]
    public function headings()
    {
        $content = $this->post->renderRichContent('content');

        if (empty($content)) {
            return [];
        }

        preg_match_all('/<h([1-3])[^>]*>(.*?)<\/h[1-3]>/i', $content, $matches);
        $headings = [];
        foreach ($matches[1] as $i => $level) {
            $text = strip_tags(html_entity_decode($matches[2][$i]));
            $id = 'heading-' . $i . '-' . Str::slug($text);
            $headings[] = ['id' => $id, 'text' => $text, 'level' => (int) $level];
        }
        return $headings;
    }

    public function like()
    {
        $user = Auth::user();
        if (!$user) {
            session()->flash('error', 'Vous devez être connecté.');
            return;
        }

        if ($this->post->isLikedBy($user)) {
            $this->post->likes()->where('user_id', $user->id)->delete();
            $this->isLiked = false;
        } else {
            $this->post->likes()->create(['user_id' => $user->id]);
            $this->isLiked = true;
        }
        $this->likesCount = $this->post->likes()->count();
    }

    public function bookmark()
    {
        $user = Auth::user();
        if (!$user) {
            session()->flash('error', 'Vous devez être connecté.');
            return;
        }

        if ($this->post->isBookmarkedBy($user)) {
            $this->post->bookmarkedBy()->detach($user->id);
            $this->isBookmarked = false;
        } else {
            $this->post->bookmarkedBy()->attach($user->id);
            $this->isBookmarked = true;
        }
        $this->bookmarksCount = $this->post->bookmarkedBy()->count();
    }
};
?>

<div class="min-h-screen bg-white dark:bg-zinc-950">
    {{-- Barre de progression de lecture --}}
    <div x-data="{ progress: 0 }" x-init="window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        progress = docHeight > 0 ? Math.min(100, (scrollTop / docHeight) * 100) : 0
    })"
        class="fixed top-0 left-0 z-50 h-0.5 w-full bg-zinc-200 dark:bg-zinc-800">
        <div class="h-full bg-emerald-500 transition-all duration-150" :style="{ width: progress + '%' }"></div>
    </div>

    {{-- Fil d'Ariane --}}
    <div class="mx-auto max-w-7xl px-6 lg:px-8 py-4">
        <nav aria-label="Fil d'Ariane" class="flex items-center gap-1.5 text-sm">
            {{-- Accueil --}}
            <a href="{{ route('home') }}" wire:navigate
                class="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-zinc-500 transition-all duration-200
                  hover:bg-emerald-50 hover:text-emerald-600
                  dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1" />
                </svg>
                <span>Accueil</span>
            </a>

            {{-- Séparateur --}}
            <svg class="h-4 w-4 shrink-0 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>

            {{-- Blog --}}
            <a href="{{ route('posts.index') }}" wire:navigate
                class="rounded-lg px-2.5 py-1.5 text-zinc-500 transition-all duration-200
                  hover:bg-emerald-50 hover:text-emerald-600
                  dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400">
                Blog
            </a>

            {{-- Séparateur --}}
            <svg class="h-4 w-4 shrink-0 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>

            {{-- Titre de l'article (page courante, non cliquable) --}}
            <span class="max-w-xs truncate rounded-lg px-2.5 py-1.5 font-medium text-zinc-900 dark:text-white"
                aria-current="page">
                {{ $post->title }}
            </span>
        </nav>
    </div>

    {{-- Hero --}}
    <section class="relative flex min-h-[75vh] items-end pb-16 lg:pb-24 overflow-hidden bg-zinc-900">
        @if ($post->hasMedia('featured'))
            <img src="{{ $post->getFirstMediaUrl('featured') }}" alt="{{ $post->title }}"
                class="absolute inset-0 h-full w-full object-cover opacity-30 dark:opacity-20">
        @endif
        {{-- Overlay plus doux, dégradé vertical accentué en bas --}}
        <div class="absolute inset-0 bg-linear-to-t from-zinc-950 via-zinc-950/60 to-zinc-900/20"></div>

        <div class="relative z-10 mx-auto w-full max-w-5xl px-6 lg:px-8" x-data="{ shown: false }"
            x-intersect="shown = true">
            <div class="flex flex-col items-center text-center lg:items-start lg:text-left">
                {{-- Badge catégorie --}}
                @if ($post->categories->isNotEmpty())
                    <span
                        class="mb-8 inline-flex items-center gap-1.5 rounded-full border border-white/20 bg-white/10 px-5 py-2 text-sm font-medium text-white backdrop-blur-md transition-all duration-700"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        <svg class="h-4 w-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                        {{ $post->categories->first()->nom }}
                    </span>
                @endif

                {{-- Titre --}}
                <h1 class="max-w-4xl text-balance text-5xl font-extrabold leading-tight tracking-tight text-white sm:text-6xl lg:text-7xl font-serif transition-all duration-700 delay-100"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    {{ $post->title }}
                </h1>

                {{-- Métadonnées --}}
                <div class="mt-10 flex flex-wrap items-center justify-center gap-x-8 gap-y-3 text-base text-zinc-200 lg:justify-start transition-all duration-700 delay-200"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                    <time datetime="{{ $post->published_at?->format('Y-m-d') ?? $post->created_at->format('Y-m-d') }}"
                        class="flex items-center gap-2.5">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $post->published_at?->translatedFormat('d F Y') ?? $post->created_at->translatedFormat('d F Y') }}
                    </time>

                    @if ($post->user)
                        <span class="flex items-center gap-2.5">
                            <flux:avatar size="sm" circle src="{{ $post->user->avatar_url }}"
                                alt="{{ $post->user->name }}" />
                            {{ $post->user->name }}
                        </span>
                    @endif

                    <span class="flex items-center gap-2.5">
                        <svg class="h-5 w-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        {{ \Illuminate\Support\Number::format($post->views_count, locale: 'fr') }} vues
                    </span>
                </div>
            </div>
        </div>
    </section>

    {{-- Contenu principal avec sidebar --}}
    <div class="mx-auto max-w-7xl px-6 py-16 lg:px-8">
        <div class="grid gap-16 lg:grid-cols-12">

            {{-- Colonne principale --}}
            <div class="lg:col-span-8" x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-1000 ease-out">

                {{-- Barre d'actions flottante --}}
                <div
                    class="sticky top-20 z-20 mb-12 flex flex-wrap items-center justify-between border-0 border-zinc-200/80 bg-white/90 px-4 py-2 dark:border-zinc-800/80 dark:bg-zinc-900/90">
                    <div class="flex items-center gap-2">
                        <button wire:click="like"
                            class="group flex h-10 items-center gap-2 px-4 text-sm font-medium transition-all
                                   {{ $isLiked ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 ring-1 ring-emerald-200 dark:ring-emerald-500/30' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                            <svg class="h-5 w-5 transition-transform group-active:scale-90"
                                fill="{{ $isLiked ? 'currentColor' : 'none' }}" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                            <span>{{ $likesCount }}</span>
                        </button>
                        <div class="h-5 w-px bg-zinc-200 dark:bg-zinc-700"></div>
                        <button wire:click="bookmark"
                            class="group flex h-10 items-center gap-2 px-4 text-sm font-medium transition-all
                                   {{ $isBookmarked ? 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 ring-1 ring-amber-200 dark:ring-amber-500/30' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                            <svg class="h-5 w-5 transition-transform group-active:scale-90"
                                fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            <span>{{ $bookmarksCount }}</span>
                        </button>
                    </div>
                    <button @click="share()"
                        class="flex h-10 items-center gap-2 bg-zinc-900 px-5 text-sm font-medium text-white transition-all hover:bg-emerald-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-emerald-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="hidden sm:inline">Partager</span>
                    </button>
                </div>

                @if ($post->excerpt)
                    <div
                        class="mb-10 fi-prose max-w-none text-2xl font-light leading-relaxed text-slate-600 dark:text-slate-300">
                        {!! $post->renderRichContent('excerpt') !!}
                    </div>
                @endif
                {{-- Galerie d'images --}}
                @if (count($this->galleryImages) > 0)
                    <div x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="mt-16 transition-all duration-700 ease-out">

                        <div
                            class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                            <h3 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Galerie média
                            </h3>
                            <span class="text-sm text-zinc-500 dark:text-zinc-400">
                                {{ count($this->galleryImages) }}
                                {{ count($this->galleryImages) > 1 ? 'médias' : 'média' }}
                            </span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3" x-data="{ open: false, active: null }">
                            @foreach ($this->galleryImages as $image)
                                <div @click="open = true; active = '{{ $image['large'] ?? ($image['medium'] ?? $image['url']) }}'"
                                    class="group cursor-zoom-in overflow-hidden border border-zinc-200/50 bg-zinc-100 transition-all duration-300 hover:border-emerald-300 dark:border-zinc-700/50 dark:bg-zinc-800 dark:hover:border-emerald-700">
                                    <img src="{{ $image['medium'] ?? ($image['small'] ?? $image['url']) }}"
                                        alt="{{ $image['alt_text'] ?? $post->title }}"
                                        class="aspect-square w-full object-cover transition-transform duration-700 group-hover:scale-105"
                                        loading="lazy">
                                </div>
                            @endforeach

                            {{-- Lightbox --}}
                            <template x-teleport="body">
                                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-100 flex items-center justify-center bg-zinc-950/90 p-4 sm:p-6"
                                    @keydown.escape.window="open = false" x-cloak>

                                    <div class="absolute inset-0" @click="open = false"></div>

                                    <button @click="open = false"
                                        class="absolute right-6 top-6 z-10 flex h-12 w-12 items-center justify-center bg-white/10 text-white transition hover:bg-white/20 hover:scale-105">
                                        <svg class="h-6 w-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    <div class="relative z-0 mx-auto max-h-full max-w-7xl" x-show="open"
                                        x-transition:enter="transition ease-out duration-400 delay-100"
                                        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-200"
                                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 scale-95 translate-y-4">
                                        <img :src="active" class="max-h-[85vh] w-auto object-contain"
                                            @click.stop="">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                @endif

                <div class="fi-prose max-w-none w-full">
                    {!! $post->renderRichContent('content') !!}
                </div>

                {{-- Navigation article précédent / suivant --}}
                <div class="mt-12 grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @if ($this->previousPost)
                        <a href="{{ route('posts.show', $this->previousPost) }}" wire:navigate
                            class="group flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-4 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-zinc-800 dark:bg-zinc-900">

                            <div class="flex flex-col text-left">
                                <span class="text-xs text-zinc-400">Article précédent</span>
                                <span
                                    class="text-sm font-semibold text-zinc-900 dark:text-white transition-transform duration-300 group-hover:translate-x-2">
                                    {{ \Illuminate\Support\Str::limit($this->previousPost->title, 80) }}
                                </span>
                            </div>

                            <svg class="ml-auto h-5 w-5 text-emerald-500 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    @if ($this->nextPost)
                        <a href="{{ route('posts.show', $this->nextPost) }}" wire:navigate
                            class="group flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-4 transition-transform duration-300 hover:-translate-y-1 hover:shadow-lg dark:border-zinc-800 dark:bg-zinc-900">

                            <div class="flex flex-col text-left">
                                <span class="text-xs text-zinc-400">Article suivant</span>
                                <span
                                    class="text-sm font-semibold text-zinc-900 dark:text-white transition-transform duration-300 group-hover:translate-x-2">
                                    {{ \Illuminate\Support\Str::limit($this->nextPost->title, 80) }}
                                </span>
                            </div>

                            <svg class="ml-auto h-5 w-5 text-emerald-500 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @endif
                </div>

            </div>

            {{-- Sidebar --}}
            <aside class="hidden lg:col-span-4 lg:block">
                <div class="sticky top-28 flex flex-col gap-8">

                    {{-- Carte Auteur Premium --}}
                    @if ($post->user)
                        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                            class="group relative overflow-hidden border border-zinc-200/50 bg-white/80 p-1 backdrop-blur-xl transition-all duration-500 hover:-translate-y-1 dark:border-zinc-800/60 dark:bg-zinc-900/80">
                            <div
                                class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-emerald-100/40 via-transparent to-transparent opacity-50 transition-opacity duration-700 group-hover:opacity-100 dark:from-emerald-900/20">
                            </div>

                            <div class="relative bg-white/50 px-6 pb-8 pt-8  dark:bg-zinc-900/50">
                                <div class="relative mx-auto mb-5 flex h-20 w-20 items-center justify-center">
                                    <div
                                        class="absolute inset-0 rounded-full transition-all duration-500 group-hover:bg-emerald-400/40 dark:bg-emerald-500/10">
                                    </div>
                                    <flux:avatar size="xl" circle src="{{ $post->user->avatar_url }}"
                                        alt="{{ $post->user->name }}"
                                        class="relative h-20 w-20 ring-1 ring-white dark:ring-zinc-800" />
                                </div>

                                <div class="text-center">
                                    <h3 class="text-xl font-semibold tracking-tight text-zinc-900 dark:text-white">
                                        {{ $post->user->name }}
                                    </h3>
                                    <p
                                        class="mt-1 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                        Rédaction CADERSA
                                    </p>
                                    <p class="mt-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                                        Expert et contributeur passionné par le développement agricole et la sécurité
                                        alimentaire en RDC.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ==================== DOCUMENTS PDF ==================== --}}
                    @if ($post->hasPdf())
                        <div
                            class="border border-zinc-200/50 bg-zinc-50/50 p-5 backdrop-blur-lg dark:border-zinc-800/50 dark:bg-zinc-900/30">
                            <h3
                                class="mb-4 flex items-center gap-2.5 text-sm font-semibold text-zinc-900 dark:text-white">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Documents joints
                                <span class="ml-auto text-xs text-zinc-400 dark:text-zinc-500">
                                    {{ $post->getMedia('attachments', ['mime_type' => 'application/pdf'])->count() }}
                                    PDF
                                </span>
                            </h3>
                            <div class="flex flex-col gap-2">
                                @foreach ($post->getMedia('attachments', ['mime_type' => 'application/pdf']) as $pdf)
                                    <x-pdf-viewer :pdfUrl="$pdf->getUrl()"
                                        label="{{ $pdf->name ?? ($pdf->file_name ?? 'Lire le document') }}"
                                        modalTitle="{{ $pdf->name ?? ($pdf->file_name ?? 'Document PDF') }}"
                                        buttonClass="group flex items-center gap-2.5 border border-zinc-200/50 bg-white/50 p-2.5 transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-50/30 dark:border-zinc-800/50 dark:bg-zinc-900/50 dark:hover:border-emerald-700/50 dark:hover:bg-emerald-900/10">
                                        <template x-slot:icon>
                                            <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </template>
                                        <span
                                            class="flex-1 text-xs font-medium text-zinc-800 dark:text-zinc-200 truncate">{{ $pdf->name ?? ($pdf->file_name ?? 'Document') }}</span>
                                        <span
                                            class="text-2xs text-zinc-400 dark:text-zinc-500">{{ round($pdf->size / 1024) }}
                                            KB</span>
                                    </x-pdf-viewer>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Thématiques (Pills Modernes) --}}
                    @if ($post->tags && $post->tags->count() > 0)
                        <div
                            class="border border-zinc-200/50 bg-zinc-50/50 p-8 backdrop-blur-lg dark:border-zinc-800/50 dark:bg-zinc-900/30">
                            <h3
                                class="mb-5 flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-zinc-900 dark:text-white">
                                <span class="h-2 w-2 bg-emerald-500"></span>
                                Thématiques
                            </h3>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}" wire:navigate
                                        class="inline-flex items-center border border-zinc-200/80 bg-white px-3.5 py-1.5 text-xs font-medium text-zinc-600 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-md dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-zinc-300 dark:hover:border-emerald-700/80 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-300">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Newsletter CTA --}}
                    <livewire:newsletter-subscribe origin="post_show" />
                    {{-- Partager --}}
                    <div class="border border-zinc-200 bg-zinc-50/50 p-6 dark:border-zinc-800/50 dark:bg-zinc-900/30">
                        <h3
                            class="mb-4 text-center text-sm font-semibold uppercase tracking-wider text-zinc-600 dark:text-zinc-400">
                            Partager cet article
                        </h3>
                        <div class="flex items-center justify-center gap-3">
                            @php
                                $shareUrl = url()->current();
                                $shareTitle = urlencode($post->title);
                            @endphp

                            {{-- Facebook --}}
                            <a href="#"
                                @click.prevent="window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('{{ $shareUrl }}')}`, '_blank')"
                                aria-label="Partager sur Facebook" title="Facebook"
                                class="flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-600 transition-colors hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                </svg>
                            </a>

                            {{-- X --}}
                            <a href="#"
                                @click.prevent="window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent('{{ $shareUrl }}')}&text=${encodeURIComponent('{{ $shareTitle }}')}`, '_blank')"
                                aria-label="Partager sur X" title="X"
                                class="flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-600 transition-colors hover:bg-black hover:text-white hover:border-black dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="#"
                                @click.prevent="window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent('{{ $shareUrl }}')}&title=${encodeURIComponent('{{ $shareTitle }}')}`, '_blank')"
                                aria-label="Partager sur LinkedIn" title="LinkedIn"
                                class="flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-600 transition-colors hover:bg-[#0A66C2] hover:text-white hover:border-[#0A66C2] dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                                </svg>
                            </a>

                            {{-- WhatsApp --}}
                            <a href="#"
                                @click.prevent="window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent('{{ $shareTitle }} - {{ $shareUrl }}')}`, '_blank')"
                                aria-label="Partager sur WhatsApp" title="WhatsApp"
                                class="flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-600 transition-colors hover:bg-[#25D366] hover:text-white hover:border-[#25D366] dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c-.001 2.106.549 4.16 1.595 5.975L0 24l6.335-1.652c1.747.96 3.711 1.468 5.704 1.469h.004c6.58 0 11.939-5.336 11.943-11.893.002-3.181-1.238-6.173-3.466-8.475zm-8.476 19.333c-1.785-.001-3.536-.48-5.068-1.387l-.363-.214-3.766.982.999-3.655-.235-.373c-1.004-1.591-1.532-3.428-1.531-5.335.003-5.526 4.512-10.024 10.045-10.024 2.68 0 5.197 1.042 7.089 2.932 1.892 1.889 2.935 4.398 2.933 7.07-.003 5.523-4.512 10.004-10.003 10.004zm5.518-7.502c-.302-.15-1.789-.882-2.066-.983-.277-.1-.478-.15-.68.15s-.781.983-.957 1.183c-.176.2-.352.225-.654.075-1.921-.976-3.32-2.457-4.108-4.593-.075-.205.228-.182.523-.765.1-.2.05-.375-.025-.525s-.68-1.631-.932-2.233c-.246-.587-.496-.508-.68-.517-.176-.008-.377-.01-.579-.01-.2 0-.527.075-.803.375s-1.054 1.025-1.054 2.5 1.08 2.898 1.231 3.098c.15.2 2.115 3.208 5.12 4.49 2.112.903 2.87.777 3.931.625.816-.118 2.516-1.031 2.87-2.025.352-.993.352-1.844.247-2.025-.105-.175-.377-.275-.68-.425z" />
                                </svg>
                            </a>

                            {{-- Copier le lien --}}
                            <button x-data="{ copied: false }"
                                @click="
            navigator.clipboard.writeText(window.location.href).then(() => {
                copied = true;
                setTimeout(() => copied = false, 3000);
            });
        "
                                aria-label="Copier le lien" title="Copier le lien"
                                class="relative flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-600 transition-colors hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg x-show="!copied" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                                <span x-show="copied" class="text-sm font-semibold text-emerald-600">✓</span>
                            </button>

                            {{-- Email --}}
                            <a href="mailto:?subject={{ $shareTitle }}&body={{ $shareUrl }}"
                                aria-label="Partager par email" title="Email"
                                class="flex h-10 w-10 items-center justify-center border border-zinc-200 bg-white text-zinc-600 transition-colors hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-600 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </div>

    {{-- Articles connexes --}}
    @if (count($this->relatedPosts) > 0)
        <div class="border-t border-zinc-200 bg-zinc-50/40 py-12 dark:border-zinc-800 dark:bg-zinc-950/50">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <h2 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">Articles similaires</h2>

                <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->relatedPosts as $related)
                        <a wire:navigate href="{{ route('posts.show', $related->slug) }}"
                            class="gsap-reveal group relative flex flex-col border border-zinc-200/50 bg-white transition-all duration-500 ease-out
                               hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                               dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20"
                            aria-label="{{ $related->title }}">

                            {{-- Image --}}
                            <div
                                class="relative overflow-hidden ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
                                @if ($related->hasMedia('featured'))
                                    <img src="{{ $related->getFirstMediaUrl('featured', 'card') }}"
                                        alt="{{ $related->title }}"
                                        class="aspect-video w-full object-cover transition duration-700 ease-out group-hover:scale-105"
                                        loading="lazy" />
                                @else
                                    <div
                                        class="flex aspect-video w-full items-center justify-center bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                        <svg class="h-12 w-12" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Corps de la carte --}}
                            <div class="flex flex-1 flex-col gap-2 p-4">
                                {{-- Titre avec losange animé --}}
                                <div
                                    class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                                    <div x-data="{
                                        init() {
                                            const tweens = [];
                                            let playing = false;
                                            const rotatingEl = $el.querySelector('[data-rotating]');
                                            const rotate = () => {
                                                gsap.to(rotatingEl, {
                                                    rotation: '+=60',
                                                    duration: 0.5,
                                                    ease: 'sine.out',
                                                    onComplete: () => { if (playing) gsap.delayedCall(0.5, rotate); },
                                                });
                                            };
                                            const boxes = $el.querySelectorAll('[data-box]');
                                            const delays = [0, 0.2, 0.1];
                                            boxes.forEach((box, i) => {
                                                tweens.push(
                                                    gsap.to(box, {
                                                        opacity: 0.3,
                                                        repeat: -1,
                                                        yoyo: true,
                                                        duration: 0.4,
                                                        delay: delays[i] || 0,
                                                        ease: 'power1.inOut',
                                                        paused: true,
                                                    })
                                                );
                                            });
                                            const group = $el.closest('.group');
                                            if (group) {
                                                group.addEventListener('mouseenter', () => {
                                                    playing = true;
                                                    tweens.forEach((t) => t.resume());
                                                    rotate();
                                                });
                                                group.addEventListener('mouseleave', () => {
                                                    playing = false;
                                                    tweens.forEach((t) => t.pause());
                                                });
                                            }
                                        }
                                    }" class="absolute top-1/2 -left-4 -translate-y-1/2">
                                        <div
                                            class="translate-x-0.5 opacity-0 transition duration-300 ease-out will-change-transform group-hover:translate-x-0 group-hover:opacity-100">
                                            <div data-rotating class="flex items-center gap-0.75">
                                                <div class="flex flex-col gap-1">
                                                    <div data-box class="size-0.75 bg-current"></div>
                                                    <div data-box class="size-0.75 bg-current"></div>
                                                </div>
                                                <div data-box class="size-0.75 bg-current"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <p
                                        class="line-clamp-1 font-outfit font-medium text-zinc-900 transition-colors duration-300
                                          group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                        {{ $related->title }}
                                    </p>
                                </div>

                                {{-- Extrait --}}
                                <p class="line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $related->getPlainTextContent(100) }}
                                </p>

                                {{-- Métadonnées : catégorie + date --}}
                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400 flex items-center gap-1">
                                        @if ($related->categories->isNotEmpty())
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full border border-zinc-200/60 bg-white px-2 py-0.5 text-xs font-medium dark:border-zinc-700 dark:bg-zinc-800">
                                                {{ $related->categories->first()->nom }}
                                            </span>
                                        @endif
                                    </span>
                                    <time class="text-sm text-zinc-500 dark:text-zinc-400">
                                        {{ $related->published_at?->translatedFormat('d F Y') ?? $related->created_at->translatedFormat('d F Y') }}
                                    </time>
                                </div>
                            </div>

                            {{-- Barre d'action : "Lire" avec fond émeraude --}}
                            <div class="flex h-11 items-stretch text-sm font-medium">
                                <div
                                    class="inline-flex grow items-center justify-between gap-3 px-4
                                        bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out
                                        group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                                    <span>Lire l'article</span>
                                    <span class="transition duration-300 ease-out group-hover:translate-x-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3" viewBox="0 0 28 22"
                                            fill="none">
                                            <path class="fill-current"
                                                d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ==================== SECTION COMMENTAIRES ==================== --}}
    @if (isset($post) && method_exists($post, 'comments'))
        <section class="bg-white py-8 antialiased lg:py-16 dark:bg-zinc-950">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-zinc-900 lg:text-2xl dark:text-white">
                        Discussion
                    </h2>
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        {{ $post->comments_count ?? 0 }}
                    </span>
                </div>

                <livewire:comments.comments commentableType="App\Models\Post" :commentableId="$post->id" />
            </div>
        </section>
    @endif

    {{-- Bouton retour en haut --}}
    <button x-data="{ visible: false }" x-init="window.addEventListener('scroll', () => { visible = window.scrollY > 500 })" x-show="visible"
        @click="window.scrollTo({top:0,behavior:'smooth'})"
        class="fixed bottom-6 right-6 z-50 flex h-10 w-10 items-center justify-center rounded-full border border-zinc-200 bg-white text-zinc-600 shadow-lg transition hover:bg-emerald-50 hover:text-emerald-600 dark:border-zinc-800 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-emerald-950/30 dark:hover:text-emerald-400">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
        </svg>
    </button>

    {{-- Script de partage --}}
    <script>
        function share() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $post->title }}',
                    text: '{{ $post->getPlainTextContent(150) }}',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Lien copié !');
            }
        }
    </script>
</div>
