<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Génère le sitemap XML du site CADERSA';

    public function handle(): int
    {
        $this->info('Génération du sitemap...');

        $sitemap = Sitemap::create();

        // Pages statiques
        $staticPages = [
            ['url' => route('home'), 'priority' => 1.0, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
            ['url' => route('about'), 'priority' => 0.8, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['url' => route('contact'), 'priority' => 0.7, 'frequency' => Url::CHANGE_FREQUENCY_MONTHLY],
            ['url' => route('services.index'), 'priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['url' => route('projects.index'), 'priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            ['url' => route('posts.index'), 'priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
        ];

        foreach ($staticPages as $page) {
            $sitemap->add(
                Url::create($page['url'])
                    ->setChangeFrequency($page['frequency'])
                    ->setPriority($page['priority'])
            );
        }

        // Articles publiés
        Post::published()->latest('published_at')->each(function (Post $post) use ($sitemap) {
            $sitemap->add($post);
        });

        // Projets actifs
        Project::active()->each(function (Project $project) use ($sitemap) {
            $sitemap->add($project);
        });

        // Services actifs
        Service::active()->each(function (Service $service) use ($sitemap) {
            $sitemap->add($service);
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap généré : public/sitemap.xml');

        return self::SUCCESS;
    }
}
