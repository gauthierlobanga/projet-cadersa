<?php

namespace App\Filament\Resources\FormationCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FormationCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nom')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->slug),

                ColorColumn::make('color')
                    ->label('Couleur')
                    ->copyable()
                    ->tooltip(fn ($record) => $record->color),

                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('formations_count')
                    ->label('Formations')
                    ->counts('formations')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->striped();
    }
}
