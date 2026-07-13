<?php

namespace App\Filament\Resources\CadersaAsblDocumentLegals\Pages;

use App\Filament\Resources\CadersaAsblDocumentLegals\CadersaAsblDocumentLegalResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditCadersaAsblDocumentLegal extends EditRecord
{
    protected static string $resource = CadersaAsblDocumentLegalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
