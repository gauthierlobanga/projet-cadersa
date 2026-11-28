<?php

use App\Settings\AboutSettings;
use App\Settings\SettingApp;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::main')] class extends Component
{
    public string $appName = '';

    public ?string $logoUrl = null;

    public array $socialLinks = [];

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $secondaryEmail = null;

    public array $addresses = [];

    // Nouvelles propriétés pour le footer
    public string $footerCopyright = 'Tous droits réservés.';

    public string $footerText = '';

    public function boot(SettingApp $appSettings): void
    {
        $this->appName = $appSettings->name ?: '';
        $this->logoUrl = $appSettings->logoUrl();
        $this->socialLinks = $this->buildSocialLinks($appSettings);
        $this->phone = $appSettings->phone;
        $this->email = $appSettings->email;
        $this->secondaryEmail = $appSettings->secondary_email;
        $this->addresses = $appSettings->addresses ?? [];

        // Récupération des paramètres du footer depuis AboutSettings
        $aboutSettings = app(AboutSettings::class);
        $this->footerCopyright = $aboutSettings->footer_copyright ?: 'Tous droits réservés.';
        $this->footerText = $aboutSettings->footer_text ?: '';

    }

    protected function buildSocialLinks(SettingApp $settings): array
    {
        $links = [];
        if ($settings->facebook_url) {
            $links['facebook'] = $settings->facebook_url;
        }
        if ($settings->x_url) {
            $links['x'] = $settings->x_url;
        }
        if ($settings->linkedin_url) {
            $links['linkedin'] = $settings->linkedin_url;
        }
        if ($settings->instagram_url) {
            $links['instagram'] = $settings->instagram_url;
        }
        if ($settings->youtube_url) {
            $links['youtube'] = $settings->youtube_url;
        }

        return $links;
    }
};
