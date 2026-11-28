<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\ChartWidget;

class SiteConversionFunnelChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Parcours de conversion';

    protected ?string $description = 'Étapes commencées et terminées · 30 derniers jours';

    protected ?string $pollingInterval = '60s';

    protected ?string $emptyStateHeading = 'Aucun parcours enregistré';

    protected ?string $emptyStateDescription = 'Les étapes apparaîtront après les premières demandes, inscriptions et abonnements.';

    protected ?string $maxHeight = '250px';

    protected int|string|array $columnSpan = 2;

    protected function getData(): array
    {
        return app(SiteAnalyticsDashboardData::class)->conversionFunnel();
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => ['position' => 'bottom'],
            ],
            'scales' => [
                'x' => ['beginAtZero' => true, 'grid' => ['display' => false], 'ticks' => ['precision' => 0]],
                'y' => ['grid' => ['display' => false]],
            ],
        ];
    }

    public function getChartAssistiveContent(): string
    {
        $data = $this->getCachedData();
        $labels = $data['labels'] ?? [];
        $datasets = $data['datasets'] ?? [];
        $startedDataset = is_array($datasets) && is_array($datasets[0] ?? null) ? ($datasets[0]['data'] ?? []) : [];
        $completedDataset = is_array($datasets) && is_array($datasets[1] ?? null) ? ($datasets[1]['data'] ?? []) : [];

        if (! is_array($labels) || ! is_array($startedDataset) || ! is_array($completedDataset)) {
            return 'Étapes commencées et terminées au cours des 30 derniers jours.';
        }

        $summary = [];

        foreach ($labels as $index => $label) {
            if (is_string($label)) {
                $started = is_numeric($startedDataset[$index] ?? null) ? (int) $startedDataset[$index] : 0;
                $completed = is_numeric($completedDataset[$index] ?? null) ? (int) $completedDataset[$index] : 0;
                $summary[] = $label.': '.$started.' commencées, '.$completed.' terminées.';
            }
        }

        return implode(' ', $summary);
    }
}
