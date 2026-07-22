<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        if (! $this->migrator->exists('about.footer_copyright')) {
            $this->migrator->add('about.footer_copyright', 'Tous droits réservés.');
        }
        if (! $this->migrator->exists('about.footer_text')) {
            $this->migrator->add('about.footer_text', '');
        }
    }
};
