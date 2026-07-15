<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class CadersaAsblDocumentLegal extends Model implements HasMedia
{
    use HasUuids, InteractsWithMedia, SoftDeletes;

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

    /**
     * registerMediaCollections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('document')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['application/pdf']);
    }

    /**
     * typeDocument.
     */
    public function typeDocument(): BelongsTo
    {
        return $this->belongsTo(TypeDocumentLegal::class, 'type_document_id');
    }

    /**
     * verifiePar.
     */
    public function verifiePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verifie_par');
    }

    /**
     * getPdfUrlAttribute.
     */
    public function getPdfUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('document');
    }

    /**
     * hasPdf.
     */
    public function hasPdf(): bool
    {
        return $this->getFirstMedia('document') !== null;
    }
}
