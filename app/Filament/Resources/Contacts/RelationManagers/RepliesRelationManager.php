<?php

namespace App\Filament\Resources\Contacts\RelationManagers;

use App\Models\ContactReply;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RepliesRelationManager extends RelationManager
{
    protected static string $relationship = 'replies';

    protected static bool $isLazy = false;

    protected static ?string $title = 'Historique des réponses';

    public function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('subject')
            ->columns([
                TextColumn::make('subject')
                    ->label('Objet')
                    ->searchable()
                    ->wrap(),

                TextColumn::make('recipient_email')
                    ->label('Destinataire')
                    ->copyable()
                    ->toggleable(),

                TextColumn::make('body')
                    ->label('Réponse')
                    ->limit(100)
                    ->wrap()
                    ->tooltip(fn (ContactReply $record): string => $record->body),

                TextColumn::make('user.name')
                    ->label('Envoyée par')
                    ->placeholder('Compte supprimé')
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('État')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        ContactReply::STATUS_SENT => 'success',
                        ContactReply::STATUS_SENDING => 'warning',
                        ContactReply::STATUS_FAILED => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        ContactReply::STATUS_SENT => 'Envoyée',
                        ContactReply::STATUS_SENDING => 'En cours',
                        ContactReply::STATUS_FAILED => 'Échec',
                        default => $state,
                    }),

                TextColumn::make('sent_at')
                    ->label('Envoyée le')
                    ->dateTime('d/m/Y H:i')
                    ->since()
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                Action::make('read')
                    ->label('Consulter')
                    ->icon(Heroicon::OutlinedEye)
                    ->color('gray')
                    ->modalHeading(fn (ContactReply $record): string => $record->status === ContactReply::STATUS_FAILED
                        ? 'Détails de l’échec d’envoi'
                        : 'Détails de la réponse')
                    ->fillForm(fn (ContactReply $record): array => [
                        'subject' => $record->subject,
                        'recipient_email' => $record->recipient_email,
                        'body' => $record->body,
                        'status' => $record->status,
                        'failure_reason' => $record->failure_reason,
                    ])
                    ->schema([
                        TextInput::make('recipient_email')
                            ->label('Destinataire')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('subject')
                            ->label('Objet')
                            ->disabled()
                            ->dehydrated(false),
                        Textarea::make('body')
                            ->label('Message envoyé')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(10),
                        TextInput::make('status')
                            ->label('État technique')
                            ->disabled()
                            ->dehydrated(false),
                        Textarea::make('failure_reason')
                            ->label('Détail technique')
                            ->disabled()
                            ->dehydrated(false)
                            ->rows(4)
                            ->visible(fn (ContactReply $record): bool => $record->status === ContactReply::STATUS_FAILED),
                    ])
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fermer'),
            ])
            ->emptyStateHeading('Aucune réponse envoyée')
            ->emptyStateDescription('Les réponses envoyées depuis cette fiche apparaîtront ici.');
    }
}
