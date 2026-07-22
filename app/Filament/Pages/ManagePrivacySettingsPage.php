<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\PrivacySettings;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Tiptap\Editor;
use UnitEnum;

class ManagePrivacySettingsPage extends SettingsPage
{
    protected static string $settings = PrivacySettings::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Politique de confidentialité';

    protected static ?string $slug = 'politique-confidentialite';

    protected static ?int $navigationSort = 12;

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
                Section::make('Politique de Confidentialité')
                    ->description('Modifiez le contenu de la politique de confidentialité.')
                    ->icon('heroicon-o-shield-check')
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('hero_badge')
                            ->label('Badge du Hero')
                            ->maxLength(100),
                        TextInput::make('hero_title')
                            ->label('Titre du Hero')
                            ->maxLength(255),
                        TextInput::make('hero_subtitle')
                            ->label('Sous-titre du Hero')
                            ->maxLength(255),
                        RichEditor::make('content')
                            ->label('Contenu')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
