@extends('themes.admin.layouts.app')

@section('title', 'تعديل الطلب #' . $order->id)

@section('content')
<div class="space-y-8">
    <!-- هيدر علوي عصري -->
    <div class="sticky top-0 z-10 bg-gradient-to-l from-blue-700 to-blue-900 dark:from-gray-900 dark:to-gray-800 shadow-lg rounded-b-2xl px-8 py-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-800 hover:bg-blue-900 text-white shadow transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div>
                <div class="text-2xl font-extrabold text-white">طلب رقم #{{ $order->id }}</div>
                <div class="text-xs text-blue-200 mt-1">({{ $order->order_number ?? $order->id }})</div>
            </div>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            @php
                $status = $order->status;
                $statusInfo = [
                    'pending'   => ['label' => 'قيد الانتظار', 'color' => 'bg-yellow-200 text-yellow-900', 'icon' => 'clock'],
                    'processing'=> ['label' => 'قيد المعالجة', 'color' => 'bg-blue-200 text-blue-900', 'icon' => 'refresh'],
                    'completed' => ['label' => 'مكتمل', 'color' => 'bg-green-200 text-green-900', 'icon' => 'check'],
                    'cancelled' => ['label' => 'ملغي', 'color' => 'bg-red-200 text-red-900', 'icon' => 'x'],
                    'refunded'  => ['label' => 'مسترجع', 'color' => 'bg-gray-200 text-gray-900', 'icon' => 'undo'],
                ];
                $info = $statusInfo[$status] ?? ['label' => $status, 'color' => 'bg-gray-200 text-gray-900', 'icon' => 'question'];
            @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border border-white/20 shadow {{ $info['color'] }}">
                @if($info['icon'] == 'clock')
                    <svg class="ml-2 h-4 w-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6v4l2 2m6-2a8 8 0 11-16 0 8 8 0 0116 0z"/></svg>
                @elseif($info['icon'] == 'refresh')
                    <svg class="ml-2 h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582M19.418 15A8 8 0 116 5.582"/></svg>
                @elseif($info['icon'] == 'check')
                    <svg class="ml-2 h-4 w-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                @elseif($info['icon'] == 'x')
                    <svg class="ml-2 h-4 w-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                @elseif($info['icon'] == 'undo')
                    <svg class="ml-2 h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 20 20"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7"/></svg>
                @else
                    <svg class="ml-2 h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2" fill="none"/><text x="10" y="15" text-anchor="middle" font-size="10" fill="currentColor">?</text></svg>
                @endif
                {{ $info['label'] }}
            </span>
            @if($order->payment_status == 'paid')
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border border-white/20 shadow bg-green-200 text-green-900">
                    <svg class="ml-2 h-4 w-4 text-green-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    مدفوع
                </span>
            @else
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold border border-white/20 shadow bg-red-200 text-red-900">
                    <svg class="ml-2 h-4 w-4 text-red-600" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-2-7a2 2 0 104 0 2 2 0 00-4 0zm6-2a1 1 0 10-2 0 1 1 0 002 0z" clip-rule="evenodd"></path></svg>
                    غير مدفوع
                </span>
            @endif
            <span class="text-xs text-blue-100">{{ $order->created_at ? $order->created_at->format('Y-m-d H:i') : '-' }}</span>
        </div>
    </div>

    <!-- شبكة المعلومات -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- معلومات العميل -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 flex flex-col gap-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center overflow-hidden">
                    <img class="h-12 w-12 rounded-full object-cover" src="{{ $order->user->avatar ? asset('storage/' . $order->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $order->user->name }}">
                </div>
                <div>
                    <div class="text-lg font-bold text-gray-700 dark:text-gray-200">معلومات العميل</div>
                    <div class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $order->user->name ?? '-' }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-300">{{ $order->user->email ?? '-' }}</div>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-2 mt-2">
                <div><span class="text-xs text-gray-500">رقم الجوال</span><div class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $order->user->phone ?? '-' }}</div></div>
                <div><span class="text-xs text-gray-500">رقم الطلب</span><div class="text-base font-medium text-gray-900 dark:text-gray-100">{{ $order->order_number ?? $order->id }}</div></div>
                <div class="mt-2">
                    <a href="{{ route('admin.users.show', $order->user) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300 font-bold">عرض الملف الشخصي</a>
                </div>
            </div>
        </div>
        <!-- تفاصيل الطلب -->
        <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 flex flex-col gap-4">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 014-4h3m4 0V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2h7" /></svg>
                </div>
                <div class="text-lg font-bold text-gray-700 dark:text-gray-200">تفاصيل الطلب</div>
                    </div>
            <div class="grid grid-cols-1 gap-2">
                <div><span class="text-xs text-gray-500">حالة الطلب</span><div class="mt-1"><span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $info['color'] }}">{{ $info['label'] }}</span></div></div>
                <div><span class="text-xs text-gray-500">حالة الدفع</span><div class="mt-1">@if($order->payment_status == 'paid')<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border border-green-200">مدفوع</span>@else<span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-200">غير مدفوع</span>@endif</div></div>
                <div><span class="text-xs text-gray-500">طريقة الدفع</span><div class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $order->payment_method ?? '-' }}</div></div>
                <div><span class="text-xs text-gray-500">السعر</span><div class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ isset($order->items[0]) ? number_format($order->items[0]->price, 2) . ' ر.س' : '-' }}</div></div>
                <div><span class="text-xs text-gray-500">الكمية</span><div class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ $order->items->sum('quantity') }}</div></div>
                <div><span class="text-xs text-gray-500">المجموع</span><div class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ number_format($order->items->sum('total'), 2) }} ر.س</div></div>
                <div><span class="text-xs text-gray-500">السعر الإجمالي</span><div class="text-base font-medium text-gray-900 dark:text-gray-100 mt-1">{{ number_format($order->total, 2) }} ر.س</div></div>
                    </div>
            <!-- اسم المنتج كبطاقة داكنة -->
            <div>
                <span class="text-xs text-gray-500">اسم المنتج</span>
                <div class="mt-2 flex flex-wrap gap-2">
                    @php $names = collect($order->items)->pluck('orderable.name')->unique()->filter()->toArray(); @endphp
                    @foreach($names as $name)
                        <div class="flex items-center gap-2 bg-gray-900 dark:bg-gray-800 rounded-xl px-4 py-3 shadow">
                            <span class="flex items-center justify-center w-8 h-8 bg-gray-800 dark:bg-gray-700 rounded-full">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <rect width="20" height="20" x="2" y="2" rx="4" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <path stroke="currentColor" stroke-width="2" d="M8 14l2-2 2 2 4-4 4 4"/>
                                    <circle cx="8.5" cy="8.5" r="1.5" fill="currentColor"/>
                                </svg>
                            </span>
                            <span class="text-base font-bold text-gray-100">{{ $name }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المخصصة (إذا وجدت) -->
    @if(isset($hasCustomProducts) && $hasCustomProducts && isset($customProductsData) && count($customProductsData) > 0)
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg overflow-hidden mt-8 border border-yellow-200 dark:border-yellow-700">
        <div class="bg-yellow-50 dark:bg-yellow-900 px-4 py-3 border-b dark:border-yellow-800 flex items-center">
            <h3 class="text-lg font-bold text-yellow-800 dark:text-yellow-200">بيانات المنتجات المخصصة</h3>
            <span class="mr-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-800 dark:text-yellow-100">معلومات هامة</span>
        </div>
        <div class="p-4 space-y-8">
            @foreach($customProductsData as $itemId => $productData)
                @php
                    $product = null;
                    if(isset($productData['product_id'])) {
                        $product = \App\Models\Product::find($productData['product_id']);
                    }
                    $fieldDefinitions = [];
                    if($product && $product->custom_fields) {
                        $customFields = is_string($product->custom_fields) ? json_decode($product->custom_fields, true) : $product->custom_fields;
                        foreach($customFields as $field) {
                            if(isset($field['name']) && isset($field['label'])) {
                                $fieldDefinitions[$field['name']] = $field['label'];
                            }
                        }
                    }
                    $priceOptions = [];
                    if($product && $product->price_options) {
                        $priceOptionsData = is_string($product->price_options) ? json_decode($product->price_options, true) : $product->price_options;
                        foreach($priceOptionsData as $option) {
                            $optionName = '';
                            $optionId = $option['id'] ?? '';
                            if(isset($option['quantity'])) {
                                $optionName = $option['quantity'];
                            } elseif(isset($option['name'])) {
                                $optionName = $option['name'];
                            } elseif(isset($option['description'])) {
                                $optionName = $option['description'];
                            }
                            if($optionId && $optionName) {
                                $priceOptions[$optionId] = $optionName;
                            }
                        }
                    }
                @endphp
                <div class="mb-6 border-r-4 border-yellow-500 bg-gray-50 dark:bg-gray-800 rounded-lg overflow-hidden shadow border dark:border-yellow-700">
        <div class="p-4">
                        <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-3">{{ $productData['name'] }}</h4>
                        @if(isset($productData['service_option']))
                        <div class="mb-4 bg-blue-50 dark:bg-blue-900 rounded-md p-3 border border-blue-200 dark:border-blue-700 flex flex-wrap gap-2">
                            <div class="flex items-center gap-2 px-3 py-1 bg-white dark:bg-gray-900 rounded border border-blue-100 dark:border-blue-700 text-blue-800 dark:text-blue-200">
                                <span class="font-medium">الخدمة:</span> {{ $displayName ?? $productData['service_option']['name'] ?? 'خيار السعر' }}
                            </div>
                            @if(isset($productData['service_option']['price']))
                            <div class="flex items-center gap-2 px-3 py-1 bg-white dark:bg-gray-900 rounded border border-green-100 dark:border-green-700 text-green-800 dark:text-green-200">
                                <span class="font-medium">السعر:</span> {{ $productData['service_option']['price'] }} ر.س
                                                </div>
                                            @endif
                                        </div>
                        @elseif(isset($productData['service']))
                        <div class="mb-4 bg-blue-50 dark:bg-blue-900 rounded-md p-3 border border-blue-200 dark:border-blue-700 flex flex-wrap gap-2">
                            <div class="flex items-center gap-2 px-3 py-1 bg-white dark:bg-gray-900 rounded border border-blue-100 dark:border-blue-700 text-blue-800 dark:text-blue-200">
                                <span class="font-medium">الخدمة:</span> {{ $productData['service']['name'] }}
                            </div>
                            @if(isset($productData['service']['price']))
                            <div class="flex items-center gap-2 px-3 py-1 bg-white dark:bg-gray-900 rounded border border-green-100 dark:border-green-700 text-green-800 dark:text-green-200">
                                <span class="font-medium">السعر:</span> {{ $productData['service']['price'] }} ر.س
                            </div>
                                                        @endif
                                                    </div>
                                                    @endif
                        @if(isset($productData['player_data']) && !empty($productData['player_data']))
                        <div class="bg-white dark:bg-gray-900 rounded-md border border-gray-200 dark:border-gray-700 p-3 mt-2">
                            <h5 class="font-medium text-gray-700 dark:text-gray-200 mb-2">البيانات المخصصة:</h5>
                            <div class="space-y-2">
                                @foreach($productData['player_data'] as $key => $field)
                                    @php
                                        $fieldValue = is_array($field) && isset($field['value']) ? $field['value'] : $field;
                                        $fieldLabel = $fieldDefinitions[$key] ?? (is_array($field) && isset($field['label']) ? $field['label'] : $key);
                                    @endphp
                                    @if($key === 'price_option' && (is_array($fieldValue) || is_object($fieldValue)))
                                        <div class="flex items-center gap-2 border border-gray-100 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-800 p-3">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $fieldValue['name'] ?? ($fieldValue['label'] ?? 'الخدمة/الباقة') }}</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-300">:
                                                {{ isset($fieldValue['price']) ? number_format($fieldValue['price'], 2) . ' ر.س' : '' }}
                                            </span>
                                        </div>
                                    @elseif($key === 'service_option' && (is_array($fieldValue) || is_object($fieldValue)))
                                        <div class="flex items-center gap-2 border border-gray-100 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-800 p-3">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $fieldValue['name'] ?? ($fieldValue['label'] ?? 'الخدمة/الباقة') }}</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-300">:
                                                {{ isset($fieldValue['price']) ? number_format($fieldValue['price'], 2) . ' ر.س' : '' }}
                                            </span>
                                        </div>
                                                                @else
                                        <div class="flex items-center gap-2 border border-gray-100 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-800 p-3">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $fieldLabel }}:</span>
                                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $fieldValue }}</span>
                                                    </div>
                                                        @endif
                                                    @endforeach
                            </div>
                        </div>
                        @elseif(!empty($productData['data']))
                        <div class="bg-white dark:bg-gray-900 rounded-md border border-gray-200 dark:border-gray-700 p-3 mt-2">
                            <h5 class="font-medium text-gray-700 dark:text-gray-200 mb-2">البيانات المخصصة:</h5>
                            <div class="space-y-2">
                                @foreach($productData['data'] as $key => $value)
                                    <div class="flex items-center gap-2 border border-gray-100 dark:border-gray-700 rounded bg-gray-50 dark:bg-gray-800 p-3">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ $fieldDefinitions[$key] ?? $key }}:</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-300">
                                                                            @if(is_array($value) || is_object($value))
                                                                                {{ json_encode($value, JSON_UNESCAPED_UNICODE) }}
                                                                            @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                                                                <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $value }}</a>
                                                                            @elseif(strpos($value, '@') !== false && filter_var($value, FILTER_VALIDATE_EMAIL))
                                                                                <a href="mailto:{{ $value }}" class="text-blue-600 hover:underline">{{ $value }}</a>
                                                                            @else
                                                                                {{ $value }}
                                                                            @endif
                                                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- الأكواد الرقمية (إذا وجدت) -->
    @if(isset($digitalCodes) && count($digitalCodes) > 0)
    <div class="mt-8">
        <div class="text-xl font-extrabold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 shadow">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                </svg>
            </span>
            الأكواد الرقمية للطلب
        </div>
        <div class="flex flex-col gap-6">
            @foreach($digitalCodes as $itemId => $codes)
                @php
                    $item = $order->items->firstWhere('id', $itemId);
                @endphp
                <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-800 overflow-hidden">
                    <div class="flex items-center gap-4 px-6 py-4 border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800">
                        <div class="flex-shrink-0 w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center">
                            <svg class="w-7 h-7 text-gray-500 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                            </div>
                            <div>
                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $item->orderable->name }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">عدد الأكواد: {{ $item->quantity }}</div>
                        </div>
                    </div>
                    <div class="overflow-x-auto p-4">
                        <table class="min-w-full divide-y divide-gray-100 dark:divide-gray-800 text-sm">
                                <thead class="bg-gray-50 dark:bg-gray-800">
                                    <tr>
                                    <th class="px-4 py-2 text-right font-bold text-gray-700 dark:text-gray-200">#</th>
                                    <th class="px-4 py-2 text-right font-bold text-gray-700 dark:text-gray-200">الكود</th>
                                    <th class="px-4 py-2 text-right font-bold text-gray-700 dark:text-gray-200">الرقم التسلسلي</th>
                                    <th class="px-4 py-2 text-right font-bold text-gray-700 dark:text-gray-200">تاريخ الانتهاء</th>
                                    <th class="px-4 py-2 text-right font-bold text-gray-700 dark:text-gray-200">الحالة</th>
                                    </tr>
                                </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-100 dark:divide-gray-800">
                                    @foreach($codes as $index => $code)
                                    <tr>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap font-mono text-gray-900 dark:text-gray-100">{{ $code->code }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">{{ $code->serial_number ?? '-' }}</td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                            @if(isset($code->expiry_date))
                                                @if(is_object($code->expiry_date) && method_exists($code->expiry_date, 'format'))
                                                    {{ $code->expiry_date->format('Y-m-d') }}
                                                @else
                                                    {{ $code->expiry_date }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    <td class="px-4 py-2 whitespace-nowrap">
                                        @if($code->status == 'used') <span class="bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 px-2 py-1 rounded-full">مستخدم</span>
                                        @elseif($code->status == 'available') <span class="bg-blue-50 dark:bg-blue-900 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full">متاح</span>
                                        @elseif($code->status == 'reserved') <span class="bg-yellow-50 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded-full">محجوز</span>
                                        @else <span class="bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 px-2 py-1 rounded-full">{{ $code->status }}</span>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

<!-- قسم تعديل الطلب وحفظ الإجراءات -->
<form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-8 bg-white dark:bg-gray-900 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-800 flex flex-col gap-6">
    @csrf
    @method('PUT')
    <!-- ملاحظة إدارية -->
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
            </div>
            <div class="text-lg font-bold text-gray-700 dark:text-gray-200">ملاحظة إدارية</div>
        </div>
        <textarea name="notes" rows="3" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500" placeholder="أضف ملاحظة إدارية حول الطلب...">{{ old('notes', $order->notes ?? '') }}</textarea>
    </div>
    <!-- رسالة تنبيه للعميل -->
    <div>
        <div class="flex items-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
            </div>
            <div class="text-lg font-bold text-gray-700 dark:text-gray-200">رسالة تنبيه للعميل</div>
        </div>
        <textarea id="alert_message" rows="3" class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-3 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-red-500" placeholder="اكتب رسالة تنبيه للعميل هنا..."></textarea>
        <button type="button" id="send-whatsapp-btn" class="mt-2 px-6 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-bold shadow transition">
            إرسال عبر واتساب
        </button>
        <div id="whatsapp-alert-result" class="mt-2"></div>
    </div>
    <script>
    document.getElementById('send-whatsapp-btn').addEventListener('click', function() {
        var message = document.getElementById('alert_message').value;
        var resultDiv = document.getElementById('whatsapp-alert-result');
        resultDiv.innerHTML = '';
        if (!message.trim()) {
            resultDiv.innerHTML = '<div class="text-red-600 font-bold">يرجى كتابة رسالة قبل الإرسال.</div>';
            return;
        }
        this.disabled = true;
        this.innerText = '...جاري الإرسال';
        fetch("{{ route('admin.orders.whatsapp_alert', $order) }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ alert_message: message })
        })
        .then(async response => {
            let data;
            try {
                data = await response.json();
            } catch (e) {
                // الاستجابة ليست JSON (غالباً خطأ من السيرفر أو CSRF أو غيره)
                throw new Error('استجابة غير متوقعة من السيرفر: ' + response.status);
            }
            return data;
        })
        .then(data => {
            this.disabled = false;
            this.innerText = 'إرسال عبر واتساب';
            if (data.success) {
                resultDiv.innerHTML = '<div class="text-green-600 font-bold">' + (data.message || 'تم إرسال الرسالة بنجاح عبر واتساب.') + '</div>';
            } else {
                resultDiv.innerHTML = '<div class="text-red-600 font-bold">فشل الإرسال: ' + (data.message || 'حدث خطأ غير متوقع') + '</div>';
            }
        })
        .catch(error => {
            this.disabled = false;
            this.innerText = 'إرسال عبر واتساب';
            resultDiv.innerHTML = '<div class="text-red-600 font-bold">حدث خطأ في الاتصال بالخادم: ' + (error.message || '') + '</div>';
        });
    });
    </script>
    <!-- تغيير حالة الطلب -->
    <div class="flex flex-col md:flex-row items-center gap-4 w-full">
        <label for="status" class="text-sm font-bold text-gray-700 dark:text-gray-200">تغيير حالة الطلب:</label>
        <select id="status" name="status" class="rounded-lg border border-gray-300 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 p-2 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500">
            <option value="pending" @if($order->status == 'pending') selected @endif>قيد الانتظار</option>
            <option value="processing" @if($order->status == 'processing') selected @endif>قيد المعالجة</option>
            <option value="completed" @if($order->status == 'completed') selected @endif>مكتمل</option>
            <option value="cancelled" @if($order->status == 'cancelled') selected @endif>ملغي</option>
            <option value="refunded" @if($order->status == 'refunded') selected @endif>مسترجع</option>
        </select>
        <button type="submit" class="px-8 py-2 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-bold shadow transition md:ml-auto">حفظ الإجراءات</button>
    </div>
</form>
@endsection 

@push('scripts')
<!-- السكريبتات تبقى كما هي -->
@endpush 