<?php

use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

test('saving a featured image persists it and clears cached missing image urls', function () {
    Storage::fake('public');
    Mail::fake();

    $post = Post::factory()->create();

    expect($post->getFeaturedImageUrl('card'))->toBeNull();

    $uploadedImage = UploadedFile::fake()->image('image-principale.jpg', 1600, 900);
    $media = $post->addMedia($uploadedImage->getRealPath())
        ->usingFileName('image-principale.jpg')
        ->toMediaCollection('featured');

    $featuredImageUrl = $post->fresh()->getFeaturedImageUrl('card');

    Storage::disk('public')->assertExists($media->getPathRelativeToRoot());

    expect($media->collection_name)->toBe('featured')
        ->and($featuredImageUrl)->not->toBeNull()
        ->and($featuredImageUrl)->not->toBe('');
});

test('Filament post creation displays the primary image upload prominently', function () {
    Mail::fake();

    $administrator = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $administrator->assignRole($role);
    $administrator->saveAppAuthenticationSecret('test-mfa-secret');
    Filament::setCurrentPanel('admin');

    $this->actingAs($administrator, 'admin')
        ->get(route('filament.admin.posts.resources.posts.create'))
        ->assertOk()
        ->assertSee('Image principale')
        ->assertSee('Image à la une')
        ->assertSee('10 Mo maximum');
});
