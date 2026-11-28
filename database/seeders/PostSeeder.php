<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $userId = User::query()->value('id');

        if (! $userId) {
            $this->command?->warn('Aucun compte disponible : les brouillons éditoriaux ne sont pas créés.');

            return;
        }

        $drafts = [
            'Sécurité alimentaire : accompagner les communautés rurales',
            'Pratiques agroécologiques et résilience des exploitations familiales',
            'Nutrition communautaire et alimentation équilibrée',
            'Accès durable à l’eau en milieu rural',
            'Formation participative et renforcement des capacités locales',
        ];

        foreach ($drafts as $title) {
            Post::updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'user_id' => $userId,
                    'title' => $title,
                    'excerpt' => $this->document('Brouillon à compléter avec les informations relues et validées par l’équipe CADERSA.'),
                    'content' => $this->document('Ajoutez le contexte, les activités menées, les partenaires concernés et les résultats documentés avant publication.'),
                    'metadata' => ['author_bio' => 'Équipe éditoriale de CADERSA ASBL'],
                    'status' => 'draft',
                    'is_pinned' => false,
                    'views_count' => 0,
                    'likes_count' => 0,
                    'comments_count' => 0,
                    'meta_title' => $title,
                    'meta_description' => 'Brouillon éditorial à compléter et valider avant publication.',
                ]
            );
        }
    }

    /**
     * @return array{type: string, content: list<array{type: string, content: list<array{type: string, text: string}>}>}
     */
    private function document(string $text): array
    {
        return [
            'type' => 'doc',
            'content' => [['type' => 'paragraph', 'content' => [['type' => 'text', 'text' => $text]]]],
        ];
    }
}
