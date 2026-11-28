<?php

use App\Models\Post;
use App\Models\PostBookMark;
use App\Models\PostLike;
use App\Models\Role;
use App\Models\User;

it('renders the about settings page without the legacy section controller', function () {
    $user = User::factory()->create();

    $user->assignRole(Role::findOrCreate('super_admin'));
    $user->saveAppAuthenticationSecret('test-mfa-secret');

    $this->actingAs($user, 'admin')
        ->get('/admin/about-page')
        ->assertOk()
        ->assertSee('fi-section', false)
        ->assertSee('Logo des e-mails')
        ->assertDontSee('filamentSection', false);
});

it('renders the posts resource for a super administrator', function () {
    $user = User::factory()->create();

    $user->assignRole(Role::findOrCreate('super_admin'));
    $user->saveAppAuthenticationSecret('test-mfa-secret');

    $response = $this->actingAs($user, 'admin')->get('/admin/posts/posts');

    $response->assertOk();

    $this->actingAs($user, 'admin')
        ->get('/admin/posts/posts/create')
        ->assertOk();
});

it('renders the post interaction resources for a super administrator', function () {
    $user = User::factory()->create();

    $user->assignRole(Role::findOrCreate('super_admin'));
    $user->saveAppAuthenticationSecret('test-mfa-secret');

    $this->actingAs($user, 'admin')
        ->get('/admin/posts/post-likes')
        ->assertOk();

    $this->actingAs($user, 'admin')
        ->get('/admin/posts/post-book-marks')
        ->assertOk();
});

it('renders interaction resources when their post was soft deleted', function () {
    $user = User::factory()->create();
    $user->assignRole(Role::findOrCreate('super_admin'));
    $user->saveAppAuthenticationSecret('test-mfa-secret');

    $post = Post::factory()->create(['user_id' => $user->id]);
    PostLike::query()->create(['post_id' => $post->id, 'user_id' => $user->id]);
    PostBookMark::query()->create(['post_id' => $post->id, 'user_id' => $user->id]);
    $post->delete();

    $this->actingAs($user, 'admin')
        ->get('/admin/posts/post-likes')
        ->assertOk();

    $this->actingAs($user, 'admin')
        ->get('/admin/posts/post-book-marks')
        ->assertOk();
});
