<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        Testimonial::query()
            ->where(function ($query): void {
                $query->where('content', 'like', '%Gauthier%')
                    ->orWhere('content', 'like', '%développeur%')
                    ->orWhere('role', 'like', '%Développeur%');
            })
            ->update(['is_active' => false]);
    }
}
