<?php

namespace App\Filament\Resources\TeamMembers\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identité')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nom complet'),

                                TextInput::make('role')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Rôle'),
                            ]),
                        TextInput::make('email')
                            ->label('Adresse email')
                            ->email()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                    ]),

                Section::make('Biographie')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        RichEditor::make('bio')
                            ->label('Biographie')
                            ->columnSpanFull()
                            ->toolbarButtons(['bold', 'italic', 'underline', 'link']),
                    ]),

                Section::make('Photo')
                    ->icon('heroicon-o-camera')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('photo')
                            ->collection('photo')
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->disk('public')
                            ->directory('team/photos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Format carré recommandé. Max 2 Mo.'),
                    ]),

                Section::make('Réseaux sociaux')
                    ->icon('heroicon-o-share')
                    ->schema([
                        KeyValue::make('social_links')
                            ->label('Liens sociaux')
                            ->keyLabel('Plateforme')
                            ->valueLabel('URL')
                            ->addActionLabel('Ajouter un lien')
                            ->reorderable()
                            ->helperText('Exemples : linkedin (https://linkedin.com/in/...), twitter, facebook'),
                    ]),

                Section::make('Paramètres')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Actif')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger'),

                                TextInput::make('sort_order')
                                    ->label('Ordre d’affichage')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0),
                            ]),
                    ]),
            ]);
    }
}
