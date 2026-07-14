<?php

namespace App\Models;

use App\Concerns\HasUserPreferences;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\PasskeyUser;
use Laravel\Fortify\PasskeyAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $name (accessor)
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property bool $email_verified
 * @property string $password
 * @property bool $is_active
 * @property array|null $preferences
 * @property Carbon|null $last_login_at
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $global_id
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable(['name', 'first_name', 'last_name', 'email', 'password', 'is_active', 'preferences'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia, HasName, MustVerifyEmail, PasskeyUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, PasskeyAuthenticatable, TwoFactorAuthenticatable;

    use HasRoles, HasUserPreferences, InteractsWithMedia; // HasUserPreferences est un trait personnalisé (voir ci-dessous)
    use HasUuids, SoftDeletes;

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

    /**
     * The attributes that should be appended to the model's array form.
     *
     * @var list<string>
     */
    protected $appends = [
        'avatar_url',
        'name',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
            'is_active' => 'boolean',
            'email_verified' => 'boolean',
            'last_login_at' => 'datetime',
            'preferences' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name (concatenation of first and last name).
     */
    public function getNameAttribute(): string
    {
        $fullName = trim(($this->first_name ?? '').' '.($this->last_name ?? ''));

        if (! empty($fullName)) {
            return $fullName;
        }

        // Fallback vers la colonne 'name' si les prénom/nom sont vides
        return $this->attributes['name'] ?? '';
    }

    /**
     * Get the user's initials.
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    /**
     * Relations avec les autres modèles (exemple)
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Media Library
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->useDisk('public')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif']);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // Avatar de taille moyenne (carré 400x400) – pour profil, cartes, etc.
        $this->addMediaConversion('medium')
            ->format('webp')
            ->width(400)
            ->height(400)                     // crop carré
            ->fit(Fit::Crop, 400, 400)
            ->quality(90)                     // excellente qualité
            ->sharpen(10)                     // netteté accrue
            ->withResponsiveImages()          // variantes automatiques (srcset)
            ->optimize()
            ->nonQueued()
            ->performOnCollections('avatar'); // uniquement pour la collection avatar

        // Avatar miniature (carré 150x150) – pour listes, commentaires, notifications
        $this->addMediaConversion('thumb')
            ->format('webp')
            ->width(150)
            ->height(150)
            ->fit(Fit::Crop, 150, 150)
            ->quality(90)
            ->sharpen(10)
            ->withResponsiveImages()
            ->optimize()
            ->performOnCollections('avatar');
    }

    /**
     * Filament Accessors
     */
    public function getFilamentName(): string
    {
        return $this->name ? $this->name : "{$this->first_name} {$this->last_name}";
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() !== 'admin') {
            return false;
        }

        return ($this->is_active && $this->hasRole(['super_admin', 'editeur', 'Manager']))
            && (str_ends_with($this->email, '@cadersa.com') && $this->hasVerifiedEmail());
    }

    /**
     * Accessors
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->hasMedia('avatar')) {
            return $this->getFirstMediaUrl('avatar', 'medium');
        }

        // Générer les initiales via ui-avatars
        $name = trim($this->name ?? $this->email);
        if (empty($name)) {
            $initials = '?';
        } else {
            $parts = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
            $initials = collect($parts)
                ->map(fn ($part) => strtoupper(mb_substr($part, 0, 1)))
                ->take(2)
                ->implode('');
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($initials)
            .'&background=F59E0B&color=FFFFFF&size=128&bold=true';
    }

    /**
     * Détermine si cet utilisateur peut impersonner d'autres utilisateurs
     */
    public function canImpersonate(): bool
    {
        return $this->hasRole('super_admin') && $this->is_active;
    }

    /**
     * Détermine si cet utilisateur peut être impersonné
     */
    public function canBeImpersonated(): bool
    {
        if ($this->hasRole('super_admin')) {
            return false;
        }

        if ($this->id === Auth::id()) {
            return false;
        }

        return true;
    }

    /**
     * Check if user has admin role
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('super_admin') || $this->hasRole('admin');
    }

    /**
     * Check if user has editor role
     */
    public function isEditor(): bool
    {
        return $this->hasRole('editor');
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->is_active)) {
                $user->is_active = true;
            }
        });
    }

    /**
     * Gestion des préférences utilisateur (stockées dans le champ JSON 'preferences')
     */
    public function setPreference(string $key, mixed $value): self
    {
        $preferences = $this->preferences ?? [];
        data_set($preferences, $key, $value);
        $this->preferences = $preferences;

        return $this;
    }

    public function getPreference(string $key, mixed $default = null): mixed
    {
        return data_get($this->preferences ?? [], $key, $default);
    }
}
