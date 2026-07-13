<?php

namespace App\Filament\Resources\Newsletters\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsletterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informations personnelles')
                    ->icon('heroicon-o-user')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Adresse email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->prefixIcon('heroicon-m-envelope'),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('prenom')
                                    ->label('Prénom')
                                    ->prefixIcon('heroicon-m-user'),
                                TextInput::make('nom')
                                    ->label('Nom')
                                    ->prefixIcon('heroicon-m-user'),
                            ]),
                    ]),

                Section::make('Abonnement')
                    ->icon('heroicon-o-bell')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Actif')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->onColor('success')
                            ->offColor('danger')
                            ->default(true),

                        Select::make('source')
                            ->label('Source')
                            ->options([
                                'formulaire' => 'Formulaire',
                                'import' => 'Import',
                                'api' => 'API',
                                'checkout' => 'Checkout',
                            ])
                            ->default('formulaire')
                            ->required()
                            ->native(false)
                            ->prefixIcon('heroicon-m-arrow-right-circle'),

                        DateTimePicker::make('confirmed_at')
                            ->label('Date de confirmation')
                            ->native(false)
                            ->prefixIcon('heroicon-m-check-badge'),
                    ]),

                Section::make('Informations techniques')
                    ->icon('heroicon-o-cog-6-tooth')
                    ->collapsed()
                    ->columns(2)
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('Adresse IP')
                            ->disabled()
                            ->prefixIcon('heroicon-m-signal'),
                        TextInput::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
