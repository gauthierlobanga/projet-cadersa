<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about.impact_stats', []);
        $this->migrator->add('about.impact_heading', '');
        $this->migrator->add('about.impact_subtitle', '');
        $this->migrator->add('about.impact_description', null);
        $this->migrator->add('about.impact_highlight_heading', '');
        $this->migrator->add('about.impact_highlight_text', null);
        $this->migrator->add('about.impact_highlight_cta_label', '');
        $this->migrator->add('about.impact_highlight_cta_url', 'contact');
    }
};
