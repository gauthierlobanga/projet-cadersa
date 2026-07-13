<?php

namespace App\Filament\Resources\NewsletterSends\Widgets;

use App\Models\NewsletterSend;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class NewsletterSendsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSent = NewsletterSend::where('status', NewsletterSend::STATUS_ENVOYE)->count();
        $totalOpened = NewsletterSend::where('status', NewsletterSend::STATUS_OUVERT)->count();
        $totalClicked = NewsletterSend::where('status', NewsletterSend::STATUS_CLIQUE)->count();

        $openRate = $totalSent > 0 ? ($totalOpened / $totalSent) * 100 : 0;
        $clickRate = $totalSent > 0 ? ($totalClicked / $totalSent) * 100 : 0;

        return [
            Stat::make('Emails envoyés', number_format($totalSent))
                ->icon('heroicon-o-paper-airplane')
                ->color('primary'),
            Stat::make('Ouvertures', number_format($totalOpened))
                ->description(round($openRate, 2).'% d\'ouverture')
                ->icon('heroicon-o-envelope-open')
                ->color('warning'),
            Stat::make('Clics', number_format($totalClicked))
                ->description(round($clickRate, 2).'% de clic')
                ->icon('heroicon-o-cursor-arrow-rays')
                ->color('success'),
        ];
    }
}
