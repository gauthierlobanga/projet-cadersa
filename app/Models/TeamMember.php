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

class TeamMember extends Model implements HasMedia
{
    use HasFactory, HasUuids, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'name', 'role', 'bio', 'email', 'social_links', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'social_links' => 'array',
    ];

    // ========== MEDIA COLLECTIONS ==========

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp']);
    }

    // ========== MEDIA CONVERSIONS ==========

    public function registerMediaConversions(?Media $media = null): void
    {
        // Miniature carrée (150x150) – pour les listes, avatars
        $this->addMediaConversion('thumb')
            ->width(150)
            ->height(150)
            ->fit(Fit::Crop, 150, 150)
            ->format('webp')
            ->quality(90)
            ->sharpen(10)
            ->optimize()
            ->performOnCollections('photo');

        // Photo de profil (400x400) – pour la page détail, carte équipe
        // Le nom 'webp' est conservé pour compatibilité avec l'accessor existant
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

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // ========== ACCESSORS ==========

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('photo', 'webp') ?: $this->getFirstMediaUrl('photo');
    }

    public function getPhotoThumbUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('photo', 'thumb');
    }

    public function getInitialsAttribute(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';
        foreach ($words as $word) {
            if (! empty($word)) {
                $initials .= strtoupper($word[0]);
            }
        }

        return substr($initials, 0, 2);
    }

    public function getFullNameAttribute(): string
    {
        return $this->name;
    }
}
