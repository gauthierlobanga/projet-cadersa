<?php

use App\Mail\AdminActivityMail;
use App\Mail\ContactReceivedMail;
use App\Mail\ContactReplyMail;
use App\Mail\WelcomeUserMail;
use App\Models\User;
use App\Settings\AboutSettings;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Storage;

test('email views use the About page logo inline and show CADERSA activities without borders or rounded corners', function () {
    Storage::fake('public');

    $logo = file_get_contents(public_path('images/cadersa/hero-community.png'));
    Storage::disk('public')->put('about/email-logo.png', $logo);

    $aboutSettings = app(AboutSettings::class);
    $aboutSettings->email_logo_url = 'about/email-logo.png';
    $aboutSettings->save();

    $user = User::factory()->create([
        'name' => 'Aline Mbuyi',
        'email' => 'aline@example.com',
    ]);

    $messages = [
        new WelcomeUserMail('Aline Mbuyi', 'aline@example.com', route('login'), true),
        new ContactReceivedMail('Aline Mbuyi', 'aline@example.com', 'Demande d’information', 'Bonjour CADERSA.', 'ABC12345'),
        new ContactReplyMail('Aline Mbuyi', 'aline@example.com', 'Re : Demande', 'Merci pour votre message.', 'Demande', 'Bonjour CADERSA.', true),
        new AdminActivityMail('Nouveau compte', ['Nom' => 'Aline Mbuyi'], route('home')),
        (new VerifyEmail)->toMail($user),
    ];

    foreach ($messages as $message) {
        $html = (string) $message->render();
        preg_match('/<img src="data:image\/png;base64,([^"]+)" alt="Logo CADERSA ASBL"/', $html, $logoMatch);

        expect($html)
            ->toContain('Nos domaines d’action')
            ->toContain('Sécurité alimentaire')
            ->toContain('Eau et assainissement')
            ->not->toContain('border-radius:')
            ->not->toContain('height:7px; background-color:#11845b');

        expect(isset($logoMatch[1]))->toBeTrue();

        expect(base64_decode(preg_replace('/\s+/', '', $logoMatch[1]), true))->toBe($logo);
    }
});
