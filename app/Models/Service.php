<?php

namespace App\Models;

use App\Traits\HasComments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tiptap\Editor;

class Service extends Model implements HasMedia
{
    use HasComments, HasUuids;
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'icon',
        'is_active',
        'sort_order',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'excerpt' => 'array',
            'content' => 'array',
        ];
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'image_url',
        'image_thumb_url',
        'short_excerpt',
    ];

    /**
     * Boot the model.
     */
    protected static function booted(): void
    {
        static::creating(function (self $service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::updating(function (self $service) {
            if ($service->isDirty('title') && empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::deleted(function (self $service) {
            $service->clearMediaCache();
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

    /**
     * Register media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
            ->withResponsiveImages();
    }

    /**
     * Register media conversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Miniature (150x150) – pour les listes, cartes compactes
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->fit(Fit::Crop, 150, 150)
            ->format('webp')
            ->quality(90)                     // 80 → 90
            ->sharpen(10)                     // netteté renforcée
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('image');

        // Carte (400x300) – pour les grilles de services, mise en avant
        $this->addMediaConversion('card')
            ->width(400)
            ->height(300)
            ->fit(Fit::Crop, 400, 300)
            ->format('webp')
            ->quality(90)                     // 85 → 90
            ->sharpen(10)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('image');

        // Grande taille (1200x800) – pour la page détail, affichage principal
        $this->addMediaConversion('large')
            ->width(1200)
            ->height(800)
            ->fit(Fit::Contain, 1200, 800)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)                     // ajouté
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('image');
    }

    /**
     * Clear media cache for this service.
     */
    public function clearMediaCache(): void
    {
        Cache::forget("service_{$this->id}_image_url");
        Cache::forget("service_{$this->id}_image_thumb_url");
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /**
     * Scope a query to only include active services.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order services by sort_order and title.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    /**
     * Scope a query to search services by title or excerpt.
     */
    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'LIKE', "%{$term}%");
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Get the image URL (cached).
     */
    public function getImageUrlAttribute(): ?string
    {
        return Cache::remember("service_{$this->id}_image_url", 3600, function () {
            $media = $this->getFirstMedia('image');
            if (! $media || ! $media->disk) {
                return null;
            }

            return $media->hasGeneratedConversion('large')
                ? $media->getUrl('large')
                : $media->getUrl();
        });
    }

    /**
     * Get the image thumbnail URL (cached).
     */
    public function getImageThumbUrlAttribute(): ?string
    {
        return Cache::remember("service_{$this->id}_image_thumb_url", 3600, function () {
            $media = $this->getFirstMedia('image');
            if (! $media || ! $media->disk) {
                return null;
            }

            return $media->hasGeneratedConversion('thumb')
                ? $media->getUrl('thumb')
                : $media->getUrl();
        });
    }

    /**
     * Get a short excerpt (limit 120 chars).
     */
    public function getShortExcerptAttribute(): string
    {
        $text = $this->excerpt;
        if (is_array($text)) {
            $text = $this->extractTextFromTiptap($text);
        }

        return Str::limit(strip_tags((string) $text), 120);
    }

    /**
     * Get the excerpt with line breaks converted to <br>.
     */
    public function getExcerptHtmlAttribute(): string
    {
        return $this->renderRichContent('excerpt');
    }

    /**
     * Get the icon as HTML (with escaping).
     */
    public function getIconHtmlAttribute(): string
    {
        return $this->icon ? '<i class="'.e($this->icon).'"></i>' : '';
    }

    /**
     * Get the URL to the service detail page.
     */
    public function getUrlAttribute(): string
    {
        return route('services.show', $this->slug);
    }

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

                return function_exists('tiptap_converter')
                    ? tiptap_converter()->asHTML($data)
                    : nl2br(e($this->extractTextFromTiptap($data)));
            }

            return $data['body'] ?? $data['text'] ?? '';
        }

        return '';
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
     * Get the plain text content (without HTML tags).
     */
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
}
