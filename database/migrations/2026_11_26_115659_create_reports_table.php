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
        Schema::create('reports', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 180);
            $table->text('description')->nullable();
            $table->string('period_type', 20);
            $table->unsignedSmallInteger('report_year');
            $table->unsignedTinyInteger('period_number')->nullable();
            $table->string('file_path');
            $table->string('original_filename');
            $table->string('mime_type', 120)->nullable();
            $table->string('file_type', 20);
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('status', 20)->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'report_year']);
            $table->index(['status', 'published_at']);
            $table->index(['period_type', 'report_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
