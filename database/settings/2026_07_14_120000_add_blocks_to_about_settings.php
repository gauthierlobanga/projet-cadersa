<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about.about_blocks', []);
        $this->migrator->add('about.vision_blocks', []);
        $this->migrator->add('about.mission_blocks', []);
    }
};
