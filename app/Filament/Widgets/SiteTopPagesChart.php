<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\ChartWidget;

class SiteTopPagesChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Pages les plus consultées';

    protected ?string $description = 'Top pages · 30 derniers jours';

    protected ?string $pollingInterval = '60s';

    protected ?string $emptyStateHeading = 'Aucune page consultée';

    protected ?string $emptyStateDescription = 'Les pages apparaîtront dès les premières visites.';

    protected ?string $maxHeight = '260px';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return app(SiteAnalyticsDashboardData::class)->topPages();
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
            'plugins' => ['legend' => ['display' => false]],
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
        $views = is_array($datasets) && is_array($datasets[0] ?? null) ? ($datasets[0]['data'] ?? []) : [];

        if (! is_array($labels) || ! is_array($views)) {
            return 'Classement des pages consultées au cours des 30 derniers jours.';
        }

        $summary = [];

        foreach ($labels as $index => $label) {
            if (is_string($label)) {
                $summary[] = $label.': '.(is_numeric($views[$index] ?? null) ? (int) $views[$index] : 0).' consultations.';
            }
        }

        return implode(' ', $summary);
    }
}
