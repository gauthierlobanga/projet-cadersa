<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Testimonial extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia, SoftDeletes;

    /**
     * Indique que les clés primaires sont de type string (UUID)
     */
    protected $keyType = 'string';

    /**
     * Indique que les clés primaires ne sont pas auto-incrémentées
     */
    public $incrementing = false;

    protected $fillable = [
        'name', 'role', 'company', 'content', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ========== MEDIA COLLECTIONS ==========

    /**
     * registerMediaCollections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // ========== MEDIA CONVERSIONS ==========

    /**
     * registerMediaConversions.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Miniature (150x150) – pour les listes, aperçus
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->fit(Fit::Crop, 150, 150)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('photo');

        // Photo principale (400x400) – pour la page témoignage, carte détaillée
        // Le nom 'webp' est conservé pour compatibilité avec l'accessor
        $this->addMediaConversion('webp')
            ->width(400)
            ->height(400)
            ->fit(Fit::Crop, 400, 400)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('photo');
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
        return $query->orderBy('created_at', 'desc');
    }

    // ========== ACCESSORS ==========

    /**
     * getPhotoUrlAttribute.
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('photo', 'webp') ?: $this->getFirstMediaUrl('photo');
    }

    /**
     * getPhotoThumbUrlAttribute.
     */
    public function getPhotoThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('photo', 'thumb');
    }

    /**
     * getFullNameAttribute.
     */
    public function getFullNameAttribute(): string
    {
        return $this->name.($this->role ? ' ('.$this->role.')' : '');
    }

    /**
     * getExcerptAttribute.
     */
    public function getExcerptAttribute(): string
    {
        return Str::limit($this->content, 150);
    }
}
