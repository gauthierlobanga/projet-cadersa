<?php

namespace App\Filament\Resources\PostBookMarks\Widgets;

use App\Models\PostBookMark;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostBookMarksStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = PostBookMark::count();
        $today = PostBookMark::whereDate('created_at', today())->count();
        $thisWeek = PostBookMark::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $thisMonth = PostBookMark::whereMonth('created_at', now()->month)->count();
        $yesterday = PostBookMark::whereDate('created_at', today()->subDay())->count();
        $avgPerDay = number_format($thisWeek / max(1, now()->dayOfWeek), 1);

        $topUser = PostBookMark::select('user_id')
            ->selectRaw('count(*) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->first();
        $topUserCount = $topUser ? $topUser->total : 0;

        $topPost = PostBookMark::select('post_id')
            ->selectRaw('count(*) as total')
            ->groupBy('post_id')
            ->orderByDesc('total')
            ->first();
        $topPostCount = $topPost ? $topPost->total : 0;

        return [
            Stat::make('Total des signets', $total)
                ->description('Favoris enregistrés')
                ->descriptionIcon(Heroicon::Bookmark)
                ->icon(Heroicon::Bookmark)
                ->color('primary'),

            Stat::make('Aujourd’hui', $today)
                ->description('Ajoutés du jour')
                ->descriptionIcon(Heroicon::Calendar)
                ->icon(Heroicon::Calendar)
                ->color('success'),

            Stat::make('Cette semaine', $thisWeek)
                ->description('Ajoutés depuis lundi')
                ->descriptionIcon(Heroicon::CalendarDays)
                ->icon('heroicon-m-calendar-days')
                ->color('info'),

            Stat::make('Ce mois', $thisMonth)
                ->description('Ajoutés ce mois')
                ->descriptionIcon(Heroicon::CalendarDateRange)
                ->icon(Heroicon::CalendarDateRange)
                ->color('warning'),

            Stat::make('Hier', $yesterday)
                ->description('Ajoutés hier')
                ->descriptionIcon('heroicon-m-arrow-uturn-left')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray'),

            Stat::make('Moyenne / jour', $avgPerDay)
                ->description('Moyenne quotidienne')
                ->descriptionIcon('heroicon-m-calculator')
                ->icon('heroicon-m-calculator')
                ->color('gray'),

            Stat::make('Top utilisateur', $topUserCount)
                ->description('Utilisateur le plus actif')
                ->descriptionIcon('heroicon-m-user')
                ->icon('heroicon-m-user')
                ->color('success'),

            Stat::make('Top article', $topPostCount)
                ->description('Article le plus sauvegardé')
                ->descriptionIcon('heroicon-m-document-text')
                ->icon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
