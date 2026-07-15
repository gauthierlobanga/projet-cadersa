<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class NewsletterCampaign extends Model
{
    use HasFactory, SoftDeletes;
    use HasUuids;

    /**
     * Indique que les clés primaires sont de type string (UUID)
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indique que les clés primaires ne sont pas auto-incrémentées
     *
     * @var bool
     */
    public $incrementing = false;

    protected $table = 'newsletter_campaigns';

    protected $fillable = [
        'titre',
        'sujet',
        'contenu_html',
        'contenu_text',
        'segments_cibles',
        'status',
        'scheduled_at',
        'sent_at',
        'total_envoyes',
        'total_ouverts',
        'total_clics',
        'total_desabonnements',
        'statistiques',
        'cree_par',
        'metadata',
    ];

    protected $casts = [
        'segments_cibles' => 'array',
        'statistiques' => 'array',
        'metadata' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];

    const STATUS_BROUILLON = 'brouillon';

    const STATUS_PROGRAMME = 'programme';

    const STATUS_ENVOYE = 'envoye';

    const STATUS_ANNULE = 'annule';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_BROUILLON => 'Brouillon',
            self::STATUS_PROGRAMME => 'Programmé',
            self::STATUS_ENVOYE => 'Envoyé',
            self::STATUS_ANNULE => 'Annulé',
        ];
    }

    // Relations
    /**
     * creePar.
     */
    public function creePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cree_par');
    }

    /**
     * envois.
     */
    public function envois(): HasMany
    {
        return $this->hasMany(NewsletterSend::class, 'campaign_id');
    }

    // Accessors
    /**
     * getStatusLabelAttribute.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    /**
     * getStatusColorAttribute.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_BROUILLON => 'gray',
            self::STATUS_PROGRAMME => 'warning',
            self::STATUS_ENVOYE => 'success',
            self::STATUS_ANNULE => 'danger',
            default => 'gray',
        };
    }

    /**
     * getTauxOuvertureAttribute.
     */
    public function getTauxOuvertureAttribute(): float
    {
        if ($this->total_envoyes == 0) {
            return 0;
        }

        return round(($this->total_ouverts / $this->total_envoyes) * 100, 2);
    }

    /**
     * getTauxClicAttribute.
     */
    public function getTauxClicAttribute(): float
    {
        if ($this->total_envoyes == 0) {
            return 0;
        }

        return round(($this->total_clics / $this->total_envoyes) * 100, 2);
    }

    /**
     * getTauxDesabonnementAttribute.
     */
    public function getTauxDesabonnementAttribute(): float
    {
        if ($this->total_envoyes == 0) {
            return 0;
        }

        return round(($this->total_desabonnements / $this->total_envoyes) * 100, 2);
    }

    // Scopes
    /**
     * scopeEnvoyes.
     *
     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeEnvoyes(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_ENVOYE);
    }

    /**
     * scopeProgrammes.

     *

     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeProgrammes(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PROGRAMME)
            ->where('scheduled_at', '>', now());
    }

    /**
     * scopeABientot.

     *

     * @param Builder<self> $query
     * @return Builder<self>
     */
    public function scopeABientot(Builder $query, $hours = 24): Builder
    {
        return $query->where('status', self::STATUS_PROGRAMME)
            ->whereBetween('scheduled_at', [now(), now()->addHours($hours)]);
    }

    // Méthodes métier
    /**
     * programmer.
     */
    public function programmer(\DateTime $date): void
    {
        $this->status = self::STATUS_PROGRAMME;
        $this->scheduled_at = $date;
        $this->save();
    }

    /**
     * annuler.
     */
    public function annuler(): void
    {
        $this->status = self::STATUS_ANNULE;
        $this->save();
    }

    /**
     * envoyer.
     */
    public function envoyer(): void
    {
        $this->status = self::STATUS_ENVOYE;
        $this->sent_at = now();
        $this->save();
    }

    /**
     * incrementerEnvoyes.
     */
    public function incrementerEnvoyes(int $count = 1): void
    {
        $this->increment('total_envoyes', $count);
    }

    /**
     * incrementerOuverts.
     */
    public function incrementerOuverts(int $count = 1): void
    {
        $this->increment('total_ouverts', $count);
        $this->updateTaux();
    }

    /**
     * incrementerClics.
     */
    public function incrementerClics(int $count = 1): void
    {
        $this->increment('total_clics', $count);
        $this->updateTaux();
    }

    /**
     * incrementerDesabonnements.
     */
    public function incrementerDesabonnements(int $count = 1): void
    {
        $this->increment('total_desabonnements', $count);
        $this->updateTaux();
    }

    private function updateTaux(): void
    {
        $stats = $this->statistiques ?? [];
        $stats['taux_ouverture'] = $this->taux_ouverture;
        $stats['taux_clic'] = $this->taux_clic;
        $stats['taux_desabonnement'] = $this->taux_desabonnement;
        $this->statistiques = $stats;
        $this->save();
    }

    /**
     * getAbonnesCibles.
     */
    public function getAbonnesCibles(): Collection
    {
        $query = Newsletter::actifs();

        $segments = $this->segments_cibles ?? [];

        if (! empty($segments['categories'])) {
            // Filtrer par catégories d'intérêt
            $query->whereJsonContains('preferences->categories', $segments['categories']);
        }

        if (! empty($segments['date_inscription_min'])) {
            $query->where('created_at', '>=', $segments['date_inscription_min']);
        }

        if (! empty($segments['date_inscription_max'])) {
            $query->where('created_at', '<=', $segments['date_inscription_max']);
        }

        return $query->get();
    }
}
