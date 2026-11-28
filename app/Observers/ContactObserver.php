<?php

namespace App\Observers;

use App\Mail\ContactReceivedMail;
use App\Models\Contact;
use App\Services\AdminEmailNotificationService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ContactObserver
{
    public function __construct(private AdminEmailNotificationService $notifications) {}

    public function created(Contact $contact): void
    {
        Mail::to($contact->email)->queue(new ContactReceivedMail(
            recipientName: $contact->full_name,
            recipientEmail: $contact->email,
            contactSubject: $contact->sujet,
            contactMessage: $contact->message,
            reference: Str::upper(Str::substr((string) $contact->getKey(), 0, 8)),
        ));

        $this->notifications->notifyAdministrators('Nouveau message de contact', [
            'Nom' => $contact->full_name,
            'E-mail' => $contact->email,
            'Téléphone' => $contact->telephone ?: 'Non renseigné',
            'Catégorie' => Contact::getCategories()[$contact->categorie] ?? $contact->categorie,
            'Priorité' => Contact::getPriorites()[$contact->priorite] ?? $contact->priorite,
            'Sujet' => $contact->sujet,
            'Message' => $contact->message,
        ], route('filament.admin.resources.contacts.edit', $contact));
    }
}
