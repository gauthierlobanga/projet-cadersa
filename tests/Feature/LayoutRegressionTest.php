<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

beforeEach(function (): void {
    $this->withoutVite();
});

it('renders the team heading animation with the shared shown state', function () {
    get('/')
        ->assertOk()
        ->assertSee('x-intersect="shown = true"', false)
        ->assertSee(":class=\"{ 'opacity-100 translate-y-0': shown, 'opacity-0 translate-y-6': !shown }\"", false)
        ->assertDontSee('x-intersect="visible = true"', false);
});

it('keeps the authenticated mobile sidebar fixed to the viewport', function () {
    actingAs(User::factory()->create());

    get('/dashboard')
        ->assertOk()
        ->assertSee('h-dvh max-h-dvh overflow-y-auto', false)
        ->assertSee('sticky top-0 z-40', false);
});

it('does not leave the old large copyright spacer in the footer', function () {
    get('/')
        ->assertOk()
        ->assertSee('min-height: 2.75rem;', false)
        ->assertDontSee('min-height: 5rem;', false);
});
