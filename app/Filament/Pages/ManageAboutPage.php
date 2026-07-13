<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\AboutSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class ManageAboutPage extends SettingsPage
{
    protected static string $settings = AboutSettings::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Page À propos';

    protected static ?string $slug = 'about-page';

    protected static ?int $navigationSort = 10;

    /**
     * Anciennes images.
     */
    protected ?string $oldHeroImage = null;

    protected ?string $oldAboutImage = null;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $this->oldHeroImage = $data['hero_image_url'] ?? null;
        $this->oldAboutImage = $data['about_image_url'] ?? null;

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (
            $this->oldHeroImage &&
            $this->oldHeroImage !== ($data['hero_image_url'] ?? null)
        ) {
            Storage::disk('public')->delete($this->oldHeroImage);
        }

        if (
            $this->oldAboutImage &&
            $this->oldAboutImage !== ($data['about_image_url'] ?? null)
        ) {
            Storage::disk('public')->delete($this->oldAboutImage);
        }

        return $data;
    }

    // ── Formulaire ─────────────────────────────────────────
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Section Hero')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Titre principal')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('hero_subtitle')
                                            ->label('Sous‑titre')
                                            ->maxLength(255),
                                    ]),

                                FileUpload::make('hero_image_url')
                                    ->label('Image de fond du hero')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('about')
                                    ->visibility('public')
                                    ->moveFiles()
                                    ->preserveFilenames(),

                                FileUpload::make('about_image_url')
                                    ->label('Image secondaire')
                                    ->image()
                                    ->imageEditor()
                                    ->disk('public')
                                    ->directory('about')
                                    ->visibility('public')
                                    ->moveFiles()
                                    ->preserveFilenames(),
                            ]),

                        Section::make('Contenu principal')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('hero_badge')
                                    ->label('Badge')
                                    ->maxLength(100),
                                RichEditor::make('about_text')
                                    ->label('À propos')
                                    ->required()
                                    ->columnSpanFull(),
                                RichEditor::make('vision_text')
                                    ->label('Vision')
                                    ->columnSpanFull(),
                                RichEditor::make('mission_text')
                                    ->label('Mission')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
