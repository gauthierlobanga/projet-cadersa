<?php

namespace Database\Factories;

use App\Models\Report;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filename = fake()->unique()->slug().'.pdf';

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->sentence(),
            'period_type' => Report::PERIOD_ANNUAL,
            'report_year' => (int) now()->year,
            'period_number' => null,
            'file_path' => 'reports/'.$filename,
            'original_filename' => $filename,
            'mime_type' => 'application/pdf',
            'file_type' => Report::TYPE_PDF,
            'file_size' => fake()->numberBetween(50_000, 2_000_000),
            'status' => Report::STATUS_PUBLISHED,
            'published_at' => now(),
        ];
    }

    public function draft(): static
    {
        return $this->state(fn (): array => [
            'status' => Report::STATUS_DRAFT,
            'published_at' => null,
        ]);
    }
}
