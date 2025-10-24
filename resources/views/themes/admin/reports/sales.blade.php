@extends('themes.admin.layouts.app')

@section('title', 'تقارير المبيعات')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">تقارير المبيعات</h1>
        <p class="text-gray-600">عرض بيانات وإحصائيات المبيعات</p>
    </div>

    <!-- Period Selector -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="flex items-center">
            <div class="mr-4">
                <label for="period" class="block text-sm font-medium text-gray-700 mb-1">الفترة الزمنية</label>
                <select id="period" name="period" onchange="this.form.submit()" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="week" {{ $period === 'week' ? 'selected' : '' }}>آخر أسبوع</option>
                    <option value="month" {{ $period === 'month' ? 'selected' : '' }}>آخر شهر</option>
                    <option value="year" {{ $period === 'year' ? 'selected' : '' }}>آخر سنة</option>
                </select>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-500 ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">إجمالي المبيعات</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalSales, 2) }} ريال</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">عدد الطلبات</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">مخطط المبيعات</h2>
        <div style="height: 300px;">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <!-- Best Selling Products -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">المنتجات الأكثر مبيعاً</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">المنتج</th>
                        <th scope="col" class="px-6 py-3">الكمية المباعة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bestSellingProducts as $product)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $product->name }}</td>
                            <td class="px-6 py-4">{{ $product->total_quantity }}</td>
                        </tr>
                    @empty
                        <tr class="border-b">
                            <td colspan="2" class="px-6 py-4 text-center text-gray-500">لا توجد بيانات للعرض</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        const labels = @json($orders->pluck('date'));
        const amounts = @json($orders->pluck('total'));
        
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'المبيعات',
                    data: amounts,
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [2, 4],
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.formattedValue + ' ريال';
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush 