<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Cookie;

new class extends Component
{
    public bool $showBanner = true;
    public bool $showPreferences = false;

    public array $consents = [
        'necessary' => true,
        'analytics' => false,
        'marketing' => false,
    ];

    public function mount()
    {
        $cookie = request()->cookie('cookie_consent');
        
        if ($cookie) {
            $this->showBanner = false;
            $savedConsents = json_decode($cookie, true);
            if (is_array($savedConsents)) {
                $this->consents = array_merge($this->consents, $savedConsents);
            }
        }
    }

    public function acceptAll()
    {
        $this->consents['analytics'] = true;
        $this->consents['marketing'] = true;
        $this->saveCookie();
        $this->showBanner = false;
        $this->showPreferences = false;
        $this->dispatch('cookie-consent-updated', consents: $this->consents);
    }

    public function rejectAll()
    {
        $this->consents['analytics'] = false;
        $this->consents['marketing'] = false;
        $this->saveCookie();
        $this->showBanner = false;
        $this->showPreferences = false;
        $this->dispatch('cookie-consent-updated', consents: $this->consents);
    }

    public function savePreferences()
    {
        $this->saveCookie();
        $this->showBanner = false;
        $this->showPreferences = false;
        $this->dispatch('cookie-consent-updated', consents: $this->consents);
    }

    public function openPreferences()
    {
        $this->showPreferences = true;
    }

    public function closePreferences()
    {
        $this->showPreferences = false;
    }

    private function saveCookie()
    {
        $this->consents['necessary'] = true;
        Cookie::queue('cookie_consent', json_encode($this->consents), 60 * 24 * 365);
    }
};
?>

