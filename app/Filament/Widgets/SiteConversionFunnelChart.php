<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SiteConversionFunnelChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Parcours de conversion';

    protected ?string $description = 'Étapes commencées et terminées sur 30 jours';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        $steps = DB::table('conversion_events')
            ->where('created_at', '>=', now()->subDays(30))
            ->select('step')
            ->selectRaw('COUNT(*) as started')
            ->selectRaw('SUM(CASE WHEN completed = 1 THEN 1 ELSE 0 END) as completed')
            ->groupBy('step')
            ->orderBy('step')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Étapes commencées',
                    'data' => $steps->pluck('started')->map(fn (int|string $total): int => (int) $total)->all(),
                    'backgroundColor' => '#64748b',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Étapes terminées',
                    'data' => $steps->pluck('completed')->map(fn (int|string|null $total): int => (int) $total)->all(),
                    'backgroundColor' => '#059669',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $steps->pluck('step')->map(fn (?string $step): string => $step ?: 'Étape sans nom')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
