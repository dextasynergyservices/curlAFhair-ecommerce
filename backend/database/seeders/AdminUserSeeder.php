<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $adminEmail = env('ADMIN_EMAIL', 'admin@curlafhair.com');
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@12345');

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'CurlAFHair Admin',
                'password' => Hash::make($adminPassword),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: ' . $adminEmail);

        // Create Regular User
        User::updateOrCreate(
            ['email' => 'user@curlafhair.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('User@12345'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Regular user created: user@curlafhair.com');
    }
}
