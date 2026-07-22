<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected ?string $primaryCategoryId = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->primaryCategoryId = $data['primary_category'] ?? null;

        unset($data['primary_category']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncPrimaryCategory($this->primaryCategoryId);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Post created')
            ->color('success')
            ->success()
            ->body('The post has been created successfully.')
            ->broadcast(Auth::user());
    }
}
