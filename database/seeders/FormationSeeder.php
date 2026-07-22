<?php

namespace Database\Seeders;

use App\Models\Formation;
use App\Models\FormationCategory;
use Illuminate\Database\Seeder;

class FormationSeeder extends Seeder
{
    public function run(): void
    {
        // Récupère les IDs des catégories existantes
        $categoryIds = FormationCategory::pluck('id')->toArray();

        if (empty($categoryIds)) {
            $this->command->warn('Aucune catégorie trouvée. Veuillez exécuter FormationCategorySeeder d\'abord.');

            return;
        }

        // Crée 12 formations
        $formations = Formation::factory()->count(12)->create();

        // Associe une catégorie aléatoire à chaque formation
        foreach ($formations as $formation) {
            $formation->formation_category_id = $categoryIds[array_rand($categoryIds)];
            $formation->save();
        }

        $this->command->info('✅ Formations créées avec succès.');
    }
}
