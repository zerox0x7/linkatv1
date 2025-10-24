<!DOCTYPE html>
<html lang="ar" dir="rtl" style="overflow-y: scroll; -ms-overflow-style: none; scrollbar-width: none;">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.5.0/echarts.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#1ED6B1",
                        secondary: "#3B82F6",
                    },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
    </script>
    <style>
        :where([class^="ri-"])::before {
            content: "\f3c2";
        }

        .dark-mode {
            background-color: #0f172a;
            color: #e2e8f0;
        }

        .card {
            background-color: rgba(30, 41, 59, 0.5);
            backdrop-filter: blur(8px);
        }

        .table-row:hover {
            background-color: rgba(30, 41, 59, 0.8);
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
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

<body class="dark-mode min-h-screen">
    <div class="flex">
        @include('themes.admin.parts.sidebar')



        <main class="flex-1  ">
            @include('themes.admin.parts.header')

            <div class="p-8">
                <div class="grid grid-cols-4 gap-6 mb-8">
                    <div class="card rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-500/20">
                                <i class="ri-checkbox-circle-line text-emerald-500"></i>
                            </div>
                        </div>
                        <h3 class="text-sm text-gray-400">الطلبات المكتملة</h3>
                        <div class="text-2xl font-semibold mt-1">{{ $completedOrders }}</div>
                        <div class="text-xs text-emerald-500 mt-2">
                            تم اكتمال {{ $completedOrdersToday }} طلب اليوم
                        </div>
                    </div>
                    <div class="card rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-yellow-500/20">
                                <i class="ri-time-line text-yellow-500"></i>
                            </div>
                        </div>
                        <h3 class="text-sm text-gray-400">الطلبات المعلقة</h3>
                        <div class="text-2xl font-semibold mt-1">{{ $pendingOrders }}</div>
                        <div class="text-xs text-yellow-500 mt-2">
                            {{ $pendingOrdersThisWeek }} طلب في انتظار المراجعة
                        </div>
                    </div>
                    <div class="card rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-rose-500/20">
                                <i class="ri-close-circle-line text-rose-500"></i>
                            </div>
                        </div>
                        <h3 class="text-sm text-gray-400">الطلبات المرفوضة</h3>
                        <div class="text-2xl font-semibold mt-1">{{ $rejectedOrders }}</div>
                        <div class="text-xs text-rose-500 mt-2">
                            {{ $rejectedOrdersThisWeek }} طلب مرفوض هذا الأسبوع
                        </div>
                    </div>
                    <div class="card rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-blue-500/20">
                                <i class="ri-loader-4-line text-blue-500"></i>
                            </div>
                        </div>
                        <h3 class="text-sm text-gray-400">في الانتظار</h3>
                        <div class="text-2xl font-semibold mt-1">{{ $processingOrders }}</div>
                        <div class="text-xs text-blue-500 mt-2">
                            {{ $processingOrdersThisWeek }} طلب جديد في الانتظار
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-6 mb-8">
                    <div class="card col-span-2 rounded-lg p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-semibold">نظرة عامة على المبيعات</h3>
                            <div class="flex items-center gap-2">
                                <button id="monthlyBtn" class="px-3 py-1 text-sm !rounded-button bg-slate-700">
                                    شهري
                                </button>
                                <button id="weeklyBtn" class="px-3 py-1 text-sm !rounded-button text-gray-400">
                                    أسبوعي
                                </button>
                            </div>
                        </div>
                        <div id="salesChart" class="h-64"></div>
                    </div>
                    <div class="grid grid-rows-2 gap-6">
                        <div class="card rounded-lg p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-semibold">العملاء</h3>
                                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-rose-500/20">
                                    <i class="ri-user-line text-rose-500"></i>
                                </div>
                            </div>
                            <div class="text-3xl font-semibold">{{ $totalUsers }}</div>
                            <div class="text-sm text-gray-400 mt-2">
                                {{ $newUsersThisWeek }} عميل جديد هذا الأسبوع
                            </div>
                        </div>
                        <div class="card rounded-lg p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-semibold">المنتجات</h3>
                                <div class="w-8 h-8 flex items-center justify-center rounded-lg bg-yellow-500/20">
                                    <i class="ri-shopping-bag-line text-yellow-500"></i>
                                </div>
                            </div>
                            <div class="text-3xl font-semibold">{{ $totalProducts }}</div>
                            <div class="text-sm text-gray-400 mt-2">
                                {{ $newProductsThisMonth }} منتج جديد هذا الشهر
                            </div>
                        </div>
                    </div>
                </div>

              {{-- <form  action="{{route('admin.orders.index')}}" id="ordersSearchForm">
                    @csrf
                <div class="card rounded-lg">
                    <div class="p-6 border-b border-slate-700 space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="font-semibold text-lg">الطلبات الحديثة</h3>
                            <button type="submit" id="ordersSearchForm"
                                class="px-3 py-1 text-sm !rounded-button bg-slate-700 hover:bg-slate-600 transition-colors">
                                بحث <i class="ri-search-eye-line"></i>
                            </button>
                        </div>



                        <div class="grid grid-cols-5 gap-4">



                            <div class="relative">
                                <input type="text" name="order_number" placeholder="رقم الطلب"
                                    class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                                    <i class="ri-hashtag"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="text" name="customer_name" placeholder="اسم العميل"
                                    class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                                    <i class="ri-user-line"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="text" name="product_name" placeholder="المنتج"
                                    class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                                    <i class="ri-shopping-bag-line"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <input type="number" name="order_price" placeholder="السعر"
                                    class="w-full bg-slate-800 border-none !rounded-button pl-9 pr-4 py-2 text-sm" />
                                <div
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 flex items-center justify-center text-gray-400">
                                    <i class="ri-money-dollar-circle-line"></i>
                                </div>
                            </div>

                            <div class="relative">
                                <!-- Date Input -->
                                <input type="date" name="order_date"
                                    class="w-full bg-slate-800 border border-slate-700  border-none !rounded-button pl-10 pr-4 py-2 text-sm text-gray-400 placeholder-gray-400  cursor-pointer appearance-none" />

                                <div
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none">
                                    <i class="ri-calendar-schedule-fill"></i>
                                </div>
                            </div>

                        </div>






                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-right text-sm text-gray-400 border-b border-slate-700">
                                    <th class="py-4 px-6 font-medium">رقم الطلب</th>
                                    <th class="py-4 px-6 font-medium">العميل</th>
                                    <th class="py-4 px-6 font-medium">المنتج</th>
                                    <th class="py-4 px-6 font-medium">المبلغ</th>
                                    <th class="py-4 px-6 font-medium">الحالة</th>
                                    <th class="py-4 px-6 font-medium">التاريخ</th>
                                    <th class="py-4 px-6 font-medium">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>



                                @if ($recentOrders->count() > 0)

                                    @foreach ($recentOrders as $order)
                                        <tr
                                            class="table-row border-b border-slate-700 hover:bg-slate-800/50 transition-colors">
                                            <td class="py-4 px-6">{{ $order->id }}#</td>
                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center">
                                                        <i class="ri-user-line text-blue-500"></i>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">
                                                            {{ $order->user ? $order->user->name : 'غير مسجل' }} </div>
                                                        <div class="text-sm text-gray-400">
                                                            {{ $order->user ? $order->user->email : 'user@gmail.com' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="py-4 px-6">
                                                @if ($order->items && $order->items->count())
                                                    {{ $order->items->first()->name }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="py-4 px-6"> {{ number_format($order->total, 2) }} ريال</td>
                                            <td class="py-4 px-6">
                                                <span
                                                    class="px-2 py-1 text-xs !rounded-button {{ $order->status == 'completed' ? 'bg-emerald-500/20 text-emerald-500 ' : ($order->status == 'rejected' ? 'bg-rose-500/20 text-rose-500' : 'bg-yellow-500/20 text-yellow-500') }}" " >
                  
                                  {{ $order->status }}
                      
                      
                                  </span
                                >
                              </td>
                              <td class="py-4 px-6"> {{ $order->created_at->format('Y-m-d') }} </td>
                              <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                  <button
                                    class="w-8 h-8 !rounded-button flex items-center justify-center bg-slate-700 hover:bg-slate-600 transition-colors"
                                  >
                                    <i class="ri-eye-line"></i>
                                  </button>
                                  <button
                                    class="w-8 h-8 !rounded-button flex items-center justify-center bg-slate-700 hover:bg-slate-600 transition-colors"
                                  >
                                    <i class="ri-edit-line"></i>
                                  </button>
                                  <button
                                    class="w-8 h-8 !rounded-button flex items-center justify-center bg-rose-500/20 text-rose-500 hover:bg-rose-500/30 transition-colors"
                                  >
                                    <i class="ri-delete-bin-line"></i>
                                  </button>
                                </div>
                              </td>
                              </tr>
                             @endforeach
                                    @endif







                            </tbody>
                        </table>
                    </div>
                </div>
              </form> --}}

              @livewire('orders-table')

            </div>

        </main>
    </div>
    
    













    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const salesChart = echarts.init(document.getElementById("salesChart"));
            const monthlyBtn = document.getElementById("monthlyBtn");
            const weeklyBtn = document.getElementById("weeklyBtn");

            const monthlySales = @json($monthlySales);
            const weeklySales = @json($weeklySales);

            const monthSalesArray = Object.values(monthlySales);
            const weeklySalesArray = Object.values(weeklySales);

            const monthlyData = {
                xAxis: [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "أبريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "أغسطس",
                    "سبتمبر",
                    "أكتوبر",
                    "نوفمبر",
                    "ديسمبر",
                ],
                series: monthSalesArray,
            };
            const weeklyData = {
                xAxis: ["الأسبوع 1", "الأسبوع 2", "الأسبوع 3", "الأسبوع 4"],
                series: weeklySalesArray,
            };
            monthlyBtn.addEventListener("click", () => {
                monthlyBtn.classList.add("bg-slate-700");
                monthlyBtn.classList.remove("text-gray-400");
                weeklyBtn.classList.remove("bg-slate-700");
                weeklyBtn.classList.add("text-gray-400");
                updateChart(monthlyData);
            });
            weeklyBtn.addEventListener("click", () => {
                weeklyBtn.classList.add("bg-slate-700");
                weeklyBtn.classList.remove("text-gray-400");
                monthlyBtn.classList.remove("bg-slate-700");
                monthlyBtn.classList.add("text-gray-400");
                updateChart(weeklyData);
            });

            function updateChart(data) {
                const option = {
                    animation: false,
                    grid: {
                        top: 0,
                        right: 0,
                        bottom: 0,
                        left: 0,
                        containLabel: true,
                    },
                    tooltip: {
                        trigger: "axis",
                        backgroundColor: "rgba(255, 255, 255, 0.9)",
                        borderWidth: 0,
                        textStyle: {
                            color: "#1f2937",
                        },
                    },
                    xAxis: {
                        type: "category",
                        data: data.xAxis,
                        axisLine: {
                            lineStyle: {
                                color: "#475569",
                            },
                        },
                        axisLabel: {
                            color: "#94a3b8",
                        },
                    },
                    yAxis: {
                        type: "value",
                        axisLine: {
                            lineStyle: {
                                color: "#475569",
                            },
                        },
                        splitLine: {
                            lineStyle: {
                                color: "#334155",
                            },
                        },
                        axisLabel: {
                            color: "#94a3b8",
                        },
                    },
                    series: [{
                        name: "المبيعات",
                        type: "line",
                        smooth: true,
                        data: data.series,
                        lineStyle: {
                            color: "#57b5e7",
                        },
                        areaStyle: {
                            color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [{
                                    offset: 0,
                                    color: "rgba(87, 181, 231, 0.2)",
                                },
                                {
                                    offset: 1,
                                    color: "rgba(87, 181, 231, 0)",
                                },
                            ]),
                        },
                        symbol: "none",
                    }, ],
                };
                salesChart.setOption(option);
            }
            updateChart(monthlyData);
            window.addEventListener("resize", function() {
                salesChart.resize();
            });
        });
    </script>




{{-- 
  <script>
    // Get the form element
    const form = document.getElementById('ordersSearchForm');

    // Add submit event listener to the form
    form.addEventListener('submit', function(event) {
      // Prevent the default form submission behavior
      event.preventDefault();

      // Get form data
     

      // Display the submitted data
      const resultDiv = document.getElementById('tbody');
      resultDiv.innerHTML = `<p>Name: ${name}</p><p>Email: ${email}</p>`;

      // Optionally, you can send the data via AJAX here
      console.log('Form submitted:', { name, email });
    });
  </script> --}}



    
</body>

</html>



























































{{-- @extends('themes.admin.layouts.app')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">إدارة الطلبات</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <span class="text-sm text-gray-500">{{ now()->translatedFormat('l، j F Y') }}</span>
        </div>
    </div>

    <!-- إحصائيات -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">إجمالي المبيعات</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($totalSales ?? 0, 2) }} ر.س</h3>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg class="h-6 w-6 text-green-600 dark:text-green-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs font-medium {{ ($salesGrowth ?? 0) >= 0 ? 'text-green-600 dark:text-green-300' : 'text-red-600 dark:text-red-300' }}">
                    {{ ($salesGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($salesGrowth ?? 0, 1) }}%
                </span>
                <span class="text-xs text-gray-500 dark:text-gray-300"> مقارنة بالشهر السابق</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">عدد الطلبات</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $totalOrders ?? 0 }}</h3>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs font-medium {{ ($ordersGrowth ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ ($ordersGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($ordersGrowth ?? 0, 1) }}%
                </span>
                <span class="text-xs text-gray-500"> مقارنة بالشهر السابق</span>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">طلبات قيد المعالجة</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ $processingOrders ?? 0 }}</h3>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <a href="#processing" class="text-xs font-medium text-blue-600 hover:underline">عرض الطلبات قيد المعالجة</a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-4">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-500 dark:text-gray-300">متوسط قيمة الطلب</p>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-100">{{ number_format($averageOrderValue ?? 0, 2) }} ر.س</h3>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
            <div class="mt-2">
                <span class="text-xs font-medium {{ ($avgOrderGrowth ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ ($avgOrderGrowth ?? 0) >= 0 ? '+' : '' }}{{ number_format($avgOrderGrowth ?? 0, 1) }}%
                </span>
                <span class="text-xs text-gray-500"> مقارنة بالشهر السابق</span>
            </div>
        </div>
    </div>

    <!-- نموذج البحث -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="space-y-4">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="order_number" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">رقم الطلب</label>
                    <input type="text" name="order_number" id="order_number" value="{{ request('order_number') }}" 
                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="ابحث برقم الطلب...">
                </div>
                <div class="flex-1">
                    <label for="customer_name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">اسم العميل</label>
                    <input type="text" name="customer_name" id="customer_name" value="{{ request('customer_name') }}" 
                        class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                        placeholder="ابحث باسم العميل...">
                </div>
                <div class="flex-1">
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">حالة الطلب</label>
                    <select name="status" id="status" class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">جميع الحالات</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        <svg class="ml-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        بحث
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-900 rounded-lg shadow-md p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3 sm:mb-0">قائمة الطلبات</h2>
            <div class="flex space-x-2 space-x-reverse">
                <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                    <svg class="ml-2 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    تصدير CSV
                </a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
            <!-- عرض البطاقات في الجوال -->
            <div class="block md:hidden space-y-4">
                @forelse ($orders as $order)
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-bold">#{{ $order->id }}</a>
                                @if (isset($customOrderIds) && in_array($order->id, $customOrderIds))
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 ml-2">مخصص</span>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                @if ($order->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800
                                @elseif($order->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800
                                @elseif($order->status == 'processing') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800
                                @elseif($order->status == 'cancelled') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800
                                @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 @endif">
                                {{ __("orders.status.$order->status") ?? $order->status }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <div class="text-xs text-gray-500 dark:text-gray-300">{{ $order->created_at->format('Y-m-d H:i') }}</div>
                        </div>
                        <div class="mb-2">
                            <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->user->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-300">{{ $order->payment ? $order->payment->method : 'غير معروفة' }}</div>
                        </div>
                        <div class="mb-2">
                            <div class="text-xs text-gray-500 dark:text-gray-300">المنتجات:</div>
                            @foreach ($order->items as $key => $item)
                                @if ($key < 2)
                                    <div class="text-xs text-gray-600 dark:text-gray-300">{{ $item->name }}</div>
                                @elseif($key == 2)
                                    <div class="text-xs text-gray-500 italic">+{{ $order->items->count() - 2 }} منتج آخر</div>
                                    @break
                                @endif
                            @endforeach
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <div class="text-sm font-bold text-blue-600 dark:text-blue-400">{{ number_format($order->total, 2) }} <span class="text-xs text-gray-500 dark:text-gray-300">ر.س</span></div>
                            <div class="flex space-x-2 space-x-reverse">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900 p-1.5 rounded-full transition-colors" title="عرض">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900 p-1.5 rounded-full transition-colors" title="تعديل">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button onclick="if(confirm('هل أنت متأكد من حذف هذا الطلب؟')) document.getElementById('delete-order-{{ $order->id }}').submit();" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900 p-1.5 rounded-full transition-colors" title="حذف">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                                <form id="delete-order-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center text-gray-500 dark:text-gray-300 py-8">لا توجد طلبات حتى الآن</div>
                @endforelse
            </div>
            <!-- الجدول في الشاشات المتوسطة والكبيرة -->
            <div class="hidden md:block">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">رقم الطلب / المنتج</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">نوع المنتج</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">العميل</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">المبلغ</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">طريقة الدفع</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">الحالة</th>
                            <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">التاريخ</th>
                            <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700" id="processing">
                        @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors {{ $order->status == 'processing' ? 'bg-yellow-50 dark:bg-yellow-900' : '' }}">
                            <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                <div class="flex items-start">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium hover:underline">#{{ $order->id }}</a>
                                    @if (isset($customOrderIds) && in_array($order->id, $customOrderIds))
                                    <span class="mr-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200" title="يحتوي على منتجات مخصصة">مخصص</span>
                                    @endif
                                </div>
                                <div class="mt-2 space-y-1">
                                    @foreach ($order->items as $key => $item)
                                        @if ($key < 2)
                                            <div class="text-xs text-gray-600 dark:text-gray-300">{{ $item->name }}</div>
                                        @elseif($key == 2)
                                            <div class="text-xs text-gray-500 italic">+{{ $order->items->count() - 2 }} منتج آخر</div>
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300">
                                <div class="space-y-1">
                                    @foreach ($order->items as $key => $item)
                                        @if ($key < 2)
                                            @if ($item->orderable_type === 'App\\Models\\Product' && $item->orderable)
                                                <div>
                                                    @switch($item->orderable->type ?? 'regular')
                                                        @case('digital_card')
                                                            <span class="px-2 py-1 text-xs rounded-md bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 font-medium">بطاقة رقمية</span>
                                                            @break
                                                        @case('custom')
                                                            <span class="px-2 py-1 text-xs rounded-md bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 font-medium">منتج مخصص</span>
                                                            @break
                                                        @case('digital')
                                                            <span class="px-2 py-1 text-xs rounded-md bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200 font-medium">منتج رقمي</span>
                                                            @break
                                                        @default
                                                            <span class="px-2 py-1 text-xs rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-medium">منتج عادي</span>
                                                    @endswitch
                                                </div>
                                            @else
                                                <div>
                                                    <span class="px-2 py-1 text-xs rounded-md bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 font-medium">غير محدد</span>
                                                </div>
                                            @endif
                                        @elseif($key == 2)
                                            <div class="text-xs text-gray-500 italic mt-1">...</div>
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200 font-medium">
                                {{ $order->user->name }}
                            </td>
                            <td class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200">
                                {{ number_format($order->total, 2) }} <span class="text-gray-500 dark:text-gray-300 text-xs">ر.س</span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-200">
                                {{ $order->payment ? $order->payment->method : 'غير معروفة' }}
                            </td>
                            <td class="px-4 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium 
                                    @if ($order->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800
                                    @elseif($order->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 border border-yellow-200 dark:border-yellow-800
                                    @elseif($order->status == 'processing') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200 border border-blue-200 dark:border-blue-800
                                    @elseif($order->status == 'cancelled') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 border border-red-200 dark:border-red-800
                                    @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 border border-gray-200 dark:border-gray-700 @endif">
                                    @switch($order->status)
                                        @case('completed')
                                            <svg class="ml-1 h-3 w-3 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            مكتمل
                                            @break
                                        @case('pending')
                                            <svg class="ml-1 h-3 w-3 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            قيد الانتظار
                                            @break
                                        @case('processing')
                                            <svg class="ml-1 h-3 w-3 text-blue-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                            </svg>
                                            قيد المعالجة
                                            @break
                                        @case('cancelled')
                                            <svg class="ml-1 h-3 w-3 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                            ملغي
                                            @break
                                        @default
                                            {{ $order->status }}
                                    @endswitch
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300">
                                <div class="whitespace-nowrap">{{ $order->created_at->format('Y-m-d') }}</div>
                                <div class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-4 py-4 text-sm text-center font-medium">
                                <div class="flex justify-center space-x-3 space-x-reverse">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900 p-1.5 rounded-full transition-colors" title="عرض">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.orders.edit', $order) }}" class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900 p-1.5 rounded-full transition-colors" title="تعديل">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <button onclick="if(confirm('هل أنت متأكد من حذف هذا الطلب؟')) document.getElementById('delete-order-{{ $order->id }}').submit();" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900 p-1.5 rounded-full transition-colors" title="حذف">
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                    <form id="delete-order-{{ $order->id }}" action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-300">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-300 dark:text-gray-700 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="font-medium">لا توجد طلبات حتى الآن</span>
                                    <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">سيتم عرض الطلبات الجديدة هنا عند إنشائها</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection  --}}
