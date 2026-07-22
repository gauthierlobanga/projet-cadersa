<x-layouts::auth :title="__('Vérification en deux étapes')">
    <div class="flex flex-col gap-6">
        {{-- Conteneur avec transition --}}
        <div
            class="relative w-full"
            x-cloak
            x-data="twoFactorChallenge(@js($errors->has('recovery_code')))"
        >
            {{-- Titre dynamique --}}
            <div class="text-center mb-6">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-zinc-900 dark:text-white"
                    x-show="!showRecoveryInput">
                    Code d’authentification
                </h1>
                <h1 class="text-xl font-bold text-zinc-900 dark:text-white"
                    x-show="showRecoveryInput">
                    Code de récupération
                </h1>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400"
                    x-show="!showRecoveryInput">
                    Saisissez le code à 6 chiffres généré par votre application d’authentification.
                </p>
                <p class="mt-2 text-sm text-zinc-500 dark:text-zinc-400"
                    x-show="showRecoveryInput">
                    Utilisez l’un de vos codes de secours pour confirmer votre identité.
                </p>
            </div>

            {{-- Formulaire --}}
            <form method="POST" action="{{ route('two-factor.login.store') }}">
                @csrf

                <div class="space-y-5">
                    {{-- Champ OTP --}}
                    <div x-show="!showRecoveryInput">
                        <div class="flex items-center justify-center my-6" x-ref="otp">
                            <flux:otp
                                x-model="code"
                                length="6"
                                name="code"
                                label="Code OTP"
                                label:sr-only
                                class="mx-auto gap-2"
                             />
                        </div>
                        @error('code')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Champ code de récupération --}}
                    <div x-show="showRecoveryInput">
                        <div class="my-6">
                            <flux:input
                                type="text"
                                name="recovery_code"
                                x-ref="recovery_code"
                                x-bind:required="showRecoveryInput"
                                autocomplete="one-time-code"
                                x-model="recovery_code"
                                placeholder="Saisissez votre code de récupération"
                                class="w-full"
                            />
                        </div>
                        @error('recovery_code')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400 text-center">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Bouton principal --}}
                    <flux:button
                        variant="primary"
                        type="submit"
                        class="w-full"
                    >
                        Vérifier
                    </flux:button>
                </div>

                {{-- Lien pour basculer entre les modes --}}
                <div class="mt-6 text-center text-sm text-zinc-500 dark:text-zinc-400">
                    <span class="opacity-70">Vous ne pouvez pas utiliser votre application ?</span><br>
                    <span class="inline font-medium underline cursor-pointer text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300"
                        x-show="!showRecoveryInput"
                        @click="toggleInput()">
                        Utiliser un code de récupération
                    </span>
                    <span class="inline font-medium underline cursor-pointer text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300"
                        x-show="showRecoveryInput"
                        @click="toggleInput()">
                        Utiliser un code d’authentification
                    </span>
                </div>
            </form>
        </div>
    </div>

    {{-- Script Alpine pour le composant (toujours chargé, même sans app.js) --}}
    @once
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('twoFactorChallenge', (initialRecovery = false) => ({
                    showRecoveryInput: Boolean(initialRecovery),
                    code: '',
                    recovery_code: '',

                    init() {
                        if (!this.showRecoveryInput) {
                            this.$nextTick(() => {
                                const input = this.$refs.otp?.querySelector('input');
                                if (input) input.focus();
                            });
                        } else {
                            this.$nextTick(() => {
                                this.$refs.recovery_code?.focus();
                            });
                        }
                    },

                    toggleInput() {
                        this.showRecoveryInput = !this.showRecoveryInput;
                        this.code = '';
                        this.recovery_code = '';
                        this.$nextTick(() => {
                            if (this.showRecoveryInput) {
                                this.$refs.recovery_code?.focus();
                            } else {
                                const input = this.$refs.otp?.querySelector('input');
                                if (input) input.focus();
                            }
                        });
                    }
                }));
            });
        </script>
    @endonce
</x-layouts::auth>
