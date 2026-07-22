<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('profile_url')->nullable()->after('company');
            $table->tinyInteger('rating')->nullable()->default(5)->after('profile_url');
            $table->string('platform')->nullable()->after('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['profile_url', 'rating', 'platform']);
        });
    }
};
