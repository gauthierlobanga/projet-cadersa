<?php

use Livewire\Component;
use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use App\Settings\SettingApp;

new #[Layout('layouts::main')] class extends Component {
    #[Validate('required|string|min:2')]
    public string $nom = '';

    #[Validate('required|string|min:2')]
    public string $prenom = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('nullable|string|min:9')]
    public string $telephone = '';

    #[Validate('required|string|in:general,commercial,technique,support,reclamation')]
    public string $categorie = 'general';

    #[Validate('required|string|min:5')]
    public string $sujet = '';

    #[Validate('required|string|min:10|max:5000')]
    public string $message = '';

    public bool $sent = false;

    public string $appName = 'CADERSA';
    public ?string $logoUrl = null;
    public array $socialLinks = [];

    public ?string $phone = null;
    public ?string $secondaryEmail = null;
    public array $addresses = [];

    public function boot(SettingApp $appSettings): void
    {
        $this->appName = $appSettings->name;
        $this->logoUrl = $appSettings->logoUrl();
        $this->socialLinks = $this->buildSocialLinks($appSettings);
        $this->phone = $appSettings->phone;
        $this->email = $appSettings->email;
        $this->secondaryEmail = $appSettings->secondary_email;
        $this->addresses = $appSettings->addresses ?? [];
    }

    protected function buildSocialLinks(SettingApp $settings): array
    {
        $links = [];
        if ($settings->facebook_url) {
            $links['facebook'] = $settings->facebook_url;
        }
        if ($settings->x_url) {
            $links['x'] = $settings->x_url;
        }
        if ($settings->linkedin_url) {
            $links['linkedin'] = $settings->linkedin_url;
        }
        if ($settings->instagram_url) {
            $links['instagram'] = $settings->instagram_url;
        }
        if ($settings->youtube_url) {
            $links['youtube'] = $settings->youtube_url;
        }
        return $links;
    }

    public function with(SettingApp $settings): array
    {
        return [
            'settings' => $settings,
            'categories' => Contact::getCategories(),
            'addresses' => $settings->addresses ?? [],
        ];
    }

    /**
     * Messages de validation personnalisés
     */
    public function messages(): array
    {
        return [
            'nom.required' => 'Le nom est obligatoire.',
            'nom.string' => 'Le nom doit être une chaîne de caractères.',
            'nom.min' => 'Le nom doit contenir au moins 2 caractères.',

            'prenom.required' => 'Le prénom est obligatoire.',
            'prenom.string' => 'Le prénom doit être une chaîne de caractères.',
            'prenom.min' => 'Le prénom doit contenir au moins 2 caractères.',

            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez saisir une adresse email valide.',

            'telephone.string' => 'Le numéro de téléphone doit être une chaîne de caractères.',
            'telephone.min' => 'Le numéro de téléphone doit contenir au moins 9 caractères.',

            'categorie.required' => 'Veuillez sélectionner une catégorie.',
            'categorie.in' => 'La catégorie sélectionnée n\'est pas valide.',

            'sujet.required' => 'Le sujet est obligatoire.',
            'sujet.string' => 'Le sujet doit être une chaîne de caractères.',
            'sujet.min' => 'Le sujet doit contenir au moins 5 caractères.',

            'message.required' => 'Le message est obligatoire.',
            'message.string' => 'Le message doit être une chaîne de caractères.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'message.max' => 'Le message ne peut pas dépasser 5000 caractères.',
        ];
    }

    public function submit()
    {
        $this->validate();

        Contact::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'telephone' => $this->telephone,
            'categorie' => $this->categorie,
            'sujet' => $this->sujet,
            'message' => $this->message,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->reset(['nom', 'prenom', 'email', 'telephone', 'categorie', 'sujet', 'message']);
        $this->sent = true;
    }

    public function getCategoryIcon(string $category): string
    {
        return match ($category) {
            'general' => '',
            'commercial' => '',
            'technique' => '',
            'support' => '',
            'reclamation' => '',
            default => '',
        };
    }
};
?>

