<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Response;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $sitemap = Sitemap::create();

        // Pages statiques
        $sitemap->add(Url::create(route('home'))->setPriority(1.0));
        $sitemap->add(Url::create(route('about'))->setPriority(0.8));
        $sitemap->add(Url::create(route('services.index'))->setPriority(0.8));
        $sitemap->add(Url::create(route('projects.index'))->setPriority(0.8));
        $sitemap->add(Url::create(route('posts.index'))->setPriority(0.8));
        $sitemap->add(Url::create(route('formations.index'))->setPriority(0.8));
        $sitemap->add(Url::create(route('contact'))->setPriority(0.6));
        $sitemap->add(Url::create(route('gallery'))->setPriority(0.6));

        // Articles
        foreach (Post::published()->latest()->get() as $post) {
            $sitemap->add($post->toSitemapTag());
        }

        // Projets
        foreach (Project::active()->latest()->get() as $project) {
            $sitemap->add(Url::create(route('projects.show', $project))
                ->setLastModificationDate($project->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                ->setPriority(0.7));
        }

        // Services
        foreach (Service::active()->get() as $service) {
            $sitemap->add(Url::create(route('services.show', $service))
                ->setLastModificationDate($service->updated_at)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7));
        }

        // Formations
        foreach (Formation::published()->latest()->get() as $formation) {
            $sitemap->add($formation->toSitemapTag());
        }

        return $sitemap->toResponse(request());
    }
}
