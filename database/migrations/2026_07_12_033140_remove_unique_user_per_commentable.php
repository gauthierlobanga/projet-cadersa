<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropUnique('comments_commentable_id_commentable_type_user_id_unique');
            $table->index(['commentable_id', 'commentable_type', 'user_id'], 'comments_commented_by_idx');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unique(['commentable_id', 'commentable_type', 'user_id'], 'comments_commentable_id_commentable_type_user_id_unique');
        });
    }
};
