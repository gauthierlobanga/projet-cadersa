<?php

namespace App\Filament\Resources\PostLikes\Pages;

use App\Filament\Resources\PostLikes\PostLikeResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostLike extends CreateRecord
{
    protected static string $resource = PostLikeResource::class;
}
