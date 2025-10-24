@extends('themes.dashboard.layouts.app')
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
            @if($recentOrders->count() > 0)
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
                            @foreach($recentOrders as $order)
                                <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                                    <td class="py-2 px-3">{{ $order->id }}</td>
                                    <td class="py-2 px-3">{{ $order->user ? $order->user->name : 'غير مسجل' }}</td>
                                    <td class="py-2 px-3">
                                        @if($order->items && $order->items->count())
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

@endpush 