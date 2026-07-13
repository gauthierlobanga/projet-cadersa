<?php

namespace App\Filament\Resources\PostBookMarks\Pages;

use App\Filament\Resources\PostBookMarks\PostBookMarkResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPostBookMark extends EditRecord
{
    protected static string $resource = PostBookMarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
