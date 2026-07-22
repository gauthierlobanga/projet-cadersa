<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected ?string $primaryCategoryId = null;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['primary_category'] = $this->record->getPrimaryCategoryId();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->primaryCategoryId = $data['primary_category'] ?? null;

        unset($data['primary_category']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncPrimaryCategory($this->primaryCategoryId);
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function getCreatedNotification(): ?Notification
    {
        $post = $this->record;

        return Notification::make()
            ->title('Saved successfully')
            ->success()
            ->body('Changes to the post have been saved.')
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(route('tenant.blog.show', $post), shouldOpenInNewTab: true),
                Action::make('undo')
                    ->color('gray')
                    ->dispatch('undoEditingPost', [$post->id])
                    ->close(),
            ])
            ->broadcast(Auth::user());
    }
}
