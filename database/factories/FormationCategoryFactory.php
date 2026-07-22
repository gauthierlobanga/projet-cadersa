<?php

namespace Database\Factories;

use App\Models\FormationCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FormationCategoryFactory extends Factory
{
    protected $model = FormationCategory::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'icon' => null,
            'color' => fake()->optional()->safeHexColor(),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
