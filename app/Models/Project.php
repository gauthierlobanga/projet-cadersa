<?php

namespace App\Models;

use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Spatie\Tags\HasTags;
use Tiptap\Nodes\Image;

class Project extends Model implements Feedable, HasMedia, HasRichContent, Sitemapable
{
    use HasFactory, HasTags, HasUuids, InteractsWithMedia, InteractsWithRichContent, Searchable, SoftDeletes;

    public function setUpRichContent(): void
    {
        $this->registerRichContent('content')
            ->fileAttachmentsDisk('media');

        $this->registerRichContent('excerpt')
            ->fileAttachmentsDisk('media');

        $this->registerRichContent('problematic')
            ->fileAttachmentsDisk('media');

        $this->registerRichContent('solution')
            ->fileAttachmentsDisk('media');

        $this->registerRichContent('results')
            ->fileAttachmentsDisk('media');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

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
        'title', 'slug', 'excerpt', 'content', 'location',
        'status', 'start_date', 'end_date', 'is_active',
        'website_url', 'repository_url',
        'problematic', 'solution', 'results', 'meta_title', 'meta_description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'excerpt' => 'array',
        'content' => 'array',
        'problematic' => 'array',
        'solution' => 'array',
        'results' => 'array',
    ];

    /**
     * Define the columns used by Scout's database search engine.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->getRawOriginal('excerpt'),
            'content' => $this->getRawOriginal('content'),
            'problematic' => $this->getRawOriginal('problematic'),
            'solution' => $this->getRawOriginal('solution'),
            'results' => $this->getRawOriginal('results'),
            'location' => $this->location,
            'status' => $this->status,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
        ];
    }

    public function shouldBeSearchable(): bool
    {
        return (bool) $this->is_active;
    }

    // --------------------------------------------------------------
    //  Feed
    // --------------------------------------------------------------
    public function toFeedItem(): FeedItem
    {
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($this->getPlainTextContent(200) ?: $this->title)
            ->updated($this->updated_at)
            ->link(route('projects.show', $this->slug))
            ->authorName('CADERSA')
            ->authorEmail('cadersa.asbl@gmail.com');
    }

    public static function getFeedItems()
    {
        return self::active()->latest('start_date')->take(20)->get();
    }

    /**
     * @return Url|string|array<string, mixed>
     */
    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('projects.show', $this->slug))
            ->setLastModificationDate($this->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.7);
    }

    // --------------------------------------------------------------
    //  Boot
    // --------------------------------------------------------------
    protected static function booted(): void
    {
        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    public function setContentAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $value = ['type' => 'doc', 'content' => []];
        }
        if (is_string($value)) {
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
            $value = ['type' => 'doc', 'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]],
            ]];
        }
        $this->attributes['excerpt'] = json_encode($value);
    }

    public function setProblematicAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $value = ['type' => 'doc', 'content' => []];
        }
        if (is_string($value)) {
            $value = ['type' => 'doc', 'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]],
            ]];
        }
        $this->attributes['problematic'] = json_encode($value);
    }

    public function setSolutionAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $value = ['type' => 'doc', 'content' => []];
        }
        if (is_string($value)) {
            $value = ['type' => 'doc', 'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]],
            ]];
        }
        $this->attributes['solution'] = json_encode($value);
    }

    public function setResultsAttribute($value): void
    {
        if (is_null($value) || $value === '') {
            $value = ['type' => 'doc', 'content' => []];
        }
        if (is_string($value)) {
            $value = ['type' => 'doc', 'content' => [
                ['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $value]]],
            ]];
        }
        $this->attributes['results'] = json_encode($value);
    }

    // --------------------------------------------------------------
    //  Media Collections
    // --------------------------------------------------------------
    public function registerMediaCollections(): void
    {
        // Collection "cover" : une seule image
        $this->addMediaCollection('cover')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        // Collection "gallery" : plusieurs images
        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);

        // Collection pour les documents PDF
        $this->addMediaCollection('documents')
            ->useDisk('public')
            ->acceptsMimeTypes(['application/pdf'])
            ->withResponsiveImages(); // Optionnel pour les aperçus
    }

    // --------------------------------------------------------------
    //  Media Conversions (globales, appliquées après ajout du média)
    // --------------------------------------------------------------
    public function registerMediaConversions(?Media $media = null): void
    {
        // Conversion "thumb" pour toutes les collections
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->fit(Fit::Crop, 300, 200)
            ->sharpen(10)
            ->nonQueued();

        // Conversion "webp" : format webp, qualité 80
        $this->addMediaConversion('webp')
            ->format('webp')
            ->quality(80)
            ->nonQueued();
    }

    // Méthodes utilitaires
    public function hasPdf(): bool
    {
        return $this->getFirstMedia('documents', ['mime_type' => 'application/pdf']) !== null;
    }

    public function getPdfUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('documents', ['mime_type' => 'application/pdf']);

        return $media?->getUrl();
    }

    /**
     * Récupère tous les PDFs attachés.
     *
     * @return Collection<int, Media>
     */
    public function getPdfsAttribute(): Collection
    {
        return $this->getMedia('documents', ['mime_type' => 'application/pdf']);
    }

    // --------------------------------------------------------------
    //  Scopes
    // --------------------------------------------------------------
    /**
     * scopeActive.
     *
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * scopeOrdered.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('start_date', 'desc');
    }

    /**
     * scopeByStatus.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeByStatus(Builder $query, $status): Builder
    {
        return $query->where('status', $status);
    }

    /**
     * scopeOngoing.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOngoing(Builder $query): Builder
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * scopeCompleted.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
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

    /**
     * getPlainTextContent.
     */
    public function getPlainTextContent(?int $limit = null): string
    {
        $content = $this->content; // déjà casté en array normalement

        // Si pour une raison quelconque c'est une chaîne (ex: double encodage),
        // on tente de la décoder en tableau.
        if (is_string($content)) {
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $content = $decoded;
            } else {
                // Pas de JSON valide : on nettoie et on limite
                $text = strip_tags($content);

                return $limit ? Str::limit($text, $limit) : $text;
            }
        }

        if (is_array($content)) {
            $text = $this->extractTextFromTiptap($content);
        } else {
            $text = '';
        }

        return $limit ? Str::limit($text, $limit) : $text;
    }

    // --------------------------------------------------------------
    //  Accessors
    // --------------------------------------------------------------
    /**
     * getCoverUrlAttribute.
     */
    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'webp') ?: $this->getFirstMediaUrl('cover');
    }

    /**
     * getCoverThumbUrlAttribute.
     */
    public function getCoverThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'thumb');
    }

    /**
     * getGalleryUrlsAttribute.
     */
    public function getGalleryUrlsAttribute(): array
    {
        return $this->getMedia('gallery')->map(fn ($media) => $media->getUrl('webp'))->toArray();
    }

    /**
     * getDurationAttribute.
     */
    public function getDurationAttribute(): ?string
    {
        if ($this->start_date && $this->end_date) {
            return $this->start_date->format('M Y').' - '.$this->end_date->format('M Y');
        }
        if ($this->start_date) {
            return 'Depuis '.$this->start_date->format('M Y');
        }

        return null;
    }

    /**
     * getIsOngoingAttribute.
     */
    public function getIsOngoingAttribute(): bool
    {
        return $this->status === 'ongoing';
    }

    /**
     * getTagNamesAttribute.
     */
    public function getTagNamesAttribute(): array
    {
        return $this->tags->pluck('name')->toArray();
    }
}
