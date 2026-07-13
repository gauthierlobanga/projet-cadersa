<?php

namespace App\Filament\Resources\PostLikes\Widgets;

use App\Models\PostLike;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PostLikeStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $total = PostLike::count();
        $today = PostLike::whereDate('created_at', today())->count();
        $thisWeek = PostLike::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $thisMonth = PostLike::whereMonth('created_at', now()->month)->count();
        $yesterday = PostLike::whereDate('created_at', today()->subDay())->count();
        $avgPerDay = number_format($thisWeek / max(1, now()->dayOfWeek), 1);

        $topUser = PostLike::select('user_id')
            ->selectRaw('count(*) as total')
            ->groupBy('user_id')
            ->orderByDesc('total')
            ->first();
        $topUserCount = $topUser ? $topUser->total : 0;

        $topPost = PostLike::select('post_id')
            ->selectRaw('count(*) as total')
            ->groupBy('post_id')
            ->orderByDesc('total')
            ->first();
        $topPostCount = $topPost ? $topPost->total : 0;

        return [
            Stat::make('Total des likes', $total)
                ->description('J’aime enregistrés')
                ->descriptionIcon('heroicon-m-heart')
                ->icon('heroicon-m-heart')
                ->color('danger'),

            Stat::make('Aujourd’hui', $today)
                ->description('Likes du jour')
                ->descriptionIcon(Heroicon::Calendar)
                ->icon(Heroicon::Calendar)
                ->color('success'),

            Stat::make('Cette semaine', $thisWeek)
                ->description('Likes depuis lundi')
                ->descriptionIcon(Heroicon::CalendarDays)
                ->icon(Heroicon::CalendarDays)
                ->color('info'),

            Stat::make('Ce mois', $thisMonth)
                ->description('Likes ce mois')
                ->descriptionIcon(Heroicon::CalendarDateRange)
                ->icon(Heroicon::CalendarDateRange)
                ->color('warning'),

            Stat::make('Hier', $yesterday)
                ->description('Likes reçus hier')
                ->descriptionIcon('heroicon-m-arrow-uturn-left')
                ->icon('heroicon-m-arrow-uturn-left')
                ->color('gray'),

            Stat::make('Moyenne / jour', $avgPerDay)
                ->description('Moyenne quotidienne')
                ->descriptionIcon('heroicon-m-calculator')
                ->icon('heroicon-m-calculator')
                ->color('gray'),

            Stat::make('Top utilisateur', $topUserCount)
                ->description('Le plus de likes donnés')
                ->descriptionIcon('heroicon-m-user')
                ->icon('heroicon-m-user')
                ->color('success'),

            Stat::make('Top article', $topPostCount)
                ->description('Article le plus aimé')
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
