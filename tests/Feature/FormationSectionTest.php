<?php

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;

test('home formation section only shows formation category posts', function () {
    $formationCategory = PostCategory::create([
        'nom' => 'Formation',
        'slug' => 'formation',
        'description' => 'Catégorie de formation',
        'color' => '#10b981',
        'metadata' => [],
        'ordre' => 10,
        'est_active' => true,
        'est_visible_dans_menu' => true,
        'meta_title' => 'Formation',
        'meta_description' => 'Articles de formation',
        'meta_keywords' => ['formation'],
    ]);

    $otherCategory = PostCategory::create([
        'nom' => 'Partenariats',
        'slug' => 'partenariats',
        'description' => 'Catégorie de partenariat',
        'color' => '#0ea5e9',
        'metadata' => [],
        'ordre' => 20,
        'est_active' => true,
        'est_visible_dans_menu' => true,
        'meta_title' => 'Partenariats',
        'meta_description' => 'Articles de partenariat',
        'meta_keywords' => ['partenariat'],
    ]);

    $author = User::factory()->create();

    $formationPosts = collect([
        ['title' => 'Formation Post One', 'slug' => 'formation-post-one', 'published_at' => now()->subDays(0)],
        ['title' => 'Formation Post Two', 'slug' => 'formation-post-two', 'published_at' => now()->subDays(1)],
        ['title' => 'Formation Post Three', 'slug' => 'formation-post-three', 'published_at' => now()->subDays(2)],
    ])->map(function ($postData) use ($author, $formationCategory) {
        $post = Post::factory()->published()->create(array_merge([
            'user_id' => $author->id,
            'content' => 'Contenu de formation',
        ], $postData));
        $post->categories()->attach($formationCategory->id);

        return $post;
    });

    $otherPost = Post::factory()->published()->create([
        'user_id' => $author->id,
        'title' => 'Other Category Post',
        'slug' => 'other-category-post',
        'content' => 'Contenu non formation',
        'published_at' => now()->subDays(10),
    ]);
    $otherPost->categories()->attach($otherCategory->id);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Plongez au cœur de nos');
    $response->assertSee('Formation Post One');
    $response->assertSee('Formation Post Two');
    $response->assertSee('Formation Post Three');
    $response->assertDontSee('Other Category Post');
});
