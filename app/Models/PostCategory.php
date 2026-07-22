<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;

#[Table('posts_categories')]
class PostCategory extends Model implements Sitemapable
{
    use SoftDeletes;

    protected $table = 'posts_categories';

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

    public function toSitemapTag(): Url|string|array
    {
        return Url::create(route('posts.index', ['cat' => $this->slug]))
            ->setLastModificationDate($this->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.6);
    }

    protected $fillable = [
        'parent_id',
        'nom',
        'slug',
        'description',
        'color',
        'metadata',
        'ordre',
        'est_active',
        'est_visible_dans_menu',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'meta_keywords' => 'array',
            'ordre' => 'integer',
            'est_active' => 'boolean',
            'est_visible_dans_menu' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'parent_id')->with('parent');
    }

    public function enfants(): HasMany
    {
        return $this->hasMany(PostCategory::class, 'parent_id')->orderBy('ordre');
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'posts_categories_pivot',
            'category_id',
            'post_id'
        )
            ->using(PostCategoryPivot::class)
            ->withPivot('is_primary', 'order')
            ->withTimestamps();
    }

    public function postsPublies()
    {
        return $this->posts()->published();
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('posts.index', ['cat' => $this->slug]);
    }

    public function getFullPathAttribute(): string
    {
        $path = [$this->nom];
        $parent = $this->parent;
        while ($parent) {
            array_unshift($path, $parent->nom);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    public function getSlugPathAttribute(): string
    {
        $path = [$this->slug];
        $parent = $this->parent;
        while ($parent) {
            array_unshift($path, $parent->slug);
            $parent = $parent->parent;
        }

        return implode('/', $path);
    }

    public function getCountPostsAttribute(): int
    {
        return $this->posts()->published()->count();
    }

    public function getMetaTitleAttribute($value): ?string
    {
        if ($value) {
            return $value ?? $this->nom;
        }

        return null;
    }

    public function getMetaDescriptionAttribute($value): ?string
    {
        if ($value) {
            return $value ?? $this->description;
        }

        return null;
    }

    /**
     * Scope pour trier par nom (compatible PostgreSQL)
     */

    // Scopes
    public function scopeActifs(Builder $query): Builder
    {
        return $query->where('est_active', true);
    }

    public function scopeVisiblesDansMenu(Builder $query): Builder
    {
        return $query->where('est_visible_dans_menu', true);
    }

    /**
     * scopeParents.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeParents(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * scopeEnfants.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeEnfants(Builder $query): Builder
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * scopeOrdonnes.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeOrdonnes(Builder $query): Builder
    {
        return $query->orderBy('ordre');
    }

    /**
     * scopeRecherche.

     *

     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeRecherche(Builder $query, string $term): Builder
    {
        return $query->where('nom', 'like', "%{$term}%")
            ->orWhere('description', 'like', "%{$term}%");
    }

    // Méthodes métier
    /**
     * hasChildren.
     */
    public function hasChildren(): bool
    {
        return $this->enfants()->exists();
    }

    /**
     * hasParent.
     */
    public function hasParent(): bool
    {
        return ! is_null($this->parent_id);
    }

    /**
     * getTreeIds.
     */
    public function getTreeIds(): array
    {
        $ids = [$this->id];
        foreach ($this->enfants as $enfant) {
            $ids = array_merge($ids, $enfant->getTreeIds());
        }

        return $ids;
    }

    /**
     * getBreadcrumb.
     */
    public function getBreadcrumb(): array
    {
        $breadcrumb = [];
        $current = $this;
        while ($current) {
            array_unshift($breadcrumb, [
                'id' => $current->id,
                'nom' => $current->nom,
                'slug' => $current->slug,
                'url' => $current->url,
            ]);
            $current = $current->parent;
        }

        return $breadcrumb;
    }

    /**
     * incrementOrdre.
     */
    public function incrementOrdre(): void
    {
        $this->increment('ordre');
    }

    /**
     * decrementOrdre.
     */
    public function decrementOrdre(): void
    {
        $this->decrement('ordre');
    }

    /**
     * activer.
     */
    public function activer(): void
    {
        $this->est_active = true;
        $this->save();
    }

    /**
     * desactiver.
     */
    public function desactiver(): void
    {
        $this->est_active = false;
        $this->save();
    }

    /**
     * rendreVisibleDansMenu.
     */
    public function rendreVisibleDansMenu(): void
    {
        $this->est_visible_dans_menu = true;
        $this->save();
    }

    /**
     * rendreInvisibleDansMenu.
     */
    public function rendreInvisibleDansMenu(): void
    {
        $this->est_visible_dans_menu = false;
        $this->save();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->nom);
            }
        });

        static::deleting(function ($category) {
            if ($category->hasChildren()) {
                $category->enfants()->update(['parent_id' => $category->parent_id]);
            }
        });
    }
}
