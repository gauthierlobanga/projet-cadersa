<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-900 antialiased">
    <flux:header container class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800">
        <flux:sidebar.toggle variant="ghost" class="lg:hidden mr-4 hover:bg-emerald-50! dark:hover:bg-emerald-900/20!"
            icon="bars-3" inset="left" />
        <a href="{{ route('home') }}" wire:navigate
            class="hidden lg:inline-flex group items-center gap-3  py-1.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500/50
          focus-visible:ring-offset-2 dark:focus-visible:ring-offset-zinc-900">
            <x-app-logo />
        </a>

        <flux:navbar class="-mb-px max-lg:hidden ml-8">
            <flux:navbar.item :href="route('home')" :current="request()->routeIs('home')" wire:navigate
                class="text-zinc-600! hover:bg-emerald-50! hover:text-emerald-600! dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                {{ __('Accueil') }}
            </flux:navbar.item>
            <flux:navbar.item :href="route('projects.index')" :current="request()->routeIs('projects.*')" wire:navigate
                class="!text-zinc-600 hover:!bg-emerald-50 hover:!text-emerald-600 dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                {{ __('Projets') }}
            </flux:navbar.item>

            <flux:navbar.item :href="route('formations.index')" :current="request()->routeIs('formations.index')"
                wire:navigate
                class="!text-zinc-600 hover:!bg-emerald-50 hover:!text-emerald-600 dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                {{ __('Formations') }}
            </flux:navbar.item>
            <flux:navbar.item :href="route('posts.index')" :current="request()->routeIs('posts.index')" wire:navigate
                class="!text-zinc-600 hover:!bg-emerald-50 hover:!text-emerald-600 dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                {{ __('Blog') }}
            </flux:navbar.item>

            <flux:separator vertical variant="subtle" class="my-2" />

            <flux:navbar.item :href="route('about')" :current="request()->routeIs('about')" wire:navigate
                class="!text-zinc-600 hover:!bg-emerald-50 hover:!text-emerald-600 dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                {{ __('À propos') }}
            </flux:navbar.item>
            <flux:navbar.item :href="route('contact')" :current="request()->routeIs('contact')" wire:navigate
                class="!text-zinc-600 hover:!bg-emerald-50 hover:!text-emerald-600 dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                {{ __('Contact') }}
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        <flux:navbar class="me-4 gap-4">
            <div class="flex items-center gap-4">
                <button x-cloak x-data aria-label="Changer le thème" x-on:click="$flux.dark = !$flux.dark"
                    class="relative flex h-9 w-9 items-center justify-center rounded-xl text-zinc-400 transition-none hover:bg-emerald-50 hover:text-emerald-600 dark:text-zinc-500 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-400">
                    <flux:icon.sun x-show="!$flux.dark" variant="mini" class="h-5 w-5" />
                    <flux:icon.moon x-show="$flux.dark" variant="mini" class="h-5 w-5" />
                </button>
            </div>
            <flux:separator vertical variant="subtle" class="my-4" />
            @auth
                <x-desktop-user-menu />
            @else
                <a href="{{ route('login') }}" wire:navigate
                    class="group hidden lg:inline-flex items-center gap-2 rounded border border-emerald-600 px-4 py-2 text-sm font-semibold text-emerald-600 transition-all duration-300
          hover:bg-emerald-50 hover:shadow-sm
          dark:border-emerald-400 dark:text-emerald-400 dark:hover:bg-emerald-900/20">
                    <svg class="h-4 w-4 transition-transform group-hover:-translate-x-0.5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    {{ __('Connexion') }}
                </a>

            @endauth
        </flux:navbar>
    </flux:header>

    <flux:sidebar sticky collapsible="mobile"
        class="lg:hidden z-50 fixed! h-dvh max-h-dvh overflow-y-auto border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.header>
            <a href="{{ route('home') }}" wire:navigate
                class="group inline-flex items-center gap-3 rounded-lg py-1.5 transition duration-300 ease-out
                  hover:-translate-x-1 focus:outline-none">
                <x-app-logo />
            </a>
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            <flux:sidebar.group :heading="__('Navigation')">
                @php
                    $links = [
                        ['route' => 'home', 'label' => __('Accueil')],
                        ['route' => 'services.index', 'label' => __('Services')],
                        ['route' => 'projects.index', 'label' => __('Projets')],
                        ['route' => 'posts.index', 'label' => __('Blog')],
                        ['route' => 'formations.index', 'label' => __('Formation')],
                        ['route' => 'about', 'label' => __('À propos')],
                        ['route' => 'contact', 'label' => __('Contact')],
                    ];
                @endphp

                @foreach ($links as $link)
                    <a href="{{ route($link['route']) }}" wire:navigate
                        class="group relative flex items-center gap-3 h-10 lg:h-8 rounded-lg px-3
                      !text-zinc-600 hover:!bg-emerald-50 hover:!text-emerald-600
                      dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400
                      !transition-colors !duration-200
                      focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500
                      @if (request()->routeIs($link['route'])) !text-emerald-600 dark:!text-emerald-400
                          !bg-emerald-50 dark:!bg-emerald-900/20 @endif">
                        {{-- Losange animé --}}
                        <span
                            class="absolute left-1 opacity-0 scale-50 -rotate-90
                             transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)]
                             group-hover:opacity-100 group-hover:scale-100 group-hover:rotate-0
                             group-hover:left-3 text-emerald-500
                             @if (request()->routeIs($link['route'])) opacity-100 scale-100 rotate-0 left-3 @endif">
                            <svg aria-hidden="true" class="size-2" viewBox="0 0 8 8" fill="none">
                                <path d="M4 0L8 4L4 8L0 4L4 0Z" class="fill-current" />
                            </svg>
                        </span>
                        {{-- Texte --}}
                        <span
                            class="transition-transform duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] group-hover:translate-x-3
                             @if (request()->routeIs($link['route'])) translate-x-3 @endif">
                            {{ $link['label'] }}
                        </span>
                    </a>
                @endforeach
            </flux:sidebar.group>
        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:sidebar.nav>
            <flux:sidebar.group class="grid">
                @auth
                    <x-desktop-user-menu />
                @else
                    <div class="flex flex-col gap-3">
                        {{-- Sélecteur de thème --}}
                        <flux:radio.group x-data variant="segmented" :accent="false" x-model="$flux.appearance"
                            class="!border !border-emerald-200 !rounded !bg-transparent !shadow-none
               dark:!border-emerald-800 dark:!bg-transparent
               [&>ui-radio]:!text-zinc-500 [&>ui-radio]:hover:!bg-emerald-50 [&>ui-radio]:hover:!text-emerald-600
               dark:[&>ui-radio]:!text-zinc-400 dark:[&>ui-radio]:hover:!bg-emerald-900/20 dark:[&>ui-radio]:hover:!text-emerald-400
               [&>ui-radio]:data-checked:!bg-transparent [&>ui-radio]:data-checked:!text-emerald-600 dark:[&>ui-radio]:data-checked:!text-emerald-400
               [&>ui-radio]:data-checked:!border-emerald-600 dark:[&>ui-radio]:data-checked:!border-emerald-400
               !gap-0 !p-0">
                            <flux:radio value="light" icon="sun" class="!border-0 !shadow-none" />
                            <flux:radio value="dark" icon="moon" class="!border-0 !shadow-none" />
                            <flux:radio value="system" icon="computer-desktop" class="border-0! !shadow-none" />
                        </flux:radio.group>

                        <flux:sidebar.item href="{{ route('login') }}" icon="arrow-right-start-on-rectangle"
                            :accent="false"
                            class="text-zinc-600! hover:bg-emerald-50! hover:text-emerald-600! dark:!text-zinc-400 dark:hover:!bg-emerald-900/20 dark:hover:!text-emerald-400 !transition !duration-200 !rounded-lg">
                            {{ __('Connexion') }}
                        </flux:sidebar.item>
                    </div>
                @endauth
            </flux:sidebar.group>
        </flux:sidebar.nav>
    </flux:sidebar>

    {{ $slot }}

    <livewire:footer.footer />

    <livewire:cookie-consent />
    <livewire:scroll-to-top />

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
    @livewireScripts
</body>

</html>
