<?php

namespace Database\Seeders;

use App\Models\FormationCategory;
use Illuminate\Database\Seeder;

class FormationCategorySeeder extends Seeder
{
    public function run(): void
    {
        FormationCategory::factory()->createMany([
            ['name' => 'Développement Web',       'slug' => 'developpement-web',       'color' => '#10b981', 'sort_order' => 10],
            ['name' => 'Frameworks & Librairies', 'slug' => 'frameworks-librairies',   'color' => '#059669', 'sort_order' => 20],
            ['name' => 'Bases de données',         'slug' => 'bases-de-donnees',        'color' => '#0ea5e9', 'sort_order' => 30],
            ['name' => 'API & Intégrations',       'slug' => 'api-integrations',        'color' => '#6366f1', 'sort_order' => 40],
            ['name' => 'DevOps & Outils',          'slug' => 'devops-outils',           'color' => '#f59e0b', 'sort_order' => 50],
            ['name' => 'Analyse de données',       'slug' => 'analyse-de-donnees',      'color' => '#7c3aed', 'sort_order' => 60],
            ['name' => 'Bureautique',              'slug' => 'bureautique',             'color' => '#ef4444', 'sort_order' => 70],
            ['name' => 'Modélisation & Conception', 'slug' => 'modelisation-conception', 'color' => '#3b82f6', 'sort_order' => 80],
            ['name' => 'Web sémantique',           'slug' => 'web-semantique',          'color' => '#0e7490', 'sort_order' => 90],
            ['name' => 'CMS & E‑commerce',         'slug' => 'cms-ecommerce',           'color' => '#d97706', 'sort_order' => 100],
            ['name' => 'Sécurité & Tests',         'slug' => 'securite-tests',          'color' => '#dc2626', 'sort_order' => 110],
            ['name' => 'Cloud & Hébergement',      'slug' => 'cloud-hebergement',       'color' => '#0891b2', 'sort_order' => 120],
            ['name' => 'Soft Skills & Carrière',   'slug' => 'soft-skills-carriere',    'color' => '#8b5cf6', 'sort_order' => 130],
        ]);
    }
}
