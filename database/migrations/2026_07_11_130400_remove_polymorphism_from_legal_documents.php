<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('legal_documents', function (Blueprint $table) {
            // Supprimer l'index unique polymorphique
            $table->dropUnique('legal_docs_unique');

            // Supprimer les colonnes morph
            $table->dropMorphs('documentable');
        });
    }

    public function down(): void
    {
        // Pas de rollback nécessaire
    }
};
