<?php

namespace App\Filament\Resources\Announcements\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AnnouncementsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Titre')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->limit(50)
                    ->tooltip(fn ($state) => $state),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'info' => 'info',
                        'success', 'promo' => 'success',
                        'warning' => 'warning',
                        'danger' => 'danger',
                        'feature' => 'primary',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'info' => 'Information',
                        'success' => 'Succès',
                        'warning' => 'Avertissement',
                        'danger' => 'Urgent',
                        'promo' => 'Promotion',
                        'feature' => 'Nouveauté',
                        default => $state,
                    }),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('starts_at')
                    ->label('Début')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Immédiat'),

                TextColumn::make('ends_at')
                    ->label('Fin')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Illimitée'),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'info' => 'Information',
                        'success' => 'Succès',
                        'warning' => 'Avertissement',
                        'danger' => 'Urgent',
                        'promo' => 'Promotion',
                        'feature' => 'Nouveauté',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Statut actif')
                    ->placeholder('Tous')
                    ->trueLabel('Actives')
                    ->falseLabel('Inactives'),

                TernaryFilter::make('expired')
                    ->label('Expiration')
                    ->placeholder('Toutes')
                    ->trueLabel('Expirées (fin dépassée)')
                    ->falseLabel('En cours')
                    ->queries(
                        true: fn (Builder $query) => $query->where('ends_at', '<', now()),
                        false: fn (Builder $query) => $query->where('ends_at', '>=', now()),
                    ),
            ])
            ->recordActions([
                EditAction::make()
                    ->modalWidth('2xl'),
                Action::make('toggle_active')
                    ->label(fn ($record) => $record->is_active ? 'Désactiver' : 'Activer')
                    ->icon(fn ($record) => $record->is_active ? 'heroicon-o-x-circle' : 'heroicon-o-check-circle')
                    ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                    ->action(function ($record) {
                        $record->update(['is_active' => ! $record->is_active]);
                    })
                    ->requiresConfirmation()
                    ->modalHeading(fn ($record) => $record->is_active ? 'Désactiver l’annonce ?' : 'Activer l’annonce ?')
                    ->modalDescription(fn ($record) => $record->is_active
                        ? 'L’annonce ne sera plus visible pour les acheteurs.'
                        : 'L’annonce sera visible pour les acheteurs à partir de la date de début.')
                    ->modalSubmitActionLabel('Confirmer'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Supprimer la sélection')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Supprimer les annonces sélectionnées')
                        ->modalDescription('Cette action est irréversible.'),
                    BulkActionGroup::make([
                        Action::make('bulk_activate')
                            ->label('Activer la sélection')
                            ->icon('heroicon-o-check-circle')
                            ->color('success')
                            ->action(fn ($records) => $records->each->update(['is_active' => true]))
                            ->requiresConfirmation()
                            ->modalHeading('Activer les annonces sélectionnées ?'),

                        Action::make('bulk_deactivate')
                            ->label('Désactiver la sélection')
                            ->icon('heroicon-o-x-circle')
                            ->color('danger')
                            ->action(fn ($records) => $records->each->update(['is_active' => false]))
                            ->requiresConfirmation()
                            ->modalHeading('Désactiver les annonces sélectionnées ?'),
                    ])->label('Action'),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->poll('60s')
            ->persistFiltersInSession()
            ->persistSearchInSession()
            ->paginated([10, 25, 50, 100, 'all'])
            ->emptyStateHeading('Aucune annonce')
            ->emptyStateDescription('Créez votre première annonce pour informer vos acheteurs.')
            ->emptyStateIcon('heroicon-o-megaphone');
    }
}
