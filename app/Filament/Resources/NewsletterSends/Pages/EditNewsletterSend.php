<?php

namespace App\Filament\Resources\NewsletterSends\Pages;

use App\Filament\Resources\NewsletterSends\NewsletterSendResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNewsletterSend extends EditRecord
{
    protected static string $resource = NewsletterSendResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
