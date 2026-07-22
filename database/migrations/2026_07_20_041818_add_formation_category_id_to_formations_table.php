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
        Schema::table('formations', function (Blueprint $table) {
            $table->foreignUuid('formation_category_id')->nullable()->constrained('formation_categories')->nullOnDelete()->after('id');
            $table->foreignUuid('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('formations', function (Blueprint $table) {
            $table->dropConstrainedForeignId('formation_category_id');
            $table->dropConstrainedForeignId('user_id');
        });
    }
};
