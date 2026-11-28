<?php

namespace App\Observers;

use App\Mail\WelcomeUserMail;
use App\Models\User;
use App\Services\AdminEmailNotificationService;
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    public function __construct(private AdminEmailNotificationService $notifications) {}

    public function created(User $user): void
    {
        Mail::to($user->email)->queue(new WelcomeUserMail(
            userName: $user->name,
            userEmail: $user->email,
            loginUrl: route('login'),
            emailVerified: $user->hasVerifiedEmail(),
        ));

        $this->notifications->notifyAdministrators('Création d’un compte utilisateur', [
            'Nom' => $user->name,
            'E-mail' => $user->email,
            'Créé le' => $user->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i'),
        ]);
    }
}
