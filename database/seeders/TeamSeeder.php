<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        TeamMember::query()
            ->where(function ($query): void {
                $query->where('email', 'like', '%@example.com')
                    ->orWhere('role', 'like', '%Développeur%')
                    ->orWhere('bio', 'like', '%Laravel%');
            })
            ->update(['is_active' => false]);
    }
}
