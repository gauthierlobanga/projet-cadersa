<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\ErrorPagesSettings;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use UnitEnum;

class ManageErrorPagesSettings extends SettingsPage
{
    protected static string $settings = ErrorPagesSettings::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Pages d\'erreur';

    protected static ?string $title = 'Gestion des pages d\'erreur';

    protected static ?int $navigationSort = 20;

    /**
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var array<string, array<string, mixed>> $pages */
        $pages = $data['pages'] ?? [];

        foreach ($pages as $code => $page) {
            $data["page_{$code}_title"] = $page['title'] ?? '';
            $data["page_{$code}_message"] = $page['message'] ?? '';
            $data["page_{$code}_description"] = $page['description'] ?? '';
            $data["page_{$code}_next_steps"] = implode("\n", $page['next_steps'] ?? []);
            $data["page_{$code}_svg_code"] = $page['svg_code'] ?? '';
        }

        unset($data['pages']);

        return $data;
    }

    /**
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $codes = ['401', '402', '403', '404', '419', '429', '500', '503'];

        /** @var array<string, array<string, mixed>> $pages */
        $pages = app(ErrorPagesSettings::class)->pages;

        foreach ($codes as $code) {
            $pages[$code] = [
                'title' => $data["page_{$code}_title"] ?? ($pages[$code]['title'] ?? ''),
                'message' => $data["page_{$code}_message"] ?? ($pages[$code]['message'] ?? ''),
                'description' => $data["page_{$code}_description"] ?? ($pages[$code]['description'] ?? ''),
                'next_steps' => array_filter(
                    explode("\n", $data["page_{$code}_next_steps"] ?? ''),
                    fn (string $line): bool => trim($line) !== ''
                ),
                'svg_code' => $data["page_{$code}_svg_code"] ?? ($pages[$code]['svg_code'] ?? ''),
            ];

            unset(
                $data["page_{$code}_title"],
                $data["page_{$code}_message"],
                $data["page_{$code}_description"],
                $data["page_{$code}_next_steps"],
                $data["page_{$code}_svg_code"]
            );
        }

        $data['pages'] = $pages;

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        $codes = [
            '401' => ['label' => '401 — Non autorisé', 'icon' => 'heroicon-o-lock-closed', 'color' => 'warning'],
            '402' => ['label' => '402 — Paiement requis', 'icon' => 'heroicon-o-credit-card', 'color' => 'info'],
            '403' => ['label' => '403 — Accès refusé', 'icon' => 'heroicon-o-shield-exclamation', 'color' => 'warning'],
            '404' => ['label' => '404 — Non trouvé', 'icon' => 'heroicon-o-magnifying-glass', 'color' => 'gray'],
            '419' => ['label' => '419 — Session expirée', 'icon' => 'heroicon-o-clock', 'color' => 'warning'],
            '429' => ['label' => '429 — Trop de requêtes', 'icon' => 'heroicon-o-bolt', 'color' => 'warning'],
            '500' => ['label' => '500 — Erreur serveur', 'icon' => 'heroicon-o-server', 'color' => 'danger'],
            '503' => ['label' => '503 — Service indisponible', 'icon' => 'heroicon-o-wrench-screwdriver', 'color' => 'danger'],
        ];

        $sections = [];

        foreach ($codes as $code => $meta) {
            $sections[] = Section::make($meta['label'])
                ->icon($meta['icon'])
                ->collapsed()
                ->columnSpanFull()
                ->description("Personnalisez le contenu affiché sur la page d'erreur {$code}.")
                ->schema([
                    TextInput::make("page_{$code}_title")
                        ->label('Titre court (label badge)')
                        ->maxLength(80)
                        ->placeholder('Ex: Accès refusé'),

                    TextInput::make("page_{$code}_message")
                        ->label('Message principal (titre h2)')
                        ->maxLength(160)
                        ->placeholder("Ex: Vous n'êtes pas autorisé à accéder à cette page."),

                    Textarea::make("page_{$code}_description")
                        ->label('Description (sous-titre)')
                        ->rows(2)
                        ->maxLength(400)
                        ->placeholder('Une phrase explicative affichée sous le message principal.'),

                    Textarea::make("page_{$code}_next_steps")
                        ->label('Pistes de solution (une par ligne)')
                        ->rows(4)
                        ->helperText('Chaque ligne deviendra un point dans la liste "Pistes de solution".')
                        ->placeholder("Revenez à une zone autorisée.\nDemandez une autorisation si votre rôle a changé."),

                    Textarea::make("page_{$code}_svg_code")
                        ->label('Code SVG de l\'illustration')
                        ->rows(6)
                        ->helperText('Collez le code SVG brut (<svg>...</svg>). Laissez vide pour utiliser l\'icône par défaut.')
                        ->placeholder('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500">...</svg>'),
                ]);
        }

        return $schema->components($sections);
    }
}
