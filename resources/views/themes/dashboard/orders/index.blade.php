@extends('themes.dashboard.layouts.app')

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
                                @if(isset($customOrderIds) && in_array($order->id, $customOrderIds))
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 ml-2">مخصص</span>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium
                                @if($order->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800
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
                            @foreach($order->items as $key => $item)
                                @if($key < 2)
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
                                    @if(isset($customOrderIds) && in_array($order->id, $customOrderIds))
                                    <span class="mr-2 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200" title="يحتوي على منتجات مخصصة">مخصص</span>
                                    @endif
                                </div>
                                <div class="mt-2 space-y-1">
                                    @foreach($order->items as $key => $item)
                                        @if($key < 2)
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
                                    @foreach($order->items as $key => $item)
                                        @if($key < 2)
                                            @if($item->orderable_type === 'App\\Models\\Product' && $item->orderable)
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
                                    @if($order->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800
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
@endsection 