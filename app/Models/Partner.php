/**
 * Method.
 *
 * @return mixed
 */
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Partner extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia, SoftDeletes;

    protected $fillable = ['name', 'url', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ========== MEDIA COLLECTIONS ==========

    /**
     * registerMediaCollections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml']);
    }

    // ========== MEDIA CONVERSIONS ==========

    /**
     * registerMediaConversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Miniature (150x150) – pour les listes, tableaux
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->fit(Fit::Contain, 150, 150)   // préserve le logo sans rogner
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('logo');

        // Conversion principale (400x400) – pour la page partenaire, cartes
        $this->addMediaConversion('webp')
            ->width(400)
            ->height(400)
            ->fit(Fit::Contain, 400, 400)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('logo');
    }

    // ========== SCOPES ==========

    /**
     * scopeActive.

     *

     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * scopeOrdered.

     *

     * @return mixed
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ========== ACCESSORS ==========

    /**
     * getLogoUrlAttribute.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo', 'webp') ?: $this->getFirstMediaUrl('logo');
    }

    /**
     * getLogoThumbUrlAttribute.
     */
    public function getLogoThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo', 'thumb');
    }
}
