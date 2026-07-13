<?php

namespace App\Filament\Resources\CadersaAsblDocumentLegals\Tables;

use App\Models\TypeDocumentLegal;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class CadersaAsblDocumentLegalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('typeDocument.nom')
                    ->label('Document')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->typeDocument?->code)
                    ->icon(fn ($record) => $record->typeDocument?->est_obligatoire ? 'heroicon-m-star' : null)
                    ->iconColor('warning'),

                TextColumn::make('typeDocument.forme_juridique')
                    ->label('Forme juridique')
                    ->formatStateUsing(fn ($state) => TypeDocumentLegal::getFormeJuridiqueLabel($state))
                    ->badge()
                    ->color('gray')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('numero_document')
                    ->label('N° Document')
                    ->searchable()
                    ->fontFamily('mono')
                    ->copyable()
                    ->copyMessage('Numéro copié !')
                    ->placeholder('Non renseigné'),

                TextColumn::make('date_delivrance')
                    ->label('Délivrance')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('date_expiration')
                    ->label('Expiration')
                    ->date('d/m/Y')
                    ->sortable()
                    ->badge()
                    ->color(fn ($record) => self::getExpirationColor($record))
                    ->icon(fn ($record) => self::getExpirationIcon($record))
                    ->tooltip(fn ($record) => self::getExpirationTooltip($record)),

                TextColumn::make('est_verifie')
                    ->label('Statut')
                    ->formatStateUsing(fn ($record) => $record->est_verifie ? 'Vérifié' : 'En attente')
                    ->badge()
                    ->color(fn ($record) => $record->est_verifie ? 'success' : 'warning')
                    ->icon(fn ($record) => $record->est_verifie ? 'heroicon-m-check-badge' : 'heroicon-m-clock')
                    ->description(fn ($record) => $record->verifie_le
                        ? $record->verifie_le->format('d/m/Y')
                        : 'Action requise'),

                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['typeDocument']))
            ->filters([
                TernaryFilter::make('est_verifie')
                    ->label('Statut de vérification')
                    ->indicator('Statut'),

                SelectFilter::make('typeDocument.forme_juridique')
                    ->label('Forme juridique')
                    ->options(TypeDocumentLegal::getFormeJuridiqueOptions())
                    ->multiple()
                    ->preload(),

                Filter::make('expired')
                    ->label('Documents expirés')
                    ->query(fn (Builder $query) => $query
                        ->whereNotNull('date_expiration')
                        ->where('date_expiration', '<', now())
                    )
                    ->toggle()
                    ->indicator('Expirés'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('verify')
                        ->label('Valider le document')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(fn ($record) => $record->update([
                            'est_verifie' => true,
                            'verifie_le' => now(),
                            'verifie_par' => Auth::id(),
                        ]))
                        ->visible(fn ($record) => ! $record->est_verifie),

                    Action::make('unverify')
                        ->label('Révoquer la validation')
                        ->icon('heroicon-o-arrow-uturn-left')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->update([
                            'est_verifie' => false,
                            'verifie_le' => null,
                            'verifie_par' => null,
                        ]))
                        ->visible(fn ($record) => $record->est_verifie),

                    EditAction::make(),
                    DeleteAction::make(),
                ])->tooltip('Gérer le document'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('verify_selected')
                        ->label('Vérifier la sélection')
                        ->icon('heroicon-o-check-badge')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                $record->update([
                                    'est_verifie' => true,
                                    'verifie_le' => now(),
                                    'verifie_par' => Auth::id(),
                                ]);
                            }
                        }),
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('est_verifie', 'asc')
            ->defaultGroup('typeDocument.est_obligatoire');
    }

    private static function getExpirationColor($record): ?string
    {
        if (! $record->date_expiration) {
            return 'gray';
        }
        if ($record->date_expiration->isPast()) {
            return 'danger';
        }
        if ($record->date_expiration->diffInDays(now()) <= 30) {
            return 'warning';
        }

        return 'success';
    }

    private static function getExpirationIcon($record): ?string
    {
        if (! $record->date_expiration) {
            return null;
        }
        if ($record->date_expiration->isPast()) {
            return 'heroicon-m-exclamation-triangle';
        }
        if ($record->date_expiration->diffInDays(now()) <= 30) {
            return 'heroicon-m-clock';
        }

        return 'heroicon-m-shield-check';
    }

    private static function getExpirationTooltip($record): ?string
    {
        if (! $record->date_expiration) {
            return 'Aucune date d\'expiration définie';
        }
        if ($record->date_expiration->isPast()) {
            return 'Expiré depuis le '.$record->date_expiration->format('d/m/Y');
        }

        return 'Valide jusqu\'au '.$record->date_expiration->format('d/m/Y');
    }
}
