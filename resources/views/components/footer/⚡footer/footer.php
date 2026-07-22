<?php

use App\Settings\AboutSettings;
use App\Settings\SettingApp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::main')] class extends Component
{
    public string $appName = 'Gauthier Lobanga';

    public ?string $logoUrl = null;

    public array $socialLinks = [];

    public ?string $phone = null;

    public ?string $email = null;

    public ?string $secondaryEmail = null;

    public array $addresses = [];

    public string $developerName = 'Gauthier Lobanga';

    public string $developerUrl = 'https://github.com/gauthierlobanga';

    public string $developerEmail = 'gauthierlobanga914@gmail.com';

    // Nouvelles propriétés pour le footer
    public string $footerCopyright = 'Tous droits réservés.';

    public string $footerText = '';

    public function boot(SettingApp $appSettings): void
    {
        $this->appName = $appSettings->name ?: 'Gauthier Lobanga';
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

        $this->loadDeveloperInfo();
    }

    protected function loadDeveloperInfo(): void
    {
        $githubData = Cache::remember('github_developer_info', 86400, function () {
            try {
                $response = Http::timeout(3)->get('https://api.github.com/users/gauthierlobanga');
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (Exception $e) {
                // Ignore errors
            }

            return null;
        });

        if ($githubData) {
            $this->developerName = $githubData['name'] ?? $githubData['login'] ?? 'Gauthier Lobanga';
            $this->developerUrl = $githubData['html_url'] ?? 'https://github.com/gauthierlobanga';
            if (! empty($githubData['email'])) {
                $this->developerEmail = $githubData['email'];
            }
        }
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
