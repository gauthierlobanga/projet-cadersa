<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ------------------------------------------------------------
        // 1. SERVICES
        // ------------------------------------------------------------
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('excerpt')->nullable();
            $table->json('content')->nullable(); // pour RichEditor/Tiptap
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('sort_order');
        });

        // ------------------------------------------------------------
        // 2. PROJECTS
        // ------------------------------------------------------------
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('excerpt')->nullable();
            $table->json('content')->nullable(); // pour RichEditor/Tiptap
            $table->string('location')->nullable();
            $table->enum('status', ['planned', 'ongoing', 'completed'])->default('ongoing');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('status');
            $table->index('start_date');
        });

        // ------------------------------------------------------------
        // 3. PIVOT SERVICE ↔ PROJECT
        // ------------------------------------------------------------
        Schema::create('service_project_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('service_id')
                ->constrained('services')
                ->cascadeOnDelete();
            $table->foreignUuid('project_id')
                ->constrained('projects')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['service_id', 'project_id']);
            $table->index(['service_id', 'project_id']);
        });

        // ------------------------------------------------------------
        // 4. TEAM MEMBERS
        // ------------------------------------------------------------
        Schema::create('team_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role');
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('sort_order');
            $table->index('email');
        });

        // ------------------------------------------------------------
        // 5. PARTNERS
        // ------------------------------------------------------------
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('sort_order');
        });

        // ------------------------------------------------------------
        // 6. TESTIMONIALS
        // ------------------------------------------------------------
        Schema::create('testimonials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('role')->nullable();
            $table->string('company')->nullable();
            $table->text('content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
        });

        // ------------------------------------------------------------
        // 7. FAQS
        // ------------------------------------------------------------
        Schema::create('faqs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('question');
            $table->text('answer');
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('sort_order');
        });

        // ------------------------------------------------------------
        // 8. POSTS (dépend de users)
        // ------------------------------------------------------------
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->json('excerpt')->nullable();
            $table->json('content')->nullable(); // pour RichEditor/Tiptap
            $table->json('metadata')->nullable();
            $table->enum('status', ['draft', 'published', 'scheduled', 'expired', 'archived'])->default('draft');
            $table->boolean('is_pinned')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->integer('reading_time_minutes')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'published_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('scheduled_for');
            $table->index('expires_at');
            if (DB::connection()->getDriverName() !== 'sqlite') {
                $table->fullText(['title']); // content est JSON, MySQL ne supporte pas FullText dessus
            }
        });

        // ------------------------------------------------------------
        // 9. POSTS CATEGORIES (hiérarchique, noms en français)
        // ------------------------------------------------------------
        Schema::create('posts_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('parent_id')
                ->nullable()
                ->constrained('posts_categories')
                ->nullOnDelete();
            $table->string('nom');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('color')->nullable();
            $table->json('metadata')->nullable();
            $table->integer('ordre')->default(0);
            $table->boolean('est_active')->default(true);
            $table->boolean('est_visible_dans_menu')->default(true);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['est_active', 'ordre']);
            $table->index('parent_id');
        });

        // ------------------------------------------------------------
        // 10. PIVOT POSTS ↔ CATEGORIES
        // ------------------------------------------------------------
        Schema::create('posts_categories_pivot', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->foreignUuid('category_id')
                ->constrained('posts_categories')
                ->cascadeOnDelete();
            $table->boolean('est_principale')->default(false);
            $table->integer('ordre')->default(0);
            $table->timestamps();

            $table->index(['post_id', 'est_principale']);
        });

        // ------------------------------------------------------------
        // 11. PIVOT SERVICE ↔ POST
        // ------------------------------------------------------------
        Schema::create('service_post_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('service_id')
                ->constrained('services')
                ->cascadeOnDelete();
            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['service_id', 'post_id']);
            $table->index(['service_id', 'post_id']);
        });

        // ------------------------------------------------------------
        // 12. POST LIKES
        // ------------------------------------------------------------
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->uuid('post_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->cascadeOnDelete();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique(['post_id', 'user_id']);
        });

        // ------------------------------------------------------------
        // 13. POST BOOKMARKS
        // ------------------------------------------------------------
        Schema::create('post_bookmarks', function (Blueprint $table) {
            $table->id();
            $table->uuid('post_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('post_id')
                ->references('id')
                ->on('posts')
                ->cascadeOnDelete();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->unique(['post_id', 'user_id']);
        });

        // ------------------------------------------------------------
        // 14. POST RELATED
        // ------------------------------------------------------------
        Schema::create('post_related', function (Blueprint $table) {
            $table->foreignUuid('post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->foreignUuid('related_post_id')
                ->constrained('posts')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['post_id', 'related_post_id']);
        });

        // ------------------------------------------------------------
        // 15. COMMENTS (polymorphiques)
        // ------------------------------------------------------------
        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('content');
            $table->json('metadata')->nullable();
            $table->enum('status', ['pending', 'approved', 'spam', 'trashed'])->default('pending');
            $table->integer('likes_count')->default(0);
            $table->integer('dislikes_count')->default(0);
            $table->integer('replies_count')->default(0);
            $table->integer('reports_count')->default(0);
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('edited_at')->nullable();

            // Polymorphic relation
            $table->uuidMorphs('commentable');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index('status');
            $table->index('content');
            $table->unique(['commentable_id', 'commentable_type', 'user_id']);
        });

        // ------------------------------------------------------------
        // 16. COMMENT LIKES
        // ------------------------------------------------------------
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('comment_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['like', 'dislike'])->default('like');
            $table->timestamps();

            $table->unique(['comment_id', 'user_id']);
            $table->index(['comment_id', 'type']);
        });

        // ------------------------------------------------------------
        // 17. COMMENT REPORTS
        // ------------------------------------------------------------
        Schema::create('comment_reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('comment_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('reason');
            $table->text('details')->nullable();
            $table->enum('status', ['pending', 'resolved', 'dismissed'])->default('pending');
            $table->timestamps();

            $table->unique(['comment_id', 'user_id']);
            $table->index(['status', 'created_at']);
        });

        // ------------------------------------------------------------
        // 18. COMMENT MENTIONS
        // ------------------------------------------------------------
        Schema::create('comment_mentions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('comment_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['comment_id', 'user_id']);
        });

        // ------------------------------------------------------------
        // 19. CONTACTS
        // ------------------------------------------------------------
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('email');
            $table->string('telephone')->nullable();
            $table->string('sujet');
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->enum('status', ['en_attente', 'lu', 'repondu', 'archive', 'spam'])->default('en_attente');
            $table->enum('priorite', ['basse', 'moyenne', 'haute', 'urgente'])->default('moyenne');
            $table->enum('categorie', ['general', 'commercial', 'technique', 'support', 'reclamation'])->default('general');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('reponse')->nullable();
            $table->foreignUuid('repondu_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('lu_at')->nullable();
            $table->timestamp('repondu_at')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['email', 'status']);
            $table->index('status');
            $table->index('priorite');
            $table->index('categorie');
            $table->index('created_at');
        });

        // ------------------------------------------------------------
        // 20. NEWSLETTERS (abonnés)
        // ------------------------------------------------------------
        Schema::create('newsletters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique();
            $table->string('prenom')->nullable();
            $table->string('nom')->nullable();
            $table->json('preferences')->nullable();
            $table->string('token_confirmation')->unique();
            $table->timestamp('confirmed_at')->nullable();
            $table->boolean('is_active')->default(false);
            $table->enum('source', ['formulaire', 'compte', 'import'])->default('formulaire');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['email', 'is_active']);
            $table->index('confirmed_at');
            $table->index('source');
        });

        // ------------------------------------------------------------
        // 21. NEWSLETTER CAMPAIGNS
        // ------------------------------------------------------------
        Schema::create('newsletter_campaigns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titre');
            $table->string('sujet');
            $table->text('contenu_html');
            $table->text('contenu_text')->nullable();
            $table->json('segments_cibles')->nullable();
            $table->enum('status', ['brouillon', 'programme', 'envoye', 'annule'])->default('brouillon');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->integer('total_envoyes')->default(0);
            $table->integer('total_ouverts')->default(0);
            $table->integer('total_clics')->default(0);
            $table->integer('total_desabonnements')->default(0);
            $table->json('statistiques')->nullable();
            $table->foreignUuid('cree_par')->constrained('users')->cascadeOnDelete();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('scheduled_at');
            $table->index('sent_at');
        });

        // ------------------------------------------------------------
        // 22. NEWSLETTER SENDS
        // ------------------------------------------------------------
        Schema::create('newsletter_sends', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('campaign_id')->constrained('newsletter_campaigns')->cascadeOnDelete();
            $table->foreignUuid('newsletter_id')->constrained('newsletters')->cascadeOnDelete();
            $table->string('email');
            $table->enum('status', ['envoye', 'ouvert', 'clique', 'erreur', 'desabonne'])->default('envoye');
            $table->timestamp('opened_at')->nullable();
            $table->timestamp('clicked_at')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->unique(['campaign_id', 'newsletter_id']);
            $table->index(['campaign_id', 'status']);
            $table->index('opened_at');
            $table->index('clicked_at');
        });

        // ------------------------------------------------------------
        // 23. VISITOR EVENTS (tracking générique)
        // ------------------------------------------------------------
        Schema::create('visitor_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('session_id')->index();
            $table->string('visitor_id')->nullable();
            $table->string('event_type'); // page_view, download, share, etc.
            $table->string('url')->nullable();
            $table->uuid('page_id')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at')->useCurrent();
            $table->timestamps();

            $table->index(['event_type', 'occurred_at', 'visitor_id']);
        });

        // ------------------------------------------------------------
        // 24. PAGE VIEWS
        // ------------------------------------------------------------
        Schema::create('page_views', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('page_id');
            $table->string('session_id')->nullable();
            $table->string('visitor_id')->nullable();
            $table->string('url')->nullable();
            $table->timestamp('viewed_at')->useCurrent();
            $table->timestamps();

            $table->index('page_id');
            $table->index('viewed_at');
        });

        // ------------------------------------------------------------
        // 25. CONVERSION EVENTS (funnel)
        // ------------------------------------------------------------
        Schema::create('conversion_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('session_id')->index();
            $table->string('visitor_id')->index();
            $table->string('step'); // ex: newsletter_signup, contact_submit, project_view
            $table->boolean('completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->index(['step', 'completed_at']);
        });

        // ------------------------------------------------------------
        // 26. VISITS (détaillées, polymorphiques)
        // ------------------------------------------------------------
        Schema::create('visits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('visitor_id')->index();
            $table->string('session_id')->nullable()->index();
            $table->nullableUuidMorphs('visitable');
            $table->string('url')->nullable();
            $table->string('path')->nullable();
            $table->string('method')->default('GET');
            $table->string('referrer')->nullable();
            $table->string('ip')->nullable();
            $table->string('device')->nullable();
            $table->string('platform')->nullable();
            $table->string('browser')->nullable();
            $table->string('language')->nullable();
            $table->json('utm_params')->nullable();
            $table->integer('duration')->default(0);
            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();

            $table->index('visited_at');
        });
    }

    public function down(): void
    {
        // Ordre inverse
        Schema::dropIfExists('visits');
        Schema::dropIfExists('conversion_events');
        Schema::dropIfExists('page_views');
        Schema::dropIfExists('visitor_events');
        Schema::dropIfExists('newsletter_sends');
        Schema::dropIfExists('newsletter_campaigns');
        Schema::dropIfExists('newsletters');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('comment_mentions');
        Schema::dropIfExists('comment_reports');
        Schema::dropIfExists('comment_likes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('post_related');
        Schema::dropIfExists('post_bookmarks');
        Schema::dropIfExists('post_likes');
        Schema::dropIfExists('service_post_pivot');
        Schema::dropIfExists('posts_categories_pivot');
        Schema::dropIfExists('posts_categories');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('service_project_pivot');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('services');
    }
};
