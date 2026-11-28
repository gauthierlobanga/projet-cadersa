<?php

namespace App\Observers;

use App\Models\Formation;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Services\AdminEmailNotificationService;
use Illuminate\Support\Carbon;

class ContentPublicationObserver
{
    public function __construct(private AdminEmailNotificationService $notifications) {}

    public function created(Post|Project|Service|Formation $content): void
    {
        $this->notifyIfPublished($content, wasPublished: false);
    }

    public function updated(Post|Project|Service|Formation $content): void
    {
        $this->notifyIfPublished($content, wasPublished: $this->wasPublished($content));
    }

    private function notifyIfPublished(Post|Project|Service|Formation $content, bool $wasPublished): void
    {
        if ($wasPublished || ! $this->isPublished($content)) {
            return;
        }

        [$type, $url] = match (true) {
            $content instanceof Post => ['Article', route('posts.show', $content->slug)],
            $content instanceof Project => ['Projet', route('projects.show', $content->slug)],
            $content instanceof Service => ['Service', route('services.show', $content->slug)],
            $content instanceof Formation => ['Formation', route('formations.show', $content->slug)],
        };

        $this->notifications->notifyAdministrators('Nouvelle publication : '.$type, [
            'Type' => $type,
            'Titre' => $content->title,
            'Lien' => $url,
        ]);
    }

    private function isPublished(Post|Project|Service|Formation $content): bool
    {
        return match (true) {
            $content instanceof Post => $content->status === Post::STATUS_PUBLISHED
                && $this->isPublicationDateReached($content->published_at),
            $content instanceof Project, $content instanceof Service => (bool) $content->is_active,
            $content instanceof Formation => (bool) $content->is_active
                && $this->isPublicationDateReached($content->published_at),
        };
    }

    private function wasPublished(Post|Project|Service|Formation $content): bool
    {
        return match (true) {
            $content instanceof Post => $content->getOriginal('status') === Post::STATUS_PUBLISHED
                && $this->isPublicationDateReached($content->getOriginal('published_at')),
            $content instanceof Project, $content instanceof Service => (bool) $content->getOriginal('is_active'),
            $content instanceof Formation => (bool) $content->getOriginal('is_active')
                && $this->isPublicationDateReached($content->getOriginal('published_at')),
        };
    }

    private function isPublicationDateReached(mixed $date): bool
    {
        return filled($date) && Carbon::parse($date)->lessThanOrEqualTo(now());
    }
}
