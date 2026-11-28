<x-layouts::auth :title="__('Vérification de l’email')">
    @php
        $user = auth()->user();
    @endphp

    <div class="flex flex-col gap-7">
        <div class="text-center">
            <div class="relative mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-700 shadow-sm shadow-emerald-900/5 dark:bg-emerald-900/35 dark:text-emerald-300">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <span class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full border-2 border-white bg-amber-400 text-white dark:border-zinc-900">
                    <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.008M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            </div>

            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-emerald-700 dark:text-emerald-400">{{ __('Sécurisez votre compte') }}</p>
            <h1 class="text-2xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-3xl">
                {{ __('Vérifiez votre boîte mail') }}
            </h1>
            <p class="mx-auto mt-3 max-w-md text-sm leading-6 text-zinc-600 dark:text-zinc-300">
                {{ __('Un lien personnel vous a été envoyé. Confirmez votre adresse pour terminer la création de votre compte et accéder à toutes les fonctionnalités.') }}
            </p>
        </div>

        @if ($user?->email)
            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-800/70">
                <p class="text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">{{ __('E-mail concerné') }}</p>
                <p class="mt-1 break-all text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $user->email }}</p>
            </div>
        @endif

        @if (session('status') === 'verification-link-sent')
            <div role="status" aria-live="polite" class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-200">
                <div class="flex items-start gap-3">
                    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12.75 2.25 2.25 4.5-5.25m5.25 2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <div>
                        <p class="font-semibold">{{ __('Le nouvel e-mail est en route') }}</p>
                        <p class="mt-1 leading-5">{{ __('Consultez votre boîte de réception dans quelques instants et utilisez le dernier lien reçu pour confirmer votre adresse.') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="rounded-2xl border border-zinc-200 bg-white p-5 dark:border-zinc-700 dark:bg-zinc-900/60">
            <h2 class="text-sm font-semibold text-zinc-900 dark:text-white">{{ __('Que faire maintenant ?') }}</h2>
            <ol class="mt-4 space-y-4">
                <li class="flex gap-3">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">1</span>
                    <p class="pt-0.5 text-sm leading-5 text-zinc-600 dark:text-zinc-300">{{ __('Ouvrez le message de vérification envoyé par CADERSA.') }}</p>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">2</span>
                    <p class="pt-0.5 text-sm leading-5 text-zinc-600 dark:text-zinc-300">{{ __('Cliquez sur « Confirmer mon adresse » dans cet e-mail.') }}</p>
                </li>
                <li class="flex gap-3">
                    <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300">3</span>
                    <p class="pt-0.5 text-sm leading-5 text-zinc-600 dark:text-zinc-300">{{ __('Si vous ne le trouvez pas, vérifiez aussi les courriers indésirables ou demandez un nouvel envoi ci-dessous.') }}</p>
                </li>
            </ol>
        </div>

        <div class="flex flex-col items-center gap-4">
            <form method="POST" action="{{ route('verification.send') }}" class="w-full">
                @csrf
                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-3.5 text-sm font-semibold text-white shadow-sm shadow-emerald-950/10 transition duration-200 hover:bg-emerald-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    {{ __('Renvoyer l’e-mail de vérification') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 text-sm font-medium text-zinc-500 transition-colors hover:text-zinc-800 focus-visible:rounded focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-zinc-500 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                    </svg>
                    {{ __('Se déconnecter') }}
                </button>
            </form>
        </div>

        @include('pages.auth._company-footer')
    </div>
</x-layouts::auth>
