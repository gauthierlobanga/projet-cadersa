<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportStatsWidget extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $publishedReports = Report::published();
        $formatCounts = (clone $publishedReports)
            ->selectRaw('file_type, COUNT(*) as total')
            ->groupBy('file_type')
            ->pluck('total', 'file_type');
        $publishedByMonth = array_fill(0, 12, 0);

        (clone $publishedReports)
            ->whereYear('published_at', now()->year)
            ->get(['published_at'])
            ->each(function (Report $report) use (&$publishedByMonth): void {
                $month = (int) $report->published_at?->format('n');

                if ($month > 0) {
                    $publishedByMonth[$month - 1]++;
                }
            });

        $publishedCount = (clone $publishedReports)->count();
        $annualCount = (clone $publishedReports)->where('period_type', Report::PERIOD_ANNUAL)->count();
        $quarterlyCount = (clone $publishedReports)->where('period_type', Report::PERIOD_QUARTERLY)->count();
        $monthlyCount = (clone $publishedReports)->where('period_type', Report::PERIOD_MONTHLY)->count();
        $draftCount = Report::where('status', Report::STATUS_DRAFT)->count();
        $storageBytes = Report::sum('file_size');

        return [
            Stat::make('Rapports publiés', number_format($publishedCount))
                ->description('Tous formats confondus')
                ->descriptionIcon('heroicon-m-document-text')
                ->chart($publishedByMonth)
                ->color('success'),
            Stat::make('Annuels', number_format($annualCount))
                ->description('Rapports annuels publiés')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),
            Stat::make('Trimestriels', number_format($quarterlyCount))
                ->description('Rapports trimestriels publiés')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('info'),
            Stat::make('Mensuels', number_format($monthlyCount))
                ->description('Rapports mensuels publiés')
                ->descriptionIcon('heroicon-m-calendar-date-range')
                ->color('warning'),
            Stat::make('Brouillons', number_format($draftCount))
                ->description('En attente de publication')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('gray'),
            Stat::make('PDF', number_format((int) ($formatCounts[Report::TYPE_PDF] ?? 0)))
                ->description('Documents consultables en ligne')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('success'),
            Stat::make('Word', number_format((int) ($formatCounts[Report::TYPE_WORD] ?? 0)))
                ->description('Documents bureautiques')
                ->descriptionIcon('heroicon-m-document')
                ->color('gray'),
            Stat::make('Excel', number_format((int) ($formatCounts[Report::TYPE_EXCEL] ?? 0)))
                ->description('Tableurs publiés')
                ->descriptionIcon('heroicon-m-table-cells')
                ->color('info'),
            Stat::make('Espace utilisé', $this->formatBytes((int) $storageBytes))
                ->description('Taille de tous les fichiers')
                ->descriptionIcon('heroicon-m-circle-stack')
                ->color('primary'),
        ];
    }

    protected function getColumns(): int
    {
        return 3;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1_000_000_000) {
            return number_format($bytes / 1_000_000_000, 1, ',', ' ').' Go';
        }

        if ($bytes >= 1_000_000) {
            return number_format($bytes / 1_000_000, 1, ',', ' ').' Mo';
        }

        if ($bytes >= 1_000) {
            return number_format($bytes / 1_000, 0, ',', ' ').' Ko';
        }

        return $bytes.' o';
    }
}
