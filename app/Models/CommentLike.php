<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommentLike extends Model
{
    use HasUuids;

    protected $table = 'comment_likes';

    protected $fillable = ['comment_id', 'user_id', 'type'];

    protected function casts(): array
    {
        return ['type' => 'string'];
    }

    public const string TYPE_LIKE = 'like';

    public const string TYPE_DISLIKE = 'dislike';

    /**
     * comment.
     */
    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }

    /**
     * user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
