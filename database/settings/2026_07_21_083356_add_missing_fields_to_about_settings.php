<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about.formation_banner_title', '');
        $this->migrator->add('about.formation_banner_subtitle', '');
    }
};
