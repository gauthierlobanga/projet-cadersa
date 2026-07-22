<?php

use Livewire\Component;
use App\Models\Formation;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

new #[Layout('layouts::main')] class extends Component {
    public Formation $formation;
    public $likesCount = 0;
    public $isLiked = false;
    public $bookmarksCount = 0;
    public $isBookmarked = false;
    public ?string $activeChapter = null;
    public ?string $activeLesson = null;

    public function mount(Formation $formation)
    {
        $this->formation = $formation->load(['category', 'media', 'tags', 'user']);
        $sessionKey = 'viewed_formation_' . $formation->id;
        if (!session()->has($sessionKey)) {
            $this->formation->increment('views_count');
            session()->put($sessionKey, true);
        }
        if (method_exists($this->formation, 'likes')) {
            $this->likesCount = $this->formation->likes()->count();
            if ($user = Auth::user()) {
                $this->isLiked = $this->formation->isLikedBy($user);
                $this->isBookmarked = $this->formation->isBookmarkedBy($user);
                $this->bookmarksCount = $this->formation->bookmarkedBy()->count();
            }
        }
    }

    #[Computed]
    public function pdfs()
    {
        return $this->formation->getMedia('documents', ['mime_type' => 'application/pdf'])->map(
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
        return $this->formation->getFirstMedia('documents', ['mime_type' => 'application/pdf']) !== null;
    }

    public function rendering(\Illuminate\View\View $view): void
    {
        $view->title($this->formation->title);
        $imageUrl = $this->formation->getFirstMediaUrl('cover') ?: asset('images/logo-app.svg');
        $description = $this->formation->getPlainTextContent(160);
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => $this->formation->title,
            'image' => [$imageUrl],
            'description' => $description,
            'provider' => ['@type' => 'Person', 'name' => 'Gauthier Lobanga'],
        ];
        $view->layoutData([
            'seoDescription' => $description,
            'seoImage' => $imageUrl,
            'seoType' => 'article',
            'seoKeywords' => $this->formation->tags->pluck('name')->toArray(),
            'schema' => '<script type="application/ld+json">' . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>',
        ]);
    }

    #[Computed]
    public function activeVideo(): ?\Spatie\MediaLibrary\MediaCollections\Models\Media
    {
        // Priorité à la leçon
        if ($this->activeLesson) {
            $video = $this->formation->getVideoForTarget($this->activeLesson);
            if ($video) {
                return $video;
            }
        }
        // Sinon, on cherche pour le chapitre actif
        if ($this->activeChapter) {
            $video = $this->formation->getVideoForTarget($this->activeChapter);
            if ($video) {
                return $video;
            }
        }
        return null;
    }

    #[Computed]
    public function galleryJson(): string
    {
        return json_encode($this->galleryImages->toArray(), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

    #[Computed]
    public function previousFormation()
    {
        return Formation::published()->where('id', '<', $this->formation->id)->latest('published_at')->first();
    }

    #[Computed]
    public function nextFormation()
    {
        return Formation::published()->where('id', '>', $this->formation->id)->oldest('published_at')->first();
    }

    #[Computed]
    public function relatedFormations()
    {
        return Formation::published()
            ->with(['category', 'media'])
            ->where('id', '!=', $this->formation->id)
            ->where('formation_category_id', $this->formation->formation_category_id)
            ->latest('published_at')
            ->take(3)
            ->get();
    }

    #[Computed]
    public function galleryImages()
    {
        return $this->formation->getMedia('gallery')->map(
            fn($media) => [
                'url' => $media->getUrl('large'),
                'medium' => $media->getUrl('card'),
                'thumb' => $media->getUrl('thumb'),
                'title' => $media->getCustomProperty('title', ''),
                'description' => $media->getCustomProperty('description', ''),
                'alt' => $media->getCustomProperty('alt', $this->formation->title),
            ],
        );
    }

    #[Computed]
    public function videos()
    {
        return $this->formation->getMedia('videos')->map(
            fn($media) => [
                'url' => $media->getUrl(),
                'name' => $media->name ?? $media->file_name,
                'mime_type' => $media->mime_type,
                'poster' => $media->getCustomProperty('poster', ''),
            ],
        );
    }

    #[Computed]
    public function hasVideo()
    {
        return $this->formation->getFirstMedia('videos') !== null;
    }

    public function like()
    {
        if (!method_exists($this->formation, 'likes')) {
            return;
        }
        $user = Auth::user();
        if (!$user) {
            return;
        }
        if ($this->formation->isLikedBy($user)) {
            $this->formation->likes()->where('user_id', $user->id)->delete();
            $this->isLiked = false;
        } else {
            $this->formation->likes()->create(['user_id' => $user->id]);
            $this->isLiked = true;
        }
        $this->likesCount = $this->formation->likes()->count();
    }

    public function bookmark()
    {
        if (!method_exists($this->formation, 'bookmarkedBy')) {
            return;
        }
        $user = Auth::user();
        if (!$user) {
            return;
        }
        if ($this->formation->isBookmarkedBy($user)) {
            $this->formation->bookmarkedBy()->detach($user->id);
            $this->isBookmarked = false;
        } else {
            $this->formation->bookmarkedBy()->attach($user->id);
            $this->isBookmarked = true;
        }
        $this->bookmarksCount = $this->formation->bookmarkedBy()->count();
    }

    // --------------------------------------------------------------
    //  Gestion des chapitres / leçons (headings Tiptap)
    // --------------------------------------------------------------
    #[Computed]
    public function chapters(): array
    {
        $content = $this->formation->content;
        if (!is_array($content)) {
            return [];
        }
        $nodes = $content['content'] ?? [];
        $chapters = [];
        $currentChapter = null;
        $currentLesson = null;

        foreach ($nodes as $node) {
            $type = $node['type'] ?? '';
            $level = $node['attrs']['level'] ?? 0;

            if ($type === 'heading' && $level === 2) {
                // Fermeture de la leçon en cours
                if ($currentLesson) {
                    $currentChapter['lessons'][] = $currentLesson;
                    $currentLesson = null;
                }
                // Fermeture du chapitre en cours
                if ($currentChapter) {
                    $chapters[] = $currentChapter;
                }
                // Nouveau chapitre
                $id = 'chapter-' . count($chapters);
                $currentChapter = [
                    'id' => $id,
                    'text' => $this->extractTextFromTiptapNode($node),
                    'level' => 2,
                    'lessons' => [],
                    'content' => [$node],
                ];
            } elseif ($type === 'heading' && $level === 3) {
                // Fermeture de la leçon précédente
                if ($currentLesson) {
                    $currentChapter['lessons'][] = $currentLesson;
                }
                $lessonId = ($currentChapter['id'] ?? 'chapter-0') . '-lesson-' . count($currentChapter['lessons'] ?? []);
                $currentLesson = [
                    'id' => $lessonId,
                    'text' => $this->extractTextFromTiptapNode($node),
                    'level' => 3,
                    'content' => [$node],
                ];
            } else {
                // Contenu hors titre : on l'ajoute à la leçon, au chapitre ou au premier chapitre implicite
                if ($currentLesson) {
                    $currentLesson['content'][] = $node;
                } elseif ($currentChapter) {
                    $currentChapter['content'][] = $node;
                } else {
                    if (!isset($chapters[0]) || $chapters[0]['id'] !== 'chapter-0') {
                        $currentChapter = [
                            'id' => 'chapter-0',
                            'text' => 'Introduction',
                            'level' => 2,
                            'lessons' => [],
                            'content' => [],
                        ];
                        $chapters[] = $currentChapter;
                    }
                    $chapters[0]['content'][] = $node;
                }
            }
        }

        // Ajout de la dernière leçon et du dernier chapitre
        if ($currentLesson) {
            $currentChapter['lessons'][] = $currentLesson;
        }
        if ($currentChapter) {
            $chapters[] = $currentChapter;
        }

        // === Fusion des chapitres consécutifs portant le même titre ===
        $merged = [];
        foreach ($chapters as $chapter) {
            if (empty($merged)) {
                $merged[] = $chapter;
                continue;
            }

            $lastIndex = count($merged) - 1;
            // Comparaison insensible à la casse et aux espaces
            if (strtolower(trim($merged[$lastIndex]['text'])) === strtolower(trim($chapter['text']))) {
                // Fusion : on fusionne les contenus et les leçons
                $merged[$lastIndex]['content'] = array_merge($merged[$lastIndex]['content'], $chapter['content']);
                $merged[$lastIndex]['lessons'] = array_merge($merged[$lastIndex]['lessons'], $chapter['lessons']);
            } else {
                $merged[] = $chapter;
            }
        }

        return $merged;
    }

    public function setChapter(?string $chapterId): void
    {
        $this->activeChapter = $chapterId;
        $this->activeLesson = null;
    }

    public function setLesson(string $lessonId): void
    {
        $this->activeLesson = $lessonId;
    }

    private function extractTextFromTiptapNode(array $node): string
    {
        $text = '';
        if (isset($node['text'])) {
            $text .= $node['text'];
        }
        if (isset($node['content'])) {
            foreach ($node['content'] as $child) {
                $text .= $this->extractTextFromTiptapNode($child);
            }
        }
        return $text;
    }
};
?>

<div class="min-h-screen bg-white dark:bg-zinc-950">
    {{-- Barre de progression --}}
    <div x-data="pageProgress()" class="fixed top-0 left-0 z-50 h-0.5 w-full bg-zinc-200 dark:bg-zinc-800">
        <div class="h-full bg-emerald-500 transition-all duration-150" :style="{ width: progress + '%' }"></div>
    </div>
    {{-- Fil d'Ariane --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4">
        <nav aria-label="Fil d'Ariane" class="flex items-center gap-1 text-xs sm:text-sm">
            <a href="{{ route('home') }}" wire:navigate
                class="flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-zinc-500 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-600 dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1" />
                </svg>
                <span>Accueil</span>
            </a>
            <svg class="h-4 w-4 shrink-0 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
            <a href="{{ route('formations.index') }}" wire:navigate
                class="rounded-lg px-2.5 py-1.5 text-zinc-500 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-600 dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400">
                Formations
            </a>
            @if ($formation->category)
                <svg class="h-4 w-4 shrink-0 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <a href="{{ route('formations.index', ['cat' => $formation->category->slug]) }}" wire:navigate
                    class="rounded-lg px-2.5 py-1.5 text-zinc-500 transition-all duration-200 hover:bg-emerald-50 hover:text-emerald-600 dark:text-zinc-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400">
                    {{ $formation->category->name }}
                </a>
            @endif
        </nav>
    </div>

    {{-- ==================== HERO SOBRE – Texte élargi, typo soignée ==================== --}}
    <section class="relative overflow-hidden bg-white dark:bg-zinc-900 py-16 sm:py-24 lg:py-0">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 lg:min-h-[60vh] items-center gap-8 lg:gap-12">

                {{-- Colonne gauche : texte (2/3 de la largeur) --}}
                <div class="lg:col-span-2 order-2 lg:order-1" x-data="{ shown: false }" x-intersect="shown = true">
                    <div class="w-full max-w-3xl">

                        {{-- Badge catégorie --}}
                        @if ($formation->category)
                            <span
                                class="inline-flex items-center gap-2 rounded-full bg-emerald-100 px-4 py-1.5 text-xs font-semibold uppercase tracking-widest text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 transition-all duration-500"
                                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                {{ $formation->category->name }}
                            </span>
                        @endif

                        {{-- Titre --}}
                        <h1 class="mt-6 text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight text-zinc-900 dark:text-white transition-all duration-700 delay-100"
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                            {{ $formation->title }}
                        </h1>

                        {{-- Sous‑titre éventuel --}}
                        @if ($formation->subtitle)
                            <p class="mt-4 text-lg sm:text-xl text-zinc-600 dark:text-zinc-400 leading-relaxed transition-all duration-700 delay-200"
                                :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                                {{ $formation->subtitle }}
                            </p>
                        @endif

                        {{-- Métadonnées --}}
                        <div class="mt-8 flex flex-wrap items-center gap-x-8 gap-y-4 text-base text-zinc-600 dark:text-zinc-400 font-medium transition-all duration-700 delay-300"
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                            <div class="flex items-center gap-2.5">
                                <svg class="h-6 w-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $formation->duration ?? 'Durée non définie' }}</span>
                            </div>
                            <div class="flex items-center gap-2.5">
                                <svg class="h-6 w-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>{{ \Illuminate\Support\Number::format($formation->views_count ?? 0, locale: 'fr') }}
                                    vues</span>
                            </div>
                            @if ($formation->location)
                                <div class="flex items-center gap-2.5">
                                    <svg class="h-6 w-6 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ $formation->location }}</span>
                                </div>
                            @endif
                        </div>

                        {{-- Boutons d'action --}}
                        <div class="mt-10 flex flex-wrap items-center gap-4 transition-all duration-700 delay-500"
                            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'">
                            <a href="{{ route('contact') }}" wire:navigate
                                class="inline-flex h-14 items-center justify-center rounded-full bg-emerald-600 px-8 text-sm font-semibold text-white shadow-lg shadow-emerald-600/20 transition-all duration-300 hover:bg-emerald-700 hover:shadow-emerald-700/30 dark:bg-emerald-500 dark:hover:bg-emerald-600 active:scale-[0.97]">
                                Je m'inscris à cette formation
                                <svg class="ml-2 h-5 w-5 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                            <a href="#chapitres"
                                class="inline-flex h-14 items-center justify-center rounded-full border border-zinc-300 bg-white px-8 text-sm font-semibold text-zinc-700 shadow-sm transition-all duration-300 hover:border-emerald-300 hover:text-emerald-700 dark:border-zinc-600 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-emerald-500 dark:hover:text-emerald-400 active:scale-[0.97]">
                                Voir le programme
                                <svg class="ml-2 h-5 w-5 transition-transform group-hover:translate-y-0.5"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite : image réduite (1/3 de la largeur) --}}
                <div class="lg:col-span-1 order-1 lg:order-2 flex justify-center lg:justify-end" x-data="{ shown: false }"
                    x-intersect="shown = true">
                    <div class="transition-all duration-700 delay-200"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'">
                        @if ($formation->hasMedia('cover'))
                            <img src="{{ $formation->getFirstMediaUrl('cover') }}" alt="{{ $formation->title }}"
                                class="w-full max-w-65 sm:max-w-75 lg:max-w-[320px] h-auto object-contain rounded-2xl"
                                loading="eager" />
                        @else
                            <div
                                class="w-full max-w-65 sm:max-w-75 lg:max-w-[320px] aspect-4/3 flex items-center justify-center rounded-2xl bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ==================== CONTENU PRINCIPAL AVEC SIDEBAR CHAPITRES ==================== --}}
    <div id="chapitres" class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
        <div class="grid gap-8 lg:grid-cols-12 lg:gap-8">

            {{-- Sidebar gauche : chapitres (design pro) --}}
            <aside class="lg:col-span-3 order-1 lg:order-1">
                <div class="sticky top-28">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="h-8 w-1 rounded-full bg-emerald-500"></div>
                        <h3 class="text-sm font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                            Contenu de la formation
                        </h3>
                    </div>
                    <nav class="space-y-1">
                        {{-- Vue d’ensemble --}}
                        <button wire:click="setChapter(null)"
                            class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-3 group
                           {{ is_null($activeChapter) && is_null($activeLesson) ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 shadow-sm' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                            <span
                                class="shrink-0 w-6 h-6 flex items-center justify-center rounded-md bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 text-xs font-bold">
                                1
                            </span>
                            <span>Vue d'ensemble</span>
                        </button>

                        {{-- Chapitres et leçons --}}
                        @foreach ($this->chapters as $chapterIndex => $chapter)
                            {{-- Chapitre --}}
                            <div class="space-y-1">
                                <button wire:click="setChapter('{{ $chapter['id'] }}')"
                                    class="w-full text-left px-4 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200 flex items-center gap-3 group
                                   {{ $activeChapter === $chapter['id'] && is_null($activeLesson) ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300 shadow-sm' : 'text-zinc-900 dark:text-white hover:bg-zinc-100 dark:hover:bg-zinc-800' }}">
                                    <span
                                        class="shrink-0 w-6 h-6 flex items-center justify-center rounded-md bg-zinc-200 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 text-xs font-bold">
                                        {{ $chapterIndex + 2 }}
                                    </span>
                                    <span>{{ $chapter['text'] }}</span>
                                </button>

                                {{-- Leçons --}}
                                @if (!empty($chapter['lessons']))
                                    <div class="ml-10 space-y-1 border-l-2 border-zinc-200 dark:border-zinc-700 pl-4">
                                        @foreach ($chapter['lessons'] as $lesson)
                                            @php
                                                // Extraction éventuelle de la durée si présente dans le texte (ex: "Les variables 16min")
                                                $lessonText = $lesson['text'];
                                                $duration = '';
                                                if (preg_match('/\d+\s?min$/', $lessonText, $matches)) {
                                                    $duration = $matches[0];
                                                    $lessonText = trim(
                                                        preg_replace('/\d+\s?min$/', '', $lesson['text']),
                                                    );
                                                }
                                            @endphp
                                            <button wire:click="setLesson('{{ $lesson['id'] }}')"
                                                class="w-full text-left py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center justify-between group
                                               {{ $activeLesson === $lesson['id'] ? 'text-emerald-700 dark:text-emerald-300' : 'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                                                <span class="flex items-center gap-2">
                                                    <svg class="h-4 w-4 shrink-0 text-emerald-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span class="line-clamp-1">{{ $lessonText }}</span>
                                                </span>
                                                @if ($duration)
                                                    <span
                                                        class="text-xs text-zinc-400 dark:text-zinc-500 shrink-0 ml-2">{{ $duration }}</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- Colonne centrale --}}
            <div class="lg:col-span-6 order-2 lg:order-2">

                {{-- Vidéo de la formation --}}
                @if ($this->hasVideo)
                    <div
                        class="mb-10 overflow-hidden rounded-2xl shadow-lg ring-1 ring-zinc-200/50 dark:ring-zinc-700/50">
                        @php $video = $this->formation->getFirstMedia('videos'); @endphp
                        <video controls class="w-full aspect-video object-cover"
                            poster="{{ $video->getCustomProperty('poster') ?? '' }}" preload="metadata">
                            <source src="{{ $video->getUrl() }}" type="{{ $video->mime_type }}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    </div>
                @endif

                {{-- Vidéo du chapitre / leçon actif --}}
                @if ($this->activeVideo)
                    <div
                        class="mb-8 overflow-hidden rounded-2xl shadow-lg ring-1 ring-zinc-200/50 dark:ring-zinc-700/50">
                        <video controls class="w-full aspect-video object-cover" preload="metadata"
                            poster="{{ $this->activeVideo->getCustomProperty('poster') ?? '' }}">
                            <source src="{{ $this->activeVideo->getUrl() }}"
                                type="{{ $this->activeVideo->mime_type }}">
                            Votre navigateur ne supporte pas la lecture de vidéos.
                        </video>
                    </div>
                @endif

                {{-- Barre d'actions flottante --}}
                <div class="sticky top-20 z-20 mb-10 flex flex-wrap items-center justify-between gap-2 rounded-2xl border border-zinc-200/50 bg-white/70 px-4 py-2 backdrop-blur-xl shadow-sm dark:border-zinc-700/50 dark:bg-zinc-900/70"
                    x-data="socialShare()" data-share-url="{{ url()->current() }}"
                    data-share-title="{{ $formation->title }}">
                    <div class="flex items-center gap-2">
                        @if (method_exists($formation, 'likes'))
                            <button wire:click="like"
                                class="group flex h-10 items-center gap-1.5 px-3 text-sm font-medium transition-all {{ $isLiked ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 ring-1 ring-emerald-200 dark:ring-emerald-500/30' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
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
                                class="group flex h-10 items-center gap-1.5 px-3 text-sm font-medium transition-all {{ $isBookmarked ? 'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400 ring-1 ring-amber-200 dark:ring-amber-500/30' : 'text-zinc-600 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                                <svg class="h-5 w-5 transition-transform group-active:scale-90"
                                    fill="{{ $isBookmarked ? 'currentColor' : 'none' }}" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                                </svg>
                                <span>{{ $bookmarksCount }}</span>
                            </button>
                        @endif
                    </div>
                    <button @click="share()"
                        class="flex h-10 items-center gap-1.5 bg-zinc-900 px-4 text-sm font-medium text-white transition-all hover:bg-emerald-600 dark:bg-white dark:text-zinc-900 dark:hover:bg-emerald-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        <span>Partager</span>
                    </button>
                </div>

                {{-- Sous‑titre --}}
                @if ($formation->subtitle)
                    <div
                        class="mb-10 text-xl sm:text-2xl font-light leading-relaxed text-slate-600 dark:text-slate-300 border-l-4 border-emerald-500 pl-6">
                        {{ $formation->subtitle }}
                    </div>
                @endif

                {{-- Contenu (chapitre, leçon ou vue d'ensemble) avec transition --}}
                <div wire:transition class="fi-prose max-w-none w-full mb-16">
                    @if ($activeLesson)
                        @php
                            $lessonData = null;
                            foreach ($this->chapters as $chapter) {
                                foreach ($chapter['lessons'] as $lesson) {
                                    if ($lesson['id'] === $activeLesson) {
                                        $lessonData = $lesson;
                                        break 2;
                                    }
                                }
                            }
                        @endphp
                        @if ($lessonData)
                            {!! new \Tiptap\Editor()->setContent(['type' => 'doc', 'content' => $lessonData['content']])->getHTML() !!}
                        @endif
                    @elseif($activeChapter)
                        @php $chap = collect($this->chapters)->firstWhere('id', $activeChapter); @endphp
                        @if ($chap)
                            {!! new \Tiptap\Editor()->setContent(['type' => 'doc', 'content' => $chap['content']])->getHTML() !!}
                        @endif
                    @else
                        @if (is_array($formation->content))
                            {!! new \Tiptap\Editor()->setContent($formation->content)->getHTML() !!}
                        @else
                            {!! $formation->content !!}
                        @endif
                    @endif
                </div>

                {{-- Galerie d'images --}}
                @if ($this->galleryImages->count() > 0)
                    <div x-cloak x-data="{ shown: false }" x-intersect.once="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="transition-all duration-500 ease-out mb-16">
                        <div
                            class="mb-6 flex items-center justify-between border-b border-zinc-200 pb-3 dark:border-zinc-800">
                            <h3 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white">Galerie média
                            </h3>
                            <span
                                class="text-sm font-medium text-zinc-500 dark:text-zinc-400">{{ $this->galleryImages->count() }}
                                médias</span>
                        </div>

                        <div x-data="{
                            images: {{ $this->galleryJson }},
                            lightboxOpen: false,
                            activeIndex: 0,
                            get activeImage() { return this.images[this.activeIndex]; },
                            open(index) {
                                this.activeIndex = index;
                                this.lightboxOpen = true;
                                document.body.style.overflow = 'hidden';
                            },
                            close() {
                                this.lightboxOpen = false;
                                document.body.style.overflow = '';
                            },
                            prev() { this.activeIndex = (this.activeIndex - 1 + this.images.length) % this.images.length; },
                            next() { this.activeIndex = (this.activeIndex + 1) % this.images.length; },
                        }" @keydown.escape.window="close()"
                            @keydown.arrow-left.window="lightboxOpen && prev()"
                            @keydown.arrow-right.window="lightboxOpen && next()">

                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                                @foreach ($this->galleryImages as $index => $image)
                                    <button type="button" @click="open({{ $index }})"
                                        class="group relative aspect-square cursor-zoom-in overflow-hidden rounded-xl border border-zinc-200/50 bg-zinc-100 transition-all duration-300 hover:border-emerald-300 hover:shadow-lg hover:shadow-emerald-500/10 dark:border-zinc-700/50 dark:bg-zinc-800 dark:hover:border-emerald-600">
                                        <img loading="eager" src="{{ $image['thumb'] }}" alt="{{ $image['alt'] }}"
                                            class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110">
                                        <div
                                            class="absolute inset-0 bg-linear-to-t from-zinc-950/60 via-zinc-950/10 to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-100">
                                        </div>
                                        <div
                                            class="absolute inset-x-0 bottom-0 flex translate-y-2 flex-col gap-1 p-3 opacity-0 transition-all duration-300 group-hover:translate-y-0 group-hover:opacity-100">
                                            @if ($image['title'])
                                                <p class="truncate text-xs font-semibold text-white drop-shadow">
                                                    {{ $image['title'] }}</p>
                                            @endif
                                            <div class="flex items-center gap-1.5">
                                                <span
                                                    class="flex h-6 w-6 items-center justify-center rounded-full bg-emerald-500/80 text-white"><svg
                                                        class="h-3 w-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5"
                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                    </svg></span>
                                                <span class="text-2xs font-medium text-white/80">Agrandir</span>
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>

                            {{-- Lightbox --}}
                            <template x-teleport="body">
                                <div x-show="lightboxOpen" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="fixed inset-0 z-200 flex flex-col bg-zinc-950/97 backdrop-blur-sm" x-cloak>
                                    <div
                                        class="flex shrink-0 items-center justify-between border-b border-white/10 px-4 py-3 sm:px-6">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="rounded-full bg-emerald-500/20 px-3 py-1 text-xs font-semibold text-emerald-400">Galerie
                                                — <span x-text="activeIndex + 1"></span>/<span
                                                    x-text="images.length"></span></span>
                                            <p class="hidden truncate text-sm font-medium text-white sm:block max-w-xs"
                                                x-text="activeImage?.title || ''"></p>
                                        </div>
                                        <button @click="close()"
                                            class="flex h-9 w-9 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:bg-white/15 hover:border-white/20"
                                            aria-label="Fermer"><svg class="h-5 w-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </div>
                                    <div
                                        class="relative flex flex-1 items-center justify-center overflow-hidden px-14 py-4 sm:px-20">
                                        <button @click="prev()"
                                            class="absolute left-3 z-10 flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:bg-emerald-500/30 hover:border-emerald-500/50 hover:scale-105 sm:left-5"
                                            aria-label="Image précédente"><svg class="h-5 w-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg></button>
                                        <div class="flex max-h-full max-w-5xl flex-col items-center gap-5">
                                            <div class="relative overflow-hidden rounded-sm"><img
                                                    :src="activeImage?.url" :alt="activeImage?.alt || ''"
                                                    class="max-h-[58vh] w-auto max-w-full object-contain sm:max-h-[63vh]"
                                                    x-transition:enter="transition ease-out duration-250"
                                                    x-transition:enter-start="opacity-0 scale-97"
                                                    x-transition:enter-end="opacity-100 scale-100"></div>
                                            <div class="w-full max-w-2xl text-center"
                                                x-show="activeImage?.title || activeImage?.description"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 translate-y-2"
                                                x-transition:enter-end="opacity-100 translate-y-0">
                                                <p class="text-base font-semibold text-white"
                                                    x-text="activeImage?.title"></p>
                                                <p class="mt-1 text-sm leading-relaxed text-zinc-400"
                                                    x-text="activeImage?.description"
                                                    x-show="activeImage?.description"></p>
                                            </div>
                                        </div>
                                        <button @click="next()"
                                            class="absolute right-3 z-10 flex h-11 w-11 items-center justify-center rounded-full border border-white/10 bg-white/5 text-white transition hover:bg-emerald-500/30 hover:border-emerald-500/50 hover:scale-105 sm:right-5"
                                            aria-label="Image suivante"><svg class="h-5 w-5" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg></button>
                                    </div>
                                    <div class="shrink-0 border-t border-white/10 bg-zinc-900/60 px-4 py-3">
                                        <div class="flex items-center justify-center gap-2 overflow-x-auto pb-1">
                                            <template x-for="(img, i) in images" :key="i">
                                                <button type="button" @click="activeIndex = i"
                                                    :class="activeIndex === i ?
                                                        'ring-2 ring-emerald-400 ring-offset-2 ring-offset-zinc-950 opacity-100 scale-105' :
                                                        'opacity-40 hover:opacity-75'"
                                                    class="relative h-14 w-14 shrink-0 overflow-hidden rounded-md transition-all duration-200"><img
                                                        :src="img.thumb" :alt="img.alt || ''"
                                                        class="h-full w-full object-cover"></button>
                                            </template>
                                        </div>
                                        <p class="mt-2 text-center text-2xs text-zinc-600">← → pour naviguer · <kbd
                                                class="rounded bg-zinc-800 px-1 py-0.5 font-mono text-zinc-400">Esc</kbd>
                                            pour fermer</p>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                @endif

                {{-- Navigation précédent / suivant --}}
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    @if ($this->previousFormation)
                        <a href="{{ route('formations.show', $this->previousFormation) }}" wire:navigate
                            class="group flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-4 transition-transform duration-300 hover:-translate-y-1 hover:shadow dark:border-zinc-800 dark:bg-zinc-900">
                            <svg class="ml-auto h-5 w-5 text-emerald-500 transition-transform duration-300 group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <div class="flex flex-col text-left"><span class="text-xs text-zinc-400">Formation
                                    précédente</span><span
                                    class="text-sm font-semibold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Str::limit($this->previousFormation->title, 80) }}</span>
                            </div>
                        </a>
                    @endif
                    @if ($this->nextFormation)
                        <a href="{{ route('formations.show', $this->nextFormation) }}" wire:navigate
                            class="group flex items-center gap-4 rounded-2xl border border-zinc-200 bg-white p-4 transition-transform duration-300 hover:-translate-y-1 hover:shadow dark:border-zinc-800 dark:bg-zinc-900">
                            <div class="flex flex-col text-left"><span class="text-xs text-zinc-400">Formation
                                    suivante</span><span
                                    class="text-sm font-semibold text-zinc-900 dark:text-white">{{ \Illuminate\Support\Str::limit($this->nextFormation->title, 80) }}</span>
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

            {{-- Sidebar droite : infos clés, formateur, etc. --}}
            <aside class="lg:col-span-3 order-3 lg:order-3">
                <div class="sticky top-28 flex flex-col gap-8">
                    {{-- Carte Formateur --}}
                    <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                        class="group relative overflow-hidden rounded-2xl border border-zinc-200/50 bg-white/70 p-6 backdrop-blur-xl shadow-sm transition-all duration-500 hover:-translate-y-1 hover:shadow-lg dark:border-zinc-700/50 dark:bg-zinc-900/70">
                        <div
                            class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,var(--tw-gradient-stops))] from-emerald-100/40 via-transparent to-transparent opacity-50 transition-opacity duration-300 group-hover:opacity-100 dark:from-emerald-900/20">
                        </div>
                        <div class="flex items-center gap-4 mb-4">
                            <div
                                class="relative h-14 w-14 overflow-hidden rounded-full ring-2 ring-white dark:ring-zinc-800">
                                <img loading="eager"
                                    src="{{ $formation->user?->avatar_url ?? asset('images/gauthier-lobanga.jpg') }}"
                                    alt="{{ $formation->user?->name ?? 'Gauthier Lobanga' }}"
                                    class="h-full w-full object-cover">
                            </div>
                            <div>
                                <h3 class="font-bold text-zinc-900 dark:text-white">
                                    {{ $formation->user?->name ?? 'Gauthier Lobanga' }}</h3>
                                <p
                                    class="text-xs font-semibold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">
                                    Formateur</p>
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed text-zinc-600 dark:text-zinc-400">
                            {{ $formation->user?->bio ?? 'Développeur Full‑Stack passionné par la transmission des connaissances.' }}
                        </p>
                    </div>

                    {{-- Informations clés --}}
                    <div
                        class="rounded-2xl border border-zinc-200/50 bg-white/70 p-6 backdrop-blur-xl shadow-sm dark:border-zinc-700/50 dark:bg-zinc-900/70">
                        <h3 class="mb-4 text-sm font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                            Informations clés</h3>
                        <ul class="space-y-4 text-sm">
                            @if ($formation->start_date)
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-zinc-700 dark:text-zinc-300">Début :
                                        <strong>{{ $formation->start_date->translatedFormat('d F Y') }}</strong></span>
                                </li>
                            @endif
                            @if ($formation->end_date)
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-zinc-700 dark:text-zinc-300">Fin :
                                        <strong>{{ $formation->end_date->translatedFormat('d F Y') }}</strong></span>
                                </li>
                            @endif
                            @if ($formation->location)
                                <li class="flex items-center gap-3">
                                    <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-zinc-700 dark:text-zinc-300">{{ $formation->location }}</span>
                                </li>
                            @endif
                            <li class="flex items-center gap-3">
                                <svg class="h-5 w-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-zinc-700 dark:text-zinc-300">Statut :
                                    <strong>{{ $formation->status_label ?? $formation->status }}</strong></span>
                            </li>
                        </ul>
                    </div>

                    {{-- Documents PDF --}}
                    @if ($this->hasPdf)
                        <div
                            class="rounded-2xl border border-zinc-200/50 bg-white/70 p-5 backdrop-blur-xl shadow-sm dark:border-zinc-700/50 dark:bg-zinc-900/70">
                            <h3 class="mb-4 flex items-center gap-2.5 text-sm font-bold text-zinc-900 dark:text-white">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Documents joints
                            </h3>
                            <div class="flex flex-col gap-2">
                                @foreach ($this->pdfs as $pdf)
                                    <a href="{{ $pdf['url'] }}" target="_blank"
                                        class="group flex items-center gap-2.5 rounded-xl border border-zinc-200/50 bg-zinc-50/50 p-2.5 transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-300/50 hover:bg-emerald-50/50 hover:shadow-sm dark:border-zinc-700/50 dark:bg-zinc-800/50 dark:hover:border-emerald-700/50 dark:hover:bg-emerald-900/20">
                                        <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span
                                            class="flex-1 text-xs font-semibold text-zinc-800 dark:text-zinc-200 truncate">{{ $pdf['name'] }}</span>
                                        <span
                                            class="text-2xs font-medium text-zinc-400 dark:text-zinc-500">{{ round($pdf['size'] / 1024) }}
                                            KB</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tags --}}
                    @if ($formation->tags && $formation->tags->count() > 0)
                        <div
                            class="rounded-2xl border border-zinc-200/50 bg-white/70 p-6 backdrop-blur-xl shadow-sm dark:border-zinc-700/50 dark:bg-zinc-900/70">
                            <h3
                                class="mb-4 flex items-center gap-3 text-xs font-bold uppercase tracking-widest text-zinc-900 dark:text-white">
                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span> Thématiques
                            </h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($formation->tags as $tag)
                                    <a href="{{ route('formations.index', ['tag' => $tag->slug]) }}" wire:navigate
                                        class="inline-flex items-center rounded-lg border border-zinc-200/80 bg-zinc-50/50 px-3 py-1.5 text-xs font-semibold text-zinc-600 transition-all duration-300 hover:-translate-y-0.5 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700 hover:shadow-sm dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-300 dark:hover:border-emerald-700/80 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-300">{{ $tag->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Partager --}}
                    @php
                        $shareUrl = url()->current();
                        $shareTitle = urlencode($formation->title);
                    @endphp
                    <div class="rounded-2xl border border-zinc-200/50 bg-white/70 p-6 backdrop-blur-xl shadow-sm dark:border-zinc-700/50 dark:bg-zinc-900/70"
                        x-data="socialShare()" data-share-url="{{ $shareUrl }}"
                        data-share-title="{{ $shareTitle }}">
                        <h3
                            class="mb-4 text-center text-xs font-bold uppercase tracking-widest text-zinc-600 dark:text-zinc-400">
                            Partager</h3>
                        <div class="flex items-center justify-center gap-2.5">
                            <button @click="share('facebook')"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200/80 bg-zinc-50/50 text-zinc-600 transition-all hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] hover:scale-105 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-400"><svg
                                    class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                                </svg></button>
                            <button @click="share('twitter')"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200/80 bg-zinc-50/50 text-zinc-600 transition-all hover:bg-black hover:text-white hover:border-black hover:scale-105 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-400"><svg
                                    class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg></button>
                            <button @click="share('linkedin')"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200/80 bg-zinc-50/50 text-zinc-600 transition-all hover:bg-[#0A66C2] hover:text-white hover:border-[#0A66C2] hover:scale-105 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-400"><svg
                                    class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4.98 3.5c0 1.381-1.11 2.5-2.48 2.5s-2.48-1.119-2.48-2.5c0-1.38 1.11-2.5 2.48-2.5s2.48 1.12 2.48 2.5zm.02 4.5h-5v16h5v-16zm7.982 0h-4.968v16h4.969v-8.399c0-4.67 6.029-5.052 6.029 0v8.399h4.988v-10.131c0-7.88-8.922-7.593-11.018-3.714v-2.155z" />
                                </svg></button>
                            <button @click="share('whatsapp')"
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200/80 bg-zinc-50/50 text-zinc-600 transition-all hover:bg-[#25D366] hover:text-white hover:border-[#25D366] hover:scale-105 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-400"><svg
                                    class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.334.101 11.893c-.001 2.106.549 4.16 1.595 5.975L0 24l6.335-1.652c1.747.96 3.711 1.468 5.704 1.469h.004c6.58 0 11.939-5.336 11.943-11.893.002-3.181-1.238-6.173-3.466-8.475zm-8.476 19.333c-1.785-.001-3.536-.48-5.068-1.387l-.363-.214-3.766.982.999-3.655-.235-.373c-1.004-1.591-1.532-3.428-1.531-5.335.003-5.526 4.512-10.024 10.045-10.024 2.68 0 5.197 1.042 7.089 2.932 1.892 1.889 2.935 4.398 2.933 7.07-.003 5.523-4.512 10.004-10.003 10.004zm5.518-7.502c-.302-.15-1.789-.882-2.066-.983-.277-.1-.478-.15-.68.15s-.781.983-.957 1.183c-.176.2-.352.225-.654.075-1.921-.976-3.32-2.457-4.108-4.593-.075-.205.228-.182.523-.765.1-.2.05-.375-.025-.525s-.68-1.631-.932-2.233c-.246-.587-.496-.508-.68-.517-.176-.008-.377-.01-.579-.01-.2 0-.527.075-.803.375s-1.054 1.025-1.054 2.5 1.08 2.898 1.231 3.098c.15.2 2.115 3.208 5.12 4.49 2.112.903 2.87.777 3.931.625.816-.118 2.516-1.031 2.87-2.025.352-.993.352-1.844.247-2.025-.105-.175-.377-.275-.68-.425z" />
                                </svg></button>
                            <button @click="copyLink()"
                                class="relative flex h-10 w-10 items-center justify-center rounded-xl border border-zinc-200/80 bg-zinc-50/50 text-zinc-600 transition-all hover:border-emerald-400 hover:bg-emerald-50 hover:text-emerald-600 hover:scale-105 dark:border-zinc-700/80 dark:bg-zinc-800/50 dark:text-zinc-400">
                                <svg x-show="!copied" class="h-4 w-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                </svg>
                                <span x-show="copied" class="text-sm font-semibold text-emerald-600">✓</span>
                            </button>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    {{-- ==================== FORMATIONS SIMILAIRES ==================== --}}
    @if (count($this->relatedFormations) > 0)
        <div class="border-t border-zinc-200 bg-zinc-50/40 py-16 sm:py-24 dark:border-zinc-800 dark:bg-zinc-950/50">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-10 text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white">Formations similaires
                </h2>
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($this->relatedFormations as $related)
                        <a wire:navigate href="{{ route('formations.show', $related->slug) }}"
                            class="gsap-reveal group relative flex flex-col overflow-hidden rounded-2xl border border-zinc-200/50 bg-white transition-all duration-500 ease-out hover:-translate-y-1 hover:border-emerald-300 hover:shadow-lg dark:border-zinc-700/60 dark:bg-zinc-900 dark:hover:border-emerald-700 dark:hover:shadow-emerald-900/20">
                            <div
                                class="relative aspect-video w-full overflow-hidden bg-zinc-100 ring-1 ring-zinc-200 dark:bg-zinc-800 dark:ring-zinc-700">
                                @if ($related->hasMedia('cover'))
                                    <img loading="eager" src="{{ $related->getFirstMediaUrl('cover', 'card') }}"
                                        alt="{{ $related->title }}"
                                        class="h-full w-full object-cover transition duration-700 ease-out group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center"><svg
                                            class="h-12 w-12 text-zinc-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg></div>
                                @endif
                            </div>
                            <div class="flex flex-1 flex-col p-5">
                                <div
                                    class="relative transition duration-300 ease-out will-change-transform group-hover:translate-x-4.5">
                                    <div x-data="rotatingBadge()" class="absolute top-1/2 -left-4 -translate-y-1/2">
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
                                        class="line-clamp-1 font-semibold text-zinc-900 transition-colors duration-300 group-hover:text-emerald-600 dark:text-white dark:group-hover:text-emerald-400">
                                        {{ $related->title }}</p>
                                </div>
                                <p class="mt-2 line-clamp-2 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $related->getPlainTextContent(100) }}</p>
                                <div class="mt-auto flex items-center justify-between pt-4">
                                    <span
                                        class="text-sm text-zinc-500 dark:text-zinc-400">{{ $related->start_date?->translatedFormat('d M Y') }}</span>
                                    @if ($related->category)
                                        <span
                                            class="inline-flex items-center gap-1 rounded-full border border-zinc-200/60 bg-white px-2 py-0.5 text-xs font-medium dark:border-zinc-700 dark:bg-zinc-800"
                                            style="color: {{ $related->category->color }}">{{ $related->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex h-10 items-stretch text-sm font-medium">
                                <div
                                    class="inline-flex grow items-center justify-between gap-3 px-4 bg-emerald-50 text-emerald-700 transition-all duration-300 ease-out group-hover:bg-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-300 dark:group-hover:bg-emerald-900/30">
                                    <span>En savoir plus</span>
                                    <span class="transition duration-300 ease-out group-hover:translate-x-1"><svg
                                            xmlns="http://www.w3.org/2000/svg" class="h-3" viewBox="0 0 28 22"
                                            fill="none">
                                            <path class="fill-current"
                                                d="M1 10H5.96046e-08V12H1V10ZM27 12C27.5523 12 28 11.5523 28 11C28 10.4477 27.5523 10 27 10V12ZM18 1V5.96046e-08H16V1H18ZM26.4207 11.7774C26.9055 12.0419 27.5129 11.8632 27.7774 11.3783C28.0419 10.8935 27.8632 10.286 27.3783 10.0216L26.4207 11.7774ZM15.9999 20.8995V21.8995H17.9999V20.8995H15.9999ZM1 12H26.8994V10H1V12ZM26.8994 12H27V10H26.8994V12ZM16 1C16 2.47241 16.7953 3.87873 17.7716 5.0769C18.7678 6.29956 20.0716 7.44977 21.3383 8.42854C22.6109 9.41186 23.8784 10.2469 24.825 10.835C25.2993 11.1295 25.6952 11.3635 25.9738 11.5245C26.1131 11.605 26.2233 11.6674 26.2993 11.71C26.3374 11.7314 26.3669 11.7478 26.3873 11.7591C26.3975 11.7647 26.4055 11.7691 26.411 11.7721C26.4138 11.7737 26.416 11.7749 26.4176 11.7758C26.4184 11.7762 26.4191 11.7765 26.4196 11.7768C26.4199 11.777 26.4201 11.7771 26.4202 11.7772C26.4205 11.7773 26.4207 11.7774 26.8995 10.8995C27.3783 10.0216 27.3784 10.0217 27.3785 10.0217C27.3785 10.0217 27.3785 10.0217 27.3785 10.0217C27.3784 10.0216 27.3781 10.0215 27.3777 10.0213C27.3769 10.0208 27.3756 10.0201 27.3736 10.019C27.3697 10.0168 27.3634 10.0134 27.3549 10.0087C27.3378 9.99926 27.3118 9.98479 27.2773 9.96547C27.2084 9.92682 27.1058 9.86878 26.9745 9.79288C26.7117 9.64102 26.3342 9.41799 25.8804 9.13606C24.9708 8.57104 23.7635 7.77501 22.5612 6.84596C21.353 5.91235 20.182 4.86894 19.322 3.81356C18.4422 2.73371 18 1.77759 18 1H16ZM26.8994 11C26.5248 10.0728 26.5245 10.0729 26.5242 10.0731C26.524 10.0731 26.5237 10.0733 26.5234 10.0734C26.5228 10.0736 26.522 10.0739 26.5211 10.0743C26.5193 10.0751 26.5169 10.076 26.5138 10.0773C26.5078 10.0797 26.4994 10.0832 26.4888 10.0876C26.4674 10.0964 26.4369 10.1091 26.3979 10.1257C26.3199 10.1587 26.2077 10.2071 26.0662 10.2703C25.7834 10.3967 25.3826 10.5825 24.903 10.824C23.9463 11.3055 22.6639 12.0142 21.3751 12.919C20.0914 13.8201 18.7665 14.94 17.7546 16.2535C16.7415 17.5685 15.9999 19.1342 15.9999 20.8995H17.9999C17.9999 19.715 18.4958 18.5685 19.3389 17.4742C20.1831 16.3784 21.333 15.3922 22.5242 14.5559C23.7103 13.7232 24.9028 13.0632 25.8022 12.6104C26.2507 12.3846 26.6233 12.2119 26.8818 12.0965C27.011 12.0388 27.1115 11.9955 27.1785 11.967C27.212 11.9528 27.2371 11.9424 27.2533 11.9357C27.2613 11.9324 27.2671 11.93 27.2706 11.9286C27.2724 11.9279 27.2735 11.9274 27.2741 11.9271C27.2744 11.927 27.2745 11.927 27.2745 11.927C27.2745 11.927 27.2744 11.927 27.2744 11.927C27.2742 11.9271 27.274 11.9272 26.8994 11Z" />
                                        </svg></span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- ==================== COMMENTAIRES ==================== --}}
    @if (method_exists($formation, 'comments'))
        <section class="bg-white py-16 antialiased lg:py-24 dark:bg-zinc-950">
            <div class="mx-auto max-w-6xl px-4">
                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-lg font-bold text-zinc-900 lg:text-2xl dark:text-white">Discussion</h2>
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-medium text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        {{ $formation->comments_count ?? 0 }}
                    </span>
                </div>
                <livewire:comments.comments commentableType="App\Models\Formation" :commentableId="$formation->id" />
            </div>
        </section>
    @endif
</div>
