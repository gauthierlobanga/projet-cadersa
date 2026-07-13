<flux:dropdown position="bottom" align="start">
    {{-- Déclencheur --}}
    <button type="button"
        class="group flex items-center gap-2 rounded-xl p-1.5 transition-all duration-200
               hover:bg-zinc-100 hover:shadow-sm dark:hover:bg-zinc-800">
        <flux:avatar
            src="{{ auth()->user()?->avatar_url ?? 'https://ui-avatars.com/api/?name=Anonyme&background=random' }}"
            :name="auth()->user()->name"
            :initials="auth()->user()->initials()"
            size="sm"
            circle
            class="ring-2 ring-transparent transition-all duration-200 group-hover:ring-emerald-400/50"
        />
        <span class="hidden sm:inline text-sm font-medium text-zinc-700 dark:text-zinc-300 truncate max-w-[120px]">
            {{ auth()->user()->name }}
        </span>
        <flux:icon.chevron-down
            variant="micro"
            class="hidden sm:block text-zinc-400 transition-transform duration-200 group-hover:translate-y-0.5 dark:text-zinc-500"
        />
    </button>

    {{-- Contenu du menu --}}
    <flux:menu class="mt-2 w-64">
        {{-- En‑tête --}}
        <div class="flex items-center gap-3 px-4 py-3">
            <flux:avatar
                src="{{ auth()->user()?->avatar_url ?? 'https://ui-avatars.com/api/?name=Anonyme&background=random' }}"
                :name="auth()->user()->name"
                :initials="auth()->user()->initials()"
                size="lg"
                circle
            />
            <div class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-zinc-900 dark:text-white">{{ auth()->user()->name }}</p>
                <p class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</p>
            </div>
        </div>
        <flux:menu.separator />
        <flux:menu.radio.group>
            @if (auth()->user()?->hasRole('super_admin'))
                <flux:menu.item
                    :href="route('filament.admin.pages.dashboard')"
                    icon="shield-check"
                    class="transition-colors duration-150 hover:bg-emerald-50 hover:text-emerald-700 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400"
                >
                    Administration
                </flux:menu.item>
            @endif
            <flux:menu.item
                :href="route('profile.edit')"
                icon="cog"
                wire:navigate
                class="transition-colors duration-150 hover:bg-emerald-50 hover:text-emerald-700 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400"
            >
                Paramètres
            </flux:menu.item>
            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <flux:menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer transition-colors duration-150 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400"
                >
                    Déconnexion
                </flux:menu.item>
            </form>
        </flux:menu.radio.group>
    </flux:menu>
</flux:dropdown>