<?php

namespace App\Filament\Resources\NewsletterSends\Schemas;

use Filament\Forms\Components\Placeholder;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsletterSendForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Envoi')
                    ->icon('heroicon-o-paper-airplane')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('campaign.titre')
                            ->label('Campagne')
                            ->content(fn ($record) => $record?->campaign?->titre ?? '-'),
                        Placeholder::make('email')
                            ->label('Email')
                            ->content(fn ($record) => $record?->email ?? '-'),
                        Placeholder::make('status')
                            ->label('Statut')
                            ->content(fn ($record) => $record?->status_label ?? '-'),
                    ]),

                Section::make('Tracking')
                    ->icon('heroicon-o-chart-bar')
                    ->columns(2)
                    ->schema([
                        Placeholder::make('opened_at')
                            ->label('Ouvert le')
                            ->content(fn ($record) => $record?->opened_at?->format('d/m/Y H:i:s') ?? '—'),
                        Placeholder::make('clicked_at')
                            ->label('Cliqué le')
                            ->content(fn ($record) => $record?->clicked_at?->format('d/m/Y H:i:s') ?? '—'),
                        Placeholder::make('ip_address')
                            ->label('Adresse IP')
                            ->content(fn ($record) => $record?->ip_address ?? '-'),
                        Placeholder::make('user_agent')
                            ->label('User Agent')
                            ->content(fn ($record) => $record?->user_agent ?? '-'),
                    ]),
            ]);
    }
}
