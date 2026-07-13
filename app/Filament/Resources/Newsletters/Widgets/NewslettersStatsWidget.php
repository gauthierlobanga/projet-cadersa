<?php

namespace App\Filament\Resources\Newsletters\Widgets;

use App\Models\Newsletter;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class NewslettersStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = Newsletter::count();
        $active = Newsletter::where('is_active', true)->count();
        $unsubscribed = Newsletter::where('is_active', false)->count();

        $newThisMonth = Newsletter::where('created_at', '>=', Carbon::now()->startOfMonth())->count();

        return [
            Stat::make('Total Abonnés', number_format($total))
                ->description($newThisMonth.' ce mois-ci')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-users'),
            Stat::make('Abonnés Actifs', number_format($active))
                ->icon('heroicon-o-check-circle')
                ->color('primary'),
            Stat::make('Désabonnés', number_format($unsubscribed))
                ->icon('heroicon-o-x-circle')
                ->color('danger'),
        ];
    }
}
