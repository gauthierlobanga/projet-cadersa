<?php

use App\Filament\Widgets\SiteConversionFunnelChart;
use App\Filament\Widgets\SiteDeviceBreakdownChart;
use App\Filament\Widgets\SiteTopPagesChart;
use App\Filament\Widgets\SiteTopPagesSummaryTable;
use App\Filament\Widgets\SiteTrafficSourcesBarChart;
use App\Filament\Widgets\SiteTrafficSourcesChart;
use App\Filament\Widgets\SiteTrafficSourcesSummaryTable;
use App\Filament\Widgets\SiteVisitsChart;
use App\Http\Middleware\RecordSiteAnalytics;
use App\Services\SiteAnalyticsDashboardData;
use App\Services\SiteAnalyticsTracker;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Session\ArraySessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Symfony\Component\HttpFoundation\Response;

test('public html pages record anonymized visits and page views', function () {
    $session = new Store('site-analytics-test', new ArraySessionHandler(120));
    $session->start();

    $request = Request::create('/projects?email=private@example.com&utm_source=newsletter&utm_medium=email&utm_campaign=novembre', 'GET', [], [], [], [
        'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126.0 Safari/537.36',
        'HTTP_ACCEPT_LANGUAGE' => 'fr-FR,fr;q=0.9',
        'HTTP_REFERER' => 'https://newsletter.example/campagne?token=private',
    ]);
    $request->setLaravelSession($session);

    $response = app(RecordSiteAnalytics::class)->handle(
        $request,
        fn (): Response => new Response('<!doctype html><html></html>', 200, ['Content-Type' => 'text/html; charset=UTF-8']),
    );

    expect($response->getStatusCode())->toBe(200)
        ->and(DB::table('visits')->count())->toBe(1)
        ->and(DB::table('page_views')->count())->toBe(1)
        ->and(DB::table('visitor_events')->where('event_type', 'page_view')->count())->toBe(1);

    $visit = DB::table('visits')->first();
    $pageView = DB::table('page_views')->first();

    expect($visit->path)->toBe('/projects')
        ->and($visit->device)->toBe('Ordinateur')
        ->and($visit->platform)->toBe('Windows')
        ->and($visit->browser)->toBe('Chrome')
        ->and($visit->ip)->toBeNull()
        ->and($visit->referrer)->toBe('newsletter.example')
        ->and(json_decode($visit->utm_params, true))->toBe([
            'utm_source' => 'newsletter',
            'utm_medium' => 'email',
            'utm_campaign' => 'novembre',
        ])
        ->and($visit->utm_params)->not->toContain('private')
        ->and($pageView->url)->toBe('/projects')
        ->and($pageView->visitor_id)->toBe($visit->visitor_id);
});

test('navigation counts as one visit until the session has been inactive for thirty minutes', function () {
    $session = new Store('site-analytics-session-test', new ArraySessionHandler(120));
    $session->start();
    $tracker = app(SiteAnalyticsTracker::class);

    foreach (['/about', '/projects'] as $path) {
        $request = Request::create($path, 'GET');
        $request->setLaravelSession($session);
        $tracker->recordPageView($request);
    }

    expect(DB::table('visits')->count())->toBe(1)
        ->and(DB::table('page_views')->count())->toBe(2);

    $this->travel(31)->minutes();

    $returnRequest = Request::create('/contact', 'GET');
    $returnRequest->setLaravelSession($session);
    $tracker->recordPageView($returnRequest);

    expect(DB::table('visits')->count())->toBe(2)
        ->and(DB::table('page_views')->count())->toBe(3);
});

test('site analytics ignores admin pages and non html requests', function () {
    $session = new Store('site-analytics-test', new ArraySessionHandler(120));
    $session->start();
    $middleware = app(RecordSiteAnalytics::class);

    $adminRequest = Request::create('/admin', 'GET');
    $adminRequest->setLaravelSession($session);
    $middleware->handle($adminRequest, fn (): Response => new Response('<html></html>', 200, ['Content-Type' => 'text/html']));

    $jsonRequest = Request::create('/projects', 'GET');
    $jsonRequest->setLaravelSession($session);
    $middleware->handle($jsonRequest, fn (): Response => new Response('{}', 200, ['Content-Type' => 'application/json']));

    expect(DB::table('visits')->count())->toBe(0)
        ->and(DB::table('page_views')->count())->toBe(0);
});

test('conversion completion updates the matching started step', function () {
    $session = new Store('site-analytics-test', new ArraySessionHandler(120));
    $session->start();
    $request = Request::create('/contact', 'GET');
    $request->setLaravelSession($session);
    $tracker = app(SiteAnalyticsTracker::class);

    $tracker->startConversion('contact', $request);
    $tracker->completeConversion('contact', $request);

    $event = DB::table('conversion_events')->first();

    expect(DB::table('conversion_events')->count())->toBe(1)
        ->and($event->step)->toBe('contact')
        ->and((bool) $event->completed)->toBeTrue()
        ->and($event->completed_at)->not->toBeNull();
});

