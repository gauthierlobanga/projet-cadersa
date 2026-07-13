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
        $this->post->increment('views_count');
        view()->share('title', $post->title);

        $this->likesCount = $post->likes()->count();
        $this->bookmarksCount = $post->bookmarkedBy()->count();

        if ($user = Auth::user()) {
            $this->isLiked = $post->isLikedBy($user);
            $this->isBookmarked = $post->isBookmarkedBy($user);
        }
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
    {{-- Fil d'Ariane --}}
    <div class="mx-auto max-w-7xl px-6 lg:px-8 py-4">
        <nav aria-label="Fil d'Ariane" class="flex items-center gap-1.5 text-sm">
            {{-- Accueil --}}
            <a href="{{ route('home') }}"
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
            <a href="{{ route('posts.index') }}"
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
                        {{ $post->views_count }} vues
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
                    class="sticky top-20 z-20 mb-12 flex flex-wrap items-center justify-between rounded-full border border-zinc-200/80 bg-white/90 px-4 py-2 shadow-sm backdrop-blur-xl dark:border-zinc-800/80 dark:bg-zinc-900/90">
                    <div class="flex items-center gap-2">
                        <button wire:click="like"
                            class="group flex h-10 items-center gap-2 rounded-full px-4 text-sm font-medium transition-all
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
                            class="group flex h-10 items-center gap-2 rounded-full px-4 text-sm font-medium transition-all
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
                        class="flex h-10 items-center gap-2 rounded-full bg-zinc-900 px-5 text-sm font-medium text-white transition-all hover:bg-emerald-600 hover:shadow-lg hover:shadow-emerald-500/20 dark:bg-white dark:text-zinc-900 dark:hover:bg-emerald-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span class="hidden sm:inline">Partager</span>
                    </button>
                </div>

                @if ($post->excerpt)
                    <div class="mb-10 text-2xl font-light leading-relaxed text-slate-600 dark:text-slate-300">
                        {!! $post->renderRichContent('excerpt') !!}
                    </div>
                @endif

                <div
                    class="w-full max-w-none 
            /* Text General */
            text-zinc-700 dark:text-zinc-300 text-base leading-relaxed
            
            /* Paragraphs */
            [&>p]:mb-5 [&>p]:leading-relaxed
            
            /* Headings */
            [&>h2]:text-3xl [&>h2]:font-extrabold [&>h2]:tracking-tight [&>h2]:text-zinc-900 dark:[&>h2]:text-white [&>h2]:mt-12 [&>h2]:mb-6 [&>h2]:border-b [&>h2]:border-emerald-100 dark:[&>h2]:border-emerald-900/30 [&>h2]:pb-4
            [&>h3]:text-2xl [&>h3]:font-bold [&>h3]:text-zinc-800 dark:[&>h3]:text-zinc-100 [&>h3]:mt-10 [&>h3]:mb-4
            
            /* Links */
            [&_a]:font-medium [&_a]:text-emerald-600 dark:[&_a]:text-emerald-400 [&_a]:underline [&_a]:underline-offset-4 [&_a]:decoration-emerald-200 dark:[&_a]:decoration-emerald-900 hover:[&_a]:decoration-emerald-600 dark:hover:[&_a]:decoration-emerald-400 [&_a]:transition-colors
            
            /* Blockquotes */
            [&>blockquote]:pl-6 [&>blockquote]:py-4 [&>blockquote]:my-8 [&>blockquote]:border-l-4 [&>blockquote]:border-emerald-500 [&>blockquote]:bg-gradient-to-r [&>blockquote]:from-emerald-50 [&>blockquote]:to-transparent dark:[&>blockquote]:from-emerald-900/20 [&>blockquote]:rounded-r-2xl [&>blockquote]:text-xl [&>blockquote]:italic [&>blockquote]:text-emerald-900 dark:[&>blockquote]:text-emerald-100 [&>blockquote]:font-serif
            
            /* Lists */
            [&>ul]:list-disc [&>ul]:pl-6 [&>ul]:mb-6 [&>ul]:space-y-3 [&>ul>li]:pl-2 [&>ul>li::marker]:text-emerald-500
            [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:mb-6 [&>ol]:space-y-3 [&>ol>li]:pl-2 [&>ol>li::marker]:text-emerald-500
            
            /* Images */
            [&_img]:rounded-3xl [&_img]:shadow-2xl [&_img]:my-10 [&_img]:border [&_img]:border-zinc-100 dark:[&_img]:border-zinc-800 [&_img]:mx-auto
            
            /* Bold & Strong */
            [&_strong]:font-semibold [&_strong]:text-zinc-900 dark:[&_strong]:text-white">
                    {!! $post->renderRichContent('content') !!}
                </div>
                {{-- Galerie d'images --}}
                @if (count($this->galleryImages) > 0)
                    <div class="mt-16 border-t border-zinc-100 pt-12 dark:border-zinc-800">
                        <h3 class="mb-8 text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Galerie média
                        </h3>
                        <div class="grid grid-cols-2 gap-4 md:grid-cols-3" x-data="{ open: false, active: null }">
                            @foreach ($this->galleryImages as $image)
                                <div @click="open = true; active = '{{ $image['large'] ?? ($image['medium'] ?? $image['url']) }}'"
                                    class="group cursor-zoom-in overflow-hidden rounded-2xl shadow-sm transition hover:shadow-xl">
                                    <img src="{{ $image['medium'] ?? ($image['small'] ?? $image['url']) }}"
                                        alt="{{ $image['alt_text'] ?? $post->title }}"
                                        class="aspect-square w-full object-cover transition-transform duration-700 group-hover:scale-110"
                                        loading="lazy">
                                </div>
                            @endforeach

                            {{-- Lightbox Premium --}}
                            <template x-teleport="body">
                                <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 backdrop-blur-none"
                                    x-transition:enter-end="opacity-100 backdrop-blur-xl"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 backdrop-blur-xl"
                                    x-transition:leave-end="opacity-0 backdrop-blur-none"
                                    class="fixed inset-0 z-[100] flex items-center justify-center bg-zinc-950/90 p-4 sm:p-6"
                                    @keydown.escape.window="open = false" x-cloak>

                                    <div class="absolute inset-0" @click="open = false"></div>

                                    <button @click="open = false"
                                        class="absolute right-6 top-6 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-white/10 text-white backdrop-blur-md transition hover:bg-white/20 hover:scale-110">
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
                                        <img :src="active"
                                            class="max-h-[85vh] w-auto rounded-3xl shadow-2xl shadow-black/50 object-contain ring-1 ring-white/10"
                                            @click.stop="">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar Moderne & Premium (Figma Quality) --}}
            <aside class="hidden lg:col-span-4 lg:block">
                <div class="sticky top-28 flex flex-col gap-8">

                    {{-- Carte Auteur Premium --}}
                    @if ($post->user)
                        <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                            class="group relative overflow-hidden rounded-[2rem] border border-white/60 bg-white/80 p-1 shadow-[0_8px_30px_rgb(0,0,0,0.04)] backdrop-blur-xl transition-all duration-500 hover:shadow-[0_8px_40px_rgba(16,185,129,0.08)] hover:-translate-y-1 dark:border-zinc-800/60 dark:bg-zinc-900/80">
                            {{-- Fond animé & Mesh --}}
                            <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-100/40 via-transparent to-transparent opacity-50 transition-opacity duration-700 group-hover:opacity-100 dark:from-emerald-900/20"></div>
                            
                            <div class="relative rounded-[1.75rem] border border-zinc-100/50 bg-white/50 px-6 pb-8 pt-8 dark:border-zinc-800/50 dark:bg-zinc-900/50">
                                {{-- Avatar avec glow --}}
                                <div class="relative mx-auto mb-5 flex h-20 w-20 items-center justify-center">
                                    <div class="absolute inset-0 rounded-full bg-emerald-400/20 blur-xl transition-all duration-500 group-hover:bg-emerald-400/40 dark:bg-emerald-500/10"></div>
                                    <flux:avatar size="xl" circle src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" class="relative h-20 w-20 ring-4 ring-white dark:ring-zinc-800 shadow-lg" />
                                </div>
                                
                                <div class="text-center">
                                    <h3 class="text-xl font-extrabold tracking-tight text-zinc-900 dark:text-white">
                                        {{ $post->user->name }}
                                    </h3>
                                    <p class="mt-1 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                        Rédaction CADERSA
                                    </p>
                                    <p class="mt-4 text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                                        Expert et contributeur passionné par le développement agricole et la sécurité alimentaire en RDC.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Thématiques (Pills Modernes) --}}
                    @if ($post->tags && $post->tags->count() > 0)
                        <div class="rounded-[2rem] border border-zinc-200/50 bg-zinc-50/50 p-8 shadow-sm backdrop-blur-lg dark:border-zinc-800/50 dark:bg-zinc-900/30">
                            <h3 class="mb-5 flex items-center gap-3 text-sm font-bold uppercase tracking-widest text-zinc-900 dark:text-white">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                Thématiques
                            </h3>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('posts.index', ['tag' => $tag->slug]) }}"
                                        class="inline-flex items-center rounded-full border border-zinc-200/80 bg-white px-4 py-2 text-sm font-medium text-zinc-600 shadow-sm transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-md dark:border-zinc-700/80 dark:bg-zinc-800/80 dark:text-zinc-300 dark:hover:border-emerald-700/80 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-300">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Newsletter CTA (Glass & Glow) --}}
                    <div class="group relative overflow-hidden rounded-[2rem] bg-zinc-900 p-8 shadow-2xl dark:bg-black/80 dark:border dark:border-zinc-800/80">
                        {{-- Effet de lumière interne --}}
                        <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-emerald-500/20 blur-[50px] transition-all duration-700 group-hover:bg-emerald-400/30 group-hover:blur-[60px]"></div>
                        <div class="absolute -bottom-12 -left-12 h-32 w-32 rounded-full bg-teal-500/10 blur-[40px] transition-all duration-700 group-hover:bg-teal-400/20"></div>
                        
                        <div class="relative z-10">
                            <h3 class="mb-3 text-2xl font-bold tracking-tight text-white">Restez informé</h3>
                            <p class="mb-6 text-sm leading-relaxed text-zinc-300/90">
                                Recevez nos actualités et analyses expertes directement dans votre boîte mail.
                            </p>
                            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-4" @submit.prevent>
                                @csrf
                                <div class="relative">
                                    <label for="email-sidebar" class="sr-only">Votre adresse e-mail</label>
                                    <input type="email" id="email-sidebar" name="email" placeholder="Entrez votre e-mail..." required
                                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-5 py-3.5 text-sm text-white placeholder-zinc-400 outline-none backdrop-blur-md transition-all duration-300 focus:border-emerald-500/50 focus:bg-white/10 focus:ring-4 focus:ring-emerald-500/10">
                                </div>
                                <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 px-5 py-3.5 text-sm font-bold text-white shadow-[0_4px_14px_0_rgba(16,185,129,0.39)] transition-all duration-300 hover:scale-[1.02] hover:shadow-[0_6px_20px_rgba(16,185,129,0.23)] active:scale-[0.98]">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    S'abonner maintenant
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Partager (Social Links Minimalistes) --}}
                    <div class="rounded-[2rem] border border-zinc-200/50 bg-white/50 p-8 text-center shadow-sm backdrop-blur-lg dark:border-zinc-800/50 dark:bg-zinc-900/30">
                        <h3 class="mb-5 text-sm font-bold uppercase tracking-widest text-zinc-900 dark:text-white">
                            Partager cet article
                        </h3>
                        <div class="flex justify-center gap-4">
                            @php
                                $shareUrl = url()->current();
                                $shareTitle = urlencode($post->title);
                            @endphp

                            {{-- Facebook --}}
                            <button @click="window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent('{{ $shareUrl }}')}`, '_blank')" aria-label="Partager sur Facebook"
                                class="group flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-100 text-zinc-500 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:bg-[#1877F2] hover:text-white hover:shadow-lg hover:shadow-[#1877F2]/30 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                </svg>
                            </button>

                            {{-- X (Twitter) --}}
                            <button @click="window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent('{{ $shareUrl }}')}&text=${encodeURIComponent('{{ $shareTitle }}')}`, '_blank')" aria-label="Partager sur X"
                                class="group flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-100 text-zinc-500 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:bg-black hover:text-white hover:shadow-lg dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white dark:hover:text-black">
                                <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </button>

                            {{-- LinkedIn --}}
                            <button @click="window.open(`https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent('{{ $shareUrl }}')}&title=${encodeURIComponent('{{ $shareTitle }}')}`, '_blank')" aria-label="Partager sur LinkedIn"
                                class="group flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-100 text-zinc-500 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:bg-[#0A66C2] hover:text-white hover:shadow-lg hover:shadow-[#0A66C2]/30 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                                </svg>
                            </button>

                            {{-- WhatsApp --}}
                            <button @click="window.open(`https://api.whatsapp.com/send?text=${encodeURIComponent('{{ $shareTitle }} - {{ $shareUrl }}')}`, '_blank')" aria-label="Partager sur WhatsApp"
                                class="group flex h-12 w-12 items-center justify-center rounded-2xl bg-zinc-100 text-zinc-500 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:bg-[#25D366] hover:text-white hover:shadow-lg hover:shadow-[#25D366]/30 dark:bg-zinc-800 dark:text-zinc-400">
                                <svg class="h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c-.001 2.106.549 4.16 1.595 5.975L0 24l6.335-1.652c1.747.96 3.711 1.468 5.704 1.469h.004c6.58 0 11.939-5.336 11.943-11.893.002-3.181-1.238-6.173-3.466-8.475zm-8.476 19.333c-1.785-.001-3.536-.48-5.068-1.387l-.363-.214-3.766.982.999-3.655-.235-.373c-1.004-1.591-1.532-3.428-1.531-5.335.003-5.526 4.512-10.024 10.045-10.024 2.68 0 5.197 1.042 7.089 2.932 1.892 1.889 2.935 4.398 2.933 7.07-.003 5.523-4.512 10.004-10.003 10.004zm5.518-7.502c-.302-.15-1.789-.882-2.066-.983-.277-.1-.478-.15-.68.15s-.781.983-.957 1.183c-.176.2-.352.225-.654.075-1.921-.976-3.32-2.457-4.108-4.593-.075-.205.228-.182.523-.765.1-.2.05-.375-.025-.525s-.68-1.631-.932-2.233c-.246-.587-.496-.508-.68-.517-.176-.008-.377-.01-.579-.01-.2 0-.527.075-.803.375s-1.054 1.025-1.054 2.5 1.08 2.898 1.231 3.098c.15.2 2.115 3.208 5.12 4.49 2.112.903 2.87.777 3.931.625.816-.118 2.516-1.031 2.87-2.025.352-.993.352-1.844.247-2.025-.105-.175-.377-.275-.68-.425z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </aside>
        </div>
    </div>

    {{-- Articles connexes --}}
    @if (count($this->relatedPosts) > 0)
        <div
            class="border-t border-zinc-200 bg-linear-to-b from-zinc-50/50 to-white py-12 dark:border-zinc-800 dark:from-zinc-950/50 dark:to-zinc-950">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <h2 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">Articles similaires</h2>
                <div class="grid grid-cols-1 gap-7 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->relatedPosts as $related)
                        <a href="{{ route('posts.show', $related->slug) }}"
                            class="group relative flex flex-col rounded border border-zinc-200/60 bg-white p-5 transition-all duration-500 ease-out
                              hover:-translate-y-1 hover:border-emerald-300 hover:shadow hover:shadow-emerald-100/30
                              dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20"
                            aria-label="{{ $related->title }}">

                            {{-- Image pleine largeur --}}
                            <div
                                class="overflow-hidden rounded-lg ring-1 ring-zinc-200 transition duration-500 ease-out group-hover:ring-emerald-300 dark:ring-zinc-700 dark:group-hover:ring-emerald-700">
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

                            {{-- Titre et description --}}
                            <div class="mt-4 flex flex-col gap-1">
                                <p
                                    class="line-clamp-1 font-medium text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                    {{ $related->title }}
                                </p>
                                <p class="line-clamp-2 text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $related->getPlainTextContent(100) }}
                                </p>
                            </div>

                            {{-- Date et flèche --}}
                            <div class="mt-5 flex items-center justify-between gap-3">
                                <time class="text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $related->published_at?->translatedFormat('d F Y') ?? $related->created_at->translatedFormat('d F Y') }}
                                </time>
                                <div
                                    class="flex shrink-0 items-center gap-1 text-sm font-medium text-emerald-600 opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:gap-2 dark:text-emerald-400">
                                    Lire
                                    <svg class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 12h14m-6-6l6 6-6 6" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Commentaires --}}
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
