@php
    $firstName = \Illuminate\Support\Str::before(trim(auth()->user()->name), ' ');
    $dashboardMetrics = [
        ['label' => 'Projets actifs', 'value' => $statistics['projects'], 'detail' => 'Actions actuellement suivies', 'icon' => 'rectangle-stack', 'tone' => 'emerald'],
        ['label' => 'Formations publiées', 'value' => $statistics['formations'], 'detail' => 'Programmes disponibles', 'icon' => 'academic-cap', 'tone' => 'teal'],
        ['label' => 'Actualités', 'value' => $statistics['posts'], 'detail' => 'Publications en ligne', 'icon' => 'newspaper', 'tone' => 'slate'],
        ['label' => 'Rapports accessibles', 'value' => $statistics['reports'], 'detail' => 'Documents consultables', 'icon' => 'document-text', 'tone' => 'emerald'],
    ];
@endphp

<style>
    .dashboard-overview,
    .dashboard-overview *,
    .dashboard-overview *::before,
    .dashboard-overview *::after {
        animation: none !important;
        transition: none !important;
        scroll-behavior: auto !important;
    }

    body:has(.dashboard-overview) [data-flux-sidebar],
    body:has(.dashboard-overview) [data-flux-sidebar-backdrop] {
        animation: none !important;
        transition: none !important;
    }
</style>

