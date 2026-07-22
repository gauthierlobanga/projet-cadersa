<?php

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;

it('can be created', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create([
        'title' => 'Test Post',
        'user_id' => $user->id,
    ]);

    expect($post)->toBeInstanceOf(Post::class)
        ->and($post->title)->toBe('Test Post')
        ->and($post->slug)->not->toBeEmpty();
});

it('belongs to a user', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);

    expect($post->user)->toBeInstanceOf(User::class)
        ->and($post->user->id)->toBe($user->id);
});

it('has a renderRichContent method', function () {
    $post = Post::factory()->create();

    expect(method_exists($post, 'renderRichContent'))->toBeTrue();
    expect($post->renderRichContent('content'))->toBeString();
});

it('can sync a primary category for a post', function () {
    $user = User::factory()->create();
    $post = Post::factory()->create(['user_id' => $user->id]);
    $categoryA = PostCategory::create(['nom' => 'Actualités', 'slug' => 'actualites']);
    $categoryB = PostCategory::create(['nom' => 'Événements', 'slug' => 'evenements']);

    $post->categories()->attach([
        $categoryA->id => ['est_principale' => false, 'ordre' => 1],
        $categoryB->id => ['est_principale' => false, 'ordre' => 2],
    ]);

    expect($post->refresh()->getPrimaryCategoryId())->toBeNull();

    $post->syncPrimaryCategory($categoryB->id);

    expect($post->refresh()->getPrimaryCategoryId())->toBe($categoryB->id);

    $post->syncPrimaryCategory(null);

    expect($post->refresh()->getPrimaryCategoryId())->toBeNull();
});
