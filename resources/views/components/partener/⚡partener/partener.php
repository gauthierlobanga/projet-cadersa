<?php

use App\Models\Partner;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    #[Computed]
    public function partners(): array
    {
        return Partner::active()
            ->ordered()
            ->get()
            ->groupBy('tier')
            ->map(fn ($partners, $tier) => [
                'tier' => $tier,
                'items' => $partners->map(fn ($partner) => [
                    'name' => $partner->name,
                    'logo' => $partner->logo_url ?? 'https://via.placeholder.com/150x60/ccc/999?text='.urlencode($partner->name),
                    'url' => $partner->url ?? '#',
                ])->values(),
            ])
            ->sortBy(function ($group) {
                return match ($group['tier']) {
                    'Gold' => 1,
                    'Silver' => 2,
                    'Bronze' => 3,
                    default => 4,
                };
            })
            ->values()
            ->toArray();
    }

    #[Computed]
    public function tiers(): array
    {
        return array_column($this->partnersByTier, 'tier');
    }
};
