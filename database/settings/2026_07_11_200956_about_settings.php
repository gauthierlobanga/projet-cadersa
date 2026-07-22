<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Section Hero
        $this->migrator->add('about.hero_title', '');
        $this->migrator->add('about.hero_subtitle', '');
        $this->migrator->add('about.hero_badge', '');

        // Images (URL stockée après upload)
        $this->migrator->add('about.hero_image_url', null);
        $this->migrator->add('about.about_image_url', null);

        // Textes longs
        $this->migrator->add('about.about_text', '');
        $this->migrator->add('about.vision_text', '');
        $this->migrator->add('about.mission_text', '');

    }
};
