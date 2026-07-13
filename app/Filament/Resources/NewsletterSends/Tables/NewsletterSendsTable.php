<?php

namespace App\Filament\Resources\NewsletterSends\Tables;

use App\Models\NewsletterSend;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NewsletterSendsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['campaign', 'newsletter']))
            ->columns([
                TextColumn::make('campaign.titre')
                    ->label('Campagne')
                    ->icon('heroicon-m-megaphone')
                    ->iconColor('primary')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(25),

                TextColumn::make('email')
                    ->label('Destinataire')
                    ->icon('heroicon-m-envelope')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('newsletter.email')
                    ->label('Abonné')
                    ->icon('heroicon-m-user')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        NewsletterSend::STATUS_ENVOYE => 'primary',
                        NewsletterSend::STATUS_OUVERT => 'warning',
                        NewsletterSend::STATUS_CLIQUE => 'success',
                        NewsletterSend::STATUS_ERREUR => 'danger',
                        NewsletterSend::STATUS_DESABONNE => 'gray',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        NewsletterSend::STATUS_ENVOYE => 'heroicon-m-paper-airplane',
                        NewsletterSend::STATUS_OUVERT => 'heroicon-m-envelope-open',
                        NewsletterSend::STATUS_CLIQUE => 'heroicon-m-cursor-arrow-rays',
                        NewsletterSend::STATUS_ERREUR => 'heroicon-m-exclamation-triangle',
                        NewsletterSend::STATUS_DESABONNE => 'heroicon-m-no-symbol',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->searchable()
                    ->sortable(),

                TextColumn::make('opened_at')
                    ->label('Ouvert le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->icon('heroicon-m-eye'),

                TextColumn::make('clicked_at')
                    ->label('Cliqué le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('—')
                    ->icon('heroicon-m-cursor-arrow-rays'),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->icon('heroicon-m-signal')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Envoyé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->icon('heroicon-m-clock'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        NewsletterSend::STATUS_ENVOYE => 'Envoyé',
                        NewsletterSend::STATUS_OUVERT => 'Ouvert',
                        NewsletterSend::STATUS_CLIQUE => 'Cliqué',
                        NewsletterSend::STATUS_ERREUR => 'Erreur',
                        NewsletterSend::STATUS_DESABONNE => 'Désabonné',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make()
                        ->iconSize(IconSize::Medium)
                        ->color('gray'),
                ])->badge()
                    ->size(Size::Medium)
                    ->label(''),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->paginationMode(PaginationMode::Cursor)
            ->defaultSort('created_at', 'desc');
    }
}
