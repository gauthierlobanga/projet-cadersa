<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\ChartWidget;

class SiteTrafficSourcesChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Origine des visites';

    protected ?string $description = 'Canaux d’acquisition · 30 derniers jours';

    protected ?string $pollingInterval = '60s';

    protected ?string $maxHeight = '240px';

    protected ?string $emptyStateHeading = 'Aucune source mesurée';

    protected ?string $emptyStateDescription = 'Les canaux apparaîtront avec les prochaines visites.';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return app(SiteAnalyticsDashboardData::class)->trafficSources();
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'cutout' => '70%',
            'plugins' => [
                'legend' => ['position' => 'bottom'],
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
