<?php

use App\Models\Comment;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $commentableType;

    public $commentableId;

    public $newComment = '';

    public $comments = []; // ← propriété publique accessible dans la vue

    protected $rules = [
        'newComment' => 'required|string|min:1',
    ];

    public function mount($commentableType, $commentableId)
    {
        $this->commentableType = $commentableType;
        $this->commentableId = $commentableId;
        $this->loadComments();
    }

    public function updated($propertyName)
    {
        // Validation en temps réel pour la propriété modifiée
        $this->validateOnly($propertyName);
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
            // envoyer un toast FluxUI côté serveur pour inviter à se connecter
            Flux::toast(variant: 'warning', text: 'Veuillez vous connecter pour poster un commentaire.');
            session()->flash('error', 'Veuillez vous connecter pour poster un commentaire.');
            return;
        }

        // Valider côté serveur (empêche soumission d'un champ vide et envoie erreurs Livewire)
        $this->validate();

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

        // succès : petit toast FluxUI côté serveur
        Flux::toast(variant: 'success', text: 'Commentaire publié avec succès.');
    }


};
