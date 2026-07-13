<?php

use App\Models\TeamMember;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function members()
    {
        return TeamMember::query()
            ->orderBy('sort_order')
            ->get();
    }
};
