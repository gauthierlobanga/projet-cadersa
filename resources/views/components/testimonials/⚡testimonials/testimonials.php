<?php

use App\Models\Testimonial;
use App\Settings\AboutSettings;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
   #[Computed]
    public function testimonials()
    {
        return Testimonial::query()
            ->active()
            ->ordered()
            ->get();
    }

    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }
};
