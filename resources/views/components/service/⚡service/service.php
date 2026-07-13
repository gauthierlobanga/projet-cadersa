<?php

use App\Models\Service;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function services()
    {
        return Service::active()->ordered()->limit(6)->get();
    }
};
