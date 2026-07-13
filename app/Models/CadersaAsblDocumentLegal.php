<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CadersaAsblDocumentLegal extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'legal_documents';

    protected $fillable = [
        'type_document_id',
        'numero_document',
        'date_delivrance',
        'date_expiration',
        'lieu_delivrance',
        'autorite_delivrance',
        'metadata',
        'est_verifie',
        'verifie_le',
        'verifie_par',
    ];

    protected $casts = [
        'date_delivrance' => 'date',
        'date_expiration' => 'date',
        'est_verifie' => 'boolean',
        'verifie_le' => 'datetime',
        'metadata' => 'array',
    ];

    public function typeDocument(): BelongsTo
    {
        return $this->belongsTo(TypeDocumentLegal::class, 'type_document_id');
    }

    public function verifiePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifie_par');
    }
}
