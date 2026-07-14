<?php

namespace App\Models;

use Filament\Forms\Components\RichEditor\Models\Concerns\InteractsWithRichContent;
use Filament\Forms\Components\RichEditor\Models\Contracts\HasRichContent;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
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
use Tiptap\Nodes\Image;

class Project extends Model implements Feedable, HasMedia, HasRichContent, Sitemapable
{
    use HasFactory, HasTags, HasUuids, InteractsWithMedia, InteractsWithRichContent, SoftDeletes;

    public function setUpRichContent(): void
    {
        $this->registerRichContent('content')
            ->fileAttachmentsDisk('media');

        $this->registerRichContent('excerpt')
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
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
        'excerpt' => 'array',
        'content' => 'array',
    ];

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
            ->authorEmail('contact@cadersa.org');
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

    public function getPdfsAttribute(): Collection
    {
        return $this->getMedia('documents', ['mime_type' => 'application/pdf']);
    }

    // --------------------------------------------------------------
    //  Scopes
    // --------------------------------------------------------------
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('start_date', 'desc');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    public function scopeCompleted($query)
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

    public function getPlainTextContent(?int $limit = null): string
    {
        $content = $this->content;
        if (is_array($content)) {
            $text = $this->extractTextFromTiptap($content);
        } else {
            $text = strip_tags((string) ($content ?? ''));
        }
        $plainText = strip_tags($text);

        return $limit ? Str::limit($plainText, $limit) : $plainText;
    }

    // --------------------------------------------------------------
    //  Accessors
    // --------------------------------------------------------------
    public function getCoverUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'webp') ?: $this->getFirstMediaUrl('cover');
    }

    public function getCoverThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cover', 'thumb');
    }

    public function getGalleryUrlsAttribute(): array
    {
        return $this->getMedia('gallery')->map(fn ($media) => $media->getUrl('webp'))->toArray();
    }

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

    public function getIsOngoingAttribute(): bool
    {
        return $this->status === 'ongoing';
    }

    public function getTagNamesAttribute(): array
    {
        return $this->tags->pluck('name')->toArray();
    }
}
