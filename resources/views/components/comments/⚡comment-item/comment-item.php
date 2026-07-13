<?php

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

new class extends Component
{
    public Comment $comment;

    public $commentableType;

    public $commentableId;

    public $replyContent = '';

    public $showReplyForm = false;

    public $isAuthor = false;

    public function mount(Comment $comment, $commentableType, $commentableId)
    {
        $this->comment = $comment->load('user', 'approvedReplies.user');
        $this->commentableType = $commentableType;
        $this->commentableId = $commentableId;
        $this->isAuthor = Auth::check() && Auth::id() === $comment->user_id;

    }

    public function like()
    {
        if (! Auth::check()) {
            return;
        }
        $this->comment->toggleLike(Auth::user());
        $this->comment->refresh();
    }

    public function addReply()
    {
        if (! Auth::check()) {
            return;
        }
        if (empty(trim($this->replyContent))) {
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

        try {
            $model->addComment(Auth::user(), $this->replyContent, $this->comment);
            $this->replyContent = '';
            $this->showReplyForm = false;
            $this->comment->refresh();
        } catch (Exception $e) {
            Log::error('Reply error: '.$e->getMessage());
        }
    }
};
