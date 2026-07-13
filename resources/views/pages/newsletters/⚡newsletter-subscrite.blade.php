<?php

use App\Models\Newsletter;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts::main')] class extends Component
{
    #[Validate('required|email|unique:newsletters,email')]
    public string $email = '';

    public bool $subscribed = false;

    public function submit()
    {
        $this->validate();

        Newsletter::create([
            'email' => $this->email,
            'token_confirmation' => \Illuminate\Support\Str::random(60),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'source' => 'formulaire',
        ]);

        $this->reset('email');
        $this->subscribed = true;
    }
};
?>

<div>
    @if($subscribed)
        <div class="text-emerald-400 font-medium">✅ Merci ! Veuillez confirmer votre inscription par email.</div>
    @else
        <form wire:submit="submit" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            <input type="email" wire:model="email" placeholder="Votre adresse email" class="flex-1 px-4 py-3 rounded-xl border border-slate-700 bg-slate-800 text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
            @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            <button type="submit" class="px-6 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition-colors shadow-lg shadow-emerald-500/30">
                S'abonner
            </button>
        </form>
    @endif
</div>
