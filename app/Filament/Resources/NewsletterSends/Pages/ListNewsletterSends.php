<?php

namespace App\Filament\Resources\NewsletterSends\Pages;

use App\Filament\Resources\NewsletterSends\NewsletterSendResource;
use App\Filament\Resources\NewsletterSends\Widgets\NewsletterSendsStatsWidget;
use App\Models\NewsletterSend;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Enums\IconPosition;
use Illuminate\Database\Eloquent\Builder;

class ListNewsletterSends extends ListRecords
{
    protected static string $resource = NewsletterSendResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            NewsletterSendsStatsWidget::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous les envois'),
            'opened' => Tab::make('Ouverts')
                ->icon('heroicon-m-envelope-open')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', NewsletterSend::STATUS_OUVERT)),
            'clicked' => Tab::make('Cliqués')
                ->icon('heroicon-m-cursor-arrow-rays')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', NewsletterSend::STATUS_CLIQUE))
                ->badge(static::getResource()::getEloquentQuery()->where('status', NewsletterSend::STATUS_CLIQUE)->count()),
            'errors' => Tab::make('Erreurs')
                ->icon('heroicon-m-exclamation-triangle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', NewsletterSend::STATUS_ERREUR)),
            'this_week' => Tab::make('Cette semaine')
                ->badge(NewsletterSend::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count())
                ->badgeColor('info')
                ->icon('heroicon-m-calendar')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])),

            // NewsletterSends du mois dernier
            'last_month' => Tab::make('Mois dernier')
                ->badge(NewsletterSend::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count())
                ->badgeColor('info')
                ->icon('heroicon-m-calendar-days')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn (Builder $query) => $query->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])),

            // NewsletterSends des 30 derniers jours
            'last_30_days' => Tab::make('30 derniers jours')
                ->badge(NewsletterSend::where('created_at', '>=', now()->subDays(30))->count())
                ->badgeColor('info')
                ->icon('heroicon-m-calendar')
                ->iconPosition(IconPosition::Before)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('created_at', '>=', now()->subDays(30))),

        ];
    }
}
