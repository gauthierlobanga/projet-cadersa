<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\User;
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

        if (PostCategory::count() === 0) {
            $this->command->error('Aucune catégorie trouvée. Veuillez d\'abord exécuter BlogCategorySeeder.');

            return;
        }

        $userIds = User::pluck('id')->toArray();
        $categoryIds = PostCategory::pluck('id')->toArray();

        $themes = [
            // ---------- Développement Web (existant) ----------
            'laravel' => [
                'titles' => [
                    'Pourquoi Laravel est le meilleur framework PHP en 2025',
                    'Laravel 11 : découvrez les nouvelles fonctionnalités',
                    'Comment organiser son code avec les Actions Laravel',
                    'Les secrets des Jobs & Queues pour des applications performantes',
                    'Créer une API RESTful avec Laravel Sanctum en 30 minutes',
                ],
                'tags' => ['Laravel', 'PHP', 'API', 'Queues', 'Sanctum'],
            ],
            'livewire' => [
                'titles' => [
                    'Livewire 4 : ce qui change pour les développeurs',
                    'Créer un formulaire multi‑étapes avec Livewire',
                    'Optimiser les performances de vos composants Livewire',
                    'Livewire vs React/Inertia : comment choisir ?',
                    'Gestion d’état avancée avec Livewire',
                ],
                'tags' => ['Livewire', 'TALL', 'Alpine.js', 'Performance', 'État'],
            ],
            'react-inertia' => [
                'titles' => [
                    'Démarrer avec React et Inertia dans Laravel',
                    'Construire une SPA moderne avec React, Inertia et Tailwind',
                    'Inertia 2.0 : les nouveautés à ne pas manquer',
                    'Partager les données entre Laravel et React avec Inertia',
                    'Authentification avec Inertia et Laravel Breeze',
                ],
                'tags' => ['React', 'Inertia.js', 'SPA', 'Tailwind', 'Authentification'],
            ],
            'filament' => [
                'titles' => [
                    'FilamentPHP : l’outil ultime pour les panneaux d’administration',
                    'Créer un plugin Filament en 5 étapes',
                    'Personnaliser le tableau de bord Filament pour vos clients',
                    'Gestion des médias avec Filament et Spatie Media Library',
                    'Filament vs Nova : lequel choisir en 2025 ?',
                ],
                'tags' => ['Filament', 'Administration', 'Plugins', 'Media', 'Nova'],
            ],
            'tailwind' => [
                'titles' => [
                    'Tailwind CSS v4 : les nouveautés à connaître',
                    'Créer un thème sombre avec Tailwind en 10 minutes',
                    'Animations modernes avec Tailwind et Alpine.js',
                    'Tailwind pour les débutants : guide complet',
                    'Comment structurer son CSS avec @apply et @layer',
                ],
                'tags' => ['Tailwind CSS', 'CSS', 'Thème sombre', 'Animations', 'Débutant'],
            ],
            'alpine' => [
                'titles' => [
                    'Alpine.js : le couteau suisse du front‑end',
                    'Alpine + Livewire : duo gagnant pour TALL stack',
                    'Créer des composants réutilisables avec Alpine.data',
                    'Animations avancées avec Alpine et GSAP',
                    'Alpine.js 4 : qu’attendre de la prochaine version ?',
                ],
                'tags' => ['Alpine.js', 'JavaScript', 'TALL', 'GSAP', 'Composants'],
            ],
            'dev-web' => [
                'titles' => [
                    'Les bonnes pratiques de développement web en 2025',
                    'Accessibilité web : pourquoi et comment s’y mettre',
                    'Sécuriser son application Laravel : checklist',
                    'Comprendre et utiliser Git comme un pro',
                    'Docker pour les développeurs Laravel',
                ],
                'tags' => ['Bonnes pratiques', 'Accessibilité', 'Sécurité', 'Git', 'Docker'],
            ],
            'carriere' => [
                'titles' => [
                    'Devenir développeur freelance : les clés pour réussir',
                    'Comment fixer ses tarifs en tant que développeur indépendant',
                    'Organiser sa veille technologique efficacement',
                    'Soft skills indispensables pour les développeurs',
                    'Trouver ses premiers clients en développement web',
                ],
                'tags' => ['Freelance', 'Carrière', 'Tarifs', 'Veille', 'Clients'],
            ],
            'projets' => [
                'titles' => [
                    'Retour d’expérience sur la création de mon portfolio TALL',
                    'Développer une application de gestion de projets avec Filament',
                    'Comment j’ai migré une app React vers Inertia',
                    'Réussir son projet de refonte de site avec Laravel',
                    'Les leçons apprises en tant que développeur solo',
                ],
                'tags' => ['Projets', 'Portfolio', 'Migration', 'Refonte', 'Solo'],
            ],

            // ---------- NOUVEAUX THÈMES ----------
            'office' => [
                'titles' => [
                    'Maîtriser Word : des raccourcis aux modèles professionnels',
                    'Excel avancé : tableaux croisés dynamiques et macros',
                    'Excel pour les débutants : les bases incontournables',
                    'Word et Excel : automatisez vos tâches avec VBA',
                    'PowerPoint : créer des présentations impactantes',
                ],
                'tags' => ['Word', 'Excel', 'Bureautique', 'VBA', 'PowerPoint'],
            ],
            'analyse-donnees' => [
                'titles' => [
                    'Introduction à l’analyse de données : concepts et méthodes',
                    'Nettoyer et préparer vos données avec Python (Pandas)',
                    'Visualisation de données avec Power BI : premiers pas',
                    'Power BI Desktop : créer des rapports interactifs',
                    'Analyse de données avec Excel : Power Query et Power Pivot',
                ],
                'tags' => ['Analyse de données', 'Power BI', 'Excel', 'Python', 'Visualisation'],
            ],
            'uml' => [
                'titles' => [
                    'Modélisation UML : les diagrammes indispensables',
                    'Diagramme de classes UML : guide complet',
                    'Cas d’utilisation UML : capturer les besoins fonctionnels',
                    'Diagramme de séquence UML : modéliser les interactions',
                    'Outils UML gratuits pour développeurs',
                ],
                'tags' => ['UML', 'Modélisation', 'Diagrammes', 'Conception', 'Outils'],
            ],
            'web-semantique' => [
                'titles' => [
                    'Introduction au Web sémantique : au-delà du Web 2.0',
                    'Comprendre RDF et les triplets sémantiques',
                    'OWL et les ontologies : structurer les connaissances',
                    'SPARQL : interroger le Web des données',
                    'Applications du Web sémantique dans les entreprises',
                ],
                'tags' => ['Web sémantique', 'RDF', 'OWL', 'SPARQL', 'Ontologies'],
            ],
            'mysql' => [
                'titles' => [
                    'MySQL pour les débutants : installation et premiers pas',
                    'Optimiser les requêtes MySQL : index et EXPLAIN',
                    'MySQL et PHP : créer une application CRUD',
                    'Sauvegardes et restaurations MySQL : les bonnes pratiques',
                    'MySQL 8.0 : nouveautés et fonctionnalités avancées',
                ],
                'tags' => ['MySQL', 'Base de données', 'SQL', 'Optimisation', 'CRUD'],
            ],
            'postgresql' => [
                'titles' => [
                    'PostgreSQL : pourquoi et quand l’utiliser ?',
                    'Installer et configurer PostgreSQL sur Linux',
                    'PostgreSQL vs MySQL : lequel choisir ?',
                    'Les fonctions de fenêtrage avancées avec PostgreSQL',
                    'PostGIS : données géospatiales avec PostgreSQL',
                ],
                'tags' => ['PostgreSQL', 'Base de données', 'SQL', 'PostGIS', 'Comparatif'],
            ],
            'sqlserver' => [
                'titles' => [
                    'SQL Server pour les développeurs : prise en main',
                    'T-SQL : les spécificités de SQL Server',
                    'SQL Server Management Studio : guide complet',
                    'Haute disponibilité avec SQL Server Always On',
                    'Migrer de MySQL à SQL Server : ce qu’il faut savoir',
                ],
                'tags' => ['SQL Server', 'T-SQL', 'Base de données', 'Migration', 'SSMS'],
            ],
            'docker' => [
                'titles' => [
                    'Docker pour les débutants : conteneurisez vos applications',
                    'Créer un fichier Docker Compose pour un projet Laravel',
                    'Docker Swarm vs Kubernetes : quel orchestrateur choisir ?',
                    'Docker en production : bonnes pratiques de sécurité',
                    'Docker et les bases de données : conteneuriser MySQL/PostgreSQL',
                ],
                'tags' => ['Docker', 'Conteneurisation', 'Docker Compose', 'Kubernetes', 'Sécurité'],
            ],
            'git' => [
                'titles' => [
                    'Git : les commandes indispensables à connaître',
                    'Git Flow : une stratégie de branches efficace',
                    'Résoudre les conflits Git comme un pro',
                    'GitHub Actions : automatisez vos workflows',
                    'Git avancé : rebase interactif et cherry-pick',
                ],
                'tags' => ['Git', 'Versioning', 'GitHub', 'Git Flow', 'CI/CD'],
            ],
        ];

        $postsCrees = 0;

        foreach ($themes as $themeKey => $theme) {
            foreach ($theme['titles'] as $title) {
                if (in_array($title, $this->usedTitles)) {
                    continue;
                }
                $this->usedTitles[] = $title;

                $numCategories = rand(1, 3);
                $categories = (array) array_rand(array_flip($categoryIds), min($numCategories, count($categoryIds)));

                do {
                    $slug = Str::slug($title);
                    if (in_array($slug, $this->usedSlugs)) {
                        $slug .= '-'.rand(100, 999);
                    }
                } while (in_array($slug, $this->usedSlugs) || Post::where('slug', $slug)->exists());
                $this->usedSlugs[] = $slug;

                $statuses = ['draft', 'published', 'archived'];
                $status = $statuses[array_rand($statuses)];
                $isPinned = rand(0, 9) === 0;

                $publishedAt = null;
                $scheduledFor = null;
                $expiresAt = null;

                if ($status === 'published') {
                    $publishedAt = Carbon::now()->subDays(rand(0, 90));
                } elseif ($status === 'draft' && rand(0, 4) === 0) {
                    $scheduledFor = Carbon::now()->addDays(rand(1, 30));
                } elseif ($status === 'archived') {
                    $publishedAt = Carbon::now()->subMonths(rand(6, 24));
                    $expiresAt = Carbon::now()->subMonths(rand(1, 3));
                }

                $post = Post::create([
                    'user_id' => $userIds[array_rand($userIds)],
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $this->generateExcerpt($title),
                    'content' => $this->generateLongContent($themeKey),
                    'metadata' => [
                        'author_bio' => 'Développeur Full‑Stack TALL & React',
                        'difficulty' => ['Débutant', 'Intermédiaire', 'Avancé'][array_rand(['Débutant', 'Intermédiaire', 'Avancé'])],
                    ],
                    'status' => $status,
                    'is_pinned' => $isPinned,
                    'views_count' => $status === 'published' ? rand(50, 50000) : 0,
                    'likes_count' => $status === 'published' ? rand(5, 200) : 0,
                    'comments_count' => $status === 'published' ? rand(0, 50) : 0,
                    'meta_title' => $title.' | ',
                    'meta_description' => Str::limit('Article traitant de '.strtolower($title), 160),
                    'meta_keywords' => implode(',', $theme['tags']),
                    'published_at' => $publishedAt,
                    'scheduled_for' => $scheduledFor,
                    'expires_at' => $expiresAt,
                ]);

                $tagIds = [];
                foreach ($theme['tags'] as $tagName) {
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

        // Compléter jusqu'à 30 articles si nécessaire
        if (Post::count() < 30) {
            $remaining = 30 - Post::count();
            for ($i = 0; $i < $remaining; $i++) {
                do {
                    $title = 'Astuce & Ressource #'.($i + 1);
                } while (in_array($title, $this->usedTitles));
                $this->usedTitles[] = $title;

                $categories = (array) array_rand(array_flip($categoryIds), min(2, count($categoryIds)));
                do {
                    $slug = Str::slug($title);
                    if (in_array($slug, $this->usedSlugs)) {
                        $slug .= '-'.rand(100, 999);
                    }
                } while (in_array($slug, $this->usedSlugs) || Post::where('slug', $slug)->exists());
                $this->usedSlugs[] = $slug;

                $statuses = ['draft', 'published', 'archived'];
                $status = $statuses[array_rand($statuses)];
                $publishedAt = null;
                if ($status === 'published') {
                    $publishedAt = Carbon::now()->subDays(rand(0, 90));
                }

                $post = Post::create([
                    'user_id' => $userIds[array_rand($userIds)],
                    'title' => $title,
                    'slug' => $slug,
                    'excerpt' => $this->generateExcerpt($title),
                    'content' => $this->generateRandomContent(),
                    'metadata' => [],
                    'status' => $status,
                    'is_pinned' => false,
                    'views_count' => rand(10, 1000),
                    'likes_count' => rand(0, 20),
                    'comments_count' => rand(0, 5),
                    'meta_title' => $title.' | ',
                    'meta_description' => Str::limit('Astuce & Ressource #'.($i + 1), 160),
                    'meta_keywords' => 'astuce,ressource,développement',
                    'published_at' => $publishedAt,
                    'scheduled_for' => null,
                    'expires_at' => null,
                ]);

                $tags = ['Astuces', 'Ressources'];
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

    private function generateExcerpt(string $title): array
    {
        $intros = [
            'Dans cet article, je vous explique',
            'Découvrez comment',
            'Guide complet sur',
            'Tout ce qu’il faut savoir sur',
            'Retour d’expérience sur',
            'Mes conseils pour',
        ];
        $intro = $intros[array_rand($intros)];
        $subject = str_replace(['Comment ', 'Pourquoi ', 'Guide ', 'Les '], '', $title);
        $subject = strtolower($subject);

        $text = $intro.' '.$subject.'. Un contenu riche et pratique pour les développeurs web d’aujourd’hui.';

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

    private function generateLongContent(string $themeKey): array
    {
        $nodes = [];
        $numParagraphs = rand(8, 15);

        $leadTexts = [
            'laravel' => 'Laravel continue de s’imposer comme le framework PHP de choix pour les développeurs web exigeants.',
            'livewire' => 'Livewire simplifie la création d’interfaces dynamiques sans quitter le confort de Laravel.',
            'react-inertia' => 'L’association de React et Inertia offre une expérience de développement moderne et réactive.',
            'filament' => 'FilamentPHP révolutionne la création de panneaux d’administration avec une élégance inégalée.',
            'tailwind' => 'Tailwind CSS permet de créer des interfaces élégantes et maintenables sans effort.',
            'alpine' => 'Alpine.js apporte la réactivité nécessaire à vos composants sans la lourdeur d’un framework complet.',
            'dev-web' => 'Le développement web évolue constamment, et rester à jour est essentiel pour tout professionnel.',
            'carriere' => 'Réussir sa carrière de développeur demande bien plus que des compétences techniques.',
            'projets' => 'Chaque projet est une occasion d’apprendre et de repousser les limites de ses connaissances.',
        ];

        $nodes[] = [
            'type' => 'paragraph',
            'attrs' => ['class' => 'lead'],
            'content' => [
                ['type' => 'text', 'text' => $leadTexts[$themeKey] ?? $leadTexts['dev-web']],
            ],
        ];

        for ($i = 0; $i < $numParagraphs; $i++) {
            if ($i % 3 === 0 && $i > 0) {
                $headings = ['Contexte', 'Mise en pratique', 'Résultats', 'Leçons apprises', 'Perspectives', 'Conseils', 'Pour aller plus loin'];
                $nodes[] = [
                    'type' => 'heading',
                    'attrs' => ['level' => 2],
                    'content' => [
                        ['type' => 'text', 'text' => $headings[$i % count($headings)]],
                    ],
                ];
            }

            if ($i % 5 === 0) {
                $listItems = [];
                for ($j = 0; $j < rand(3, 6); $j++) {
                    $listItems[] = [
                        'type' => 'listItem',
                        'content' => [
                            [
                                'type' => 'paragraph',
                                'content' => [
                                    ['type' => 'text', 'text' => 'Point clé n°'.($j + 1).' sur '.$themeKey],
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

            $paragraphs = [
                'J’ai pu constater que cette approche améliore significativement la qualité du code et la productivité de l’équipe.',
                'Les retours de la communauté confirment l’efficacité de cette méthode, notamment sur des projets de grande envergure.',
                'Une documentation claire et des exemples concrets facilitent la prise en main, même pour les débutants.',
                'N’oubliez pas de tester vos composants de manière isolée, cela vous évitera bien des surprises en production.',
                'L’écosystème Laravel (Forge, Vapor, Envoyer) simplifie le déploiement et la maintenance des applications modernes.',
            ];
            $nodes[] = [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => $paragraphs[$i % count($paragraphs)]],
                ],
            ];

            if ($i % 7 === 0) {
                $quotes = [
                    '“Ce framework a changé ma façon de développer.” — Un développeur passionné',
                    '“Grâce à ces astuces, j’ai divisé mon temps de développement par deux.” — Freelance expérimenté',
                    '“La communauté est incroyablement active et solidaire.” — Contributeur open source',
                ];
                $nodes[] = [
                    'type' => 'blockquote',
                    'content' => [
                        [
                            'type' => 'paragraph',
                            'content' => [
                                ['type' => 'text', 'text' => $quotes[array_rand($quotes)]],
                            ],
                        ],
                    ],
                ];
            }
        }

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
                ['type' => 'text', 'text' => 'J’espère que cet article vous aidera dans vos projets. N’hésitez pas à partager vos retours en commentaire !'],
            ],
        ];

        return [
            'type' => 'doc',
            'content' => $nodes,
        ];
    }

    private function generateRandomContent(): array
    {
        $nodes = [];
        $numParagraphs = rand(5, 12);

        for ($i = 0; $i < $numParagraphs; $i++) {
            if ($i % 4 === 0 && $i > 0) {
                $nodes[] = [
                    'type' => 'heading',
                    'attrs' => ['level' => 2],
                    'content' => [
                        ['type' => 'text', 'text' => 'Section '.($i / 4 + 1)],
                    ],
                ];
            }

            $nodes[] = [
                'type' => 'paragraph',
                'content' => [
                    ['type' => 'text', 'text' => 'Contenu informatif sur le développement web, les outils modernes et les bonnes pratiques.'],
                ],
            ];
        }

        return [
            'type' => 'doc',
            'content' => $nodes,
        ];
    }
}
