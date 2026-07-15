<?php

use App\Models\Post;
use App\Models\PostCategory;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::main')] class extends Component
{
    use WithPagination;

    protected const FORMATION_CATEGORY_SLUG = 'formation';

    protected $scrollToTop = false;

    public string $search = '';

    public ?string $category = self::FORMATION_CATEGORY_SLUG;

    #[Url(as: 'sort')]
    public string $sort = 'newest';

    public function with(): array
    {
        $query = Post::query()
            ->with(['user', 'categories', 'media'])
            ->published()
            ->whereHas('categories', fn ($q) => $q->where('slug', self::FORMATION_CATEGORY_SLUG));

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('content', 'LIKE', '%'.$this->search.'%')
                    ->orWhere('excerpt', 'LIKE', '%'.$this->search.'%');
            });
        }

        $query
            ->when($this->sort === 'oldest', fn ($q) => $q->oldest('published_at'))
            ->when($this->sort === 'popular', fn ($q) => $q->orderBy('views_count', 'desc'))
            ->when($this->sort === 'name-asc', fn ($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'name-desc', fn ($q) => $q->orderBy('title', 'desc'))
            ->when(! in_array($this->sort, ['oldest', 'popular', 'name-asc', 'name-desc']), fn ($q) => $q->latest('published_at'));

        return [
            'posts' => $query->paginate(9),
            'categories' => PostCategory::actifs()->get(),
        ];
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'category', 'sort']);
        $this->resetPage();
    }

    public function getStatsProperty()
    {
        $publicationQuery = Post::published()->whereHas('categories', fn ($q) => $q->where('slug', self::FORMATION_CATEGORY_SLUG));

        return [
            'articles' => $publicationQuery->count(),
            'authors' => $publicationQuery->distinct('user_id')->count('user_id'),
            'categories' => PostCategory::whereHas('posts', fn ($q) => $q->published()->whereHas('categories', fn ($q) => $q->where('slug', self::FORMATION_CATEGORY_SLUG)))->count(),
            'views' => $publicationQuery->sum('views_count'),
        ];
    }
};
