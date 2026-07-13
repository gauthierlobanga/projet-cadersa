<?php

namespace App\Filament\Resources\CadersaAsblDocumentLegals\Pages;

use App\Filament\Resources\CadersaAsblDocumentLegals\CadersaAsblDocumentLegalResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCadersaAsblDocumentLegals extends ListRecords
{
    protected static string $resource = CadersaAsblDocumentLegalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
