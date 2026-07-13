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

    // Nouvelles propriétés
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
    {{-- ==================== HERO ==================== --}}
    @if ($phone || $email || $secondaryEmail || !empty($addresses))
        <section
            class="relative max-w-7xl mx-auto overflow-hidden  bg-linear-to-br px-4 py-20 lg:py-28 from-white via-zinc-50 to-emerald-50/40 p-8  dark:from-zinc-900 dark:via-zinc-900 dark:to-zinc-950">

            {{-- Background --}}
            <div class="pointer-events-none absolute inset-0 opacity-30">
                <div class="absolute -left-20 top-0 h-72 w-72 rounded-full bg-emerald-500 blur-[120px]"></div>
                <div class="absolute right-0 bottom-0 h-64 w-64 rounded-full bg-cyan-500 blur-[120px]"></div>
            </div>

            <div class="relative">

                {{-- Header --}}
                <div class="mb-10">
                    <span
                        class="inline-flex items-center rounded-full border border-emerald-500/20 bg-emerald-500/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-emerald-600 dark:text-emerald-400">
                        Nous contacter
                    </span>

                    <h2 class="mt-4 text-3xl font-bold tracking-tight text-zinc-900 dark:text-white">
                        Parlons de votre projet
                    </h2>

                    <p class="mt-3 max-w-2xl text-zinc-600 dark:text-zinc-400">
                        Notre équipe est disponible pour répondre à toutes vos questions
                        et vous accompagner dans vos projets.
                    </p>
                </div>

                <div class="grid gap-8 lg:grid-cols-12">

                    {{-- Contacts --}}
                    <div class="space-y-5 lg:col-span-4" data-animate="enter-from-left-staggered">

                        @if ($phone)
                            <a href="tel:{{ $phone }}"
                                class="group flex items-center gap-5 rounded-2xl border border-zinc-200/60 bg-white/70 p-5 backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900/60">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600 transition group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white">

                                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498A1 1 0 0121 16.72V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm text-zinc-500">Téléphone</p>
                                    <p class="font-semibold text-zinc-900 dark:text-white">
                                        {{ $phone }}
                                    </p>
                                </div>

                            </a>
                        @endif


                        @if ($email)
                            <a href="mailto:{{ $email }}"
                                class="group flex items-center gap-5 rounded-2xl border border-zinc-200/60 bg-white/70 p-5 backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900/60">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-600 transition group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white">

                                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm text-zinc-500">Email</p>
                                    <p class="font-semibold text-zinc-900 dark:text-white">
                                        {{ $email }}
                                    </p>
                                </div>

                            </a>
                        @endif


                        @if ($secondaryEmail)
                            <a href="mailto:{{ $secondaryEmail }}"
                                class="group flex items-center gap-5 rounded-2xl border border-zinc-200/60 bg-white/70 p-5 backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900/60">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-sky-500/10 text-sky-600 transition group-hover:scale-110 group-hover:bg-sky-500 group-hover:text-white">

                                    <svg class="size-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>

                                </div>

                                <div>
                                    <p class="text-sm text-zinc-500">Support</p>
                                    <p class="font-semibold text-zinc-900 dark:text-white">
                                        {{ $secondaryEmail }}
                                    </p>
                                </div>

                            </a>
                        @endif

                    </div>

                    {{-- Offices --}}
                    @if (!empty($addresses))

                        <div class="lg:col-span-8" data-animate="enter-from-right-staggered">

                            <h3 class="mb-6 text-xl font-bold text-zinc-900 dark:text-white">
                                Nos bureaux
                            </h3>

                            <div class="grid gap-6 sm:grid-cols-2">

                                @foreach ($addresses as $addr)
                                    <div
                                        class="group rounded-2xl border border-zinc-200/60 bg-white/70 p-6 backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:border-emerald-500 hover:shadow-xl dark:border-zinc-700 dark:bg-zinc-900/60">

                                        <div
                                            class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white transition">

                                            <svg class="size-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">

                                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />

                                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />

                                            </svg>

                                        </div>

                                        <h4 class="text-lg font-semibold text-zinc-900 dark:text-white">
                                            {{ $addr['label'] }}
                                        </h4>

                                        <p class="mt-3 leading-relaxed text-zinc-600 dark:text-zinc-400">
                                            {{ $addr['address'] }}
                                        </p>

                                    </div>
                                @endforeach

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </section>
    @endif

    {{-- ==================== FORM + INFO ==================== --}}
    <section class="bg-white py-16 lg:py-20 dark:bg-slate-950">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid gap-10 lg:grid-cols-[1fr_1.2fr]">

                {{-- Left column: engagements --}}
                <div x-data="{ visible: false }" x-intersect="visible = true" class="space-y-8"
                    :class="{ 'opacity-100 translate-x-0': visible, 'opacity-0 -translate-x-4': !visible }"
                    style="transition: opacity 0.7s, transform 0.7s;">
                    <div class="space-y-4">
                        <flux:badge variant="outline"
                            class="gap-1 border-emerald-200 text-emerald-700 dark:border-emerald-800 dark:text-emerald-300">
                            🎧 Support Premium
                        </flux:badge>
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Un accompagnement sur mesure</h2>
                        <p class="text-slate-600 dark:text-slate-400">
                            Notre équipe traite chaque demande avec attention. Réponse rapide, suivi personnalisé et
                            solutions adaptées à vos besoins.
                        </p>
                    </div>

                    <div class="grid gap-4">
                        @foreach ([['icon' => '⏱️', 'title' => 'Réponse rapide', 'desc' => 'Première réponse en < 24h ouvrables.'], ['icon' => '🛡️', 'title' => 'Suivi structuré', 'desc' => 'Chaque message est classé et suivi jusqu’à résolution.'], ['icon' => '👥', 'title' => 'Équipe dédiée', 'desc' => 'Commercial, support et technique travaillent ensemble.'], ['icon' => '🔒', 'title' => 'Confidentialité', 'desc' => 'Vos données sont protégées et jamais partagées.']] as $item)
                            <div
                                class="rounded-2xl border border-slate-200 bg-white/60 backdrop-blur-sm p-5 flex gap-4 dark:border-slate-800 dark:bg-slate-900/60">
                                <div
                                    class="rounded-full bg-emerald-100 p-2.5 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 text-xl">
                                    {{ $item['icon'] }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-slate-900 dark:text-white">{{ $item['title'] }}</h3>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $item['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Availability card --}}
                    <div
                        class="rounded-2xl border border-emerald-200 bg-emerald-50 p-5 dark:border-emerald-800 dark:bg-emerald-900/20">
                        <div class="flex items-center gap-3">
                            <span class="text-emerald-600 dark:text-emerald-400">🕒</span>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">Disponibilité</p>
                                <p class="text-sm text-slate-500 dark:text-slate-400">
                                    Support technique 7j/7 · Du lundi au samedi, 8h - 18h
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right column: Form --}}
                <div x-data="{ visible: false }" x-intersect="visible = true" class="transition-all duration-700"
                    :class="{ 'opacity-100 translate-x-0': visible, 'opacity-0 translate-x-4': !visible }">
                    <div
                        class="overflow-hidden rounded-3xl border border-slate-200 shadow-xl dark:border-slate-800 dark:bg-slate-900">
                        <div
                            class="border-b border-slate-200 bg-slate-50 px-6 py-5 dark:border-slate-800 dark:bg-slate-900/50">
                            <h2 class="flex items-center gap-2 text-xl font-semibold text-slate-900 dark:text-white">
                                Envoyez-nous un message
                            </h2>
                            <p class="text-sm text-slate-500 dark:text-slate-400">
                                Remplissez le formulaire ci-dessous, nous vous répondrons dans les plus brefs délais.
                            </p>
                        </div>
                        <div class="p-6">
                            {{-- Success state --}}
                            <div x-show="$wire.sent" x-transition.opacity.duration.500ms
                                class="flex flex-col items-center justify-center py-12 text-center">
                                <div
                                    class="w-20 h-20 bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center text-emerald-500 mb-6">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Message envoyé !
                                </h3>
                                <p class="text-slate-600 dark:text-slate-400">Nous avons bien reçu votre message et
                                    nous vous répondrons rapidement.</p>
                                <button type="button" wire:click="$set('sent', false)"
                                    class="mt-8 px-6 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-medium rounded-xl transition-colors">
                                    Envoyer un autre message
                                </button>
                            </div>

                            {{-- Form --}}
                            <form wire:submit.prevent="submit" class="space-y-6" x-show="!$wire.sent"
                                x-transition.opacity.duration.300ms>
                                {{-- Catégories --}}
                                <div>
                                    <label
                                        class="text-sm font-medium text-slate-700 dark:text-slate-300 mb-2 block">Catégorie</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($categories as $key => $label)
                                            <button type="button"
                                                wire:click="$set('categorie', '{{ $key }}')"
                                                aria-pressed="{{ $categorie === $key ? 'true' : 'false' }}"
                                                class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-medium transition-all duration-200
                                                {{ $categorie === $key
                                                    ? 'border-transparent bg-emerald-600 text-white shadow-sm dark:bg-emerald-500'
                                                    : 'border-slate-200 bg-white text-slate-700 hover:border-emerald-300 hover:bg-emerald-50 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-emerald-700 dark:hover:bg-slate-800' }}">
                                                <span aria-hidden="true">{{ $this->getCategoryIcon($key) }}</span>
                                                <span>{{ $label }}</span>
                                                @if ($categorie === $key)
                                                    <svg class="w-3.5 h-3.5 text-emerald-200" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                    @error('categorie')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Nom & Prénom --}}
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <flux:field>
                                        <flux:label>Nom</flux:label>
                                        <flux:input wire:model="nom" placeholder="Dupont" />
                                        <flux:error name="nom" />
                                    </flux:field>
                                    <flux:field>
                                        <flux:label>Prénom</flux:label>
                                        <flux:input wire:model="prenom" placeholder="Jean" />
                                        <flux:error name="prenom" />
                                    </flux:field>
                                </div>

                                {{-- Email & Téléphone --}}
                                <div class="grid gap-5 sm:grid-cols-2">
                                    <flux:field>
                                        <flux:label>Email</flux:label>
                                        <flux:input type="email" wire:model="email"
                                            placeholder="jean@exemple.com" />
                                        <flux:error name="email" />
                                    </flux:field>
                                    <flux:field>
                                        <flux:label>Téléphone</flux:label>
                                        <flux:input wire:model="telephone" placeholder="+33 6 12 34 56 78" />
                                        <flux:error name="telephone" />
                                    </flux:field>
                                </div>

                                {{-- Sujet --}}
                                <flux:field>
                                    <flux:label>Sujet</flux:label>
                                    <flux:input wire:model="sujet" placeholder="Demande de renseignements" />
                                    <flux:error name="sujet" />
                                </flux:field>

                                {{-- Message --}}
                                <flux:field>
                                    <div class="flex justify-between items-center">
                                        <flux:label>Message</flux:label>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-slate-400">{{ mb_strlen($message) }}/5000</span>
                                            <div class="w-24 h-1 bg-slate-200 rounded-full dark:bg-slate-700">
                                                <div class="h-full bg-emerald-500 rounded-full transition-all duration-300"
                                                    style="width: {{ (mb_strlen($message) / 5000) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <flux:textarea wire:model="message" rows="7"
                                        placeholder="Décrivez votre demande en détail..." class="min-h-40" />
                                    <flux:error name="message" />
                                </flux:field>

                                {{-- Catégorie hint --}}
                                <div
                                    class="flex items-center gap-3 rounded-lg bg-slate-100 p-3 text-sm dark:bg-slate-800">
                                    <span aria-hidden="true">{{ $this->getCategoryIcon($categorie) }}</span>
                                    <span class="text-slate-600 dark:text-slate-300">
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

                                <hr class="dark:border-slate-700">

                                <flux:button type="submit" variant="primary"
                                    class="w-full h-12 text-base font-semibold bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-200 dark:shadow-emerald-900/30 transition-all"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.remove>Envoyer le message</span>
                                    <span wire:loading class="flex items-center justify-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        Envoi en cours...
                                    </span>
                                </flux:button>
                                <p class="text-center text-xs text-slate-400">Vos données sont traitées avec la
                                    plus grande confidentialité.</p>
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
