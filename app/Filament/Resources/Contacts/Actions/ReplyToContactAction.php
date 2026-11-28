<?php

namespace App\Filament\Resources\Contacts\Actions;

use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\User;
use App\Services\ContactReplyService;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;

class ReplyToContactAction
{
    public static function make(): Action
    {
        return Action::make('reply')
            ->label('Répondre par e-mail')
            ->icon(Heroicon::OutlinedEnvelope)
            ->color('success')
            ->modalHeading('Répondre au contact')
            ->modalDescription('La réponse sera envoyée depuis l’adresse e-mail de CADERSA.')
            ->modalWidth('2xl')
            ->modalSubmitActionLabel('Envoyer la réponse')
            ->visible(fn (Contact $record): bool => $record->status !== Contact::STATUS_SPAM)
            ->fillForm(fn (Contact $record): array => [
                'recipient_email' => $record->email,
                'subject' => preg_match('/^re\s*:/i', $record->sujet) === 1
                    ? $record->sujet
                    : 'Re : '.$record->sujet,
                'body' => 'Bonjour '.$record->full_name.",\n\nNous avons bien reçu votre message et vous remercions de nous avoir contactés. Notre équipe va examiner votre demande et reviendra vers vous dans les meilleurs délais.\n\nBien cordialement,\nL’équipe CADERSA",
                'include_original' => true,
            ])
            ->schema([
                TextInput::make('recipient_email')
                    ->label('Destinataire')
                    ->disabled()
                    ->dehydrated(false)
                    ->prefixIcon('heroicon-m-envelope'),

                TextInput::make('subject')
                    ->label('Objet')
                    ->required()
                    ->maxLength(255),

                Select::make('quick_template')
                    ->label('Réponse rapide')
                    ->placeholder('Choisir une réponse préremplie')
                    ->options([
                        'acknowledgement' => 'Accusé de réception',
                        'request_details' => 'Demander des précisions',
                        'follow_up' => 'Informer du suivi en cours',
                    ])
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set, Contact $record): void {
                        if (! $state) {
                            return;
                        }

                        $greeting = 'Bonjour '.$record->full_name.',';

                        $set('body', match ($state) {
                            'acknowledgement' => $greeting."\n\nNous vous remercions pour votre message. Nous l’avons bien reçu et notre équipe va l’examiner. Nous reviendrons vers vous dans les meilleurs délais.\n\nBien cordialement,\nL’équipe CADERSA",
                            'request_details' => $greeting."\n\nAfin de traiter votre demande au mieux, pourriez-vous nous transmettre quelques précisions complémentaires ?\n\nMerci d’avance pour votre retour.\n\nBien cordialement,\nL’équipe CADERSA",
                            'follow_up' => $greeting."\n\nVotre demande est en cours de traitement par notre équipe. Nous vous tiendrons informé(e) dès que nous aurons les éléments nécessaires.\n\nMerci de votre patience.\n\nBien cordialement,\nL’équipe CADERSA",
                            default => '',
                        });
                    }),

                Textarea::make('body')
                    ->label('Votre réponse')
                    ->required()
                    ->minLength(10)
                    ->maxLength(10000)
                    ->rows(12)
                    ->autosize()
                    ->columnSpanFull(),

                Toggle::make('include_original')
                    ->label('Inclure le message initial dans l’e-mail')
                    ->default(true)
                    ->inline(false)
                    ->columnSpanFull(),
            ])
            ->action(function (array $data, Contact $record): void {
                $user = Filament::auth()->user();

                if (! $user instanceof User) {
                    Notification::make()
                        ->danger()
                        ->title('Réponse impossible')
                        ->body('Votre session administrateur doit être renouvelée.')
                        ->send();

                    return;
                }

                $reply = app(ContactReplyService::class)->send(
                    contact: $record,
                    user: $user,
                    subject: $data['subject'],
                    body: $data['body'],
                    includeOriginal: (bool) ($data['include_original'] ?? false),
                );

                if ($reply->status === ContactReply::STATUS_SENT) {
                    Notification::make()
                        ->success()
                        ->title('Réponse envoyée')
                        ->body('Votre message a été envoyé à '.$record->email.'.')
                        ->send();
                } else {
                    Notification::make()
                        ->danger()
                        ->title('Échec de l’envoi')
                        ->body('La réponse n’a pas été envoyée. Vérifiez la configuration e-mail puis réessayez.')
                        ->send();
                }
            });
    }
}
