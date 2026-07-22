<?php

namespace App\Filament\Resources\FormationCategories\Pages;

use App\Filament\Resources\FormationCategories\FormationCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditFormationCategory extends EditRecord
{
    protected static string $resource = FormationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
