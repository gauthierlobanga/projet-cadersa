<?php

namespace App\Filament\Resources\PostBookMarks\Pages;

use App\Filament\Resources\PostBookMarks\PostBookMarkResource;
use App\Filament\Resources\PostBookMarks\Widgets\PostBookMarksStatsWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPostBookMarks extends ListRecords
{
    protected static string $resource = PostBookMarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PostBookMarksStatsWidget::class,
        ];
    }
}
