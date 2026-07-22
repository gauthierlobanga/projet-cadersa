<?php

namespace App\Filament\Resources\Testimonials\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identité du témoin')
                    ->icon('heroicon-o-user-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nom complet'),

                                TextInput::make('role')
                                    ->maxLength(255)
                                    ->label('Rôle / Fonction'),

                                TextInput::make('company')
                                    ->maxLength(255)
                                    ->label('Entreprise / Organisation'),

                                TextInput::make('profile_url')
                                    ->url()
                                    ->maxLength(255)
                                    ->label('Lien vers le profil (LinkedIn, etc.)'),

                                TextInput::make('platform')
                                    ->maxLength(255)
                                    ->label('Plateforme (ex: Malt, Upwork)'),

                                Select::make('rating')
                                    ->options([
                                        1 => '1 étoile',
                                        2 => '2 étoiles',
                                        3 => '3 étoiles',
                                        4 => '4 étoiles',
                                        5 => '5 étoiles',
                                    ])
                                    ->default(5)
                                    ->label('Évaluation (sur 5)'),
                            ]),
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
                            ->directory('testimonials/photos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Format carré recommandé. Max 2 Mo.'),

                        SpatieMediaLibraryFileUpload::make('company_logo')
                            ->collection('company_logo')
                            ->image()
                            ->disk('public')
                            ->directory('testimonials/logos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'])
                            ->helperText('Logo de l\'entreprise. Max 2 Mo.'),
                    ]),

                Section::make('Témoignage')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->label('Contenu du témoignage')
                            ->columnSpanFull()
                            ->toolbarButtons(['bold', 'italic', 'underline', 'link']),
                    ]),

                Section::make('Paramètres')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Actif')
                            ->default(true)
                            ->onColor('success')
                            ->offColor('danger'),
                    ]),
            ]);
    }
}
