<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletters,email',
        ]);

        $subscriber = Newsletter::create([
            'email' => $request->email,
            'token_confirmation' => Str::random(60),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'source' => 'formulaire',
        ]);

        // Envoyer l'email de confirmation (à implémenter via Mailable)

        return back()->with('flash', 'Un email de confirmation vous a été envoyé.');
    }

    public function confirm(string $token)
    {
        $subscriber = Newsletter::where('token_confirmation', $token)->firstOrFail();

        $subscriber->update([
            'confirmed_at' => now(),
            'is_active' => true,
            'token_confirmation' => null,
        ]);

        return redirect()->route('home')->with('flash', 'Votre inscription a été confirmée avec succès.');
    }

    public function unsubscribe(string $token)
    {
        $subscriber = Newsletter::where('token_confirmation', $token)->firstOrFail();

        $subscriber->update([
            'is_active' => false,
        ]);

        return redirect()->route('home')->with('flash', 'Vous vous êtes désinscrit de la newsletter.');
    }
}
