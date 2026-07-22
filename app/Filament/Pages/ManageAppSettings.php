<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroup;
use App\Settings\SettingApp;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Storage;
use UnitEnum;

class ManageAppSettings extends SettingsPage
{
    protected static string $settings = SettingApp::class;

    protected static string|UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?string $navigationLabel = 'Paramètres';

    protected static ?string $title = 'Paramètres de l’application';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['logo_url'] = SettingApp::normalizeLogoPath($data['logo_url'] ?? null);

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $settings = app(SettingApp::class);
        $oldLogo = SettingApp::normalizeLogoPath($settings->logo_url);
        $newLogo = SettingApp::normalizeLogoPath($data['logo_url'] ?? null);
        if ($oldLogo && $oldLogo !== $newLogo) {
            Storage::disk('public')->delete($oldLogo);
        }
        $data['logo_url'] = $newLogo;

        return $data;
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Colonne de gauche
                Section::make('Identité de l’entreprise')
                    ->icon('heroicon-o-building-office')
                    ->columnSpanFull()
                    ->description('Nom, logo et coordonnées principales.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nom de l’application')
                            ->required()
                            ->maxLength(255),
                        FileUpload::make('logo_url')
                            ->label('Logo')
                            ->image()
                            ->disk('public')
                            ->directory('settings')
                            ->visibility('public')
                            ->maxSize(2048),

                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('address')
                                    ->label('Adresse principale')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('phone')
                                    ->label('Téléphone')
                                    ->tel()
                                    ->maxLength(30),
                                TextInput::make('email')
                                    ->label('Email principal')
                                    ->email()
                                    ->maxLength(255),
                                TextInput::make('secondary_email')
                                    ->label('Email secondaire')
                                    ->email()
                                    ->maxLength(255),
                            ]),
                    ]),

                // Colonne de droite
                Section::make('Réseaux sociaux')
                    ->columnSpanFull()
                    ->icon('heroicon-o-share')
                    ->schema([
                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('facebook_url')->url()->label('Facebook')
                                    ->url()
                                    ->suffixIcon(Heroicon::GlobeAlt),
                                TextInput::make('instagram_url')->url()->label('Instagram')
                                    ->url()
                                    ->suffixIcon(Heroicon::GlobeAlt),
                            ]),
                        Group::make()
                            ->columns(3)
                            ->schema([
                                TextInput::make('x_url')->url()->label('X (Twitter)')
                                    ->url()
                                    ->suffixIcon(Heroicon::GlobeAlt),
                                TextInput::make('linkedin_url')->url()->label('LinkedIn')
                                    ->url()
                                    ->suffixIcon(Heroicon::GlobeAlt),
                                TextInput::make('youtube_url')->url()->label('YouTube')
                                    ->url()
                                    ->suffixIcon(Heroicon::GlobeAlt),
                            ]),
                    ]),

                // Pleine largeur
                Section::make('Bureaux / Adresses supplémentaires')
                    ->icon('heroicon-o-map-pin')
                    ->description('Ajoutez les différents bureaux de l’organisation.')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('addresses')
                            ->label('Liste des bureaux')
                            ->addActionLabel('Ajouter un bureau')
                            ->schema([
                                Group::make()
                                    ->columns(2)
                                    ->schema([
                                        TextInput::make('label')
                                            ->label('Nom du bureau')
                                            ->required()
                                            ->placeholder('Ex: Siège National - Bukavu'),
                                        TextInput::make('address')
                                            ->label('Adresse complète')
                                            ->required()
                                            ->placeholder('Av. Mbaki N° 041, Q. Ndedere, Commune d’Ibanda, Sud-Kivu'),

                                    ]),
                            ])
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->defaultItems(0),
                    ]),

                Section::make('Contenu du formulaire de contact')
                    ->icon('heroicon-o-chat-bubble-bottom-center-text')
                    ->description('Texte dynamique utilisé sur la page de contact.')
                    ->columnSpanFull()
                    ->schema([
                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('contact_hero_badge')
                                    ->label('Badge du hero contact')
                                    ->maxLength(100),
                                TextInput::make('contact_hero_title')
                                    ->label('Titre du hero contact')
                                    ->maxLength(255),
                            ]),
                        TextInput::make('contact_hero_subtitle')
                            ->label('Sous-titre du hero contact')
                            ->maxLength(255),
                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('contact_form_heading')
                                    ->label('Titre du formulaire')
                                    ->maxLength(255),
                                TextInput::make('contact_form_description')
                                    ->label('Description du formulaire')
                                    ->maxLength(255),
                            ]),
                        Group::make()
                            ->columns(2)
                            ->schema([
                                TextInput::make('contact_support_title')
                                    ->label('Titre du bloc support')
                                    ->maxLength(255),
                                TextInput::make('contact_support_description')
                                    ->label('Description du bloc support')
                                    ->maxLength(255),
                            ]),
                        TextInput::make('contact_offices_title')
                            ->label('Titre de la section bureaux')
                            ->maxLength(255),
                    ]),
            ]);
    }
}
