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
        // Check if the admin user already exists
        if (!User::where('email', 'admin@curlafhair.com')->exists()) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@curlafhair.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }
    }
}
