<?php

namespace App\Filament\Resources\Reports\Pages;

use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Widgets\ReportStatsWidget;
use App\Models\Report;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListReports extends ListRecords
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReportStatsWidget::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Tous')
                ->badge(Report::count())
                ->badgeColor('gray')
                ->icon('heroicon-m-document-text'),
            'annual' => Tab::make('Annuels')
                ->badge(Report::where('period_type', Report::PERIOD_ANNUAL)->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('period_type', Report::PERIOD_ANNUAL)),
            'quarterly' => Tab::make('Trimestriels')
                ->badge(Report::where('period_type', Report::PERIOD_QUARTERLY)->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('period_type', Report::PERIOD_QUARTERLY)),
            'monthly' => Tab::make('Mensuels')
                ->badge(Report::where('period_type', Report::PERIOD_MONTHLY)->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('period_type', Report::PERIOD_MONTHLY)),
            'drafts' => Tab::make('Brouillons')
                ->badge(Report::where('status', Report::STATUS_DRAFT)->count())
                ->badgeColor('gray')
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('status', Report::STATUS_DRAFT)),
        ];
    }

    public function getDefaultActiveTab(): string|int|null
    {
        return 'all';
    }
}
