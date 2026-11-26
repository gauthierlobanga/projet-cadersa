<?php

namespace App\Filament\Resources\Reports\Schemas;

use App\Models\Report;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Détails du rapport')
                    ->description('Décrivez la période couverte et le document à publier.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Titre du rapport')
                            ->required()
                            ->maxLength(180)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Résumé')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),

                        Select::make('project_id')
                            ->label('Projet associé')
                            ->relationship('project', 'title')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Facultatif : associez ce rapport à un projet.'),

                        Select::make('period_type')
                            ->label('Périodicité')
                            ->options([
                                Report::PERIOD_ANNUAL => 'Annuel',
                                Report::PERIOD_QUARTERLY => 'Trimestriel',
                                Report::PERIOD_MONTHLY => 'Mensuel',
                            ])
                            ->native(false)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Set $set): mixed => $set('period_number', null)),

                        TextInput::make('report_year')
                            ->label('Année du rapport')
                            ->numeric()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->default(now()->year)
                            ->required(),

                        TextInput::make('period_number')
                            ->label(fn (Get $get): string => $get('period_type') === Report::PERIOD_QUARTERLY ? 'Trimestre' : 'Mois')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(fn (Get $get): int => $get('period_type') === Report::PERIOD_QUARTERLY ? 4 : 12)
                            ->required(fn (Get $get): bool => in_array($get('period_type'), [Report::PERIOD_QUARTERLY, Report::PERIOD_MONTHLY], true))
                            ->visible(fn (Get $get): bool => in_array($get('period_type'), [Report::PERIOD_QUARTERLY, Report::PERIOD_MONTHLY], true)),

                        Select::make('status')
                            ->label('Publication')
                            ->options([
                                Report::STATUS_DRAFT => 'Brouillon',
                                Report::STATUS_PUBLISHED => 'Publié',
                            ])
                            ->native(false)
                            ->default(Report::STATUS_DRAFT)
                            ->required()
                            ->live(),

                        DateTimePicker::make('published_at')
                            ->label('Date de publication')
                            ->native(false)
                            ->seconds(false)
                            ->visible(fn (Get $get): bool => $get('status') === Report::STATUS_PUBLISHED)
                            ->helperText('Si la date reste vide, la date de publication sera définie automatiquement.'),

                        FileUpload::make('file_path')
                            ->label('Fichier du rapport')
                            ->disk(Report::FILE_DISK)
                            ->directory('reports')
                            ->visibility('private')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-excel',
                                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            ])
                            ->maxSize(51200)
                            ->storeFileNamesIn('original_filename')
                            ->required(fn (?Report $record): bool => $record === null)
                            ->helperText('PDF, Word ou Excel · 50 Mo maximum.')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
