<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ajouter la colonne seulement si elle n'existe pas
        if (! Schema::hasColumn('type_documents_legaux', 'forme_juridique')) {
            Schema::table('type_documents_legaux', function (Blueprint $table) {
                $table->string('forme_juridique')->nullable()->after('est_obligatoire');
            });
        }

        // 2. Mettre à jour les enregistrements existants
        // On vérifie d'abord que la colonne existe (sécurité)
        if (Schema::hasColumn('type_documents_legaux', 'forme_juridique')) {
            DB::table('type_documents_legaux')
                ->whereIn('code', ['RCCM', 'STATUTS', 'CARTE_ARTISAN', 'TPE'])
                ->whereNull('forme_juridique') // Évite de réécrire si déjà défini
                ->update(['forme_juridique' => 'societe_commerciale']);

            DB::table('type_documents_legaux')
                ->where('code', 'PATENTE')
                ->whereNull('forme_juridique')
                ->update(['forme_juridique' => 'petit_commercant']);

            DB::table('type_documents_legaux')
                ->where('code', 'PERSONNALITE_JURIDIQUE')
                ->whereNull('forme_juridique')
                ->update(['forme_juridique' => 'organisation_sans_but_lucratif']);

            DB::table('type_documents_legaux')
                ->whereIn('code', ['ID_NAT', 'IFU'])
                ->whereNull('forme_juridique')
                ->update(['forme_juridique' => 'toutes']);
        }
    }

    public function down(): void
    {
        Schema::table('type_documents_legaux', function (Blueprint $table) {
            if (Schema::hasColumn('type_documents_legaux', 'forme_juridique')) {
                $table->dropColumn('forme_juridique');
            }
        });
    }
};
