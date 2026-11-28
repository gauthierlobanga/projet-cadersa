<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const PROJECT_SLUGS = [
        'portfolio-personnel-tall-stack',
        'dashboard-de-gestion-pour-une-pme',
        'api-rest-securisee-avec-laravel-sanctum',
        'migration-react-vers-inertiajs-dans-laravel',
        'site-vitrine-pour-une-ong-locale',
        'plateforme-ecommerce-avec-laravel-livewire',
        'automatisation-cicd-avec-docker-et-gitlab',
        'systeme-de-gestion-de-formations-en-ligne',
        'blog-technique-avec-laravel',
        'application-de-suivi-de-projet-freelance',
    ];

    private const LEGACY_POST_CATEGORIES = [
        'laravel', 'livewire', 'react-inertia', 'filament', 'tailwind-css', 'alpine-js', 'developpement-web', 'carriere',
    ];

    public function up(): void
    {
        Schema::create('legacy_demo_content_snapshots', function (Blueprint $table): void {
            $table->id();
            $table->string('table_name', 64);
            $table->char('record_id', 36);
            $table->json('record_values');
            $table->timestamps();
            $table->unique(['table_name', 'record_id']);
        });

        $now = now();

        $projects = DB::table('projects')
            ->whereIn('slug', self::PROJECT_SLUGS)
            ->where('is_active', true)
            ->whereNull('deleted_at');
        $this->snapshot('projects', $projects, ['is_active', 'deleted_at', 'updated_at']);
        $projects->update(['is_active' => false, 'deleted_at' => $now, 'updated_at' => $now]);

        $posts = DB::table('posts')
            ->whereNull('deleted_at')
            ->where(function (Builder $query): void {
                $query->where('slug', 'retour-dexperience-sur-la-creation-de-mon-portfolio-tall')
                    ->orWhere('metadata', 'like', '%Développeur Full%');
            });
        $this->snapshot('posts', $posts, ['deleted_at', 'updated_at']);
        $posts->update(['deleted_at' => $now, 'updated_at' => $now]);

        $faqs = DB::table('faqs')
            ->whereNull('deleted_at')
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->where('answer', 'like', '%développeur%')
                    ->orWhere('answer', 'like', '%Laravel%')
                    ->orWhere('answer', 'like', '%TALL stack%')
                    ->orWhere('answer', 'like', '%Gauthier%')
                    ->orWhere('answer', 'like', '%portfolio%');
            });
        $this->snapshot('faqs', $faqs, ['is_active', 'updated_at']);
        $faqs->update(['is_active' => false, 'updated_at' => $now]);

        $teamMembers = DB::table('team_members')
            ->whereNull('deleted_at')
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->where('email', 'like', '%@example.com')
                    ->orWhere('role', 'like', '%Développeur%')
                    ->orWhere('bio', 'like', '%Laravel%');
            });
        $this->snapshot('team_members', $teamMembers, ['is_active', 'updated_at']);
        $teamMembers->update(['is_active' => false, 'updated_at' => $now]);

        $testimonials = DB::table('testimonials')
            ->whereNull('deleted_at')
            ->where('is_active', true)
            ->where(function (Builder $query): void {
                $query->where('content', 'like', '%Gauthier%')
                    ->orWhere('content', 'like', '%développeur%')
                    ->orWhere('role', 'like', '%Développeur%');
            });
        $this->snapshot('testimonials', $testimonials, ['is_active', 'updated_at']);
        $testimonials->update(['is_active' => false, 'updated_at' => $now]);

        $legacyCategoryIds = DB::table('posts_categories')
            ->whereIn('slug', self::LEGACY_POST_CATEGORIES)
            ->pluck('id');
        $categories = DB::table('posts_categories')
            ->where(function (Builder $query) use ($legacyCategoryIds): void {
                $query->whereIn('id', $legacyCategoryIds)
                    ->orWhereIn('parent_id', $legacyCategoryIds);
            });
        $this->snapshot('posts_categories', $categories, ['est_active', 'est_visible_dans_menu', 'updated_at']);
        $categories->update(['est_active' => false, 'est_visible_dans_menu' => false, 'updated_at' => $now]);
    }

    public function down(): void
    {
        foreach (DB::table('legacy_demo_content_snapshots')->get() as $snapshot) {
            $values = json_decode((string) $snapshot->record_values, true);

            if (! is_array($values)) {
                continue;
            }

            DB::table($snapshot->table_name)
                ->where('id', $snapshot->record_id)
                ->update($values);
        }

        Schema::dropIfExists('legacy_demo_content_snapshots');
    }

    /**
     * @param  list<string>  $columns
     */
    private function snapshot(string $tableName, Builder $query, array $columns): void
    {
        $timestamp = now();

        foreach ($query->get(['id', ...$columns]) as $record) {
            $values = [];

            foreach ($columns as $column) {
                $values[$column] = $record->{$column};
            }

            DB::table('legacy_demo_content_snapshots')->insert([
                'table_name' => $tableName,
                'record_id' => $record->id,
                'record_values' => json_encode($values, JSON_THROW_ON_ERROR),
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
};
