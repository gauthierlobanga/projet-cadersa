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
