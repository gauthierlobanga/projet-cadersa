<?php

namespace App\Filament\Resources\Announcements\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AnnouncementForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Informations principales')
                    ->icon('heroicon-o-megaphone')
                    ->description('Configurez le contenu et le type de votre annonce.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                // Type avec boutons bascules pour un rendu plus visuel
                                ToggleButtons::make('type')
                                    ->label('Type d\'annonce')
                                    ->options([
                                        'info' => 'Information',
                                        'success' => 'Succès',
                                        'warning' => 'Avertissement',
                                        'danger' => 'Urgent',
                                        'promo' => 'Promotion',
                                        'feature' => 'Nouveauté',
                                    ])
                                    ->colors([
                                        'info' => 'info',
                                        'success' => 'success',
                                        'warning' => 'warning',
                                        'danger' => 'danger',
                                        'promo' => 'success',
                                        'feature' => 'primary',
                                    ])
                                    ->icons([
                                        'info' => 'heroicon-o-information-circle',
                                        'success' => 'heroicon-o-check-circle',
                                        'warning' => 'heroicon-o-exclamation-triangle',
                                        'danger' => 'heroicon-o-x-circle',
                                        'promo' => 'heroicon-o-gift',
                                        'feature' => 'heroicon-o-sparkles',
                                    ])
                                    ->inline()
                                    ->required()
                                    ->default('info')
                                    ->columnSpanFull(),

                                TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ex: Offre exceptionnelle sur les produits électroniques')
                                    ->helperText('Un titre court et percutant pour capter l’attention.')
                                    ->live(debounce: 500)
                                    ->afterStateUpdated(function ($state, callable $set) {
                                        // Optionnel : auto-générer un slug si vous en avez besoin
                                        // $set('slug', Str::slug($state));
                                    })->columnSpanFull(),

                                Textarea::make('message')
                                    ->label('Message')
                                    ->required()
                                    ->rows(4)
                                    ->maxLength(1000)
                                    ->placeholder('Décrivez votre annonce en détail...')
                                    ->helperText('Utilisez un langage clair et concis.')
                                    ->columnSpanFull(),

                                Toggle::make('is_active')
                                    ->label('Activer l’annonce')
                                    ->helperText('Si activée, l’annonce sera visible pour les acheteurs.')
                                    ->default(true)
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),

                    ]),

                Section::make('Planification')
                    ->icon('heroicon-o-clock')
                    ->description('Définissez la période de diffusion de l’annonce.')
                    ->schema([
                        Fieldset::make('Période de validité')
                            ->schema([
                                Grid::make(1)
                                    ->schema([
                                        DateTimePicker::make('starts_at')
                                            ->label('Date de début')
                                            ->helperText('Laissez vide pour une diffusion immédiate.')
                                            ->displayFormat('d/m/Y H:i')
                                            ->native(false)
                                            ->seconds(false)
                                            ->timezone('Europe/Paris'),

                                        DateTimePicker::make('ends_at')
                                            ->label('Date de fin')
                                            ->helperText('Laissez vide pour une diffusion sans limite dans le temps.')
                                            ->displayFormat('d/m/Y H:i')
                                            ->native(false)
                                            ->seconds(false)
                                            ->timezone('Europe/Paris')
                                            ->after('starts_at')
                                            ->validationMessages([
                                                'after' => 'La date de fin doit être postérieure à la date de début.',
                                            ]),
                                        TextInput::make('action_text')
                                            ->label('Texte du bouton (optionnel)')
                                            ->maxLength(60)
                                            ->placeholder('Ex: En savoir plus')
                                            ->helperText('Texte qui apparaîtra sur le bouton d’appel à l’action.'),

                                        TextInput::make('action_url')
                                            ->label('Lien du bouton (optionnel)')
                                            ->url()
                                            ->placeholder('https://example.com')
                                            ->helperText('Lien vers une page, un produit ou une offre.')
                                            ->suffixIcon('heroicon-o-link'),
                                    ])->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
