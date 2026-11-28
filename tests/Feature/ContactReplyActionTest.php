<?php

use App\Mail\ContactReplyMail;
use App\Models\Contact;
use App\Models\ContactReply;
use App\Models\Role;
use App\Models\User;
use App\Services\ContactReplyService;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Mail;

test('sending a contact reply delivers email and marks the conversation as answered', function () {
    Mail::fake();

    $contact = Contact::factory()->create([
        'email' => 'visitor@example.com',
        'sujet' => 'Demande de partenariat',
        'status' => Contact::STATUS_EN_ATTENTE,
    ]);
    $administrator = User::factory()->create();

    $reply = app(ContactReplyService::class)->send(
        contact: $contact,
        user: $administrator,
        subject: 'Re : Demande de partenariat',
        body: 'Bonjour, merci pour votre message. Nous revenons vers vous rapidement.',
        includeOriginal: true,
    );

    Mail::assertSent(ContactReplyMail::class, fn (ContactReplyMail $mail): bool => $mail->hasTo('visitor@example.com')
        && $mail->replySubject === 'Re : Demande de partenariat'
    );

    expect($reply->status)->toBe(ContactReply::STATUS_SENT)
        ->and($reply->recipient_email)->toBe('visitor@example.com')
        ->and($reply->user_id)->toBe($administrator->getKey())
        ->and($reply->sent_at)->not->toBeNull()
        ->and($contact->fresh()->status)->toBe(Contact::STATUS_REPONDU)
        ->and($contact->fresh()->reponse)->toContain('merci pour votre message');
});

test('failed email delivery stays visible in reply history without marking the contact answered', function () {
    Mail::fake();

    $contact = Contact::factory()->create([
        'email' => 'visitor@example.com',
        'status' => Contact::STATUS_EN_ATTENTE,
    ]);
    $administrator = User::factory()->create();

    Mail::shouldReceive('to')
        ->once()
        ->with('visitor@example.com')
        ->andThrow(new RuntimeException('SMTP indisponible'));

    $reply = app(ContactReplyService::class)->send(
        contact: $contact,
        user: $administrator,
        subject: 'Réponse',
        body: 'Voici notre réponse à votre demande.',
        includeOriginal: false,
    );

    expect($reply->fresh()->status)->toBe(ContactReply::STATUS_FAILED)
        ->and($reply->fresh()->failure_reason)->toBe('SMTP indisponible')
        ->and($contact->fresh()->status)->toBe(Contact::STATUS_EN_ATTENTE);
});

test('Filament contacts page renders the email reply action', function () {
    Mail::fake();

    $administrator = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $administrator->assignRole($role);
    $administrator->saveAppAuthenticationSecret('test-mfa-secret');
    Contact::factory()->create();

    Filament::setCurrentPanel('admin');

    $this->actingAs($administrator, 'admin')
        ->get('/admin/contacts')
        ->assertOk()
        ->assertSee('Répondre par e-mail');
});
