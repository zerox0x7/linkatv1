<?php

namespace App\Http\Controllers\Admin;

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
    public function index(Request $request)
    {


         $store = $request->attributes->get('store');
        // إحصائيات المبيعات
        $totalSales = Order::where('store_id',$store->id )->whereIn('status', ['completed', 'processing'])->sum('total');
        $salesCount = Order::where('store_id',$store->id )->count();
        $salesThisMonth = Order::where('store_id',$store->id )->whereMonth('created_at', now()->month)
                              ->whereYear('created_at', now()->year)
                              ->count();
        
        // مبيعات اليوم (مجموع الطلبات المكتملة اليوم)
        $todaySales = Order::where('store_id',$store->id )->where('status', 'completed')
            ->whereDate('created_at', now()->toDateString())
            ->sum('total');

        $yesterdaySales = Order::where('store_id', $store->id)
                ->where('status', 'completed')
                ->whereDate('created_at', now()->yesterday())
                ->sum('total');
             
        // مبيعات الشهر الحالي (مجموع الطلبات المكتملة خلال الشهر)
        $monthSales = Order::where('store_id',$store->id )->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
        
        // إحصائيات المستخدمين
        $totalUsers = User::where('store_id',$store->id )->where('role','customer')->count();
        $newUsers = User::where('store_id',$store->id )->whereDate('created_at', '>=', now()->subDays(30))->count();
        
        // إحصائيات المنتجات
        $totalProducts = Product::where('store_id',$store->id )->count();
        $outOfStockProducts = Product::where('store_id',$store->id )->where('stock', 0)->count();
        
        // الطلبات الأخيرة
        $recentOrders = Order::where('store_id',$store->id )->with(['user', 'items'])
                           ->orderBy('created_at', 'desc')
                           ->take(5)
                           ->get();
        // dd($recentOrders);
        
        // الطلبات المخصصة التي تحتاج اهتمام
        $pendingCustomOrders = CustomOrder::where('store_id',$store->id )->where('status', 'pending')
                                      ->orderBy('created_at', 'desc')
                                      ->take(5)
                                      ->get();
        
        // إحصائيات المبيعات حسب الشهر للرسم البياني
        $monthlySalesRaw = Order::where('store_id',$store->id )->where('status', 'completed')
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();


            $lastMonthSales = Order::where('store_id', $store->id)
        ->where('status', 'completed')
        ->whereMonth('created_at', now()->subMonth()->month)
        ->whereYear('created_at', now()->subMonth()->year)
        ->sum('total');

    //    dd($monthSales);


        // Calculate the percentage change
        if ($lastMonthSales > 0) {
            $monthPercentageChange = (($monthSales - $lastMonthSales) / $lastMonthSales) * 100;
        } else {
            // If no sales last month, treat it as a 100% increase or no change
            $monthPercentageChange = $monthSales > 0 ? 100 : 0;
        }

        
        // بناء مصفوفة كاملة لكل الشهور من 1 إلى 12
        $monthlySales = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlySales[$i] = isset($monthlySalesRaw[$i]) ? (float)$monthlySalesRaw[$i] : 0;
        }



                    // إحصائيات المبيعات حسب الأسبوع للرسم البياني
            $weeklySalesRaw = Order::where('store_id', $store->id)
                ->where('status', 'completed')
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]) // Filter for the current week
                ->select(
                    DB::raw('DAYOFWEEK(created_at) as day'), // Get the day of the week (1 = Sunday, 7 = Saturday)
                    DB::raw('SUM(total) as total') // Sum the sales total
                )
                ->groupBy('day') // Group by the day of the week
                ->get()
                ->pluck('total', 'day')
                ->toArray();

            //    dd($monthSales);

            // بناء مصفوفة كاملة لكل أيام الأسبوع من الأحد إلى السبت
            $weeklySales = [];
            for ($i = 1; $i <= 7; $i++) {
                $weeklySales[$i] = isset($weeklySalesRaw[$i]) ? (float)$weeklySalesRaw[$i] : 0;
            }

            // تحويل أيام الأسبوع إلى الإنجليزية للرسم البياني
            $weeklySalesFormatted = [
                
                'Mon' => $weeklySales[1] ?? 0,
                'Tue' => $weeklySales[2] ?? 0,
                'Wed' => $weeklySales[3] ?? 0,
                'Thu' => $weeklySales[4] ?? 0,
                'Fri' => $weeklySales[5] ?? 0,
                'Sat' => $weeklySales[6] ?? 0,
                'Sun' => $weeklySales[7] ?? 0,
            ];



            // Current Week Sales
            $currentWeekSales = Order::where('store_id', $store->id)
                ->where('status', 'completed')
                ->whereBetween('created_at', [
                    now()->startOfWeek(),
                    now()->endOfWeek(),
                ])
                ->sum('total');

            // Last Week Sales
            $lastWeekSales = Order::where('store_id', $store->id)
                ->where('status', 'completed')
                ->whereBetween('created_at', [
                    now()->subWeek()->startOfWeek(),
                    now()->subWeek()->endOfWeek(),
                ])
                ->sum('total');


                   // Calculate the percentage change
        if ($lastWeekSales > 0) {
            $weekPercentageChange = (($currentWeekSales - $lastWeekSales) / $lastWeekSales) * 100;
        } else {
            // If no sales last month, treat it as a 100% increase or no change
            $weekPercentageChange = $currentWeekSales > 0 ? 100 : 0;
        }


          if ($yesterdaySales > 0) {
            $dayPercentageChange = (($todaySales - $yesterdaySales) / $yesterdaySales) * 100;
        } else {
            // If no sales last month, treat it as a 100% increase or no change
            $dayPercentageChange = $todaySales > 0 ? 100 : 0;
        }

        // dd($dayPercentageChange);

        //   dd($weekPercentageChange,$lastWeekSales,$currentWeekSales);

        //   $weekPercentageChange = -40;


        // Get the total products added in the current month
            $newProductsThisMonth = Product::where('store_id', $store->id)
                ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth() ])
                ->count();
                   


        // Get the total new users added this week
            $newUsersThisWeek = User::where('store_id', $store->id)
                ->whereBetween('created_at', [ now()->startOfWeek(), now()->endOfWeek()])
                ->count();
                
        return view('themes.admin.dashboard.index', compact(
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
            'monthSales',
            'weeklySalesFormatted',
            'monthPercentageChange',
            'weekPercentageChange',
            'dayPercentageChange',
            'newProductsThisMonth',
            'newUsersThisWeek'
            
        ));
    }
} 