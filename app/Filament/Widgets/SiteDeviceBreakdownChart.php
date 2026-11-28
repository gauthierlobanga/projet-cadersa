<?php

namespace App\Filament\Widgets;

use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\ChartWidget;

class SiteDeviceBreakdownChart extends ChartWidget
{
    protected static bool $isLazy = false;

    protected ?string $heading = 'Appareils des visiteurs';

    protected ?string $description = 'Répartition des appareils · 30 derniers jours';

    protected ?string $pollingInterval = '60s';

    protected ?string $emptyStateHeading = 'Aucune visite mesurée';

    protected ?string $emptyStateDescription = 'La répartition apparaîtra dès les premières visites.';

    protected ?string $maxHeight = '240px';

    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        return app(SiteAnalyticsDashboardData::class)->deviceBreakdown();
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function getChartAssistiveContent(): string
    {
        $data = $this->getCachedData();
        $labels = $data['labels'] ?? [];
        $datasets = $data['datasets'] ?? [];
        $visits = is_array($datasets) && is_array($datasets[0] ?? null) ? ($datasets[0]['data'] ?? []) : [];

        if (! is_array($labels) || ! is_array($visits)) {
            return 'Répartition des visites selon les appareils au cours des 30 derniers jours.';
        }

        $summary = [];

        foreach ($labels as $index => $label) {
            if (is_string($label)) {
                $summary[] = $label.': '.(is_numeric($visits[$index] ?? null) ? (int) $visits[$index] : 0).' visites.';
            }
        }

        return implode(' ', $summary);
    }
}
