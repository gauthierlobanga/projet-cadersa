<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Section Hero
        $this->migrator->add('about.hero_title', 'Bâtir des villages durables en RDC.');
        $this->migrator->add('about.hero_subtitle', 'Paix, Sympathie et Mieux-être.');
        $this->migrator->add('about.hero_badge', 'Depuis 2010');

        // Images (URL stockée après upload)
        $this->migrator->add('about.hero_image_url', null);
        $this->migrator->add('about.about_image_url', null);

        // Textes longs
        $this->migrator->add('about.about_text', '');
        $this->migrator->add('about.vision_text', '');
        $this->migrator->add('about.mission_text', '');
    }
};
