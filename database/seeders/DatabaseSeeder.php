<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CreateAdminUserSeeder::class,
            BlogCategorySeeder::class,
            PostSeeder::class,
            FaqSeeder::class,
            TeamSeeder::class,
            LegalPagesSeeder::class,
            ServiceSeeder::class,
            ProjectSeeder::class,
            FormationCategorySeeder::class,
            FormationSeeder::class,
            PartnerSeeder::class,
            TestimonialSeeder::class,
        ]);
    }
}
