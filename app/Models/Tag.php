<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name', 'slug', 'type', 'order_column', 'color', 'description', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_column' => 'integer',
    ];

    protected $attributes = [
        'is_active' => true,
        'order_column' => 0,
    ];

    /**
     * Force la génération de l'UUID avant création.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $tag) {
            if (empty($tag->id)) {
                $tag->id = (string) Str::orderedUuid();
            }
        });
    }

    /**
     * scopeActive.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * getTranslatedNameAttribute.
     */
    public function getTranslatedNameAttribute(): string
    {
        return $this->getTranslation('name', app()->getLocale());
    }

    /**
     * getTranslatedSlugAttribute.
     */
    public function getTranslatedSlugAttribute(): string
    {
        return $this->getTranslation('slug', app()->getLocale());
    }
}
