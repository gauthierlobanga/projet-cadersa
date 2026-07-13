<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    private array $usedTitles = [];

    private array $usedSlugs = [];

    public function run(): void
    {
        if (User::count() === 0) {
            $this->command->error('Aucun utilisateur trouvé. Veuillez d\'abord créer des utilisateurs.');

            return;
        }

        $categoriesExistantes = PostCategory::count();
        if ($categoriesExistantes === 0) {
            $this->command->error('Aucune catégorie trouvée. Veuillez d\'abord exécuter BlogCategorySeeder.');

            return;
        }

        $faker = Factory::create('fr_FR');
        $userIds = User::pluck('id')->toArray();
        $categoryIds = PostCategory::pluck('id')->toArray();

        $themes = [
            'agriculture' => [
                'titles' => [
                    'Techniques de culture du maïs en zone tropicale',
                    'L\'agroécologie pour une production durable',
                    'Gestion intégrée des sols agricoles',
                    'Irrigation : systèmes économes pour petits producteurs',
                    'Semences améliorées : atouts et précautions',
                ],
                'tags' => ['agriculture', 'maïs', 'agroécologie', 'sol', 'irrigation'],
            ],
            'elevage' => [
                'titles' => [
                    'Élevage de poules pondeuses en milieu rural',
                    'Alimentation des bovins en saison sèche',
                    'Prévention des maladies animales courantes',
                    'Mise en place d\'un élevage caprin',
                    'Production de fourrage de qualité',
                ],
                'tags' => ['élevage', 'bovins', 'caprins', 'aviculture', 'santé animale'],
            ],
            'nutrition' => [
                'titles' => [
                    'Alimentation des nourrissons : les bonnes pratiques',
                    'Repas équilibrés pour femmes enceintes et allaitantes',
                    'Valorisation des protéines végétales',
                    'Démonstrations culinaires à base d\'aliments locaux',
                    'L\'importance de la diversification alimentaire',
                ],
                'tags' => ['nutrition', 'enfants', 'femmes enceintes', 'protéines', 'aliments locaux'],
            ],
            'projets' => [
                'titles' => [
                    'Projet de renforcement de la résilience à Luiza',
                    'Bilan du programme de nutrition sensible',
                    'Construction d\'entrepôts communautaires à Gemena',
                    'Formation des coopératives agricoles au Kasaï Central',
                    'Distribution de kits AGR : impact sur les bénéficiaires',
                ],
                'tags' => ['projets', 'résilience', 'nutrition', 'entrepôts', 'coopératives'],
            ],
            'formation' => [
                'titles' => [
                    'Atelier sur la gestion post-récolte',
                    'Formation en alphabétisation fonctionnelle',
                    'Sensibilisation à la nutrition infantile',
                    'Atelier de fabrication de foyers améliorés',
                    'Formation en entrepreneurial agricole',
                ],
                'tags' => ['formation', 'alphabétisation', 'nutrition', 'foyers améliorés', 'entrepreneuriat'],
            ],
            'temoignages' => [
                'titles' => [
                    'Histoire de Marie, productrice à Luiza',
                    'Témoignage de Jean, bénéficiaire du projet',
                    'Retour d\'expérience d\'une coopérative',
                    'Impact du programme sur la vie des femmes',
                    'Paroles de partenaires : PAM et CADERSA',
                ],
                'tags' => ['témoignage', 'bénéficiaire', 'coopérative', 'femmes', 'partenaires'],
            ],
            'environnement' => [
                'titles' => [
                    'Reboisement communautaire : bilan de la campagne',
                    'Lutte antiérosive : techniques efficaces',
                    'Agroforesterie pour préserver la biodiversité',
                    'Gestion durable des déchets agricoles',
                    'Adaptation aux changements climatiques',
                ],
                'tags' => ['environnement', 'reboisement', 'antiérosive', 'agroforesterie', 'climat'],
            ],
            'partenariats' => [
                'titles' => [
                    'Collaboration avec le PAM pour la sécurité alimentaire',
                    'Appui de la FAO à l\'agriculture familiale',
                    'Partenariat avec le gouvernement congolais',
                    'Synergie avec les ONG locales',
                    'Coopération internationale pour le développement rural',
                ],
                'tags' => ['partenariat', 'PAM', 'FAO', 'gouvernement', 'ONG'],
            ],
        ];

        $postsCrees = 0;

        foreach ($themes as $themeKey => $theme) {
            foreach ($theme['titles'] as $title) {
                if (in_array($title, $this->usedTitles)) {
                    continue;
                }
                $this->usedTitles[] = $title;

                $numCategories = $faker->numberBetween(1, 3);
                $categories = $faker->randomElements($categoryIds, $numCategories);

                do {
                    $slug = Str::slug($title);
                    if (in_array($slug, $this->usedSlugs)) {
                        $slug .= '-'.$faker->randomNumber(3);
                    }
                } while (in_array($slug, $this->usedSlugs) || Post::where('slug', $slug)->exists());
                $this->usedSlugs[] = $slug;

                $status = $faker->randomElement(['draft', 'published', 'archived']);
                $isPinned = $faker->boolean(10);

                $publishedAt = null;
                $scheduledFor = null;
                $expiresAt = null;

                if ($status === 'published') {
                    $publishedAt = Carbon::now()->subDays($faker->numberBetween(0, 90));
                } elseif ($status === 'draft' && $faker->boolean(20)) {
                    $scheduledFor = Carbon::now()->addDays($faker->numberBetween(1, 30));
                } elseif ($status === 'archived') {
                    $publishedAt = Carbon::now()->subMonths($faker->numberBetween(6, 24));
                    $expiresAt = Carbon::now()->subMonths($faker->numberBetween(1, 3));
                }

                $post = Post::create([
                    'user_id' => $faker->randomElement($userIds),
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $this->generateUniqueExcerpt($faker, $title),
                    'content' => $this->generateLongContent($faker, $themeKey),
                    'metadata' => [
                        'author_bio' => $faker->sentence(10),
                        'difficulty' => $faker->randomElement(['Débutant', 'Intermédiaire', 'Avancé']),
                    ],
                    'status' => $status,
                    'is_pinned' => $isPinned,
                    'views_count' => $status === 'published' ? $faker->numberBetween(50, 50000) : 0,
                    'likes_count' => $status === 'published' ? $faker->numberBetween(5, 200) : 0,
                    'comments_count' => $status === 'published' ? $faker->numberBetween(0, 50) : 0,
                    'meta_title' => $title.' | CADERSA',
                    'meta_description' => Str::limit($faker->sentence(12), 160),
                    'meta_keywords' => implode(',', $theme['tags']),
                    'published_at' => $publishedAt,
                    'scheduled_for' => $scheduledFor,
                    'expires_at' => $expiresAt,
                ]);

                // --- GESTION DES TAGS AVEC UUID ---
                $tags = $theme['tags'];
                $tagIds = [];
                foreach ($tags as $tagName) {
                    $tagSlug = Str::slug($tagName);
                    $tag = Tag::firstOrCreate(
                        ['slug' => $tagSlug],
                        [
                            'id' => (string) Str::uuid(), // ✅ Génération de l'UUID
                            'name' => ['en' => $tagName],
                            'type' => 'default',
                            'order_column' => 0,
                        ]
                    );
                    $tagIds[] = $tag->id;
                }
                $post->tags()->sync($tagIds);

                // Catégories
                $syncData = [];
                foreach ($categories as $index => $categoryId) {
                    $syncData[$categoryId] = [
                        'est_principale' => ($index === 0),
                        'ordre' => $index,
                    ];
                }
                $post->categories()->sync($syncData);

                $postsCrees++;
            }
        }

        // Compléter jusqu'à 30 articles si nécessaire
        if (Post::count() < 30) {
            $remaining = 30 - Post::count();
            for ($i = 0; $i < $remaining; $i++) {
                do {
                    $title = $faker->sentence(6);
                } while (in_array($title, $this->usedTitles));
                $this->usedTitles[] = $title;

                $categories = $faker->randomElements($categoryIds, 2);
                do {
                    $slug = Str::slug($title);
                    if (in_array($slug, $this->usedSlugs)) {
                        $slug .= '-'.$faker->randomNumber(3);
                    }
                } while (in_array($slug, $this->usedSlugs) || Post::where('slug', $slug)->exists());
                $this->usedSlugs[] = $slug;

                $status = $faker->randomElement(['draft', 'published', 'archived']);
                $publishedAt = null;
                if ($status === 'published') {
                    $publishedAt = Carbon::now()->subDays($faker->numberBetween(0, 90));
                }

                $post = Post::create([
                    'user_id' => $faker->randomElement($userIds),
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $this->generateUniqueExcerpt($faker, $title),
                    'content' => $this->generateRandomContent($faker),
                    'metadata' => [],
                    'status' => $status,
                    'is_pinned' => false,
                    'views_count' => $faker->numberBetween(10, 1000),
                    'likes_count' => $faker->numberBetween(0, 20),
                    'comments_count' => $faker->numberBetween(0, 5),
                    'meta_title' => $title,
                    'meta_description' => Str::limit($faker->sentence(12), 160),
                    'meta_keywords' => implode(',', $faker->words(5)),
                    'published_at' => $publishedAt,
                    'scheduled_for' => null,
                    'expires_at' => null,
                ]);

                // Tags avec UUID
                $tags = $faker->words(3);
                $tagIds = [];
                foreach ($tags as $tagName) {
                    $tagSlug = Str::slug($tagName);
                    $tag = Tag::firstOrCreate(
                        ['slug' => $tagSlug],
                        [
                            'id' => (string) Str::uuid(),
                            'name' => ['en' => $tagName],
                            'type' => 'default',
                            'order_column' => 0,
                        ]
                    );
                    $tagIds[] = $tag->id;
                }
                $post->tags()->sync($tagIds);

                $syncData = [];
                foreach ($categories as $index => $categoryId) {
                    $syncData[$categoryId] = [
                        'est_principale' => ($index === 0),
                        'ordre' => $index,
                    ];
                }
                $post->categories()->sync($syncData);

                $postsCrees++;
            }
        }

        $this->command->info("✅ {$postsCrees} articles de blog créés avec succès.");
    }

    /**
     * Génère un excerpt au format Tiptap JSON.
     *
     * @return array<string, mixed>
     */
    private function generateUniqueExcerpt($faker, string $title): array
    {
        $intros = ['Découvrez dans cet article', 'Guide complet sur', 'Tout ce qu\'il faut savoir sur', 'Analyse de', 'Nos conseils pour'];
        $intro = $faker->randomElement($intros);
        $subject = str_replace(['Comment ', 'Pourquoi ', 'Guide ', 'Les '], '', $title);
        $subject = strtolower($subject);

        $text = $intro.' '.$subject.'. '.$faker->sentence(8);

        return [
            'type' => 'doc',
            'content' => [
                [
                    'type' => 'paragraph',
                    'content' => [
                        ['type' => 'text', 'text' => $text],
                    ],
                ],
            ],
        ];
    }

    /**
     * Génère un contenu long au format Tiptap JSON.
     *
     * @return array<string, mixed>
     */
    private function generateLongContent($faker, string $themeKey): array
    {
        $nodes = [];
        $numParagraphs = rand(8, 15);

        // Lead paragraph
        $nodes[] = [
            'type' => 'paragraph',
            'attrs' => ['class' => 'lead'],
            'content' => [
                ['type' => 'text', 'text' => $faker->paragraph(3)],
            ],
        ];

        for ($i = 0; $i < $numParagraphs; $i++) {
            if ($i % 3 === 0 && $i > 0) {
                $nodes[] = [
                    'type' => 'heading',
                    'attrs' => ['level' => 2],
                    'content' => [
                        ['type' => 'text', 'text' => $faker->sentence(rand(4, 7))],
                    ],
                ];
            }
            if ($i % 4 === 0 && $i > 0) {
                $nodes[] = [
                    'type' => 'heading',
                    'attrs' => ['level' => 3],
                    'content' => [
                        ['type' => 'text', 'text' => $faker->sentence(rand(4, 6))],
                    ],
                ];
            }

            $nodes[] = [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => $faker->paragraph(rand(3, 8))],
                ],
            ];

            if ($i % 5 === 0) {
                $listItems = [];
                for ($j = 0; $j < rand(3, 6); $j++) {
                    $listItems[] = [
                        'type' => 'listItem',
                        'content' => [
                            [
                                'type' => 'paragraph',
                                'content' => [
                                    ['type' => 'text', 'text' => $faker->sentence(rand(6, 12))],
                                ],
                            ],
                        ],
                    ];
                }
                $nodes[] = [
                    'type' => 'bulletList',
                    'content' => $listItems,
                ];
            }

            if ($i % 7 === 0) {
                $nodes[] = [
                    'type' => 'blockquote',
                    'content' => [
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => $faker->sentence(rand(10, 20))],
                            ],
                        ],
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => '— '.$faker->name()],
                            ],
                        ],
                    ],
                ];
            }
        }

        // Conclusion
        $nodes[] = [
            'type' => 'heading',
            'attrs' => ['level' => 2],
            'content' => [
                ['type' => 'text', 'text' => 'Conclusion'],
            ],
        ];
        $nodes[] = [
            'type' => 'paragraph',
            'content' => [
                ['type' => 'text', 'text' => $faker->paragraph(4)],
            ],
        ];

        return [
            'type' => 'doc',
            'content' => $nodes,
        ];
    }

    /**
     * Génère un contenu aléatoire au format Tiptap JSON.
     *
     * @return array<string, mixed>
     */
    private function generateRandomContent($faker): array
    {
        $nodes = [];
        $numParagraphs = rand(5, 12);

        for ($i = 0; $i < $numParagraphs; $i++) {
            if ($i % 4 === 0 && $i > 0) {
                $nodes[] = [
                    'type' => 'heading',
                    'attrs' => ['level' => 2],
                    'content' => [
                        ['type' => 'text', 'text' => $faker->sentence(rand(4, 7))],
                    ],
                ];
            }

            $nodes[] = [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => $faker->paragraph(rand(3, 7))],
                ],
            ];
        }

        return [
            'type' => 'doc',
            'content' => $nodes,
        ];
    }
}
