<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            ['title' => 'Brouillon : sécurité alimentaire communautaire', 'excerpt' => 'Fiche à compléter avec les informations vérifiées par l’équipe CADERSA.', 'content' => 'Brouillon de présentation. Renseignez les objectifs, les partenaires, la zone d’intervention et les résultats documentés avant toute publication.'],
            ['title' => 'Brouillon : agriculture durable', 'excerpt' => 'Fiche à compléter avec les informations vérifiées par l’équipe CADERSA.', 'content' => 'Brouillon de présentation. Ajoutez les activités menées, les communautés concernées et les résultats validés avant toute publication.'],
            ['title' => 'Brouillon : nutrition communautaire', 'excerpt' => 'Fiche à compléter avec les informations vérifiées par l’équipe CADERSA.', 'content' => 'Brouillon de présentation. Indiquez les objectifs, les localités concernées et les résultats validés avant toute publication.'],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                ['slug' => Str::slug($project['title'])],
                [...$project, 'status' => 'planned', 'is_active' => false]
            );
        }
    }
}
