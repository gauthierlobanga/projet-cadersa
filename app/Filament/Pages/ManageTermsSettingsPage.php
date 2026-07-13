<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\TermsSettings;
use Filament\Forms\Components\RichEditor;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Tiptap\Editor;
use UnitEnum;

class ManageTermsSettingsPage extends SettingsPage
{
    protected static string $settings = TermsSettings::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Conditions d\'utilisation';

    protected static ?string $slug = 'conditions-utilisation';

    protected static ?int $navigationSort = 13;

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
                Section::make('Conditions d\'utilisation')
                    ->description('Modifiez les conditions générales d\'utilisation (CGU).')
                    ->icon('heroicon-o-document-check')
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
