<?php

use App\Models\Formation;
use App\Models\Post;
use App\Models\Project;

use function Pest\Laravel\get;

beforeEach(function (): void {
    $this->withoutVite();
});

it('searches active projects through Scout', function (): void {
    $matchingProject = Project::factory()->create([
        'title' => 'Projet d\'accès à l\'eau potable',
        'location' => 'Kisangani',
        'is_active' => true,
    ]);

    $otherProject = Project::factory()->create([
        'title' => 'Projet de reboisement communautaire',
        'is_active' => true,
    ]);

    get('/projects?q=Kisangani')
        ->assertOk()
        ->assertSee($matchingProject->title)
        ->assertDontSee($otherProject->title);
});

it('searches published posts through Scout', function (): void {
    $matchingPost = Post::factory()->published()->create([
        'title' => 'Guide pratique de l\'agroécologie',
        'content' => 'Les techniques agroécologiques améliorent les sols.',
    ]);

    $otherPost = Post::factory()->published()->create([
        'title' => 'Actualités de la communauté',
        'content' => 'Les dernières nouvelles de notre réseau.',
    ]);

    get('/posts?q=agroécologie')
        ->assertOk()
        ->assertSee($matchingPost->title)
        ->assertDontSee($otherPost->title);
});

it('searches active formations through Scout', function (): void {
    $matchingFormation = Formation::factory()->create([
        'title' => 'Formation en gestion de projet',
        'subtitle' => 'Méthodes et outils pour les équipes',
        'is_active' => true,
    ]);

    $otherFormation = Formation::factory()->create([
        'title' => 'Formation en communication',
        'is_active' => true,
    ]);

    get('/formations?q=gestion%20de%20projet')
        ->assertOk()
        ->assertSee($matchingFormation->title)
        ->assertDontSee($otherFormation->title);
});
