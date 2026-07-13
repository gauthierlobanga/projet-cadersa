<?php

use App\Models\Post;
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
