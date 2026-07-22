<?php

use App\Settings\AboutSettings;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts::main')] class extends Component
{
    #[Computed]
    public function about(): AboutSettings
    {
        return app(AboutSettings::class);
    }
};
