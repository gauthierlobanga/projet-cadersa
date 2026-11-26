<?php

namespace App\Filament\Widgets;

use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SiteVisitsChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Fréquentation du site';

    protected ?string $description = 'Visites quotidiennes sur les 14 derniers jours';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $startDate = CarbonImmutable::today()->subDays(13);
        $dailyTotals = DB::table('visits')
            ->whereBetween('visited_at', [$startDate->startOfDay(), now()])
            ->selectRaw('DATE(visited_at) as visit_date, COUNT(*) as total')
            ->groupBy('visit_date')
            ->pluck('total', 'visit_date');

        $labels = [];
        $values = [];

        foreach (range(0, 13) as $offset) {
            $date = $startDate->addDays($offset);
            $labels[] = $date->locale('fr')->translatedFormat('d M');
            $values[] = (int) ($dailyTotals[$date->toDateString()] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Visites',
                    'data' => $values,
                    'borderColor' => '#047857',
                    'backgroundColor' => 'rgba(16, 185, 129, 0.16)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
