<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Ajoute l'email secondaire (valeur par défaut null)
        $this->migrator->add('app.secondary_email', null);

        // Ajoute la liste des adresses (tableau vide par défaut)
        $this->migrator->add('app.addresses', []);
    }
};
