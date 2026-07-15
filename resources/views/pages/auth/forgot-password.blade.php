<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Mot de passe oublié')" :description="__('Entrez votre adresse e-mail pour recevoir un lien de réinitialisation')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                type="email"
                required
                autofocus
                placeholder="email@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Ou, revenir à') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('la connexion') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
