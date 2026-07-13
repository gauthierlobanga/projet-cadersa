<?php

namespace App\Filament\Resources\PostLikes\Pages;

use App\Filament\Resources\PostLikes\PostLikeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPostLike extends EditRecord
{
    protected static string $resource = PostLikeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
