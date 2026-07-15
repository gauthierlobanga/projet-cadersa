/**
 * Method.
 *
 * @return mixed
 */
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = [
        'notifiable_type', 'notifiable_id', 'type',
        'sujet', 'contenu', 'statut', 'metadata',
        'date_envoi', 'date_lecture',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'contenu' => 'array',
            'date_envoi' => 'datetime',
            'date_lecture' => 'datetime',
        ];
    }

    public const string TYPE_EMAIL = 'email';

    public const string TYPE_SMS = 'sms';

    public const string TYPE_PUSH = 'push';

    public const string STATUT_EN_ATTENTE = 'en_attente';

    public const string STATUT_ENVOYE = 'envoye';

    public const string STATUT_ECHEC = 'echec';

    /**
     * notifiable.
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * scopeNonEnvoyees.

     *

     * @return mixed
     */
    public function scopeNonEnvoyees($query)
    {
        return $query->where('statut', self::STATUT_EN_ATTENTE);
    }

    /**
     * scopePourUtilisateur.

     *

     * @return mixed
     */
    public function scopePourUtilisateur($query, User $user)
    {
        return $query->where('notifiable_type', User::class)
            ->where('notifiable_id', $user->id);
    }
}
