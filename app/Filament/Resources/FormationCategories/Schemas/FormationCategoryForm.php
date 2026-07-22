<?php

namespace App\Filament\Resources\FormationCategories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FormationCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Généré automatiquement si laissé vide.'),

                        ColorPicker::make('color')
                            ->label('Couleur')
                            ->default('#6b7280'),

                        TextInput::make('sort_order')
                            ->label('Ordre d’affichage')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                    ])->columnSpanFull(),
            ]);
    }
}
