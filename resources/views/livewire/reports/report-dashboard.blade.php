@php
    $monthlyChartData = [
        'labels' => collect($statistics['monthly'])->pluck('label')->all(),
        'datasets' => [
            ['label' => 'PDF', 'data' => collect($statistics['monthly'])->pluck('pdf')->all()],
            ['label' => 'Word', 'data' => collect($statistics['monthly'])->pluck('word')->all()],
            ['label' => 'Excel', 'data' => collect($statistics['monthly'])->pluck('excel')->all()],
        ],
    ];
    $trendChartData = [
        'labels' => collect($statistics['monthly'])->pluck('label')->all(),
        'datasets' => [
            ['label' => 'Rapports publiés', 'data' => collect($statistics['monthly'])->pluck('total')->all()],
        ],
    ];
    $storageBytes = $statistics['bytes'];
    $storageLabel = match (true) {
        $storageBytes >= 1_000_000_000 => number_format($storageBytes / 1_000_000_000, 1, ',', ' ') . ' Go',
        $storageBytes >= 1_000_000 => number_format($storageBytes / 1_000_000, 1, ',', ' ') . ' Mo',
        $storageBytes >= 1_000 => number_format($storageBytes / 1_000, 0, ',', ' ') . ' Ko',
        default => $storageBytes . ' o',
    };
    $periodLabels = [
        'annual' => 'Annuels',
        'quarterly' => 'Trimestriels',
        'monthly' => 'Mensuels',
    ];
    $formatLabels = [
        'pdf' => 'PDF',
        'word' => 'Word',
        'excel' => 'Excel',
    ];
    $formatChartData = [
        'labels' => array_values($formatLabels),
        'datasets' => [['label' => 'Documents', 'data' => array_values($statistics['formats'])]],
    ];
@endphp

<style>
    .report-dashboard,
    .report-dashboard *,
    .report-dashboard *::before,
    .report-dashboard *::after {
        animation: none !important;
        transition: none !important;
    }
</style>

