@extends('themes.dashboard.layouts.app')

@section('title', 'تفاصيل كوبون الخصم')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">تفاصيل كوبون الخصم</h1>
        <a href="{{ route('dashboard.coupons.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded shadow">عودة للقائمة</a>
    </div>
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">كود الخصم</span>
                    <span class="badge bg-primary dark:bg-blue-700 dark:text-white">{{ $coupon->code }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نوع الخصم</span>
                    <span class="badge {{ $coupon->type == 'fixed' ? 'bg-info dark:bg-blue-800' : 'bg-success dark:bg-green-800' }} dark:text-white">
                        {{ $coupon->type == 'fixed' ? 'مبلغ ثابت' : 'نسبة مئوية' }}
                    </span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">قيمة الخصم</span>
                    <span>{{ $coupon->type == 'fixed' ? $coupon->value . ' ر.س' : $coupon->value . '%' }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحالة</span>
                    <span class="badge bg-{{ $coupon->is_active ? 'success dark:bg-green-800 dark:text-white' : 'danger dark:bg-red-800 dark:text-white' }}">
                        {{ $coupon->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">صلاحية الكوبون</span>
                    <span class="badge bg-{{ $coupon->isValid() ? 'success dark:bg-green-800 dark:text-white' : 'danger dark:bg-red-800 dark:text-white' }}">
                        {{ $coupon->isValid() ? 'صالح' : 'غير صالح' }}
                    </span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تاريخ البدء</span>
                    <span>{{ $coupon->starts_at ? $coupon->starts_at->format('Y-m-d') : 'غير محدد' }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تاريخ الانتهاء</span>
                    <span>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'غير محدد' }}</span>
                </div>
            </div>
            <div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحد الأدنى للطلب</span>
                    <span>{{ $coupon->min_order_amount ? $coupon->min_order_amount . ' ر.س' : 'غير محدد' }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">الحد الأقصى للاستخدام</span>
                    <span>{{ $coupon->max_uses ?: 'غير محدد' }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">عدد مرات الاستخدام</span>
                    <span>{{ $coupon->used_times }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">نسبة الاستخدام</span>
                    @if($coupon->max_uses && $coupon->used_times)
                        @php $percentage = min(100, ($coupon->used_times / $coupon->max_uses) * 100); @endphp
                        <div class="w-full bg-gray-200 dark:bg-gray-800 rounded-full h-2.5">
                            <div class="h-2.5 rounded-full {{ $percentage >= 75 ? 'bg-red-600 dark:bg-red-800' : 'bg-green-600 dark:bg-green-800' }}" style="width: {{ $percentage }}%"></div>
                        </div>
                        <span class="text-xs">{{ $coupon->used_times }}/{{ $coupon->max_uses }}</span>
                    @else
                        -
                    @endif
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">تاريخ الإنشاء</span>
                    <span>{{ $coupon->created_at->format('Y-m-d H:i') }}</span>
                </div>
                <div class="mb-4">
                    <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">آخر تحديث</span>
                    <span>{{ $coupon->updated_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>
        </div>
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mt-8 mb-4">استهداف المنتجات والتصنيفات</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">المنتجات المستهدفة</span>
                <div class="flex flex-wrap gap-2">
                    @php $productIds = $coupon->product_ids ? (is_array($coupon->product_ids) ? $coupon->product_ids : json_decode($coupon->product_ids, true)) : []; @endphp
                    @if($productIds && count($productIds) > 0)
                        @foreach(\App\Models\Product::whereIn('id', $productIds)->get() as $product)
                            <span class="badge bg-blue-600 text-white">{{ $product->name }}</span>
                        @endforeach
                    @else
                        <span class="text-gray-400">يشمل جميع المنتجات</span>
                    @endif
                </div>
            </div>
            <div>
                <span class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">التصنيفات المستهدفة</span>
                <div class="flex flex-wrap gap-2">
                    @php $categoryIds = $coupon->category_ids ? (is_array($coupon->category_ids) ? $coupon->category_ids : json_decode($coupon->category_ids, true)) : []; @endphp
                    @if($categoryIds && count($categoryIds) > 0)
                        @foreach(\App\Models\Category::whereIn('id', $categoryIds)->get() as $category)
                            <span class="badge bg-purple-600 text-white">{{ $category->name }}</span>
                        @endforeach
                    @else
                        <span class="text-gray-400">يشمل جميع التصنيفات</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">إحصائيات الكوبون</h3>
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="mb-1"><strong>تم استخدامه:</strong> {{ $coupon->orders()->where('status', 'completed')->count() }} مرة</p>
                        <p class="mb-1"><strong>تاريخ الإنشاء:</strong> {{ $coupon->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                    <div>
                        <p class="mb-1"><strong>آخر تحديث:</strong> {{ $coupon->updated_at->format('Y-m-d H:i') }}</p>
                        <p class="mb-1">
                            <strong>حالة الكوبون:</strong>
                            @if($coupon->isValid())
                                <span class="badge bg-success">صالح</span>
                            @else
                                <span class="badge bg-danger">غير صالح</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- سجل استخدام الكوبون --}}
<div class="mt-10">
    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">سجل استخدام الكوبون</h3>
    @php $orders = $coupon->orders()->with('user')->latest()->get(); @endphp
    @if($orders->count())
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-900 rounded-lg shadow hidden md:table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b">#</th>
                        <th class="px-4 py-2 border-b">رقم الطلب</th>
                        <th class="px-4 py-2 border-b">العميل</th>
                        <th class="px-4 py-2 border-b">تاريخ الطلب</th>
                        <th class="px-4 py-2 border-b">المبلغ</th>
                        <th class="px-4 py-2 border-b">الحالة</th>
                        <th class="px-4 py-2 border-b">رقم العملية</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $i => $order)
                        <tr class="text-center">
                            <td class="px-4 py-2 border-b">{{ $i+1 }}</td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('dashboard.orders.show', $order->id) }}" class="text-blue-600 hover:underline">{{ $order->id }}</a>
                            </td>
                            <td class="px-4 py-2 border-b">{{ $order->user ? $order->user->name : '-' }}</td>
                            <td class="px-4 py-2 border-b">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                            <td class="px-4 py-2 border-b">{{ $order->total }} ر.س</td>
                            <td class="px-4 py-2 border-b">
                                @if($order->status == 'completed')
                                    <span class="badge bg-green-600 text-white">مكتمل</span>
                                @elseif($order->status == 'pending')
                                    <span class="badge bg-gray-500 text-white">قيد الانتظار</span>
                                @else
                                    <span class="badge bg-red-600 text-white">{{ __($order->status) }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">{{ $order->transaction_id ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- عرض كروت في الجوال -->
            <div class="md:hidden flex flex-col gap-4 mt-4">
                @foreach($orders as $i => $order)
                    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-4 flex flex-col gap-2">
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-400">#{{ $i+1 }}</span>
                            <a href="{{ route('dashboard.orders.show', $order->id) }}" class="text-blue-600 hover:underline font-bold">طلب رقم {{ $order->id }}</a>
                        </div>
                        <div><span class="font-medium">العميل:</span> {{ $order->user ? $order->user->name : '-' }}</div>
                        <div><span class="font-medium">تاريخ الطلب:</span> {{ $order->created_at->format('Y-m-d H:i') }}</div>
                        <div><span class="font-medium">المبلغ:</span> {{ $order->total }} ر.س</div>
                        <div>
                            <span class="font-medium">الحالة:</span>
                            @if($order->status == 'completed')
                                <span class="badge bg-green-600 text-white">مكتمل</span>
                            @elseif($order->status == 'pending')
                                <span class="badge bg-gray-500 text-white">قيد الانتظار</span>
                            @else
                                <span class="badge bg-red-600 text-white">{{ __($order->status) }}</span>
                            @endif
                        </div>
                        <div><span class="font-medium">رقم العملية:</span> {{ $order->transaction_id ?? '-' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="text-gray-400">لا يوجد طلبات استخدمت هذا الكوبون بعد.</div>
    @endif
</div>
@endsection 