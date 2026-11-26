<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteTopPagesChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Pages les plus consultées';

    protected ?string $description = 'Consultations sur les 30 derniers jours';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $topPages = DB::table('page_views')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->select('url')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Pages vues',
                    'data' => $topPages->pluck('total')->map(fn (int|string $total): int => (int) $total)->all(),
                    'backgroundColor' => '#059669',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $topPages->pluck('url')->map(fn (?string $url): string => Str::limit($url ?: '/', 28))->all(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
