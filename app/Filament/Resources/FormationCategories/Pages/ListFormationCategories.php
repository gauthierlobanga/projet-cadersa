<?php

namespace App\Filament\Resources\FormationCategories\Pages;

use App\Filament\Resources\FormationCategories\FormationCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormationCategories extends ListRecords
{
    protected static string $resource = FormationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
