<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Charts\UserOrderChart;

class MemberDashboardController extends Controller
{
    public function index()
    {
        $user = User::with([
            'orders' => fn ($query) => $query->latest()->take(5),
            'savedItems' => fn ($query) => $query->latest()->take(5),
            'wishlists' => fn ($query) => $query->latest()->take(5),
        ])->findOrFail(Auth::id());

        // Load notifications properly
        $user->loadMissing('notifications');

        // Admin redirect
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Premium member
        if ($user->membership_type === 'premium' && $user->role === 'member') {
            $chart = new UserOrderChart;
            $hasOrders = $user->orders->count() > 0;

            return view('frontend.members.premium-dashboard', [
                'user' => $user,
                'chart' => $chart,
                'hasChartData' => $hasOrders,
                'hasOrders' => $hasOrders,
                'recentActivities' => $user->orders,
                'notifications' => $user->notifications,
            ]);
        }

        // Regular member
        return view('frontend.members.dashboard', [
            'user' => $user,
            'orders' => $user->orders,
            'savedItems' => $user->savedItems,
            'wishlist' => $user->wishlists,
            'notifications' => $user->notifications,
        ]);
    }


    public function markNotificationsAsRead()
    {
        if (Auth::check()) {
            Auth::user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 401);
    }
}
