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

        // Map legacy single fields into the new Builder-backed blocks for compatibility
        if (empty($data['about_blocks'] ?? []) && isset($data['about_text'])) {
            $data['about_blocks'] = [[
                'title' => $data['about_title'] ?? null,
                'description' => $data['about_text'],
                'image_url' => $data['about_image_url'] ?? null,
            ]];
        }

        if (empty($data['vision_blocks'] ?? []) && isset($data['vision_text'])) {
            $data['vision_blocks'] = [[
                'title' => $data['vision_title'] ?? null,
                'description' => $data['vision_text'],
                'image_url' => $data['about_image_url'] ?? null,
            ]];
        }

        if (empty($data['mission_blocks'] ?? []) && isset($data['mission_text'])) {
            $data['mission_blocks'] = [[
                'title' => $data['mission_title'] ?? null,
                'description' => $data['mission_text'],
                'image_url' => $data['about_image_url'] ?? null,
            ]];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Gestion des images
        if ($this->oldHeroImage && $this->oldHeroImage !== ($data['hero_image_url'] ?? null)) {
            Storage::disk('public')->delete($this->oldHeroImage);
        }

        if ($this->oldAboutImage && $this->oldAboutImage !== ($data['about_image_url'] ?? null)) {
            Storage::disk('public')->delete($this->oldAboutImage);
        }

        // Garantir la présence des clés
        $data['impact_content'] = $data['impact_content'] ?? [];
        $data['impact_stats'] = $data['impact_stats'] ?? [];

        // Récupérer les paramètres actuels pour les valeurs par défaut
        $settings = app(AboutSettings::class);

        $defaults = [
            'hero_title' => $settings->hero_title,
            'hero_subtitle' => $settings->hero_subtitle,
            'hero_badge' => $settings->hero_badge,
            'about_text' => $settings->about_text,
            'vision_text' => $settings->vision_text,
            'mission_text' => $settings->mission_text,
            'impact_heading' => $settings->impact_heading,
            'impact_subtitle' => $settings->impact_subtitle,
            'impact_description' => $settings->impact_description,
            'impact_highlight_heading' => $settings->impact_highlight_heading,
            'impact_highlight_text' => $settings->impact_highlight_text,
            'impact_highlight_cta_label' => $settings->impact_highlight_cta_label,
            'impact_highlight_cta_url' => $settings->impact_highlight_cta_url,
            'impact_content' => $settings->impact_content,
            'impact_stats' => $settings->impact_stats,
            'about_blocks' => $settings->about_blocks,
            'vision_blocks' => $settings->vision_blocks,
            'mission_blocks' => $settings->mission_blocks,
            'hero_image_url' => $settings->hero_image_url,
            'about_image_url' => $settings->about_image_url,
        ];

        // Fusionner les valeurs manquantes (ne pas écraser les valeurs soumises)
        foreach ($defaults as $key => $value) {
            if (! array_key_exists($key, $data) || $data[$key] === null) {
                $data[$key] = $value;
            }
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

                                Builder::make('about_blocks')
                                    ->label('Blocs À propos')
                                    ->addActionLabel('Ajouter un bloc')
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(false)
                                    ->blocks([
                                        Block::make('content')
                                            ->label('Bloc contenu')
                                            ->schema([
                                                TextInput::make('title')->label('Titre')->maxLength(255),
                                                RichEditor::make('description')
                                                    ->label('Description')
                                                    ->columnSpanFull()
                                                    ->json()
                                                    ->customTextColors(true)
                                                    ->resizableImages(true)
                                                    ->uploadingFileMessage(__('Téléversement en cours...'))
                                                    ->preventFileAttachmentPathTampering(true),
                                                FileUpload::make('image_url')
                                                    ->label('Image')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->disk('public')
                                                    ->directory('about')
                                                    ->visibility('public')
                                                    ->moveFiles()
                                                    ->preserveFilenames(),
                                            ]),
                                    ])
                                    ->columnSpanFull(),

                                Builder::make('vision_blocks')
                                    ->label('Blocs Vision')
                                    ->addActionLabel('Ajouter un bloc')
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(false)
                                    ->blocks([
                                        Block::make('content')
                                            ->label('Bloc contenu')
                                            ->schema([
                                                TextInput::make('title')->label('Titre')->maxLength(255),
                                                RichEditor::make('description')
                                                    ->label('Description')
                                                    ->columnSpanFull()
                                                    ->json()
                                                    ->customTextColors(true)
                                                    ->resizableImages(true)
                                                    ->uploadingFileMessage(__('Téléversement en cours...'))
                                                    ->preventFileAttachmentPathTampering(true),
                                                FileUpload::make('image_url')
                                                    ->label('Image')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->disk('public')
                                                    ->directory('about')
                                                    ->visibility('public')
                                                    ->moveFiles()
                                                    ->preserveFilenames(),
                                            ]),
                                    ])
                                    ->columnSpanFull(),

                                Builder::make('mission_blocks')
                                    ->label('Blocs Mission')
                                    ->addActionLabel('Ajouter un bloc')
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(false)
                                    ->blocks([
                                        Block::make('content')
                                            ->label('Bloc contenu')
                                            ->schema([
                                                TextInput::make('title')->label('Titre')->maxLength(255),
                                                RichEditor::make('description')
                                                    ->label('Description')
                                                    ->columnSpanFull()
                                                    ->json()
                                                    ->customTextColors(true)
                                                    ->resizableImages(true)
                                                    ->uploadingFileMessage(__('Téléversement en cours...'))
                                                    ->preventFileAttachmentPathTampering(true),
                                                FileUpload::make('image_url')
                                                    ->label('Image')
                                                    ->image()
                                                    ->imageEditor()
                                                    ->disk('public')
                                                    ->directory('about')
                                                    ->visibility('public')
                                                    ->moveFiles()
                                                    ->preserveFilenames(),
                                            ]),
                                    ])
                                    ->columnSpanFull(),

                            ]),
                        Section::make('Section sur l\'impact')
                            ->icon('heroicon-o-document-text')
                            ->schema([
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
                                            ->columnSpanFull()
                                            ->json()
                                            ->customTextColors(true)
                                            ->resizableImages(true)
                                            ->uploadingFileMessage(__('Téléversement en cours...'))
                                            ->preventFileAttachmentPathTampering(true),
                                        TextInput::make('impact_highlight_heading')
                                            ->label('Titre du bloc secondaire')
                                            ->maxLength(255),
                                        RichEditor::make('impact_highlight_text')
                                            ->label('Texte du bloc secondaire')
                                            ->columnSpanFull()
                                            ->json()
                                            ->customTextColors(true)
                                            ->resizableImages(true)
                                            ->uploadingFileMessage(__('Téléversement en cours...'))
                                            ->preventFileAttachmentPathTampering(true),
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
                                                    ->imageEditor()
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
    // public function form(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             Section::make()
    //                 ->columnSpanFull()
    //                 ->schema([
    //                     Section::make('Section Hero')
    //                         ->icon('heroicon-o-photo')
    //                         ->schema([
    //                             Group::make()
    //                                 ->columns(2)
    //                                 ->schema([
    //                                     TextInput::make('hero_title')
    //                                         ->label('Titre principal')
    //                                         ->required()
    //                                         ->maxLength(255),
    //                                     TextInput::make('hero_subtitle')
    //                                         ->label('Sous‑titre')
    //                                         ->maxLength(255),
    //                                 ]),

    //                             FileUpload::make('hero_image_url')
    //                                 ->label('Image de fond du hero')
    //                                 ->image()
    //                                 ->imageEditor()
    //                                 ->editableSvgs()
    //                                 ->confirmSvgEditing()
    //                                 ->circleCropper()
    //                                 ->automaticallyCropImagesToAspectRatio()
    //                                 ->imagePreviewHeight('400')
    //                                 ->imageEditorViewportWidth(1200)
    //                                 ->imageEditorViewportHeight(800)
    //                                 ->disk('public')
    //                                 ->directory('about')
    //                                 ->visibility('public')
    //                                 ->moveFiles()
    //                                 ->preserveFilenames(),

    //                             FileUpload::make('about_image_url')
    //                                 ->label('Image secondaire')
    //                                 ->image()
    //                                 ->imageEditor()
    //                                 ->editableSvgs()
    //                                 ->confirmSvgEditing()
    //                                 ->circleCropper()
    //                                 ->automaticallyCropImagesToAspectRatio()
    //                                 ->imagePreviewHeight('400')
    //                                 ->imageEditorViewportWidth(1200)
    //                                 ->imageEditorViewportHeight(800)
    //                                 ->automaticallyOpenImageEditorForAspectRatio()
    //                                 ->disk('public')
    //                                 ->directory('about')
    //                                 ->visibility('public')
    //                                 ->moveFiles()
    //                                 ->preserveFilenames(),
    //                         ]),

    //                     Section::make('Contenu principal')
    //                         ->icon('heroicon-o-document-text')
    //                         ->schema([
    //                             TextInput::make('hero_badge')
    //                                 ->label('Badge')
    //                                 ->maxLength(100),
    //                             Builder::make('about_blocks')
    //                                 ->label('Blocs À propos')
    //                                 ->addActionLabel('Ajouter un bloc')
    //                                 ->blockNumbers(false)
    //                                 ->blockLabels(true)
    //                                 ->blockIcons(false)
    //                                 ->blocks([
    //                                     Block::make('content')
    //                                         ->label('Bloc contenu')
    //                                         ->schema([
    //                                             TextInput::make('title')->label('Titre')->maxLength(255),
    //                                             RichEditor::make('description')
    //                                                 ->label('Description')
    //                                                 ->columnSpanFull()
    //                                                 ->json()
    //                                                 ->customTextColors(true)
    //                                                 ->resizableImages(true)
    //                                                 ->uploadingFileMessage(__('Téléversement en cours...'))
    //                                                 ->preventFileAttachmentPathTampering(true),
    //                                             FileUpload::make('image_url')
    //                                                 ->label('Image')
    //                                                 ->image()
    //                                                 ->imageEditor()
    //                                                 ->editableSvgs()
    //                                                 ->confirmSvgEditing()
    //                                                 ->circleCropper()
    //                                                 ->automaticallyCropImagesToAspectRatio()
    //                                                 ->imagePreviewHeight('300')
    //                                                 ->imageEditorViewportWidth(1000)
    //                                                 ->imageEditorViewportHeight(700)
    //                                                 ->disk('public')
    //                                                 ->directory('about')
    //                                                 ->visibility('public')
    //                                                 ->moveFiles()
    //                                                 ->preserveFilenames(),
    //                                         ]),
    //                                 ])
    //                                 ->columnSpanFull(),

    //                             Builder::make('vision_blocks')
    //                                 ->label('Blocs Vision')
    //                                 ->addActionLabel('Ajouter un bloc')
    //                                 ->blockNumbers(false)
    //                                 ->blockLabels(true)
    //                                 ->blockIcons(false)
    //                                 ->blocks([
    //                                     Block::make('content')
    //                                         ->label('Bloc contenu')
    //                                         ->schema([
    //                                             TextInput::make('title')->label('Titre')->maxLength(255),
    //                                             RichEditor::make('description')
    //                                                 ->label('Description')
    //                                                 ->columnSpanFull()
    //                                                 ->json()
    //                                                 ->customTextColors(true)
    //                                                 ->resizableImages(true)
    //                                                 ->uploadingFileMessage(__('Téléversement en cours...'))
    //                                                 ->preventFileAttachmentPathTampering(true),
    //                                             FileUpload::make('image_url')
    //                                                 ->label('Image')
    //                                                 ->image()
    //                                                 ->imageEditor()
    //                                                 ->editableSvgs()
    //                                                 ->confirmSvgEditing()
    //                                                 ->circleCropper()
    //                                                 ->automaticallyCropImagesToAspectRatio()
    //                                                 ->imagePreviewHeight('300')
    //                                                 ->imageEditorViewportWidth(1000)
    //                                                 ->imageEditorViewportHeight(700)
    //                                                 ->disk('public')
    //                                                 ->directory('about')
    //                                                 ->visibility('public')
    //                                                 ->moveFiles()
    //                                                 ->preserveFilenames(),
    //                                         ]),
    //                                 ])
    //                                 ->columnSpanFull(),

    //                             Builder::make('mission_blocks')
    //                                 ->label('Blocs Mission')
    //                                 ->addActionLabel('Ajouter un bloc')
    //                                 ->blockNumbers(false)
    //                                 ->blockLabels(true)
    //                                 ->blockIcons(false)
    //                                 ->blocks([
    //                                     Block::make('content')
    //                                         ->label('Bloc contenu')
    //                                         ->schema([
    //                                             TextInput::make('title')->label('Titre')->maxLength(255),
    //                                             RichEditor::make('description')
    //                                                 ->label('Description')
    //                                                 ->columnSpanFull()
    //                                                 ->json()
    //                                                 ->customTextColors(true)
    //                                                 ->resizableImages(true)
    //                                                 ->uploadingFileMessage(__('Téléversement en cours...'))
    //                                                 ->preventFileAttachmentPathTampering(true),
    //                                             FileUpload::make('image_url')
    //                                                 ->label('Image')
    //                                                 ->image()
    //                                                 ->imageEditor()
    //                                                 ->editableSvgs()
    //                                                 ->confirmSvgEditing()
    //                                                 ->circleCropper()
    //                                                 ->automaticallyCropImagesToAspectRatio()
    //                                                 ->imagePreviewHeight('300')
    //                                                 ->imageEditorViewportWidth(1000)
    //                                                 ->imageEditorViewportHeight(700)
    //                                                 ->disk('public')
    //                                                 ->directory('about')
    //                                                 ->visibility('public')
    //                                                 ->moveFiles()
    //                                                 ->preserveFilenames(),
    //                                         ]),
    //                                 ])
    //                                 ->columnSpanFull(),

    //                             Repeater::make('impact_content')
    //                                 ->label('Bloc impact')
    //                                 ->columns(1)
    //                                 ->collapsible()
    //                                 ->itemLabel(fn (?array $state): string => $state['impact_heading'] ?? 'Impact')
    //                                 ->schema([
    //                                     TextInput::make('impact_heading')
    //                                         ->label('Titre de la section impact')
    //                                         ->maxLength(255),
    //                                     TextInput::make('impact_subtitle')
    //                                         ->label('Sous-titre de l’impact')
    //                                         ->maxLength(255),
    //                                     RichEditor::make('impact_description')
    //                                         ->label('Description détaillée de l’impact')
    //                                         ->columnSpanFull()
    //                                         ->json()
    //                                         ->customTextColors(true)
    //                                         ->resizableImages(true)
    //                                         ->uploadingFileMessage(__('Téléversement en cours...'))
    //                                         ->preventFileAttachmentPathTampering(true),
    //                                     TextInput::make('impact_highlight_heading')
    //                                         ->label('Titre du bloc secondaire')
    //                                         ->maxLength(255),
    //                                     RichEditor::make('impact_highlight_text')
    //                                         ->label('Texte du bloc secondaire')
    //                                         ->columnSpanFull()
    //                                         ->json()
    //                                         ->customTextColors(true)
    //                                         ->resizableImages(true)
    //                                         ->uploadingFileMessage(__('Téléversement en cours...'))
    //                                         ->preventFileAttachmentPathTampering(true),
    //                                     TextInput::make('impact_highlight_cta_label')
    //                                         ->label('Libellé du bouton du bloc secondaire')
    //                                         ->maxLength(100),
    //                                     TextInput::make('impact_highlight_cta_url')
    //                                         ->label('URL du bouton du bloc secondaire')
    //                                         ->maxLength(255),
    //                                 ])
    //                                 ->defaultItems(1)
    //                                 ->minItems(1)
    //                                 ->maxItems(1)
    //                                 ->columnSpanFull(),

    //                             Builder::make('impact_stats')
    //                                 ->label('Cartes d’impact')
    //                                 ->addActionLabel('Ajouter une carte d’impact')
    //                                 ->addActionAlignment(Alignment::Start)
    //                                 ->blockNumbers(false)
    //                                 ->blockLabels(true)
    //                                 ->blockIcons(true)
    //                                 ->blockHeaders(true)
    //                                 ->blockPreviews(true)
    //                                 ->blockPickerColumns(['md' => 2, 'xl' => 3])
    //                                 ->blockPickerWidth('3xl')
    //                                 ->reorderableWithDragAndDrop()
    //                                 ->reorderableWithButtons()
    //                                 ->cloneable()
    //                                 ->collapsible()
    //                                 ->collapsed(false)
    //                                 ->deletable()
    //                                 ->blocks([
    //                                     Block::make('impact_card')
    //                                         ->label(function (?array $state): string {
    //                                             if ($state === null) {
    //                                                 return 'Carte d’impact';
    //                                             }

    //                                             return $state['label'] ?? $state['data']['label'] ?? $state['data']['value'] ?? 'Carte d’impact';
    //                                         })
    //                                         ->icon(Heroicon::Sparkles)
    //                                         ->preview('filament.forms.builder.impact-card-preview')
    //                                         ->schema([
    //                                             TextInput::make('value')
    //                                                 ->label('Valeur principale')
    //                                                 ->required(),
    //                                             TextInput::make('label')
    //                                                 ->label('Titre')
    //                                                 ->required(),
    //                                             TextInput::make('description')
    //                                                 ->label('Description courte')
    //                                                 ->maxLength(255),
    //                                             FileUpload::make('image_url')
    //                                                 ->label('Image d’impact')
    //                                                 ->image()
    //                                                 ->imageEditor()
    //                                                 ->editableSvgs()
    //                                                 ->confirmSvgEditing()
    //                                                 ->circleCropper()
    //                                                 ->automaticallyCropImagesToAspectRatio()
    //                                                 ->imagePreviewHeight('300')
    //                                                 ->imageEditorViewportWidth(1000)
    //                                                 ->imageEditorViewportHeight(700)
    //                                                 ->automaticallyOpenImageEditorForAspectRatio()
    //                                                 ->disk('public')
    //                                                 ->directory('about/impact')
    //                                                 ->visibility('public')
    //                                                 ->moveFiles()
    //                                                 ->preserveFilenames(),
    //                                             TextInput::make('icon')
    //                                                 ->label('Icône (chemin SVG)')
    //                                                 ->helperText('Laisser vide pour utiliser une icône par défaut.'),
    //                                         ]),
    //                                 ])
    //                                 ->columnSpanFull(),
    //                         ]),
    //                 ]),
    //         ]);
    // }
}
