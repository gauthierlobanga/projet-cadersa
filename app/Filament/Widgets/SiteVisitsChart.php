<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\ChartWidget;

class SiteVisitsChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Fréquentation du site';

    protected ?string $description = 'Visites quotidiennes · 14 derniers jours';

    protected ?string $pollingInterval = '60s';

    protected ?string $emptyStateHeading = 'Aucune visite mesurée';

    protected ?string $emptyStateDescription = 'La fréquentation apparaîtra dès les premières visites.';

    protected ?string $maxHeight = '260px';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        return app(SiteAnalyticsDashboardData::class)->dailyVisits();
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'plugins' => ['legend' => ['display' => false]],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => true, 'grid' => ['display' => false], 'ticks' => ['precision' => 0]],
            ],
        ];
    }

    public function getChartAssistiveContent(): string
    {
        $data = $this->getCachedData();
        $labels = $data['labels'] ?? [];
        $datasets = $data['datasets'] ?? [];
        $visits = is_array($datasets) && is_array($datasets[0] ?? null) ? ($datasets[0]['data'] ?? []) : [];

        if (! is_array($labels) || ! is_array($visits)) {
            return 'Fréquentation quotidienne sur les 14 derniers jours.';
        }

        $total = array_sum(array_map(fn (mixed $value): int => is_numeric($value) ? (int) $value : 0, $visits));
        $dailySummary = [];

        foreach ($labels as $index => $label) {
            if (is_string($label)) {
                $dailySummary[] = $label.': '.(is_numeric($visits[$index] ?? null) ? (int) $visits[$index] : 0);
            }
        }

        return 'Total de '.$total.' visites sur 14 jours. '.implode(', ', $dailySummary);
    }
}
