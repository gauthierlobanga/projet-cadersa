<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\ChartWidget;

class SiteTrafficSourcesBarChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Visites par canal';

    protected ?string $description = 'Comparaison des sources · 30 derniers jours';

    protected ?string $pollingInterval = '60s';

    protected ?string $maxHeight = '280px';

    protected ?string $emptyStateHeading = 'Aucune source mesurée';

    protected ?string $emptyStateDescription = 'Le graphique apparaîtra après les prochaines visites.';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return app(SiteAnalyticsDashboardData::class)->trafficSources();
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
        $visits = $data['datasets'][0]['data'] ?? [];
        $summary = [];

        if (! is_array($labels) || ! is_array($visits)) {
            return '';
        }

        foreach ($labels as $index => $label) {
            if (! is_string($label)) {
                continue;
            }

            $summary[] = $label.': '.(int) ($visits[$index] ?? 0).' visites.';
        }

        return implode(' ', $summary);
    }
}