<div wire:poll.15s="checkForNewReports" data-disable-global-animations
    class="report-dashboard min-h-full bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-100">
    <header class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <div
            class="mx-auto flex w-full max-w-none flex-col gap-5 px-4 py-7 sm:px-6 lg:flex-row lg:items-end lg:justify-between lg:px-8 xl:px-10 2xl:px-12">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700 dark:text-emerald-400">
                    Espace documentaire</p>
                <h1 class="mt-2 text-3xl font-semibold tracking-tight sm:text-4xl">Rapports & indicateurs</h1>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-400">Suivez les publications de
                    CADERSA ASBL et consultez les rapports disponibles.</p>
            </div>
        </div>
    </header>

    @if ($reportNotifications !== [])
        <section class="mx-auto w-full max-w-none px-4 pt-5 sm:px-6 lg:px-8 xl:px-10 2xl:px-12" aria-live="polite"
            aria-label="Nouveaux rapports publiés">
            <div class="grid gap-3">
                @foreach ($reportNotifications as $notification)
                    <article wire:key="report-notification-{{ $notification['id'] }}"
                        class="flex items-start gap-3 rounded-xl border border-emerald-200 bg-emerald-50/90 p-4 shadow-none  dark:border-emerald-900/80 dark:bg-emerald-950/50 sm:items-center sm:px-5">
                        <span
                            class="grid size-10 shrink-0 place-items-center rounded-xl bg-white text-emerald-700 ring-1 ring-emerald-100 dark:bg-emerald-900/70 dark:text-emerald-300 dark:ring-emerald-800">
                            <flux:icon name="bell-alert" class="size-5" />
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="text-sm font-semibold text-emerald-950 dark:text-emerald-100">Nouveau rapport publié</p>
                            <p class="mt-0.5 truncate text-sm text-emerald-800 dark:text-emerald-200">
                                {{ $notification['title'] }} <span
                                    class="text-emerald-700/75 dark:text-emerald-300/80">·
                                    {{ $notification['period'] }}</span></p>
                        </div>
                        <a href="#bibliotheque-rapports"
                            class="hidden shrink-0 rounded-lg px-3 py-2 text-sm font-semibold text-emerald-800 hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:text-emerald-200 dark:hover:bg-emerald-900/70 sm:inline-flex">Voir
                            les rapports</a>
                        <button type="button" wire:click="dismissReportNotification('{{ $notification['id'] }}')"
                            class="grid size-9 shrink-0 place-items-center rounded-lg text-emerald-800 transition hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:text-emerald-200 dark:hover:bg-emerald-900/70"
                            aria-label="Fermer la notification">
                            <flux:icon name="x-mark" class="size-4" />
                        </button>
                    </article>
                @endforeach
            </div>
        </section>
    @endif

    <main class="mx-auto flex w-full max-w-none flex-col gap-6 px-4 py-7 sm:px-6 lg:gap-7 lg:px-8 xl:px-10 2xl:px-12">
        <section aria-label="Statistiques des rapports" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($formatLabels as $type => $label)
                @php
                    $accent = match ($type) {
                        'pdf' => 'emerald',
                        'word' => 'slate',
                        default => 'teal',
                    };
                    $icons = ['pdf' => 'document-text', 'word' => 'document', 'excel' => 'table-cells'];
                @endphp
                <article wire:key="report-stat-{{ $type }}"
                    class="rounded-xl border border-slate-200 bg-white p-5 shadow-none  dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }} publiés
                        </p>
                        <span @class([
                            'grid size-10 place-items-center rounded-xl',
                            'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' =>
                                $accent === 'emerald',
                            'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' =>
                                $accent === 'slate',
                            'bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-300' =>
                                $accent === 'teal',
                        ])>
                            <flux:icon :name="$icons[$type]" class="size-5" />
                        </span>
                    </div>
                    <div class="mt-4 flex items-end justify-between gap-4">
                        <p class="text-3xl font-semibold tracking-tight">
                            {{ number_format($statistics['formats'][$type], 0, ',', ' ') }}</p>
                        <p class="pb-1 text-xs font-medium text-slate-400">
                            {{ $statistics['documents'] > 0 ? number_format(($statistics['formats'][$type] / $statistics['documents']) * 100, 0, ',', ' ') . ' %' : '—' }}
                            du fonds</p>
                    </div>
                    <div class="mt-4 h-1.5 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                        <div @class([
                            'h-full rounded-full transition-all',
                            'bg-emerald-600 dark:bg-emerald-400' => $accent === 'emerald',
                            'bg-slate-600 dark:bg-slate-400' => $accent === 'slate',
                            'bg-teal-500 dark:bg-teal-400' => $accent === 'teal',
                        ])
                            style="width: {{ $statistics['documents'] > 0 ? min(100, ($statistics['formats'][$type] / $statistics['documents']) * 100) : 0 }}%">
                        </div>
                    </div>
                </article>
            @endforeach

            <article
                class="rounded-xl border border-slate-200 bg-white p-5 shadow-none  dark:border-slate-800 dark:bg-slate-900">
                <div class="flex items-center justify-between gap-3">
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">Documents publiés</p>
                    <span
                        class="grid size-10 place-items-center rounded-xl bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300">
                        <flux:icon name="rectangle-stack" class="size-5" />
                    </span>
                </div>
                <div class="mt-4 flex items-end justify-between gap-4">
                    <p class="text-3xl font-semibold tracking-tight">
                        {{ number_format($statistics['documents'], 0, ',', ' ') }}</p>
                    <p class="pb-1 text-xs font-medium text-slate-400">{{ $storageLabel }} stockés</p>
                </div>
                <div class="mt-4 flex items-center gap-1.5">
                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                    <span class="text-xs text-slate-500 dark:text-slate-400">Données réelles ·
                        {{ $year }}</span>
                </div>
            </article>
        </section>

        <section aria-label="Volumes par période" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ($periodLabels as $period => $label)
                <article wire:key="report-period-stat-{{ $period }}"
                    class="rounded-xl border border-slate-200 bg-white p-5 shadow-none  dark:border-slate-800 dark:bg-slate-900">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ $label }}</p>
                        <span
                            class="grid size-10 place-items-center rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                            <flux:icon name="calendar-days" class="size-5" />
                        </span>
                    </div>
                    <p class="mt-4 text-3xl font-semibold tracking-tight">
                        {{ number_format($statistics['periods'][$period], 0, ',', ' ') }}</p>
                    <p class="mt-2 text-xs text-slate-500 dark:text-slate-400">Rapports publiés · {{ $year }}
                    </p>
                </article>
            @endforeach

            @if ($canDownload)
                <article
                    class="rounded-xl border border-amber-200 bg-amber-50/70 p-5 shadow-none  dark:border-amber-900/70 dark:bg-amber-950/30">
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-sm font-medium text-amber-800 dark:text-amber-200">Brouillons</p>
                        <span
                            class="grid size-10 place-items-center rounded-xl bg-white text-amber-700 dark:bg-amber-950 dark:text-amber-300">
                            <flux:icon name="pencil-square" class="size-5" />
                        </span>
                    </div>
                    <p class="mt-4 text-3xl font-semibold tracking-tight text-amber-950 dark:text-amber-100">
                        {{ number_format($statistics['drafts'], 0, ',', ' ') }}</p>
                    <p class="mt-2 text-xs text-amber-800/80 dark:text-amber-200/80">Brouillons · {{ $year }}
                    </p>
                </article>
            @endif
        </section>

        <section class="grid gap-6 xl:grid-cols-[1.45fr_1fr]">
            <article
                class="rounded-xl border border-slate-200 bg-white p-5 shadow-none dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                <div class="flex flex-col justify-between gap-2 sm:flex-row sm:items-start">
                    <div>
                        <h2 class="text-lg font-semibold tracking-tight">Ajouts par mois</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Nombre de fichiers publiés · exercice
                            {{ $year }}</p>
                    </div>
                    <span
                        class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ number_format($statistics['documents'], 0, ',', ' ') }}
                        au total</span>
                </div>
                <div class="relative mt-6 h-64 w-full">
                    <canvas data-report-chart="monthly"
                        data-chart-data="{{ base64_encode(json_encode($monthlyChartData, JSON_UNESCAPED_UNICODE)) }}"
                        role="img" aria-label="Histogramme interactif des rapports publiés chaque mois par format">
                    </canvas>
                </div>
                <p
                    class="mt-3 border-t border-slate-100 pt-4 text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400">
                    Survolez une barre pour consulter le détail · Source : date de publication</p>
            </article>

            <article
                class="rounded-xl border border-slate-200 bg-white p-5 shadow-none dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                <div>
                    <h2 class="text-lg font-semibold tracking-tight">Répartition des périodes</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Nature des rapports de l’exercice
                        {{ $year }}</p>
                </div>
                <div class="mt-7 flex flex-col gap-6">
                    @foreach ($periodLabels as $period => $label)
                        @php
                            $periodCount = $statistics['periods'][$period];
                            $periodWidth =
                                $statistics['documents'] > 0 ? ($periodCount / $statistics['documents']) * 100 : 0;
                        @endphp
                        <div wire:key="report-period-{{ $period }}">
                            <div class="mb-2 flex items-center justify-between gap-3 text-sm">
                                <span class="text-slate-600 dark:text-slate-300">{{ $label }}</span>
                                <span
                                    class="font-semibold tabular-nums">{{ number_format($periodCount, 0, ',', ' ') }}</span>
                            </div>
                            <div class="h-2 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                <div class="h-full rounded-full bg-emerald-700 transition-all dark:bg-emerald-400"
                                    style="width: {{ $periodWidth }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8 rounded-xl bg-emerald-50 p-4 dark:bg-emerald-950/50">
                    <p class="text-sm font-medium text-emerald-950 dark:text-emerald-200">Volume documentaire</p>
                    <p class="mt-1 text-2xl font-semibold tracking-tight text-emerald-900 dark:text-emerald-100">
                        {{ $storageLabel }}</p>
                    <p class="mt-1 text-xs text-emerald-800/75 dark:text-emerald-300/75">Taille cumulée des fichiers
                        publiés</p>
                </div>
            </article>
        </section>

        <section class="grid gap-6 xl:grid-cols-2" aria-label="Analyses détaillées des rapports">
            <article
                class="rounded-xl border border-slate-200 bg-white p-5 shadow-none dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold tracking-tight">Tendance mensuelle</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Évolution du nombre de publications
                            en {{ $year }}</p>
                    </div>
                    <span
                        class="rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">Courbe
                        de tendance</span>
                </div>
                <div class="relative mt-5 h-64 w-full">
                    <canvas data-report-chart="trend"
                        data-chart-data="{{ base64_encode(json_encode($trendChartData, JSON_UNESCAPED_UNICODE)) }}"
                        role="img"
                        aria-label="Courbe interactive des publications mensuelles de {{ $year }}">
                    </canvas>
                </div>
                <p
                    class="mt-2 border-t border-slate-100 pt-4 text-xs text-slate-500 dark:border-slate-800 dark:text-slate-400">
                    Source : date de publication de chaque rapport.</p>
            </article>

            <article
                class="rounded-xl border border-slate-200 bg-white p-5 shadow-none dark:border-slate-800 dark:bg-slate-900 sm:p-6">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold tracking-tight">Formats des documents</h2>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Part de chaque format publié en
                            {{ $year }}</p>
                    </div>
                    <span
                        class="rounded-md bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-800 dark:text-slate-300">{{ number_format($statistics['documents'], 0, ',', ' ') }}
                        documents</span>
                </div>
                <div class="mt-5 grid items-center gap-6 sm:grid-cols-[minmax(0,1fr)_1fr]">
                    <div class="relative mx-auto h-56 w-full max-w-64">
                        <canvas data-report-chart="formats"
                            data-chart-data="{{ base64_encode(json_encode($formatChartData, JSON_UNESCAPED_UNICODE)) }}"
                            role="img"
                            aria-label="Graphique interactif en anneau de la répartition des documents par format">
                        </canvas>
                    </div>
                    <div class="space-y-4">
                        @foreach ($formatLabels as $type => $label)
                            @php
                                $formatPercent =
                                    $statistics['documents'] > 0
                                        ? ($statistics['formats'][$type] / $statistics['documents']) * 100
                                        : 0;
                            @endphp
                            <div wire:key="format-donut-legend-{{ $type }}"
                                class="flex items-center justify-between gap-4">
                                <span
                                    class="inline-flex items-center gap-2 text-sm text-slate-600 dark:text-slate-300"><span
                                        @class([
                                            'size-2.5 rounded-full',
                                            'bg-emerald-700' => $type === 'pdf',
                                            'bg-slate-600' => $type === 'word',
                                            'bg-teal-400' => $type === 'excel',
                                        ])></span>{{ $label }}</span>
                                <span
                                    class="text-sm font-semibold tabular-nums text-slate-900 dark:text-white">{{ $statistics['formats'][$type] }}
                                    <span
                                        class="font-normal text-slate-400">{{ number_format($formatPercent, 0, ',', ' ') }}
                                        %</span></span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </article>
        </section>

        <section id="bibliotheque-rapports"
            class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-none dark:border-slate-800 dark:bg-slate-900"
            aria-labelledby="report-library-heading">
            <div
                class="flex flex-col gap-5 border-b border-slate-200 px-5 py-5 dark:border-slate-800 sm:px-6 sm:py-6 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <p
                        class="text-xs font-semibold uppercase tracking-[0.15em] text-emerald-700 dark:text-emerald-400">
                        Bibliothèque</p>
                    <h2 id="report-library-heading" class="mt-1 text-xl font-semibold tracking-tight">Rapports par
                        période</h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Les filtres s’appliquent aux trois
                        tableaux ci-dessous.</p>
                </div>
                <div class="grid gap-3 sm:grid-cols-2 lg:min-w-[38rem] lg:grid-cols-3">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label for="report-search"
                            class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Rechercher un
                            rapport</label>
                        <flux:input id="report-search" wire:model.live.debounce.300ms="search" type="search"
                            placeholder="Titre, description, nom du fichier…" aria-label="Rechercher un rapport" />
                    </div>
                    <div>
                        <label for="report-format"
                            class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Filtrer par
                            format</label>
                        <flux:select id="report-format" wire:model.live="format" aria-label="Filtrer par format">
                            <option value="">Tous les formats</option>
                            <option value="pdf">PDF</option>
                            <option value="word">Word</option>
                            <option value="excel">Excel</option>
                        </flux:select>
                    </div>
                    <div>
                        <label for="report-year"
                            class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-300">Filtrer par
                            année</label>
                        <flux:select id="report-year" wire:model.live="year" aria-label="Filtrer par année">
                            @foreach ($availableYears as $availableYear)
                                <option value="{{ $availableYear }}">{{ $availableYear }}</option>
                            @endforeach
                        </flux:select>
                    </div>
                    @if (filled($search) || filled($format) || (string) $year !== (string) now()->year)
                        <div class="sm:col-span-2 lg:col-span-3">
                            <button type="button" wire:click="clearFilters"
                                class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 text-xs font-semibold text-emerald-800 transition hover:bg-emerald-50 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:text-emerald-300 dark:hover:bg-emerald-950/60">
                                <flux:icon name="x-mark" class="size-3.5" />
                                Effacer la recherche et les filtres
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            @foreach ($periodLabels as $periodType => $periodLabel)
                <section class="border-t border-slate-200 dark:border-slate-800"
                    aria-label="Rapports {{ strtolower($periodLabel) }}">
                    <div
                        class="flex flex-wrap items-center justify-between gap-3 bg-slate-50/80 px-5 py-4 dark:bg-slate-950/50 sm:px-6">
                        <h3 class="font-semibold text-slate-900 dark:text-white">{{ $periodLabel }}</h3>
                        <span
                            class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold tabular-nums text-slate-600 ring-1 ring-slate-200 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-700">{{ number_format($periodReports[$periodType]->total(), 0, ',', ' ') }}
                            {{ $periodReports[$periodType]->total() === 1 ? 'résultat' : 'résultats' }} ·
                            {{ $year }}</span>
                    </div>

                    @if ($periodReports[$periodType]->isNotEmpty())
                        <flux:table class="w-full min-w-full text-slate-800 dark:text-slate-100"
                            container:class="w-full overflow-x-auto border-t border-slate-100 dark:border-slate-800"
                            aria-label="Tableau des rapports {{ strtolower($periodLabel) }}">
                            <flux:table.columns class="bg-white dark:bg-slate-900">
                                <flux:table.column class="first:ps-5 sm:first:ps-6">Document</flux:table.column>
                                <flux:table.column>Projet</flux:table.column>
                                <flux:table.column>Période</flux:table.column>
                                <flux:table.column>Format</flux:table.column>
                                <flux:table.column align="end">Taille</flux:table.column>
                                <flux:table.column>Publié le</flux:table.column>
                                <flux:table.column align="end" class="last:pe-5 sm:last:pe-6">Actions
                                </flux:table.column>
                            </flux:table.columns>

                            <flux:table.rows class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach ($periodReports[$periodType] as $report)
                                    <flux:table.row :key="$report->id"
                                        class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40">
                                        <flux:table.cell variant="strong"
                                            class="max-w-[24rem] first:ps-5 sm:first:ps-6">
                                            <div class="flex min-w-0 items-center gap-3">
                                                <span @class([
                                                    'grid size-10 shrink-0 place-items-center rounded-xl',
                                                    'bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' =>
                                                        $report->file_type === 'pdf',
                                                    'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' =>
                                                        $report->file_type === 'word',
                                                    'bg-teal-50 text-teal-700 dark:bg-teal-950 dark:text-teal-300' =>
                                                        $report->file_type === 'excel',
                                                ])>
                                                    <flux:icon
                                                        :name="$report->file_type === 'pdf' ? 'document-text' : ($report->file_type === 'excel' ? 'table-cells' : 'document')"
                                                        class="size-5" />
                                                </span>
                                                <span class="min-w-0">
                                                    <span
                                                        class="block truncate font-semibold text-slate-900 dark:text-white">{{ $report->title }}</span>
                                                    <span
                                                        class="mt-0.5 block truncate text-xs font-normal text-slate-500 dark:text-slate-400">{{ $report->original_filename }}</span>
                                                </span>
                                            </div>
                                        </flux:table.cell>
                                        <flux:table.cell class="max-w-48 truncate text-slate-600 dark:text-slate-300">
                                            {{ $report->project?->title ?? 'Organisation' }}</flux:table.cell>
                                        <flux:table.cell class="whitespace-nowrap text-slate-600 dark:text-slate-300">
                                            {{ $report->period_label }}</flux:table.cell>
                                        <flux:table.cell class="py-0">
                                            <flux:badge size="sm"
                                                :color="$report->file_type === 'pdf' ? 'emerald' : ($report->file_type === 'excel' ? 'teal' : 'zinc')">
                                                {{ $report->format_label }}</flux:badge>
                                        </flux:table.cell>
                                        <flux:table.cell align="end"
                                            class="tabular-nums text-slate-600 dark:text-slate-300">
                                            {{ $report->formatted_file_size }}</flux:table.cell>
                                        <flux:table.cell class="whitespace-nowrap text-slate-600 dark:text-slate-300">
                                            {{ $report->published_at?->translatedFormat('d M Y') }}</flux:table.cell>
                                        <flux:table.cell align="end" class="last:pe-5 sm:last:pe-6">
                                            <div class="flex items-center justify-end gap-2">
                                                @if ($report->file_type === 'pdf')
                                                    <flux:button size="sm" variant="ghost"
                                                        wire:key="open-report-{{ $report->getKey() }}"
                                                        :href="route('dashboard.reports', ['preview' => $report->getKey()])"
                                                        icon="eye">Aperçu</flux:button>
                                                @endif
                                                @if ($canDownload)
                                                    <a href="{{ route('reports.download', $report) }}"
                                                        class="inline-flex size-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-800 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:border-slate-700 dark:text-slate-300 dark:hover:border-emerald-800 dark:hover:bg-emerald-950 dark:hover:text-emerald-300"
                                                        aria-label="Télécharger {{ $report->title }}">
                                                        <flux:icon name="arrow-down-tray" class="size-4" />
                                                    </a>
                                                @endif
                                            </div>
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                        {{ $periodReports[$periodType]->links('pagination::custom') }}
                    @else
                        <div class="flex items-center gap-3 px-5 py-6 sm:px-6">
                            <span
                                class="grid size-10 shrink-0 place-items-center rounded-xl bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                                <flux:icon name="document-magnifying-glass" class="size-5" />
                            </span>
                            <div>
                                <p class="text-sm font-medium text-slate-800 dark:text-slate-200">Aucun rapport
                                    {{ strtolower($periodLabel) }} ne correspond à ces critères.</p>
                                <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-400">Modifiez la recherche ou
                                    les filtres pour afficher d’autres documents.</p>
                            </div>
                        </div>
                    @endif
                </section>
            @endforeach
        </section>
    </main>

    @if ($selectedReport)
        <div wire:key="report-preview-{{ $selectedReport->getKey() }}"
            class="fixed inset-0 z-[100] flex flex-col bg-slate-950/70 p-2 backdrop-blur-md sm:p-5 lg:p-8"
            role="dialog" aria-modal="true" aria-labelledby="report-preview-title"
            x-on:keydown.escape.window="window.location.href = '{{ route('dashboard.reports') }}'">
            <a href="{{ route('dashboard.reports') }}" class="absolute inset-0 cursor-default"
                aria-label="Fermer l’aperçu"></a>
            <section x-ref="reader" data-pdf-url="{{ route('reports.preview', $selectedReport) }}"
                x-data="{
                    page: 1,
                    zoom: 100,
                    requestVersion: 0,
                    pdfUrl: $el.dataset.pdfUrl,
                    updateViewer() {
                        const viewerUrl = new URL(this.pdfUrl, window.location.origin);
                        viewerUrl.searchParams.set('_reader', String(++this.requestVersion));
                        viewerUrl.hash = `toolbar=0&navpanes=0&page=${this.page}&zoom=${this.zoom}`;
                        this.$refs.pdfFrame.src = viewerUrl.toString();
                    },
                    previousPage() {
                        if (this.page > 1) {
                            this.page--;
                            this.updateViewer();
                        }
                    },
                    nextPage() {
                        this.page++;
                        this.updateViewer();
                    },
                    goToPage() {
                        this.page = Math.max(1, Number(this.page) || 1);
                        this.updateViewer();
                    },
                    changeZoom(amount) {
                        this.zoom = Math.min(200, Math.max(50, this.zoom + amount));
                        this.updateViewer();
                    },
                    fitPage() {
                        this.zoom = 100;
                        this.updateViewer();
                    },
                    toggleFullscreen() {
                        if (document.fullscreenElement === this.$refs.reader) {
                            document.exitFullscreen();
                        } else {
                            this.$refs.reader.requestFullscreen();
                        }
                    }
                }" x-init="updateViewer()"
                class="relative z-10 mx-auto flex h-full w-full max-w-7xl flex-col overflow-hidden rounded-xl border border-slate-200 bg-white shadow-2xl dark:border-slate-700 dark:bg-slate-900"
                role="document">
                <header
                    class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 px-4 py-3 dark:border-slate-800 sm:px-6">
                    <div class="flex min-w-0 items-center gap-3">
                        <span
                            class="grid size-10 shrink-0 place-items-center rounded-xl bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300">
                            <flux:icon name="document-text" class="size-5" />
                        </span>
                        <div class="min-w-0">
                            <p
                                class="text-[11px] font-semibold uppercase tracking-[0.16em] text-emerald-700 dark:text-emerald-400">
                                Lecteur de rapport</p>
                            <h2 id="report-preview-title"
                                class="mt-0.5 truncate text-sm font-semibold text-slate-950 dark:text-white sm:text-base">
                                {{ $selectedReport->title }}</h2>
                            <p class="mt-0.5 truncate text-xs text-slate-500 dark:text-slate-400">
                                {{ $selectedReport->original_filename }} · {{ $selectedReport->formatted_file_size }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($canDownload)
                            <a href="{{ route('reports.download', $selectedReport) }}"
                                class="inline-flex h-9 items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-3 text-sm font-semibold text-emerald-800 transition hover:border-emerald-300 hover:bg-emerald-100 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/60 dark:text-emerald-200 dark:hover:bg-emerald-900/70">
                                <flux:icon name="arrow-down-tray" class="size-4" /> Télécharger
                            </a>
                        @endif
                        <a href="{{ route('dashboard.reports') }}"
                            class="grid size-9 place-items-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-900 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 dark:text-slate-400 dark:hover:bg-slate-800 dark:hover:text-white"
                            aria-label="Fermer l’aperçu">
                            <flux:icon name="x-mark" class="size-5" />
                        </a>
                    </div>
                </header>
                <nav class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-200 bg-white px-3 py-2 dark:border-slate-800 dark:bg-slate-900 sm:px-5"
                    aria-label="Commandes du lecteur PDF">
                    <div class="flex items-center gap-1.5">
                        <button type="button" x-on:click="previousPage()"
                            class="grid size-9 place-items-center rounded-lg text-slate-600 transition hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40 dark:text-slate-300 dark:hover:bg-slate-800"
                            aria-label="Page précédente" x-bind:disabled="page <= 1">
                            <flux:icon name="chevron-left" class="size-4" />
                        </button>
                        <label
                            class="flex h-9 items-center gap-2 rounded-lg border border-slate-200 px-2.5 dark:border-slate-700">
                            <span class="text-xs text-slate-500 dark:text-slate-400">Page</span>
                            <input type="number" min="1" x-model.number="page" x-on:change="goToPage()"
                                class="w-12 border-0 bg-transparent p-0 text-center text-sm font-semibold tabular-nums text-slate-900 focus:ring-0 dark:text-white"
                                aria-label="Numéro de page">
                        </label>
                        <button type="button" x-on:click="nextPage()"
                            class="grid size-9 place-items-center rounded-lg text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                            aria-label="Page suivante">
                            <flux:icon name="chevron-right" class="size-4" />
                        </button>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button type="button" x-on:click="changeZoom(-10)"
                            class="grid size-9 place-items-center rounded-lg text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                            aria-label="Réduire le zoom">
                            <flux:icon name="minus" class="size-4" />
                        </button>
                        <span
                            class="min-w-14 text-center text-sm font-semibold tabular-nums text-slate-700 dark:text-slate-200"
                            x-text="`${zoom} %`" aria-live="polite"></span>
                        <button type="button" x-on:click="changeZoom(10)"
                            class="grid size-9 place-items-center rounded-lg text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800"
                            aria-label="Augmenter le zoom">
                            <flux:icon name="plus" class="size-4" />
                        </button>
                        <button type="button" x-on:click="fitPage()"
                            class="ml-1 inline-flex h-9 items-center gap-2 rounded-lg border border-slate-200 px-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">
                            <flux:icon name="arrows-pointing-in" class="size-4" /><span
                                class="hidden sm:inline">Ajuster</span>
                        </button>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <span
                            class="mr-1 hidden items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300 sm:inline-flex"><span
                                class="size-1.5 rounded-full bg-emerald-500"></span>Lecture seule</span>
                        <button type="button" x-on:click="toggleFullscreen()"
                            class="inline-flex h-9 items-center gap-2 rounded-lg border border-slate-200 px-3 text-xs font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800"
                            aria-label="Afficher en plein écran">
                            <flux:icon name="arrows-pointing-out" class="size-4" /><span
                                class="hidden sm:inline">Plein écran</span>
                        </button>
                    </div>
                </nav>
                <div class="relative min-h-0 flex-1 bg-slate-100 p-2 dark:bg-slate-950 sm:p-4">
                    <div
                        class="pointer-events-none absolute inset-2 rounded-xl border border-slate-200/80 dark:border-slate-800 sm:inset-4">
                    </div>
                    <iframe wire:ignore x-ref="pdfFrame"
                        src="{{ route('reports.preview', $selectedReport) }}#toolbar=0&navpanes=0&page=1&zoom=100"
                        title="Lecture du rapport {{ $selectedReport->title }}"
                        class="relative z-10 h-full min-h-0 w-full rounded-lg bg-white shadow-none ring-1 ring-slate-900/5 dark:bg-white"
                        loading="lazy"></iframe>
                </div>
            </section>
        </div>
    @endif
</div>
