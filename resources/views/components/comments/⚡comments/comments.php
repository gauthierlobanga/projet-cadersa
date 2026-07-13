<?php

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $commentableType;

    public $commentableId;

    public $newComment = '';

    public $comments = []; // ← propriété publique accessible dans la vue

    public function mount($commentableType, $commentableId)
    {
        $this->commentableType = $commentableType;
        $this->commentableId = $commentableId;
        $this->loadComments();
    }

    public function loadComments()
    {
        $type = str_replace('\\\\', '\\', $this->commentableType);
        $this->comments = Comment::where('commentable_type', $type)
            ->where('commentable_id', $this->commentableId)
            ->whereNull('parent_id')
            ->with(['user', 'approvedReplies.user'])   // ← uniquement les réponses approuvées
            ->approved()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function addComment()
    {
        if (! Auth::check()) {
            return;
        }
        if (empty(trim($this->newComment))) {
            return;
        }

        $type = str_replace('\\\\', '\\', $this->commentableType);
        $modelClass = $type;
        if (! class_exists($modelClass)) {
            return;
        }

        $model = $modelClass::find($this->commentableId);
        if (! $model) {
            return;
        }

        $model->addComment(Auth::user(), $this->newComment);
        $this->newComment = '';
        $this->loadComments();
    }
};
