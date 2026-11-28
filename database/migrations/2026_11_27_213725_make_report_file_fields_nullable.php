<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->string('file_path')->nullable()->change();
            $table->string('original_filename')->nullable()->change();
            $table->string('file_type', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('reports')->whereNull('file_path')->update(['file_path' => '']);
        DB::table('reports')->whereNull('original_filename')->update(['original_filename' => '']);
        DB::table('reports')->whereNull('file_type')->update(['file_type' => 'other']);

        Schema::table('reports', function (Blueprint $table) {
            $table->string('file_path')->nullable(false)->change();
            $table->string('original_filename')->nullable(false)->change();
            $table->string('file_type', 20)->nullable(false)->change();
        });
    }
};
