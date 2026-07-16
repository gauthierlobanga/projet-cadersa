<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Couleurs hexadécimales fixes et agréables pour chaque catégorie
        $colors = [
            '#059669', '#10b981', '#34d399', '#6ee7b7', '#a7f3d0',
            '#f59e0b', '#d97706', '#b45309', '#8b5cf6', '#6366f1',
            '#3b82f6', '#2563eb', '#1d4ed8', '#ec4899', '#db2777',
        ];

        // Descriptions génériques pour les sous-catégories
        $descriptions = [
            'Une ressource essentielle pour approfondir vos connaissances.',
            'Découvrez les meilleures pratiques et les témoignages du terrain.',
            'Explorez les projets et initiatives en cours dans ce domaine.',
            'Tout ce que vous devez savoir pour rester informé et engagé.',
            'Un aperçu complet des actions et de leur impact sur les communautés.',
        ];

        $racines = [
            ['nom' => 'Agriculture', 'description' => 'Techniques agricoles, cultures, innovations'],
            ['nom' => 'Élevage', 'description' => 'Élevage de bétail, santé animale, pratiques durables'],
            ['nom' => 'Nutrition', 'description' => 'Sécurité alimentaire, nutrition infantile, conseils diététiques'],
            ['nom' => 'Projets', 'description' => 'Suivi des projets de développement, réalisations'],
            ['nom' => 'Formation', 'description' => 'Ateliers, formations, renforcement des capacités'],
            ['nom' => 'Témoignages', 'description' => 'Histoires de bénéficiaires, retours d\'expérience'],
            ['nom' => 'Partenariats', 'description' => 'Collaborations avec PAM, FAO, etc.'],
            ['nom' => 'Environnement', 'description' => 'Agroforesterie, lutte contre la déforestation, changements climatiques'],
        ];

        foreach ($racines as $index => $catData) {
            $slug = Str::slug($catData['nom']);
            PostCategory::firstOrCreate(
                ['slug' => $slug],
                [
                    'parent_id' => null,
                    'nom' => $catData['nom'],
                    'description' => $catData['description'],
                    'color' => $colors[$index % count($colors)],
                    'metadata' => ['niveau' => 1, 'type' => 'racine'],
                    'ordre' => $index * 10,
                    'est_active' => true,
                    'est_visible_dans_menu' => true,
                    'meta_title' => $catData['nom'].' - CADERSA',
                    'meta_description' => 'Articles sur '.strtolower($catData['nom']).' dans le cadre du développement rural',
                    'meta_keywords' => explode(' ', strtolower($catData['nom'])),
                ]
            );
        }

        $sousCategoriesMap = [
            'Agriculture' => ['Cultures vivrières', 'Agroécologie', 'Gestion des sols', 'Irrigation', 'Semences améliorées'],
            'Élevage' => ['Bovins', 'Caprins', 'Aviculture', 'Santé animale', 'Fourrage'],
            'Nutrition' => ['Alimentation infantile', 'Femmes enceintes et allaitantes', 'Cuisine équilibrée', 'Protéines végétales'],
            'Projets' => ['Projets en cours', 'Projets achevés', 'Impact', 'Rapports'],
            'Formation' => ['Ateliers pratiques', 'Formations en ligne', 'Sensibilisation', 'Boîtes à outils'],
            'Témoignages' => ['Bénéficiaires', 'Partenaires', 'Staff'],
            'Partenariats' => ['PAM', 'FAO', 'ONG locales', 'Gouvernement'],
            'Environnement' => ['Reboisement', 'Lutte antiérosive', 'Gestion des déchets', 'Changements climatiques'],
        ];

        foreach ($sousCategoriesMap as $racineNom => $sousCategories) {
            $parent = PostCategory::where('nom', $racineNom)->first();
            if (! $parent) {
                continue;
            }

            foreach ($sousCategories as $index => $nomSousCat) {
                $slug = Str::slug($parent->slug.'-'.$nomSousCat);
                PostCategory::firstOrCreate(
                    ['slug' => $slug],
                    [
                        'parent_id' => $parent->id,
                        'nom' => $nomSousCat,
                        'description' => $descriptions[$index % count($descriptions)],
                        'color' => $colors[(8 + $index) % count($colors)], // Décale pour varier les couleurs
                        'metadata' => ['niveau' => 2, 'parent' => $racineNom],
                        'ordre' => $index * 5,
                        'est_active' => true,
                        'est_visible_dans_menu' => ($index % 2 === 0), // Une sur deux visible
                        'meta_title' => $nomSousCat.' - '.$racineNom,
                        'meta_description' => 'Découvrez nos articles et ressources sur '.strtolower($nomSousCat).' dans la catégorie '.strtolower($racineNom).'.',
                        'meta_keywords' => array_merge(
                            explode(' ', strtolower($nomSousCat)),
                            explode(' ', strtolower($racineNom))
                        ),
                    ]
                );
            }
        }

        $this->command->info('✅ Catégories de blog pour CADERSA créées avec succès.');
    }
}
