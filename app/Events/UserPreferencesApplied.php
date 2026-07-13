<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Événement déclenché lors de l'application ou de la mise à jour des préférences utilisateur.
 *
 * Permet de diffuser un signal pour rafraîchir l'interface utilisateur en conséquence.
 */
class UserPreferencesApplied
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * Crée une nouvelle instance de l'événement.
     *
     * @param  User  $user  L'utilisateur dont les préférences ont été appliquées.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.'.$this->user->id),
        ];
    }
}
