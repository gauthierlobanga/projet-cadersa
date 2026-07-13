<?php

use Livewire\Component;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;

new #[Layout('layouts::main')] class extends Component
{
    #[Url(as: 'q', history: true)]
    public string $query = '';

    public function with(): array
    {
        if (empty($this->query)) {
            return ['results' => collect()];
        }

        $posts = Post::published()
            ->where('title', 'LIKE', '%'.$this->query.'%')
            ->orWhere('content', 'LIKE', '%'.$this->query.'%')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'excerpt']);

        $projects = Project::active()
            ->where('title', 'LIKE', '%'.$this->query.'%')
            ->orWhere('content', 'LIKE', '%'.$this->query.'%')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'excerpt']);

        $services = Service::active()
            ->where('title', 'LIKE', '%'.$this->query.'%')
            ->orWhere('content', 'LIKE', '%'.$this->query.'%')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'excerpt']);

        return [
            'results' => [
                'posts' => $posts,
                'projects' => $projects,
                'services' => $services,
            ],
        ];
    }
};
?>

<div class="py-24 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-8">
            <input type="text" wire:model.live.debounce.300ms="query" placeholder="Rechercher..." class="w-full px-4 py-3 rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500">
        </div>

        @if(!empty($query) && !$results['posts']->isEmpty())
            <h3 class="text-lg font-bold mb-4">Articles</h3>
            @foreach($results['posts'] as $post)
                <a href="{{ route('posts.show', $post) }}" class="block p-4 bg-white rounded-xl shadow-sm mb-2 hover:shadow-md transition-shadow">
                    {{ $post->title }}
                </a>
            @endforeach
        @endif

        @if(!empty($query) && !$results['projects']->isEmpty())
            <h3 class="text-lg font-bold mt-6 mb-4">Projets</h3>
            @foreach($results['projects'] as $project)
                <a href="{{ route('projects.show', $project) }}" class="block p-4 bg-white rounded-xl shadow-sm mb-2 hover:shadow-md transition-shadow">
                    {{ $project->title }}
                </a>
            @endforeach
        @endif

        @if(!empty($query) && !$results['services']->isEmpty())
            <h3 class="text-lg font-bold mt-6 mb-4">Services</h3>
            @foreach($results['services'] as $service)
                <a href="{{ route('services.show', $service) }}" class="block p-4 bg-white rounded-xl shadow-sm mb-2 hover:shadow-md transition-shadow">
                    {{ $service->title }}
                </a>
            @endforeach
        @endif

        @if(!empty($query) && $results['posts']->isEmpty() && $results['projects']->isEmpty() && $results['services']->isEmpty())
            <p class="text-slate-500 text-center py-12">Aucun résultat trouvé pour “{{ $query }}”</p>
        @endif
    </div>
</div>
