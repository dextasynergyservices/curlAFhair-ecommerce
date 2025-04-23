<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Spatie\Activitylog\Models\Activity;
use App\Charts\SalesChart;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
{
        // Fetching the activity log filter (if any)
        $logName = $request->get('log'); // Example: 'order', 'user', etc.

        // Fetching activity logs with pagination and optional filtering by log name
        $activities = Activity::when($logName, fn($q) => $q->where('log_name', $logName))
            ->latest()
            ->paginate(10);

        // Fetching the necessary data to be displayed in the dashboard
        $totalOrders = Order::count();
        $totalSales = Order::sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();
        $shippedOrders = Order::where('status', 'shipped')->count();
        $recentOrders = Order::latest()->take(5)->get();

         // Generate Sales Chart
        // $chart = new SalesChart;
        // $chart->labels(['January', 'February', 'March', 'April', 'May']);
        // $chart->dataset('Sales', 'line', [5000, 7000, 6000, 8000, 9500]);

        // Passing data to the view
        return view('admin.dashboard', compact('totalOrders', 'totalSales', 'pendingOrders', 'shippedOrders', 'recentOrders', 'activities'));

    }
}
