<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\AboutSettings;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Alignment;
use Filament\Support\Icons\Heroicon;
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

        if (empty($data['impact_content'] ?? [])) {
            $data['impact_content'] = [[
                'impact_heading' => $data['impact_heading'] ?? null,
                'impact_subtitle' => $data['impact_subtitle'] ?? null,
                'impact_description' => $data['impact_description'] ?? null,
                'impact_highlight_heading' => $data['impact_highlight_heading'] ?? null,
                'impact_highlight_text' => $data['impact_highlight_text'] ?? null,
                'impact_highlight_cta_label' => $data['impact_highlight_cta_label'] ?? null,
                'impact_highlight_cta_url' => $data['impact_highlight_cta_url'] ?? null,
            ]];
        }

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

                                Repeater::make('impact_content')
                                    ->label('Bloc impact')
                                    ->columns(1)
                                    ->collapsible()
                                    ->itemLabel(fn (?array $state): string => $state['impact_heading'] ?? 'Impact')
                                    ->schema([
                                        TextInput::make('impact_heading')
                                            ->label('Titre de la section impact')
                                            ->maxLength(255),
                                        TextInput::make('impact_subtitle')
                                            ->label('Sous-titre de l’impact')
                                            ->maxLength(255),
                                        RichEditor::make('impact_description')
                                            ->label('Description détaillée de l’impact')
                                            ->columnSpanFull(),
                                        TextInput::make('impact_highlight_heading')
                                            ->label('Titre du bloc secondaire')
                                            ->maxLength(255),
                                        RichEditor::make('impact_highlight_text')
                                            ->label('Texte du bloc secondaire')
                                            ->columnSpanFull(),
                                        TextInput::make('impact_highlight_cta_label')
                                            ->label('Libellé du bouton du bloc secondaire')
                                            ->maxLength(100),
                                        TextInput::make('impact_highlight_cta_url')
                                            ->label('URL du bouton du bloc secondaire')
                                            ->maxLength(255),
                                    ])
                                    ->defaultItems(1)
                                    ->minItems(1)
                                    ->maxItems(1)
                                    ->columnSpanFull(),

                                Builder::make('impact_stats')
                                    ->label('Cartes d’impact')
                                    ->addActionLabel('Ajouter une carte d’impact')
                                    ->addActionAlignment(Alignment::Start)
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(true)
                                    ->blockHeaders(true)
                                    ->blockPreviews(true)
                                    ->blockPickerColumns(['md' => 2, 'xl' => 3])
                                    ->blockPickerWidth('3xl')
                                    ->reorderableWithDragAndDrop()
                                    ->reorderableWithButtons()
                                    ->cloneable()
                                    ->collapsible()
                                    ->collapsed(false)
                                    ->deletable()
                                    ->blocks([
                                        Block::make('impact_card')
                                            ->label(function (?array $state): string {
                                                if ($state === null) {
                                                    return 'Carte d’impact';
                                                }

                                                return $state['label'] ?? $state['data']['label'] ?? $state['data']['value'] ?? 'Carte d’impact';
                                            })
                                            ->icon(Heroicon::Sparkles)
                                            ->preview('filament.forms.builder.impact-card-preview')
                                            ->schema([
                                                TextInput::make('value')
                                                    ->label('Valeur principale')
                                                    ->required(),
                                                TextInput::make('label')
                                                    ->label('Titre')
                                                    ->required(),
                                                TextInput::make('description')
                                                    ->label('Description courte')
                                                    ->maxLength(255),
                                                FileUpload::make('image_url')
                                                    ->label('Image d’impact')
                                                    ->image()
                                                    ->disk('public')
                                                    ->directory('about/impact')
                                                    ->visibility('public')
                                                    ->moveFiles()
                                                    ->preserveFilenames(),
                                                TextInput::make('icon')
                                                    ->label('Icône (chemin SVG)')
                                                    ->helperText('Laisser vide pour utiliser une icône par défaut.'),
                                            ]),
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
