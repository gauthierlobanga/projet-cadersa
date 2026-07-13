<?php

namespace App\Models;

// use App\Concerns\Traits\HasTiptapContent;
use App\Traits\HasComments;
use Carbon\Carbon;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Tags\HasTags;
use Tiptap\Editor;

#[Fillable([
    'user_id',
    'title',
    'slug',
    'excerpt',
    'content',
    'embedding',
    'featured_image',
    'status',
    'is_pinned',
    'views_count',
    'likes_count',
    'comments_count',
    'reading_time_minutes',
    'meta_title',
    'meta_description',
    'meta_keywords',
    'published_at',
    'scheduled_for',
    'expires_at',
    'order',
])]
class Post extends Model implements Feedable, HasMedia, HasRichContent, Sitemapable
{
    use HasComments, HasFactory, HasTags, InteractsWithMedia , SoftDeletes;
    use HasUuids;
    use InteractsWithRichContent;

    /**
     * Indique que les clés primaires sont de type string (UUID)
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indique que les clés primaires ne sont pas auto-incrémentées
     *
     * @var bool
     */
    public $incrementing = false;

    public function setUpRichContent(): void
    {
        $this->registerRichContent('content')
            ->fileAttachmentsDisk('public')   // ou s3 si vous utilisez
            ->fileAttachmentsVisibility('public');
        // Ajoutez ici vos blocs, mentions, etc.
    }

