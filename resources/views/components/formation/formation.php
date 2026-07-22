<?php

use App\Models\Formation;
use App\Models\FormationCategory;
use App\Settings\AboutSettings;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Layout('layouts::main')] class extends Component
{
    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'cat', history: true)]
    public ?string $categorySlug = null;

    #[Url(as: 'sort', history: true)]
    public string $sort = 'newest';

    #[Computed]
    public function formations()
    {
        return Formation::query()
            ->with(['category', 'media', 'user'])
            ->where('is_active', true)
            ->when($this->search, fn ($q) => $q->where(function ($query) {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('excerpt', 'like', '%'.$this->search.'%')
                    ->orWhere('subtitle', 'like', '%'.$this->search.'%');
            }))
            ->when($this->categorySlug, fn ($q) => $q->whereHas('category', fn ($query) => $query->where('slug', $this->categorySlug)))
            ->when($this->sort === 'oldest', fn ($q) => $q->oldest('start_date'))
            ->when($this->sort === 'name-asc', fn ($q) => $q->orderBy('title', 'asc'))
            ->when($this->sort === 'name-desc', fn ($q) => $q->orderBy('title', 'desc'))
            ->when(! in_array($this->sort, ['oldest', 'name-asc', 'name-desc']), fn ($q) => $q->latest('start_date'))
            ->paginate(9);
    }

    #[Computed]
    public function categories()
    {
        return FormationCategory::orderBy('sort_order')->get();
    }

    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }

    public function clearFilters()
    {
        $this->reset(['search', 'categorySlug', 'sort']);
        $this->resetPage();
    }
};
