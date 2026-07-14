<section class="border-b border-zinc-200 px-6 py-16 sm:px-8 sm:py-20 lg:px-16 lg:py-28 dark:border-zinc-800">
    <header class="flex flex-col items-center justify-center text-center">
        <div x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 scale-100' : 'opacity-0 scale-90'" class="transition-all duration-700 ease-out">
            <svg aria-hidden="true" class="h-5 text-stone-800 lg:h-6 dark:text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 48 48">
                <path class="stroke-current [stroke-width:var(--stroke-width,3)]" stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M2 28.5641S8 26 13 26c3.5274 0 7.4004 1.4179 9.9935 2.5866 1.9898 0.8968 3.1354 1.4628 3.591 3.5974 0.3166 1.4829 -0.749 3.9554 -2.2605 4.0771l-1.0647 0.0858m0 0c-2.4421 0 -6.2222 -0.724 -6.2222 -0.724m6.2222 0.724c3.3866 0 12.3032 -1.6086 15.4627 -2.1991 0.7538 -0.1409 1.5346 -0.2442 2.252 0.0266 0.9023 0.3406 2.1117 1.1633 2.6902 3.15 0.4519 1.5517 -0.6332 3.0446 -2.1404 3.6279C37.1039 42.6627 27.887 46 23.2593 46 11 46 2 42.9231 2 42.9231">
                </path>
                <path class="stroke-current [stroke-width:var(--stroke-width,3)]" stroke-linejoin="round"
                    d="M46 10c0 -4 -2.5 -8 -7.4992 -8 -4.5008 0 -6.5 4 -6.5 4S30 2 25.5008 2C20.5008 2 18 6 18 10c0 5.9985 5.5363 10.8956 11.1866 14.3765 1.7262 1.0634 3.9022 1.0634 5.6284 -0.0001C40.4649 20.8955 46 15.9985 46 10Z">
                </path>
            </svg>
        </div>

        <p class="mt-4 inline-flex items-center gap-2 rounded-full bg-emerald-50 px-5 py-1.5 text-sm font-medium uppercase tracking-wider text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300"
            x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            class="transition-all duration-700 delay-100 ease-out">
            Partenaires
        </p>

        <h1 class="mt-5 max-w-3xl text-4xl font-extrabold tracking-tight text-zinc-900 dark:text-white sm:text-5xl lg:text-6xl"
            x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            class="transition-all duration-700 delay-200 ease-out">
            Ensemble pour un <span
                class="relative inline-block bg-linear-to-r from-emerald-600 via-emerald-500 to-teal-600 bg-clip-text text-transparent dark:from-emerald-400 dark:via-emerald-300 dark:to-teal-400">impact
                durable</span>
        </h1>

        <p class="mt-4 max-w-2xl text-pretty text-lg leading-relaxed text-zinc-600 dark:text-zinc-300"
            x-data="{ shown: false }" x-intersect="shown = true"
            :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
            class="transition-all duration-700 delay-300 ease-out">
            C’est grâce à leur confiance et à leur engagement à nos côtés que le CADERSA peut concrétiser sa mission
            de développement rural et de sécurité alimentaire au cœur des communautés.
        </p>
    </header>

    @foreach ($this->partners as $group)
        <div class="mx-auto mt-14 max-w-7xl">
            <h3 class="mb-8 text-center text-2xl font-bold text-zinc-800 dark:text-white">
                {{ $group['tier'] }}
            </h3>
            <div class="grid grid-cols-2 gap-6 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($group['items'] as $item)
                    <div x-data="{ shown: false }" x-intersect="shown = true"
                        :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-6'"
                        class="transition-all duration-700 ease-out"
                        style="transition-delay: {{ $loop->index * 60 }}ms">
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer"
                            class="group flex h-24 w-full items-center justify-center border border-zinc-200 bg-white p-4 transition-all duration-300 ease-out hover:-translate-y-1 hover:border-emerald-300 hover:bg-emerald-50/50 dark:border-zinc-800 dark:bg-zinc-900 dark:hover:border-emerald-800/50 dark:hover:bg-emerald-900/20">
                            <img src="{{ $item['logo'] }}" alt="{{ $item['name'] }}" loading="lazy"
                                class="h-12 w-auto max-w-[80%] object-contain transition duration-300 ease-out group-hover:scale-105 dark:brightness-90" />
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</section>
