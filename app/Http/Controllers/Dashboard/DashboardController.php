<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\CustomOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية للمسؤول
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // إحصائيات المبيعات
        $totalSales = Order::whereIn('status', ['completed', 'processing'])->sum('total');
        $salesCount = Order::count();
        $salesThisMonth = Order::whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();
        
        // مبيعات اليوم (مجموع الطلبات المكتملة اليوم)
        $todaySales = Order::where('status', 'completed')
            ->whereDate('created_at', now()->toDateString())
            ->sum('total');
        // مبيعات الشهر الحالي (مجموع الطلبات المكتملة خلال الشهر)
        $monthSales = Order::where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        // إحصائيات المستخدمين
        $totalUsers = User::count();
        $newUsers = User::whereDate('created_at', '>=', now()->subDays(30))->count();
        
        // إحصائيات المنتجات
        $totalProducts = Product::count();
        $outOfStockProducts = Product::where('stock', 0)->count();
        
        // الطلبات الأخيرة
        $recentOrders = Order::with(['user', 'items'])
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
        
        // الطلبات المخصصة التي تحتاج اهتمام
        $pendingCustomOrders = CustomOrder::where('status', 'pending')
                                      ->orderBy('created_at', 'desc')
                                      ->take(5)
                                      ->get();
        
        // إحصائيات المبيعات حسب الشهر للرسم البياني
        $monthlySalesRaw = Order::where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();
        
        // بناء مصفوفة كاملة لكل الشهور من 1 إلى 12
        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[$i] = isset($monthlySalesRaw[$i]) ? (float)$monthlySalesRaw[$i] : 0;
        }
        
        return view('themes.dashboard.dashboard.index', compact(
            'totalSales',
            'salesCount',
            'salesThisMonth',
            'totalUsers',
            'newUsers',
            'totalProducts',
            'outOfStockProducts',
            'recentOrders',
            'pendingCustomOrders',
            'monthlySales',
            'todaySales',
            'monthSales'
        ));
    }
} 