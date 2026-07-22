<?php

use App\Filament\Resources\Projects\Schemas\ProjectForm;
use App\Models\Project;
use Filament\Schemas\Components\Component as SchemaComponent;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Contracts\TranslatableContentDriver;
use Livewire\Component as LivewireComponent;

it('can be created', function () {
    $project = Project::factory()->create([
        'title' => 'Test Project',
    ]);

    expect($project)->toBeInstanceOf(Project::class)
        ->and($project->title)->toBe('Test Project')
        ->and($project->slug)->not->toBeEmpty();
});

it('uses model attribute names for project case study and seo fields', function () {
    $livewire = new class extends LivewireComponent implements HasSchemas
    {
        public function render()
        {
            return '';
        }

        public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
        {
            return null;
        }

        public function getOldSchemaState(string $statePath): mixed
        {
            return null;
        }

        public function getSchemaComponent(string $key, bool $withHidden = false, array $skipComponentsChildContainersWhileSearching = []): ?SchemaComponent
        {
            return null;
        }

        public function getSchema(string $name): ?Schema
        {
            return null;
        }

        public function currentlyValidatingSchema(?Schema $schema): void {}

        public function getDefaultTestingSchemaName(): ?string
        {
            return null;
        }
    };

    $schema = ProjectForm::configure(Schema::make($livewire));
    $fieldNames = collect($schema->getFlatFields())
        ->map(fn ($field) => $field->getName())
        ->all();

    expect($fieldNames)->toContain('problematic');
    expect($fieldNames)->toContain('solution');
    expect($fieldNames)->toContain('results');
    expect($fieldNames)->toContain('meta_title');
    expect($fieldNames)->toContain('meta_description');
    expect($fieldNames)->not->toContain('case_study_problem');
    expect($fieldNames)->not->toContain('case_study_solution');
    expect($fieldNames)->not->toContain('case_study_results');
    expect($fieldNames)->not->toContain('seo_title');
    expect($fieldNames)->not->toContain('seo_description');
});

it('has a renderRichContent method', function () {
    $project = Project::factory()->create();

    expect(method_exists($project, 'renderRichContent'))->toBeTrue();
    expect($project->renderRichContent('content'))->toBeString();
});
