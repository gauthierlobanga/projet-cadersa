<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\CookieSettings;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Tiptap\Editor;
use UnitEnum;

class ManageCookieSettingsPage extends SettingsPage
{
    protected static string $settings = CookieSettings::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Gestion des Cookies';

    protected static ?string $slug = 'gestion-cookies';

    protected static ?int $navigationSort = 14;

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
                Section::make('Gestion des Cookies')
                    ->description('Modifiez la politique et gestion des cookies.')
                    ->icon(Heroicon::OutlinedShieldCheck)
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
