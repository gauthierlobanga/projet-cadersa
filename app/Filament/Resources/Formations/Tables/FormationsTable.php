<?php

namespace App\Filament\Resources\Formations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class FormationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('cover')
                    ->label('Image')
                    ->collection('cover')
                    ->conversion('thumb')
                    ->circular()
                    ->imageSize(40)
                    ->toggleable(),

                TextColumn::make('title')
                    ->label('Formation')
                    ->searchable()
                    ->sortable()
                    ->description(fn ($record) => $record->getPlainTextExcerpt(30)),

                TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->badge()
                    ->color(fn ($record) => $record->category?->color ?? 'gray')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('user.name')
                    ->label('Auteur')
                    ->formatStateUsing(function ($record) {
                        $user = $record->user;
                        if (! $user) {
                            return '—';
                        }
                        $avatarUrl = $user->avatar_url ?? Storage::url('images/cadersa-logo.png');
                        $name = e($user->name);
                        $email = e($user->email);

                        return "
            <div style='display: flex; align-items: center; gap: 0.75rem;'>
                <img src='{$avatarUrl}' alt='{$name}' style='width: 2rem; height: 2rem; border-radius: 9999px; object-fit: cover;' />
                <div>
                    <span style='font-weight: 600;'>{$name}</span><br>
                    <span style='font-size: 0.75rem; color: #6b7280;'>{$email}</span>
                </div>
            </div>
        ";
                    })
                    ->html()
                    ->sortable(query: function ($query, $direction) {
                        $query->join('users', 'formations.user_id', '=', 'users.id')
                            ->orderBy('users.name', $direction);
                    })
                    ->toggleable()
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'planned' => 'Planifié',
                        'ongoing' => 'En cours',
                        'completed' => 'Terminé',
                    })
                    ->color(fn ($state) => match ($state) {
                        'planned' => 'gray',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                    })
                    ->sortable(),

                TextColumn::make('location')
                    ->label('Lieu')
                    ->searchable()
                    ->icon('heroicon-m-map-pin')
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label('Début')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->label('Fin')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),

                IconColumn::make('is_active')
                    ->label('Actif')
                    ->boolean()
                    ->sortable()
                    ->toggleable(),

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
                SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'planned' => 'Planifié',
                        'ongoing' => 'En cours',
                        'completed' => 'Terminé',
                    ]),
                SelectFilter::make('is_active')
                    ->label('Actif')
                    ->options([
                        1 => 'Oui',
                        0 => 'Non',
                    ]),
                SelectFilter::make('formation_category_id')
                    ->label('Catégorie')
                    ->relationship('category', 'name'),
                TrashedFilter::make(),
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
            ->defaultSort('start_date', 'desc')
            ->striped();
    }
}
