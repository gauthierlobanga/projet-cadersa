<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'excerpt' => ['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => fake()->paragraph()]]]]],
            'content' => ['type' => 'doc', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => fake()->paragraphs(3, true)]]]]],
            'location' => fake()->city(),
            'status' => fake()->randomElement(['planned', 'ongoing', 'completed']),
            'start_date' => fake()->date(),
            'end_date' => fake()->optional()->date(),
            'website_url' => fake()->optional()->url(),
            'repository_url' => fake()->optional()->url(),
            'is_active' => fake()->boolean(80),
        ];
    }
}
