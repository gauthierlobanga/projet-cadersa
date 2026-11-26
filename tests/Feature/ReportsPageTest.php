<?php

use App\Filament\Resources\Media\MediaResource;
use App\Filament\Resources\Projects\ProjectResource;
use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole as EditRolePage;
use App\Filament\Resources\Services\ServiceResource;
use App\Livewire\Reports\ReportDashboard;
use App\Models\Project;
use App\Models\Report;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

beforeEach(function (): void {
    Storage::fake(Report::FILE_DISK);
});

test('reports are available in the authenticated dashboard and have no public index', function () {
    $publishedPath = 'reports/public-annual.pdf';
    Storage::disk(Report::FILE_DISK)->put($publishedPath, '%PDF-1.4 public report');

    Report::factory()->create([
        'title' => 'Rapport annuel publié',
        'file_path' => $publishedPath,
        'original_filename' => 'rapport-annuel.pdf',
        'report_year' => now()->year,
    ]);

    Report::factory()->draft()->create([
        'title' => 'Brouillon confidentiel',
        'file_path' => 'reports/draft.pdf',
        'original_filename' => 'brouillon.pdf',
        'report_year' => now()->year,
    ]);

    $this->get('/rapports')->assertNotFound();

    $this->get(route('dashboard'))->assertRedirect(route('login'));

    $user = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($user)->get(route('dashboard'))
        ->assertOk()
        ->assertSee('Rapport annuel publié')
        ->assertDontSee('Brouillon confidentiel')
        ->assertDontSee('Télécharger');
});

test('the homepage metadata describes the organization instead of a developer portfolio', function () {
    $this->get(route('home'))
        ->assertOk()
        ->assertSee('<title>Développement rural et sécurité alimentaire - Cadersa-ASBL</title>', false)
        ->assertSee('name="description" content="CADERSA ASBL accompagne les communautés rurales', false)
        ->assertSee('"@type": "Organization"', false)
        ->assertDontSee('Développeur Web');
});

test('report filters narrow each period table by file format', function () {
    Report::factory()->create([
        'title' => 'Rapport PDF annuel',
        'report_year' => now()->year,
        'file_type' => Report::TYPE_PDF,
    ]);

    Report::factory()->create([
        'title' => 'Rapport Word trimestriel',
        'period_type' => Report::PERIOD_QUARTERLY,
        'period_number' => 1,
        'report_year' => now()->year,
        'file_type' => Report::TYPE_WORD,
        'original_filename' => 'rapport.docx',
    ]);

    $this->actingAs(User::factory()->create(['email_verified_at' => now()]));

    Livewire::test(ReportDashboard::class)
        ->set('year', (string) now()->year)
        ->set('format', Report::TYPE_WORD)
        ->assertSee('Rapport Word trimestriel')
        ->assertDontSee('Rapport PDF annuel');
});

test('user profile fields accept telephone and email verification mass assignment', function () {
    $verifiedAt = now();
    $user = User::factory()->create([
        'telephone' => '+243 800 000 000',
        'email_verified_at' => $verifiedAt,
    ]);

    expect($user->telephone)->toBe('+243 800 000 000')
        ->and($user->email_verified_at->toDateTimeString())->toBe($verifiedAt->toDateTimeString());
});

test('newly published reports trigger a dismissible live notification', function () {
    $this->actingAs(User::factory()->create(['email_verified_at' => now()]));
    $component = Livewire::test(ReportDashboard::class);

    $report = Report::factory()->create([
        'title' => 'Rapport mensuel ajouté',
        'period_type' => Report::PERIOD_MONTHLY,
        'period_number' => now()->month,
        'report_year' => now()->year,
        'published_at' => now(),
    ]);

    $component->call('checkForNewReports')
        ->assertSee('Nouveau rapport publié')
        ->assertSee('Rapport mensuel ajouté')
        ->assertSee($report->period_label);

    $component->call('checkForNewReports')
        ->assertSee('Rapport mensuel ajouté');

    $component->call('dismissReportNotification', (string) $report->getKey())
        ->assertSet('reportNotifications', []);
});

test('the report dashboard shows separate period tables and an optional project link', function () {
    $project = Project::factory()->create(['title' => 'Projet de sécurité alimentaire']);

    Report::factory()->create([
        'title' => 'Rapport annuel lié',
        'period_type' => Report::PERIOD_ANNUAL,
        'period_number' => null,
        'report_year' => now()->year,
        'project_id' => $project->getKey(),
    ]);
    Report::factory()->create([
        'title' => 'Rapport trimestriel',
        'period_type' => Report::PERIOD_QUARTERLY,
        'period_number' => 1,
        'report_year' => now()->year,
    ]);
    Report::factory()->create([
        'title' => 'Rapport mensuel',
        'period_type' => Report::PERIOD_MONTHLY,
        'period_number' => now()->month,
        'report_year' => now()->year,
    ]);
    Report::factory()->draft()->create(['report_year' => now()->year]);

    $administrator = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $administrator->assignRole($role);

    $this->actingAs($administrator);

    Livewire::test(ReportDashboard::class)
        ->assertSee('Rapport annuel lié')
        ->assertSee('Rapport trimestriel')
        ->assertSee('Rapport mensuel')
        ->assertSee('Projet de sécurité alimentaire')
        ->assertSee('Annuels')
        ->assertSee('Trimestriels')
        ->assertSee('Mensuels')
        ->assertSee('Brouillons')
        ->assertSee('1');
});

