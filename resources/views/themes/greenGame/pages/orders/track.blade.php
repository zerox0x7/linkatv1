@extends('layouts.app')

@section('title', 'تتبع الطلب')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">تتبع الطلب</h1>
        <p class="text-gray-400">تتبع حالة طلبك عن طريق رقم الطلب</p>
    </div>

    <div class="glass-effect rounded-lg p-6 mb-8">
        <form action="{{ route('orders.track') }}" method="GET">
            <div class="mb-6">
                <label for="order_number" class="block text-white mb-2">رقم الطلب</label>
                <input type="text" name="order_number" id="order_number" value="{{ request('order_number') }}" 
                    class="w-full bg-[#1e1e1e] border border-[#3a3a3a] rounded py-2 px-4 text-white placeholder-gray-400 focus:outline-none search-input" 
                    placeholder="أدخل رقم الطلب هنا...">
                <p class="text-gray-400 text-sm mt-1">أدخل رقم الطلب الخاص بك للتحقق من حالته</p>
            </div>
            <button type="submit" class="bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium hover:opacity-90 transition-all neon-glow">
                <i class="ri-search-line ml-1"></i>تتبع الطلب
            </button>
        </form>
    </div>

    @isset($error)
        <div class="bg-red-600 bg-opacity-20 border border-red-600 text-red-100 px-4 py-3 rounded mb-8" role="alert">
            <span class="block sm:inline">{{ $error }}</span>
        </div>
    @endisset

    @isset($order)
        <div class="glass-effect rounded-lg p-6">
            <h2 class="text-xl font-bold text-white mb-4">معلومات الطلب <span class="text-primary">#{{ $order->id }}</span></h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-white font-bold mb-3">تفاصيل الطلب</h3>
                    <div class="bg-[#1e1e1e] rounded-lg p-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-400">رقم الطلب:</span>
                                <span class="text-white">#{{ $order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">تاريخ الطلب:</span>
                                <span class="text-white">{{ $order->created_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">المجموع:</span>
                                <span class="text-white">{{ number_format($order->total, 2) }} ر.س</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">عدد المنتجات:</span>
                                <span class="text-white">{{ $order->items->sum('quantity') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-white font-bold mb-3">حالة الطلب</h3>
                    <div class="bg-[#1e1e1e] rounded-lg p-4">
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-400">حالة الطلب:</span>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-600 bg-opacity-20 border-yellow-600 text-yellow-100',
                                        'processing' => 'bg-blue-600 bg-opacity-20 border-blue-600 text-blue-100',
                                        'completed' => 'bg-green-600 bg-opacity-20 border-green-600 text-green-100',
                                        'cancelled' => 'bg-red-600 bg-opacity-20 border-red-600 text-red-100',
                                        'payment_failed' => 'bg-red-600 bg-opacity-20 border-red-600 text-red-100',
                                        'pending_confirmation' => 'bg-purple-600 bg-opacity-20 border-purple-600 text-purple-100',
                                    ];
                                    $statusText = [
                                        'pending' => 'قيد الانتظار',
                                        'processing' => 'قيد المعالجة',
                                        'completed' => 'مكتمل',
                                        'cancelled' => 'ملغي',
                                        'payment_failed' => 'فشل الدفع',
                                        'pending_confirmation' => 'بانتظار تأكيد الدفع',
                                    ];
                                @endphp
                                <span class="inline-block py-1 px-3 rounded border {{ $statusClasses[$order->status] ?? 'bg-gray-600 bg-opacity-20 border-gray-600 text-gray-100' }}">
                                    {{ $statusText[$order->status] ?? $order->status }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">حالة الدفع:</span>
                                <span class="inline-block py-1 px-3 rounded border {{ $order->payment_status == 'paid' ? 'bg-green-600 bg-opacity-20 border-green-600 text-green-100' : 'bg-yellow-600 bg-opacity-20 border-yellow-600 text-yellow-100' }}">
                                    {{ $order->payment_status == 'paid' ? 'مدفوع' : 'غير مدفوع' }}
                                </span>
                            </div>
                            @if($order->paid_at)
                            <div class="flex justify-between">
                                <span class="text-gray-400">تاريخ الدفع:</span>
                                <span class="text-white">{{ $order->paid_at->format('Y-m-d H:i') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-400">طريقة الدفع:</span>
                                <span class="text-white">
                                    @php
                                        $paymentMethods = [
                                            'credit_card' => 'بطاقة ائتمان',
                                            'clickpay' => 'كليك باي',
                                            'bank_transfer' => 'تحويل بنكي',
                                            'cash_on_delivery' => 'الدفع عند الاستلام',
                                        ];
                                    @endphp
                                    {{ $paymentMethods[$order->payment_method] ?? $order->payment_method ?? 'غير محدد' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- خط زمني للطلب -->
            <div class="relative mt-8 mb-8">
                <h3 class="text-white font-bold mb-6">مراحل الطلب</h3>
                <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-gray-700 mt-8"></div>
                <div class="flex justify-between relative z-10 mt-8">
                    <div class="text-center">
                        <div class="w-8 h-8 rounded-full {{ $order->created_at ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                            <i class="ri-checkbox-circle-fill"></i>
                        </div>
                        <div class="text-xs text-gray-400">الطلب</div>
                        <div class="text-xs text-primary mt-1">{{ $order->created_at->format('Y-m-d') }}</div>
                    </div>
                    <div class="text-center">
                        <div class="w-8 h-8 rounded-full {{ $order->payment_status == 'paid' ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                            <i class="ri-checkbox-circle-fill"></i>
                        </div>
                        <div class="text-xs text-gray-400">الدفع</div>
                        <div class="text-xs text-primary mt-1">{{ $order->paid_at ? $order->paid_at->format('Y-m-d') : '-' }}</div>
                    </div>
                    <div class="text-center">
                        <div class="w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'completed']) ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                            <i class="ri-checkbox-circle-fill"></i>
                        </div>
                        <div class="text-xs text-gray-400">المعالجة</div>
                        <div class="text-xs text-primary mt-1">
                            @if(in_array($order->status, ['processing', 'completed']))
                                {{ $order->updated_at->format('Y-m-d') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <div class="w-8 h-8 rounded-full {{ $order->status == 'completed' ? 'bg-primary' : 'bg-gray-700' }} text-white inline-flex items-center justify-center mb-2">
                            <i class="ri-checkbox-circle-fill"></i>
                        </div>
                        <div class="text-xs text-gray-400">إتمام</div>
                        <div class="text-xs text-primary mt-1">
                            @if($order->status == 'completed')
                                {{ $order->updated_at->format('Y-m-d') }}
                            @else
                                -
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            @if(auth()->check() && $order->user_id == auth()->id())
                <div class="text-center mt-6">
                    <a href="{{ route('orders.show', $order->id) }}" class="bg-gradient-to-r from-primary to-secondary text-white px-5 py-2 rounded-button font-medium hover:opacity-90 transition-all neon-glow inline-block">
                        <i class="ri-eye-line ml-1"></i>عرض تفاصيل الطلب كاملة
                    </a>
                </div>
            @endif
        </div>
    @endisset
</div>
@endsection 