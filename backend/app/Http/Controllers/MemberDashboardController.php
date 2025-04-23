<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\SavedItem;
use App\Models\Wishlist;
use App\Models\Notification;
use App\Charts\UserOrderChart;

class MemberDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated user with necessary relationships loaded
        $user = \App\Models\User::where('id', Auth::id())
            ->with([
                'orders' => fn ($query) => $query->latest()->take(5),
                'savedItems' => fn ($query) => $query->latest()->take(5),
                'wishlists' => fn ($query) => $query->latest()->take(5),
                'notifications' => fn ($query) => $query->latest()->take(5),
            ])
            ->first();

            // Create the chart instance
            $chart = new UserOrderChart;

        // Check membership type and render the appropriate view
        if ($user->membership_type === 'premium' && $user->role === 'member') {
            return view('frontend.members.premium-dashboard', compact('chart'));
        }

        elseif($user->membership_type === 'admin' && $user->role === 'admin'){
            return redirect()->route('admin.dashboard');
        }

        return view('frontend.members.dashboard', [
            'user' => $user,
        ]);
    }
}
