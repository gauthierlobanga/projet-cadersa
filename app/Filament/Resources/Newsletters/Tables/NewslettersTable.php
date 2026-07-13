<?php

namespace App\Filament\Resources\Newsletters\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Enums\IconSize;
use Filament\Support\Enums\Size;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class NewslettersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable()
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                TextColumn::make('confirmed_at')
                    ->label('Confirmé le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->placeholder('Non confirmé')
                    ->icon('heroicon-m-check-badge'),

                TextColumn::make('source')
                    ->label('Source')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'formulaire' => 'primary',
                        'import' => 'warning',
                        'api' => 'info',
                        'checkout' => 'success',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('envois_count')
                    ->label('Envois')
                    ->counts('envois')
                    ->numeric()
                    ->badge()
                    ->color('info')
                    ->alignCenter()
                    ->sortable(),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->icon('heroicon-m-signal')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Inscrit le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->icon('heroicon-m-clock'),

                TextColumn::make('deleted_at')
                    ->label('Supprimé le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(),

                TernaryFilter::make('is_active')
                    ->label('Statut')
                    ->trueLabel('Actifs')
                    ->falseLabel('Inactifs'),

                SelectFilter::make('source')
                    ->label('Source')
                    ->options([
                        'formulaire' => 'Formulaire',
                        'import' => 'Import',
                        'api' => 'API',
                        'checkout' => 'Checkout',
                    ]),
            ])
            ->recordActions([
                ActionGroup::make([
                    EditAction::make()
                        ->iconSize(IconSize::Medium)
                        ->color('gray'),

                    Action::make('toggle_active')
                        ->iconSize(IconSize::Medium)
                        ->label(fn ($record) => $record->is_active ? 'Désactiver' : 'Activer')
                        ->icon(fn ($record) => $record->is_active ? 'heroicon-m-x-circle' : 'heroicon-m-check-circle')
                        ->color(fn ($record) => $record->is_active ? 'danger' : 'success')
                        ->requiresConfirmation()
                        ->action(fn ($record) => $record->is_active ? $record->desactiver() : $record->reactiver()),
                ])->badge()
                    ->size(Size::Medium)
                    ->label(''),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('activate')
                        ->label('Activer')
                        ->icon('heroicon-m-check-circle')
                        ->action(fn ($records) => $records->each->reactiver()),

                    BulkAction::make('deactivate')
                        ->label('Désactiver')
                        ->icon('heroicon-m-x-circle')
                        ->color('danger')
                        ->action(fn ($records) => $records->each->desactiver()),

                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->paginationMode(PaginationMode::Cursor)
            ->defaultSort('created_at', 'desc');
    }
}
