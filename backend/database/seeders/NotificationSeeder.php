<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Notifications\DashboardNotification;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // $user = User::first();

        // for ($i = 1; $i <= 5; $i++) {
        //     $user->notify(new DashboardNotification("Sample Title $i", "This is a test message $i."));
        // }

        $user = User::find(1); // or User::find(1)

        $user->notify(new DashboardNotification(
            title: 'Order Update',
            message: 'Your order #123 has been shipped.'
        ));

        $user->notify(new DashboardNotification(
            title: 'Promo Alert',
            message: '50% discount on selected items until Sunday!'
        ));
    }
}
