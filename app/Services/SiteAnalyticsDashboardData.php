<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiteAnalyticsDashboardData
{
    /**
     * @return array{datasets: list<array{label: string, data: list<int>, backgroundColor: string, borderRadius: int}>, labels: list<string>}
     */
    public function conversionFunnel(): array
    {
        $since = now()->subDays(30);
        $started = DB::table('conversion_events')
            ->where('created_at', '>=', $since)
            ->select('step')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('step')
            ->pluck('total', 'step');
        $completed = DB::table('conversion_events')
            ->where('completed', true)
            ->where('completed_at', '>=', $since)
            ->select('step')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('step')
            ->pluck('total', 'step');

        $steps = collect(['contact', 'registration', 'newsletter_subscription'])
            ->merge($started->keys())
            ->merge($completed->keys())
            ->unique()
            ->values();

        return [
            'datasets' => [
                [
                    'label' => 'Commencées',
                    'data' => array_values($steps->map(fn (string $step): int => (int) ($started[$step] ?? 0))->all()),
                    'backgroundColor' => '#94a3b8',
                    'borderRadius' => 6,
                ],
                [
                    'label' => 'Terminées',
                    'data' => array_values($steps->map(fn (string $step): int => (int) ($completed[$step] ?? 0))->all()),
                    'backgroundColor' => '#059669',
                    'borderRadius' => 6,
                ],
            ],
            'labels' => array_values($steps->map(fn (string $step): string => $this->conversionLabel($step))->all()),
        ];
    }

    /**
     * @return array{datasets: list<array{label: string, data: list<int>, backgroundColor: list<string>, borderWidth: int}>, labels: list<string>}
     */
    public function deviceBreakdown(): array
    {
        $devices = DB::table('visits')
            ->where('visited_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF(device, ''), 'Non renseigné') as device_label, COUNT(*) as total")
            ->groupBy('device_label')
            ->orderByDesc('total')
            ->get();

        return [
            'datasets' => [[
                'label' => 'Visites',
                'data' => array_values($devices->pluck('total')->map(fn (mixed $total): int => (int) $total)->all()),
                'backgroundColor' => ['#047857', '#0f766e', '#64748b', '#f59e0b', '#cbd5e1'],
                'borderWidth' => 0,
            ]],
            'labels' => array_values($devices->pluck('device_label')->map(fn (mixed $device): string => (string) $device)->all()),
        ];
    }

    /**
     * @return array{datasets: list<array{label: string, data: list<int>, backgroundColor: list<string>, borderWidth: int}>, labels: list<string>}
     */
    public function trafficSources(): array
    {
        $sources = $this->trafficSourceTotals();

        return [
            'datasets' => [[
                'label' => 'Visites',
                'data' => array_map(fn (array $source): int => $source['total'], $sources),
                'backgroundColor' => ['#047857', '#0f766e', '#0ea5a4', '#f59e0b', '#94a3b8'],
                'borderWidth' => 0,
            ]],
            'labels' => array_map(fn (array $source): string => $source['label'], $sources),
        ];
    }

    public function attributedVisitsCount(): int
    {
        return (int) DB::table('visits')
            ->where('visited_at', '>=', now()->subDays(30))
            ->where(function ($query): void {
                $query->whereNotNull('referrer')
                    ->orWhereNotNull('utm_params');
            })
            ->count();
    }

    /**
     * @return array{pages: list<array{label: string, value: int, share: int}>, sources: list<array{label: string, value: int, share: int}>}
     */
    public function summaryTables(): array
    {
        $pages = DB::table('page_views')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF(url, ''), '/') as label, COUNT(*) as total")
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $sources = array_slice($this->trafficSourceTotals(), 0, 5);
        $pagesTotal = (int) DB::table('page_views')->where('viewed_at', '>=', now()->subDays(30))->count();
        $visitsTotal = (int) DB::table('visits')->where('visited_at', '>=', now()->subDays(30))->count();
        $pageSummaries = [];

        foreach ($pages as $page) {
            $pageCount = (int) $page->total;
            $pageSummaries[] = [
                'label' => Str::limit((string) $page->label, 48),
                'value' => $pageCount,
                'share' => $pagesTotal > 0 ? (int) round(($pageCount / $pagesTotal) * 100) : 0,
            ];
        }

        return [
            'pages' => $pageSummaries,
            'sources' => array_map(fn (array $source): array => [
                'label' => $source['label'],
                'value' => $source['total'],
                'share' => $visitsTotal > 0 ? (int) round(($source['total'] / $visitsTotal) * 100) : 0,
            ], $sources),
        ];
    }

    /**
     * @return array{datasets: list<array{label: string, data: list<int>, backgroundColor: string, borderRadius: int}>, labels: list<string>}
     */
    public function topPages(): array
    {
        $topPages = DB::table('page_views')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF(url, ''), '/') as page_url, COUNT(*) as total")
            ->groupBy('page_url')
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        return [
            'datasets' => [[
                'label' => 'Consultations',
                'data' => array_values($topPages->pluck('total')->map(fn (mixed $total): int => (int) $total)->all()),
                'backgroundColor' => '#059669',
                'borderRadius' => 6,
            ]],
            'labels' => array_values($topPages->pluck('page_url')->map(fn (mixed $url): string => Str::limit(is_string($url) && $url !== '' ? $url : '/', 48))->all()),
        ];
    }

    /**
     * @return array{datasets: list<array{label: string, data: list<int>, borderColor: string, backgroundColor: string, fill: bool, tension: float}>, labels: list<string>}
     */
    public function dailyVisits(): array
    {
        $startDate = CarbonImmutable::today()->subDays(13);
        $dailyTotals = DB::table('visits')
            ->whereBetween('visited_at', [$startDate->startOfDay(), now()])
            ->selectRaw('DATE(visited_at) as visit_date, COUNT(*) as total')
            ->groupBy('visit_date')
            ->pluck('total', 'visit_date');

        $labels = [];
        $values = [];

        foreach (range(0, 13) as $offset) {
            $date = $startDate->addDays($offset);
            $labels[] = $date->translatedFormat('d M');
            $values[] = (int) ($dailyTotals[$date->toDateString()] ?? 0);
        }

        return [
            'datasets' => [[
                'label' => 'Visites',
                'data' => $values,
                'borderColor' => '#047857',
                'backgroundColor' => 'rgba(16, 185, 129, 0.16)',
                'fill' => true,
                'tension' => 0.35,
            ]],
            'labels' => $labels,
        ];
    }

    private function conversionLabel(string $step): string
    {
        return match ($step) {
            'contact' => 'Demande de contact',
            'registration' => 'Création de compte',
            'newsletter_subscription' => 'Inscription à la newsletter',
            default => Str::headline($step),
        };
    }

    /**
     * @return list<array{label: string, total: int}>
     */
    private function trafficSourceTotals(): array
    {
        $utmSourceExpression = match (DB::connection()->getDriverName()) {
            'mysql' => "JSON_UNQUOTE(JSON_EXTRACT(utm_params, '$.utm_source'))",
            'sqlite' => "json_extract(utm_params, '$.utm_source')",
            'pgsql' => "utm_params->>'utm_source'",
            default => 'NULL',
        };

        $sources = DB::table('visits')
            ->where('visited_at', '>=', now()->subDays(30))
            ->selectRaw("COALESCE(NULLIF({$utmSourceExpression}, ''), NULLIF(referrer, ''), 'Direct / sans campagne') as source_label, COUNT(*) as total")
            ->groupBy('source_label')
            ->orderByDesc('total')
            ->limit(8)
            ->get()
            ->map(fn (object $source): array => [
                'label' => Str::limit((string) $source->source_label, 40),
                'total' => (int) $source->total,
            ])
            ->values()
            ->all();

        return array_values($sources);
    }
}
