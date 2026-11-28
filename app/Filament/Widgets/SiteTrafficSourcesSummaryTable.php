<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class SiteTrafficSourcesSummaryTable extends TableWidget
{
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = "full";

    public function table(Table $table): Table
    {
        return $table
            ->heading('Résumé des sources')
            ->description('Origine des visites · 30 derniers jours')
            ->records(fn(): array => collect(app(SiteAnalyticsDashboardData::class)->summaryTables()['sources'])
                ->mapWithKeys(fn(array $row): array => [$row['label'] => $row])
                ->all())
            ->columns([
                TextColumn::make('label')
                    ->label('Canal')
                    ->limit(40),
                TextColumn::make('value')
                    ->label('Visites')
                    ->numeric()
                    ->alignEnd(),
                TextColumn::make('share')
                    ->label('Part')
                    ->suffix('%')
                    ->alignEnd(),
            ])
            ->paginated(false);
    }
}
