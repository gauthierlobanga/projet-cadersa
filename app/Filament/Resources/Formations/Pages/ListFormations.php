<?php

namespace App\Filament\Resources\Formations\Pages;

use App\Filament\Resources\Formations\FormationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFormations extends ListRecords
{
    protected static string $resource = FormationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
