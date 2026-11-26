<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SiteDeviceBreakdownChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Appareils des visiteurs';

    protected ?string $description = 'Répartition des visites sur 30 jours';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $devices = DB::table('visits')
            ->where('visited_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF(device, ''), 'Non renseigné') as device_label, COUNT(*) as total")
            ->groupBy('device_label')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [
                [
                    'data' => $devices->pluck('total')->map(fn (int|string $total): int => (int) $total)->all(),
                    'backgroundColor' => ['#047857', '#475569', '#2dd4bf', '#94a3b8', '#f59e0b'],
                    'borderWidth' => 0,
                ],
            ],
            'labels' => $devices->pluck('device_label')->all(),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
