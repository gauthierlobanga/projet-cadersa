<?php

use App\Models\Faq;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function faqs()
    {
        return Faq::active()->ordered()->get();
    }
};
