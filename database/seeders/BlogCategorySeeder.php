<?php

namespace Database\Seeders;

use App\Models\PostCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nom' => 'Développement rural', 'description' => 'Initiatives et approches menées avec les communautés locales.'],
            ['nom' => 'Sécurité alimentaire', 'description' => 'Agriculture familiale, disponibilité alimentaire et résilience locale.'],
            ['nom' => 'Nutrition communautaire', 'description' => 'Information et pratiques favorables à la nutrition et à la santé.'],
            ['nom' => 'Agriculture durable', 'description' => 'Agroécologie, protection des ressources et pratiques adaptées au terrain.'],
            ['nom' => 'Eau, hygiène et assainissement', 'description' => 'Ressources et actions autour de l’eau et du bien-être communautaire.'],
        ];
        $colors = ['#047857', '#0f766e', '#0e7490', '#65a30d', '#0891b2'];

        foreach ($categories as $index => $category) {
            $slug = Str::slug($category['nom']);

            PostCategory::updateOrCreate(
                ['slug' => $slug],
                [
                    'parent_id' => null,
                    ...$category,
                    'color' => $colors[$index],
                    'metadata' => ['niveau' => 1, 'type' => 'racine'],
                    'ordre' => ($index + 1) * 10,
                    'est_active' => true,
                    'est_visible_dans_menu' => true,
                    'meta_title' => $category['nom'].' | CADERSA ASBL',
                    'meta_description' => Str::limit($category['description'], 155),
                    'meta_keywords' => array_map('trim', explode(',', strtolower($category['nom']))),
                ]
            );
        }
    }
}
