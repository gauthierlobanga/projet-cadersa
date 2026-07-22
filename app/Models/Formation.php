<?php

namespace App\Models;

use App\Traits\HasComments;
use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Tags\HasTags;

class Formation extends Model implements Feedable, HasMedia, HasRichContent, Sitemapable
{
    use HasComments, HasUuids;
    use HasFactory, HasTags, InteractsWithMedia, SoftDeletes;
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

    protected $fillable = [
        'title',
        'slug',
        'subtitle',
        'excerpt',
        'content',
        'location',
        'status',
        'is_active',
        'start_date',
        'end_date',
        'published_at',
        'meta',
        'sort_order',
        'formation_category_id',
        'user_id',
        'views_count',
        'duration',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
        'published_at' => 'datetime',
        'meta' => 'array',
        'content' => 'array',
    ];

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
            ->link(route('formations.show', $this->slug)) // Votre route de détail
            ->authorName($this->user?->name ?? 'Gaudev')
            ->authorEmail($this->user?->email ?? 'gauthierlobanga914@gmail.com');
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
        return Url::create(route('formations.show', $this->slug))
            ->setLastModificationDate($this->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8);
    }

    // --------------------------------------------------------------
    // Boot
    // --------------------------------------------------------------
    protected static function booted(): void
    {
        static::creating(function (Formation $formation) {
            if (empty($formation->slug)) {
                $formation->slug = Str::slug($formation->title ?: 'formation');
            }
        });

        static::updating(function (Formation $formation) {
            if ($formation->isDirty('title') && empty($formation->slug)) {
                $formation->slug = Str::slug($formation->title ?: 'formation');
            }
        });
    }

    // --------------------------------------------------------------
    // Scopes
    // --------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', 'planned')
            ->where('is_active', true)
            ->where('start_date', '>', now());
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing')
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed')
            ->where('is_active', true)
            ->whereNotNull('end_date')
            ->where('end_date', '<', now());
    }

    public function scopeForCategory($query, $categoryId)
    {
        return $query->where('formation_category_id', $categoryId);
    }

    // --------------------------------------------------------------
    // Relations
    // --------------------------------------------------------------
    public function category()
    {
        return $this->belongsTo(FormationCategory::class, 'formation_category_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // --------------------------------------------------------------
    // Media
    // --------------------------------------------------------------
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('gallery')
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        $this->addMediaCollection('videos')
            ->useDisk('public')
            ->acceptsFile(function (File $file) {
                // Accepte tout fichier dont le type MIME commence par "video/"
                return str_starts_with($file->mimeType, 'video/');
            });
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->fit(Fit::Crop, 150, 150)
            ->format('webp')
            ->quality(85)
            ->sharpen(10)
            ->performOnCollections('cover', 'gallery');

        $this->addMediaConversion('card')
            ->width(400)
            ->height(300)
            ->fit(Fit::Crop, 400, 300)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->performOnCollections('cover', 'gallery');

        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->fit(Fit::Contain, 1200, 800)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->performOnCollections('cover', 'gallery');
    }

    /**
     * Récupère la vidéo associée à un chapitre ou une leçon.
     */
    public function getVideoForTarget(string $targetId): ?Media
    {
        return $this->getMedia('videos')->first(
            fn (Media $media) => $media->getCustomProperty('target_id') === $targetId
        );
    }

    // --------------------------------------------------------------
    // Accesseurs
    // --------------------------------------------------------------
    public function coverUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('cover', 'card') ?: null);
    }

    public function thumbUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('cover', 'thumb') ?: null);
    }

    public function largeUrl(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMediaUrl('cover', 'large') ?: null);
    }

    public function galleryUrls(): Attribute
    {
        return Attribute::get(function () {
            return $this->getMedia('gallery')->map(fn ($media) => $media->getUrl('card'))->toArray();
        });
    }

    // --------------------------------------------------------------
    // Méthodes utilitaires
    // --------------------------------------------------------------
    public function getPlainTextContent(int $limit = 200): string
    {
        $content = $this->content;
        if (is_array($content)) {
            $text = $this->extractTextFromTiptap($content);
        } else {
            $text = strip_tags((string) $content);
        }

        return Str::limit($text, $limit);
    }

    public function duration(): Attribute
    {
        return Attribute::get(function () {
            if (! $this->start_date) {
                return null;
            }
            $end = $this->end_date ?? now();

            return $this->start_date->format('d/m/Y').' - '.$end->format('d/m/Y');
        });
    }

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

    public function chaptersCount(): int
    {
        $content = $this->content;
        if (! is_array($content)) {
            return 0;
        }
        $nodes = $content['content'] ?? [];

        return count(array_filter($nodes, fn ($node) => ($node['type'] ?? '') === 'heading' && ($node['attrs']['level'] ?? 0) === 2
        ));
    }
}
