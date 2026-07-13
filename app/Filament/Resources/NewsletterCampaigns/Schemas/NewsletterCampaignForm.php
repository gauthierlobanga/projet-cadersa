<?php

namespace App\Filament\Resources\NewsletterCampaigns\Schemas;

use App\Models\NewsletterCampaign;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class NewsletterCampaignForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Campagne')
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Paramètres')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                TextInput::make('titre')
                                    ->label('Titre de la campagne')
                                    ->required()
                                    ->prefixIcon('heroicon-m-megaphone')
                                    ->columnSpanFull(),

                                TextInput::make('sujet')
                                    ->label("Sujet de l'email")
                                    ->required()
                                    ->prefixIcon('heroicon-m-envelope')
                                    ->columnSpanFull(),

                                Select::make('status')
                                    ->label('Statut')
                                    ->options(NewsletterCampaign::getStatuses())
                                    ->default(NewsletterCampaign::STATUS_BROUILLON)
                                    ->required()
                                    ->native(false)
                                    ->prefixIcon('heroicon-m-flag'),

                                DateTimePicker::make('scheduled_at')
                                    ->label("Date d'envoi programmé")
                                    ->native(false)
                                    ->prefixIcon('heroicon-m-clock'),
                            ])->columns(2),

                        Tab::make('Contenu')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Select::make('cree_par')
                                    ->label('Auteur')
                                    ->relationship('creePar', 'name')
                                    ->preload()
                                    ->searchable(),
                                RichEditor::make('contenu_html')
                                    ->label('Contenu HTML')
                                    ->required()
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold', 'italic', 'underline', 'strike',
                                        'link', 'orderedList', 'bulletList',
                                        'h2', 'h3',
                                        'blockquote', 'codeBlock',
                                        'undo', 'redo',
                                    ]),

                                Textarea::make('contenu_text')
                                    ->label('Contenu texte (fallback)')
                                    ->columnSpanFull()
                                    ->rows(6)
                                    ->helperText('Version texte brut pour les clients email qui ne supportent pas le HTML.'),
                            ]),

                        Tab::make('Audience')
                            ->icon('heroicon-o-user-group')
                            ->schema([
                                Section::make('Segmentation')
                                    ->description('Définissez les critères de ciblage pour cette campagne.')
                                    ->schema([
                                        TextInput::make('segments_cibles')
                                            ->label('Segments cibles (JSON)')
                                            ->columnSpanFull()
                                            ->helperText('Format JSON : {"categories": [...], "date_inscription_min": "..."}'),
                                    ]),
                            ]),

                        Tab::make('Statistiques')
                            ->icon('heroicon-o-chart-bar')
                            ->schema([
                                Section::make('Métriques de performance')
                                    ->columns(4)
                                    ->schema([
                                        Placeholder::make('total_envoyes_display')
                                            ->label('Envoyés')
                                            ->content(fn ($record) => $record?->total_envoyes ?? 0),
                                        Placeholder::make('total_ouverts_display')
                                            ->label('Ouverts')
                                            ->content(fn ($record) => ($record?->total_ouverts ?? 0)),
                                        // ->content(fn ($record) => ($record?->total_ouverts ?? 0).' ('.($record?->taux_ouverture ?? 0).'%)'),
                                        Placeholder::make('total_clics_display')
                                            ->label('Clics')
                                            ->content(fn ($record) => ($record?->total_clics ?? 0)),
                                        // ->content(fn ($record) => ($record?->total_clics ?? 0).' ('.($record?->taux_clic ?? 0).'%)'),
                                        Placeholder::make('total_desabonnements_display')
                                            ->label('Désabonnements')
                                            ->content(fn ($record) => ($record?->total_desabonnements ?? 0).' ('.($record?->taux_desabonnement ?? 0).'%)'),
                                    ]),
                            ])
                            ->visible(fn ($record) => $record !== null),
                    ]),
            ]);
    }
}
