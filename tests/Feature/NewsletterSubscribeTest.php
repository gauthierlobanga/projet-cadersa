<?php

use App\Livewire\NewsletterSubscribe;
use Livewire\Livewire;

it('subscribes a new email through the newsletter sidebar component', function () {
    Livewire::test(NewsletterSubscribe::class)
        ->set('email', 'abonne@example.com')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSee('Merci ! Vérifiez votre boîte mail pour confirmer votre abonnement.');

    $this->assertDatabaseHas('newsletters', [
        'email' => 'abonne@example.com',
        'source' => 'formulaire',
    ]);
});

it('validates the newsletter email address before subscribing', function () {
    Livewire::test(NewsletterSubscribe::class)
        ->set('email', '')
        ->call('submit')
        ->assertHasErrors(['email']);
});
