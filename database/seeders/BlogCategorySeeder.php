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

        $descriptions = [
            'Une ressource essentielle pour approfondir vos connaissances.',
            'Découvrez les meilleures pratiques et astuces.',
            'Explorez les projets et retours d’expérience.',
            'Tout ce que vous devez savoir pour progresser.',
            'Un aperçu complet des outils et méthodes modernes.',
        ];

        // Catégories principales (thèmes techniques)
        $racines = [
            ['nom' => 'Laravel', 'description' => 'Framework PHP, astuces, architecture'],
            ['nom' => 'Livewire', 'description' => 'Composants dynamiques sans JavaScript'],
            ['nom' => 'React & Inertia', 'description' => 'Front-end moderne avec Laravel'],
            ['nom' => 'Filament', 'description' => 'Panneaux d’administration rapides'],
            ['nom' => 'Tailwind CSS', 'description' => 'Design utilitaire et responsive'],
            ['nom' => 'Alpine.js', 'description' => 'Interactivité légère en front-end'],
            ['nom' => 'Développement Web', 'description' => 'Bonnes pratiques, sécurité, outils'],
            ['nom' => 'Carrière', 'description' => 'Freelance, productivité, veille techno'],
        ];

        // Création des catégories racines
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
                    'meta_title' => $catData['nom'].' | ',
                    'meta_description' => 'Articles sur '.strtolower($catData['nom']).' : tutoriels, conseils, actualités.',
                    'meta_keywords' => explode(' ', strtolower($catData['nom'])),
                ]
            );
        }

        // Sous-catégories (optionnelles) pour enrichir le blog
        $sousCategoriesMap = [
            'Laravel' => ['Bonnes pratiques', 'Packs & Librairies', 'API & Sécurité'],
            'Livewire' => ['Composants réutilisables', 'Volt & Actions', 'Performance'],
            'React & Inertia' => ['SPA', 'State Management', 'Authentification'],
            'Filament' => ['Plugins', 'Tableaux de bord', 'Formulaires'],
            'Tailwind CSS' => ['Thèmes', 'Animations', 'Personnalisation'],
            'Développement Web' => ['Git & CI/CD', 'Docker', 'Sécurité'],
            'Carrière' => ['Freelancing', 'Productivité', 'Veille techno'],
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
                        'color' => $colors[(8 + $index) % count($colors)],
                        'metadata' => ['niveau' => 2, 'parent' => $racineNom],
                        'ordre' => $index * 5,
                        'est_active' => true,
                        'est_visible_dans_menu' => ($index % 2 === 0),
                        'meta_title' => $nomSousCat.' - '.$racineNom.' | ',
                        'meta_description' => 'Articles et astuces sur '.strtolower($nomSousCat).' dans la catégorie '.strtolower($racineNom).'.',
                        'meta_keywords' => array_merge(
                            explode(' ', strtolower($nomSousCat)),
                            explode(' ', strtolower($racineNom))
                        ),
                    ]
                );
            }
        }

        $this->command->info('✅ Catégories de blog techniques créées avec succès.');
    }
}
