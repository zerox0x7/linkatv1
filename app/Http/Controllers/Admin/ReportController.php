<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display sales reports.
     */
    public function sales(Request $request)
    {
        $period = $request->input('period', 'month');
        
        // Get orders grouped by date
        $query = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as total')
            ->where('status', 'completed')
            ->groupBy('date');
            
        // Filter by time period
        if ($period === 'week') {
            $query->where('created_at', '>=', Carbon::now()->subWeek());
        } elseif ($period === 'month') {
            $query->where('created_at', '>=', Carbon::now()->subMonth());
        } elseif ($period === 'year') {
            $query->where('created_at', '>=', Carbon::now()->subYear());
        }
        
        $orders = $query->orderBy('date', 'asc')->get();
        
        // Calculate totals
        $totalSales = $orders->sum('total');
        $totalOrders = $orders->sum('count');
        
        // Best selling products
        $bestSellingProducts = DB::table('order_items')
            ->select('name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('name')
            ->orderBy('total_quantity', 'desc')
            ->limit(5)
            ->get();
        
        return view('themes.admin.reports.sales', compact(
            'orders', 
            'totalSales', 
            'totalOrders', 
            'bestSellingProducts', 
            'period'
        ));
    }
    
    /**
     * Display user reports.
     */
    public function users(Request $request)
    {
        $period = $request->input('period', 'month');
        
        // New users over time
        $query = User::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date');
            
        // Filter by time period
        if ($period === 'week') {
            $query->where('created_at', '>=', Carbon::now()->subWeek());
        } elseif ($period === 'month') {
            $query->where('created_at', '>=', Carbon::now()->subMonth());
        } elseif ($period === 'year') {
            $query->where('created_at', '>=', Carbon::now()->subYear());
        }
        
        $newUsers = $query->orderBy('date', 'asc')->get();
        
        // User statistics
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $topSpenders = User::select('users.*', DB::raw('SUM(orders.total) as total_spent'))
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 'completed')
            ->groupBy('users.id')
            ->orderBy('total_spent', 'desc')
            ->limit(5)
            ->get();
        
        return view('themes.admin.reports.users', compact(
            'newUsers', 
            'totalUsers', 
            'activeUsers', 
            'topSpenders', 
            'period'
        ));
    }
} 