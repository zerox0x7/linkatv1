 <!DOCTYPE html>
 <html lang="ar" dir="rtl"   style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;" >

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Modern Dashboard</title>
     <script src="https://cdn.tailwindcss.com/3.4.16"></script>
     <script>
         tailwind.config = {
             theme: {
                 extend: {
                     colors: {
                         primary: '#15B8A6',
                         secondary: ''
                     },
                     borderRadius: {
                         'none': '0px',
                         'sm': '4px',
                         DEFAULT: '8px',
                         'md': '12px',
                         'lg': '16px',
                         'xl': '20px',
                         '2xl': '24px',
                         '3xl': '32px',
                         'full': '9999px',
                         'button': '8px'
                     }
                 }
             }
         }
     </script>
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
     <style>
         :where([class^="ri-"])::before {
             content: "\f3c2";
         }

         body {
             background-color: #1a1f2b;
             color: #e2e8f0;
         }

         .stats-card {
            background: #232b3e;
             /* background: linear-gradient(145deg, #1e2533, #232a3b); */
             box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
         }

         .sidebar-item.active {
             background-color: rgba(21, 184, 166, 0.1);
             border-right: 3px solid #15B8A6;
         }

         .status-completed {
             background-color: rgba(16, 185, 129, 0.1);
             color: #10b981;
         }

         .status-pending {
             background-color: rgba(245, 158, 11, 0.1);
             color: #f59e0b;
         }

         .status-cancelled {
             background-color: rgba(239, 68, 68, 0.1);
             color: #ef4444;
         }

         input[type="checkbox"] {
             appearance: none;
             -webkit-appearance: none;
             height: 18px;
             width: 18px;
             background-color: #1e2533;
             border: 2px solid #4b5563;
             border-radius: 4px;
             cursor: pointer;
             display: flex;
             align-items: center;
             justify-content: center;
         }

         input[type="checkbox"]:checked {
             background-color: #15B8A6;
             border-color: #15B8A6;
         }

         input[type="checkbox"]:checked::after {
             content: "✓";
             color: white;
             font-size: 12px;
         }

         input[type="number"]::-webkit-inner-spin-button,
         input[type="number"]::-webkit-outer-spin-button {
             -webkit-appearance: none;
             margin: 0;
         }

         .switch {
             position: relative;
             display: inline-block;
             width: 44px;
             height: 22px;
         }

         .switch input {
             opacity: 0;
             width: 0;
             height: 0;
         }

         .slider {
             position: absolute;
             cursor: pointer;
             top: 0;
             left: 0;
             right: 0;
             bottom: 0;
             background-color: #374151;
             transition: .4s;
             border-radius: 22px;
         }

         .slider:before {
             position: absolute;
             content: "";
             height: 16px;
             width: 16px;
             left: 3px;
             bottom: 3px;
             background-color: white;
             transition: .4s;
             border-radius: 50%;
         }

         input:checked+.slider {
             background-color: #15B8A6;
         }

         input:checked+.slider:before {
             transform: translateX(22px);
         }

         .table-row:nth-child(odd) {
             background-color: rgba(30, 41, 59, 0.5);
         }

         .table-row:nth-child(even) {
             background-color: rgba(30, 41, 59, 0.3);
         }

         .table-row:hover {
             background-color: rgba(30, 41, 59, 0.8);
         }
     </style>











   <!-- CSS للتحكم في القوائم المنسدلة -->
    <style>
        .s-dropdown-content {
            display: none;
            opacity: 0;
            max-height: 0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .s-dropdown-content.show {
            display: block;
            opacity: 1;
            max-height: 500px;
        }

        .s-dropdown-toggle {
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .s-dropdown-toggle:hover {
            color: #10b981;
        }

        .s-transform.rotate-180 {
            transform: rotate(180deg);
        }
    </style>



 </head>

 <body class="min-h-screen flex text-gray-200">
     <!-- Sidebar -->
    @include('themes.admin.parts.sidebar')
     <!-- Main Content -->
     <div class="flex-1 ">
         <!-- Header -->
         @include('themes.admin.parts.header')
         <!-- Dashboard Content -->
         <main class="p-6">

             <!-- Stats Cards -->
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                 <div class="stats-card rounded p-6 flex flex-col">
                     <div class="flex items-center justify-between mb-4">
                         <span class="text-gray-400 text-sm">Monthly Sales</span>
                         <div
                             class="w-8 h-8 flex items-center justify-center rounded-full bg-blue-500/10 text-blue-400">
                             <i class="ri-calendar-line"></i>
                         </div>
                     </div>
                     <div class="text-3xl font-bold text-blue-400">{{ number_format($monthSales, 2) }}</div>
                         <div class="mt-2 text-xs flex items-center text-green-400">
                      
                         <span>
                       @if($monthPercentageChange > 0)
                        <div class="mt-2 text-xs flex items-center text-green-400">
                         <i class="ri-arrow-up-line mr-1"></i>
                         <span>{{ number_format($monthPercentageChange,2)  }}% from last month</span>
                     </div>

                       @endif

                       </span>
                    </div>
                 </div>
                 <div class="stats-card rounded p-6 flex flex-col">
                     <div class="flex items-center justify-between mb-4">
                         <span class="text-gray-400 text-sm">Daily Sales</span>
                         <div
                             class="w-8 h-8 flex items-center justify-center rounded-full bg-green-500/10 text-green-400">
                             <i class="ri-shopping-cart-line"></i>
                         </div>
                     </div>
                     <div class="text-3xl font-bold text-green-400">{{ number_format( $todaySales, 2) }}</div>
                      <div class="mt-2 text-xs flex items-center text-green-400">
                      
                         <span>
                     
                     @if($dayPercentageChange > 0)
                        <div class="mt-2 text-xs flex items-center text-green-400">
                         <i class="ri-arrow-up-line mr-1"></i>
                         <span>{{ number_format($dayPercentageChange,2)  }}% from last day</span>
                     </div>

                       @endif

                       </span> 
                       </div>
                 </div>
                 <div class="stats-card rounded p-6 flex flex-col">
                     <div class="flex items-center justify-between mb-4">
                         <span class="text-gray-400 text-sm">Total Sales</span>
                         <div class="w-8 h-8 flex items-center justify-center rounded-full bg-primary/10 text-primary">
                             <i class="ri-money-dollar-circle-line"></i>
                         </div>
                     </div>
                     <div class="text-3xl font-bold text-primary">{{ number_format($totalSales, 2) }}</div>
                     <div class="mt-2 text-xs flex items-center text-green-400">
                      
                         <span>
                            
                          

                            @if($weekPercentageChange > 0)
                            <div class="mt-2 text-xs flex items-center text-green-400">
                                <i class="ri-arrow-up-line mr-1"></i>
                                <span> sales arrow go up</span>
                            </div>
                            @elseif($weekPercentageChange > -50 && $weekPercentageChange < -30 )
                                <div class="mt-2 text-xs flex items-center text-orange-400">
                                <i class="ri-arrow-down-line mr-1"></i>
                                <span> ≈ sales about to go down </span>
                                </div>

                            @elseif($weekPercentageChange < -50 )
                                <div class="mt-2 text-xs flex items-center text-red-500">
                                <i class="ri-arrow-down-line mr-1"></i>
                                <span>  sales go down </span>
                                </div>
                            
                            @endif

                         </span>
                     </div>
                 </div>
                 <div class="stats-card rounded p-6 flex flex-col">
                     <div class="flex items-center justify-between mb-4">
                         <span class="text-gray-400 text-sm">Total Orders</span>
                         <div
                             class="w-8 h-8 flex items-center justify-center rounded-full bg-purple-500/10 text-purple-400">
                             <i class="ri-shopping-bag-line"></i>
                         </div>
                     </div>
                     <div class="text-3xl font-bold text-purple-400">{{ $salesCount }}</div>
                        <div class="mt-2 text-xs flex items-center text-green-400">
                      
                         <span>
                    
                    
                            @if($weekPercentageChange > 0)
                            <div class="mt-2 text-xs flex items-center text-green-400">
                                <i class="ri-arrow-up-line mr-1"></i>
                                <span> Orders arrow go up</span>
                            </div>
                            @elseif($weekPercentageChange > -50 && $weekPercentageChange < -30 )
                                <div class="mt-2 text-xs flex items-center text-orange-400">
                                <i class="ri-arrow-down-line mr-1"></i>
                                <span> ≈ Orders about to go down </span>
                                </div>

                            @elseif($weekPercentageChange < -50 )
                                <div class="mt-2 text-xs flex items-center text-red-500">
                                <i class="ri-arrow-down-line mr-1"></i>
                                <span>  Orders go down </span>
                                </div>
                            
                            @endif

                       </span> 
                       </div>
                 </div>
             </div>
             <!-- Secondary Stats Cards -->
             <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                 <div class="stats-card rounded p-6 col-span-1">
                     <div class="flex items-center justify-between mb-2">
                         <span class="text-gray-400 text-sm">Products</span>
                         <div
                             class="w-8 h-8 flex items-center justify-center rounded-full bg-amber-500/10 text-amber-400">
                             <i class="ri-store-line"></i>
                         </div>
                     </div>
                     <div class="text-3xl font-bold text-amber-400">{{ $totalProducts }}</div>
                     <div class="mt-2 text-xs text-gray-400">
                         <span> {{$newProductsThisMonth}} new this month</span>
                     </div>
                 </div>
                 <div class="stats-card rounded p-6 col-span-1">
                     <div class="flex items-center justify-between mb-2">
                         <span class="text-gray-400 text-sm">Customers</span>
                         <div
                             class="w-8 h-8 flex items-center justify-center rounded-full bg-rose-500/10 text-rose-400">
                             <i class="ri-user-line"></i>
                         </div>
                     </div>
                     <div class="text-3xl font-bold text-rose-400">{{ $totalUsers }}</div>
                     <div class="mt-2 text-xs text-gray-400">
                         <span>{{$newUsersThisWeek}} new this week</span>
                     </div>
                 </div>
                 <!-- Chart -->
                 <div class="stats-card rounded p-6 col-span-2" id="sales-chart">
                     <div class="flex items-center justify-between mb-4">
                         <span class="text-gray-300 font-medium">Sales Overview</span>
                         <div class="flex space-x-2">
                             <button id="weekly-btn"
                                 class="px-3 py-1 text-xs rounded bg-gray-800 hover:bg-gray-700 text-gray-300 whitespace-nowrap !rounded-button">Weekly</button>
                             <button id="monthly-btn"
                                 class="px-3 py-1 text-xs rounded bg-primary/10 text-primary hover:bg-primary/20 whitespace-nowrap !rounded-button">Monthly</button>
                         </div>
                     </div>
                     <div class="h-48" id="sales-trend-chart"></div>
                 </div>
             </div>
             <!-- Recent Orders -->
             <div class="stats-card rounded overflow-hidden">
                 <div class="p-6 flex justify-between items-center border-b border-gray-800">
                     <h2 class="text-lg font-medium">Recent Orders</h2>
                     <div class="flex space-x-2">
                         {{-- <button
                             class="px-3 py-1.5 text-xs rounded bg-gray-800 hover:bg-gray-700 text-gray-300 whitespace-nowrap !rounded-button">
                             <i class="ri-filter-line ml-1"></i> تصفية
                         </button> --}}
                         <a href="{{route('admin.orders.index')}}"
                             class="px-3 py-1.5 text-xs rounded bg-primary text-white hover:bg-primary/90 whitespace-nowrap !rounded-button">
                             <i class="ri-align-item-left-line"></i>  الكل
                        </a>
                     </div>
                 </div>
                 <div class="overflow-x-auto">
                     <table class="w-full">
                         <thead>
                             <tr class="text-left text-xs text-gray-400 bg-gray-800">
                                 <th class="px-6 py-3 font-medium">
                                     <div class="flex items-center">
                                         <input  style="opacity:0;" type="checkbox" class="mr-3">
                                         Order ID
                                     </div>
                                 </th>
                                 <th class="px-6 py-3 font-medium">Customer</th>
                                 <th class="px-6 py-3 font-medium">Product</th>
                                 <th class="px-6 py-3 font-medium">Amount</th>
                                 <th class="px-6 py-3 font-medium">Status</th>
                                 <th class="px-6 py-3 font-medium">Date</th>
                                 <th class="px-6 py-3 font-medium">Actions</th>
                             </tr>
                         </thead>
                         <tbody>

                            @if ($recentOrders->count() > 0)

                             @foreach ($recentOrders as $order)
                                 <tr class="table-row">
                                 <td class="px-6 py-4">
                                     <div class="flex items-center">
                                         <input style="opacity:0;" type="checkbox" class="mr-3">
                                         <span>{{ $order->id }}#</span>
                                     </div>
                                 </td>
                                 <td class="px-6 py-4">
                                     <div class="flex items-center">
                                         <div
                                             class="w-8 h-8 ml-2 rounded-full bg-green-500/20 flex items-center justify-center mr-3 text-green-400">
                                             <i class="ri-user-fill"></i>
                                         </div>
                                         <div>
                                             <div class="font-medium">{{ $order->user ? $order->user->name : 'غير مسجل' }}</div>
                                             <div class="text-xs text-gray-400">{{ $order->user ? $order->user->email : 'user@gmail.com' }}</div>
                                         </div>
                                     </div>
                                 </td>
                                 <td class="px-6 py-4">
                                    @if ($order->items && $order->items->count())
                                            {{ $order->items->first()->name }}
                                        @else
                                            -
                                        @endif
                                 </td>
                                 <td class="px-6 py-4 font-medium">  {{ number_format($order->total, 2) }} ريال</td>
                                 <td class="px-6 py-4">
                                     <span class="px-2 py-1 rounded text-xs 
                                            {{ $order->status == 'completed' ? 'status-completed ' : ($order->status == 'cancelled' ? 'status-cancelled' : 'status-pending') }}">
                                            {{ $order->status }}
                                        </span>
                                 </td>
                                 <td class="px-6 py-4 text-gray-400">{{ $order->created_at->format('Y-m-d') }} </td>
                                 <td class="px-6 py-4">
                                     <div class="flex space-x-2">
                                         <button
                                             class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-800 text-gray-400 hover:text-white">
                                             <i class="ri-eye-line"></i>
                                         </button>
                                         <button
                                             class="w-8 h-8 flex items-center justify-center rounded hover:bg-gray-800 text-gray-400 hover:text-white">
                                             <i class="ri-edit-line"></i>
                                         </button>
                                     </div>
                                 </td>
                                 </tr>

                             @endforeach
                            @endif



                    
                        
                         </tbody>
                     </table>
                 </div>
                 {{-- <div class="p-4 border-t border-gray-800 flex items-center justify-between">
                     <div class="text-sm text-gray-400">Showing 1 to 5 of 25 entries</div>
                     <div class="flex space-x-1">
                         <button
                             class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 text-gray-400 hover:bg-gray-700 disabled:opacity-50"
                             disabled>
                             <i class="ri-arrow-left-s-line"></i>
                         </button>
                         <button
                             class="w-8 h-8 flex items-center justify-center rounded bg-primary text-white">1</button>
                         <button
                             class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 text-gray-400 hover:bg-gray-700">2</button>
                         <button
                             class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 text-gray-400 hover:bg-gray-700">3</button>
                         <button
                             class="w-8 h-8 flex items-center justify-center rounded bg-gray-800 text-gray-400 hover:bg-gray-700">
                             <i class="ri-arrow-right-s-line"></i>
                         </button>
                     </div>
                 </div> --}}
             </div>
         </main>
     </div>
     <script id="toast-handler">
         document.addEventListener('DOMContentLoaded', function() {
             const themeSwitch = document.getElementById('theme-switch');
             const toast = document.getElementById('toast');
             const toastMessage = toast.querySelector('p');

             function showToast(message) {
                 toastMessage.textContent = message;
                 toast.classList.remove('translate-y-full', 'opacity-0');
                 setTimeout(() => {
                     toast.classList.add('translate-y-full', 'opacity-0');
                 }, 3000);
             }
             themeSwitch.querySelector('input').addEventListener('change', function(e) {
                 const isDarkMode = e.target.checked;
                 showToast(isDarkMode ? 'تم تفعيل الوضع الليلي' : 'تم إيقاف الوضع الليلي');
             });
         });
     </script>
    
     <script id="chart-initialization">
         document.addEventListener('DOMContentLoaded', function() {
             const salesChart = echarts.init(document.getElementById('sales-trend-chart'));
             const weeklyBtn = document.getElementById('weekly-btn');
             const monthlyBtn = document.getElementById('monthly-btn');
             const sales = @json($monthlySales);
              const weeklySales = @json($weeklySalesFormatted);
             
             const salesArray = Object.values(sales);
             
             const weeklySalesArray = Object.values(weeklySales);
             const monthlyData = {
                 xAxis: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                 sales: salesArray,
                 profit: [2100, 2800, 3600, 3200, 4100, 4800, 5500, 5200, 6000, 6500, 7200, 7800]
             };
             const weeklyData = {
                 xAxis: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                 sales: weeklySalesArray,
                 profit: [450, 520, 680, 590, 780, 850, 720]
             };

             function getChartOption(data) {
                 return {
                     animation: false,
                     grid: {
                         top: 10,
                         right: 10,
                         bottom: 20,
                         left: 40,
                     },
                     tooltip: {
                         trigger: 'axis',
                         backgroundColor: 'rgba(255, 255, 255, 0.8)',
                         borderColor: '#eee',
                         borderWidth: 1,
                         textStyle: {
                             color: '#1f2937'
                         }
                     },
                     xAxis: {
                         type: 'category',
                         data: data.xAxis,
                         axisLine: {
                             lineStyle: {
                                 color: '#4b5563'
                             }
                         },
                         axisLabel: {
                             color: '#9ca3af'
                         }
                     },
                     yAxis: {
                         type: 'value',
                         axisLine: {
                             lineStyle: {
                                 color: '#4b5563'
                             }
                         },
                         splitLine: {
                             lineStyle: {
                                 color: '#374151'
                             }
                         },
                         axisLabel: {
                             color: '#9ca3af'
                         }
                     },
                     series: [{
                             name: 'Sales',
                             type: 'line',
                             smooth: true,
                             data: data.sales,
                             lineStyle: {
                                 color: 'rgba(87, 181, 231, 1)'
                             },
                             itemStyle: {
                                 color: 'rgba(87, 181, 231, 1)'
                             },
                             areaStyle: {
                                 color: {
                                     type: 'linear',
                                     x: 0,
                                     y: 0,
                                     x2: 0,
                                     y2: 1,
                                     colorStops: [{
                                             offset: 0,
                                             color: 'rgba(87, 181, 231, 0.3)'
                                         },
                                         {
                                             offset: 1,
                                             color: 'rgba(87, 181, 231, 0.05)'
                                         }
                                     ]
                                 }
                             },
                             symbol: 'none'
                         },
                         {
                             name: 'Profit',
                             type: 'line',
                             smooth: true,
                             data: data.profit,
                             lineStyle: {
                                 color: 'rgba(141, 211, 199, 1)'
                             },
                             itemStyle: {
                                 color: 'rgba(141, 211, 199, 1)'
                             },
                             areaStyle: {
                                 color: {
                                     type: 'linear',
                                     x: 0,
                                     y: 0,
                                     x2: 0,
                                     y2: 1,
                                     colorStops: [{
                                             offset: 0,
                                             color: 'rgba(141, 211, 199, 0.3)'
                                         },
                                         {
                                             offset: 1,
                                             color: 'rgba(141, 211, 199, 0.05)'
                                         }
                                     ]
                                 }
                             },
                             symbol: 'none'
                         }
                     ]
                 };
             }

             function updateChart(isWeekly) {
                 const data = isWeekly ? weeklyData : monthlyData;
                 salesChart.setOption(getChartOption(data));
                 weeklyBtn.className = isWeekly ?
                     'px-3 py-1 text-xs rounded bg-primary/10 text-primary hover:bg-primary/20 whitespace-nowrap !rounded-button' :
                     'px-3 py-1 text-xs rounded bg-gray-800 hover:bg-gray-700 text-gray-300 whitespace-nowrap !rounded-button';
                 monthlyBtn.className = !isWeekly ?
                     'px-3 py-1 text-xs rounded bg-primary/10 text-primary hover:bg-primary/20 whitespace-nowrap !rounded-button' :
                     'px-3 py-1 text-xs rounded bg-gray-800 hover:bg-gray-700 text-gray-300 whitespace-nowrap !rounded-button';
             }
             weeklyBtn.addEventListener('click', () => updateChart(true));
             monthlyBtn.addEventListener('click', () => updateChart(false));
             updateChart(false);
             window.addEventListener('resize', function() {
                 salesChart.resize();
             });
         });
     </script>









    {{-- <!-- JavaScript للتحكم في القوائم المنسدلة -->
    <script>
        function toggleDropdown(section) {
            const content = document.getElementById(section + '-content');
            const arrow = document.getElementById(section + '-arrow');

            // تبديل القائمة الحالية فقط
            content.classList.toggle('show');
            arrow.classList.toggle('rotate-180');
        }

        // فتح قسم إدارة المتجر افتراضياً
        document.addEventListener('DOMContentLoaded', function() {
            toggleDropdown('store');
        });
    </script> --}}












 </body>

 </html>








 {{-- @extends('themes.admin.layouts.app')
@section('content')
<div class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-100 p-6 rounded">


@section('title', 'لوحة القيادة')

@section('content')
<div class="py-4 px-2 bg-gray-100 dark:bg-gray-900 min-h-screen">
    <!-- إحصائيات سريعة -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="rounded-lg shadow-lg bg-white dark:bg-gray-800 p-6 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
            <div class="flex-shrink-0">
                <i class="fas fa-shopping-cart text-4xl text-primary"></i>
            </div>
            <div>
                <div class="text-3xl font-bold text-primary">{{ $salesCount }}</div>
                <div class="text-gray-500 dark:text-gray-300">إجمالي الطلبات</div>
            </div>
        </div>
        <div class="rounded-lg shadow-lg bg-white dark:bg-gray-800 p-6 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
            <div class="flex-shrink-0">
                <i class="fas fa-money-bill-wave text-4xl text-green-600"></i>
            </div>
            <div>
                <div class="text-3xl font-bold text-green-600">{{ number_format($totalSales, 2) }}</div>
                <div class="text-gray-500 dark:text-gray-300">إجمالي المبيعات (ريال)</div>
            </div>
        </div>
        <!-- بطاقة مبيعات اليوم -->
        <div class="rounded-lg shadow-lg bg-white dark:bg-gray-800 p-6 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
            <div class="flex-shrink-0">
                <i class="fas fa-calendar-day text-4xl text-blue-500"></i>
            </div>
            <div>
                <div class="text-3xl font-bold text-blue-500">{{ number_format($todaySales, 2) }}</div>
                <div class="text-gray-500 dark:text-gray-300">مبيعات اليوم (ريال)</div>
            </div>
        </div>
        <!-- بطاقة مبيعات الشهر -->
        <div class="rounded-lg shadow-lg bg-white dark:bg-gray-800 p-6 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
            <div class="flex-shrink-0">
                <i class="fas fa-calendar-alt text-4xl text-purple-600"></i>
            </div>
            <div>
                <div class="text-3xl font-bold text-purple-600">{{ number_format($monthSales, 2) }}</div>
                <div class="text-gray-500 dark:text-gray-300">مبيعات الشهر (ريال)</div>
            </div>
        </div>
        <div class="rounded-lg shadow-lg bg-white dark:bg-gray-800 p-6 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
            <div class="flex-shrink-0">
                <i class="fas fa-users text-4xl text-blue-600"></i>
            </div>
            <div>
                <div class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</div>
                <div class="text-gray-500 dark:text-gray-300">عدد المستخدمين</div>
            </div>
        </div>
        <div class="rounded-lg shadow-lg bg-white dark:bg-gray-800 p-6 flex items-center gap-4 border border-gray-200 dark:border-gray-700">
            <div class="flex-shrink-0">
                <i class="fas fa-box text-4xl text-yellow-500"></i>
            </div>
            <div>
                <div class="text-3xl font-bold text-yellow-500">{{ $totalProducts }}</div>
                <div class="text-gray-500 dark:text-gray-300">عدد المنتجات</div>
            </div>
        </div>
    </div>

    <!-- آخر الطلبات -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center mb-4">
                <h5 class="text-lg font-bold text-primary">آخر الطلبات</h5>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.orders.index') }}" class="bg-gradient-to-r from-primary to-secondary text-white px-4 py-2 rounded-md font-semibold text-xs hover:opacity-90 transition">عرض الكل</a>
                    <a href="{{ route('admin.orders.index') }}" class="bg-white dark:bg-gray-900 border border-primary text-primary px-4 py-2 rounded-md font-semibold text-xs hover:bg-primary hover:text-white transition">عرض قسم الطلبات</a>
                </div>
            </div>
            @if ($recentOrders->count() > 0)
                <div class="overflow-x-auto w-full">
                    <table class="min-w-full text-sm text-gray-700 dark:text-gray-200 whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-primary">
                                <th class="py-2 px-3">#</th>
                                <th class="py-2 px-3">المستخدم</th>
                                <th class="py-2 px-3">المنتج</th>
                                <th class="py-2 px-3">المبلغ</th>
                                <th class="py-2 px-3">الحالة</th>
                                <th class="py-2 px-3">التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentOrders as $order)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="py-2 px-3">{{ $order->id }}</td>
                                    <td class="py-2 px-3">{{ $order->user ? $order->user->name : 'غير مسجل' }}</td>
                                    <td class="py-2 px-3">
                                        @if ($order->items && $order->items->count())
                                            {{ $order->items->first()->name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-2 px-3">{{ number_format($order->total, 2) }} ريال</td>
                                    <td class="py-2 px-3">
                                        <span class="px-2 py-1 rounded text-xs font-bold
                                            {{ $order->status == 'completed' ? 'bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-200' : ($order->status == 'cancelled' ? 'bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-700 dark:text-yellow-200') }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="py-2 px-3">{{ $order->created_at->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center text-gray-400 dark:text-gray-500 py-8">لا توجد طلبات حالياً</div>
            @endif
        </div>
    </div>

    <!-- إحصائيات المبيعات الشهرية -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border border-gray-200 dark:border-gray-700">
        <h5 class="text-lg font-bold text-primary mb-4">إحصائيات المبيعات الشهرية لعام {{ now()->year }}</h5>
        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4" style="min-height:260px;">
            <canvas id="salesChart" height="220"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var salesData = {!! json_encode(array_values($monthlySales)) !!};
        var monthNames = ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر'];
        var chartData = [];
        for (var i = 1; i <= 12; i++) {
            chartData.push(salesData[i] || 0);
        }
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'المبيعات (ريال)',
                    data: chartData,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                animation: false,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@endpush   --}}
