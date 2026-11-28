<?php

namespace Database\Seeders;

use App\Models\FormationCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FormationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Agriculture durable', 'color' => '#10b981'],
            ['name' => 'Sécurité alimentaire', 'color' => '#059669'],
            ['name' => 'Nutrition communautaire', 'color' => '#0e7490'],
            ['name' => 'Développement rural', 'color' => '#65a30d'],
            ['name' => 'Eau, hygiène et assainissement', 'color' => '#0891b2'],
        ];

        foreach ($categories as $index => $category) {
            FormationCategory::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [...$category, 'sort_order' => ($index + 1) * 10]
            );
        }
    }
}