<div>
    {{-- ===== BANNER ===== --}}
    @if ($showBanner)
        <div x-ref="banner" class="fixed bottom-0 left-0 right-0 z-100 p-4 sm:p-6 pointer-events-none flex justify-center items-end h-0 overflow-visible">
            <div class="pointer-events-auto w-full max-w-6xl bg-white/90 dark:bg-zinc-950/90 backdrop-blur-2xl border border-zinc-200/40 dark:border-zinc-800/40 shadow-2xl shadow-zinc-900/5 dark:shadow-black/50 p-6 md:p-7 flex flex-col lg:flex-row items-center gap-6 ring-1 ring-black/5 dark:ring-white/5 relative overflow-hidden">
                
                {{-- Élément décoratif --}}
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-emerald-500/8 dark:bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>

                {{-- Contenu --}}
                <div class="flex-1 flex gap-4 items-start">
                    <div class="hidden sm:flex shrink-0 w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 items-center justify-center border border-emerald-100/60 dark:border-emerald-500/20">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 22a10 10 0 1 0 0-20 10 10 0 0 0 0 20Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.5 10a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1ZM15.5 12a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1ZM11 16a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 2a4 4 0 0 0 4 4 4 4 0 0 0 4-4" opacity="0.4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 tracking-tight">
                            Votre vie privée nous importe
                        </h3>
                        <p class="mt-1.5 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-2xl">
                            Nous utilisons des cookies pour assurer le bon fonctionnement de notre site, mesurer notre audience et vous offrir une expérience optimale.
                            <a href="{{ route('cookies') }}" class="inline-flex items-center gap-1 text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium hover:underline underline-offset-4 transition-colors">
                                En savoir plus
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        </p>
                    </div>
                </div>
                
                {{-- Boutons --}}
                <div class="flex flex-col sm:flex-row gap-2.5 w-full lg:w-auto shrink-0 mt-1 lg:mt-0 z-10">
                    <flux:button wire:click="openPreferences" variant="subtle" size="sm" class="w-full sm:w-auto font-medium text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800/50">
                        Personnaliser
                    </flux:button>
                    <flux:button wire:click="rejectAll" variant="ghost" size="sm" color="red" class="w-full sm:w-auto font-medium">
                        Refuser tout
                    </flux:button>
                    <flux:button wire:click="acceptAll" variant="primary" size="sm" color="emerald" class="w-full sm:w-auto font-medium">
                        Tout accepter
                    </flux:button>
                </div>
            </div>
        </div>
    @endif

    {{-- ===== MODAL PRÉFÉRENCES ===== --}}
    @if ($showPreferences)
        <div class="fixed inset-0 z-110 flex items-center justify-center p-4 sm:p-6">
            {{-- Backdrop --}}
            <div x-ref="backdrop" class="absolute inset-0 bg-zinc-900/50 dark:bg-black/60 backdrop-blur-sm pointer-events-auto" wire:click="closePreferences"></div>
            
            {{-- Modal --}}
            <div x-ref="modal" class="relative w-full max-w-2xl bg-white dark:bg-zinc-900 border border-zinc-200/60 dark:border-zinc-800/60 shadow-2xl shadow-zinc-900/20 dark:shadow-black/50 overflow-hidden pointer-events-auto flex flex-col max-h-[90vh]">
                
                {{-- Header --}}
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between sticky top-0 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-sm z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center border border-emerald-100/60 dark:border-emerald-500/20">
                            <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-zinc-900 dark:text-white tracking-tight">Préférences des cookies</h2>
                    </div>
                    <button wire:click="closePreferences" class="p-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 text-zinc-500 hover:text-zinc-900 dark:hover:text-zinc-100 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500/50">
                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                {{-- Body --}}
                <div class="p-6 overflow-y-auto flex-1 space-y-4">
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-5">
                        Lorsque vous naviguez sur notre site, des informations peuvent être stockées dans votre navigateur. Vous pouvez choisir de ne pas autoriser certains types de cookies.
                    </p>

                    {{-- Necessary --}}
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-zinc-50/50 dark:bg-zinc-900/30 border border-zinc-200/40 dark:border-zinc-800/40">
                        <div class="flex-1">
                            <div class="flex items-center gap-2.5">
                                <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">Cookies strictement nécessaires</h4>
                                <span class="text-2xs font-bold uppercase tracking-wider bg-zinc-200 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 px-2 py-0.5 rounded-full">Toujours actifs</span>
                            </div>
                            <p class="mt-1.5 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Essentiels au fonctionnement du site. Ils permettent des fonctionnalités de base comme la sécurité et la gestion du réseau.</p>
                        </div>
                        <div class="pt-1 pointer-events-none opacity-60">
                            <flux:switch checked disabled size="sm" />
                        </div>
                    </div>

                    {{-- Analytics --}}
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-zinc-50/50 dark:bg-zinc-900/30 border border-zinc-200/40 dark:border-zinc-800/40 hover:border-emerald-200/60 dark:hover:border-emerald-800/40 transition-colors">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">Cookies analytiques</h4>
                            <p class="mt-1.5 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Nous permettent de mesurer l'audience du site, les pages populaires et le comportement des visiteurs.</p>
                        </div>
                        <div class="pt-1">
                            <flux:switch wire:model="consents.analytics" size="sm" />
                        </div>
                    </div>

                    {{-- Marketing --}}
                    <div class="flex items-start gap-4 p-4 rounded-xl bg-zinc-50/50 dark:bg-zinc-900/30 border border-zinc-200/40 dark:border-zinc-800/40 hover:border-emerald-200/60 dark:hover:border-emerald-800/40 transition-colors">
                        <div class="flex-1">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-white">Cookies marketing</h4>
                            <p class="mt-1.5 text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">Utilisés pour afficher des publicités pertinentes et intéressantes pour l'utilisateur.</p>
                        </div>
                        <div class="pt-1">
                            <flux:switch wire:model="consents.marketing" size="sm" />
                        </div>
                    </div>
                </div>
                
                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-zinc-100 dark:border-zinc-800 bg-white dark:bg-zinc-900 flex flex-col sm:flex-row justify-end gap-2.5 sticky bottom-0">
                    <flux:button wire:click="rejectAll" variant="ghost" size="sm" color="red" class="font-medium">
                        Tout refuser
                    </flux:button>
                    <flux:button wire:click="acceptAll" variant="primary" size="sm" color="emerald" class="font-medium">
                        Tout accepter
                    </flux:button>
                    <flux:button wire:click="savePreferences" variant="primary" size="sm" color="zinc" class="font-medium">
                        Enregistrer mes choix
                    </flux:button>
                </div>
            </div>
        </div>
    @endif
</div>