<x-layouts::app :title="__('Vue d’ensemble')">
    <main data-disable-global-animations class="dashboard-overview min-h-full bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
        <div class="mx-auto flex w-full max-w-screen-2xl flex-col gap-7 px-4 py-7 sm:px-6 lg:px-8 xl:px-10">
            <section class="relative isolate overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50 to-emerald-100 px-6 py-8 text-slate-900 shadow-sm dark:border-emerald-900/30 dark:from-slate-950 dark:via-emerald-950 dark:to-emerald-800 dark:text-white dark:shadow-none sm:px-8 sm:py-10 lg:px-10">
                <div class="pointer-events-none absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-emerald-300/40 via-transparent to-transparent dark:from-emerald-300/20"></div>
                <div class="relative grid gap-8 lg:grid-cols-[minmax(0,1fr)_19rem] lg:items-end">
                    <div class="max-w-3xl">
                        <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200 bg-emerald-100/80 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.14em] text-emerald-900 dark:border-white/15 dark:bg-white/10 dark:text-emerald-100">
                            <flux:icon name="building-office-2" class="size-4" /> Espace partenaire · CADERSA ASBL
                        </span>
                        <h1 class="mt-5 text-3xl font-semibold tracking-tight sm:text-4xl">Bienvenue, {{ $firstName }}</h1>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 dark:text-emerald-50/85 sm:text-base sm:leading-7">
                            Retrouvez en un seul endroit les actions, les actualités et les rapports de CADERSA. Votre espace vous aide à suivre les publications et à accéder rapidement aux documents de référence.
                        </p>
                        <div class="mt-6 flex flex-wrap items-center gap-3">
                            <a href="{{ route('dashboard.reports') }}" class="inline-flex h-11 items-center gap-2 rounded-lg bg-emerald-700 px-4 text-sm font-semibold text-white hover:bg-emerald-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:bg-white dark:text-emerald-950 dark:hover:bg-emerald-50 dark:focus-visible:outline-white">
                                Consulter les rapports <flux:icon name="arrow-right" class="size-4" />
                            </a>
                            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="inline-flex h-11 items-center gap-2 rounded-lg border border-emerald-300 px-4 text-sm font-semibold text-emerald-900 hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:border-white/20 dark:text-white dark:hover:bg-white/10 dark:focus-visible:outline-white">
                                Découvrir le site <flux:icon name="arrow-up-right" class="size-4" />
                            </a>
                        </div>
                    </div>

                    <aside class="rounded-xl border border-emerald-200 bg-white/80 p-5 shadow-sm dark:border-white/15 dark:bg-slate-950/25 dark:shadow-none">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-emerald-800 dark:text-emerald-200">En bref</p>
                        <p class="mt-3 text-2xl font-semibold tracking-tight">Des actions suivies, des résultats partagés.</p>
                        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-emerald-50/75">Consultez les publications officielles et les bilans périodiques depuis la bibliothèque des rapports.</p>
                    </aside>
                </div>
            </section>

            <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Indicateurs de l’activité de CADERSA">
                @foreach ($dashboardMetrics as $metric)
                    <article class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-slate-600 dark:text-slate-400">{{ $metric['label'] }}</p>
                                <p class="mt-3 text-3xl font-semibold tracking-tight tabular-nums text-slate-950 dark:text-white">{{ number_format($metric['value'], 0, ',', ' ') }}</p>
                            </div>
                            <span @class([
                                'grid size-10 shrink-0 place-items-center rounded-lg',
                                'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' => $metric['tone'] === 'emerald',
                                'bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-300' => $metric['tone'] === 'teal',
                                'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' => $metric['tone'] === 'slate',
                            ])>
                                <flux:icon :name="$metric['icon']" class="size-5" />
                            </span>
                        </div>
                        <p class="mt-3 border-t border-slate-100 pt-3 text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400">{{ $metric['detail'] }}</p>
                    </article>
                @endforeach
            </section>

            <section class="grid gap-6 xl:grid-cols-[minmax(0,1.25fr)_minmax(20rem,0.75fr)]" aria-label="Activités récentes de CADERSA">
                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex flex-wrap items-end justify-between gap-3 border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:px-6">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-400">La vie de l’organisation</p>
                            <h2 class="mt-1 text-lg font-semibold tracking-tight">Actualités récentes</h2>
                        </div>
                        <a href="{{ route('posts.index') }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-800 hover:text-emerald-950 dark:text-emerald-300 dark:hover:text-emerald-200">
                            Toutes les actualités <flux:icon name="arrow-up-right" class="size-4" />
                        </a>
                    </div>
                    @if ($recentPosts->isNotEmpty())
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($recentPosts as $post)
                                <a href="{{ route('posts.show', $post->slug) }}" target="_blank" rel="noopener" class="flex items-start gap-4 px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 sm:px-6">
                                    <span class="mt-0.5 grid size-9 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300"><flux:icon name="newspaper" class="size-4" /></span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $post->title }}</span>
                                        <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">Publié le {{ $post->published_at?->locale('fr')->translatedFormat('d M Y') }}</span>
                                    </span>
                                    <flux:icon name="arrow-up-right" class="mt-1 size-4 shrink-0 text-slate-400" />
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="px-5 py-10 text-center sm:px-6">
                            <flux:icon name="newspaper" class="mx-auto size-8 text-slate-300 dark:text-slate-600" />
                            <p class="mt-3 text-sm font-medium text-slate-700 dark:text-slate-300">Les actualités apparaîtront ici dès leur publication.</p>
                        </div>
                    @endif
                </article>

                <article class="overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                    <div class="border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:px-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-400">Bibliothèque documentaire</p>
                        <h2 class="mt-1 text-lg font-semibold tracking-tight">Derniers rapports</h2>
                    </div>
                    @if ($recentReports->isNotEmpty())
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @foreach ($recentReports as $report)
                                <a href="{{ route('dashboard.reports') }}" class="flex items-start gap-3 px-5 py-4 hover:bg-slate-50 dark:hover:bg-slate-800/50 sm:px-6">
                                    <span class="mt-0.5 grid size-9 shrink-0 place-items-center rounded-lg bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300"><flux:icon name="document-text" class="size-4" /></span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $report->title }}</span>
                                        <span class="mt-1 block text-xs text-slate-500 dark:text-slate-400">{{ $report->period_label }} · {{ $report->published_at?->locale('fr')->translatedFormat('d M Y') }}</span>
                                    </span>
                                    <flux:icon name="arrow-right" class="mt-1 size-4 shrink-0 text-slate-400" />
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="px-5 py-10 text-center sm:px-6">
                            <flux:icon name="document-text" class="mx-auto size-8 text-slate-300 dark:text-slate-600" />
                            <p class="mt-3 text-sm font-medium text-slate-700 dark:text-slate-300">Aucun rapport n’est encore publié.</p>
                        </div>
                    @endif
                    <div class="border-t border-slate-100 p-5 dark:border-slate-800 sm:px-6">
                        <a href="{{ route('dashboard.reports') }}" class="flex h-10 w-full items-center justify-center gap-2 rounded-lg bg-emerald-700 px-4 text-sm font-semibold text-white hover:bg-emerald-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500">
                            Ouvrir la page des rapports <flux:icon name="arrow-right" class="size-4" />
                        </a>
                    </div>
                </article>
            </section>

            <section aria-labelledby="quick-access-heading">
                <div class="flex flex-col gap-2 border-b border-slate-200 pb-4 dark:border-slate-800 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.14em] text-emerald-700 dark:text-emerald-400">Domaines & ressources</p>
                        <h2 id="quick-access-heading" class="mt-1 text-xl font-semibold tracking-tight">Explorer</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-6 text-slate-500 dark:text-slate-400">Découvrez les domaines d’intervention et les ressources de CADERSA.</p>
                </div>

                <div class="mt-4 grid gap-4 md:grid-cols-3">
                    <a href="{{ route('projects.index') }}" target="_blank" rel="noopener" class="flex min-h-56 flex-col rounded-xl border border-slate-200 bg-white p-5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <span class="grid size-11 place-items-center rounded-lg bg-emerald-50 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300"><flux:icon name="folder-git-2" class="size-5" /></span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">Programmes</span>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-base font-semibold text-slate-950 dark:text-white">Projets sur le terrain</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Suivez les initiatives et les actions menées auprès des communautés et des partenaires.</p>
                        </div>
                        <span class="mt-auto flex items-center justify-between gap-3 border-t border-slate-100 pt-5 text-sm font-semibold text-emerald-800 dark:border-slate-800 dark:text-emerald-300">
                            Explorer les projets <flux:icon name="arrow-up-right" class="size-4" />
                        </span>
                    </a>

                    <a href="{{ route('formations.index') }}" target="_blank" rel="noopener" class="flex min-h-56 flex-col rounded-xl border border-slate-200 bg-white p-5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <span class="grid size-11 place-items-center rounded-lg bg-teal-50 text-teal-800 dark:bg-teal-950 dark:text-teal-300"><flux:icon name="academic-cap" class="size-5" /></span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">Renforcement des capacités</span>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-base font-semibold text-slate-950 dark:text-white">Formations & accompagnement</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Consultez les parcours et les ressources conçus pour soutenir les acteurs locaux.</p>
                        </div>
                        <span class="mt-auto flex items-center justify-between gap-3 border-t border-slate-100 pt-5 text-sm font-semibold text-teal-800 dark:border-slate-800 dark:text-teal-300">
                            Voir les formations <flux:icon name="arrow-up-right" class="size-4" />
                        </span>
                    </a>

                    <a href="{{ route('services.index') }}" target="_blank" rel="noopener" class="flex min-h-56 flex-col rounded-xl border border-slate-200 bg-white p-5 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <span class="grid size-11 place-items-center rounded-lg bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300"><flux:icon name="hand-raised" class="size-5" /></span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-slate-400 dark:text-slate-500">Expertise</span>
                        </div>
                        <div class="mt-5">
                            <h3 class="text-base font-semibold text-slate-950 dark:text-white">Services de CADERSA</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-400">Parcourez les services et les formes d’appui proposés par l’organisation.</p>
                        </div>
                        <span class="mt-auto flex items-center justify-between gap-3 border-t border-slate-100 pt-5 text-sm font-semibold text-slate-700 dark:border-slate-800 dark:text-slate-300">
                            Découvrir les services <flux:icon name="arrow-up-right" class="size-4" />
                        </span>
                    </a>
                </div>
            </section>
        </div>
    </main>
</x-layouts::app>
