<?php

use App\Models\Post;
use App\Settings\AboutSettings;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function posts(): Collection
    {
        return Post::with(['user', 'categories'])
            ->published()
            ->whereHas('categories', fn ($query) => $query->where('slug', 'formation'))
            ->latest('published_at')
            ->limit(6)
            ->get();
    }

    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }
};
