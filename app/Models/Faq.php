<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Faq extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['question', 'answer', 'is_active', 'sort_order'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scopes
    /**
     * scopeActive.
     *
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * scopeOrdered.

     *

     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('question');
    }

    // Accessors
    /**
     * getFormattedQuestionAttribute.
     */
    public function getFormattedQuestionAttribute(): string
    {
        return ucfirst($this->question);
    }

    /**
     * getFormattedAnswerAttribute.
     */
    public function getFormattedAnswerAttribute(): string
    {
        return nl2br(e($this->answer));
    }
}
