<?php

use App\Models\Project;

use function Pest\Laravel\get;

beforeEach(function (): void {
    $this->withoutVite();
});

it('filters projects by status from the url', function () {
    $completedProject = Project::factory()->create([
        'title' => 'Projet hydraulique termine',
        'status' => 'completed',
        'is_active' => true,
    ]);

    $ongoingProject = Project::factory()->create([
        'title' => 'Projet agricole en cours',
        'status' => 'ongoing',
        'is_active' => true,
    ]);

    get('/projects?status=completed')
        ->assertOk()
        ->assertSee($completedProject->title)
        ->assertDontSee($ongoingProject->title);
});

it('ignores invalid status and sort values from the url', function () {
    $plannedProject = Project::factory()->create([
        'title' => 'Projet planifie visible',
        'status' => 'planned',
        'is_active' => true,
    ]);

    $completedProject = Project::factory()->create([
        'title' => 'Projet termine visible',
        'status' => 'completed',
        'is_active' => true,
    ]);

    get('/projects?status=not-a-status&sort=not-a-sort')
        ->assertOk()
        ->assertSee($plannedProject->title)
        ->assertSee($completedProject->title);
});

it('renders live filter bindings for Livewire 4', function () {
    get('/projects')
        ->assertOk()
        ->assertSee('wire:model.live.preserve-scroll="filter"', false)
        ->assertSee('wire:model.live.debounce.250ms.preserve-scroll="search"', false)
        ->assertSee('wire:click.preserve-scroll="$set(\'sort\',', false)
        ->assertSee('wire:target="search,filter,sort,clearFilters,gotoPage,nextPage,previousPage"', false)
        ->assertSee('wire:loading.delay', false)
        ->assertSee('min-h-[34rem]', false)
        ->assertDontSee('autoAnimate($el', false);
});

it('does not predefine Alpine before Filament loads its scripts', function () {
    get('/admin/login')
        ->assertOk()
        ->assertDontSee('window.Alpine = window.Alpine || {}', false);
});