test('dashboard charts use the requested date ranges and rank their results', function () {
    $this->travelTo(CarbonImmutable::create(2026, 11, 27, 12));

    $insertVisit = function (CarbonImmutable $visitedAt, string $device, string $path, ?string $referrer = null, ?array $utmParams = null): void {
        DB::table('visits')->insert([
            'id' => (string) Str::uuid(),
            'visitor_id' => (string) Str::uuid(),
            'session_id' => (string) Str::uuid(),
            'url' => $path,
            'path' => $path,
            'method' => 'GET',
            'referrer' => $referrer,
            'utm_params' => $utmParams === null ? null : json_encode($utmParams, JSON_THROW_ON_ERROR),
            'device' => $device,
            'visited_at' => $visitedAt,
            'created_at' => $visitedAt,
            'updated_at' => $visitedAt,
        ]);
    };

    $insertPageView = function (CarbonImmutable $viewedAt, string $url): void {
        DB::table('page_views')->insert([
            'id' => (string) Str::uuid(),
            'page_id' => (string) Str::uuid(),
            'session_id' => (string) Str::uuid(),
            'visitor_id' => (string) Str::uuid(),
            'url' => $url,
            'viewed_at' => $viewedAt,
            'created_at' => $viewedAt,
            'updated_at' => $viewedAt,
        ]);
    };

    $insertConversion = function (string $step, CarbonImmutable $createdAt, bool $completed, ?CarbonImmutable $completedAt): void {
        DB::table('conversion_events')->insert([
            'id' => (string) Str::uuid(),
            'session_id' => (string) Str::uuid(),
            'visitor_id' => (string) Str::uuid(),
            'step' => $step,
            'completed' => $completed,
            'completed_at' => $completedAt,
            'created_at' => $createdAt,
            'updated_at' => $completedAt ?? $createdAt,
        ]);
    };

    $insertVisit(now()->subDays(13)->setTime(10, 0), 'Ordinateur', '/jour-13');
    $insertVisit(now()->subDays(13)->setTime(11, 0), 'Ordinateur', '/jour-13', 'partenaire.example');
    $insertVisit(now()->subDays(14)->setTime(10, 0), 'Mobile', '/jour-14');
    $insertVisit(now()->setTime(9, 0), 'Mobile', '/', null, ['utm_source' => 'facebook', 'utm_medium' => 'social']);
    $insertVisit(now()->subDays(29)->setTime(9, 0), 'Tablette', '/jour-29');
    $insertVisit(now()->subDays(31)->setTime(9, 0), 'Non renseigné', '/jour-31');

    foreach (range(1, 3) as $index) {
        $insertPageView(now()->subDays(10)->setTime($index, 0), '/posts');
    }

    foreach (range(1, 2) as $index) {
        $insertPageView(now()->subDays(29)->setTime($index, 0), '/projects');
    }

    foreach (range(1, 9) as $index) {
        $insertPageView(now()->subDays(31)->setTime($index, 0), '/ancienne-page');
    }

    $insertConversion('contact', now()->subDays(2), false, null);
    $insertConversion('registration', now()->subDays(2), true, now()->subDays(1));
    $insertConversion('registration', now()->subDays(35), true, now()->subDays(1));
    $insertConversion('newsletter_subscription', now()->subDays(31), true, now()->subDays(31));

    $data = app(SiteAnalyticsDashboardData::class);
    $dailyVisits = $data->dailyVisits();
    $devices = $data->deviceBreakdown();
    $trafficSources = $data->trafficSources();
    $topPages = $data->topPages();
    $summaryTables = $data->summaryTables();
    $funnel = $data->conversionFunnel();

    expect(count($dailyVisits['labels']))->toBe(14)
        ->and($dailyVisits['datasets'][0]['data'][0])->toBe(2)
        ->and($dailyVisits['datasets'][0]['data'][13])->toBe(1)
        ->and(array_sum($dailyVisits['datasets'][0]['data']))->toBe(3)
        ->and($devices['labels'])->toContain('Ordinateur', 'Mobile', 'Tablette')
        ->and(array_sum($devices['datasets'][0]['data']))->toBe(5)
        ->and($trafficSources['labels'])->toContain('facebook', 'partenaire.example', 'Direct / sans campagne')
        ->and(array_sum($trafficSources['datasets'][0]['data']))->toBe(5)
        ->and($data->attributedVisitsCount())->toBe(2)
        ->and($topPages['labels'])->toBe(['/posts', '/projects'])
        ->and($topPages['datasets'][0]['data'])->toBe([3, 2])
        ->and($summaryTables['pages'][0]['label'])->toBe('/posts')
        ->and($summaryTables['sources'][0]['label'])->toBe('Direct / sans campagne')
        ->and($funnel['labels'])->toBe(['Demande de contact', 'Création de compte', 'Inscription à la newsletter'])
        ->and($funnel['datasets'][0]['data'])->toBe([1, 1, 0])
        ->and($funnel['datasets'][1]['data'])->toBe([0, 2, 0]);
});

test('Filament analytics charts and summary tables render on the dashboard', function () {
    Livewire::test(SiteVisitsChart::class)
        ->assertSee('Fréquentation du site')
        ->assertSee('Visites quotidiennes · 14 derniers jours');

    Livewire::test(SiteTopPagesChart::class)
        ->assertSee('Pages les plus consultées')
        ->assertSee('Top pages · 30 derniers jours');

    Livewire::test(SiteConversionFunnelChart::class)
        ->assertSee('Parcours de conversion')
        ->assertSee('Étapes commencées et terminées · 30 derniers jours');

    Livewire::test(SiteDeviceBreakdownChart::class)
        ->assertSee('Appareils des visiteurs')
        ->assertSee('Répartition des appareils · 30 derniers jours');

    Livewire::test(SiteTrafficSourcesChart::class)
        ->assertSee('Origine des visites')
        ->assertSee('Canaux d’acquisition · 30 derniers jours');

    Livewire::test(SiteTrafficSourcesBarChart::class)
        ->assertSee('Visites par canal')
        ->assertSee('Comparaison des sources · 30 derniers jours');

    Livewire::test(SiteTopPagesSummaryTable::class)
        ->assertSee('Résumé des pages')
        ->assertSee('Pages les plus consultées · 30 derniers jours');

    Livewire::test(SiteTrafficSourcesSummaryTable::class)
        ->assertSee('Résumé des sources')
        ->assertSee('Origine des visites · 30 derniers jours');
});
