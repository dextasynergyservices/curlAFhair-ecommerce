<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;  // Add this line
use App\Models\Order;
use Carbon\Carbon;
use App\Charts\UserOrderChart;

class PremiumDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();  // Get the authenticated user

    // Fetch recent orders (recent activities)
    $recentActivities = Order::where('user_id', $user->id)
        ->latest()  // Get the latest orders
        ->take(5)   // Limit to the latest 5 orders
        ->get();

    // Check if there are any recent orders
    $hasOrders = $recentActivities->isNotEmpty();

    // Fetch data for the chart
    $orders = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders')
                   ->where('user_id', $user->id)
                   ->groupBy('date')
                   ->orderBy('date', 'asc')
                   ->get();

    // Extract the date and total_orders for the chart
    $dates = $orders->pluck('date')->toArray();
    $totalOrders = $orders->pluck('total_orders')->toArray();

    // Pass the data to the view
    return view('members.premium-dashboard', compact('recentActivities', 'dates', 'totalOrders', 'hasOrders'));
    }


    public function showPremiumDashboard()
    {
        $user = Auth::user();

        // Fetch the orders for this user in the last 30 days
        $orders = Order::where('user_id', $user->id)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get();

        // Prepare chart data (dates and order counts)
        $dates = [];
        $orderCounts = [];

        if ($orders->count() > 0) {
            // Group orders by day
            $ordersGroupedByDate = $orders->groupBy(function ($order) {
                return $order->created_at->format('Y-m-d');
            });

            // Populate dates and order counts for the chart
            for ($i = 30; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $dates[] = $date;
                $orderCounts[] = isset($ordersGroupedByDate[$date]) ? $ordersGroupedByDate[$date]->count() : 0;
            }
        }

        // Create chart object with dynamic data
        $chart = new UserOrderChart($dates, $orderCounts);

        // Get recent activities (order history)
        $recentActivities = $orders->take(5); // Limit to 5 most recent activities

        // Determine if the user has any orders
        $hasOrders = $orders->count() > 0;

        // Pass data to the view
        return view('members.premium-dashboard', compact('chart', 'recentActivities', 'hasOrders'));
    }

}
