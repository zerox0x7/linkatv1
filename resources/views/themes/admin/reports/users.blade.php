@extends('themes.admin.layouts.app')

@section('title', 'تقارير المستخدمين')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">تقارير المستخدمين</h1>
        <p class="text-gray-600">عرض بيانات وإحصائيات المستخدمين</p>
    </div>

    <!-- Period Selector -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-6">
        <form action="{{ route('admin.reports.users') }}" method="GET" class="flex items-center">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">إجمالي المستخدمين</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-500 ml-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-500 text-sm">المستخدمين النشطين</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $activeUsers }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- User Registration Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">تسجيلات المستخدمين الجدد</h2>
        <div style="height: 300px;">
            <canvas id="userChart"></canvas>
        </div>
    </div>

    <!-- Top Spenders -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">المستخدمين الأكثر إنفاقاً</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-right text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3">المستخدم</th>
                        <th scope="col" class="px-6 py-3">البريد الإلكتروني</th>
                        <th scope="col" class="px-6 py-3">إجمالي المشتريات</th>
                        <th scope="col" class="px-6 py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topSpenders as $user)
                        <tr class="border-b">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ number_format($user->total_spent, 2) }} ريال</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-blue-600 hover:underline ml-2">عرض</a>
                            </td>
                        </tr>
                    @empty
                        <tr class="border-b">
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">لا توجد بيانات للعرض</td>
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
        const ctx = document.getElementById('userChart').getContext('2d');
        
        const labels = @json($newUsers->pluck('date'));
        const counts = @json($newUsers->pluck('count'));
        
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'مستخدمين جدد',
                    data: counts,
                    backgroundColor: 'rgba(59, 130, 246, 0.8)',
                    borderRadius: 4
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
                        },
                        ticks: {
                            precision: 0
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
                    }
                }
            }
        });
    });
</script>
@endpush 