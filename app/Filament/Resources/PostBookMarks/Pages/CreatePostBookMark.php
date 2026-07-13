<?php

namespace App\Filament\Resources\PostBookMarks\Pages;

use App\Filament\Resources\PostBookMarks\PostBookMarkResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePostBookMark extends CreateRecord
{
    protected static string $resource = PostBookMarkResource::class;
}
