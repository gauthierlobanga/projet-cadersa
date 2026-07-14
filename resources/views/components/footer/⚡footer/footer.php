<?php

use App\Settings\SettingApp;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::main')] class extends Component
{
    public string $appName = 'CADERSA';

    public ?string $logoUrl = null;

    public array $socialLinks = [];

    // Nouvelles propriétés
    public ?string $phone = null;

    public ?string $email = null;

    public ?string $secondaryEmail = null;

    public array $addresses = [];

    public string $developerName = 'Gauthier Lobanga';

    public string $developerUrl = 'https://github.com/gauthierlobanga';

    // Developer contact email (displayed on hover)
    public string $developerEmail = 'gauthierlobanga914@gmail.com';

    public function boot(SettingApp $appSettings): void
    {
        $this->appName = $appSettings->name;
        $this->logoUrl = $appSettings->logoUrl();
        $this->socialLinks = $this->buildSocialLinks($appSettings);
        $this->phone = $appSettings->phone;
        $this->email = $appSettings->email;
        $this->secondaryEmail = $appSettings->secondary_email;
        $this->addresses = $appSettings->addresses ?? [];

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
            // GitHub may not expose email via API; use if available
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
