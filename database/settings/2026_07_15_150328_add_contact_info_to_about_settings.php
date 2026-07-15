<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about.contact_email', null);
        $this->migrator->add('about.contact_phone', null);
        $this->migrator->add('about.address', null);
    }
};
