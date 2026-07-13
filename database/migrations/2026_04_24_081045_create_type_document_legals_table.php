<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Table des types de documents légaux
        Schema::create('type_documents_legaux', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->unique();
            $table->string('nom');
            $table->text('description')->nullable();
            $table->string('autorite_emettrice')->nullable();
            $table->boolean('est_obligatoire')->default(true);
            $table->string('forme_juridique')->nullable()->comment('societe_commerciale, petit_commercant, organisation_sans_but_lucratif, toutes');
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });

        // 2. Table des documents légaux (polymorphe)
        Schema::create('legal_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuidMorphs('documentable'); // documentable_type, documentable_id
            $table->foreignUuid('type_document_id')->constrained('type_documents_legaux')->cascadeOnDelete();
            $table->string('numero_document')->nullable();
            $table->date('date_delivrance')->nullable();
            $table->date('date_expiration')->nullable();
            $table->string('lieu_delivrance')->nullable();
            $table->string('autorite_delivrance')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('est_verifie')->default(false);
            $table->timestamp('verifie_le')->nullable();
            $table->foreignUuid('verifie_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            // Index pour accélérer les recherches
            $table->unique(['documentable_type', 'documentable_id', 'type_document_id'], 'legal_docs_unique');
        });

        // 3. Remplir les types de documents
        $this->seedTypeDocuments();
    }

    private function seedTypeDocuments(): void
    {
        $types = [
            [
                'code' => 'RCCM',
                'nom' => 'Registre du Commerce et du Crédit Mobilier',
                'description' => 'Numéro d\'immatriculation au registre du commerce',
                'autorite_emettrice' => 'Guichet Unique de Création d\'Entreprise (GUCE)',
                'est_obligatoire' => true,
                'forme_juridique' => 'societe_commerciale',
                'ordre' => 1,
            ],
            [
                'code' => 'PATENTE',
                'nom' => 'Patente commerciale',
                'description' => 'Autorisation annuelle d\'exercer une activité commerciale',
                'autorite_emettrice' => 'Direction Générale des Recettes (DGR)',
                'est_obligatoire' => true,
                'forme_juridique' => 'petit_commercant',
                'ordre' => 2,
            ],
            [
                'code' => 'IFU',
                'nom' => 'Identifiant Fiscal Unique (Numéro Impôt)',
                'description' => 'Numéro d\'identification fiscale',
                'autorite_emettrice' => 'Direction Générale des Impôts (DGI)',
                'est_obligatoire' => true,
                'forme_juridique' => 'toutes',
                'ordre' => 3,
            ],
            [
                'code' => 'ID_NAT',
                'nom' => 'Identification Nationale',
                'description' => 'Carte d\'identité nationale congolaise',
                'autorite_emettrice' => 'Office National de l\'Identification de la Population (ONIP)',
                'est_obligatoire' => true,
                'forme_juridique' => 'toutes',
                'ordre' => 4,
            ],
            [
                'code' => 'STATUTS',
                'nom' => 'Statuts notariés',
                'description' => 'Acte de création de la société ou de l\'ASBL',
                'autorite_emettrice' => 'Notaire / Tribunal de Commerce',
                'est_obligatoire' => true,
                'forme_juridique' => 'societe_commerciale',
                'ordre' => 5,
            ],
            [
                'code' => 'PERSONNALITE_JURIDIQUE',
                'nom' => 'Personnalité juridique (ASBL)',
                'description' => 'Document de reconnaissance légale pour les ASBL',
                'autorite_emettrice' => 'Ministère de la Justice',
                'est_obligatoire' => false,
                'forme_juridique' => 'organisation_sans_but_lucratif',
                'ordre' => 6,
            ],
            [
                'code' => 'TPE',
                'nom' => 'Taxe Professionnelle sur les Entreprises',
                'description' => 'Attestation de paiement de la TPE',
                'autorite_emettrice' => 'DGRAD / DGI',
                'est_obligatoire' => false,
                'forme_juridique' => 'societe_commerciale',
                'ordre' => 7,
            ],
            [
                'code' => 'AUTORISATION_FONCTIONNEMENT',
                'nom' => 'Autorisation de fonctionnement',
                'description' => 'Autorisation spécifique selon le secteur d\'activité (ex: santé, agriculture)',
                'autorite_emettrice' => 'Ministère sectoriel compétent',
                'est_obligatoire' => false,
                'forme_juridique' => 'organisation_sans_but_lucratif',
                'ordre' => 8,
            ],
            [
                'code' => 'ATTESTATION_FISCALE',
                'nom' => 'Attestation de situation fiscale',
                'description' => 'Attestation de régularité fiscale',
                'autorite_emettrice' => 'DGI',
                'est_obligatoire' => false,
                'forme_juridique' => 'toutes',
                'ordre' => 9,
            ],
            [
                'code' => 'CARTE_ARTISAN',
                'nom' => 'Carte d\'artisan',
                'description' => 'Carte professionnelle d\'artisan',
                'autorite_emettrice' => 'Ministère des PME/Artisanat',
                'est_obligatoire' => true,
                'forme_juridique' => 'petit_commercant',
                'ordre' => 10,
            ],
            // Ajoutez d'autres types spécifiques à CADERSA si besoin
        ];

        foreach ($types as $type) {
            DB::table('type_documents_legaux')->insert(array_merge($type, [
                'id' => Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_documents');
        Schema::dropIfExists('type_documents_legaux');
    }
};
