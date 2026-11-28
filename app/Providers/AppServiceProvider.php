<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\Formation;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\User;
use App\Observers\ContactObserver;
use App\Observers\ContentPublicationObserver;
use App\Observers\UserObserver;
use App\Settings\SettingApp;
use Carbon\CarbonImmutable;
use Filament\Notifications\Livewire\Notifications;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\VerticalAlignment;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Spatie\MediaLibrary\MediaCollections\Events\MediaHasBeenAddedEvent;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        Contact::observe(ContactObserver::class);
        User::observe(UserObserver::class);
        Post::observe(ContentPublicationObserver::class);
        Project::observe(ContentPublicationObserver::class);
        Service::observe(ContentPublicationObserver::class);
        Formation::observe(ContentPublicationObserver::class);

        Event::listen(MediaHasBeenAddedEvent::class, function (MediaHasBeenAddedEvent $event): void {
            $post = $event->media->model;

            if ($post instanceof Post && in_array($event->media->collection_name, ['featured', 'gallery'], true)) {
                $post->clearMediaCache();
            }
        });

        VerifyEmail::toMailUsing(function (mixed $notifiable, string $verificationUrl): MailMessage {
            return (new MailMessage)
                ->subject('Confirmez votre adresse e-mail — CADERSA')
                ->view('emails.auth.verify-email', [
                    'user' => $notifiable,
                    'verificationUrl' => $verificationUrl,
                    'expiresIn' => config('auth.verification.expire', 60),
                ])
                ->text('emails.auth.verify-email-text', [
                    'user' => $notifiable,
                    'verificationUrl' => $verificationUrl,
                    'expiresIn' => config('auth.verification.expire', 60),
                    'appName' => config('app.name', 'CADERSA ASBL'),
                ]);
        });

        Model::shouldBeStrict();

        Notifications::alignment(Alignment::Center);
        Notifications::verticalAlignment(VerticalAlignment::Start);

        /**
         * Partage des données globales avec toutes les vues
         */
        View::composer('*', function ($view) {
            $settings = app(SettingApp::class);
            $view->with('settings', $settings);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        if (app()->isProduction()) {
            Vite::useHotFile(storage_path('framework/vite.hot'));
        }

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
