<?php

namespace Database\Factories;

use App\Models\Formation;
use App\Models\FormationCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FormationFactory extends Factory
{
    protected $model = Formation::class;

    public function definition(): array
    {
        $start = fake()->optional(0.8)->dateTimeBetween('-1 years', '+6 months');
        $end = $start ? fake()->optional(0.6)->dateTimeBetween($start, '+6 months') : null;

        $title = fake()->unique()->sentence(3);

        return [
            'user_id' => User::inRandomOrder()->first()?->id
                                      ?? User::factory(),
            'formation_category_id' => FormationCategory::inRandomOrder()->first()?->id
                                      ?? FormationCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('##'),
            'subtitle' => fake()->optional()->sentence(6),
            'excerpt' => fake()->paragraph(2),           // Chaîne simple
            'content' => $this->generateContent(),
            'location' => fake()->city(),                 // Plus de null
            'status' => fake()->randomElement(['planned', 'ongoing', 'completed']),
            'is_active' => true,
            'start_date' => $start ? $start->format('Y-m-d') : null,
            'end_date' => $end ? $end->format('Y-m-d') : null,
            'published_at' => fake()->optional(0.6)->dateTimeBetween('-1 years', 'now'),
            'meta' => $this->generateMeta($start, $end),
            'sort_order' => fake()->numberBetween(1, 200),
        ];
    }

    // Contenu riche structuré (Tiptap)
    private function generateContent(): array
    {
        $nodes = [];

        // Introduction
        $nodes[] = [
            'type' => 'paragraph',
            'content' => [['type' => 'text', 'text' => fake()->paragraph(3)]],
        ];

        // Prérequis
        $nodes[] = [
            'type' => 'heading',
            'attrs' => ['level' => 2],
            'content' => [['type' => 'text', 'text' => 'Prérequis']],
        ];
        $nodes[] = [
            'type' => 'bulletList',
            'content' => array_map(
                fn () => ['type' => 'listItem', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => fake()->sentence()]]]]],
                range(1, rand(2, 4))
            ),
        ];

        // Objectifs pédagogiques
        $nodes[] = [
            'type' => 'heading',
            'attrs' => ['level' => 2],
            'content' => [['type' => 'text', 'text' => 'Objectifs pédagogiques']],
        ];
        $nodes[] = [
            'type' => 'bulletList',
            'content' => array_map(
                fn () => ['type' => 'listItem', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => fake()->sentence()]]]]],
                range(1, rand(2, 5))
            ),
        ];

        // Programme détaillé
        $nodes[] = [
            'type' => 'heading',
            'attrs' => ['level' => 2],
            'content' => [['type' => 'text', 'text' => 'Programme']],
        ];
        $numModules = rand(3, 6);
        for ($i = 1; $i <= $numModules; $i++) {
            $nodes[] = [
                'type' => 'heading',
                'attrs' => ['level' => 3],
                'content' => [['type' => 'text', 'text' => "Module $i : ".fake()->sentence(3)]],
            ];
            $nodes[] = [
                'type' => 'bulletList',
                'content' => array_map(
                    fn () => ['type' => 'listItem', 'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => fake()->sentence()]]]]],
                    range(1, rand(2, 4))
                ),
            ];
            if ($i < $numModules) {
                $nodes[] = [
                    'type' => 'paragraph',
                    'content' => [['type' => 'text', 'text' => fake()->paragraph(2)]],
                ];
            }
        }

        // Méthodologie
        $nodes[] = [
            'type' => 'heading',
            'attrs' => ['level' => 2],
            'content' => [['type' => 'text', 'text' => 'Méthodologie']],
        ];
        $nodes[] = [
            'type' => 'paragraph',
            'content' => [['type' => 'text', 'text' => fake()->paragraph(4)]],
        ];

        // Certification
        $nodes[] = [
            'type' => 'heading',
            'attrs' => ['level' => 2],
            'content' => [['type' => 'text', 'text' => 'Certification']],
        ];
        $nodes[] = [
            'type' => 'paragraph',
            'content' => [['type' => 'text', 'text' => fake()->randomElement([
                'Une attestation de participation est délivrée à l\'issue de la formation.',
                'Un certificat de compétence est remis après évaluation.',
                'La formation prépare à la certification officielle reconnue par l\'industrie.',
            ])]],
        ];

        return [
            'type' => 'doc',
            'content' => $nodes,
        ];
    }

    // Méta structurée
    private function generateMeta($start, $end): array
    {
        $dureeHeures = ($start && $end) ? fake()->numberBetween(7, 70) : null;
        $niveaux = ['Débutant', 'Intermédiaire', 'Avancé', 'Tous niveaux'];
        $langues = ['Français', 'Anglais'];
        $formats = ['Présentiel', 'Distanciel', 'Hybride'];

        return [
            'duree_heures' => $dureeHeures,
            'niveau' => fake()->randomElement($niveaux),
            'langue' => fake()->randomElement($langues),
            'format' => fake()->randomElement($formats),
            'prerequis' => fake()->boolean(50) ? fake()->sentence(4) : null,
            'public_cible' => fake()->optional()->sentence(3),
            'certification' => fake()->boolean(60),
            'certification_label' => fake()->boolean(40) ? fake()->word() : null,
            'tags' => array_map(fn () => fake()->word(), range(1, rand(2, 5))),
            'prix' => fake()->optional(0.7)->numberBetween(100, 5000),
            'places_limit' => fake()->optional(0.5)->numberBetween(5, 30),
        ];
    }
}
