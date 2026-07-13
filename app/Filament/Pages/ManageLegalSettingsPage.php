<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\LegalSettings;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Tiptap\Editor;
use UnitEnum;

class ManageLegalSettingsPage extends SettingsPage
{
    protected static string $settings = LegalSettings::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Mentions Légales';

    protected static ?string $slug = 'mentions-legales';

    protected static ?int $navigationSort = 11;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        if (isset($data['content']) && is_array($data['content'])) {
            $data['content'] = (new Editor)->setContent($data['content'])->getHTML();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['content']) && is_string($data['content'])) {
            $data['content'] = (new Editor)->setContent($data['content'])->getDocument();
        }

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Mentions Légales')
                    ->description('Modifiez le contenu des mentions légales du site.')
                    ->icon('heroicon-o-document-text')
                    ->columnSpanFull()
                    ->schema([
                        RichEditor::make('content')
                            ->label('Contenu')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
