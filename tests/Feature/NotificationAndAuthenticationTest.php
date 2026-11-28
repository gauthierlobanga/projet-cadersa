<?php

use App\Mail\AdminActivityMail;
use App\Models\Contact;
use App\Models\Formation;
use App\Models\Post;
use App\Models\Project;
use App\Models\Role;
use App\Models\Service;
use App\Models\User;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as GoogleUser;

test('contact messages notify the configured association addresses', function () {
    Mail::fake();
    config(['mail.admin_notification_recipients' => [
        'cadersa.asbl@gmail.com',
        'cadersaasbl@cadersaasbl.com',
    ]]);

    Contact::create([
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'email' => 'jean@example.com',
        'telephone' => '+33 6 12 34 56 78',
        'sujet' => 'Demande de renseignements',
        'message' => 'Bonjour, je souhaite obtenir des renseignements sur vos services.',
        'categorie' => Contact::CATEGORIE_GENERAL,
        'status' => Contact::STATUS_EN_ATTENTE,
        'priorite' => Contact::PRIORITE_MOYENNE,
    ]);

    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Nouveau message de contact'
        && $mail->details['E-mail'] === 'jean@example.com'
        && str_contains($mail->details['Message'], 'renseignements')
        && $mail->hasTo('cadersa.asbl@gmail.com')
        && $mail->hasTo('cadersaasbl@cadersaasbl.com')
    );
});

test('new user accounts notify the association', function () {
    Mail::fake();

    $user = User::factory()->create(['name' => 'Nouveau membre']);

    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Création d’un compte utilisateur'
        && $mail->details['Nom'] === 'Nouveau membre'
        && $mail->details['E-mail'] === $user->email
    );
});

test('publication of each public content type sends one email on the transition to published', function () {
    $owner = User::factory()->create();
    Mail::fake();

    $post = Post::factory()->draft()->create([
        'user_id' => $owner->id,
        'title' => 'Article publié',
        'slug' => 'article-publie',
    ]);
    $project = Project::factory()->create([
        'title' => 'Projet publié',
        'slug' => 'projet-publie',
        'is_active' => false,
    ]);
    $service = Service::factory()->create([
        'title' => 'Service publié',
        'slug' => 'service-publie',
        'is_active' => false,
    ]);
    $formation = Formation::factory()->create([
        'user_id' => $owner->id,
        'title' => 'Formation publiée',
        'slug' => 'formation-publiee',
        'is_active' => false,
        'published_at' => null,
    ]);

    Mail::assertQueuedCount(0);

    $post->update(['status' => Post::STATUS_PUBLISHED, 'published_at' => now()]);
    $project->update(['is_active' => true]);
    $service->update(['is_active' => true]);
    $formation->update(['is_active' => true, 'published_at' => now()]);

    Mail::assertQueuedCount(4);
    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Nouvelle publication : Article'
        && $mail->details['Lien'] === route('posts.show', 'article-publie')
    );
    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Nouvelle publication : Projet'
    );
    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Nouvelle publication : Service'
    );
    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Nouvelle publication : Formation'
    );

    $post->update(['title' => 'Article publié modifié']);
    $project->update(['title' => 'Projet publié modifié']);
    $service->update(['title' => 'Service publié modifié']);
    $formation->update(['title' => 'Formation publiée modifiée']);

    Mail::assertQueuedCount(4);
});

test('Google sign-in creates a verified account and starts a session', function () {
    config([
        'services.google.client_id' => 'google-client-id',
        'services.google.client_secret' => 'google-client-secret',
    ]);

    Socialite::fake('google', GoogleUser::fake([
        'email' => 'google-user@example.com',
        'email_verified' => true,
        'name' => 'Google User',
    ]));
    Mail::fake();

    $response = $this->get(route('auth.google.callback'));

    $response->assertRedirect(route('dashboard'));
    $this->assertAuthenticated();

    $user = User::query()->where('email', 'google-user@example.com')->firstOrFail();
    expect($user->hasVerifiedEmail())->toBeTrue();

    Mail::assertQueued(AdminActivityMail::class, fn (AdminActivityMail $mail): bool => $mail->headline === 'Création d’un compte utilisateur'
        && $mail->details['E-mail'] === 'google-user@example.com'
    );
});

test('Google sign-in rejects an unverified email address', function () {
    Socialite::fake('google', GoogleUser::fake([
        'email' => 'unverified@example.com',
        'email_verified' => false,
    ]));

    $this->get(route('auth.google.callback'))
        ->assertRedirect(route('login'))
        ->assertSessionHasErrors('email');

    $this->assertGuest();
    expect(User::query()->where('email', 'unverified@example.com')->exists())->toBeFalse();
});

test('Google web sign-in does not authenticate the Filament administrator guard', function () {
    config([
        'services.google.client_id' => 'google-client-id',
        'services.google.client_secret' => 'google-client-secret',
    ]);
    Mail::fake();

    $administrator = User::factory()->create(['email' => 'admin@example.com']);
    Role::create(['name' => 'admin', 'guard_name' => 'web']);
    $administrator->assignRole('admin');

    Socialite::fake('google', GoogleUser::fake([
        'email' => $administrator->email,
        'email_verified' => true,
    ]));

    $this->get(route('auth.google.callback'))
        ->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($administrator, 'web');
    expect(Auth::guard('admin')->check())->toBeFalse();

    $this->get(route('filament.admin.pages.dashboard'))
        ->assertRedirect(route('filament.admin.auth.login'));
});

test('Google sign-in is shown when configured and Filament requires app MFA', function () {
    config([
        'services.google.client_id' => 'google-client-id',
        'services.google.client_secret' => 'google-client-secret',
    ]);

    $this->get(route('login'))
        ->assertSuccessful()
        ->assertSee('Continuer avec Google')
        ->assertSee('https://developers.google.com/static/identity/images/g-logo.png', false)
        ->assertSee('Se connecter avec une clé d’accès');

    $adminPanel = Filament::getPanel('admin');

    $this->get(route('filament.admin.auth.login'))->assertSuccessful();

    expect($adminPanel->hasMultiFactorAuthentication())->toBeTrue()
        ->and($adminPanel->isMultiFactorAuthenticationRequired())->toBeTrue()
        ->and($adminPanel->getAuthGuard())->toBe('admin')
        ->and($adminPanel->hasLogin())->toBeTrue()
        ->and(User::factory()->make())->toBeInstanceOf(HasAppAuthentication::class)
        ->and(User::factory()->make())->toBeInstanceOf(HasAppAuthenticationRecovery::class)
        ->and(Route::has('passkey.login-options'))->toBeTrue()
        ->and(Route::has('passkey.login'))->toBeTrue()
        ->and(Route::has('filament.admin.auth.login'))->toBeTrue();

    Mail::fake();
    $user = User::factory()->create();
    $user->saveAppAuthenticationSecret('totp-secret');
    $user->saveAppAuthenticationRecoveryCodes(['recovery-code']);

    expect($user->getAppAuthenticationSecret())->toBe('totp-secret')
        ->and($user->getAppAuthenticationRecoveryCodes())->toBe(['recovery-code'])
        ->and(DB::table('users')->where('id', $user->id)->value('app_authentication_secret'))->not->toBe('totp-secret');
});

test('unknown passkeys explain how to restore passwordless sign-in', function () {
    $passkeyFrontend = file_get_contents(resource_path('js/passkeys.js'));

    expect($passkeyFrontend)
        ->toContain('passkey not recognized')
        ->toContain('Paramètres > Sécurité');
});
