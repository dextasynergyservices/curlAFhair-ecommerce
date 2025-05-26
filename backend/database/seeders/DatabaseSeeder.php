<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\UsersTableSeeder as SeedersUsersTableSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            // AdminUserSeeder::class,
            // OrderSeeder::class,
            // SavedItemSeeder::class,
            // WishlistSeeder::class,
            NotificationSeeder::class,
            // UsersTableSeeder::class,
        ]);

    }
}
