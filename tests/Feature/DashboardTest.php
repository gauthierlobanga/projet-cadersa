<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertOk()
        ->assertSee('from-white via-emerald-50 to-emerald-100', false)
        ->assertSee('dark:from-slate-950 dark:via-emerald-950 dark:to-emerald-800', false)
        ->assertSee('text-slate-600 dark:text-emerald-50/85', false);
});
