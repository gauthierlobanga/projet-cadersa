<?php

namespace App\Filament\Resources\Formations\Schemas;

use App\Models\FormationCategory;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class FormationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informations générales')
                    ->description('Titre, slug et catégorie de la formation.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label('Titre')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Généré automatiquement si laissé vide.'),
                            ]),

                        Select::make('formation_category_id')
                            ->label('Catégorie')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('Nom de la catégorie')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('slug')
                                    ->label('Slug')
                                    ->maxLength(255),
                                ColorPicker::make('color')
                                    ->label('Couleur')
                                    ->default('#6b7280'),
                                TextInput::make('icon')
                                    ->label('Icône (optionnel)')
                                    ->maxLength(255),
                            ])
                            ->placeholder('Choisissez ou créez une catégorie'),
                    ]),

                Section::make('Description')
                    ->description('Résumé et contenu détaillé.')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        TextInput::make('subtitle')
                            ->label('Sous‑titre')
                            ->maxLength(255),

                        RichEditor::make('excerpt')
                            ->label('Résumé')
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->json()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike', 'link',
                                'h2', 'h3',
                                'blockquote', 'bulletList', 'orderedList',
                                'undo', 'redo',
                            ]),

                        RichEditor::make('content')
                            ->label('Contenu complet')
                            ->columnSpanFull()
                            ->json()
                            ->fileAttachmentsDisk('media')
                            ->fileAttachmentsDirectory('formations/content')
                            ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg'])
                            ->resizableImages()
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike', 'link', 'attachFiles',
                                'h1', 'h2', 'h3',
                                'blockquote', 'codeBlock', 'bulletList', 'orderedList',
                                'table',
                                'undo', 'redo',
                            ]),
                    ]),

                Section::make('Médias')
                    ->description('Image de couverture et galerie.')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('formations/covers')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->helperText('Format 16:9 recommandé, max 5 Mo.')
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label('Galerie d\'images')
                            ->collection('gallery')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->responsiveImages()
                            ->conversion('thumb')
                            ->disk('public')
                            ->directory('formations/gallery')
                            ->visibility('public')
                            ->maxFiles(10)
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->reorderable()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->customProperties([
                                'title' => '',
                                'description' => '',
                                'alt' => '',
                            ])
                            ->helperText('Images supplémentaires (max 10 fichiers, 5 Mo chacun). Cliquez sur une image pour ajouter un titre, une description et un texte alternatif.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Vidéos')
                    ->description('Ajoutez une vidéo pour chaque chapitre ou leçon. Une fois la vidéo téléversée, cliquez sur le bouton d\'édition (icône crayon) du média pour renseigner la propriété personnalisée "target_id" (ex: chapter-0, chapter-2-lesson-1).')
                    ->icon('heroicon-o-video-camera')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('videos')
                            ->collection('videos')
                            ->multiple()
                            ->disk('public')
                            ->directory('formations/videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/*'])  // ✅ accepte tout type MIME vidéo
                            ->maxSize(102400)
                            ->helperText('Formats acceptés : tous types vidéo (MP4, WebM, OGG, MOV, AVI, MKV, etc.)')
                            ->customProperties(fn () => ['target_id' => ''])
                            ->panelLayout('list')
                            ->reorderable()
                            ->appendFiles(),
                    ]),

                Section::make('Détails de la formation')
                    ->description('Dates, localisation et statut.')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('location')
                                    ->label('Localisation')
                                    ->maxLength(255),

                                TextInput::make('duration')
                                    ->label('Durée')
                                    ->maxLength(255)
                                    ->placeholder('ex: 3h30, 2 jours, etc.'),

                                ToggleButtons::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'planned' => 'Planifié',
                                        'ongoing' => 'En cours',
                                        'completed' => 'Terminé',
                                    ])
                                    ->colors([
                                        'planned' => 'gray',
                                        'ongoing' => 'warning',
                                        'completed' => 'success',
                                    ])
                                    ->icons([
                                        'planned' => 'heroicon-o-calendar',
                                        'ongoing' => 'heroicon-o-clock',
                                        'completed' => 'heroicon-o-check-circle',
                                    ])
                                    ->inline()
                                    ->required()
                                    ->default('planned'),

                                DatePicker::make('start_date')
                                    ->label('Date de début')
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),

                                DatePicker::make('end_date')
                                    ->label('Date de fin')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->after('start_date')
                                    ->helperText('Optionnelle.'),
                            ]),
                    ]),

                Section::make('Tags')
                    ->description('Mots-clés associés à la formation.')
                    ->icon('heroicon-o-tag')
                    ->schema([
                        SpatieTagsInput::make('tags')
                            ->label('Tags')
                            ->suggestions(function () {
                                // Récupère les noms des catégories de formation comme suggestions de base
                                $categoryNames = FormationCategory::pluck('name')->toArray();
                                // Ajoute des tags complémentaires
                                $extraTags = ['Débutant', 'Intermédiaire', 'Avancé', 'Certifiant', 'Présentiel', 'Distanciel'];

                                return array_merge($categoryNames, $extraTags);
                            })
                            ->columnSpanFull(),
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
                                    ->label('Ordre d\'affichage')
                                    ->numeric()
                                    ->default(0)
                                    ->minValue(0)
                                    ->helperText('Plus petit = premier.'),

                                // --- Nouveau champ utilisateur ---
                                Select::make('user_id')
                                    ->label('Auteur')
                                    ->relationship('user', 'name') // suppose que la relation s'appelle 'user' dans le modèle
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Choisissez un auteur')
                                    ->helperText('Personne qui dispense la formation.'),
                            ]),
                    ]),
            ]);
    }
}
