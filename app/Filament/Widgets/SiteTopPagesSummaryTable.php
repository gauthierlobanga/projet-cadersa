<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class SiteTopPagesSummaryTable extends TableWidget
{
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Résumé des pages')
            ->description('Pages les plus consultées · 30 derniers jours')
            ->records(fn (): array => collect(app(SiteAnalyticsDashboardData::class)->summaryTables()['pages'])
                ->mapWithKeys(fn (array $row): array => [$row['label'] => $row])
                ->all())
            ->columns([
                TextColumn::make('label')
                    ->label('Page')
                    ->limit(40),
                TextColumn::make('value')
                    ->label('Vues')
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
