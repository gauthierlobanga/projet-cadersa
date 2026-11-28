<?php

namespace App\Filament\Resources\Reports\Tables;

use App\Models\Report;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Rapport')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Report $record): ?string => $record->original_filename),
                TextColumn::make('period_type')
                    ->label('Période')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Report::PERIOD_ANNUAL => 'Annuel',
                        Report::PERIOD_QUARTERLY => 'Trimestriel',
                        Report::PERIOD_MONTHLY => 'Mensuel',
                        default => $state,
                    })
                    ->description(fn (Report $record): string => $record->period_label),
                TextColumn::make('project.title')
                    ->label('Projet')
                    ->placeholder('Organisation')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('file_type')
                    ->label('Format')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        Report::TYPE_PDF => 'success',
                        Report::TYPE_WORD => 'gray',
                        Report::TYPE_EXCEL => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (Report $record): string => $record->format_label),
                TextColumn::make('file_size')
                    ->label('Taille')
                    ->formatStateUsing(fn (Report $record): string => $record->formatted_file_size)
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => $state === Report::STATUS_PUBLISHED ? 'success' : 'warning')
                    ->formatStateUsing(fn (string $state): string => $state === Report::STATUS_PUBLISHED ? 'Publié' : 'Brouillon'),
                TextColumn::make('published_at')
                    ->label('Publié le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Publication')
                    ->options([
                        Report::STATUS_DRAFT => 'Brouillons',
                        Report::STATUS_PUBLISHED => 'Publiés',
                    ]),
                SelectFilter::make('period_type')
                    ->label('Périodicité')
                    ->options([
                        Report::PERIOD_ANNUAL => 'Annuel',
                        Report::PERIOD_QUARTERLY => 'Trimestriel',
                        Report::PERIOD_MONTHLY => 'Mensuel',
                    ]),
                SelectFilter::make('file_type')
                    ->label('Format')
                    ->options([
                        Report::TYPE_PDF => 'PDF',
                        Report::TYPE_WORD => 'Word',
                        Report::TYPE_EXCEL => 'Excel',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('removeFile')
                    ->label('Supprimer le fichier')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Supprimer le fichier du rapport ?')
                    ->modalDescription('Le rapport sera conservé, mais son fichier sera supprimé définitivement.')
                    ->modalSubmitActionLabel('Supprimer le fichier')
                    ->visible(fn (Report $record): bool => filled($record->file_path))
                    ->action(function (Report $record): void {
                        $record->file_path = null;
                        $record->save();
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
