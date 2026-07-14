<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('about.impact_stats', []);
        $this->migrator->add('about.impact_content', []);
        $this->migrator->add('about.impact_heading', 'Des résultats concrets sur le terrain');
        $this->migrator->add('about.impact_subtitle', 'Programme de Résilience au Kasaï Central, avec le soutien du PAM.');
        $this->migrator->add('about.impact_description', null);
        $this->migrator->add('about.impact_highlight_heading', 'Renforcement de la chaîne de valeur agricole');
        $this->migrator->add('about.impact_highlight_text', null);
        $this->migrator->add('about.impact_highlight_cta_label', 'Lire le rapport complet');
        $this->migrator->add('about.impact_highlight_cta_url', '#');
    }
};
