<?php

namespace App\Filament\Resources\NewsletterCampaigns\Pages;

use App\Filament\Resources\NewsletterCampaigns\NewsletterCampaignResource;
use App\Filament\Resources\NewsletterCampaigns\Widgets\CampaignsStatsWidget;
use App\Models\NewsletterCampaign;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListNewsletterCampaigns extends ListRecords
{
    protected static string $resource = NewsletterCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CampaignsStatsWidget::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Toutes'),
            'drafts' => Tab::make('Brouillons')
                ->icon('heroicon-m-pencil')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', NewsletterCampaign::STATUS_BROUILLON)),
            'scheduled' => Tab::make('Programmées')
                ->icon('heroicon-m-clock')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', NewsletterCampaign::STATUS_PROGRAMME)),
            'sent' => Tab::make('Envoyées')
                ->icon('heroicon-m-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', NewsletterCampaign::STATUS_ENVOYE))
                ->badge(static::getResource()::getEloquentQuery()->where('status', NewsletterCampaign::STATUS_ENVOYE)->count()),
            // Posts de cette semaine
            'this_week' => Tab::make('Cette semaine')
                ->badge(NewsletterCampaign::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->badgeColor('info')
                ->icon('heroicon-m-calendar')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),

            // NewsletterCampaigns du mois dernier
            'last_month' => Tab::make('Mois dernier')
                ->badge(NewsletterCampaign::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count())
                ->badgeColor('info')
                ->icon('heroicon-m-calendar-days')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])),

            // NewsletterCampaigns des 30 derniers jours
            'last_30_days' => Tab::make('30 derniers jours')
                ->badge(NewsletterCampaign::where('created_at', '>=', now()->subDays(30))->count())
                ->badgeColor('info')
                ->icon('heroicon-m-calendar')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(30))),
        ];
    }
}
