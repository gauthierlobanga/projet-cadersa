<?php

namespace App\Filament\Widgets;

use App\Models\Report;
use App\Services\SiteAnalyticsDashboardData;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class SiteAnalyticsOverview extends StatsOverviewWidget
{
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected ?string $pollingInterval = '60s';

    protected function getStats(): array
    {
        $thirtyDaysAgo = now()->subDays(30);
        $visits = DB::table('visits')->where('visited_at', '>=', $thirtyDaysAgo);
        $pageViewsCount = DB::table('page_views')->where('viewed_at', '>=', $thirtyDaysAgo)->count();
        $completedConversions = DB::table('conversion_events')
            ->where('completed', true)
            ->where('completed_at', '>=', $thirtyDaysAgo)
            ->count();
        $activeContentCount = DB::table('posts')->where('status', 'published')->whereNull('deleted_at')->count()
            + DB::table('projects')->where('is_active', true)->whereNull('deleted_at')->count()
            + DB::table('formations')->where('is_active', true)->whereNull('deleted_at')->count();

        return [
            Stat::make('Visites', number_format((clone $visits)->count()))
                ->description('30 derniers jours')
                ->descriptionIcon('heroicon-m-eye')
                ->chart(array_map(fn (int $visit): float => (float) $visit, $this->dailyVisits()))
                ->color('success'),
            Stat::make('Visiteurs uniques', number_format((clone $visits)->whereNotNull('visitor_id')->distinct('visitor_id')->count('visitor_id')))
                ->description('Sessions anonymisées · 30 jours')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Visites attribuées', number_format(app(SiteAnalyticsDashboardData::class)->attributedVisitsCount()))
                ->description('Référents et campagnes · 30 jours')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
            Stat::make('Pages consultées', number_format($pageViewsCount))
                ->description('30 derniers jours')
                ->descriptionIcon('heroicon-m-document-magnifying-glass')
                ->color('primary'),
            Stat::make('Conversions', number_format($completedConversions))
                ->description('Parcours terminés · 30 jours')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
            Stat::make('Contenus actifs', number_format($activeContentCount))
                ->description('Articles, projets et formations')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('primary'),
            Stat::make('Rapports publiés', number_format(Report::published()->count()))
                ->description('Bibliothèque documentaire')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
            Stat::make('Messages à traiter', number_format(DB::table('contacts')->where('status', 'en_attente')->whereNull('deleted_at')->count()))
                ->description('Demandes de contact en attente')
                ->descriptionIcon('heroicon-m-inbox')
                ->color('warning'),
            Stat::make('Abonnés actifs', number_format(DB::table('newsletters')->where('is_active', true)->whereNull('deleted_at')->count()))
                ->description('Liste de diffusion')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('info'),
        ];
    }

    /**
     * @return list<int>
     */
    private function dailyVisits(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $dailyTotals = DB::table('visits')
            ->where('visited_at', '>=', $startDate)
            ->selectRaw('DATE(visited_at) as visit_date, COUNT(*) as total')
            ->groupBy('visit_date')
            ->pluck('total', 'visit_date');

        return array_values(collect(range(0, 6))
            ->map(fn (int $offset): int => (int) ($dailyTotals[now()->subDays(6 - $offset)->toDateString()] ?? 0))
            ->all());
    }
}
