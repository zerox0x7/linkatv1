@extends('themes.admin.layouts.app')

@section('title', 'تفاصيل الطلب #' . $order->id)

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">تفاصيل الطلب #{{ $order->id }}</h1>
        <div class="flex items-center space-x-4 space-x-reverse">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Status and Actions -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                    @if($order->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                    @elseif($order->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                    @elseif($order->status == 'processing') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                    @elseif($order->status == 'cancelled') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                    @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 @endif">
                    {{ trans('orders.status.' . $order->status) ?? $order->status }}
                </span>
                <span class="mx-2 text-gray-500 dark:text-gray-300">•</span>
                <span class="text-gray-500 dark:text-gray-300">{{ $order->created_at->format('Y-m-d H:i') }}</span>
            </div>
            <div class="flex space-x-2 space-x-reverse">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="inline-block">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center">
                        <select name="status" class="text-sm border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-100 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 ml-2">
                            <option value="pending" @if($order->status == 'pending') selected @endif>قيد الانتظار</option>
                            <option value="processing" @if($order->status == 'processing') selected @endif>قيد المعالجة</option>
                            <option value="completed" @if($order->status == 'completed') selected @endif>مكتمل</option>
                            <option value="cancelled" @if($order->status == 'cancelled') selected @endif>ملغي</option>
                            <option value="refunded" @if($order->status == 'refunded') selected @endif>مسترجع</option>
                        </select>
                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            تحديث الحالة
                        </button>
                    </div>
                </form>
                <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-700 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    تعديل
                </a>
                <button onclick="if(confirm('هل أنت متأكد من حذف هذا الطلب؟')) document.getElementById('delete-order').submit();" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    حذف
                </button>
                <form id="delete-order" action="{{ route('admin.orders.destroy', $order) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Order Info -->
        <div class="md:col-span-2 space-y-6">
            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">منتجات الطلب</h3>
                </div>
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($order->items as $item)
                    <div class="p-4 flex">
                        <div class="flex-shrink-0 w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded overflow-hidden">
                            @if($item->orderable->image)
                            <img src="{{ asset('storage/' . $item->orderable->image) }}" alt="{{ $item->orderable->name }}" class="w-full h-full object-center object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="mr-4 flex-1">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $item->orderable->name }}</h4>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">
                                        {{ $item->quantity }} × {{ number_format($item->price, 2) }} ر.س
                                    </p>
                                </div>
                                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ number_format($item->total, 2) }} ر.س</p>
                            </div>
                            @if($item->options)
                            <div class="mt-2">
                                <h5 class="text-sm font-medium text-gray-700 dark:text-gray-200">الخيارات:</h5>
                                <ul class="mt-1 text-sm">
                                    @if(isset($item->options['selected_price_option']) || isset($item->options['selected_option_name']) || isset($item->options['selected_price']))
                                    <li class="p-2 mb-2 bg-blue-50 dark:bg-blue-900 rounded border border-blue-100 dark:border-blue-800">
                                        <span class="font-bold text-blue-600 dark:text-blue-200">خدمة مطلوبة: </span>
                                        <span class="block">{{ $item->options['selected_option_name'] ?? '-' }}</span>
                                        @if(isset($item->options['selected_price']))
                                        <span class="text-green-600 dark:text-green-200 font-semibold">السعر: {{ $item->options['selected_price'] }} ر.س</span>
                                        @endif
                                    </li>
                                    @endif

                                    <!-- معلومات مخصصة مدخلة من العميل -->
                                    @if(isset($item->options['custom_fields_data']) && is_array($item->options['custom_fields_data']))
                                    <li class="p-2 mb-2 bg-yellow-50 dark:bg-yellow-900 rounded border border-yellow-100 dark:border-yellow-800">
                                        <span class="font-bold text-yellow-700 dark:text-yellow-200 block mb-1">بيانات مدخلة من العميل:</span>
                                        <ul class="pl-4 space-y-1">
                                            @php
                                                // الحصول على المنتج المرتبط لاستخراج مسميات الحقول
                                                $product = isset($item->orderable_id) ? \App\Models\Product::find($item->orderable_id) : null;
                                                
                                                // استخراج تعريفات الحقول المخصصة من المنتج
                                                $fieldDefinitions = [];
                                                if($product && $product->custom_fields) {
                                                    $customFields = is_string($product->custom_fields) ? 
                                                                    json_decode($product->custom_fields, true) : 
                                                                    $product->custom_fields;
                                                    foreach($customFields as $field) {
                                                        if(isset($field['name']) && isset($field['label'])) {
                                                            $fieldDefinitions[$field['name']] = $field['label'];
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach($item->options['custom_fields_data'] as $fieldName => $fieldValue)
                                                <li>
                                                    <span class="font-medium">{{ $fieldDefinitions[$fieldName] ?? $fieldName }}:</span>
                                                    @if(is_array($fieldValue) || is_object($fieldValue))
                                                        @php
                                                            $textValue = '';
                                                            try {
                                                                if(is_array($fieldValue)) {
                                                                    $values = [];
                                                                    foreach($fieldValue as $k => $v) {
                                                                        if(is_scalar($v)) {
                                                                            $values[] = $v;
                                                                        } elseif(is_object($v) && method_exists($v, '__toString')) {
                                                                            $values[] = (string)$v;
                                                                        }
                                                                    }
                                                                    $textValue = implode(', ', $values);
                                                                } elseif(is_object($fieldValue) && method_exists($fieldValue, '__toString')) {
                                                                    $textValue = (string)$fieldValue;
                                                                }
                                                            } catch(\Exception $e) {
                                                                $textValue = '[بيانات مركبة]';
                                                            }
                                                        @endphp
                                                        {{ $textValue }}
                                                    @else
                                                        {{ $fieldValue }}
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                    
                                    <!-- بيانات المنتج المخصص - طريقة بديلة للعرض -->
                                    @php
                                        $customDataFound = false;
                                        $fieldsToIgnore = ['selected_price_option', 'selected_option_name', 'selected_price', 'other_options', 'custom_fields_data', 'custom_data', 'quantity', 'id', 'product_id'];
                                    @endphp
                                    
                                    @foreach($item->options as $key => $value)
                                        @if(!in_array($key, $fieldsToIgnore) && !empty($value))
                                            @php $customDataFound = true; @endphp
                                        @endif
                                    @endforeach
                                    
                                    @if($customDataFound)
                                    <li class="p-2 mb-2 bg-yellow-50 dark:bg-yellow-900 rounded border border-yellow-100 dark:border-yellow-800">
                                        <span class="font-bold text-yellow-700 dark:text-yellow-200 block mb-1">تفاصيل مخصصة:</span>
                                        <ul class="pl-4 space-y-1">
                                            @foreach($item->options as $key => $value)
                                                @if(!in_array($key, $fieldsToIgnore) && !empty($value))
                                                    <li class="flex items-start">
                                                        <span class="font-medium ml-1 dark:text-gray-200">{{ $key }}:</span>
                                                        <span class="flex-1">
                                                            @if(is_array($value) || is_object($value))
                                                                @php
                                                                    $textValue = '';
                                                                    try {
                                                                        if(is_array($value)) {
                                                                            $values = [];
                                                                            foreach($value as $k => $v) {
                                                                                if(is_scalar($v)) {
                                                                                    $values[] = $v;
                                                                                } elseif(is_object($v) && method_exists($v, '__toString')) {
                                                                                    $values[] = (string)$v;
                                                                                }
                                                                            }
                                                                            $textValue = implode(', ', $values);
                                                                        } elseif(is_object($value) && method_exists($value, '__toString')) {
                                                                            $textValue = (string)$value;
                                                                        }
                                                                    } catch(\Exception $e) {
                                                                        $textValue = '[بيانات مركبة]';
                                                                    }
                                                                @endphp
                                                                {{ $textValue }}
                                                            @elseif(filter_var($value, FILTER_VALIDATE_URL))
                                                                <a href="{{ $value }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $value }}</a>
                                                            @elseif(is_string($value) && strpos($value, '@') !== false && filter_var($value, FILTER_VALIDATE_EMAIL))
                                                                <a href="mailto:{{ $value }}" class="text-blue-600 hover:underline">{{ $value }}</a>
                                                            @else
                                                                {{ $value }}
                                                            @endif
                                                        </span>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                    @endif
                                    
                                    @if(isset($item->options['other_options']) && is_array($item->options['other_options']))
                                    @foreach($item->options['other_options'] as $key => $value)
                                    <li>
                                        <span class="font-medium">{{ $key }}:</span>
                                        @if(is_array($value))
                                            @php
                                                $textValue = '';
                                                try {
                                                    $values = [];
                                                    foreach($value as $k => $v) {
                                                        if(is_scalar($v)) {
                                                            $values[] = $v;
                                                        } elseif(is_object($v) && method_exists($v, '__toString')) {
                                                            $values[] = (string)$v;
                                                        }
                                                    }
                                                    $textValue = implode(', ', $values);
                                                } catch(\Exception $e) {
                                                    $textValue = '[بيانات مركبة]';
                                                }
                                            @endphp
                                            {{ $textValue }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </li>
                                    @endforeach
                                    @else
                                    @foreach($item->options as $key => $value)
                                    @if(!in_array($key, $fieldsToIgnore))
                                    <li>
                                        <span class="font-medium">{{ $key }}:</span>
                                        @if(is_array($value))
                                            @php
                                                $textValue = '';
                                                try {
                                                    $values = [];
                                                    foreach($value as $k => $v) {
                                                        if(is_scalar($v)) {
                                                            $values[] = $v;
                                                        } elseif(is_object($v) && method_exists($v, '__toString')) {
                                                            $values[] = (string)$v;
                                                        }
                                                    }
                                                    $textValue = implode(', ', $values);
                                                } catch(\Exception $e) {
                                                    $textValue = '[بيانات مركبة]';
                                                }
                                            @endphp
                                            {{ $textValue }}
                                        @else
                                            {{ $value }}
                                        @endif
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="bg-gray-50 p-4">
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>المجموع الفرعي</p>
                        <p>{{ number_format($order->subtotal, 2) }} ر.س</p>
                    </div>
                    <div class="flex justify-between text-base font-medium text-gray-900">
                        <p>الشحن</p>
                        <p>{{ number_format($order->shipping, 2) }} ر.س</p>
                    </div>
                    <div class="flex justify-between text-lg font-bold text-gray-900 pt-3 mt-3 border-t">
                        <p>الإجمالي</p>
                        <p>{{ number_format($order->total, 2) }} ر.س</p>
                    </div>
                </div>
            </div>

            <!-- قسم المنتجات المخصصة (إذا وجدت) -->
            @if(isset($hasCustomProducts) && $hasCustomProducts)
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden mt-6">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b dark:border-gray-700 flex items-center">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">بيانات المنتجات المخصصة</h3>
                    <span class="mr-2 px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">معلومات هامة</span>
                </div>
                <div class="p-4">
                    @foreach($customProductsData as $itemId => $productData)
                        @php
                            // الحصول على المنتج المرتبط إذا كان متوفراً
                            $product = null;
                            if(isset($productData['product_id'])) {
                                $product = \App\Models\Product::find($productData['product_id']);
                            }
                            
                            // استخراج تعريفات الحقول المخصصة من المنتج
                            $fieldDefinitions = [];
                            if($product && $product->custom_fields) {
                                $customFields = is_string($product->custom_fields) ? 
                                                json_decode($product->custom_fields, true) : 
                                                $product->custom_fields;
                                foreach($customFields as $field) {
                                    if(isset($field['name']) && isset($field['label'])) {
                                        $fieldDefinitions[$field['name']] = $field['label'];
                                    }
                                }
                            }
                            
                            // استخراج تعريفات خيارات السعر من المنتج
                            $priceOptions = [];
                            if($product && $product->price_options) {
                                $priceOptionsData = is_string($product->price_options) ? 
                                                json_decode($product->price_options, true) : 
                                                $product->price_options;
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
                        <div class="mb-6 border-r-4 border-yellow-500 bg-yellow-50 rounded-lg overflow-hidden">
                            <div class="p-4">
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">{{ $productData['name'] }}</h4>
                                
                                @if(isset($productData['service_option']))
                                <div class="mb-4 bg-blue-50 rounded-md p-3 border border-blue-200">
                                    <h5 class="font-medium text-blue-700">الخدمة المطلوبة:</h5>
                                    @php
                                        $optionId = $productData['service_option']['option_id'] ?? '';
                                        $displayName = $priceOptions[$optionId] ?? $productData['service_option']['name'] ?? 'خيار السعر';
                                    @endphp
                                    <div class="flex flex-wrap">
                                        <div class="px-3 py-1 bg-white rounded border border-blue-100 text-blue-800 ml-2 mb-2">
                                            <span class="font-medium">الخدمة:</span> {{ $displayName }}
                                        </div>
                                        @if(isset($productData['service_option']['price']))
                                        <div class="px-3 py-1 bg-white rounded border border-green-100 text-green-800 ml-2 mb-2">
                                            <span class="font-medium">السعر:</span> {{ $productData['service_option']['price'] }} ر.س
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @elseif(isset($productData['service']))
                                <div class="mb-4 bg-blue-50 rounded-md p-3 border border-blue-200">
                                    <h5 class="font-medium text-blue-700">الخدمة المطلوبة:</h5>
                                    <div class="flex flex-wrap">
                                        <div class="px-3 py-1 bg-white rounded border border-blue-100 text-blue-800 ml-2 mb-2">
                                            <span class="font-medium">الخدمة:</span> {{ $productData['service']['name'] }}
                                        </div>
                                        @if(isset($productData['service']['price']))
                                        <div class="px-3 py-1 bg-white rounded border border-green-100 text-green-800 ml-2 mb-2">
                                            <span class="font-medium">السعر:</span> {{ $productData['service']['price'] }} ر.س
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
                                
                                @if(isset($productData['player_data']) && !empty($productData['player_data']))
                                <div class="bg-white rounded-md border border-gray-200 p-3">
                                    <h5 class="font-medium text-gray-700 mb-2">البيانات المخصصة:</h5>
                                    <div class="space-y-2">
                                        @foreach($productData['player_data'] as $key => $field)
                                            @php
                                                $fieldValue = is_array($field) && isset($field['value']) ? $field['value'] : $field;
                                                // استخدام العنوان من تعريف الحقل إذا كان متوفراً، وإلا استخدام العنوان من البيانات أو اسم الحقل
                                                $fieldLabel = $fieldDefinitions[$key] ?? (is_array($field) && isset($field['label']) ? $field['label'] : $key);
                                            @endphp
                                            <div class="border border-gray-100 rounded bg-gray-50 p-3">
                                                <div class="flex">
                                                    <span class="text-sm font-medium text-gray-700 ml-2">{{ $fieldLabel }}:</span>
                                                    <span class="text-sm text-gray-600">
                                                    @if(is_array($fieldValue) || is_object($fieldValue))
                                                        {{ json_encode($fieldValue, JSON_UNESCAPED_UNICODE) }}
                                                    @elseif(filter_var($fieldValue, FILTER_VALIDATE_URL))
                                                        <a href="{{ $fieldValue }}" target="_blank" class="text-blue-600 hover:underline break-all">{{ $fieldValue }}</a>
                                                    @elseif(strpos($fieldValue, '@') !== false && filter_var($fieldValue, FILTER_VALIDATE_EMAIL))
                                                        <a href="mailto:{{ $fieldValue }}" class="text-blue-600 hover:underline">{{ $fieldValue }}</a>
                                                    @else
                                                        {{ $fieldValue }}
                                                    @endif
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @elseif(!empty($productData['data']))
                                <div class="bg-white rounded-md border border-gray-200 p-3">
                                    <h5 class="font-medium text-gray-700 mb-2">البيانات المخصصة:</h5>
                                    <div class="space-y-2">
                                        @foreach($productData['data'] as $key => $value)
                                            <div class="border border-gray-100 rounded bg-gray-50 p-3">
                                                <div class="flex">
                                                    <span class="text-sm font-medium text-gray-700 ml-2">{{ $fieldDefinitions[$key] ?? $key }}:</span>
                                                    <span class="text-sm text-gray-600">
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
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden mt-6">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">الأكواد الرقمية للطلب</h3>
                </div>
                <div class="p-4">
                    @foreach($digitalCodes as $itemId => $codes)
                        @php
                            $item = $order->items->firstWhere('id', $itemId);
                        @endphp
                        <div class="mb-6 border-r-4 border-blue-500 bg-blue-50 dark:bg-blue-900 rounded-lg overflow-hidden">
                            <div class="p-4">
                                <div class="flex items-center mb-4">
                                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded overflow-hidden mr-4">
                                        <div class="w-full h-full flex items-center justify-center text-blue-500 dark:text-blue-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $item->orderable->name }}</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-300">{{ $item->quantity }} كود</p>
                                    </div>
                                </div>
                                
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">#</th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">الكود</th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">الرقم التسلسلي</th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">تاريخ الانتهاء</th>
                                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300">الحالة</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                            @foreach($codes as $index => $code)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $index + 1 }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">{{ $code->code }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">{{ $code->serial_number ?? '-' }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
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
                                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        @if($code->status == 'used') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                                        @elseif($code->status == 'available') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                                        @elseif($code->status == 'reserved') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                        @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 @endif">
                                                        {{ $code->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Payment Details -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">تفاصيل الدفع</h3>
                </div>
                <div class="p-4">
                    @if($order->payment)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">طريقة الدفع</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->payment->method }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">حالة الدفع</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->payment->status == 'completed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                    @elseif($order->payment->status == 'pending') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                    @elseif($order->payment->status == 'failed') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                    @else bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-200 @endif">
                                    {{ $order->payment->status }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">رقم المعاملة</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->payment->transaction_id ?: 'غير متوفر' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">تاريخ الدفع</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->payment->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    @else
                    <p class="text-sm text-gray-500">لا توجد معلومات دفع لهذا الطلب.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="space-y-6">
            <!-- Customer Info -->
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">معلومات العميل</h3>
                </div>
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="{{ $order->user->avatar ? asset('storage/' . $order->user->avatar) : asset('images/default-avatar.png') }}" alt="{{ $order->user->name }}">
                        </div>
                        <div class="mr-3">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-300">{{ $order->user->email }}</p>
                        </div>
                    </div>
                    <div class="mt-3 grid grid-cols-1 gap-2">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">رقم الهاتف</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->user->phone ?: 'غير متوفر' }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 dark:text-gray-300">تاريخ التسجيل</h4>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $order->user->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="mt-2">
                            <a href="{{ route('admin.users.show', $order->user) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-500 dark:hover:text-blue-300">عرض الملف الشخصي</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->notes)
            <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-hidden">
                <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 border-b dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-800 dark:text-gray-100">ملاحظات الطلب</h3>
                </div>
                <div class="p-4">
                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 