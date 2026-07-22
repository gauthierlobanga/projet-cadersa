<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\AboutSettings;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\TextColor;
use Filament\Forms\Components\RichEditor\ToolbarButtonGroup;
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

        $data['about_blocks'] = collect(AboutSettings::normalizeBlocks($data['about_blocks'] ?? []))
            ->map(fn ($item) => ['type' => 'content', 'data' => $item])
            ->toArray();

        $data['vision_blocks'] = collect(AboutSettings::normalizeBlocks($data['vision_blocks'] ?? []))
            ->map(fn ($item) => ['type' => 'content', 'data' => $item])
            ->toArray();

        $data['mission_blocks'] = collect(AboutSettings::normalizeBlocks($data['mission_blocks'] ?? []))
            ->map(fn ($item) => ['type' => 'content', 'data' => $item])
            ->toArray();

        // Map legacy single fields into the new Builder-backed blocks for compatibility.
        if (empty($data['about_blocks']) && isset($data['about_text'])) {
            $data['about_blocks'] = [[
                'type' => 'content',
                'data' => [
                    'title' => $data['about_title'] ?? null,
                    'description' => $data['about_text'],
                    'image_url' => $data['about_image_url'] ?? null,
                ],
            ]];
        }

        if (empty($data['vision_blocks']) && isset($data['vision_text'])) {
            $data['vision_blocks'] = [[
                'type' => 'content',
                'data' => [
                    'title' => $data['vision_title'] ?? null,
                    'description' => $data['vision_text'],
                    'image_url' => $data['about_image_url'] ?? null,
                ],
            ]];
        }

        if (empty($data['mission_blocks']) && isset($data['mission_text'])) {
            $data['mission_blocks'] = [[
                'type' => 'content',
                'data' => [
                    'title' => $data['mission_title'] ?? null,
                    'description' => $data['mission_text'],
                    'image_url' => $data['about_image_url'] ?? null,
                ],
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
            'contact_email' => $settings->contact_email ?? null,
            'contact_phone' => $settings->contact_phone ?? null,
            'address' => $settings->address ?? null,
        ];

        // Fusionner les valeurs manquantes (ne pas écraser les valeurs soumises)
        foreach ($defaults as $key => $value) {
            if (! array_key_exists($key, $data) || $data[$key] === null) {
                $data[$key] = $value;
            }
        }

        // Ensure all declared settings properties are present in the payload before saving.
        // This avoids Spatie\LaravelSettings MissingSettings exceptions when saving a subset.
        try {
            $reflectedKeys = $settings->settingsConfig()->getReflectedProperties()->keys()->toArray();
            foreach ($reflectedKeys as $prop) {
                if (! array_key_exists($prop, $data)) {
                    // Prefer submitted value, otherwise use current settings value or null
                    $data[$prop] = $settings->{$prop} ?? null;
                }
            }
        } catch (\Throwable $e) {
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
                        // ══════════════════════════════════════════
                        // SECTION HERO (page d'accueil / À propos)
                        // ══════════════════════════════════════════
                        Section::make('Hero — Page d\'accueil')
                            ->icon('heroicon-o-home')
                            ->collapsible()
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('hero_badge')
                                            ->label('Badge hero')
                                            ->maxLength(100),
                                        TextInput::make('author_home')
                                            ->label('Titre / Nom affiché (accueil)')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('hero_title')
                                            ->label('Titre principal')
                                            ->maxLength(255),
                                        TextInput::make('hero_subtitle')
                                            ->label('Sous‑titre')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        FileUpload::make('hero_image_url')
                                            ->label('Image hero')
                                            ->image()
                                            ->imageEditor()
                                            ->disk('public')
                                            ->directory('about')
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->preserveFilenames(),
                                        FileUpload::make('about_image_url')
                                            ->label('Image secondaire (À propos)')
                                            ->image()
                                            ->imageEditor()
                                            ->disk('public')
                                            ->directory('about')
                                            ->visibility('public')
                                            ->moveFiles()
                                            ->preserveFilenames(),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION À PROPOS (blocs de contenu)
                        // ══════════════════════════════════════════
                        Section::make('À Propos — Contenu')
                            ->icon('heroicon-o-document-text')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('auteur_about')
                                    ->label('Auteur page À propos')
                                    ->maxLength(255),

                                Builder::make('about_blocks')
                                    ->label('Blocs À propos')
                                    ->addActionLabel('Ajouter un bloc')
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(false)
                                    ->blocks([$this->contentBlock('about')])
                                    ->columnSpanFull(),

                                Builder::make('vision_blocks')
                                    ->label('Blocs Vision')
                                    ->addActionLabel('Ajouter un bloc')
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(false)
                                    ->blocks([$this->contentBlock('vision')])
                                    ->columnSpanFull(),

                                Builder::make('mission_blocks')
                                    ->label('Blocs Mission')
                                    ->addActionLabel('Ajouter un bloc')
                                    ->blockNumbers(false)
                                    ->blockLabels(true)
                                    ->blockIcons(false)
                                    ->blocks([$this->contentBlock('mission')])
                                    ->columnSpanFull(),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION SERVICES
                        // ══════════════════════════════════════════
                        Section::make('Services')
                            ->icon('heroicon-o-wrench-screwdriver')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('service_title')
                                            ->label('Titre section Services')
                                            ->maxLength(255),
                                        TextInput::make('service_subtitle')
                                            ->label('Sous-titre section Services')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION COMPÉTENCES
                        // ══════════════════════════════════════════
                        Section::make('Compétences')
                            ->icon('heroicon-o-light-bulb')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('skill_badge')
                                            ->label('Badge section Compétences')
                                            ->maxLength(100),
                                        TextInput::make('skill_title')
                                            ->label('Titre section Compétences')
                                            ->maxLength(255),
                                        TextInput::make('skill_subtitle')
                                            ->label('Sous-titre section Compétences')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION PROJETS
                        // ══════════════════════════════════════════
                        Section::make('Projets')
                            ->icon('heroicon-o-rectangle-stack')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('project_hero_badge')
                                            ->label('Badge')
                                            ->maxLength(100),
                                        TextInput::make('project_hero_title')
                                            ->label('Titre hero')
                                            ->maxLength(255),
                                        TextInput::make('project_hero_subtitle')
                                            ->label('Sous-titre hero')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('project_content_title')
                                            ->label('Titre du contenu')
                                            ->maxLength(255),
                                        TextInput::make('project_content_subtitle')
                                            ->label('Sous-titre du contenu')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('project_banner_title')
                                            ->label('Titre bannière')
                                            ->maxLength(255),
                                        TextInput::make('project_banner_subtitle')
                                            ->label('Sous-titre bannière')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION BLOG / POSTS
                        // ══════════════════════════════════════════
                        Section::make('Blog / Posts')
                            ->icon('heroicon-o-newspaper')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('blog_hero_badge')
                                            ->label('Badge')
                                            ->maxLength(100),
                                        TextInput::make('blog_hero_title')
                                            ->label('Titre hero')
                                            ->maxLength(255),
                                        TextInput::make('blog_hero_subtitle')
                                            ->label('Sous-titre hero')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('blog_content_title')
                                            ->label('Titre du contenu')
                                            ->maxLength(255),
                                        TextInput::make('blog_content_subtitle')
                                            ->label('Sous-titre du contenu')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('blog_banner_title')
                                            ->label('Titre bannière')
                                            ->maxLength(255),
                                        TextInput::make('blog_banner_subtitle')
                                            ->label('Sous-titre bannière')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION FORMATIONS
                        // ══════════════════════════════════════════
                        Section::make('Formations')
                            ->icon('heroicon-o-academic-cap')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('formation_title')
                                            ->label('Titre section Formations')
                                            ->maxLength(255),
                                        TextInput::make('formation_subtitle')
                                            ->label('Sous-titre section Formations')
                                            ->maxLength(255),
                                    ]),
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('formation_banner_title')
                                            ->label('Titre bannière')
                                            ->maxLength(255),
                                        TextInput::make('formation_banner_subtitle')
                                            ->label('Sous-titre bannière')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION ÉQUIPE / TÉMOIGNAGES
                        // ══════════════════════════════════════════
                        Section::make('Équipe / Témoignages')
                            ->icon('heroicon-o-users')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('team_title')
                                            ->label('Titre section Équipe')
                                            ->maxLength(255),
                                        TextInput::make('team_subtitle')
                                            ->label('Sous-titre section Équipe')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION PARTENAIRES
                        // ══════════════════════════════════════════
                        Section::make('Partenaires')
                            ->icon('heroicon-o-building-office')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('partner_title')
                                            ->label('Titre section Partenaires')
                                            ->maxLength(255),
                                        TextInput::make('partner_subtitle')
                                            ->label('Sous-titre section Partenaires')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // SECTION IMPACT
                        // ══════════════════════════════════════════
                        Section::make('Impact')
                            ->icon('heroicon-o-chart-bar')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Repeater::make('impact_content')
                                    ->label('Bloc impact principal')
                                    ->columns(1)
                                    ->collapsible()
                                    ->itemLabel(fn (?array $state): string => $state['impact_heading'] ?? 'Impact')
                                    ->schema([
                                        TextInput::make('impact_heading')
                                            ->label('Titre de la section impact')
                                            ->maxLength(255),
                                        TextInput::make('impact_subtitle')
                                            ->label('Sous-titre')
                                            ->maxLength(255),
                                        RichEditor::make('impact_description')
                                            ->label('Description détaillée')
                                            ->columnSpanFull()
                                            ->json()
                                            ->customTextColors(true)
                                            ->resizableImages(true)
                                            ->uploadingFileMessage(__('Téléversement en cours...'))
                                            ->preventFileAttachmentPathTampering(true)
                                            ->textColors($this->richEditorTextColors())
                                            ->customTextColors(),
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
                                            ->preventFileAttachmentPathTampering(true)
                                            ->toolbarButtons($this->richEditorToolbarButtons())
                                            ->floatingToolbars($this->richEditorFloatingToolbars())
                                            ->textColors($this->richEditorTextColors())
                                            ->customTextColors(),
                                        TextInput::make('impact_highlight_cta_label')
                                            ->label('Libellé du bouton')
                                            ->maxLength(100),
                                        TextInput::make('impact_highlight_cta_url')
                                            ->label('URL du bouton')
                                            ->maxLength(255),
                                    ])
                                    ->defaultItems(1)
                                    ->minItems(1)
                                    ->maxItems(1)
                                    ->columnSpanFull(),

                                Builder::make('impact_stats')
                                    ->label('Cartes d\'impact')
                                    ->addActionLabel('Ajouter une carte d\'impact')
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
                                                    return 'Carte d\'impact';
                                                }

                                                return $state['label'] ?? $state['data']['label'] ?? $state['data']['value'] ?? 'Carte d\'impact';
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
                                                    ->label('Image d\'impact')
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

                        // ══════════════════════════════════════════
                        // COORDONNÉES
                        // ══════════════════════════════════════════
                        Section::make('Coordonnées')
                            ->icon('heroicon-o-phone')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Group::make()
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('contact_email')
                                            ->label('Email de contact')
                                            ->email()
                                            ->maxLength(255),
                                        TextInput::make('contact_phone')
                                            ->label('Téléphone')
                                            ->maxLength(50),
                                        TextInput::make('address')
                                            ->label('Adresse')
                                            ->maxLength(255),
                                    ]),
                            ]),

                        // ══════════════════════════════════════════
                        // PIED DE PAGE (Footer)
                        // ══════════════════════════════════════════
                        Section::make('Pied de page (Footer)')
                            ->icon('heroicon-o-document-text')
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                TextInput::make('citation_footer')
                                    ->label('Citation du footer')
                                    ->maxLength(255),
                                TextInput::make('footer_copyright')
                                    ->label('Texte copyright')
                                    ->maxLength(255)
                                    ->helperText('Ex. : "Tous droits réservés."'),
                                TextInput::make('footer_text')
                                    ->label('Texte personnalisé du footer')
                                    ->maxLength(500)
                                    ->helperText('Vous pouvez utiliser du HTML simple.'),
                            ]),
                    ]),
            ]);
    }

    /**
     * Retourne un Builder Block "content" réutilisable pour about/vision/mission.
     */
    private function contentBlock(string $dir): Block
    {
        return Block::make('content')
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
                    ->preventFileAttachmentPathTampering(true)
                    ->textColors($this->richEditorTextColors())
                    ->toolbarButtons($this->richEditorToolbarButtons())
                    ->floatingToolbars($this->richEditorFloatingToolbars())
                    ->customTextColors(),
                FileUpload::make('image_url')
                    ->label('Image')
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('about/'.$dir)
                    ->visibility('public')
                    ->moveFiles()
                    ->preserveFilenames(),
            ]);
    }

    private function richEditorTextColors(): array
    {
        return [
            // Nuances de gris modernes (ardoise, gris, zinc)
            'slate' => TextColor::make('Ardoise', '#475569', darkColor: '#94a3b8'),
            'gray' => TextColor::make('Gris', '#6b7280', darkColor: '#9ca3af'),
            'zinc' => TextColor::make('Zinc', '#71717a', darkColor: '#a1a1aa'),
            'neutral' => TextColor::make('Neutre', '#737373', darkColor: '#a3a3a3'),
            'stone' => TextColor::make('Stone', '#78716c', darkColor: '#a8a29e'),

            // Couleurs vives
            'red' => TextColor::make('Rouge', '#ef4444', darkColor: '#f87171'),
            'orange' => TextColor::make('Orange', '#f97316', darkColor: '#fb923c'),
            'amber' => TextColor::make('Ambre', '#f59e0b', darkColor: '#fbbf24'),
            'yellow' => TextColor::make('Jaune', '#eab308', darkColor: '#facc15'),
            'lime' => TextColor::make('Citron vert', '#84cc16', darkColor: '#a3e635'),
            'green' => TextColor::make('Vert', '#22c55e', darkColor: '#4ade80'),
            'emerald' => TextColor::make('Émeraude', '#059669', darkColor: '#34d399'),
            'teal' => TextColor::make('Sarcelle', '#0d9488', darkColor: '#2dd4bf'),
            'cyan' => TextColor::make('Cyan', '#06b6d4', darkColor: '#22d3ee'),
            'sky' => TextColor::make('Bleu ciel', '#0ea5e9', darkColor: '#38bdf8'),
            'blue' => TextColor::make('Bleu', '#2563eb', darkColor: '#60a5fa'),
            'indigo' => TextColor::make('Indigo', '#4f46e5', darkColor: '#818cf8'),
            'violet' => TextColor::make('Violet', '#7c3aed', darkColor: '#a78bfa'),
            'purple' => TextColor::make('Pourpre', '#a855f7', darkColor: '#c084fc'),
            'fuchsia' => TextColor::make('Fuchsia', '#d946ef', darkColor: '#e879f9'),
            'pink' => TextColor::make('Rose', '#ec4899', darkColor: '#f472b6'),
            'rose' => TextColor::make('Rose foncé', '#e11d48', darkColor: '#fb7185'),
            ...TextColor::getDefaults(),
        ];
    }

    private function richEditorToolbarButtons(): array
    {
        return [
            ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
            [ToolbarButtonGroup::make('Heading', ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'])->icon('fi-o-heading')],
            [ToolbarButtonGroup::make('Alignment', ['alignStart', 'alignCenter', 'alignEnd', 'alignJustify'])],
            [ToolbarButtonGroup::make('Paragraph', ['paragraph', 'lead', 'small', 'code', 'highlight', 'horizontalRule', 'details'])],
            ['textColor', 'blockquote', 'codeBlock', 'bulletList', 'orderedList'],
            [ToolbarButtonGroup::make('Table', ['table', 'tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn', 'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow', 'tableMergeCells', 'tableSplitCell', 'tableToggleHeaderRow', 'tableToggleHeaderCell', 'tableDelete'])],
            ['grid', 'gridDelete', 'attachFiles'],
            ['undo', 'redo', 'clearFormatting'],
        ];
    }

    private function richEditorFloatingToolbars(): array
    {
        return [
            'paragraph' => ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link', 'textColor'],
            'heading' => ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
            'table' => ['tableAddColumnBefore', 'tableAddColumnAfter', 'tableDeleteColumn', 'tableAddRowBefore', 'tableAddRowAfter', 'tableDeleteRow', 'tableMergeCells', 'tableSplitCell', 'tableToggleHeaderRow', 'tableToggleHeaderCell', 'tableDelete'],
        ];
    }
}
