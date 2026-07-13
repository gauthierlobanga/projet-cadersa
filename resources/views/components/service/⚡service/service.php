<?php

use App\Models\Service;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function services()
    {
        return Cache::remember('home_services', 3600, fn () => Service::active()->ordered()->limit(3)->get());
    }
};
