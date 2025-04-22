<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SavedItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class SavedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        SavedItem::factory()->count(5)->create([
            'user_id' => $user->id,
        ]);
    }
}
