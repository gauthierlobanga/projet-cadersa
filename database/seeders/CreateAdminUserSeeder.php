<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $name = 'Cadersa ASBL';
        $email = 'cadersaasbl@cadresa.com';

        if (User::where('email', $email)->exists()) {
            $this->command->warn("Un utilisateur avec l'email {$email} existe déjà. Aucune création?");

            return;
        }

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Artisan::call('shield:generate', [
            '--all' => true,
            '--option' => 'permissions',
            '--panel' => 'admin',
            '--no-interaction' => true,
        ]);

        Artisan::call('shield:super-admin', [
            '--user' => $user->getKey(),
            '--panel' => 'admin',
            '--no-interaction' => true,
        ]);
    }
}
