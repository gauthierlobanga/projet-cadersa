<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Création des tags techniques
        $tags = [
            'Laravel',
            'Livewire',
            'Alpine.js',
            'Tailwind CSS',
            'Filament',
            'React',
            'Inertia.js',
            'MySQL',
            'PostgreSQL',
            'Docker',
            'Git',
            'API REST',
            'Full‑Stack',
            'TALL Stack',
            'Freelance',
        ];

        foreach ($tags as $name) {
            $slug = Str::slug($name);
            $nameJson = json_encode(['fr' => $name]);
            $slugJson = json_encode(['fr' => $slug]);

            Tag::firstOrCreate(
                ['slug' => $slugJson],
                [
                    'name' => $nameJson,
                    'type' => 'project',
                    'is_active' => true,
                    'order_column' => 0,
                ]
            );
        }

        // Projet 1 – Portfolio TALL
        $slug1 = Str::slug('Portfolio personnel TALL stack');
        $project1 = Project::updateOrCreate(
            ['slug' => $slug1],
            [
                'title' => 'Portfolio personnel TALL stack',
                'excerpt' => 'Création d’un portfolio moderne avec Laravel, Livewire, Alpine.js, Tailwind CSS et Filament.',
                'content' => 'Conception et développement de mon portfolio personnel en utilisant le stack TALL. Le site présente mes compétences, projets et formations. Il intègre un blog, une galerie de projets et un back-office administrable via Filament.',
                'location' => 'En ligne',
                'status' => 'completed',
                'start_date' => '2025-01-10',
                'end_date' => '2025-02-20',
                'is_active' => true,
            ]
        );
        $project1->attachTags(['Laravel', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'Filament', 'Full‑Stack', 'TALL Stack']);

        // Projet 2 – Dashboard Filament pour une PME
        $slug2 = Str::slug('Dashboard de gestion pour une PME');
        $project2 = Project::updateOrCreate(
            ['slug' => $slug2],
            [
                'title' => 'Dashboard de gestion pour une PME',
                'excerpt' => 'Application sur mesure avec Filament pour la gestion des stocks, ventes et ressources humaines.',
                'content' => 'Développement d’un panneau d’administration complet à l’aide de FilamentPHP. Le système permet de gérer les stocks, les ventes, les clients et les employés. Des tableaux de bord dynamiques avec graphiques sont générés automatiquement.',
                'location' => 'Kinshasa, RDC',
                'status' => 'ongoing',
                'start_date' => '2025-06-01',
                'end_date' => null,
                'is_active' => true,
            ]
        );
        $project2->attachTags(['Filament', 'MySQL', 'Full‑Stack', 'Laravel']);

        // Projet 3 – API REST avec Laravel & Sanctum
        $slug3 = Str::slug('API REST sécurisée avec Laravel Sanctum');
        $project3 = Project::updateOrCreate(
            ['slug' => $slug3],
            [
                'title' => 'API REST sécurisée avec Laravel Sanctum',
                'excerpt' => 'Mise en place d’une API RESTful pour une application mobile, avec authentification par token.',
                'content' => 'Création d’une API REST complète destinée à une application mobile. Utilisation de Laravel Sanctum pour l’authentification et gestion des rôles. Documentation interactive générée avec Swagger/OpenAPI.',
                'location' => 'Remote',
                'status' => 'completed',
                'start_date' => '2024-11-01',
                'end_date' => '2024-12-15',
                'is_active' => true,
            ]
        );
        $project3->attachTags(['API REST', 'Laravel', 'MySQL', 'Git']);

        // Projet 4 – Migration d’une app React vers Inertia.js
        $slug4 = Str::slug('Migration React vers Inertia.js dans Laravel');
        $project4 = Project::updateOrCreate(
            ['slug' => $slug4],
            [
                'title' => 'Migration d’une app React vers Inertia.js',
                'excerpt' => 'Refonte d’une application monopage React en utilisant Inertia.js avec Laravel.',
                'content' => 'Projet de migration progressive d’une SPA React existante vers une architecture Inertia.js couplée à Laravel. Amélioration des performances, SEO et simplification de la base de code.',
                'location' => 'Remote',
                'status' => 'completed',
                'start_date' => '2025-03-01',
                'end_date' => '2025-04-30',
                'is_active' => true,
            ]
        );
        $project4->attachTags(['React', 'Inertia.js', 'Laravel', 'Full‑Stack', 'Git']);

        // Projet 5 – Site vitrine pour une ONG
        $slug5 = Str::slug('Site vitrine pour une ONG locale');
        $project5 = Project::updateOrCreate(
            ['slug' => $slug5],
            [
                'title' => 'Site vitrine pour une ONG locale',
                'excerpt' => 'Création d’un site internet responsive avec Tailwind CSS et Alpine.js pour une organisation humanitaire.',
                'content' => 'Conception complète : charte graphique, maquettes, développement front‑end avec Tailwind CSS et animations Alpine.js. Backend Laravel pour la gestion des actualités et des dons.',
                'location' => 'Goma, RDC',
                'status' => 'ongoing',
                'start_date' => '2025-05-15',
                'end_date' => null,
                'is_active' => true,
            ]
        );
        $project5->attachTags(['Tailwind CSS', 'Alpine.js', 'Laravel', 'Git']);

        // Projet 6 – E‑commerce avec Laravel & Livewire
        $slug6 = Str::slug('Plateforme e‑commerce avec Laravel Livewire');
        $project6 = Project::updateOrCreate(
            ['slug' => $slug6],
            [
                'title' => 'Plateforme e‑commerce avec Laravel Livewire',
                'excerpt' => 'Boutique en ligne dynamique développée avec Laravel, Livewire et MySQL.',
                'content' => 'Développement d’un site marchand complet : gestion des produits, panier, commandes, paiement via Mobile Money. Interface administrateur avec Filament. Forte interactivité grâce à Livewire.',
                'location' => 'Lubumbashi, RDC',
                'status' => 'planned',
                'start_date' => '2025-07-01',
                'end_date' => '2025-09-30',
                'is_active' => true,
            ]
        );
        $project6->attachTags(['Laravel', 'Livewire', 'Filament', 'MySQL', 'Full‑Stack']);

        // Projet 7 – Mise en place de CI/CD avec Docker & Git
        $slug7 = Str::slug('Automatisation CI/CD avec Docker et GitLab');
        $project7 = Project::updateOrCreate(
            ['slug' => $slug7],
            [
                'title' => 'Automatisation CI/CD avec Docker et GitLab',
                'excerpt' => 'Configuration d’un pipeline de déploiement continu avec GitLab CI, Docker et Laravel Forge.',
                'content' => 'Mise en place de l’intégration continue pour un projet Laravel. Tests automatisés, construction d’images Docker et déploiement automatique sur serveur de production via Laravel Forge.',
                'location' => 'Remote',
                'status' => 'completed',
                'start_date' => '2025-02-01',
                'end_date' => '2025-02-28',
                'is_active' => true,
            ]
        );
        $project7->attachTags(['Docker', 'Git', 'Laravel', 'API REST']);

        // Projet 8 – Système de gestion de formations
        $slug8 = Str::slug('Système de gestion de formations en ligne');
        $project8 = Project::updateOrCreate(
            ['slug' => $slug8],
            [
                'title' => 'Système de gestion de formations en ligne',
                'excerpt' => 'Application de gestion des inscriptions et du suivi des formations avec Filament.',
                'content' => 'Développement d’une plateforme de gestion de formations pour un centre de formation professionnelle. Gestion des sessions, des formateurs, des apprenants et des évaluations. Génération de certificats PDF.',
                'location' => 'Kinshasa, RDC',
                'status' => 'ongoing',
                'start_date' => '2025-04-01',
                'end_date' => null,
                'is_active' => true,
            ]
        );
        $project8->attachTags(['Filament', 'Laravel', 'PostgreSQL', 'API REST', 'Full‑Stack']);

        // Projet 9 – Blog technique & partage de connaissances
        $slug9 = Str::slug('Blog technique avec Laravel');
        $project9 = Project::updateOrCreate(
            ['slug' => $slug9],
            [
                'title' => 'Blog technique avec Laravel',
                'excerpt' => 'Création d’un blog performant pour publier des articles sur le développement web.',
                'content' => 'Blog construit avec Laravel et Livewire. Gestion des articles, catégories, tags et commentaires. Interface d’administration avec Filament. Optimisé pour le référencement et les performances.',
                'location' => 'En ligne',
                'status' => 'completed',
                'start_date' => '2024-10-01',
                'end_date' => '2024-11-15',
                'is_active' => true,
            ]
        );
        $project9->attachTags(['Laravel', 'Livewire', 'Filament', 'MySQL', 'Full‑Stack']);

        // Projet 10 – Application de suivi de projet freelance
        $slug10 = Str::slug('Application de suivi de projet freelance');
        $project10 = Project::updateOrCreate(
            ['slug' => $slug10],
            [
                'title' => 'Application de suivi de projet freelance',
                'excerpt' => 'Outil interne pour gérer les clients, les factures et le temps passé sur les missions.',
                'content' => 'Développement d’une application web destinée aux freelances. Fonctionnalités : gestion des clients, suivi du temps, génération de factures PDF, statistiques de rentabilité. Stack : Laravel, Livewire, Alpine.js, Tailwind CSS.',
                'location' => 'Remote',
                'status' => 'planned',
                'start_date' => '2025-08-01',
                'end_date' => '2025-10-31',
                'is_active' => true,
            ]
        );
        $project10->attachTags(['Laravel', 'Livewire', 'Alpine.js', 'Tailwind CSS', 'Freelance']);
    }
}
