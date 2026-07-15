<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen flex flex-col bg-white dark:bg-zinc-900">
    {{-- ========== HEADER ========== --}}
    <flux:header container class="border-b h-20 border-zinc-100 bg-white dark:border-zinc-800 dark:bg-zinc-950">
        {{-- Toggle sidebar mobile --}}
        <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

        {{-- Logo --}}
        <a href="{{ route('home') }}" wire:navigate
            class="group inline-flex items-center gap-3 rounded-lg py-1.5 transition duration-300 ease-out
                  hover:-translate-x-1 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50
                  focus-visible:ring-offset-2 dark:focus-visible:ring-offset-zinc-900">
            <x-app-logo />
        </a>

        {{-- Navigation desktop --}}
        <flux:navbar class="-mb-px max-lg:hidden ml-10">
            <flux:navbar.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                <span
                    class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Accueil') }}</span>
            </flux:navbar.item>
            <flux:navbar.item :href="route('projects.index')" :current="request()->routeIs('projects.*')" wire:navigate>
                <span
                    class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Projets') }}</span>
            </flux:navbar.item>
            <flux:navbar.item :href="route('posts.index')" :current="request()->routeIs('posts.index')" wire:navigate>
                <span
                    class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Blog') }}</span>
            </flux:navbar.item>
            <flux:navbar.item :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                <span
                    class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('À propos') }}</span>
            </flux:navbar.item>
            <flux:navbar.item :href="route('contact')" :current="request()->routeIs('contact')" wire:navigate>
                <span
                    class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Contact') }}</span>
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        {{-- Actions à droite --}}
        <div class="flex items-center gap-2">
            {{-- Bouton dark mode --}}
            <button x-cloak x-data="{ tooltip: false }" x-on:mouseenter="tooltip = true" x-on:mouseleave="tooltip = false"
                x-on:click="
        tooltip = false;
        document.documentElement.classList.add('no-transition');
        $flux.dark = !$flux.dark;
        setTimeout(() => document.documentElement.classList.remove('no-transition'), 100);
    "
                aria-label="Changer le thème"
                class="relative flex h-9 w-9 items-center justify-center rounded-xl text-zinc-500 transition-all duration-200
           hover:bg-zinc-100 hover:text-zinc-700 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-200">
                <flux:icon.sun x-show="!$flux.dark" variant="mini" class="h-5 w-5 transition-all duration-300" />
                <flux:icon.moon x-show="$flux.dark" variant="mini" class="h-5 w-5 transition-all duration-300" />
            </button>

            @auth
                <x-desktop-user-menu />
            @else
                <a href="{{ route('login') }}"
                    class="group hidden lg:inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white
                          shadow-sm shadow-emerald-200 transition-all duration-300
                          hover:bg-emerald-700 hover:shadow-md hover:shadow-emerald-300/30
                          dark:shadow-emerald-900/50 dark:hover:bg-emerald-500 dark:hover:shadow-emerald-800/50">
                    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Connexion') }}
                </a>
            @endauth
        </div>
    </flux:header>

    {{-- ========== SIDEBAR MOBILE ========== --}}
    <flux:sidebar collapsible="mobile" sticky
        class="lg:hidden border-e border-zinc-200 bg-white dark:border-zinc-800 dark:bg-zinc-950">
        <flux:sidebar.header class="flex items-center justify-between">
            <a href="{{ route('home') }}" wire:navigate
                class="group inline-flex items-center gap-3 rounded-lg py-1.5 transition duration-300 ease-out
                      hover:-translate-x-1 focus:outline-none">
                <x-app-logo :sidebar="true" />
            </a>
            <flux:sidebar.collapse
                class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Navigation')">
                <flux:sidebar.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                    <span
                        class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Accueil') }}</span>
                </flux:sidebar.item>
                <flux:sidebar.item :href="route('services.index')" :current="request()->routeIs('services.*')"
                    wire:navigate>
                    <span
                        class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Services') }}</span>
                </flux:sidebar.item>
                <flux:sidebar.item :href="route('projects.index')" :current="request()->routeIs('projects.*')"
                    wire:navigate>
                    <span
                        class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Projets') }}</span>
                </flux:sidebar.item>
                <flux:sidebar.item :href="route('posts.index')" :current="request()->routeIs('posts.index')"
                    wire:navigate>
                    <span
                        class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Blog') }}</span>
                </flux:sidebar.item>
                <flux:sidebar.item :href="route('about')" :current="request()->routeIs('about')" wire:navigate>
                    <span
                        class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('À propos') }}</span>
                </flux:sidebar.item>
                <flux:sidebar.item :href="route('contact')" :current="request()->routeIs('contact')" wire:navigate>
                    <span
                        class="transition-colors duration-200 hover:text-emerald-600 dark:hover:text-emerald-400">{{ __('Contact') }}</span>
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:spacer />

            <flux:sidebar.group :heading="__('Actions')">
                @auth
                    <flux:sidebar.item href="{{ route('dashboard') }}" icon="layout-grid" wire:navigate>
                        {{ __('Tableau de bord') }}
                    </flux:sidebar.item>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <flux:sidebar.item as="button" type="submit" icon="arrow-right-start-on-rectangle">
                            {{ __('Déconnexion') }}
                        </flux:sidebar.item>
                    </form>
                @else
                    <flux:sidebar.item href="{{ route('login') }}" icon="arrow-right-start-on-rectangle">
                        {{ __('Connexion') }}
                    </flux:sidebar.item>
                @endauth
            </flux:sidebar.group>
        </flux:sidebar.nav>
    </flux:sidebar>

    <div class="flex-1">
        {{ $slot }}
    </div>

    <livewire:footer.footer />

    <livewire:cookie-consent />
    <livewire:scroll-to-top />

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    {{-- Hack: Force Livewire 3 to wait for Vite modules to execute in production mode by simulating a Vite client script. This fixes GSAP/Alpine timing issues. --}}
    <script type="module" src="data:text/javascript,/**vite*/" data-dummy="true"></script>
    @vite('resources/js/app.js')
    @fluxScripts
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>