    /**
     * Convertit un article en élément de flux.
     */
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->getPlainTextContent(200) ?: $this->title)
            ->updated($this->updated_at)
            ->link(route('posts.show', $this->slug)) // Votre route de détail
            ->authorName($this->user?->name ?? 'CADERSA')
            ->authorEmail($this->user?->email ?? 'contact@cadersa.org');
    }

    /**
     * Méthode statique qui retourne les éléments du flux.
     */
    public static function getFeedItems()
    {
        return self::published()
            ->latest('published_at')
            ->take(20) // Limite pour éviter les flux trop volumineux
            ->get();
    }

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('posts.show', $this->slug))
            ->setLastModificationDate($this->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8);
    }

    protected function casts(): array
    {
        return [
            'excerpt' => 'array',
            'content' => 'array',
            'metadata' => 'array',
            'meta_keywords' => 'array',
            'published_at' => 'datetime',
            'scheduled_for' => 'datetime',
            'is_pinned' => 'boolean',
            'views_count' => 'integer',
            'likes_count' => 'integer',
            'comments_count' => 'integer',
            'reading_time_minutes' => 'integer',
            'published_at' => 'datetime',
            'scheduled_for' => 'datetime',
            'expires_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // Constantes de statut
    public const string STATUS_DRAFT = 'draft';

    public const string STATUS_PUBLISHED = 'published';

    public const string STATUS_SCHEDULED = 'scheduled';

    public const string STATUS_EXPIRED = 'expired';

    public const string STATUS_ARCHIVED = 'archived';

    // Tailles d'images optimisées
    private const array IMAGE_SIZES = [
        'thumb' => ['width' => 150, 'height' => 150, 'fit' => Fit::Crop],
        'card' => ['width' => 400, 'height' => 300, 'fit' => Fit::Crop],
        'small' => ['width' => 600, 'height' => 400, 'fit' => Fit::Contain],
        'medium' => ['width' => 1200, 'height' => 800, 'fit' => Fit::Contain],
        'large' => ['width' => 1920, 'height' => 1080, 'fit' => Fit::Max],
    ];

    public static function getStatuses(): array
    {
        return [
            self::STATUS_DRAFT => 'Brouillon',
            self::STATUS_PUBLISHED => 'Publié',
            self::STATUS_SCHEDULED => 'Programmé',
            self::STATUS_EXPIRED => 'Expiré',
            self::STATUS_ARCHIVED => 'Archivé',
        ];
    }

    // ========== RELATIONS ==========

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            PostCategory::class,
            'posts_categories_pivot',
            'post_id',
            'category_id'
        )
            ->using(PostCategoryPivot::class)
            ->withPivot('est_principale', 'ordre')
            ->withTimestamps()
            ->orderByPivot('ordre');
    }

    // Ajoutez dans la classe
    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    public function isLikedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->likes()->where('user_id', $user->id)->exists();
    }

    public function primaryCategory()
    {
        return $this->belongsToMany(PostCategory::class, 'posts_categories_pivot')
            ->wherePivot('est_principale', true)
            ->first();
    }

    // ========== MEDIA CONFIGURATION ==========

    public function registerMediaCollections(): void
    {
        // Collection principale pour l'image à la une
        $this->addMediaCollection('featured')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->withResponsiveImages();

        // Collection pour la galerie
        $this->addMediaCollection('gallery')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->withResponsiveImages();

        // Collection pour les fichiers joints
        $this->addMediaCollection('attachments')
            ->useDisk('public')
            ->acceptsMimeTypes([
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'text/plain',
            ]);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // ------------------------------
        // 1. Miniature (thumb) – 150×150
        // ------------------------------
        $this->addMediaConversion('thumb')
            ->width(self::IMAGE_SIZES['thumb']['width'])
            ->height(self::IMAGE_SIZES['thumb']['height'])
            ->fit(self::IMAGE_SIZES['thumb']['fit'], self::IMAGE_SIZES['thumb']['width'], self::IMAGE_SIZES['thumb']['height'])
            ->format('webp')
            ->quality(80)
            ->sharpen(10)                     // ← rendu plus net
            ->optimize()
            ->nonQueued()
            ->performOnCollections('featured', 'gallery');

        // ------------------------------
        // 2. Carte (card) – 400×300
        // ------------------------------
        $this->addMediaConversion('card')
            ->width(self::IMAGE_SIZES['card']['width'])
            ->height(self::IMAGE_SIZES['card']['height'])
            ->fit(self::IMAGE_SIZES['card']['fit'], self::IMAGE_SIZES['card']['width'], self::IMAGE_SIZES['card']['height'])
            ->format('webp')
            ->quality(90)                     // ← meilleure qualité (85 → 90)
            ->sharpen(10)
            ->withResponsiveImages()          // génère les variantes pour srcset
            ->optimize()
            ->nonQueued()
            ->performOnCollections('featured');

        // ------------------------------
        // 3. Petite taille (small) – 600×400
        // ------------------------------
        $this->addMediaConversion('small')
            ->width(self::IMAGE_SIZES['small']['width'])
            ->height(self::IMAGE_SIZES['small']['height'])
            ->fit(self::IMAGE_SIZES['small']['fit'])
            ->format('webp')
            ->quality(85)
            ->sharpen(10)
            ->withResponsiveImages()
            ->optimize()
            ->nonQueued()
            ->performOnCollections('featured', 'gallery');

        // ------------------------------
        // 4. Affichage principal (medium) – 1200×800
        // ------------------------------
        $this->addMediaConversion('medium')
            ->width(self::IMAGE_SIZES['medium']['width'])
            ->height(self::IMAGE_SIZES['medium']['height'])
            ->fit(self::IMAGE_SIZES['medium']['fit'])
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->withResponsiveImages()
            ->optimize()
            ->queued()                       // file d'attente car lourd
            ->performOnCollections('featured', 'gallery');

        // ------------------------------
        // 5. Grande taille (large) – 1920×1080
        // ------------------------------
        $this->addMediaConversion('large')
            ->width(self::IMAGE_SIZES['large']['width'])
            ->height(self::IMAGE_SIZES['large']['height'])
            ->fit(self::IMAGE_SIZES['large']['fit'])
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->withResponsiveImages()
            ->optimize()
            ->queued()
            ->performOnCollections('featured', 'gallery');

        // ------------------------------
        // 6. Version Retina (2x) pour les cartes
        //    (800×600 si card = 400×300)
        // ------------------------------
        $this->addMediaConversion('card@2x')
            ->width(self::IMAGE_SIZES['card']['width'] * 2)
            ->height(self::IMAGE_SIZES['card']['height'] * 2)
            ->fit(self::IMAGE_SIZES['card']['fit'], self::IMAGE_SIZES['card']['width'] * 2, self::IMAGE_SIZES['card']['height'] * 2)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->withResponsiveImages()
            ->optimize()
            ->nonQueued()                    // rapide car carte
            ->performOnCollections('featured');
    }
    // ========== MEDIA ACCESSORS AVEC CACHE ==========

    /**
     * Accessor dynamique pour les différentes conversions
     * Usage: $post->featured_image_thumb, $post->featured_image_card, etc.
     */
    public function __get($key)
    {
        if (str_starts_with($key, 'featured_image_')) {
            $conversion = str_replace('featured_image_', '', $key);
            if (array_key_exists($conversion, self::IMAGE_SIZES)) {
                return $this->getFeaturedImageUrl($conversion);
            }
        }

        return parent::__get($key);
    }

    // ========== MEDIA ACCESSORS AVEC CACHE ==========

    /**
     * Récupère l'URL de l'image à la une avec une conversion spécifique
     * Avec mise en cache pour éviter les appels répétés
     */
    public function getFeaturedImageUrl(string $conversion = 'card'): ?string
    {
        $cacheKey = "post_{$this->id}_featured_image_{$conversion}";

        return Cache::remember($cacheKey, 3600, function () use ($conversion) {
            $media = $this->getFirstMedia('featured');

            if (! $media || ! $media->disk) {
                return null;
            }

            return $this->getMediaUrlSafely($media, $conversion);
        });
    }

    /**
     * Vérifie si un média est valide - Version corrigée
     */
    private function isMediaValid(?Media $media): bool
    {
        if (! $media || ! $media->disk) {
            return false;
        }

        try {
            // Vérifier simplement si le média existe en base et a un disque
            // La méthode getUrl() échouera si le fichier n'existe pas physiquement
            return true;
        } catch (\Exception $e) {
            Log::warning("Erreur lors de la vérification du média {$media->id}: ".$e->getMessage());

            return false;
        }
    }

    /**
     * Récupère l'URL d'un média de manière sécurisée - Version améliorée
     */
    private function getMediaUrlSafely(Media $media, string $conversion): string
    {
        try {
            // Vérifier si la conversion existe et est générée
            if ($media->hasGeneratedConversion($conversion)) {
                return $media->getUrl($conversion);
            }

            // Fallback: retourner l'original si conversion inexistante
            if (! $media->getUrl()) {
                Log::warning("Média {$media->id} sans URL valide");

                return '';
            }

            Log::info("Conversion '{$conversion}' non générée pour le média {$media->id}, utilisation de l'original");

            return $media->getUrl();
        } catch (\Exception $e) {
            Log::error("Erreur lors de la récupération de l'URL du média {$media->id}: ".$e->getMessage());

            return $media->getUrl(); // Fallback sur l'original en cas d'erreur
        }
    }

    /**
     * Récupère tous les médias de la galerie avec leurs URLs optimisées - Version corrigée
     */
    public function getGalleryImagesAttribute(): array
    {
        $cacheKey = "post_{$this->id}_gallery_images";

        return Cache::remember($cacheKey, 3600, function () {
            return $this->getMedia('gallery')->map(function ($media) {
                if (! $media || ! $media->disk) {
                    Log::warning("Média galerie invalide pour le post {$this->id}, media_id: {$media->id}");

                    return null;
                }

                try {
                    return [
                        'id' => $media->id,
                        'url' => $media->getUrl(),
                        'thumb' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
                        'small' => $media->hasGeneratedConversion('small') ? $media->getUrl('small') : $media->getUrl(),
                        'medium' => $media->hasGeneratedConversion('medium') ? $media->getUrl('medium') : $media->getUrl(),
                        'large' => $media->hasGeneratedConversion('large') ? $media->getUrl('large') : $media->getUrl(),
                        'name' => $media->name,
                        'size' => $media->size,
                        'mime_type' => $media->mime_type,
                        'alt_text' => $media->getCustomProperty('alt_text', $this->title),
                    ];
                } catch (\Exception $e) {
                    Log::error("Erreur galerie pour media {$media->id}: ".$e->getMessage());

                    return null;
                }
            })->filter()->values()->toArray();
        });
    }

    /**
     * Récupère l'URL de l'image à la une avec une conversion spécifique
     * Avec mise en cache pour éviter les appels répétés
     * Version améliorée avec plus de logs et de vérifications
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        try {
            $media = $this->getFirstMedia('featured');

            // AJOUT DE LA VÉRIFICATION DU DISQUE ICI
            if (! $media || ! $media->disk) {
                Log::info('No media or disk found for post: '.$this->id);

                return null;
            }

            // Vérifier si la conversion existe
            $hasMedium = $media->hasGeneratedConversion('medium');
            Log::info('Has medium conversion: '.($hasMedium ? 'yes' : 'no'));

            if ($hasMedium) {
                $url = $media->getUrl('medium');
            } else {
                $url = $media->getUrl(); // L'erreur 500 se déclenchait ici
            }

            Log::info('Generated URL: '.$url);

            return $url;
        } catch (\Exception $e) {
            Log::error('Error in getFeaturedImageUrlAttribute: '.$e->getMessage());

            return null;
        }
    }

    public function getFeaturedImageDetailAttribute(): ?string
    {
        $media = $this->getFirstMedia('featured');

        // AJOUT DE LA MÊME VÉRIFICATION ICI
        if (! $media || ! $media->disk) {
            return null;
        }

        return $media->hasGeneratedConversion('large')
            ? $media->getUrl('large')
            : $media->getUrl();
    }

    public function getFeaturedImageCardAttribute(): ?string
    {
        $media = $this->getFirstMedia('featured');

        if (! $media || ! $media->disk) {
            return null;
        }

        return $media->hasGeneratedConversion('card')
            ? $media->getUrl('card')
            : $media->getUrl();
    }

    /**
     * Invalide le cache des images après mise à jour des médias
     */
    public function clearMediaCache(): void
    {
        Cache::forget("post_{$this->id}_featured_image_card");
        Cache::forget("post_{$this->id}_gallery_images");

        foreach (array_keys(self::IMAGE_SIZES) as $conversion) {
            Cache::forget("post_{$this->id}_featured_image_{$conversion}");
        }
    }

    public function getReadingTimeAttribute(): int
    {
        if ($this->reading_time_minutes) {
            return $this->reading_time_minutes;
        }

        $content = $this->content;
        if (is_array($content)) {
            $content = $this->extractTextFromTiptap($content);
        }

        $words = str_word_count(strip_tags((string) ($content ?? '')));

        return (int) ceil($words / 200);
    }

    public function getUrlAttribute(): string
    {
        return route('posts.show', $this->slug);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT => 'gray',
            self::STATUS_PUBLISHED => 'green',
            self::STATUS_SCHEDULED => 'yellow',
            self::STATUS_EXPIRED => 'red',
            self::STATUS_ARCHIVED => 'gray',
            default => 'gray',
        };
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === self::STATUS_PUBLISHED &&
            $this->published_at &&
            $this->published_at->isPast() &&
            (! $this->expires_at || $this->expires_at->isFuture());
    }

    public function getIsScheduledAttribute(): bool
    {
        return $this->status === self::STATUS_SCHEDULED ||
            ($this->scheduled_for && $this->scheduled_for->isFuture());
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?? $this->title;
    }

    public function getMetaDescriptionAttribute($value): string
    {
        // Extraction sécurisée du texte depuis l'excerpt Tiptap
        $text = $value;
        if (empty($text)) {
            $text = $this->getPlainTextContent(160) ?: $this->title;
        }

        return (string) $text;
    }

    /**
     * Get the excerpt attribute.
     * Ensures a valid Tiptap document structure is always returned.
     */
    public function getExcerptAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if (is_array($decoded) && isset($decoded['type']) && ! isset($decoded['content'])) {
                    $decoded['content'] = [];
                }

                return $decoded;
            }

            return $value;
        }

        if (is_array($value) && isset($value['type']) && ! isset($value['content'])) {
            $value['content'] = [];
        }

        return $value;
    }

    public function setContentAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $value = ['type' => 'doc', 'content' => []];
        }

        if (is_string($value)) {
            // Wrap plain HTML/text in a Tiptap doc structure
            $value = ['type' => 'doc', 'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]],
            ]];
        }

        $this->attributes['content'] = json_encode($value);
    }

    public function setExcerptAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $value = ['type' => 'doc', 'content' => []];
        }

        if (is_string($value)) {
            // Wrap plain text in a Tiptap doc structure
            $value = ['type' => 'doc', 'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]],
            ]];
        }

        $this->attributes['excerpt'] = json_encode($value);
    }

    public function getContentAttribute($value)
    {
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                if (is_array($decoded) && isset($decoded['type']) && ! isset($decoded['content'])) {
                    $decoded['content'] = [];
                }

                return $decoded;
            }

            return $value;
        }

        if (is_array($value) && isset($value['type']) && ! isset($value['content'])) {
            $value['content'] = [];
        }

        return $value;
    }

    public function getContentPlainTextAttribute()
    {
        return $this->getPlainTextContent(120);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // ========== SCOPES ==========

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED)
            ->where('published_at', '<=', now())
            ->where(function ($q) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>', now());
            });
    }

    public function scopeDraft($query)
    {
        return $query->where('status', self::STATUS_DRAFT);
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', self::STATUS_SCHEDULED)
            ->orWhere('scheduled_for', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<=', now());
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', fn ($q) => $q->where('posts_categories.id', $categoryId));
    }

    public function scopeSearch($query, string $term)
    {
        return $query->whereFullText(['title'], $term);
    }

    public function scopePopular($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->whereBetween('published_at', [$start, $end]);
    }

    // ========== MÉTHODES PUBLIQUES ==========

    public function publish(): void
    {
        $this->status = self::STATUS_PUBLISHED;
        $this->published_at = now();
        $this->scheduled_for = null;
        $this->save();
        $this->clearMediaCache(); // Nettoyer le cache après modification
    }

    public function schedule(Carbon $date): void
    {
        $this->status = self::STATUS_SCHEDULED;
        $this->scheduled_for = $date;
        $this->save();
        $this->clearMediaCache();
    }

    public function archive(): void
    {
        $this->status = self::STATUS_ARCHIVED;
        $this->save();
        $this->clearMediaCache();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function incrementLikes(): void
    {
        $this->increment('likes_count');
    }

    public function decrementLikes(): void
    {
        $this->decrement('likes_count');
    }

    public function incrementComments(): void
    {
        $this->increment('comments_count');
    }

    public function decrementComments(): void
    {
        $this->decrement('comments_count');
    }

    public function hasCategory($categoryId): bool
    {
        return $this->categories()->where('posts_categories.id', $categoryId)->exists();
    }

    public function syncCategories(array $categoryIds, ?int $mainCategoryId = null): void
    {
        $syncData = [];
        foreach ($categoryIds as $index => $categoryId) {
            $syncData[$categoryId] = [
                'is_primary' => $categoryId === $mainCategoryId,
                'order' => $index,
            ];
        }
        $this->categories()->sync($syncData);
    }

    public function getPreviousPublished(): ?self
    {
        if (is_null($this->published_at)) {
            return null;
        }

        return self::published()
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }

    public function getNextPublished(): ?self
    {
        if (is_null($this->published_at)) {
            return null;
        }

        return self::published()
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at', 'asc')
            ->first();
    }

    public function getRelatedPosts(int $limit = 6)
    {
        $categoryIds = $this->categories()->pluck('posts_categories.id');

        if ($categoryIds->isEmpty()) {
            return collect();
        }

        return self::published()
            ->where('id', '!=', $this->id)
            ->whereHas('categories', fn ($q) => $q->whereIn('posts_categories.id', $categoryIds))
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    // ========== BOOT ==========

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->reading_time_minutes)) {
                $post->reading_time_minutes = $post->reading_time;
            }
            if (empty($post->excerpt)) {
                $post->excerpt = [
                    'type' => 'doc',
                    'content' => [
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => $post->getPlainTextContent(150)],
                            ],
                        ],
                    ],
                ];
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('content') && empty($post->reading_time_minutes)) {
                $post->reading_time_minutes = $post->reading_time;
            }
        });

        // Nettoyer le cache après suppression
        static::deleted(function ($post) {
            $post->clearMediaCache();
        });
    }

    public function bookmarkedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_bookmarks', 'post_id', 'user_id')
            ->withTimestamps();
    }

    public function isBookmarkedBy(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        return $this->bookmarkedBy()->where('user_id', $user->id)->exists();
    }

    /**
     * Get the content attribute.
     * Ensures a valid Tiptap document structure is always returned.
     */
    public function getPlainTextContent(?int $limit = null): string
    {
        $content = $this->content; // déjà un tableau grâce à l'accesseur

        if (isset($content['type']) && $content['type'] === 'doc') {
            $text = $this->extractTextFromTiptap($content);
        } elseif (is_array($content)) {
            $text = $content['body'] ?? $content['text'] ?? json_encode($content);
        } else {
            $text = (string) ($content ?? '');
        }

        $plainText = strip_tags($text);

        return $limit ? Str::limit($plainText, $limit) : $plainText;
    }

    /**
     * Renders rich content from a JSON/array or string field.
     */
    public function renderRichContent(string $field = 'content'): string
    {
        $data = $this->{$field};

        if (is_string($data)) {
            // Si c'est déjà du HTML
            if ($data !== strip_tags($data)) {
                return $data;
            }
            // Convertir le texte brut en paragraphes
            $paragraphs = explode("\n\n", str_replace("\r", '', $data));
            $html = '';
            foreach ($paragraphs as $p) {
                if (trim($p) !== '') {
                    $html .= '<p>'.nl2br(e(trim($p))).'</p>';
                }
            }

            return $html;
        }

        if (is_array($data)) {
            if (isset($data['type']) && $data['type'] === 'doc') {
                if (class_exists(Editor::class)) {
                    return (new Editor)->setContent($data)->getHTML();
                }

                if (class_exists(RichContentRenderer::class)) {
                    return RichContentRenderer::make($data)->toHtml();
                }

                return function_exists('tiptap_converter')
                    ? tiptap_converter()->asHTML($data)
                    : nl2br(e($this->extractTextFromTiptap($data)));
            }

            return $data['body'] ?? $data['text'] ?? '';
        }

        return '';
    }

    /**
     * Extrait récursivement le texte d'un document Tiptap.
     */
    private function extractTextFromTiptap(array $node): string
    {
        $text = '';
        if (isset($node['text'])) {
            $text .= $node['text'];
        }
        if (isset($node['content'])) {
            foreach ($node['content'] as $child) {
                $text .= $this->extractTextFromTiptap($child);
            }
        }

        return $text;
    }
}
