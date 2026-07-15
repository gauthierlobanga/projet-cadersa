/**
 * Method.
 *
 * @return mixed
 */
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasUuids;

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

    protected $table = 'announcements';

    protected $fillable = [
        'target_audience',
        'type',
        'title',
        'message',
        'action_url',
        'action_text',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    /**
     * scopeActive.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            });
    }

    /**
     * scopeForVendors.
     */
    public function scopeForVendors(Builder $query): Builder
    {
        return $query->whereIn('target_audience', ['all', 'vendors']);
    }

    /**
     * scopeForBuyers.
     */
    public function scopeForBuyers(Builder $query): Builder
    {
        return $query->whereIn('target_audience', ['all', 'buyers']);
    }
}
