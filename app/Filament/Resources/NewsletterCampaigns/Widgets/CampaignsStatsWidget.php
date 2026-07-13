<?php

namespace App\Filament\Resources\NewsletterCampaigns\Widgets;

use App\Models\NewsletterCampaign;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CampaignsStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = NewsletterCampaign::count();
        $sent = NewsletterCampaign::where('status', NewsletterCampaign::STATUS_ENVOYE)->count();
        $scheduled = NewsletterCampaign::where('status', NewsletterCampaign::STATUS_PROGRAMME)->count();

        $avgOpenRate = NewsletterCampaign::where('status', NewsletterCampaign::STATUS_ENVOYE)->avg('total_desabonnements') ?? 0; // à revoir

        return [
            Stat::make('Campagnes totales', number_format($total))
                ->icon('heroicon-o-megaphone'),
            Stat::make('Campagnes envoyées', number_format($sent))
                ->icon('heroicon-o-paper-airplane')
                ->color('success'),
            Stat::make('Taux d\'ouverture moyen', round($avgOpenRate, 2).'%')
                ->icon('heroicon-o-chart-pie')
                ->color('info')
                ->description($scheduled.' en attente d\'envoi'),
        ];
    }
}
