<?php

namespace App\Livewire;

use App\Models\Newsletter;
use Flux\Flux;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class NewsletterSubscribe extends Component
{
    #[Validate('required|email|unique:newsletters,email', message: 'Veuillez entrer une adresse e-mail valide qui n\'est pas déjà utilisée.', as: 'adresse e-mail')]
    public string $email = '';

    public string $source = 'formulaire';

    public string $origin = 'post_show';

    public bool $subscribed = false;

    /**
     * Handle the newsletter subscription form submission.
     *
     * Validates the input, creates a newsletter record with a confirmation token,
     * resets the email field and sets the subscribed flag to true, then shows a toast.
     */
    public function submit(): void
    {
        $this->validate();

        Newsletter::create([
            'email' => $this->email,
            'token_confirmation' => Str::random(60),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'source' => $this->source,
            'metadata' => ['origin' => $this->origin],
        ]);

        $this->reset('email');
        $this->subscribed = true;

        Flux::toast(
            heading: 'Inscription réussie',
            text: 'Merci ! Vérifiez votre boîte mail pour confirmer votre abonnement.',
            variant: 'success',
        );
    }

    /**
     * Render the Livewire component view.
     *
     * @return View|string
     */
    public function render()
    {
        return view('livewire.newsletter-subscribe');
    }
}