test('published pdf files can be previewed inline', function () {
    $path = 'reports/previewable.pdf';
    Storage::disk(Report::FILE_DISK)->put($path, '%PDF-1.4 test');

    $report = Report::factory()->create([
        'file_path' => $path,
        'original_filename' => 'rapport.pdf',
        'file_type' => Report::TYPE_PDF,
    ]);

    $user = User::factory()->create(['email_verified_at' => now()]);
    $this->actingAs($user);
    $response = $this->get(route('reports.preview', $report));

    $response->assertOk();
    expect($response->headers->get('Content-Type'))->toBe('application/pdf');
    expect($response->headers->get('Content-Disposition'))->toContain('inline');
    expect($response->headers->get('Accept-Ranges'))->toBe('bytes');

    $this->get(route('reports.preview', $report), ['Range' => 'bytes=0-3'])
        ->assertStatus(206)
        ->assertHeader('Content-Range', 'bytes 0-3/13');

    Livewire::test(ReportDashboard::class)
        ->call('openPreview', (string) $report->getKey())
        ->assertSee('Commandes du lecteur PDF')
        ->assertSee('Ajuster')
        ->assertSee('Plein écran')
        ->assertSee('data-report-chart="monthly"', false)
        ->assertSee('data-report-chart="trend"', false)
        ->assertSee('data-report-chart="formats"', false)
        ->assertSee('toolbar=0')
        ->assertDontSee('Télécharger');
});

test('draft reports cannot be previewed or downloaded', function () {
    $report = Report::factory()->draft()->create();
    $administrator = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $administrator->assignRole($role);

    $this->get(route('reports.preview', $report))->assertRedirect(route('login'));
    $this->actingAs($administrator)->get(route('reports.preview', $report))->assertNotFound();
    $this->actingAs($administrator)->get(route('reports.download', $report))->assertNotFound();
});

test('only administrators can download published reports', function () {
    $path = 'reports/administrator-only.pdf';
    Storage::disk(Report::FILE_DISK)->put($path, '%PDF-1.4 report');
    $report = Report::factory()->create(['file_path' => $path]);
    $regularUser = User::factory()->create(['email_verified_at' => now()]);

    $this->actingAs($regularUser)
        ->get(route('reports.download', $report))
        ->assertForbidden();

    $administrator = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'admin', 'guard_name' => 'web']);
    $administrator->assignRole($role);

    $this->actingAs($administrator)
        ->get(route('reports.download', $report))
        ->assertOk()
        ->assertDownload($report->original_filename);
});

test('filament can open the report management page for a super administrator', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $user->assignRole($role);

    $this->actingAs($user)
        ->get('/admin/reports')
        ->assertOk()
        ->assertSee('Rapports')
        ->assertSee('Annuels')
        ->assertSee('Trimestriels')
        ->assertSee('Mensuels')
        ->assertSee('Brouillons')
        ->assertSee('Rapports publiés')
        ->assertSee('Annuels')
        ->assertSee('Trimestriels')
        ->assertSee('Mensuels')
        ->assertSee('Espace utilisé');
});

test('role creation sanitizes resource permission fields before saving', function () {
    $baseAttributes = [
        'name' => 'Gestionnaire de rapports',
        'guard_name' => 'web',
    ];
    $permissionFields = [
        MediaResource::class => ['view_any_media'],
        ProjectResource::class => ['view_any_project'],
        ReportResource::class => ['view_any_report'],
        ServiceResource::class => ['view_any_service'],
    ];
    $data = [...$baseAttributes, ...$permissionFields];

    $createMethod = new ReflectionMethod(CreateRole::class, 'mutateFormDataBeforeCreate');
    $createAttributes = $createMethod->invoke(app(CreateRole::class), $data);

    expect($createAttributes)->toBe($baseAttributes);
    expect(Role::query()->create($createAttributes)->exists)->toBeTrue();

    $editMethod = new ReflectionMethod(EditRolePage::class, 'mutateFormDataBeforeSave');
    $editAttributes = $editMethod->invoke(app(EditRolePage::class), $data);

    expect($editAttributes)->toBe($baseAttributes);
});

test('filament site dashboard shows live analytics charts', function () {
    $user = User::factory()->create(['email_verified_at' => now()]);
    $role = Role::query()->create(['name' => 'super_admin', 'guard_name' => 'web']);
    $user->assignRole($role);

    $this->actingAs($user)
        ->get('/admin')
        ->assertOk()
        ->assertSee('Visites')
        ->assertSee('Visiteurs uniques')
        ->assertSee('Pages consultées')
        ->assertSee('Fréquentation du site')
        ->assertSee('Pages les plus consultées')
        ->assertSee('Parcours de conversion')
        ->assertSee('Appareils des visiteurs');
});
