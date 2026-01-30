<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\SavedItem;
use App\Models\Wishlist;
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

        // Check if admin - only redirect if role is exactly 'admin'
        if($user && $user->role === 'admin'){
            return redirect()->route('admin.dashboard');
        }

        // Check membership type and render the appropriate view
        if ($user && $user->role === 'member') {
            // Premium members get premium dashboard
            if ($user->membership_type === 'premium') {
                return view('frontend.members.premium-dashboard', compact('chart', 'user'));
            }
            // Regular members get loyalty dashboard
            return view('frontend.members.dashboard', [
                'user' => $user,
            ]);
        }

        // Regular users (role = 'user' or any other role) get standard dashboard
        return view('dashboard', [
            'notifications' => $user ? $user->notifications : collect(),
            'orders' => $user ? $user->orders : collect(),
            'savedItems' => $user ? $user->savedItems : collect(),
            'wishlists' => $user ? $user->wishlists : collect(),
        ]);
    }

    public function redeemRewards()
    {
        $user = Auth::user();
        
        // Check if user is a member
        if ($user->role !== 'member') {
            return redirect()->route('dashboard')->with('error', 'Only members can access rewards.');
        }

        return view('frontend.members.redeem-rewards', [
            'user' => $user,
        ]);
    }

    public function pointsHistory()
    {
        $user = Auth::user();
        
        // Check if user is a member
        if ($user->role !== 'member') {
            return redirect()->route('dashboard')->with('error', 'Only members can access points history.');
        }

        return view('frontend.members.points-history', [
            'user' => $user,
        ]);
    }
}
