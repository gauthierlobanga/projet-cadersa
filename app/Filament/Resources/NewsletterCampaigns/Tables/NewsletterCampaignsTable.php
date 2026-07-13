<?php

namespace App\Filament\Resources\NewsletterCampaigns\Tables;

use App\Models\NewsletterCampaign;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class NewsletterCampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('creePar'))
            ->columns([
                TextColumn::make('titre')
                    ->label('Titre')
                    ->icon('heroicon-m-megaphone')
                    ->iconColor('primary')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg')
                    ->description(fn ($record) => $record->sujet)
                    ->limit(35),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        NewsletterCampaign::STATUS_BROUILLON => 'gray',
                        NewsletterCampaign::STATUS_PROGRAMME => 'warning',
                        NewsletterCampaign::STATUS_ENVOYE => 'success',
                        NewsletterCampaign::STATUS_ANNULE => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        NewsletterCampaign::STATUS_BROUILLON => 'heroicon-m-pencil',
                        NewsletterCampaign::STATUS_PROGRAMME => 'heroicon-m-clock',
                        NewsletterCampaign::STATUS_ENVOYE => 'heroicon-m-check-circle',
                        NewsletterCampaign::STATUS_ANNULE => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('creePar.name')
                    ->label('Créé par')
                    ->icon('heroicon-m-user')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('total_envoyes')
                    ->label('Envoyés')
                    ->numeric()
                    ->badge()
                    ->color('primary')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('total_ouverts')
                    ->label('Ouverts')
                    ->numeric()
                    ->badge()
                    ->color('warning')
                    ->alignCenter()
                    ->sortable()
                    ->description(fn ($record) => $record->taux_ouverture.'%'),

                TextColumn::make('total_clics')
                    ->label('Clics')
                    ->numeric()
                    ->badge()
                    ->color('success')
                    ->alignCenter()
                    ->sortable()
                    ->description(fn ($record) => $record->taux_clic.'%'),

                TextColumn::make('total_desabonnements')
                    ->label('Désab.')
                    ->numeric()
                    ->badge()
                    ->color('danger')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('scheduled_at')
                    ->label('Programmé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->icon('heroicon-m-clock')
                    ->toggleable(),

                TextColumn::make('sent_at')
                    ->label('Envoyé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->icon('heroicon-m-paper-airplane'),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                SelectFilter::make('status')
                    ->label('Statut')
                    ->options(NewsletterCampaign::getStatuses()),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->iconSize(IconSize::Medium)
                        ->color('gray'),

                    EditAction::make()
                        ->iconSize(IconSize::Medium)
                        ->color('gray'),

                    Action::make('cancel')
                        ->label('Annuler')
                        ->icon('heroicon-m-x-circle')
                        ->iconSize(IconSize::Medium)
                        ->color('danger')
                        ->requiresConfirmation()
                        ->visible(fn ($record) => in_array($record->status, [
                            NewsletterCampaign::STATUS_BROUILLON,
                            NewsletterCampaign::STATUS_PROGRAMME,
                        ]))
                        ->action(fn ($record) => $record->annuler()),
                ])->badge()
                    ->size(Size::Medium)
                    ->label(''),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->paginationMode(PaginationMode::Cursor)
            ->defaultSort('created_at', 'desc');
    }
}