<div>
    {{-- ==================== HERO CONTACT ==================== --}}
    <section
        class="border-b border-zinc-200 bg-linear-to-br from-white via-zinc-50 to-emerald-50/30 px-4 py-16 dark:border-zinc-800 dark:from-zinc-900 dark:via-zinc-950 dark:to-emerald-950/20">
        <div class="relative mx-auto max-w-7xl text-center">
            {{-- Ambiance lumineuse de fond --}}
            <div class="pointer-events-none absolute inset-0 z-0">
                <div
                    class="absolute -top-40 right-0 h-150 w-150 rounded-full bg-linear-to-br from-emerald-200/20 to-teal-100/0 blur-3xl dark:from-emerald-500/5 dark:to-transparent">
                </div>
                <div
                    class="absolute -bottom-20 -left-20 h-125 w-125 rounded-full bg-linear-to-tr from-zinc-200/40 to-emerald-100/0 blur-3xl dark:from-zinc-900/50 dark:to-transparent">
                </div>
                <div
                    class="absolute inset-0 bg-[linear-gradient(to_right,#8080800a_1px,transparent_1px),linear-gradient(to_bottom,#8080800a_1px,transparent_1px)] bg-size-[14px_24px] mask-[radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)]">
                </div>
            </div>

            <div class="relative">
                <div x-cloak x-data="cspState" x-intersect.once="shown = true">
                    {{-- Badge --}}
                    <span
                        class="inline-flex items-center gap-2 border border-emerald-500/20 bg-emerald-500/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600 transition-all duration-700 ease-[cubic-bezier(0.16,1,0.3,1)] dark:text-emerald-400"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'">
                        <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 16.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        Nous contacter
                    </span>

                    {{-- Titre --}}
                    <h1
                        class="mt-6 text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-6xl transition-all duration-1000 delay-100 ease-[cubic-bezier(0.16,1,0.3,1)]"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Parlons de votre <span
                            class="bg-linear-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">projet</span>
                    </h1>

                    {{-- Description --}}
                    <p class="mx-auto mt-4 transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)] max-w-2xl text-lg text-zinc-600 dark:text-zinc-400"
                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                        Notre équipe est disponible pour répondre à toutes vos questions et vous accompagner dans vos
                        projets de développement rural.
                    </p>
                    {{-- Coordonnées rapides --}}
                    @if ($phone || $email || $secondaryEmail)
                        <div class="mt-6 flex flex-wrap justify-center gap-x-6 gap-y-2 text-sm">
                            @if ($phone)
                                <a href="tel:{{ $phone }}"
                                    class="flex transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)] items-center gap-2 text-zinc-600 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400"
                                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 16.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    {{ $phone }}
                                </a>
                            @endif
                            @if ($email)
                                <a href="mailto:{{ $email }}"
                                    class="flex transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)] items-center gap-2 text-zinc-600 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400"
                                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $email }}
                                </a>
                            @endif
                            @if ($secondaryEmail)
                                <a href="mailto:{{ $secondaryEmail }}"
                                    class="flex transition-all duration-1000 delay-200 ease-[cubic-bezier(0.16,1,0.3,1)] items-center gap-2 text-zinc-600 hover:text-emerald-600 dark:text-zinc-400 dark:hover:text-emerald-400"
                                    :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $secondaryEmail }}
                                </a>
                            @endif
                        </div>
                    @endif
                </div>


                {{-- ===== ADRESSES AVEC BORDURE SUBTILE ===== --}}
                @if (!empty($this->addresses))
                    <div class="mt-10">
                        {{-- Titre "Nos bureaux" --}}
                        <h3
                            class="mb-4 inline-flex items-center gap-2 text-sm font-medium uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Nos bureaux
                        </h3>

                        {{-- Grille 4 colonnes --}}
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            @foreach ($this->addresses as $addr)
                                <div
                                    class="group flex items-start gap-4 border border-zinc-200/70 p-4 transition-colors hover:border-emerald-300 dark:border-zinc-800/70 dark:hover:border-emerald-700">
                                    <div
                                        class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center border border-zinc-300 bg-zinc-50 text-emerald-600 transition-colors group-hover:border-emerald-400 group-hover:bg-emerald-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-emerald-400 dark:group-hover:border-emerald-600 dark:group-hover:bg-emerald-950/30">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">
                                            {{ $addr['label'] }}</h4>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $addr['address'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    {{-- ==================== MAIN CONTENT ==================== --}}
    <section class="border-b border-zinc-200 bg-white px-4 py-16 dark:border-zinc-800 dark:bg-zinc-950">
        <div class="mx-auto max-w-7xl">
            <div class="grid gap-12 lg:grid-cols-[1fr_1.2fr]">

                {{-- GAUCHE : Engagements --}}
                <div x-data="cspState" x-intersect="visible = true"
                    :class="visible ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-4'"
                    style="transition: opacity 0.7s ease-out, transform 0.7s ease-out;">
                    <div class="space-y-8">
                        <div>
                            <span
                                class="inline-flex items-center gap-1.5 border-b-2 border-emerald-500 pb-1 text-sm font-semibold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                                Support
                            </span>
                            <h2 class="mt-4 text-3xl font-bold text-zinc-900 dark:text-white">Un accompagnement sur
                                mesure</h2>
                            <p class="mt-2 text-zinc-600 dark:text-zinc-400">
                                Notre équipe traite chaque demande avec attention. Réponse rapide, suivi personnalisé et
                                solutions adaptées à vos besoins.
                            </p>
                        </div>

                        {{-- Points forts avec SVG modernes --}}
                        <div class="grid gap-4">
                            @php
                                $features = [
                                    [
                                        'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                        'title' => 'Réponse rapide',
                                        'desc' => 'Première réponse en < 24h ouvrables.',
                                    ],
                                    [
                                        'icon' =>
                                            'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                                        'title' => 'Suivi structuré',
                                        'desc' => 'Chaque message est classé et suivi jusqu’à résolution.',
                                    ],
                                    [
                                        'icon' =>
                                            'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z',
                                        'title' => 'Équipe dédiée',
                                        'desc' => 'Commercial, support et technique travaillent ensemble.',
                                    ],
                                    [
                                        'icon' =>
                                            'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',
                                        'title' => 'Confidentialité',
                                        'desc' => 'Vos données sont protégées et jamais partagées.',
                                    ],
                                ];
                            @endphp

                            @foreach ($features as $item)
                                <div
                                    class="flex items-start gap-4 border-b border-zinc-100 pb-4 last:border-0 dark:border-zinc-800">
                                    <div
                                        class="mt-1 flex h-10 w-10 shrink-0 items-center justify-center border border-zinc-200 bg-zinc-50 text-emerald-600 dark:border-zinc-700 dark:bg-zinc-900 dark:text-emerald-400">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $item['icon'] }}" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-zinc-900 dark:text-white">{{ $item['title'] }}
                                        </h3>
                                        <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ $item['desc'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Disponibilité --}}
                        <div class="border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-800 dark:bg-zinc-900">
                            <div class="flex items-start gap-3">
                                <svg class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <p class="font-medium text-zinc-900 dark:text-white">Disponibilité</p>
                                    <p class="text-sm text-zinc-600 dark:text-zinc-400">Support technique 7j/7 · Du
                                        lundi au samedi, 8h - 18h</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DROITE : Formulaire --}}
                <div x-data="cspState" x-intersect="visible = true"
                    :class="visible ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'"
                    style="transition: opacity 0.7s ease-out, transform 0.7s ease-out;">
                    <div class="border border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-900">
                        <div
                            class="border-b border-zinc-200 bg-zinc-50 px-6 py-5 dark:border-zinc-800 dark:bg-zinc-900/50">
                            <h2 class="flex items-center gap-2 text-xl font-semibold text-zinc-900 dark:text-white">
                                <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Envoyez-nous un message
                            </h2>
                            <p class="text-sm text-zinc-500 dark:text-zinc-400">Remplissez le formulaire ci-dessous,
                                nous vous répondrons dans les plus brefs délais.</p>
                        </div>

                        <div class="p-6">
                            {{-- Succès --}}
                            <div x-show="$wire.sent" x-transition.opacity.duration.500ms
                                class="flex flex-col items-center justify-center py-12 text-center">
                                <div
                                    class="flex h-16 w-16 items-center justify-center border-2 border-emerald-500 text-emerald-500">
                                    <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="mt-4 text-2xl font-bold text-zinc-900 dark:text-white">Message envoyé !</h3>
                                <p class="mt-2 text-zinc-600 dark:text-zinc-400">Nous avons bien reçu votre message et
                                    vous répondrons rapidement.</p>
                                <button type="button" wire:click="$set('sent', false)"
                                    class="mt-6 border border-zinc-300 bg-white px-6 py-2 text-sm font-medium text-zinc-700 hover:bg-zinc-100 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-300 dark:hover:bg-zinc-700">
                                    Envoyer un autre message
                                </button>
                            </div>

                            {{-- Formulaire --}}
                            <form wire:submit.prevent="submit" class="space-y-5" x-show="!$wire.sent">
                                {{-- Catégories (validation en temps réel) --}}
                                <div>
                                    <label
                                        class="mb-2 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Catégorie</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($categories as $key => $label)
                                            <button type="button"
                                                wire:click="$set('categorie', '{{ $key }}')"
                                                wire:key="cat-{{ $key }}"
                                                aria-pressed="{{ $categorie === $key ? 'true' : 'false' }}"
                                                class="inline-flex items-center gap-1.5 border px-3 py-1.5 text-sm font-medium transition-colors duration-200
                                                {{ $categorie === $key
                                                    ? 'border-emerald-600 bg-emerald-50 text-emerald-700 dark:border-emerald-500 dark:bg-emerald-950/30 dark:text-emerald-300'
                                                    : 'border-zinc-200 bg-white text-zinc-700 hover:border-emerald-300 hover:bg-emerald-50 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 dark:hover:border-emerald-700 dark:hover:bg-zinc-800' }}">
                                                @if ($categorie === $key)
                                                    <svg class="h-3.5 w-3.5 text-emerald-500" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                @endif
                                                {{ $label }}
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('categorie')
                                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nom / Prénom avec validation en temps réel --}}
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="nom"
                                            class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Nom</label>
                                        <input type="text" id="nom" wire:model.live.debounce.300ms="nom"
                                            wire:validate="nom"
                                            class="block w-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-500"
                                            placeholder="Dupont" />
                                        @error('nom')
                                            <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="prenom"
                                            class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Prénom</label>
                                        <input type="text" id="prenom" wire:model.live.debounce.300ms="prenom"
                                            wire:validate="prenom"
                                            class="block w-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-500"
                                            placeholder="Jean" />
                                        @error('prenom')
                                            <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email / Téléphone --}}
                                <div class="grid gap-4 sm:grid-cols-2">
                                    <div>
                                        <label for="email"
                                            class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Email</label>
                                        <input type="email" id="email" wire:model.live.debounce.300ms="email"
                                            wire:validate="email"
                                            class="block w-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-500"
                                            placeholder="jean@exemple.com" />
                                        @error('email')
                                            <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="telephone"
                                            class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Téléphone</label>
                                        <input type="text" id="telephone"
                                            wire:model.live.debounce.300ms="telephone" wire:validate="telephone"
                                            class="block w-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-500"
                                            placeholder="+33 6 12 34 56 78" />
                                        @error('telephone')
                                            <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Sujet --}}
                                <div>
                                    <label for="sujet"
                                        class="mb-1 block text-sm font-medium text-zinc-700 dark:text-zinc-300">Sujet</label>
                                    <input type="text" id="sujet" wire:model.live.debounce.300ms="sujet"
                                        wire:validate="sujet"
                                        class="block w-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-500"
                                        placeholder="Demande de renseignements" />
                                    @error('sujet')
                                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Message --}}
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label for="message"
                                            class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Message</label>
                                        <span class="text-xs text-zinc-400">{{ mb_strlen($message) }}/5000</span>
                                    </div>
                                    <textarea id="message" rows="5" wire:model.live.debounce.300ms="message" wire:validate="message"
                                        class="block w-full border border-zinc-300 bg-white px-3 py-2 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:outline-none dark:border-zinc-700 dark:bg-zinc-900 dark:text-white dark:placeholder:text-zinc-500 dark:focus:border-emerald-500"
                                        placeholder="Décrivez votre demande en détail..."></textarea>
                                    @error('message')
                                        <p class="mt-0.5 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                    <div class="mt-1 h-0.5 w-full bg-zinc-200 dark:bg-zinc-700">
                                        <div class="h-0.5 bg-emerald-500 transition-all duration-300"
                                            style="width: {{ (mb_strlen($message) / 5000) * 100 }}%"></div>
                                    </div>
                                </div>

                                {{-- Indice catégorie --}}
                                <div
                                    class="border border-zinc-200 bg-zinc-50 p-3 text-sm dark:border-zinc-800 dark:bg-zinc-900/50">
                                    <span class="text-zinc-600 dark:text-zinc-400">
                                        @switch($categorie)
                                            @case('general')
                                                Pour une question générale ou un premier contact.
                                            @break

                                            @case('commercial')
                                                Demandez un devis, une présentation ou un accompagnement business.
                                            @break

                                            @case('technique')
                                                Signalez un besoin technique ou une intégration.
                                            @break

                                            @case('support')
                                                Obtenez de l'aide sur un service en cours.
                                            @break

                                            @case('reclamation')
                                                Partagez une insatisfaction pour un traitement prioritaire.
                                            @break
                                        @endswitch
                                    </span>
                                </div>

                                <flux:button variant="primary" type="submit" wire:loading.attr="disabled"
                                    class="w-full border border-emerald-600 bg-emerald-600 px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-emerald-700 dark:border-emerald-500 dark:bg-emerald-500 dark:hover:bg-emerald-600">
                                    Envoyer le message
                                </flux:button>
                                <p class="text-center text-xs text-zinc-400">Vos données sont traitées avec la plus
                                    grande confidentialité.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ==================== FAQ ==================== --}}
    <livewire:faq.faq />
</div>

