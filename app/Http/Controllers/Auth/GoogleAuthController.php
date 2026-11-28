<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SiteAnalyticsTracker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        if (blank(config('services.google.client_id')) || blank(config('services.google.client_secret'))) {
            return redirect()->route('login')->withErrors([
                'email' => 'La connexion Google n’est pas encore configurée.',
            ]);
        }

        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            Log::warning('Google sign-in failed.', ['exception' => $exception::class]);

            return redirect()->route('login')->withErrors([
                'email' => 'La connexion avec Google a échoué. Veuillez réessayer.',
            ]);
        }

        $email = mb_strtolower(trim((string) $googleUser->getEmail()));
        $googleEmailIsVerified = filter_var(
            $googleUser->getRaw()['email_verified'] ?? $googleUser->getRaw()['verified_email'] ?? false,
            FILTER_VALIDATE_BOOLEAN,
        );

        if ($email === '' || ! filter_var($email, FILTER_VALIDATE_EMAIL) || ! $googleEmailIsVerified) {
            return redirect()->route('login')->withErrors([
                'email' => 'Google doit confirmer votre adresse e-mail pour vous connecter.',
            ]);
        }

        $user = User::query()->where('email', $email)->first();

        if (! $user) {
            $user = new User;
            $user->name = $googleUser->getName() ?: $googleUser->getNickname() ?: $email;
            $user->email = $email;
            $user->password = Str::random(64);
            $user->email_verified_at = now();
            $user->email_verified = true;
            $user->save();

            app(SiteAnalyticsTracker::class)->completeConversion('registration', $request);
        } elseif (! $user->hasVerifiedEmail()) {
            $user->forceFill([
                'email_verified_at' => now(),
                'email_verified' => true,
            ])->save();
        }

        if (! $user->is_active) {
            return redirect()->route('login')->withErrors([
                'email' => 'Ce compte est désactivé. Contactez CADERSA pour obtenir de l’aide.',
            ]);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }
}
