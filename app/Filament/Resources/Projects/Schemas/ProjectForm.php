<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Informations générales')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),

                                TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                            ]),

                        RichEditor::make('excerpt')
                            ->label('Résumé')
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->json()
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'link'],
                                [ToolbarButtonGroup::make('Heading', ['h2', 'h3'])->textualButtons()->icon('fi-o-heading')],
                                ['blockquote', 'bulletList', 'orderedList'],
                                ['undo', 'redo'],
                            ]),

                        RichEditor::make('content')
                            ->label('Description complète')
                            ->required()
                            ->columnSpanFull()
                            ->json()
                            ->fileAttachmentsDisk('media')
                            ->fileAttachmentsDirectory('projects/content')
                            ->fileAttachmentsAcceptedFileTypes(['image/png', 'image/jpeg'])
                            ->resizableImages()
                            ->toolbarButtons([
                                ['bold', 'italic', 'underline', 'strike', 'link', 'attachFiles'],
                                [ToolbarButtonGroup::make('Heading', ['h1', 'h2', 'h3'])->textualButtons()->icon('fi-o-heading')],
                                [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
                                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                                ['table'],
                                ['undo', 'redo'],
                            ])
                            ->floatingToolbars([
                                'paragraph' => ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript'],
                                'heading' => ['h1', 'h2', 'h3'],
                                'table' => ['tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn', 'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow', 'tableMergeCells', 'tableSplitCell', 'tableToggleHeaderRow', 'tableToggleHeaderCell', 'tableDelete'],
                            ])
                            ->textColors([
                                'brand' => TextColor::make('Brand', '#0ea5e9'),
                                'warning' => TextColor::make('Warning', '#f59e0b', darkColor: '#fbbf24'),
                                ...TextColor::getDefaults(),
                            ]),
                    ]),

                Section::make('Média')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('cover')
                            ->collection('cover')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('projects/covers')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->columnSpanFull()
                            ->helperText('Format 16:9 recommandé, max 5 Mo.'),

                        SpatieMediaLibraryFileUpload::make('gallery')
                            ->label('Galerie d\'images')
                            ->collection('gallery')
                            ->multiple()
                            ->image()
                            ->imageEditor()
                            ->responsiveImages()
                            ->conversion('thumb')
                            ->disk('public')
                            ->directory('projects/gallery')
                            ->visibility('public')
                            ->maxFiles(10)
                            ->maxSize(5120)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->reorderable()
                            ->appendFiles()
                            ->panelLayout('grid')
                            ->columnSpanFull()
                            ->helperText('Images supplémentaires (max 10 fichiers, 5MB chacun). Glissez pour réorganiser.'),
                    ]),

                // ========== NOUVELLE SECTION : DOCUMENTS PDF ==========
                Section::make('Documents PDF')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('documents')
                            ->label('Documents PDF (rapports, études, etc.)')
                            ->collection('documents')
                            ->multiple()
                            ->disk('public')
                            ->directory('projects/documents')
                            ->visibility('public')
                            ->maxFiles(10)
                            ->maxSize(20480) // 20 MB
                            ->acceptedFileTypes(['application/pdf'])
                            ->downloadable()
                            ->previewable(true)
                            ->openable()
                            ->reorderable()
                            ->appendFiles()
                            ->columnSpanFull()
                            ->helperText('Téléchargez les documents PDF liés au projet (rapports d\'activité, études, etc.). Poids max : 20 Mo par fichier.'),
                    ]),

                Section::make('Détails du projet')
                    ->icon('heroicon-o-map-pin')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('location')
                                    ->label('Localisation')
                                    ->maxLength(255),

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
                                    ->default('ongoing'),

                                DatePicker::make('start_date')
                                    ->label('Date de début')
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),

                                DatePicker::make('end_date')
                                    ->label('Date de fin')
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->after('start_date'),
                            ]),
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
