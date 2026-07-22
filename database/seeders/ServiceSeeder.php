<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'Développement Web Full‑Stack TALL',
                'excerpt' => 'Applications web modernes avec Laravel, Livewire, Alpine.js et Tailwind CSS.',
                'content' => 'Je conçois et réalise des applications web sur mesure en utilisant le stack TALL (Tailwind CSS, Alpine.js, Laravel, Livewire). De l’analyse du besoin à la mise en production, chaque projet bénéficie d’une architecture solide, d’une interface élégante et d’une maintenance simplifiée. Idéal pour les startups, PME ou indépendants souhaitant une solution performante et évolutive.',
                'icon' => 'fa-solid fa-code',
                'sort_order' => 1,
            ],
            [
                'title' => 'Panneaux d’administration avec FilamentPHP',
                'excerpt' => 'Back‑offices puissants, intuitifs et rapides à déployer.',
                'content' => 'FilamentPHP est mon outil de prédilection pour créer des panneaux d’administration complets. Gestion des utilisateurs, tableaux de bord statistiques, exports de données, intégration de médias : tout est configurable rapidement. Vous bénéficiez d’une interface moderne et totalement personnalisable, sans sacrifier la sécurité ni les performances.',
                'icon' => 'fa-solid fa-gauge-high',
                'sort_order' => 2,
            ],
            [
                'title' => 'Création d’API REST & GraphQL',
                'excerpt' => 'APIs robustes et documentées pour vos applications mobiles ou tierces.',
                'content' => 'Je développe des APIs RESTful (et bientôt GraphQL) avec Laravel Sanctum ou Passport. Authentification, gestion des rôles, rate limiting, documentation interactive Swagger/OpenAPI : tout est prévu pour une intégration fluide avec vos clients (applications mobiles, front‑end séparés). Performances et sécurité sont au cœur de chaque endpoint.',
                'icon' => 'fa-solid fa-plug',
                'sort_order' => 3,
            ],
            [
                'title' => 'Front‑end Réactif avec React & Inertia.js',
                'excerpt' => 'Des interfaces dynamiques sans compromis sur le SEO.',
                'content' => 'Associer la puissance de Laravel à la réactivité de React, c’est possible avec Inertia.js. Je réalise des applications monopages (SPA) qui restent indexables par les moteurs de recherche. Le tout avec une navigation instantanée, des composants réutilisables et une expérience utilisateur haut de gamme.',
                'icon' => 'fa-solid fa-atom',
                'sort_order' => 4,
            ],
            [
                'title' => 'Audit, Optimisation & Maintenance',
                'excerpt' => 'Amélioration des performances, sécurité et évolutivité de vos projets existants.',
                'content' => 'Vous avez déjà une application Laravel mais elle manque de rapidité ou de clarté ? Je réalise des audits de code, des optimisations de base de données, la mise en cache, la conteneurisation (Docker) et la mise en place de pipelines CI/CD. Votre projet gagne en stabilité et en vélocité.',
                'icon' => 'fa-solid fa-magnifying-glass-chart',
                'sort_order' => 5,
            ],
            [
                'title' => 'Conseil & Accompagnement Technique',
                'excerpt' => 'Du choix technologique au déploiement, je vous guide à chaque étape.',
                'content' => 'Besoin d’un avis éclairé sur votre stack technique, votre architecture ou vos méthodes de travail ? Je propose des missions de conseil pour les équipes ou les indépendants. Ensemble, nous définissons les meilleures pratiques, les outils adaptés et la feuille de route pour mener votre projet au succès.',
                'icon' => 'fa-solid fa-compass',
                'sort_order' => 6,
            ],
        ];

        foreach ($services as $data) {
            Service::create([
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'excerpt' => $data['excerpt'],
                'content' => $data['content'],
                'icon' => $data['icon'],
                'is_active' => true,
                'sort_order' => $data['sort_order'],
            ]);
        }
    }
}
