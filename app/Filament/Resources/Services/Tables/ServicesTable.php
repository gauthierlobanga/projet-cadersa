<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Visuel')
                    ->getStateUsing(fn ($record) => $record->getFirstMediaUrl('image', 'thumb'))
                    ->size(40)
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Service')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->getPlainTextContent(80)),

                TextColumn::make('icon')
                    ->label('Icône')
                    ->toggleable()
                    ->formatStateUsing(fn ($state) => "<i class=\"$state\"></i>")
                    ->html(),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('sort_order')
                    ->label('Ordre')
                    ->numeric()
                    ->sortable()
                    ->toggleable()
                    ->alignCenter(),

                TextColumn::make('created_at')
                    ->label('Création')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Mise à jour')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Actif')
                    ->options([
                        1 => 'Oui',
                        0 => 'Non',
                    ]),
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Aucun service')
            ->emptyStateDescription('Créez votre premier service en cliquant sur le bouton "Ajouter un service".')
            ->emptyStateIcon('heroicon-o-wrench-screwdriver')
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }
}
