<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Newsletter extends Model
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

    protected $table = 'newsletters';

    protected $fillable = [
        'email',
        'prenom',
        'nom',
        'preferences',
        'token_confirmation',
        'confirmed_at',
        'is_active',
        'source',
        'ip_address',
        'user_agent',
        'metadata',
    ];

    protected $casts = [
        'preferences' => 'array',
        'metadata' => 'array',
        'confirmed_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // Relations
    /**
     * envois.
     */
    public function envois(): HasMany
    {
        return $this->hasMany(NewsletterSend::class);
    }

    // Accessors
    /**
     * getFullNameAttribute.
     */
    public function getFullNameAttribute(): string
    {
        return trim($this->prenom.' '.$this->nom);
    }

    /**
     * getEstConfirmeAttribute.
     */
    public function getEstConfirmeAttribute(): bool
    {
        return ! is_null($this->confirmed_at) && $this->is_active;
    }

    /**
     * getPreferencesCategoriesAttribute.
     */
    public function getPreferencesCategoriesAttribute(): array
    {
        return $this->preferences['categories'] ?? [];
    }

    /**
     * getPreferencesFrequenceAttribute.
     */
    public function getPreferencesFrequenceAttribute(): string
    {
        return $this->preferences['frequence'] ?? 'hebdomadaire';
    }

    // Scopes
    /**
     * scopeActifs.
     *
     * @return mixed
     */
    public function scopeActifs($query)
    {
        return $query->where('is_active', true)->whereNotNull('confirmed_at');
    }

    /**
     * scopeInactifs.

     *

     * @return mixed
     */
    public function scopeInactifs($query)
    {
        return $query->where('is_active', false)->orWhereNull('confirmed_at');
    }

    /**
     * scopeParSource.

     *

     * @return mixed
     */
    public function scopeParSource($query, $source)
    {
        return $query->where('source', $source);
    }

    // Méthodes métier
    public static function creer(
        string $email,
        ?string $prenom = null,
        ?string $nom = null,
        string $source = 'formulaire'): self
    {
        return self::create([
            'email' => $email,
            'prenom' => $prenom,
            'nom' => $nom,
            'token_confirmation' => Str::random(60),
            'source' => $source,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * confirmer.
     */
    public function confirmer(): void
    {
        $this->confirmed_at = now();
        $this->is_active = true;
        $this->token_confirmation = null;
        $this->save();
    }

    /**
     * desactiver.
     */
    public function desactiver(): void
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * reactiver.
     */
    public function reactiver(): void
    {
        $this->is_active = true;
        $this->save();
    }

    /**
     * updatePreferences.
     */
    public function updatePreferences(array $categories, string $frequence): void
    {
        $this->preferences = [
            'categories' => $categories,
            'frequence' => $frequence,
        ];
        $this->save();
    }
}
